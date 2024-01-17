<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
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
                if(count($ex)>1){
                    $sliced = array_slice($ex, 0, -1);
                }else{
                    $sliced = array_slice($ex, 0, 1);
                }

                $string = implode("/", $sliced);
                // dd($string);
                   if (checkConstructor($this->role_id, count($ex)>1?$string.'/':$string) == 1) {
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        exit;
        return redirect(url('/')); //view('home');
    }

    public function  notifications(){

        $date = \Carbon\Carbon::today()->subDays(30);
        // $users = goods_delivery_note::where('created_at', '>=', date($date))
        // ->join('categories', 'articles.categories_id', '=', 'categories.id')
        // ->get();
        $data['records'] = DB::select("
            SELECT * FROM `notifications` where is_view = 'No'");
        return $data;
    }


    public function updatenotifications(Request $request){
        $notification_id = $request->notification_id;
        $notification = Notifications::find($notification_id);
        $notification->is_view = 'Yes';
        $notification->save();
    }

}
