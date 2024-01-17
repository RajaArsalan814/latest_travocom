<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SalesController extends Controller
{
    protected $role_id;
    public function __construct()
    {
        $this->middleware('auth');
               $this->middleware(function ($request, $next) {
                   $this->role_id = Auth::user()->role_id;
                //    $slug_filter = preg_replace('/[0-9]+/', '', $request->path());
                //    $slug_filter = preg_replace('/[0-9]+/', '', $request->path());
                $ex = explode('/',$request->path());
                if(count($ex)>=3){
                    $sliced = array_slice($ex, 0, -1);

                }else{
                    $sliced = $ex;
                }

                $string = implode("/", $sliced);
//                 dd($string);
                   if (checkConstructor($this->role_id, count($ex)>=3 ? $string.'/': $string) == 1) {
                       return $next($request);
                   }else if(strpos($request->path(), 'store') !== false){
                       return $next($request);
                   }else if(strpos($request->path(), 'update') !== false){
                       return $next($request);
                   } else {
                       abort(404);
                   }
               });
    }
     public function index()
    {
         echo '<pre>'; print_r(auth()->user());exit;
        return view('sales.dashboard');
    }

    public function cities_index(){

    }
}
