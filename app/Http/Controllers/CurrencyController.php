<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\currency_exchange_rate;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class CurrencyController extends Controller
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
    $currency = currency_exchange_rate::all();

    return view('currency_exchange.index' , compact('currency'));
  }
  public function create()
  {
    $currency = currency_exchange_rate::all();

    return view('currency_exchange.create' , compact('currency'));
  }

  public function store(Request $request)
{
    $store = new currency_exchange_rate;
    $store->currency_name = $request->currency_name;
    $store->currency_rate = $request->currency_rate;
    $store->currency_symbols = $request->currency_symbols;

    $store->save();
    session()->flash('success', "New Rate Of Exchange Added Successfully");

    return redirect('currency_exchange');
}

public function edit($id)
{
    $dec_id = \Crypt::decrypt($id);
    $edit = currency_exchange_rate::where('id_currency_exchange_rates' , $dec_id)->first();
    // $edit = currency_exchange_rate::all();

    return view('currency_exchange.edit' , compact('edit'));
}
public function update(Request $request ,$id)
{
    $dec_id = \Crypt::decrypt($id);
    $update = currency_exchange_rate::where('id_currency_exchange_rates' , $dec_id)->first();
    // $update = currency_exchange_rate::all();
    // dd($update);
    $update->currency_name = $request->currency_name;
    $update->currency_rate = $request->currency_rate;
    $update->currency_symbols = $request->currency_symbols;

    $update->save();

    session()->flash('warning', "Rate Of Exchange Updated Successfully");

    return redirect('currency_exchange');


}




}
