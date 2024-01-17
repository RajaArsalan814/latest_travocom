<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use Illuminate\Support\Facades\Session;

class ActivityController extends Controller {

    protected $role_id;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->role_id = Auth::user()->role_id;
            $slug_filter = preg_replace('/[0-9]+/', '', $request->path());
            if (checkConstructor($this->role_id, $slug_filter) == 1) {
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
    public function index() {
        $activity = Activity::select('*')->get();
        return view('/activity.index', compact('activity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('/activity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'activity' => 'required|unique:activities,activity',
        ]);

        $activity = new Activity();
        $activity->activity = $request->activity;
        $activity->active = $request->active;
        $activity->created_by = auth()->user()->id;
        $activity->save();

        Session::flash('message', 'Activity has been added');
        Session::flash('message_type', 'success');
        return redirect(url('activity'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $activity = Activity::findOrfail($id);
        return view('/activity.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $this->validate($request, [
            'activity' => 'required',
        ]);

        $activity = Activity::find($id);
        $activity->activity = $request->activity;
        $activity->active = $request->active;
        $activity->save();

        Session::flash('message', 'Activity has been updated');
        Session::flash('message_type', 'success');
        return redirect(url('activity'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $brands = brands::findOrfail($request->id);
        $brands->delete();
        Session::flash('message', 'Brand has been deleted');
        return back();
    }

}
