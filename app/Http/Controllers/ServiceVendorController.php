<?php

namespace App\Http\Controllers;

use App\service_vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class ServiceVendorController extends Controller
{
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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendors = service_vendor::all();
        return view('vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vendor_name' => 'required',
            'primary_contact' => 'required',
            'vendor_address' => 'required'
        ]);
        // dd($request);
        $vendor = new service_vendor();
        $vendor->vendor_name = $request->vendor_name;
        $vendor->business_type = 1;
        $vendor->primary_contact = $request->primary_contact;
        $vendor->secondory_contact = $request->secondory_contact;
        $vendor->other_contact = $request->other_contact;
        $vendor->vendor_address = $request->vendor_address;

        $country_city = $request->country_city;
        $contact_name = $request->contact_name;
        $contact_phone = $request->contact_phone;
        $size_of = sizeof($country_city);
        for ($i = 0; $i < $size_of; $i++) {
            $city = $country_city[$i];
            $c_name = $contact_name[$i];
            $c_phone = $contact_phone[$i];
            $details[] = [
                'city' => $city,
                'c_name' => $c_name,
                'c_phone' => $c_phone,
            ];
        }
        $encode_details = json_encode($details);
        $vendor->country_person_details = $encode_details;
        if (!empty($request->vendor_image)) {
            $file = $request->file('vendor_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/vendor_images/'), $filename);
            $data['image'] = $filename;
            $vendor->vendor_image = $data['image'];
        }
        $vendor->save();

        if ($vendor) {
            session()->flash('success', 'Vendor Added Successfully!');

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
    public function show(service_vendor $service_vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dec_id = \Crypt::decrypt($id);
        $edit_vendor = service_vendor::where('id_service_vendors', $dec_id)->first();
        return view('vendors.edit', compact('edit_vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //        echo 'working';exit;
        $request->validate([
            'vendor_name' => 'required',
            'primary_contact' => 'required',
            'vendor_address' => 'required'
        ]);


        $dec_id = $request->v_id;
        $vendor = service_vendor::where('id_service_vendors', $dec_id)->first();
        //             dd($vendor);
        $vendor->vendor_name = $request->vendor_name;
        $vendor->business_type = 1;
        $vendor->primary_contact = $request->primary_contact;
        $vendor->secondory_contact = $request->secondory_contact;
        $vendor->other_contact = $request->other_contact;
        $vendor->vendor_address = $request->vendor_address;

        $country_city = $request->country_city;
        $contact_name = $request->contact_name;
        $contact_phone = $request->contact_phone;
        $size_of = sizeof($country_city);
        for ($i = 0; $i < $size_of; $i++) {
            $city = $country_city[$i];
            $c_name = $contact_name[$i];
            $c_phone = $contact_phone[$i];
            $details[] = [
                'city' => $city,
                'c_name' => $c_name,
                'c_phone' => $c_phone,
            ];
        }
        $encode_details = json_encode($details);
        $vendor->country_person_details = $encode_details;
        if (!empty($request->vendor_image)) {
            $file = $request->file('vendor_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/vendor_images/'), $filename);
            $data['image'] = $filename;
            $vendor->vendor_image = $data['image'];
        }
        $vendor->save();

        if ($vendor) {
            session()->flash('success', 'Vendor Added Successfully!');

            return redirect()->back();
        } else {
            toastr()->error('An error has occurred please try again later.');
            //            session()->flash('error', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vendor_id = \Crypt::decrypt($id);
        $destroy_vendor = service_vendor::findOrfail($vendor_id);
        $destroy_vendor->delete();
        session()->flash('success', 'Vendor Removed!');
        return back();
    }
}
