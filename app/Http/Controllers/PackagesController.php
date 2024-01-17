<?php

namespace App\Http\Controllers;

use App\other_service;
use App\packages;
use App\packagestypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class PackagesController extends Controller
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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = packages::all();
        return view('packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $packages_types = packagestypes::all();
        $services = other_service::where('parent_id', null)->get();
        return view('packages.create', compact('packages_types', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'package_name' => 'required',
            'package_type' => 'required',
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        try {
            $package = new packages();
            $package->package_name = $request->package_name;
            $package->package_type = $request->package_type;
            $package->from_date = $request->from_date;
            $package->to_date = $request->to_date;
            $package->no_of_persons = $request->no_of_persons;
            $package->package_cost = $request->package_cost;
            $package->package_price = $request->package_price;

            $services_count = count($request->services);
            // dd($services_count);
            $data = $request->all();
            // dd($data);
            for ($i = 0; $i < $services_count; $i++) {
                // dd($i);
                $services[] = $data['services'][$i];
                if ($i == 0) {
                    $sub_services[] =  $services[$i] . '/' . implode(',', $data['sub_services']);
                } else {
                    $sub_services[] =  $services[$i] . '/' . implode(',', $data['sub_services' . $i]);
                }
            }

            $package->services_and_sub_services = json_encode($sub_services);


            if (!empty($request->package_image)) {
                $file = $request->file('package_image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move(public_path('uploads/package_images/'), $filename);
                $data['image'] = $filename;
                $package->package_image = $data['image'];
            }
            $package->save();
            session()->flash('success', "Package Added Successfully");
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(packages $packages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dec_id = \Crypt::decrypt($id);
        $services = other_service::where('parent_id', null)->get();
        $packages_types = packagestypes::all();
        $edit_package = packages::where('id_packages', $dec_id)->first();
        return view('packages.edit', compact('edit_package', 'packages_types', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        // dd($request);
        try {

            $request->validate([
                'package_name' => 'required',
                'package_type' => 'required',
                'from_date' => 'required',
                'to_date' => 'required'
            ]);

            $dec_id = \Crypt::decrypt($request->h_id);
            $package = packages::where('id_packages', $dec_id)->first();
            $package->package_name = $request->package_name;
            $package->package_type = $request->package_type;
            $package->from_date = $request->from_date;
            $package->no_of_persons = $request->no_of_persons;
            $package->to_date = $request->to_date;
            $package->package_cost = $request->package_cost;
            $package->package_price = $request->package_price;
            $package->package_status = $request->package_status;
            $services_count = count($request->services);
            // dd($services_count);
            $data = $request->all();
            // dd($data);
            for ($i = 0; $i < $services_count; $i++) {
                // dd($i);
                $services[] = $data['services'][$i];
                if ($i == 0) {
                    $sub_services[] =  $services[$i] . '/' . implode(',', $data['sub_services']);
                } else {
                    $sub_services[] =  $services[$i] . '/' . implode(',', $data['sub_services' . $i]);
                }
            }

            $package->services_and_sub_services = json_encode($sub_services);
            if (!empty($request->package_image)) {
                $file = $request->file('package_image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move(public_path('uploads/package_images/'), $filename);
                $data['image'] = $filename;
                $package->package_image = $data['image'];
            }
            $package->save();
            session()->flash('success', "Package Updated Successfully");
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(packages $packages)
    {
        //
    }

    public function package_types_index()
    {
        $packages = packagestypes::all();
        return view('package_types.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function package_types_create()
    {
        return view('package_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function package_types_store(Request $request)
    {
        //        echo 'Heyyyyy';exit;
        $request->validate([
            'package_type' => 'required'
        ]);

        $package_types = new packagestypes();
        $package_types->type_name = $request->package_type;
        $package_types->save();
        if ($package_types) {
            session()->flash('success', 'New Package Type Added');

            return redirect()->back();
        } else {
            toastr()->error('An error has occurred please try again later.');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function package_types_show(packages $packages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function package_types_edit($id)
    {
        $dec_id = Crypt::decrypt($id);
        $edit_packages_types = packagestypes::where('id_packages_types', $dec_id)->first();
        return view('package_types.edit', compact('edit_packages_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function package_types_update(Request $request, $id)
    {
        $request->validate([
            'type_name' => 'required',
            'package_status' => 'required'
        ]);
        // dd($edit_packages_types);
        try {

            $dec_id = \Crypt::decrypt($id);
            $edit_packages_types = packagestypes::where('id_packages_types', $dec_id)->first();

            $edit_packages_types->type_name = $request->type_name;
            $edit_packages_types->status = $request->package_status;
            $edit_packages_types->save();
            session()->flash('success', "Package Type Updated Successfully");
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function package_types_destroy(packages $packages)
    {
        //
    }
}
