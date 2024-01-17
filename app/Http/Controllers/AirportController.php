<?php

namespace App\Http\Controllers;

use App\airlines;
use App\airport;
use App\cities;
use App\city;
use App\countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class AirportController extends Controller
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
     */
    public function index()
    {
        $airports = airport::all();
        return view('airports.index', compact('airports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = countries::all();
        return view('airports.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'airport_name' => 'required',
            'airport_country' => 'required',
            'airport_short_code' => 'required',
            'airport_city' => 'required',
        ]);

        $store = new airport();
        $store->name     = $request->airport_name;
        $store->countryName = $request->airport_country;
        $getCityName = cities::where('id', $request->airport_city)->first();
        $store->cityName = $request->airport_city;
        $store->code = $request->airport_short_code;
        // $store->timezone = $request->airport_short_code;
        $store->save();

        if ($store) {
            session()->flash('success', 'Added Successfully!');

            return redirect()->back();
        } else {
            toastr()->error('An error has occurred please try again later.');
            //session()->flash('error', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(airline $airline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dec_id = \Crypt::decrypt($id);
        $countries = countries::all();
        $airports = airport::where('id_airports', $dec_id)->first();
        return view('airports.edit', compact('airports', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //        echo 'working';exit;
        $request->validate([
            'airport_name' => 'required',
            'airport_country' => 'required',
            'airport_short_code' => 'required',
            'airport_city' => 'required',
        ]);
        // dd($request);

        $dec_id = \Crypt::decrypt($request->a_id);
        $store = airport::where('id_airports', $dec_id)->first();
        $store->name     = $request->airport_name;
        $store->countryName = $request->airport_country;
        $getCityName = cities::where('id', $request->airport_city)->first();
        $store->cityName = $request->airport_city;
        $store->code = $request->airport_short_code;
        $store->save();
        if ($store) {
            session()->flash('success', 'Updated Successfully!');
            return redirect()->back();
        } else {
            toastr()->error('An error has occurred please try again later.');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $airline_id = \Crypt::decrypt($id);
        $destroy_airline = airlines::findOrfail($airline_id);
        $destroy_airline->delete();
        session()->flash('success', 'Airline Removed!');
        return back();
    }
}
