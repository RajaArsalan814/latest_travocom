<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\role_permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $title = 'Permission';
        $menu = 'permission';
        $submenu = 'permission';
        $page = 'list';
        $roles = DB::table('roles')->get()->toArray();
        
        $permission = DB::table('role_permission')->where('role_id', request('id'))->pluck('menu_id')->toArray();
        
        $role_id = request('id') > 0 ? request('id') : 0;

//dd($role_id);

        return view('Permission.index')->with(compact('title', 'menu','submenu', 'page', 'roles','role_id', 'permission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Roles';

        $menu = 'role';
        $submenu = 'role';
        $page = 'add';

        return view('Roles.create')->with(compact('title', 'menu','submenu', 'page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //echo "<pre>";
        //print_r($request);exit;
        DB::table('role_permission')->where('role_id', request('id'))->delete();
        if($request->menu_id){
            for($i = 0; $i < count($request->menu_id); $i++){
                DB::table('role_permission')
                ->insert(['role_id' => request('id'), 'menu_id' => $request->menu_id[$i]]);
            }
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Roles';
        $menu = 'role';
        $submenu = 'role';
        $page = 'edit';
        $role = DB::table('roles')->where('id_roles', $id)->first();

        return view('Roles.edit')->with(compact('title', 'menu', 'submenu', 'page', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'role' => 'required',
        ]);

        DB::table('roles')->where('id_roles', $id)->update(['role' => $request->role, 'updated_at' => date('Y-m-d H:i:s')]);

        return redirect(url('roles'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $role = DB::table('roles')->where('id_roles', $request->id)->delete();
        Session::flash('message','Role has been deleted');
        return back();
    }
}
