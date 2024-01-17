<?php

namespace App\Http\Controllers;

use App\follow_up_type;
use App\hotel_details;
use App\hotel_inventory;
use App\hotel_rate;
use App\hotels;
use App\office_working_hour;
use App\room_type;
use App\service_vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class HotelRateController extends Controller
{
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
            //                 dd($string);
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($hotel_id)
    {
        $hotel_id = Crypt::decrypt($hotel_id);
        $hotel = hotels::where('id_hotels', $hotel_id)->first();
        $hotel_rates = hotel_rate::where('hotel_id', $hotel_id)->get();
        return view('hotel_rates.index', compact('hotel_rates', 'hotel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($hotel_id)
    {
        $hotel_id = Crypt::decrypt($hotel_id);
        // dd($hotel_id);
        $hotel_details = hotel_details::where('hotel_id', $hotel_id)->first();
        $service_vendors = service_vendor::where('vendor_status', 1)->get();
        // dd($hotel_details);

        $hotel_inventory = hotel_inventory::select()->where('hotel_id', $hotel_id)->get();
        $decode = json_decode($hotel_details->room_availablity);
        if ($decode == null) {
            $decode = [];
        }
        // $existing_inventory = hotel_inventory::where('hotel_id', $hotel_id)->groupBy('inventory_type_id')->pluck('inventory_type_id');
        $room_types = room_type::whereIn('id_room_types', $decode)->get();
        return view('hotel_rates.create', compact('room_types', 'service_vendors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hotel_id = Crypt::decrypt($request->h_id);
        // dd($hotel_id);
        $request->validate([
            'from_date' => 'required',
            'to_date' => 'required',
            'room_type' => 'required',
            'cost_price' => 'required',
            'selling_price' => 'required',
        ]);

        try {

            $store = new hotel_rate();
            $store->from_date = $request->from_date;
            $store->to_date = $request->to_date;
            $store->hotel_id = $hotel_id;
            $store->room_type_id = $request->room_type;
            $store->cost_price = $request->cost_price;
            $store->selling_price = $request->selling_price;
            $store->vendor_id = $request->vendor;
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
        $service_vendors = service_vendor::where('vendor_status', 1)->get();
        //    dd($dec_id);
        $room_rates = hotel_rate::where('id_hotel_rates', $dec_id)->first();
        // dd($hotel_id);
        $hotel_details = hotel_details::where('hotel_id', $room_rates->hotel_id)->first();
        // dd($hotel_details);

        $hotel_inventory = hotel_inventory::select()->where('hotel_id', $room_rates->hotel_id)->get();

        $decode = json_decode($hotel_details->room_availablity);
        if ($decode == null) {
            $decode = [];
        }
        // $existing_inventory = hotel_inventory::where('hotel_id', $hotel_id)->groupBy('inventory_type_id')->pluck('inventory_type_id');
        $room_types = room_type::whereIn('id_room_types', $decode)->get();

        return view('hotel_rates.edit', compact('room_types', 'room_rates', 'service_vendors'));
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
            'room_type' => 'required',
            'cost_price' => 'required',
            'selling_price' => 'required',
        ]);
        try {
            $dec_id = Crypt::decrypt($id);
            $hotel_id = Crypt::decrypt($request->h_id);
            // dd($dec_id);
            $store = hotel_rate::where('id_hotel_rates', $dec_id)->first();
            // dd($store);
            $store->from_date = $request->from_date;
            $store->to_date = $request->to_date;
            $store->hotel_id = $hotel_id;
            $store->room_type_id = $request->room_type;
            $store->vendor_id = $request->vendor;
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
        $rate_id = \Crypt::decrypt($id);
        $destroy_hotel = hotel_rate::findOrfail($rate_id);
        $destroy_hotel->delete();
        session()->flash('success', 'Removed Successfully');
        return back();
    }
}
