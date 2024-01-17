<?php

namespace App\Http\Controllers;

use App\assign_department_user;
use App\departments;
use App\countries;
use App\department_service;
use App\department_team;
use App\department_sub_service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\other_service;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class DepartmentsController extends Controller
{
    protected $role_id;
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (isset(request()->q)) {
            $departments = departments::where('id_departments', request()->q)->get();
        } else {
            $departments = departments::all();
        }
        $users = User::all();
        // $dep_users=assign_department_user::where();
        // dd()
        $services = other_service::where('status', 'Active')
            ->where('parent_id', null)
            ->get();
        $department_teams = department_team::all();
        return view('departments.index', compact('departments', 'department_teams', 'users', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = countries::all();
        $services = other_service::where('status', 'Active')
            ->where('parent_id', null)
            ->get();
        return view('departments.create', compact('countries', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required',
            // 'services' => 'required',
            // 'sub_services' => 'required'
        ]);

        $department = new departments();
        $department->department_name = $request->department_name;
        // $department->services = $request->services;
        // $department->sub_services = json_encode($request->sub_services);
        $department->save();

        if ($department) {
            session()->flash('success', 'Department Added Successfully!');

            return redirect()->back();
        } else {
            toastr()->error('An error has occurred please try again later.');
            //            session()->flash('error', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dec_id = \Crypt::decrypt($id);
        $edit_department = departments::where('id_departments', $dec_id)->first();
        $services = other_service::where('status', 'Active')
            ->where('parent_id', null)
            ->get();
        return view('departments.edit', compact('edit_department', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //        echo 'working';exit;
        $request->validate([
            'department_name' => 'required',
        ]);
        // dd($request);

        $dec_id = \Crypt::decrypt($request->a_id);

        //            echo $dec_id;exit;
        $department = departments::where('id_departments', $dec_id)->first();
        //             dd($department);
        $department->department_name = $request->department_name;
        // $department->services = $request->services;
        // $department->sub_services = json_encode($request->sub_services);
        $department->status = $request->department_status;

        $department->save();
        if ($department) {
            session()->flash('success', 'Department Updated Successfully!');

            return redirect()->back();
        } else {
            toastr()->error('An error has occurred please try again later.');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $department_id = \Crypt::decrypt($id);
        $destroy_department = departments::findOrfail($department_id);
        $destroy_department->delete();
        session()->flash('success', 'Department Removed!');
        return back();
    }
    public function remove_department_user($user_id, $d_id)
    {
        $dec_user_id = \Crypt::decrypt($user_id);
        // dd($dec_user_id);
        $dec_d_id = \Crypt::decrypt($d_id);
        // dd($dec_d_id);
        $department_team_user = department_team::findOrFail($dec_d_id);
        $get_all_users = json_decode($department_team_user->user_id);
        // if(count($get_all_users_count)>0){
        //     $get_all_users = json_decode($department_team_user->user_id);
        // }else{
        //     $get_all_users=$department_team_user->user_id
        // }
        // dd($get_all_users);
        // dd(json_encode($get_all_users));
        // dd(is_array($get_all_users));
        if (($key = array_search($dec_user_id, $get_all_users)) !== false) {
            unset($get_all_users[$key]);
        }

        $get_users_ids = [];
        foreach ($get_all_users as $item_user) {
            $get_users_ids[] = $item_user;
        }
        // dd($get_all_users);

        $department_team_user->user_id = json_encode($get_users_ids);
        $department_team_user->save();
        session()->flash('success', 'User Removed!');
        return back();
    }
    public function assign_user_teams(Request $request)
    {
        // dd($request);
        $request->validate([
            'user_id' => 'required',
        ]);
        $update = department_team::where('id_department_teams', $request->team_id)->first();
        // dd($update);
        if ($update) {
            $get_table_users = json_decode($update->user_id);
            if ($get_table_users == null) {
                $get_table_users = [];
            }
            // dd($get_table_users);
            $check_user = in_array($request->user_id, $get_table_users);
            if (isset($request->is_head)) {
                $update->head_id = $request->user_id;
                $update->save();
            }

            if (!$check_user) {
                if (isset($request->is_head)) {
                    $update->head_id = $request->user_id;
                    $update->save();
                }
                $get_reqs_user[] = $request->user_id;
                $all_users = array_merge($get_table_users, $get_reqs_user);
                $update->user_id = json_encode($all_users);
                $update->save();

                //    User Teams Update Start
                $user_team = User::where('id', $request->user_id)->first();
                $get_users_team_id = json_decode($user_team->team_id);
                if ($get_users_team_id == null) {
                    $get_users_team_id = [];
                }
                $get_team_id[] = $update->id_department_teams;
                $merge_teams_users = array_merge($get_users_team_id, $get_team_id);
                $user_team->team_id = $merge_teams_users;
                $user_team->save();
                //    User Teams Update End
                session()->flash('success', 'Assign User');
                return back();
            } else {
                session()->flash('warning', 'User Already Added !');
                return back();
            }
        } else {
            session()->flash('error', 'Invalid Details');
            return back();
        }
    }
    public function assign_services_department(Request $request)
    {
        // dd($request);
        $department_id = $request->d_id;
        $department = departments::find($department_id);
        $services_count = count($request->services);
        // dd($services_count);
        $data = $request->all();
        // dd($data);
        for ($i = 0; $i < $services_count; $i++) {
            // dd($i);
            $services = $data['services'][$i];
            // dd($services);
            if ($i == 0) {
                $store_services = new department_service();
                $store_services->department_id = $department_id;
                $store_services->service_id = $services;
                $store_services->save();
                $service_id = $store_services->id;
                // dd($service_id);
                $store_sub_services = new department_sub_service();
                $store_sub_services->departments_id = $department_id;
                $store_sub_services->services_id = $service_id;
                $store_sub_services->sub_services_id = json_encode($data['sub_services']);
                $store_sub_services->save();
            } else {
                $store_services = new department_service();
                $store_services->department_id = $department_id;
                $store_services->service_id = $services;
                $store_services->save();

                $service_id = $store_services->id;

                $store_sub_services = new department_sub_service();
                $store_sub_services->departments_id = $department_id;
                $store_sub_services->services_id = $service_id;
                $store_sub_services->sub_services_id = json_encode($data['sub_services' . $i]);
                $store_sub_services->save();
            }
        }

        $department->department_services_id = $store_services->id_department_services;
        $department->save();
        // dd($department);

        session()->flash('success', 'Assign User');
        return back();
    }
    public function add_department_teams(Request $request)
    {
        // dd($request);
        $request->validate([
            'department_teams' => 'required',
        ]);

        $services_count = count($request->services);
        // dd($services_count);
        $data = $request->all();
        // dd($data);
        for ($i = 0; $i < $services_count; $i++) {
            // dd($i);
            $services[] = $data['services'][$i];
            if ($i == 0) {
                $sub_services[] = $services[$i] . '/' . implode(',', $data['sub_services']);
            } else {
                $sub_services[] = $services[$i] . '/' . implode(',', $data['sub_services' . $i]);
            }
        }

        $update = department_team::where('team_name', $request->department_teams)->first();
        if ($update) {
            $update->services = json_encode($sub_services);
            $update->department_id = $request->d_id;
            $update->save();
        } else {
            $store = new department_team();
            $store->team_name = $request->department_teams;
            $store->services = json_encode($sub_services);
            $store->department_id = $request->d_id;
            $store->save();
        }

        session()->flash('success', 'Team Added Successfully');
        return redirect()->back();
    }
}
