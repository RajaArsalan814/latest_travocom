<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activityschedule;
use App\customers;
use App\employees;
use App\Activity;
use App\Activityscheduledetails;
use Illuminate\Support\Facades\DB;
use App\Activityschedulecomments;
use DateTime;

class ActivityscheduleController extends Controller {

    public function schedule_list() {
        //$schedules = Activityschedule::select('activity_schedule.*')->where('activity_id', $activity_id)->get()->toArray();
        $employees = employees::select('employees.id_employee', 'employees.employee_name')->where('status', 'Active');
        if (auth()->user()->rule_id != 1) {
            $employees = $employees->join('user_employee', 'user_employee.employee_id', '=', 'employees.id_employee');
            $employees = $employees->where('user_employee.user_id', '=', auth()->user()->id);
        }
        $employees = $employees->get()->toArray();
        $activities = Activity::where('active', '=', 'Y')->get()->toArray();
        return view('/activity.schedule.schedule_list', compact('schedules', 'activity_id', 'employees', 'activities'));
    }

    public function schedule_create($activity_id) {
        //return auth()->user();exit;
        $employees = employees::select('employees.id_employee', 'employees.employee_name')->where('status', 'Active');
        if (auth()->user()->rule_id != 1) {
            $employees = $employees->join('user_employee', 'user_employee.employee_id', '=', 'employees.id_employee');
            $employees = $employees->where('user_employee.user_id', '=', auth()->user()->id);
        }
        $employees = $employees->get()->toArray();
        //$customers = getCustomersBySaleman(36);
        return view('/activity.schedule.create', compact('employees'));
    }

    public function getCustomersBySaleman(Request $request) {
        $customers = getCustomersBySaleman($request->saleman_id);
        return response()->json([
                    'customers' => $customers
        ]);
    }

    public function schedule_store(Request $request) {

        $activity_schedule = new Activityschedule();
        $activity_schedule->activity_id = $request->activity_id;
        $activity_schedule->customer_id = $request->customer_id;
        $activity_schedule->saleman_id = $request->saleman_id;
        $activity_schedule->status = 'Y';
        $activity_schedule->remarks = NULL;
        $activity_schedule->created_by = auth()->user()->id;
        if ($activity_schedule->save()) {
            if ($request->ScheduleData && !empty($request->ScheduleData)) {
                $ScheduleData = $request->ScheduleData;
                for ($i = 0; $i < count($ScheduleData); $i++) {
                    $activity_schedule_details = new Activityscheduledetails();
                    $activity_schedule_details->schedule_date = date('Y-m-d', strtotime($ScheduleData[$i]['schedule_date']));
                    $activity_schedule_details->start_time = $ScheduleData[$i]['start_time'];
                    $activity_schedule_details->end_time = $ScheduleData[$i]['end_time'];
                    $activity_schedule_details->remarks = $ScheduleData[$i]['remarks'];
                    $activity_schedule_details->status = $ScheduleData[$i]['status'];
                    $activity_schedule_details->created_by = auth()->user()->id;
                    $activity_schedule_details->activity_schedule_id = $activity_schedule->id_activity_schedule;
                    $activity_schedule_details->save();
                }
            }
        }
        return response()->json([
                    'message' => 'success'
        ]);
    }

