<?php

namespace App\Http\Controllers;

use App\hotels;
use App\hotel_details;
use App\hotel_inventory;
use App\countries;
use App\hotel_inventory_temp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\inventory_detail;
use App\room_type;
use App\room_types_rate;
use App\service_vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;


class HotelsController extends Controller
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

        //        $this->middleware('auth');
        //               $this->middleware(function ($request, $next) {
        //                   $this->role_id = Auth::user()->role_id;
        //                   $slug_filter = preg_replace('/[0-9]+/', '', $request->path());
        //                   if (checkConstructor($this->role_id, $slug_filter) == 1) {
        //                       return $next($request);
        //                   }else if(strpos($request->path(), 'store') !== false){
        //                       return $next($request);
        //                   }else if(strpos($request->path(), 'update') !== false){
        //                       return $next($request);
        //                   } else {
        //                       abort(404);
        //                   }
        //               });

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = hotels::select('hotels.*', 'hotel_details.hotel_address', 'hotel_details.quint_status', 'hotel_details.quad_status', 'hotel_details.triple_status', 'hotel_details.double_status', 'hotel_details.country', 'hotel_details.hotel_image')->join('hotel_details', 'hotel_details.hotel_id', '=', 'hotels.id_hotels', 'left')->orderBy('hotels.id_hotels', 'DESC')
            ->get()->toArray();
        //        echo '<pre>'; print_r($hotels);exit;
        return view('hotels.index', compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = countries::all();
        $room_types = room_type::all();
        return view('hotels.create', compact('countries', 'room_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'hotel_name' => 'required',
            'hotel_type' => 'required',
            'room_availablity' => 'required',
            'country_city' => 'required'


        ]);
//         dd($request->hotel_category);
        $hotel = new hotels();
        $hotel->hotel_name = $request->hotel_name;
        $hotel->hotel_category = $request->hotel_category;
        $hotel->hotel_type = $request->hotel_type;
        $hotel->save();


        $hotel_id = $hotel->id_hotels;

        $hotel_details = new hotel_details();
        $hotel_details->hotel_id = $hotel_id;
        $hotel_details->hotel_address = $request->hotel_address;
        $hotel_details->room_availablity = json_encode($request->room_availablity);
        $hotel_details->country = $request->country_city;
        $get_city_from_country=explode('-',$request->country_city);
        // dd());
        $hotel_details->city = trim($get_city_from_country[1]);

        if (!empty($request->hotel_image)) {
            $file = $request->file('hotel_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/hotels_images/'), $filename);
            $data['image'] = $filename;
            $hotel_details->hotel_image = $data['image'];
        }
        $hotel_details->save();

        if ($hotel) {
            session()->flash('success', 'Hotel Added Successfully!');

            return redirect()->back();
        } else {
            toastr()->error('An error has occurred please try again later.');
            //            session()->flash('error', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(hotel $hotel)
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
        $room_types = room_type::where('status', 'Active')->get();
        $edit_hotel = hotels::select('hotels.*', 'hotel_details.hotel_address', 'hotel_details.room_availablity', 'hotel_details.quad_status', 'hotel_details.triple_status', 'hotel_details.double_status', 'hotel_details.country', 'hotel_details.hotel_image')->join('hotel_details', 'hotel_details.hotel_id', '=', 'hotels.id_hotels', 'left')->orderBy('hotels.id_hotels', 'DESC')
            ->where('hotels.id_hotels', $dec_id)->first();

        //        echo '<pre>';print_r($edit_hotel);exit;
        return view('hotels.edit', compact('edit_hotel', 'countries', 'room_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //        echo 'working';exit;
        $request->validate([
            'hotel_name' => 'required',
            'hotel_type' => 'required',
            'room_availablity' => 'required',
            'country_city' => 'required'


        ]);
//         dd($request->hotel_category);

        $dec_id = \Crypt::decrypt($request->h_id);

        //            echo $dec_id;exit;
        $hotel = hotels::where('id_hotels', $dec_id)->first();
        //             dd($hotel);
        $hotel->hotel_name = $request->hotel_name;
        $hotel->hotel_type = $request->hotel_type;
        $hotel->hotel_category = $request->hotel_category;
        $hotel->hotel_status = $request->hotel_status;
        $hotel->save();


        $hotel_details = hotel_details::where('hotel_id', $dec_id)->first();

        $hotel_details->hotel_address = $request->hotel_address;
        $hotel_details->room_availablity = json_encode($request->room_availablity);
        $hotel_details->country = $request->country_city;
        $get_city_from_country=explode('-',$request->country_city);
        // dd());
        $hotel_details->city = trim($get_city_from_country[1]);

        if (!empty($request->hotel_image)) {
            $file = $request->file('hotel_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/hotels_images/'), $filename);
            $data['image'] = $filename;
            $hotel_details->hotel_image = $data['image'];
        }
        $hotel_details->save();
        if ($hotel) {
            session()->flash('success', 'Hotel Updated Successfully!');

            return redirect()->back();
        } else {
            toastr()->error('An error has occurred please try again later.');
            return redirect()->back();
        }
    }

    public function inventory($id, Request   $request)
    {

        $hotel_id = \Crypt::decrypt($id);

        $hotel = hotels::select()->where('id_hotels', $hotel_id)->first();
        $hotel_inventory = hotel_inventory::select()->where('hotel_id', $hotel_id)->get();
        $all_data = "";
        if ($request->ajax()) {
            $hotel_inventory = hotel_inventory_temp::select()->where('hotel_id', $hotel_id)->get();
            foreach ($hotel_inventory as $key => $hotel_inv) {
                $room = room_type::where("id_room_types", $hotel_inv->inventory_type_id)->first();
                $all_data .= '<tr id="rmv' . $hotel_inv->id_hotel_inventory_temp . '">

                <td>' . $key = $key + 1 . '</td>
                <td>
                <input type="hidden" name="room_type[]" value="' . $hotel_inv->inventory_type_id . '">
                <input type="hidden" name="qty[]" value="' . $hotel_inv->qty . '">
                <input type="hidden" name="cost_price[]" value="' . $hotel_inv->cost_price . '">
                <input type="hidden" name="selling_price[]" value="' . $hotel_inv->selling_price . '">
                <input type="hidden" name="beds[]" value="' . $hotel_inv->beds . '">

                ' . $room->name . '
                </td>
                <td>
                    ' . $hotel_inv->qty . '
                </td>
                <td>
                    ' . $hotel_inv->cost_price . '
                </td>
                <td>
                    ' . $hotel_inv->selling_price . '
                </td>
                <td>
                    ' . $hotel_inv->beds . '
                </td>
                <td>
                    Super Admin
                </td>
                <td>' . date("d-m-Y", strtotime($hotel_inv->created_at)) . '</td>

                <td><button type="button"
                        onClick="delete_btn(' . $hotel_inv->id_hotel_inventory . ',' . $hotel->id_hotels . ')"
                        class="btn btn-rounded btn-danger" href="#">
                        Delete
                    </button>
            </tr>';
            };

            return response()->json([
                'data' => $all_data,
            ]);
        }
        return view('hotels.inventory', compact('hotel', 'hotel_inventory'));
    }
    public function save_inventory(Request $request)
    {

        $hotel_id = \Crypt::decrypt($request->h_id);
        $store = new hotel_inventory_temp();
        $store->hotel_id = $hotel_id;
        $store->inventory_type = "room";
        $store->inventory_type_id = $request->room_type;
        $store->qty = $request->qty;
        $store->cost_price = $request->c_price;
        $store->selling_price = $request->s_price;
        $store->beds = $request->beds;
        $store->save();
        return response()->json([
            'success' => true,
            'message' => "Hotel inventory saved",
        ]);
    }

    public function inventory_create($id, Request $request)
    {
        $vendors = service_vendor::where('vendor_status', 1)->get();
        // dd($decode);

        // dd($decode);
        if ($request->ajax()) {
            $hotel_id = $id;
            // dd($hotel_id);
            $hotel_details = hotel_details::where('hotel_id', $hotel_id)->first();

            $hotel_inventory = hotel_inventory_temp::where('hotel_id', $hotel_id)->get();
            $decode = json_decode($hotel_details->room_availablity);
            if ($decode == null) {
                $decode = [];
            }
            $existing_inventory = hotel_inventory_temp::where('hotel_id', $hotel_id)->groupBy('inventory_type_id')->pluck('inventory_type_id');
            $room_types = room_type::whereIn('id_room_types', $decode)->whereNotIn('id_room_types', $existing_inventory)->get();

            $data = "";
            foreach ($room_types as $key => $item) {
                $data .= '  <option value=' . $item->id_room_types . '">' . $item->name . '</option>';
            }
            return response()->json([
                "data" => $data,
            ]);
            // dd($room_types);
        } else {
            $hotel_id = \Crypt::decrypt($id);

            $hotel_details = hotel_details::where('hotel_id', $hotel_id)->first();

            $hotel_inventory = hotel_inventory_temp::select()->where('hotel_id', $hotel_id)->get();
            $decode = json_decode($hotel_details->room_availablity);
            if ($decode == null) {
                $decode = [];
            }
            $existing_inventory = hotel_inventory_temp::where('hotel_id', $hotel_id)->groupBy('inventory_type_id')->pluck('inventory_type_id');
            $room_types = room_type::whereIn('id_room_types', $decode)->whereNotIn('id_room_types', $existing_inventory)->get();
            // dd($room_types);
            // dd($room_types);
            $hotel = hotels::where('id_hotels', $hotel_id)->first();
        }

        return view('hotels.inventory_create', compact('hotel', 'room_types', 'hotel_inventory','vendors'));
    }
    public function get_room_type($id)
    {
        // dd(request()->edit);
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
            $room_types = room_type::where('id_room_types', $id)->first();
            $room_type_name = $room_types->name;
            if ($room_types->no_of_beds == null) {
                $data = '  <h3 class="mt-4"> Select Inventory Of ' . $room_types->name . '</h3><div class="col-md-3">
                <div class="form-group">
                    <label class="az-content-label tx-11 tx-medium tx-gray-600">No Of Rooms</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Qty</span>
                        </div>
                        <input type="number" name="qty" class="form-control"  required="required">

                    </div><!-- input-group -->

                </div>
            </div>
            <div class="col-md-3">
            <div class="form-group">
            <label class="az-content-label tx-11 tx-medium tx-gray-600">No Of Beds</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Qty</span>
                </div>
                <input type="number" name="beds" class="form-control"  required="required">

            </div><!-- input-group -->

        </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="az-content-label tx-11 tx-medium tx-gray-600">' . $room_types->name . ' Cost Price</label>
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
            <div class="col-md-3">
                <div class="form-group">
                    <label class="az-content-label tx-11 tx-medium tx-gray-600">' . $room_types->name . ' Selling Price</label>
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
            } else {
                $data = '  <h3 class="mt-4"> Select Inventory Of ' . $room_types->name . '</h3><div class="col-md-3">
                <div class="form-group">
                    <label class="az-content-label tx-11 tx-medium tx-gray-600">No Of Rooms</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Qty</span>
                        </div>
                        <input type="number" name="qty" class="form-control"  required="required">

                    </div><!-- input-group -->

                </div>
            </div>
            <div class="col-md-3">
            <div class="form-group">
            <label class="az-content-label tx-11 tx-medium tx-gray-600">No Of Beds</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Qty</span>
                </div>
                <input type="number" name="beds" disabled value="' . $room_types->no_of_beds . '" class="form-control"  required="required">

            </div><!-- input-group -->

        </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="az-content-label tx-11 tx-medium tx-gray-600">' . $room_types->name . ' Cost Price</label>
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
            <div class="col-md-3">
                <div class="form-group">
                    <label class="az-content-label tx-11 tx-medium tx-gray-600">' . $room_types->name . ' Selling Price</label>
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
            }

            return response()->json([
                "data" => $data,
                "name" => $room_type_name
            ]);
        }

        // dd($hotel_inventory);

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
            $hotel_inventory->batch_number = $request->batch_number;
            $hotel_inventory->from_date = $request->from_date;
            $hotel_inventory->vendor_id = $request->vendor;

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
                'from_date' => 'required',
                'to_date' => 'required',
                // 'qty' => 'required',
                // 'cost_price' => 'required',
                // 'selling_price' => 'required',
                // 'room_type' => 'required',
            ]);

            $hotel_id = \Crypt::decrypt($request->h_id);
            $hotel_inventory = new hotel_inventory();
            $hotel_inventory->vendor_id = $request->vendor;
            $hotel_inventory->hotel_id = $hotel_id;
            $hotel_inventory->batch_number = $request->batch_number;
