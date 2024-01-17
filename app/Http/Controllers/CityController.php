<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\cities;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CityController extends Controller {

    protected $role_id;
    public function __construct()
    {
        $this->middleware('auth');
               
    }
//     public function __construct()
//     {
//         $this->middleware('auth');
//                $this->middleware(function ($request, $next) {
//                    $this->role_id = Auth::user()->role_id;
//                 //    $slug_filter = preg_replace('/[0-9]+/', '', $request->path());
//                 //    $slug_filter = preg_replace('/[0-9]+/', '', $request->path());
//                 $ex = explode('/',$request->path());
//                 if(count($ex)>=3){
//                     $sliced = array_slice($ex, 0, -1);

//                 }else{
//                     $sliced = $ex;
//                 }

//                 $string = implode("/", $sliced);
// //                 dd($string);
//                    if (checkConstructor($this->role_id, count($ex)>=3 ? $string.'/': $string) == 1) {
//                        return $next($request);
//                    }else if(strpos($request->path(), 'store') !== false){
//                        return $next($request);
//                    }else if(strpos($request->path(), 'update') !== false){
//                        return $next($request);
//                    } else {
//                        abort(404);
//                    }
//                });
//     }
    public function index() {
        // $cities = cities::paginate(5);

        return view('city.index'); //, compact('cities'));
    }

    public function create() {
        return view('city.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'city_name' => 'required'
        ]);

        $city = new city();
        $city->city_name = $request->city_name;
        $city->save();

        Session::flash('message', 'City has been added');
        return redirect(url('city'));
    }

    public function edit(Request $request, $id) {
        $city = city::find($id);
        return view('city.edit', compact('city'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'city_name' => 'required'
        ]);

        $city = city::find($id);
        $city->city_name = $request->city_name;
        $city->save();

        Session::flash('message', 'City has been updated');
        return redirect(url('city'));
    }

}
