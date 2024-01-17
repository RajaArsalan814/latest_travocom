<?php

namespace App\Http\Controllers;

use App\airline_flight_class;
use App\airline_inventory;
use App\airline_inventory_temp;
use App\airlines;
use App\countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\service_vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;


class AirlinesController extends Controller
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
     */
    public function index()
    {
        $airlines = airlines::orderBy('id_airlines', 'desc')->orderBy('Airline', 'asc')->get();
        return view('airlines.index', compact('airlines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = countries::all();
        return view('airlines.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'airline_name' => 'required',
            'airline_country' => 'required',
            'airline_short_code' => 'required'
        ]);

        $airline = new airlines();
        $airline->Airline     = $request->airline_name;
        $airline->Country = $request->airline_country;
        $airline->ICAO = $request->airline_short_code;
        if (!empty($request->airline_image)) {
            $file = $request->file('airline_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/airlines_images/'), $filename);
            $data['image'] = $filename;
            $airline->airline_image = $data['image'];
        }
        $airline->save();

        if ($airline) {
            session()->flash('success', 'Airline Added Successfully!');

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
        $edit_airline = airlines::where('id_airlines', $dec_id)->first();
        return view('airlines.edit', compact('edit_airline'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //        echo 'working';exit;
        $request->validate([
            'airline_name' => 'required',
            'airline_country' => 'required'
        ]);
        // dd($request);

        $dec_id = \Crypt::decrypt($request->a_id);

        //            echo $dec_id;exit;
        $airline = airlines::where('id_airlines', $dec_id)->first();
        //             dd($airline);
        $airline->Airline     = $request->airline_name;
        $airline->Country = $request->airline_country;
        $airline->ICAO = $request->airline_short_code;
        $airline->airline_status = $request->airline_status;
        if (!empty($request->airline_image)) {
            $file = $request->file('airline_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/airlines_images/'), $filename);
            $data['image'] = $filename;
            $airline->airline_image = $data['image'];
        }
        $airline->save();
        if ($airline) {
            session()->flash('success', 'Airline Updated Successfully!');

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
    public function inventory($id, Request $request)
    {
        $airline_id = \Crypt::decrypt($id);

        $airline = airlines::select()->where('id_airlines', $airline_id)->first();
        $airline_inventory = airline_inventory::select()->where('airline_id', $airline_id)->get();
        $all_data = "";
        if ($request->ajax()) {
            $airline_inventory = airline_inventory_temp::select()->where('airline_id', $airline_id)->get();
            foreach ($airline_inventory as $key => $airline_inv) {
                $all_data .= '<tr id="rmv' . $airline_inv->id_airline_inventory_temp . '">

                <td>' . $key = $key + 1 . '</td>
                <td>
                <input type="hidden" name="flight_class[]" value="' . $airline_inv->flight_class . '">
                <input type="hidden" name="qty[]" value="' . $airline_inv->qty . '">
                <input type="hidden" name="cost_price[]" value="' . $airline_inv->cost_price . '">
                <input type="hidden" name="selling_price[]" value="' . $airline_inv->selling_price . '">


                ' . $airline_inv->flight_class . '
                </td>
                <td>
                    ' . $airline_inv->qty . '
                </td>
                <td>
                    ' . $airline_inv->cost_price . '
                </td>
                <td>
                    ' . $airline_inv->selling_price . '
                </td>

                <td>
                    Super Admin
                </td>
                <td>' . date("d-m-Y", strtotime($airline_inv->created_at)) . '</td>

                <td><button type="button"
                        onClick="delete_btn(' . $airline_inv->id_airline_inventory_temp . ',' . $airline_inv->airline_id . ')"
                        class="btn btn-rounded btn-danger" href="#">
                        Delete
                    </button>
            </tr>';
            };

            return response()->json([
                'data' => $all_data,
            ]);
        }
        return view('airlines.airline_inventory', compact('airline', 'airline_inventory'));
    }
    // Airline Inventory Work
    public function inventory_create($id, Request $request)
    {
        //         dd($id);
        $vendors = service_vendor::where('vendor_status', 1)->get();
        //         dd($decode);
        if ($request->ajax()) {

            if (is_numeric($id)) {
                $airline_id = $id;
            } else {
                $airline_id = Crypt::decrypt($id);
            }
            //             dd($airline_id);
            $flight_class_temp_ajax = airline_inventory_temp::select()->where('airline_id', $airline_id)->pluck('flight_class')->groupBy('flight_class')->toArray();

            // dd($flight_class_temp_ajax);
            $get_flight_class_ajax = airline_flight_class::whereNotIn('flight_class', $flight_class_temp_ajax)->get();
            // dd($get_flight_class_ajax);
            $data = "";
            foreach ($get_flight_class_ajax as $key => $item) {
                $data .= '  <option value=' . $item->flight_class . '>' . $item->flight_class . '</option>';
            }
            return response()->json([
                "data" => $data,
            ]);
            // dd($room_types);
        } else {
            $airline_id = \Crypt::decrypt($id);
            $countries = countries::all();
            $airline = airlines::where('id_airlines', $airline_id)->first();
            // dd($airline_id);

            $flight_class_temp = airline_inventory_temp::select()->where('airline_id', $airline_id)->pluck('flight_class')->groupBy('flight_class')->toArray();

            // dd($flight_class_temp);
            $airlrine_inventory = airline_inventory_temp::select()->where('airline_id', $airline_id)->get();
            $get_flight_class = airline_flight_class::whereNotIn('flight_class', $flight_class_temp)->get();
            // dd($get_flight_class);
            // $decode = json_decode($hotel_details->room_availablity);
            // if ($decode == null) {
            //     $decode = [];
            // }
            // $existing_inventory = hotel_inventory_temp::where('hotel_id', $hotel_id)->groupBy('inventory_type_id')->pluck('inventory_type_id');
            // $room_types = room_type::whereIn('id_room_types', $decode)->whereNotIn('id_room_types', $existing_inventory)->get();
            // dd($room_types);
            // dd($room_types);
            // $hotel = hotels::where('id_hotels', $hotel_id)->first();
        }

        return view('airlines.inventory_create', compact('airline', 'airlrine_inventory', 'get_flight_class', 'countries','vendors'));
    }
    public function save_inventory(Request $request)
    {

        $airline_id = \Crypt::decrypt($request->h_id);
        $store = new airline_inventory_temp();
        $store->airline_id = $airline_id;
        $store->flight_class = $request->flight_class;
        $store->qty = $request->qty;
        $store->cost_price = $request->c_price;
        $store->selling_price = $request->s_price;
        $store->save();
        return response()->json([
            'success' => true,
            'message' => "Hotel inventory saved",
        ]);
    }


    public function get_room_type($id)
    {
        // dd("sds");
        if (request()->edit == "edit") {
            $hotel_id = \Crypt::decrypt(request()->h_id);
            // dd($hotel_id);
            $hotel_inventory = hotel_inventory::where(['hotel_id' => $hotel_id, "inventory_type" => "room", 'inventory_type_id' => $id])->first();
            $room_types = room_type::where('id_room_types', $id)->first();
            echo '<div class="col-md-3">

            <div class="form-group">
                <label class="az-content-label tx-11 tx-medium tx-gray-600">' . $room_types->name . ' Quantity</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Qty</span>
                    </div>
                    <input type="number" name="qty" class="form-control" value="' . $hotel_inventory->qty . '" required="required">

                </div><!-- input-group -->

            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="az-content-label tx-11 tx-medium tx-gray-600">' . $room_types->name . ' Cost</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">AMOUNT</span>
                    </div>
                    <input type="text" name="cost" class="form-control" value="' . $hotel_inventory->cost_price . '" required="required">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div><!-- input-group -->

            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="az-content-label tx-11 tx-medium tx-gray-600">' . $room_types->name . ' Price</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">AMOUNT</span>
                    </div>
                    <input type="text" name="s_price" value="' . $hotel_inventory->selling_price . '" class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div><!-- input-group -->

            </div>
        </div>
        <hr>';
        } else {


            $data = '<h3 class="mt-4"> Select Inventory Of ' . $id . '</h3><div class="col-md-3">
            <div class="form-group">
                <label class="az-content-label tx-11 tx-medium tx-gray-600">No Of Tickets</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Qty</span>
                    </div>
                    <input type="number" name="qty" class="form-control"  required="required">

                </div><!-- input-group -->

            </div>
        </div>

        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="az-content-label tx-11 tx-medium tx-gray-600">' . $id  . ' Cost Price</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">AMOUNT</span>
                    </div>
                    <input type="text" name="cost" class="form-control"  required="required">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div><!-- input-group -->

            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="az-content-label tx-11 tx-medium tx-gray-600">' . $id  . ' Selling Price</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">AMOUNT</span>
                    </div>
                    <input type="text" name="s_price"  class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div><!-- input-group -->

            </div>
        </div>

</div>
<div class="row">
<div class="col-md-12"  style="text-align:right;">
<button id="save_btn_temp" onclick="save_btn()" type="button" class="btn btn-az-primary">Save</button>
</div>
</div>
        <hr>
        ';
            return response()->json([
                "data" => $data,
                "name" => $id
            ]);
        }

        // dd($hotel_inventory);

    }
    public function inventory_delete($id, $id_airline)
    {
        // dd($id .'/'. $id_airline);
        $destroy_airline = airline_inventory_temp::where(['airline_id' => $id_airline, 'id_airline_inventory_temp' => $id])->first();
        //    dd($destroy_hotel);
        $destroy_airline->delete();
        // session()->flash('success', 'Inventory Removed!');
        return response()->json([
            'message' => 'Inventory Removed'
        ]);
        return back();
    }
    public function inventory_destroy($id, $id_airline)
    {
        // dd($id .'/'. $id_airline);
        $inv_id = Crypt::decrypt($id);
        $airline_id = Crypt::decrypt($id_airline);
        $destroy_hotel = airline_inventory::where(['airline_id' => $airline_id, 'id_airline_inventory' => $inv_id])->first();
        //    dd($airline_id);
        $destroy_hotel->delete();
        session()->flash('success', 'Inventory Removed!');

        return back();
    }

    public function autocomplete(Request $request)
    {

        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            // dd($search);
            $data = Countries::join('cities', 'countries.id_countries', '=', 'cities.country_id')->orwhere("countries.country_name", 'LIKE', '%' . $search)->orwhere("cities.name", 'LIKE', '%' . $search)->select('countries.country_name', 'cities.name')->get();
            // dd($data);
        }
        return response()->json($data);
        // $query = $request->get('query');
        // // dd($query);
        // $data=Countries::join('cities','countries.id_countries','=','cities.country_id')->orwhere("countries.country_name",'LIKE','%'.$query)->orwhere("cities.name",'LIKE','%'.$query)->select('countries.country_name','cities.name')->get();
        // // dd($join_country_city);
        // // $users = User::join('posts', 'users.id', '=', 'posts.user_id')
        // //        ->get(['users.*', 'posts.descrption']);
        // // $data = countries::where("name", "LIKE", $query)->select('name')
        // //     ->get();
        // return response()->json($data);
    }
    public function inventory_store(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            $request->validate([
                'batch_number' => 'required',
                'from_date' => 'required',
                'to_date' => 'required',
                'qty' => 'required',
                'cost' => 'required',
                's_price' => 'required',
                'room_type_val' => 'required',
            ]);
            //  dd($request);

            $hotel_id = \Crypt::decrypt($request->h_id);
            $hotel_inventory = new hotel_inventory_temp();
            $hotel_inventory->hotel_id = $hotel_id;
            $hotel_inventory->vendor_id = $request->vendor;
            $hotel_inventory->batch_number = $request->batch_number;
            $hotel_inventory->from_date = $request->from_date;
            $hotel_inventory->flight_no = $request->flight_no;

            $hotel_inventory->to_date = $request->to_date;
            $hotel_inventory->created_by = auth()->user()->id;
            $hotel_inventory->qty = $request->qty;
            $hotel_inventory->cost_price = $request->cost;
            $hotel_inventory->selling_price = $request->s_price;
            $hotel_inventory->inventory_type = "room";
            $hotel_inventory->inventory_type_id = $request->room_type_val;

            // dd($hotel_rates->id);
            if (!empty($request->attachments)) {
                $file = $request->file('attachments');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move(public_path('uploads/hotels_inventory/'), $filename);
                $data['image'] = $filename;
                $hotel_inventory->attachments = $data['image'];
            }
            $hotel_inventory->save();
            $room_types = room_type::where('id_room_types', $request->room_type_val)->first();

            if ($hotel_inventory) {
                // session()->flash('success', 'New Inventory Added');
                return response()->json([
                    'message' => 'New Inventory Added',
                    'name' => $room_types->name,
                ]);
                return redirect()->back();
            } else {
                toastr()->error('An error has occurred please try again later.');
                return redirect()->back();
            }
        } else {
            // dd($request);
            $request->validate([
                'batch_number' => 'required',
                'arival_date' => 'required',
                'departure_date' => 'required',
                'qty' => 'required',
                'cost_price' => 'required',
                'selling_price' => 'required',
                'flight_class' => 'required',
            ]);

            $airline_id = \Crypt::decrypt($request->h_id);
            // dd($airline_id);
            $hotel_inventory = new airline_inventory();
            $hotel_inventory->airline_id = $airline_id;
            $hotel_inventory->vendor_id = $request->vendor;
            $hotel_inventory->batch_no = $request->batch_number;
            $hotel_inventory->flight_no = $request->flight_no;
            $total_size = sizeof($request->flight_class);
            for ($i = 0; $i < $total_size; $i++) {
                $all_entries[] = array(
                    'flight_class' => $request->flight_class[$i],
                    'qty' => $request->qty[$i],
                    'cost_price' => $request->cost_price[$i],
                    'selling_price' => $request->selling_price[$i],
                );
                $inventory_delete_temp = airline_inventory_temp::where('airline_id', $airline_id)->first();
                $inventory_delete_temp->delete();
            }

            $hotel_inventory->arrival_date = $request->arival_date;
            $hotel_inventory->departure_date = $request->departure_date;
            $hotel_inventory->arrival_destination = $request->arrival_destination;
            // $hotel_inventory->arrival_from_city = $request->arrival_from_city;
            $hotel_inventory->departure_destination = $request->departure_destination;
            // $hotel_inventory->departure_to_city = $request->departure_to_city;
            $hotel_inventory->mid_destination = $request->mid_destination;
            // $hotel_inventory->mid_destination_city = $request->mid_destination_city;
            $hotel_inventory->all_entries = json_encode($all_entries);
            $hotel_inventory->created_by = auth()->user()->id;


            // dd($hotel_rates->id);
            if (!empty($request->attachments)) {
                $file = $request->file('attachments');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move(public_path('uploads/hotels_inventory/'), $filename);
                $data['image'] = $filename;
                $hotel_inventory->attachments = $data['image'];
            }
            $hotel_inventory->save();
            // $room_types = room_type::where('id_room_types', $request->room_type_val)->first();

            if ($hotel_inventory) {
                session()->flash('success', 'New Inventory Added');

                return redirect()->back();
            } else {
                toastr()->error('An error has occurred please try again later.');
                return redirect()->back();
            }
        }
    }
}
