<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\land_services_type;
use Illuminate\Http\Request;
use App\Landservicestypes;
use App\Route;
use App\service_vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LandservicestypesController extends Controller
{
    protected $role_id;
    public function __construct()
    {
        $this->middleware('auth');
               
    }
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware(function ($request, $next) {
    //         $this->role_id = Auth::user()->role_id;
    //         //    $slug_filter = preg_replace('/[0-9]+/', '', $request->path());
    //         //    $slug_filter = preg_replace('/[0-9]+/', '', $request->path());
    //         $ex = explode('/', $request->path());
    //         if (count($ex) >= 3) {
    //             $sliced = array_slice($ex, 0, -1);
    //         } else {
    //             $sliced = $ex;
    //         }

    //         $string = implode("/", $sliced);
    //         //                 dd($string);
    //         if (checkConstructor($this->role_id, count($ex) >= 3 ? $string . '/' : $string) == 1) {
    //             return $next($request);
    //         } else if (strpos($request->path(), 'store') !== false) {
    //             return $next($request);
    //         } else if (strpos($request->path(), 'update') !== false) {
    //             return $next($request);
    //         } else {
    //             abort(404);
    //         }
    //     });

    // }

    public function index()
    {
        $landservicestypes = Landservicestypes::all();
//        dd($landservicestypes);
        return view('landservicestypes.index', compact('landservicestypes'));
    }
    public function create()
    {

        $land_services_type = land_services_type::where('status', 1)->get();
        $routes = Route::where('status', 1)->get();
        $vendors = service_vendor::where('vendor_status', 1)->get();

        return view('landservicestypes.create', compact('land_services_type', 'vendors', 'routes'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $store = new Landservicestypes;
        $get_transport_type = $request->transport_type;
//        $get_size = sizeof($request->transport);
        
                $allentries[] = [
                    'transport' => $request->transport,
                    'route_id' => $request->route,
                    'vendor' => $request->vendor,
                    'cost_price' => $request->cost_price,
                    'selling_price' => $request->selling_price,
                ];
            
        

//         dd($allentries);

        $store->name = $request->name;
        $store->service_type = $request->service_type;
        $store->total_entries = json_encode($allentries);
        $store->save();

        if ($store) {
            session()->flash('success', 'New Land Service Added');

            return redirect('land_services');
        } else {
            toastr()->error('An error has occurred please try again later.');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $dec_id = \Crypt::decrypt($id);
        
        $get_edit_data = Landservicestypes::where('id_land_and_services_types', $dec_id)->first();
//         dd( $get_edit_data );
        $landservicestypes = Landservicestypes::all();

        $land_services_type = land_services_type::where('status', 1)->get();
        $routes = Route::where('status', 1)->get();
        $vendors = service_vendor::where('vendor_status', 1)->get();

        return view('landservicestypes.edit', compact('landservicestypes' , 'get_edit_data','land_services_type' , 'routes' , 'vendors'));
    }

    public function update(Request $request, $id)
    {
        $dec_id = \Crypt::decrypt($id);
//         dd($dec_id);
        // $update = Landservicestypes::all();
        $update = Landservicestypes::where('id_land_and_services_types', $dec_id)->first();
        // dd($update);
       $get_transport_type = $request->transport_type;
//        $get_size = sizeof($request->transport);
        
                $allentries[] = [
                    'transport' => $request->transport,
                    'route_id' => $request->route,
                    'vendor' => $request->vendor,
                    'cost_price' => $request->cost_price,
                    'selling_price' => $request->selling_price,
                ];
            
        

//         dd($allentries);

        $update->name = $request->name;
        $update->service_type = $request->service_type;
        $update->total_entries = json_encode($allentries);
        $update->save();

        session()->flash('success', "Land Service  Updated Succcessfully");
        return redirect()->back();
    }
    public function append_land_services($v_id)
    {
        $land_services_type = land_services_type::where('id_land_services_types', $v_id)->first();
        $options = "<option value=''>Select</option>";
        $encode = json_decode($land_services_type->service_type);
        foreach ($encode as $key => $value) {
            $options .= "<option value='" . $value . "'>" . $value . "</option>";
        }
        return response()->json([
            'services' => $options,
        ]);
    }
}
