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

class Land_services_typesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
               
    }
   public function index()
   {
      $land_services_types = land_services_type::all();
      return view('land_services_types.index', compact('land_services_types'));
   }
   public function create()
   {
      $land_services_types = land_services_type::all();
      return view('land_services_types.create', compact('land_services_types'));
   }
   public function store(Request $request)
   {
      //   $request->validate([
      //       'service_name  ' => 'required',
      //       'service_type' => 'required',
      //   ]);
      $store = new land_services_type();
      $store->service_name = $request->service_name;
      $store->service_type = json_encode($request->service_type);
      $store->save();
      session()->flash('success', "Land Services Types Added Succcessfully");
      return redirect()->back();
   }

   public function edit($id)
   {
      $dec_id = \Crypt::decrypt($id);
      $edit = land_services_type::all();
      $edit = land_services_type::where('id_land_services_types', $dec_id)->first();

      return view('land_services_types.edit', compact('edit'));
   }

   public function update(Request $request ,$id)
   {
      //   $request->validate([
      //       'service_name  ' => 'required',
      //       'service_type' => 'required',
      //   ]);
      $dec_id = \Crypt::decrypt($id);
      $update = land_services_type::where('id_land_services_types', $dec_id)->first();
      $update->service_name = $request->service_name;
      $update->service_type = json_encode($request->service_type);
      $update->status=$request->status;
      $update->save();
      session()->flash('success', "Land Services Types Edited Succcessfully");
      return redirect()->back();
   }

}
