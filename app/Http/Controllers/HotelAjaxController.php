<?php

namespace App\Http\Controllers;

use App\airline_inventory_temp;
use App\hotel_inventory;
use App\hotel_inventory_temp;
use App\hotels;
use App\Http\Controllers\Controller;
use App\room_type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class HotelAjaxController extends Controller
{
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
        $store->created_by = auth()->user()->id;
        $store->save();
        return response()->json([
            'success' => true,
            'message' => "Hotel inventory saved",
        ]);
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
                <input type="number" name="beds" disabled value="'.$room_types->no_of_beds.'" class="form-control"  required="required">

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
                $get_created_by = User::where("id", $hotel_inv->created_by)->first();
                $all_data .= '<tr id="rmv' . $hotel_inv->id_hotel_inventory_temp . '">

                <td>' . $key = $key + 1 . '</td>
                <td>
                <input type="hidden" name="room_type[]" value="' . $hotel_inv->inventory_type_id . '">
                <input type="hidden" name="qty[]" value="' . $hotel_inv->qty . '">
                <input type="hidden" name="cost_price[]" value="' . $hotel_inv->cost_price . '">
                <input type="hidden" name="selling_price[]" value="' . $hotel_inv->selling_price . '">
                ' . $room->name . '
                </td>
                <td>
                    ' . $hotel_inv->qty . '
                </td>
                <td>
                    ' . $hotel_inv->beds . '
                </td>
                <td>
                    ' . $hotel_inv->cost_price . '
                </td>
                <td>
                    ' . $hotel_inv->selling_price . '
                </td>
                <td>
                    ' . $hotel_inv->cost_price*$hotel_inv->qty . '
                </td>
                <td>
                    ' . $hotel_inv->selling_price*$hotel_inv->qty . '
                </td>
                <td>
'.$get_created_by->name.'
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

}