//            dd($request);
//            dd($request->room_type);
            $total_size = sizeof($request->room_type);
            for ($i = 0; $i < $total_size; $i++) {
                $all_entries[] = array(
                    'room_type' => $request->room_type[$i],
                    'qty' => $request->qty[$i],
                    'beds' => $request->beds[$i],
                    'cost_price' => $request->cost_price[$i],
                    'selling_price' => $request->selling_price[$i],
                );
                $inventory_delete_temp = hotel_inventory_temp::where('hotel_id', $hotel_id)->first();
                $inventory_delete_temp->delete();
            }

            $hotel_inventory->from_date = $request->from_date;
            $hotel_inventory->to_date = $request->to_date;
            $hotel_inventory->total_entries = json_encode($all_entries);
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
            $room_types = room_type::where('id_room_types', $request->room_type_val)->first();

            if ($hotel_inventory) {
                session()->flash('success', 'New Inventory Added');

                return redirect()->back();
            } else {
                toastr()->error('An error has occurred please try again later.');
                return redirect()->back();
            }
        }
    }

    public function inventory_edit($id, $hotel_id)
    {
        $hotel = hotels::where('id_hotels', $hotel_id)->first();
        $hotel_inventory = hotel_inventory::select('*')->where('id_hotel_inventory', $id)->first();
        $hotel_details = hotel_details::where('hotel_id', $hotel_id)->first();
        $decode = json_decode($hotel_details->room_availablity);
        if ($decode == null) {
            $decode = [];
        }
        // dd($decode);
        $room_types = room_type::whereIn('id_room_types', $decode)->get();
        //        echo '<pre>'; print_r($hotel_inventory);exit;
        return view('hotels.inventory_edit', compact('hotel', 'hotel_inventory', 'room_types'));
    }

    public function inventory_update(Request $request)
    {

        $request->validate([
            'batch_number' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'qty' => 'required',
            'cost' => 'required',
            's_price' => 'required',
            'room_type' => 'required',
        ]);

        $hotel_inv_id = \Crypt::decrypt($request->h_id);
        $hotel_inventory = hotel_inventory::where(['id_hotel_inventory' => $hotel_inv_id])->first();
        $hotel_inventory->from_date = $request->from_date;
        $hotel_inventory->to_date = $request->to_date;
        $hotel_inventory->qty = $request->qty;
        $hotel_inventory->cost_price = $request->cost;
        $hotel_inventory->selling_price = $request->s_price;


        if (!empty($request->attachments)) {
            $file = $request->file('attachments');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/hotels_inventory/'), $filename);
            $data['image'] = $filename;
            $hotel_inventory->attachments = $data['image'];
        }
        $hotel_inventory->save();

        if ($hotel_inventory) {
            session()->flash('success', 'Inventory Updated!');

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
        $hotel_id = \Crypt::decrypt($id);
        $destroy_hotel = hotels::findOrfail($hotel_id);
        $destroy_hotel->delete();
        session()->flash('success', 'Hotel Removed!');
        return back();
    }
    public function inventory_delete($id, $id_hotel)
    {
        // dd($id .'/'. $id_hotel);
        $destroy_hotel = hotel_inventory_temp::where(['hotel_id' => $id_hotel, 'id_hotel_inventory_temp' => $id])->first();
        //    dd($destroy_hotel);
        $destroy_hotel->delete();
        // session()->flash('success', 'Inventory Removed!');
        return response()->json([
            'message' => 'Inventory Removed'
        ]);
        return back();
    }
    public function inventory_destroy($id, $id_hotel)
    {
        // dd($id .'/'. $id_hotel);
        $inv_id = Crypt::decrypt($id);
        $hotel_id = Crypt::decrypt($id_hotel);
        $destroy_hotel = hotel_inventory::where(['hotel_id' => $hotel_id, 'id_hotel_inventory' => $inv_id])->first();
        //    dd($destroy_hotel);
        $destroy_hotel->delete();
        session()->flash('success', 'Inventory Removed!');

        return back();
    }
    public function new_save_btn_ajax()
    {
    }
}