    public function schedule_data(Request $request) {
        $saleman_id = $request->saleman_id;
        $activity_id = $request->activity_id;
        $status = $request->status;
        $start = date('Y-m-d', strtotime($request->start));
        $end = date('Y-m-d', strtotime($request->end));
        $data = [];
        $column = [
            DB::raw('concat(customers.customer_name, " (", activity_schedule_details.status, ")", "\r\n\r\n",activity_schedule_details.remarks) as title'), //\r\n
            DB::raw('activity_schedule_details.id_activity_schedule_details as id'),
            DB::raw('date_format(concat(activity_schedule_details.schedule_date," ", activity_schedule_details.start_time),"%Y-%m-%d %H:%i:%s") as start'),
            DB::raw('date_format(concat(activity_schedule_details.schedule_date," ", activity_schedule_details.end_time),"%Y-%m-%d %H:%i:%s") as end'),
            DB::raw('activity_schedule_details.remarks as description'),
            DB::raw('activity_schedule_details.status as status')
        ];
        $schedule_data = Activityscheduledetails::select($column)
                        ->join('activity_schedule', 'activity_schedule.id_activity_schedule', '=', 'activity_schedule_details.activity_schedule_id')
                        ->join('customers', 'customers.id_customers', '=', 'activity_schedule.customer_id')
                        ->where('activity_schedule.saleman_id', '=', $saleman_id)
                        ->where('activity_schedule.activity_id', '=', $activity_id)
                        ->where('activity_schedule_details.schedule_date', '>=', $start)
                        ->where('activity_schedule_details.schedule_date', '<=', $end);
        if($status != 'all'){
            $schedule_data = $schedule_data->where('activity_schedule_details.status', '=', $status);
        }
            $schedule_data = $schedule_data->get()->toArray();
        if ($schedule_data) {
            return response()->json([
                'message' => 'success',
                'event' => $schedule_data
            ]);
        } else {
            return response()->json([
                'message' => 'false',
                'event' => []
            ]);
        }
    }

