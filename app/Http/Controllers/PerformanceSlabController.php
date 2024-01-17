<?php

namespace App\Http\Controllers;

use App\follow_up_type;
use App\office_working_hour;
use App\performance_slab;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PerformanceSlabController extends Controller
{
    protected $role_id;
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
        $performance_slabs = performance_slab::all();
        return view('performance_slabs.index', compact('performance_slabs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role_id = auth()->user()->role_id;
        $users = User::where('role_id', $role_id)->get();
        return view('performance_slabs.create', compact('users'));
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
            'slab_code' => 'required|unique:performance_slabs,slab_code',
            'start_date' => 'required',
            'end_date' => 'required',
            'month' => 'required',
            'slab_amount' => 'required',
            'user' => 'required',

        ]);

        try {
            $store = new performance_slab();
            $store->slab_code = $request->slab_code;
            $store->start_date = $request->start_date;
            $store->end_date = $request->end_date;
            $store->slab_amount = $request->slab_amount;
            $store->month = $request->month;
            $store->target_amount = $request->slab_amount * $request->month;
            $name = User::where('id', $request->user)->select('name')->first();
            $store->employee_id = $request->user;
            $store->no_of_persons = $request->no_of_persons;
            $store->employee_name = $name->name;
            $store->created_by = auth()->user()->id;
            $store->save();
            session()->flash('success', 'Added Successfully');
            return redirect('performance_slabs');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\office_working_hour  $office_working_hour
     * @return \Illuminate\Http\Response
     */
    public function show(office_working_hour $office_working_hour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\office_working_hour  $office_working_hour
     * @return \Illuminate\Http\Response
     */
    public function edit(office_working_hour $office_working_hour, $id)
    {
        $role_id = auth()->user()->role_id;
        $users = User::where('role_id', $role_id)->get();
        $dec_id = Crypt::decrypt($id);
        //    dd($dec_id);
        $performance_slabs = performance_slab::where('id_performance_slabs', $dec_id)->first();
        //    dd($office_working_hour);
        return view('performance_slabs.edit', compact('performance_slabs', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\office_working_hour  $office_working_hour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, office_working_hour $office_working_hour, $id)
    {
        $dec_id = Crypt::decrypt($id);
        // dd($dec_id);
        $request->validate([
            'slab_code' => 'required|unique:performance_slabs,slab_code,' . $dec_id . ',id_performance_slabs',
            'start_date' => 'required',
            'end_date' => 'required',
            'month' => 'required',
            'slab_amount' => 'required',
            'user' => 'required',

        ]);
        try {

            // dd($dec_id);
            $store = performance_slab::where('id_performance_slabs', $dec_id)->first();
            $store->slab_code = $request->slab_code;
            $store->start_date = $request->start_date;
            $store->end_date = $request->end_date;
            $store->slab_amount = $request->slab_amount;
            $store->month = $request->month;
            $store->target_amount = $request->slab_amount * $request->month;
            $name = User::where('id', $request->user)->select('name')->first();
            $store->employee_id = $request->user;
            $store->no_of_persons = $request->no_of_persons;
            $store->employee_name = $name->name;
            $store->created_by = auth()->user()->id;
            $store->save();
            session()->flash('success', 'Added Successfully');
            return redirect('performance_slabs');
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\office_working_hour  $office_working_hour
     * @return \Illuminate\Http\Response
     */
    public function destroy(office_working_hour $office_working_hour)
    {
        //
    }
}
