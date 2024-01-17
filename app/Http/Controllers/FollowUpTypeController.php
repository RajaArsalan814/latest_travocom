<?php

namespace App\Http\Controllers;

use App\follow_up_type;
use App\office_working_hour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class FollowUpTypeController extends Controller
{
    protected $role_id;
    public function __construct()
    {
        $this->middleware('auth');
               
    }
//     public function __construct()
//     {
//         $this->middleware('auth');
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
        $follow_up_types = follow_up_type::all();
        return view('follow_up_types.index', compact('follow_up_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('follow_up_types.create');
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
            'type_name' => 'required',
            'status' => 'required',
        ]);

        try {

            $store = new follow_up_type();
            $store->type_name = $request->type_name;
            if ($request->status == 1) {
                $store->status = "Active";
            } else {
                $store->status = "In-Active";
            }
            $store->created_by = auth()->user()->id;
            $store->save();
            session()->flash('success','Added Successfully');
            return redirect('follow_up_types');
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
        $follow_up_types = follow_up_type::where('id_follow_up_types', $dec_id)->first();
        //    dd($office_working_hour);
        return view('follow_up_types.edit', compact('follow_up_types'));
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
        try {
            $dec_id = Crypt::decrypt($id);
            // dd($dec_id);
            $store = follow_up_type::where('id_follow_up_types', $dec_id)->first();
            $store->type_name = $request->type_name;
            if ($request->status == 1) {
                $store->status = "Active";
            } else {
                $store->status = "In-Active";
            }
            $store->save();
            session()->flash('success','Update Successfully');
            return redirect('follow_up_types');
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
