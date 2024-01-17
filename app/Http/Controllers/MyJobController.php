<?php

namespace App\Http\Controllers;

use App\assign_department_user;
use App\follow_up;
use App\followup;
use App\followup_remark;
use App\my_job;
use App\Http\Controllers\Controller;
use App\my_team_job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class MyJobController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth');

    }
    public function index()
    {
        $my_jobs = my_job::select('my_jobs.inquiry_id', 'my_jobs.assign_by','team_id', 'customers.customer_name', 'inquiry.services_sub_services', 'inquirytypes.type_name', 'my_jobs.user_id', 'my_jobs.created_at', 'my_jobs.updated_at')
            ->join('inquiry', 'inquiry.id_inquiry', '=', 'my_jobs.inquiry_id')
            ->join('customers', 'customers.id_customers', '=', 'inquiry.customer_id')
            ->join('inquirytypes', 'inquirytypes.type_id', '=', 'inquiry.inquiry_type')
            ->where('user_id', auth()->user()->id)->get();
        //        dd(auth()->user()->id);
        //        echo '<pre>'; print_r($my_jobs);exit;
        return view('my_jobs.index', compact('my_jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($inq_id, $team_id)
    {

        $dec_inq_id = Crypt::decrypt($inq_id);
        $dec_team_id = Crypt::decrypt($team_id);

        $inquiry = \App\inquiry::where('id_inquiry', $dec_inq_id)->first();
        $inquiry_types = \App\inquirytypes::where('type_id', $inquiry->inquiry_type)->first();

        $my_job_create = new my_job();
        $my_job_create->inquiry_id = $dec_inq_id;
        $my_job_create->user_id = auth()->user()->id;
        $my_job_create->team_job_id = $dec_team_id;
        $my_job_create->save();

        $find_team_job = my_team_job::where('id_my_team_jobs', $dec_team_id)->first();
        $find_team_job->taken_by = $my_job_create->user_id;
        $find_team_job->taken_by_status = 1;
        $find_team_job->save();

        $users = \App\User::where('id', auth()->user()->id)->first();
        sendNoti('New ' . $inquiry_types->type_name . ' Inquiry', $users->name, 'self_inquiry', auth()->user()->id);
        session()->flash('success', 'Inquiry Assign Successfully');
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    public function assign_job(Request $request)
    {
        // dd($request);
        $dec_inq_id = $request->inq_id;
        $dec_team_id = $request->t_id;

        $inquiry = \App\inquiry::where('id_inquiry', $dec_inq_id)->first();
        $inquiry_types = \App\inquirytypes::where('type_id', $inquiry->inquiry_type)->first();

        $my_job_create = new my_job();
        $my_job_create->inquiry_id = $dec_inq_id;
        $my_job_create->user_id = $request->user_id;
        $my_job_create->team_job_id = $dec_team_id;
        $my_job_create->assign_by = auth()->user()->id;
        $my_job_create->save();

        $find_team_job = my_team_job::where('id_my_team_jobs', $dec_team_id)->first();
        $find_team_job->taken_by = $my_job_create->user_id;
        $find_team_job->taken_by_status = 1;
        $find_team_job->save();

        $users = \App\User::where('id', $my_job_create->user_id)->first();
        sendNoti('New ' . $inquiry_types->type_name . ' Inquiry', $users->name, 'self_inquiry', $my_job_create->user_id);
        return redirect()->back();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\my_job  $my_job
     * @return \Illuminate\Http\Response
     */
    public function show(my_job $my_job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\my_job  $my_job
     * @return \Illuminate\Http\Response
     */
    public function edit(my_job $my_job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\my_job  $my_job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, my_job $my_job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\my_job  $my_job
     * @return \Illuminate\Http\Response
     */
    public function destroy(my_job $my_job)
    {
        //
    }

    public function followups()
    {
        $get_users = [];
        $my_follow_ups = followup_remark::where('user_id', auth()->user()->id)->get();
        $all_follow_ups = followup_remark::all();
        foreach ($all_follow_ups as $key => $value1) {
            $assign_department = assign_department_user::whereIn('department_id', [1, 2, 3])->get();
            foreach ($assign_department as $key => $value2) {
                if ($value1->user_id == $value2->user_id) {
                    $get_users[] = $value1->user_id;
                }
            }
        };

        $my_team_follow_ups = followup_remark::whereIn('user_id', array_unique($get_users))->where('user_id', '!=', auth()->user()->id)->get();
        return view('followups.index', compact('my_follow_ups', 'all_follow_ups', 'my_team_follow_ups'));
    }
}
