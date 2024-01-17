<?php

namespace App\Http\Controllers;

use App\airline_rate;
use App\airlines;
use App\follow_up_type;
use App\hotel_details;
use App\hotel_inventory;
use App\hotel_rate;
use App\hotels;
use App\office_working_hour;
use App\room_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AirlineRateController extends Controller
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
    public function index($airline_id)
    {
        $airline_id = Crypt::decrypt($airline_id);
        $airlines = airlines::where('id_airlines', $airline_id)->first();
        // dd($airlines);
        $airline_rates = airline_rate::where('airline_id', $airline_id)->get();
        return view('airline_rates.index', compact('airline_rates', 'airlines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($airline_id)
    {
        $hotel_id = Crypt::decrypt($airline_id);
        return view('airline_rates.create');
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
        $airline_id = Crypt::decrypt($request->h_id);
        $request->validate([
            'from_date' => 'required',
            'to_date' => 'required',
            'from_location' => 'required',
            'to_location' => 'required',
            'flight_class' => 'required',
            'cost_price' => 'required',
            'selling_price' => 'required',
        ]);

        try {

            $store = new airline_rate();
            $store->from_date = $request->from_date;
            $store->to_date = $request->to_date;
            $store->from_location = $request->from_location;
            $store->to_location = $request->to_location;
            $store->flight_class = $request->flight_class;
            $store->airline_id = $airline_id;
            $store->cost_price = $request->cost_price;
            $store->selling_price = $request->selling_price;
            $store->created_by = auth()->user()->id;
            $store->save();
            session()->flash('success', 'Added Successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            // throw $th;
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
        $room_rates = airline_rate::where('id_airline_rates', $dec_id)->first();
        return view('airline_rates.edit', compact('room_rates'));
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
        // dd($request);
        $request->validate([
            'from_date' => 'required',
            'to_date' => 'required',
            'from_location' => 'required',
            'to_location' => 'required',
            'flight_class' => 'required',
            'cost_price' => 'required',
            'selling_price' => 'required',
        ]);
        try {
            $dec_id = Crypt::decrypt($id);
            $airline_id = Crypt::decrypt($request->a_id);
            // dd($dec_id);
            $store = airline_rate::where('id_airline_rates', $dec_id)->first();
            // dd($store);
            $store->from_date = $request->from_date;
            $store->to_date = $request->to_date;
            $store->from_location = $request->from_location;
            $store->to_location = $request->to_location;
            $store->flight_class = $request->flight_class;
            $store->airline_id = $airline_id;
            $store->cost_price = $request->cost_price;
            $store->selling_price = $request->selling_price;
            $store->created_by = auth()->user()->id;
            $store->save();
            session()->flash('success', 'Update Successfully');
            return redirect()->back();
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
    public function destroy($id)
    {
        $rate_id = Crypt::decrypt($id);
        $destroy_hotel = airline_rate::findOrfail($rate_id);
        $destroy_hotel->delete();
        session()->flash('success', 'Removed Successfully');
        return back();
    }
}