    public function schedule_update_time(Request $request) {
        $activity_schedule_detail_id = $request->activity_schedule_detail_id;
        $start_time = explode('T', $request->start_time);
        $end_time = explode('T', $request->end_time);

        $updata = Activityscheduledetails::find($activity_schedule_detail_id);
        $updata->start_time = $start_time[1];
        $updata->end_time = $end_time[1];
        $updata->save();
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function schedule_update_date(Request $request) {
        $activity_schedule_detail_id = $request->activity_schedule_detail_id;
        $start_time = explode('T', $request->start_time);
        $end_time = explode('T', $request->end_time);

        $updata = Activityscheduledetails::find($activity_schedule_detail_id);
        $updata->schedule_date = date('Y-m-d', strtotime($start_time[0]));
        $updata->start_time = $start_time[1];
        $updata->end_time = $end_time[1];
        $updata->save();
        return response()->json([
            'message' => 'success'
        ]);
    }
    
    public function schedule_edit_status(Request $request) {
        $activity_schedule_detail_id = $request->activity_schedule_detail_id;

        $event = Activityscheduledetails::select('activity_schedule_details.*', 'activities.activity', 'users.name')
                ->join('activity_schedule', 'activity_schedule.id_activity_schedule', 'activity_schedule_details.activity_schedule_id')
                ->join('activities', 'activities.id_activities', '=', 'activity_schedule.activity_id')
                ->join('users', 'activities.created_by', '=', 'users.id')
                ->where('id_activity_schedule_details', $activity_schedule_detail_id)
                ->first();

        return response()->json([
                    'message' => 'success',
                    'event' => $event
        ]);
    }

    public function schedule_update_status(Request $request) {
        $activity_schedule_detail_id = $request->activity_schedule_detail_id;
        $start_time = date('H:i:s', strtotime($request->start_time));
        $end_time = date('H:i:s', strtotime($request->end_time));
        $schedule_date = date('Y-m-d', strtotime($request->schedule_date));

        $updata = Activityscheduledetails::find($activity_schedule_detail_id);
        $updata->schedule_date = $schedule_date;
        $updata->start_time = $start_time;
        $updata->end_time = $end_time;
        $updata->remarks = $request->remarks;
        $updata->status = $request->status;
        $updata->save();
        return response()->json([
                    'message' => 'success'
        ]);
    }
    
        
    public function get_activity_comments(Request $request){
        $id = $request->activity_schedule_id;
        $comments = Activityschedulecomments::select('activity_schedule_comments.*', 'users.name')->where('activity_schedule_id', $id)->join('users', 'users.id', 'activity_schedule_comments.commenter_id')->get()->toArray();
        $html = '';
        if($comments){
            foreach($comments as $row){
            if(auth()->user()->id != $row['commenter_id']){
                $html .= '<li>';
                    $html .= '<div class="chat-image">'; 
                        if(auth()->user()->profile->pic){
                            $html .= '<img alt="'.ucwords($row['name']).'" src="'.asset('uploads/users/'.auth()->user()->profile->pic).'">'; 
                        }else{
                            $html .= '<img alt="'.ucwords($row['name']).'" src="'.asset('uploads/users/default.jpeg').'">'; 
                        }
                    $html .= '</div>';
                    $html .= '<div class="chat-body">';
                        $html .= '<div class="chat-text">';
                            $html .= '<p><span class="font-semibold">'.ucwords($row['name']).'</span> '.$row['comments'].'. </p>';
                        $html .= '</div>';
                        $datetime1 = new DateTime();
                        $datetime2 = new DateTime($row['created_at']);
                        $interval = $datetime1->diff($datetime2);
                        //$elapsed = $interval->format('%y years %m months %a days %h hours %i minutes %s seconds');
                        $elapsed = $interval->format('%i minutes');
                        $html .= '<span>'.$elapsed.'</span>';
                    $html .= '</div>';
                $html .= '</li>';
            }else{
                $html .= '<li title="Me" class="odd">';
                    $html .= '<div class="chat-body">';
                        $html .= '<div class="chat-text">';
                            $html .= '<p>'.$row['comments'].'</p>';
                        $html .= '</div>';
                        $datetime1 = new DateTime();
                        $datetime2 = new DateTime($row['created_at']);
                        $interval = $datetime1->diff($datetime2);
                        //$elapsed = $interval->format('%y years %m months %a days %h hours %i minutes %s seconds');
                        $elapsed = $interval->format('%i minutes');
                        $html .= '<span>'.$elapsed.'</span>';
                    $html .= '</div>';
                $html .= '</li>';
            }
        }}
        return response()->json([
                'message' => 'success',
                'comments' => $html
        ]);
    }
    
    public function insert_activity_comments(Request $request){
        $comments = new Activityschedulecomments;
        $comments->commenter_id = auth()->user()->id;
        $comments->activity_schedule_id = $request->activity_schedule_id;
        $comments->comments = $request->comments;
        if($comments->save()){
            return response()->json([
                'message' => 'success'
        ]);
        }
    }
    
    public function schedule_edit(Request $request){
        $activityscheduleid = $request->activity_schedule_id;
        $activityschedule = Activityschedule::find($activityscheduleid);
        $activityscheduledetail = Activityscheduledetails::where('activity_schedule_id', $activityscheduleid)->get()->toArray();
        return response()->json([
                'message' => 'success',
                'activityschedule' => $activityschedule,
                'activityscheduledetail' => $activityscheduledetail
        ]);
    }
    
    public function schedule_update(Request $request){
        $activity_schedule_id = $request->activity_schedule_id;
        $activity_schedule = Activityschedule::find($activity_schedule_id);
        $activity_schedule->activity_id = $request->activity_id;
        $activity_schedule->customer_id = $request->customer_id;
        $activity_schedule->saleman_id = $request->saleman_id;
        $activity_schedule->status = 'Y';
        $activity_schedule->remarks = NULL;
        $activity_schedule->created_by = auth()->user()->id;
        if ($activity_schedule->save()) {
            $delete_schedule = Activityscheduledetails::where('activity_schedule_id', $activity_schedule_id)->delete();
            if ($request->ScheduleData && !empty($request->ScheduleData)) {
                $ScheduleData = $request->ScheduleData;
                for ($i = 0; $i < count($ScheduleData); $i++) {
                    $activity_schedule_details = new Activityscheduledetails();
                    $activity_schedule_details->schedule_date = date('Y-m-d', strtotime($ScheduleData[$i]['schedule_date']));
                    $activity_schedule_details->start_time = $ScheduleData[$i]['start_time'];
                    $activity_schedule_details->end_time = $ScheduleData[$i]['end_time'];
                    $activity_schedule_details->remarks = $ScheduleData[$i]['remarks'];
                    $activity_schedule_details->status = $ScheduleData[$i]['status'];
                    $activity_schedule_details->created_by = auth()->user()->id;
                    $activity_schedule_details->activity_schedule_id = $activity_schedule_id;
                    $activity_schedule_details->save();
                }
            }
        }
        return response()->json([
                    'message' => 'success'
        ]);
    }

}
