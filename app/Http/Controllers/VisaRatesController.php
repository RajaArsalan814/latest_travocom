<?php

namespace App\Http\Controllers;

use App\countries;
use App\Http\Controllers\Controller;
use App\service_vendor;
use App\Visa_rates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class VisaRatesController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth');
               
    }

    public function index()
    {

        $visa = Visa_rates::all();
        $vendor = service_vendor::all();
        return view('visa_rate.index', compact('visa', 'vendor'));
    }
    public function create()
    {

        $visa = Visa_rates::all();
        $vendor = service_vendor::all();
        $country = countries::all();

        return view('visa_rate.create', compact('visa', 'vendor'));
    }
    public function store(Request $request)
    {

        // dd($request);
        $store = new Visa_rates;
        $vendor = service_vendor::all();

        $visa = Visa_rates::all();

        $store->name = $request->service_name;
        $store->visa_type = $request->visa_type;
        $store->child_cost_price = $request->child_cost_price;
        $store->child_selling_price = $request->child_selling_price;
        $store->infant_cost_price = $request->infant_cost_price;
        $store->infant_selling_price = $request->infant_selling_price;
        $store->adult_cost_price = $request->adult_cost_price;
        $store->adult_selling_price = $request->adult_selling_price;
        $store->service_vendor_id = $request->vendor_name;
        $store->country_id = $request->country;

        $store->save();
        // dd($store);
        session()->flash('success', "Visa Rate Added Successfully");
        return redirect()->back();
    }

    public function edit($id)
    {
        $dec_id = \Crypt::decrypt($id);
        $edit = Visa_rates::where('id_visa_rates', $dec_id)->first();
        // dd($edit);
        $visa = Visa_rates::all();
        $vendor = service_vendor::all();

        return view('visa_rate.edit', compact('visa', 'vendor', 'edit'));
        // return view('visa_rate.edit', compact('edit'));
    }


    public function update(Request $request)
    {


        $dec_id = \Crypt::decrypt($request->visa_rates_id);
        // dd($dec_id);
        $visa = Visa_rates::all();
        $vendor = service_vendor::all();

        $update = Visa_rates::where('id_visa_rates', $dec_id)->first();

        $update->name = $request->service_name;
        $update->visa_type = $request->visa_type;
        $update->child_cost_price = $request->child_cost_price;
        $update->child_selling_price = $request->child_selling_price;
        $update->infant_cost_price = $request->infant_cost_price;
        $update->infant_selling_price = $request->infant_selling_price;
        $update->adult_cost_price = $request->adult_cost_price;
        $update->adult_selling_price = $request->adult_selling_price;
        $update->service_vendor_id = $request->vendor_name;
        if($request->visa_type=="international"){
            $update->country_id = $request->country;
        }else{
            $update->country_id = "";
        }


        $update->save();
        session()->flash('warning', "Visa Rate Updated Successfully");
        return redirect()->back();
    }
}
