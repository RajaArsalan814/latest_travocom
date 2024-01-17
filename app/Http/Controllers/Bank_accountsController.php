<?php

namespace App\Http\Controllers;

use App\other_service;
use App\bank_accounts;
use App\packagestypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class Bank_accountsController extends Controller
{
    protected $role_id;
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
        $my_bank = bank_accounts::all();
        return view('my_bank_account.index', compact('my_bank'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $my_bank = bank_accounts::all();
        return view('my_bank_account.create', compact('my_bank'));
    }

    public function store(Request $request)
    {

        $store = new bank_accounts;
        $my_bank = bank_accounts::all();

        $store->bank_name = $request->bank_name;
        $store->account_number = $request->account_number;
        $store->branch_address = $request->branch_address;
        // dd($store);
        $store->save();

        session()->flash('success', "My Bank Account Added Successfully");
        return redirect()->back();
    }
    public function edit($id)
    {
        $dec_id = \Crypt::decrypt($id);
        $my_bank = bank_accounts::where('id_bank_accounts' , $dec_id )->first();
        return view('my_bank_account.edit', compact('my_bank'));

    }

    public function update(Request $request , $id)
    {
        $dec_id = \Crypt::decrypt($id);
        $update = bank_accounts::where('id_bank_accounts' , $dec_id )->first();
        $my_bank = bank_accounts::all();

        $update->bank_name = $request->bank_name;
        $update->account_number = $request->account_number;
        $update->branch_address = $request->branch_address;
        // dd($update);
        $update->save();

        session()->flash('success', "My Bank Account Updated Successfully");
        return redirect()->back();
    }

}
