<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Addons;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;



class AddonsController extends Controller
{
    // protected $role_id;
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

        $addons = Addons::all();
        return view('addon.index', compact('addons'));
    }
    public function create()
    {

        $addons = Addons::all();
        return view('addon.create', compact('addons'));
    }
    public function store(Request $request)
    {

        $store = new Addons;
        $addons = Addons::all();





            $store->addon_name=$request->addon_name;
            $store->addon_cost_price=$request->cost_price;
            $store->addon_selling_price=$request->sell_price;
            $store->save();


            session()->flash('success', "Addon Added Successfully");


        if ($store) {

            return view('addon.index', compact('addons'));

//        sendNoti('New Customer Added By ' . "bilal", 'sds', 'Installation');
            return redirect('addons');
//
//
//            return view('addon.index' , compact('addons'));


        }
    }

    public function edit($id)
    {
        $dec_id = \Crypt::decrypt($id);
        $edit = Addons::where('id_addons', $dec_id)->first();
        return view('addon.edit', compact('edit'));
    }


    public function update(Request $request, $id)
    {


            $dec_id = \Crypt::decrypt($id);
            $update = Addons::where('id_addons' , $dec_id)->first();
            $addons = Addons::all();
            $update->addon_name=$request->addon_name;
            $update->addon_cost_price=$request->cost_price;
            $update->addon_selling_price=$request->sell_price;
            $update->status=$request->status;
            $update->save();
            session()->flash('warning', "Addon Updated Successfully");
            return redirect('addons');
        if ($update) {

            return redirect()->back();
        }
    }
}
