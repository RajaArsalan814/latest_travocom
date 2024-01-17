<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class RouteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
               
    }
    public function index()
    {
        $routes = Route::all();
        return view('route.index', compact('routes'));
    }
    public function create()
    {
        $routes = Route::all();
        return view('route.create', compact('routes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'route_name' => 'required',
            'locations' => 'required',
        ]);
        $store = new Route;
        foreach ($request->locations as $key => $value) {
            $allentries[] = [
                'key' => $key,
                'locations' => $request->locations[$key],
            ];
        }

        $store->route_name = $request->route_name;
        $store->locations = json_encode($allentries);
        $store->route_location = implode('->', $request->locations);
        $store->save();
        // dd($allentries);


        session()->flash('success', 'Route Added Successfully');
        return redirect()->back();
    }



    public function edit($id, Request $request)
    {
        try {
            $dec_id = \Crypt::decrypt($id);
            $edit = Route::findOrFail($dec_id); // Find the specific route by ID

            return view('route.edit', compact('edit'));
        } catch (\Exception $e) {
        }
    }


    public function update(Request $request, $id)
    {
        $dec_id = \Crypt::decrypt($id);
        $update = Route::where('id_route', $dec_id)->first();
        foreach ($request->locations as $key => $value) {
            $allentries[] = [
                'key' => $key,
                'locations' => $request->locations[$key],

            ];
        }

        $update->route_name = $request->route_name;
        $update->locations = json_encode($allentries);
        $update->route_location = implode('->', $request->locations);
        $update->save();
        // dd($update);
        // dd($allentries);


        session()->flash('success', 'Route Updated Successfully');
        return redirect()->back();
    }
}
