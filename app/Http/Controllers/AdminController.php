<?php

namespace App\Http\Controllers;

use App\inquiry;
use App\Customer;
use App\payments_account;
use Illuminate\Support\Facades\DB;
use App\quotation;
use Carbon\Carbon;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Path to the scanned image
        // $imagePath =public_path('p1.jpg');

        // // Create a new instance of TesseractOCR
        // $tesseract = new TesseractOCR($imagePath);

        // // Set the language of the text in the image
        // $tesseract->lang('eng');

        // // Get the text from the image
        // $text = $tesseract->run();

        // Print the extracted text
        // echo $text;
        // dd(explode("\n", $text));
        //         echo '<pre>'; print_r(auth()->user());exit;
        $date = date('Y-m-d h:i:s', strtotime(now()));
        $customers_count = Customer::count();

        $today_inquiry_count = inquiry::whereDate('created_at', '>=', Carbon::today())
            ->whereDate('created_at', '<=', Carbon::today())->count();

        $total_quotation_count = quotation::whereDate('created_at', '>=', Carbon::today())
            ->whereDate('created_at', '<=', Carbon::today())->count();

        $count_open_inquiries = inquiry::where('status', 'Open')->whereDate('created_at', Carbon::today())->count();
        $count_progress_inquiries = inquiry::where('status', 'In-Progress')->whereDate('created_at', Carbon::today())->count();
        $count_confirmed_inquiries = inquiry::where('status', 'Confirmed')->whereDate('created_at', Carbon::today())->count();
        $count_canceled_inquiries = inquiry::where('status', 'Canceled')->whereDate('created_at', Carbon::today())->count();
        $count_completed_inquiries = inquiry::where('status', 'Completed')->whereDate('created_at', Carbon::today())->count();

        $quotation_count = payments_account::groupBy('quotation_id')->get()->count();
        $quotation_today_count = payments_account::whereDate('created_at', Carbon::now())->select('quotation_id')->groupBy('quotation_id')->get()->count();
        $today_amount = payments_account::whereDate('created_at', Carbon::now())->sum('paid_amount');
        $today_dues = payments_account::whereDate('created_at', Carbon::now())->groupBy('quotation_id')->select('total_quotation_amount')->get();
        $get_total_dues = 0;
        foreach ($today_dues as $key => $value) {
            $get_total_dues += $value->total_quotation_amount;
        }
        $total_today_due = $get_total_dues - $today_amount;
        // dd($total_today_due);

        $users = \App\User::get();
        // dd($count_open_inquiries);exit;
        if (auth()->user()->role_id == 8) {
            return redirect('inquiry');
            // Accounts
//            return view('dashboards.accounts_dashboard', compact('total_today_due', 'today_amount', 'quotation_count', 'quotation_today_count'));
        } 
        if(auth()->user()->role_id == 6){
            return redirect('inquiry');
//            return view('dashboards.sales_dashboard', compact('total_today_due', 'today_amount', 'quotation_count', 'quotation_today_count'));
        }
        if(auth()->user()->role_id == 7){
            return redirect('inquiry');
//            return view('dashboards.manager_dashboard', compact('total_today_due', 'today_amount', 'quotation_count', 'quotation_today_count'));
        }
        if(auth()->user()->role_id == 1) {
            // Admin
            return redirect('inquiry');
//            return view('dashboards.admin_dashboard', compact('customers_count', 'today_inquiry_count', 'total_quotation_count', 'count_open_inquiries', 'count_progress_inquiries', 'count_confirmed_inquiries', 'count_canceled_inquiries', 'count_completed_inquiries', 'users'));
        }
        if(auth()->user()->role_id == 9) {
            // Admin
            return redirect('inquiry/create');
//            return view('dashboards.admin_dashboard', compact('customers_count', 'today_inquiry_count', 'total_quotation_count', 'count_open_inquiries', 'count_progress_inquiries', 'count_confirmed_inquiries', 'count_canceled_inquiries', 'count_completed_inquiries', 'users'));
        }else{
        return redirect('inquiry');
            
        }
    }

    public function cities_index()
    {
    }
}
