<?php

namespace App\Http\Controllers;

use App\jobs;
use App\inquirytypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class JobsController extends Controller
{
    protected $role_id;
    public function __construct()
    {
       $this->middleware('auth');
               $this->middleware(function ($request, $next) {
                   $this->role_id = Auth::user()->role_id;
                //    $slug_filter = preg_replace('/[0-9]+/', '', $request->path());
                //    $slug_filter = preg_replace('/[0-9]+/', '', $request->path());
                $ex = explode('/',$request->path());
                if(count($ex)>=3){
                    $sliced = array_slice($ex, 0, -1);

                }else{
                    $sliced = $ex;
                }

                $string = implode("/", $sliced);
//                 dd($string);
                   if (checkConstructor($this->role_id, count($ex)>=3 ? $string.'/': $string) == 1) {
                       return $next($request);
                   }else if(strpos($request->path(), 'store') !== false){
                       return $next($request);
                   }else if(strpos($request->path(), 'update') !== false){
                       return $next($request);
                   } else {
                       abort(404);
                   }
               });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = jobs::select('*')->get();

        return view('jobs.index',compact('data'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = \App\roles::all();
        $inquiry_types = inquirytypes::select()->where('type_name', '!=' , 'Other')->where('type_name', '!=' , '-')->where('type_name', '!=' , null)->where('type_name', '!=' , ' ')->get()->toArray();
//        echo '<pre>'; print_r($inquiry_types);exit;
        return view('jobs.create', compact('inquiry_types', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'job_name' => 'required',
            'job_description' => 'required',
            'inquiry_type' => 'required'

        ]);
        $jobs = new jobs();
        $jobs->job_name = $request->job_name;
        $jobs->inquiry_type = $request->inquiry_type;
        $jobs->job_description = $request->job_description;
        $jobs->job_duration_hours = $request->duration_hours;
        $jobs->job_duration_minutes = $request->duration_minutes;
        $jobs->save();
        if ($jobs) {
            session()->flash('success', 'New Job Added');

            return redirect()->back();
        } else {
            toastr()->error('An error has occurred please try again later.');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function show(jobs $jobs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $inquiry_types = inquirytypes::select('*')->where('type_name', '!=' , 'Other')->where('type_name', '!=' , '-')->where('type_name', '!=' , null)->where('type_name', '!=' , ' ')->get()->toArray();
        $jobs = jobs::findOrfail(\Crypt::decrypt($request->id));
//        echo '<pre>'; print_r($inquiry_types);exit;
        return  view('jobs.edit',compact('jobs', 'inquiry_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'job_name' => 'required',
            'job_description' => 'required'
        ]);
//        echo 'Stop';exit;
//        $jobs = new jobs();
        $dec_id = \Crypt::decrypt($request->h_id);
        $jobs = jobs::where('id_jobs', $dec_id)->first();
        $jobs->job_name = $request->job_name;
        $jobs->inquiry_type = $request->inquiry_type;
        $jobs->job_description = $request->job_description;
        $jobs->job_duration_hours = $request->duration_hours;
        $jobs->job_duration_minutes = $request->duration_minutes;
        $jobs->status = $request->status;
        $jobs->save();
        if ($jobs) {
            session()->flash('success', 'Job Updated');

            return redirect()->back();
        } else {
            toastr()->error('An error has occurred please try again later.');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\jobs  $jobs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $jobs = jobs::findOrfail($request->id);
        $jobs->delete();
        Session::flash('message','Sales References has been deleted');
        return back();
    }
}
