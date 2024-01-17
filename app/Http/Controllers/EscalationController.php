<?php

namespace App\Http\Controllers;

use App\escalation_group;
use App\Escalations;
use App\escalations_preference;
use App\escallation;
use App\inquiry;
use App\my_job;
use App\my_team_job;
use App\role_permission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class EscalationController extends Controller
{


    public function preferences()
    {
        $escalations = Escalations::all();
        return view('/escalation_preferences.index', compact('escalations'));
    }
    public function get_notifications_my_jobs()
    {
        $noti = Notification::latest()->where('is_read', 0)->limit(5)->where('user_id', auth()->user()->id)->where('type', "self_inquiry")->get();
        foreach ($noti as $not) {

            echo $not = '<a  href="' . url('/my_jobs') . '"><div class="media">
            <div class="az-img-user"><img  src="' . url('/img/notification_icon.png') . '" style="height:40px;width:40px;" alt=""></div>
            <div class="media-body">
                <p><strong>' . $not->user_name . '</strong>' . $not->message . '</p></a>
                <span>' . $not->created_at->format('d M  H:i') . ' <a  href="' . url('/notification_read_my_jobs' . '/' . Crypt::encrypt($not->id)) . '">Mark as read</a></span>
            </div>
        </div>';
        }
    }
    public function get_noti_count_my_jobs($count = null)
    {
        $noti = Notification::where('is_read', 0)->where('user_id', auth()->user()->id)->where('type', "self_inquiry")->get()->count();
        $active = 0;
        if ($noti > $count) {
            $active = 1;
        }
        return response()->json([
            'count' => $noti,
            'is_new' => $active,
        ]);
    }
    public function notification_read_my_jobs($id)
    {
        $dec_id = Crypt::decrypt($id);
        $noti = Notification::where('id', $dec_id)->where('user_id', auth()->user()->id)->whereIn('type', "self_inquiry")->get()->first();
        $noti->is_read = 1;
        $noti->save();

        session()->flash('success', "Notification Read Successfully");
        return redirect()->back();
    }

    //Team Notifications
    public function get_notifications_team()
    {



        $noti = Notification::latest()->where('is_read', 0)->limit(5)->where('user_id', auth()->user()->id)->where('type', "team_inquiry")->get();
        foreach ($noti as $not) {

            echo $not = '<a  href="' . url('/my_jobs') . '"><div class="media">
            <div class="az-img-user"><img  src="' . url('/img/notification_icon_team.png') . '" style="height:40px;width:40px;" alt=""></div>
            <div class="media-body">
                <p><strong>' . $not->user_name . '</strong>' . $not->message . '</p></a>
                <span>' . $not->created_at->format('d M  H:i') . ' <a  href="' . url('/notification_read_my_jobs' . '/' . Crypt::encrypt($not->id)) . '">Mark as read</a></span>
            </div>
        </div>';
        }
    }
    public function get_noti_count_team($count = null)
    {
        $noti = Notification::where('is_read', 0)->where('user_id', auth()->user()->id)->where('type', "team_inquiry")->get()->count();
        $active = 0;
        if ($noti > $count) {
            $active = 1;
        }
        return response()->json([
            'count' => $noti,
            'is_new' => $active,
        ]);
    }
    public function notification_read_team($id)
    {
        $dec_id = Crypt::decrypt($id);
        $noti = Notification::where('id', $dec_id)->where('user_id', auth()->user()->id)->whereIn('type', "team_inquiry")->get()->first();
        $noti->is_read = 1;
        $noti->save();

        session()->flash('success', "Notification Read Successfully");
        return redirect()->back();
    }

    //Escalations Notifications
    public function get_escalations()
    {



        $noti = Notification::latest()->where('is_read', 0)->limit(5)->where('user_id', auth()->user()->id)->where('type', "team_inquiry")->get();
        foreach ($noti as $not) {

            echo $not = '<a  href="' . url('/my_jobs') . '"><div class="media">
            <div class="az-img-user"><img  src="' . url('/img/notification_icon_team.png') . '" style="height:40px;width:40px;" alt=""></div>
            <div class="media-body">
                <p><strong>' . $not->user_name . '</strong>' . $not->message . '</p></a>
                <span>' . $not->created_at->format('d M  H:i') . ' <a  href="' . url('/notification_read_my_jobs' . '/' . Crypt::encrypt($not->id)) . '">Mark as read</a></span>
            </div>
        </div>';
        }
    }
    public function get_escalations_count($count = null)
    {
        $noti = Notification::where('is_read', 0)->where('user_id', auth()->user()->id)->where('type', "team_inquiry")->get()->count();
        $active = 0;
        if ($noti > $count) {
            $active = 1;
        }
        return response()->json([
            'count' => $noti,
            'is_new' => $active,
        ]);
    }
    public function escalations_read($id)
    {
        $dec_id = Crypt::decrypt($id);
        $noti = Notification::where('id', $dec_id)->where('user_id', auth()->user()->id)->whereIn('type', "team_inquiry")->get()->first();
        $noti->is_read = 1;
        $noti->save();

        session()->flash('success', "Escalation Read Successfully");
        return redirect()->back();
    }

    public function escalation_timer_for_open()
    {

        $get_escalation_group_user = escalation_group::pluck('user_id');
        // dd($get_escalation_group);
        // if()
        $get_inquiry = inquiry::whereIn('saleperson', $get_escalation_group_user)->get();
        $get_prefrence = escalations_preference::where('escalation_name', "NO FIRST CONTACT")->first();
        foreach ($get_inquiry as $key => $value) {
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $value->escalation_time_for_open);
            $from = Carbon::now();
            $time = $from->diffInMinutes($to);
            $get_ids = [];
            // dd($time);
            if ($value->priority == 1) {
                $timer = $get_prefrence->timer / 2;
            } elseif ($value->priority == 2) {
                $timer = $get_prefrence->timer;
            }
            $my_job = my_job::where('inquiry_id', $value->id_inquiry)->first();
            if ($time >= intval($timer)) {
                if ($my_job && $value->status == "Open") {

                    // dd($my_job);
                    $get_ids[] = $value->saleperson;
                    $store = new escallation();
                    $store->my_team_job_id = $my_job->id_my_jobs;
                    $store->inquiry_id = $value->id_inquiry;
                    $store->user_id = json_encode($get_ids);
                    $store->escellation_status = "NO FIRST CONTACT";
                    $store->created_by = "System";
                    $store->save();
                    $value->escalation_time_for_open = date("Y-m-d H:i:s");
                    $value->save();
                    sendNoti('New Escalation Received Against Inquiry#'.$value->id_inquiry, null,'escalation', $value->saleperson, null);
                }
            }

            // dd($get_ids);
        }
    }
    public function escalation_timer_for_not_assign()
    {

        $get_escalation_group_user = escalation_group::pluck('user_id');
        // dd($get_escalation_group);
        // if()
        $get_inquiry = inquiry::whereIn('saleperson', $get_escalation_group_user)->get();
        // dd($get_inquiry);
        $get_prefrence = escalations_preference::where('escalation_name', "NOT ASSIGNED")->first();
        foreach ($get_inquiry as $key => $value) {
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $value->escalation_time_for_assign);
            $from = Carbon::now();
            $time = $from->diffInMinutes($to);
            // dd($time);
            if ($value->priority == 1) {
                $timer = $get_prefrence->timer / 2;
            } elseif ($value->priority == 2) {
                $timer = $get_prefrence->timer;
            }

            $my_team_job = my_team_job::where('inquiry_id', $value->id_inquiry)->first();
            if ($time >= intval($timer)) {
                if ($my_team_job && $my_team_job->taken_by_status != 1) {

                    $get_users_id = json_encode($value->saleperson);
                    $store = new escallation();
                    $store->my_team_job_id = $my_team_job->id_my_team_jobs;
                    $store->inquiry_id = $value->id_inquiry;
                    $store->user_id = $get_users_id;
                    $store->escellation_status = "Un Assigned";
                    $store->created_by = "System";
                    $store->save();
                    $value->escalation_time_for_assign = date("Y-m-d H:i:s");
                    $value->save();

                    sendNoti('New Escalation Received Against Inquiry#'.$value->id_inquiry, null,'escalation', $value->saleperson, null);
                }
            }
            // dd($time);
        }
    }
}
