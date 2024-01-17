<?php

namespace App\Http\Controllers;

use App\follow_up_type;
use App\office_working_hour;
use App\room_type;
use App\Addons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $role_id;
    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->role_id = Auth::user()->role_id;
            //    $slug_filter = preg_replace('/[0-9]+/', '', $request->path());
            //    $slug_filter = preg_replace('/[0-9]+/', '', $request->path());
            $ex = explode('/', $request->path());
            if (count($ex) >= 3) {
                $sliced = array_slice($ex, 0, -1);
            } else {
                $sliced = $ex;
            }

            $string = implode("/", $sliced);
                            // dd($string);
            if (checkConstructor($this->role_id, count($ex) >= 3 ? $string . '/' : $string) == 1) {
                return $next($request);
            } else if (strpos($request->path(), 'store') !== false) {
                return $next($request);
            } else if (strpos($request->path(), 'update') !== false) {
                return $next($request);
            } else {
                abort(404);
            }
        });
    }
    public function index()
    {

        $room_types = room_type::all();
        return view('room_types.index', compact('room_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $addons = Addons::where('status',1)->get();
        return view('room_types.create' , compact('addons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'type_name' => 'required'
        ]);

        try {

            $store = new room_type();
            $store->name = $request->type_name;
            $store->addons = json_encode($request->addons);
            $store->no_of_beds = $request->no_of_beds;
            $store->status = "Active";
            $store->created_by = auth()->user()->id;
            $store->save();
            session()->flash('success', 'Added Successfully');
            return redirect('room_types');
        } catch (\Throwable $th) {
            throw $th;
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
        $addons = Addons::where('status',1)->get();
        //    dd($dec_id);
        $room_types = room_type::where('id_room_types', $dec_id)->first();
        //    dd($office_working_hour);
        return view('room_types.edit', compact('room_types','addons'));
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
            $store = room_type::where('id_room_types', $dec_id)->first();
            $store->name = $request->type_name;
            $store->no_of_beds = $request->no_of_beds;
            $store->addons = json_encode($request->addons);
            if ($request->status == 1) {
                $store->status = "Active";
            } else {
                $store->status = "In-Active";
            }
            $store->save();
            session()->flash('success', 'Update Successfully');
            return redirect('room_types');
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
