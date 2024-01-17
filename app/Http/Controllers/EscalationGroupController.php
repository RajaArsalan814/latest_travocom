<?php

namespace App\Http\Controllers;

use App\approval_group;
use App\campaign;
use App\escalation_group;
use App\follow_up_type;
use App\office_working_hour;
use App\other_service;
use App\performance_slab;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class EscalationGroupController extends Controller
{
    protected $role_id;
//     public function __construct()
//     {
//        $this->middleware('auth');
//                $this->middleware(function ($request, $next) {
//                    $this->role_id = Auth::user()->role_id;
//                 //    $slug_filter = preg_replace('/[0-9]+/', '', $request->path());
//                 //    $slug_filter = preg_replace('/[0-9]+/', '', $request->path());
//                 $ex = explode('/',$request->path());
//                 if(count($ex)>=3){
//                     $sliced = array_slice($ex, 0, -1);

//                 }else{
//                     $sliced = $ex;
//                 }

//                 $string = implode("/", $sliced);
// //                 dd($string);
//                    if (checkConstructor($this->role_id, count($ex)>=3 ? $string.'/': $string) == 1) {
//                        return $next($request);
//                    }else if(strpos($request->path(), 'store') !== false){
//                        return $next($request);
//                    }else if(strpos($request->path(), 'update') !== false){
//                        return $next($request);
//                    } else {
//                        abort(404);
//                    }
//                });
//     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $escalation_group = escalation_group::all();
        return view('escalation_groups.index', compact('escalation_group'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $users = User::all();
        return view('escalation_groups.create', compact('users'));
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
            'users' => 'required',

        ]);

        try {
            $store = new escalation_group();
            $user=User::find($request->users);
            $store->user_name = $user->name;
            $store->user_id = $request->users;
            $store->created_by = auth()->user()->id;
            $store->save();
            session()->flash('success', 'Added Successfully');
            return back();
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
        // dd('sds');

        $dec_id = Crypt::decrypt($id);
        //    dd($dec_id);
        $edit = escalation_group::where('id_escalation_group', $dec_id)->first();
        $users = User::all();
        //    dd($office_working_hour);
        return view('escalation_groups.edit', compact('edit', 'users'));
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
            'users' => 'required',
        ]);
        try {

            // dd($request);
            $store = escalation_group::where('id_escalation_group', $dec_id)->first();
            // dd($store);
            $user=User::find($request->users);
            $store->user_name = $user->name;
            $store->user_id = $request->users;
            $store->created_by = auth()->user()->id;
            $store->save();
            session()->flash('success', 'Updated Successfully');
            return back();
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
    public function destroy(office_working_hour $office_working_hour,$id)
    {
        $dec_id = Crypt::decrypt($id);

        $destroy = escalation_group::where('id_escalation_group',$dec_id)->first();
        //    dd($destroy_hotel);
        $destroy->delete();
        session()->flash('success', 'Inventory Removed!');

        return back();
    }
}
