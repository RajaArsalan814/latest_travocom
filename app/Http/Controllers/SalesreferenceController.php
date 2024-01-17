<?php

namespace App\Http\Controllers;

use App\sales_reference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SalesreferenceController extends Controller
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

        $data = sales_reference::select('*')->get();
        return view('references.index',compact('data'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('references.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|unique:sales_reference'
        ]);

        $sales_reference = new sales_reference();
        $sales_reference->type_name = $request->type_name;
        $sales_reference->save();
        if ($sales_reference) {
            session()->flash('success', 'New Sales Reference Added');

            return redirect()->back();
        } else {
            toastr()->error('An error has occurred please try again later.');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sales_reference  $sales_reference
     * @return \Illuminate\Http\Response
     */
    public function show(sales_reference $sales_reference)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sales_reference  $sales_reference
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $dec_id = \Crypt::decrypt($id);
        $sales_reference = sales_reference::where('type_id', $dec_id)->first();
        return  view('references.edit',compact('sales_reference'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sales_reference  $sales_reference
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , $id)
    {

        // dd('d');
        // $request->validate([
        //     'type_name' => 'required'
        // ]);

        // $sales_reference = sales_reference::findOrfail($request->type_id);
        // $sales_reference->type_name = $request->type_name;
        // $sales_reference->save();
        // Session::flash('message','Sales References has been updated');
        // return redirect('sales_reference');

        $request->validate([
            'type_name' => 'required|unique:sales_reference'
        ]);
        // dd($request);
        try {
            $dec_id = \Crypt::decrypt($id);
            $sales_reference = sales_reference::where('type_id', $dec_id)->first();
            $sales_reference->type_name = $request->type_name;
            $sales_reference->save();
            session()->flash('success', "Inquiry Type Updated Successfully");
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
            return redirect()->back();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sales_reference  $sales_reference
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $sales_reference = sales_reference::findOrfail($request->type_id);
        $sales_reference->delete();
        Session::flash('message','Sales References has been deleted');
        return back();
    }
}
