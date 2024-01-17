<?php

namespace App\Http\Controllers;

use App\assign_department_user;
use App\follow_up_type;
use App\department_team;
use App\inquiry;
use App\my_team_job;
use App\departments;
use App\my_job;
use App\office_working_hour;
use App\performance_slab;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class TeamsJobsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd($department_team);
        $get_team = [];
        $get_auth_teams = json_decode(auth()->user()->team_id);
        foreach ($get_auth_teams as $key => $value) {
            $department_team = department_team::where('id_department_teams', $value)
                ->select('user_id', 'department_id')
                ->first();
            if ($department_team) {
                $department_name_get = departments::where('id_departments', $department_team->department_id)->first();
                // dd($department_name_get);
                $department_name[] = $department_name_get->department_name;
            }
        }

        // dd($department_name);
        $get_team = my_team_job::where('taken_by', null)
            ->where('team_id', null)
            ->whereIn('department_ids', $department_name)
            ->with('get_inquiry')
            ->get();
        $decode_team = json_decode(auth()->user()->team_id);
        //         // dd($decode_team);
        //         $head_user = [];
        //         if (is_array($decode_team) && count($decode_team) > 0) {
        //             foreach ($decode_team as $key => $value) {
        //                 $depart_team_head = department_team::where('id_department_teams', $value)->first();

        //                 if (isset($depart_team_head) && $depart_team_head) {
        //                     if ($depart_team_head->head_id == auth()->user()->id) {
        //                         $head_user[] = $value;
        // dd()
        //                     } else {
        //                     }
        //                 }
        //             }
        //         }
        // dd($head_user);
        $my_team_jobs = my_team_job::whereIn('team_id', $get_auth_teams)
            ->with('get_inquiry', 'get_inquiry.get_customer')
            ->whereIn('department_ids', $department_name)
            ->get();
        // dd($my_team_jobs);
        if (isset($decode_team) && is_array($decode_team)) {
            foreach ($decode_team as $team_id) {
                $depart_team = department_team::where('id_department_teams', $team_id)->first();
                $get_depart_users = json_decode($depart_team?->user_id);
                $get_depart_user_head[] = $depart_team?->head_id;
            }
            $check_is_head = in_array(auth()->user()->id, $get_depart_user_head);
            if ($check_is_head) {
                $is_head = true;
            } else {
                $is_head = false;
            }
            return view('my_team_jobs.index', compact('get_team', 'is_head', 'decode_team', 'my_team_jobs'));
        } else {
            $is_head = false;

            return view('my_team_jobs.index', compact('get_team', 'is_head', 'my_team_jobs'));
        }
    }
    public function take_my_team_job(Request $request)
    {
        // dd($request);
        $request->validate([
            't_id' => 'required',
            'inq_id' => 'required',
        ]);
        $my_job_exist = my_job::where('inquiry_id', $request->inq_id)
            ->where('team_id', $request->t_id)
            ->where('user_id', auth()->user()->id)
            ->first();
        if (!$my_job_exist) {
            $job = new my_job();
            $job->user_id = auth()->user()->id;
            $job->team_id = $request->t_id;
            $job->inquiry_id = $request->inq_id;
            $job->save();

            $team_jobs = my_team_job::where('id_my_team_jobs', $request->my_t_job_id)->first();
            $team_jobs->team_id = $request->t_id;
            $team_jobs->taken_by = auth()->user()->id;
            $team_jobs->save();

            session()->flash('success', 'Job Taken Successfully');
            return redirect('my_jobs');
        } else {
            session()->flash('warning', 'Job Already Taken');
            return redirect('my_jobs');
        }
    }
    public function assign_my_team_job(Request $request)
    {
        // dd($request);
        $request->validate([
            't_id' => 'required',
            'inq_id' => 'required',
            'user_id' => 'required',
        ]);
        $my_job_exist = my_job::where('inquiry_id', $request->inq_id)
            ->where('team_id', $request->t_id)
            ->where('user_id', $request->user_id)
            ->first();
        if (!$my_job_exist) {
            $job = new my_job();
            $job->user_id = $request->user_id;
            $job->team_id = $request->t_id;
            $job->inquiry_id = $request->inq_id;
            $job->assign_by = auth()->user()->id;
            $job->save();

            $team_jobs = my_team_job::where('id_my_team_jobs', $request->my_t_job_id)->first();
            $team_jobs->team_id = $request->t_id;
            $team_jobs->taken_by = $request->user_id;
            $team_jobs->assign_by = auth()->user()->id;
            $team_jobs->save();

            session()->flash('success', 'Job Assign Successfully');
            return redirect()->back();
        } else {
            session()->flash('warning', 'Job Already Taken');
            return redirect()->back();
        }
    }
}
