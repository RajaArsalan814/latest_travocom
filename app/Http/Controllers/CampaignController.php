<?php

namespace App\Http\Controllers;

use App\campaign;
use App\follow_up_type;
use App\inquirytypes;
use App\office_working_hour;
use App\other_service;
use App\performance_slab;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CampaignController extends Controller
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = campaign::all();
        return view('campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role_id = auth()->user()->role_id;
        $services = other_service::where('status', 'Active')->where('parent_id', null)->get();
        $inquiry_type = inquirytypes::all();
        return view('campaigns.create', compact('services', 'inquiry_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'services' => 'required',
            'inquiry_type' => 'required',
            'sub_services' => 'required',
        ]);
        try {
            $store = new Campaign();
            $store->campaign_name = $request->campaign_name;
            $store->start_date = $request->start_date;
            $store->end_date = $request->end_date;

            $servicesCount = count($request->services);
            $data = $request->all();
            // dd($data);
            $services = [];
            $subServices = [];

            for ($i = 0; $i < $servicesCount; $i++) {
                $services[] = $data['services'][$i];
                if ($i == 0) {
                    $service_pair[] = [
                        'service' => isset($data['services'][$i]) ? $data['services'][$i] : null,
                        'sub_service' => implode(',', $data['sub_services']),
                    ];
                } else {
                    $service_pair[] = [
                        'service' => isset($data['services'][$i]) ? $data['services'][$i] : null,
                        'sub_service' => isset($data['sub_services' . $i]) ? implode(',', $data['sub_services' . $i]) : null,
                    ];
                }
            }

            // dd($service_pair);
            $store->services_id = implode(',', $services);
            $store->description = $request->desc;
            $store->status = "Active";
            $store->inquiry_type = $request->inquiry_type;
            $store->services_and_sub_services = json_encode($service_pair);
            $store->created_by = auth()->user()->id;
            $store->save();

            session()->flash('success', 'Added Successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\office_working_hour  $office_working_hour
     * @return \Illuminate\Http\Response
     */
    public function show(office_working_hour $office_working_hour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\office_working_hour  $office_working_hour
     * @return \Illuminate\Http\Response
     */
    public function edit(office_working_hour $office_working_hour, $id)
    {
        // dd('sds');

        $dec_id = Crypt::decrypt($id);
        //    dd($dec_id);
        $edit_campaign = campaign::where('id_campaigns', $dec_id)->first();
        $services = other_service::where('status', 'Active')->where('parent_id', null)->get();
        $inquiry_type = inquirytypes::all();
        //    dd($office_working_hour);
        return view('campaigns.edit', compact('edit_campaign', 'services', 'inquiry_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\office_working_hour  $office_working_hour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, office_working_hour $office_working_hour, $id)
    {
        $dec_id = Crypt::decrypt($id);
        // dd($dec_id);
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'services' => 'required',
        ]);
        try {

            // dd($request);
            $store = campaign::where('id_campaigns', $dec_id)->first();
            // dd($store);
            $store->campaign_name = $request->campaign_name;
            $store->start_date = $request->start_date;
            $store->end_date = $request->end_date;
            $servicesCount = count($request->services);
            $data = $request->all();
            $services = [];
            $subServices = [];

            if (isset($request->sub_services)) {
                for ($i = 0; $i < $servicesCount; $i++) {
                    $services[] = $data['services'][$i];
                    if ($i == 0) {
                        $subServices[] = $services[$i] . '/' . implode(',', $data['sub_services']);
                    } else {
                        $subServices[] = $services[$i] . '/' . implode(',', $data['sub_services' . $i]);
                    }
                }
            }

            $store->services_id = implode(',', $services);
            $store->description = $request->desc;
            $store->status = "Active";
            $store->inquiry_type = $request->inquiry_type;
            $store->services_and_sub_services = json_encode($subServices);
            $store->created_by = auth()->user()->id;
            $store->save();

            session()->flash('success', 'Updated Successfully');
            return back();
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\office_working_hour  $office_working_hour
     * @return \Illuminate\Http\Response
     */
    public function destroy(office_working_hour $office_working_hour, $id)
    {
        $dec_id = Crypt::decrypt($id);

        $destroy = campaign::where('id_campaigns', $dec_id)->first();
        //    dd($destroy_hotel);
        $destroy->delete();
        session()->flash('success', 'Inventory Removed!');

        return back();
    }
}
