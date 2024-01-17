<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\Facades\DataTables;
use App\UnitType;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class UnitTypeController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/unittype.index');
    }

    public function getdata()
    {
        $unit_type = UnitType::select('*');
        //->where('business_id',auth()->user()->business_id);
        return Datatables::of($unit_type)
                ->addColumn('action', function ($unit_type) {
                    $html = '
                        <a  href="'.url('edit_unittype/'.$unit_type->id_unit_type).'" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> Edit</a>
                        <a onclick="deleteunittype('.$unit_type->id_unit_type.');" href="javascript:void(0);"  class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i> Delete</a>

                    ';
                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/unittype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'name' => 'required|unique:unit_type,name'
        ],['name.required' => 'The unit type field is required.', 'name.unique' => 'The unit type has already been taken.']);

        $UnitType  = new UnitType;
        $UnitType->name = $request->name;
        $UnitType->status = $request->status;
        $UnitType->created_by = auth()->user()->id;
        $UnitType->business_id = auth()->user()->business_id;
        $UnitType->save();
        Session::flash('message','Unit Type has been added');
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
        $UnitType = UnitType::where('id_unit_type', $id)->first();

        return  view('unittype.edit',compact('UnitType'));
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
        $this->validate($request,[
            'name' => 'required|unique:unit_type,name,'.$id.',id_unit_type'
        ],['name.required' => 'The unit type field is required.', 'name.unique' => 'The unit type has already been taken.']);

        $UnitType = UnitType::where('id_unit_type', $id)->update([
            'name' => $request->name,
            'status' => $request->status,
            'created_by' => auth()->user()->id,
            'business_id' => auth()->user()->business_id
        ]);

        Session::flash('message','Unit Type has been updated');
        return redirect('unittype');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $UnitType = UnitType::findOrfail($id);
        $UnitType->delete();
        Session::flash('message','Unit Type has been deleted');
        return back();
    }
}
