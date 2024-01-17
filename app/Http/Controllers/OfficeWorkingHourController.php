<?php

namespace App\Http\Controllers;

use App\office_working_hour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class OfficeWorkingHourController extends Controller
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
        $office_working_hours = office_working_hour::all();
        return view('office_working_hours.index', compact('office_working_hours'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('office_working_hours.create');
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
            'day_of_week' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        try {

            $store = new office_working_hour();
            $store->day_of_week = $request->day_of_week;
            $store->start_time = $request->start_time;
            $store->end_time = $request->end_time;
            $store->created_by = auth()->user()->id;
            $store->save();
            return redirect('office_working_hours');
            session()->flash('success','Added Successfully');
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
        $dec_id = Crypt::decrypt($id);
        //    dd($dec_id);
        $office_working_hour = office_working_hour::where('id_office_working_hour', $dec_id)->first();
        //    dd($office_working_hour);
        return view('office_working_hours.edit', compact('office_working_hour'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\office_working_hour  $office_working_hour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, office_working_hour $office_working_hour,$id)
    {
        try {
            $dec_id = Crypt::decrypt($id);
            // dd($dec_id);
            $store = office_working_hour::where('id_office_working_hour', $dec_id)->first();
            $store->day_of_week = $request->day_of_week;
            $store->start_time = $request->start_time;
            $store->end_time = $request->end_time;
            $store->update();
            session()->flash('success','Update Successfully');
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
