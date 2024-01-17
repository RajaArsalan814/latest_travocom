<?php

namespace App\Http\Controllers;


use App\cost_center_type;
use Illuminate\Http\Request;
use App\Store;
use Illuminate\Support\Facades\DB;
use App\customers;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerReceivableMail;
use View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class CronJobController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cost_center_type  $cost_center_type
     * @return \Illuminate\Http\Response
     */
       public function run()
    {
        $sql= "SELECT
                *
            FROM
                (
                SELECT
                    id_sale_invoice,
                    customer_id,
                    payment_status,
                    Invoice_date
                FROM
                    sale_invoice
                WHERE
                    id_sale_invoice IN(
                    SELECT
                        MAX(id_sale_invoice)
                    FROM
                        sale_invoice
                    GROUP BY
                        customer_id
                )
            ORDER BY
                customer_id ASC
            ) AS cust
            WHERE
                payment_status = 'Unpaid' AND DATEDIFF(CURDATE(), Invoice_date) > 15";

        $res = DB::select($sql);
        
    $account_map = DB::table('transaction_account')->select()
    ->where(DB::raw('LOWER(transaction_account_name)'),strtolower('RECEIVABLES FROM CUSTOMER'))
    ->where('business_id',1)
    ->first();   

    $transactionId =  empty($account_map) ? 0: $account_map->id_transaction_account;
        
        foreach($res as $customer)
        {
            $customer_id =  $customer->customer_id;            
            //inv.created_at <= '$from' AND
            $this->sendemail($transactionId, $customer_id);
            exit;
            
        }
        
        exit;
       
    }


    public function customeremail(Request $request)
    {
        $transactionId = $request->transactionId;
        $customer_id = $request->customerId;


        //echo "hello world"; exit;
        $this->getLedger($customer_id,4, $transactionId);

        //echo $customer_id.": ".$transactionId; exit;
        //$this->sendemail($transactionId, $customer_id);
        return "email successfully sent";
    }

    public function sendemail($transactionId, $customer_id)
    {

        $accountBalance = DB::table('account_voucher as av')
        ->select(DB::raw("SUM(debit) as debit"), DB::raw("SUM(credit) as credit"), 'ta.id_transaction_account', 'ta.transaction_account_name', 'ta.transaction_account_number', 'sca.sub_control_account_number', 'ca.control_account_number', 'ma.main_account_number', 'ta.nature', 'ta.id_transaction_account', 'avd.transaction_account_id')
        ->join('account_voucher_details as avd', 'avd.account_voucher_id', 'av.id_account_voucher')
        ->join('transaction_account as ta', 'ta.id_transaction_account', 'avd.transaction_account_id')
        ->join('sub_control_account as sca', 'ta.sub_control_account_id', 'sca.id_sub_control_account')
        ->join('control_account as ca', 'sca.control_account_id', 'ca.id_control_account')
        ->join('main_account as ma', 'ca.main_account_id', 'ma.id_main_account')
        ->where('av.business_id', 1)
        ->where('av.bp_id', $customer_id)
        ->where('av.bp_type', "Customer")
        ->where('avd.transaction_account_id',  $transactionId)
        ->groupBy('avd.transaction_account_id')
        ->whereNull('av.deleted_at')
        ->get();


        if (!empty($accountBalance)) {
            $amount = $accountBalance[0]->debit - $accountBalance[0]->credit;
        } else {
            $amount = 0;
        }
        //echo $amount;
        $customer = customers::select('*')
                ->where('id_customers', '=', $customer_id)
                ->get();
        if ($amount >0)
        {
            if(!empty($customer[0]->customer_email))
            {
                //email here
                echo $customer[0]->customer_email."<br>" ; 
                echo $amount."<br>" ; 
                $data['customer_email'] = $customer[0]->customer_email;
                $data['customer_name'] = $customer[0]->customer_name;
                $data['customer_amount'] = $amount;
                $emaildata['view'] = (string) View::make('emails.customers.template', $data);
                $customer[0]->customer_email = "meer.mszsolutions@gmail.com";
                Mail::to($customer[0]->customer_email)->send(new CustomerReceivableMail($emaildata));
                
                exit;
            }
        
        } 
    }



    public function getLedger($bp_id, $business_type ,$transactionId )
    {
        
        if ($bp_id > 0) {
            //$business_type = $request->type_id;
            $business_name_id = $bp_id;
            
            $type = "";
            if ($business_type == 2) {
                $type = 'Vendors';
            } elseif ($business_type == 3) {
                $type = 'Employees';
            } elseif ($business_type == 4) {
                $type = 'Customer';
            } elseif ($business_type == 5) {
                $type = 'Other';
            } 
            elseif ($business_type == 'All') {
                $type = 'All';
            } else {
                $type = $business_type;
            }

            $from_account = $transactionId;
            $to_account = $transactionId;

            // Getting date range
            $from_date = date('Y-m-d', strtotime('-1 year'));
            $to_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d")));

            
            // Fetching account details between date range
            $accounts = DB::table('transaction_account as ta')
            ->select('ta.id_transaction_account', 'ta.transaction_account_name', 'ta.transaction_account_number', 'sca.sub_control_account_number', 'ca.control_account_number', 'ma.main_account_number', 'ta.nature')
            ->join('sub_control_account as sca', 'ta.sub_control_account_id', 'sca.id_sub_control_account')
            ->join('control_account as ca', 'sca.control_account_id', 'ca.id_control_account')
            ->join('main_account as ma', 'ca.main_account_id', 'ma.id_main_account')
            ->whereBetween('ta.id_transaction_account', [$from_account, $to_account])
            ->where('ta.business_id', auth()->user()->business_id)
            ->get();



            $data = array();
            foreach ($accounts as $row) { /// Fetch transactions using transaction id
    
                $opneingBalance = DB::table('account_voucher as av')
                    ->select(DB::raw("SUM(debit) as debit"), DB::raw("SUM(credit) as credit"))
                    ->join('account_voucher_details as avd', 'avd.account_voucher_id', 'av.id_account_voucher')
                    ->where('avd.transaction_account_id', $row->id_transaction_account)
                    ->where('av.voucher_date', '<', $from_date)
                    ->where('av.business_id', auth()->user()->business_id)
                    ->whereNull('av.deleted_at');
    
                if ($type != 'All') {
                    $opneingBalance = $opneingBalance->where('av.bp_type', $type);
                }
                if ($business_name_id != 'All') {
                    $opneingBalance = $opneingBalance->where('av.bp_id', $business_name_id);
                }
                $opneingBalance = $opneingBalance
                    ->get();
    
                $transactions = DB::table('account_voucher as av')
                    ->select('*', DB::raw("SUM(debit) as debit"), DB::raw("SUM(credit) as credit"))
                    ->join('account_voucher_details as avd', 'avd.account_voucher_id', 'av.id_account_voucher')
                    ->where('avd.transaction_account_id', $row->id_transaction_account)
                    ->whereBetween('av.voucher_date', [$from_date, $to_date])
                    ->whereNull('av.deleted_at')
                    ->groupBy('avd.account_voucher_id')
                    ->orderBy('av.voucher_date', 'asc')
                    ->where('av.business_id', auth()->user()->business_id);
                if ($type != 'All') {
                    $transactions = $transactions->where('av.bp_type', $type);
                }
                if ($business_name_id != 'All') {
                    $transactions = $transactions->where('av.bp_id', $business_name_id);
                }
               // echo $transactions->toSql(); exit; 
                $transactions = $transactions->get();
    
                $data[$row->transaction_account_name]['av'] = $row;
                $data[$row->transaction_account_name]['ob'] = $opneingBalance;
                $data[$row->transaction_account_name]['details'] = $transactions;
    
            }


            // all records get

            $this->renderHtml($data);
            exit;
    
            


        } 
        

    }

    public function renderHtml($data)
    {
        //echo "<pre>";
        //print_r($data);
        $openingBlance = 0;

        $html = '<table class="" style=" width: 100%;margin-top: -10px;" cellspacing="0" id="podetailstbl" class="customtble">
        <thead>
            <tr>
                <th style="padding: 6px 5px 6px 5px;border-bottom: 1px solid black;" colspan="5"></th>
                <th style="padding: 6px 5px 6px 5px;border-bottom: 1px solid black;" colspan="3"></th>
            </tr>
            <tr role="row" class="heading">
                <th style="padding: 6px 5px 6px 5px;border: 1px solid black;width:12%;">Date</th>
                <th style="padding: 6px 5px 6px 5px;border: 1px solid black;width:10%;">Voucher #</th>
                <th style="padding: 6px 5px 6px 5px;border: 1px solid black;width:25%;">Description</th>
                <th style="padding: 6px 5px 6px 5px;border: 1px solid black;width:20%;">Business Partner</th>
                <th style="padding: 6px 5px 6px 5px;border: 1px solid black;width:5%;">Check/Slip#</th>
                <th style="padding: 6px 5px 6px 5px;border: 1px solid black;text-align: right;width:10%;">Debit</th>
                <th style="padding: 6px 5px 6px 5px;border: 1px solid black;text-align: right;width:10%;">Credit</th>
                <th style="padding: 6px 5px 6px 5px;border: 1px solid black;text-align: right;width:15%;">Balance</th>
            </tr>
            </thead>
                <tr>                                    
                <td style="font-size: 12px !important;padding: 6px 5px 6px 5px;border: 1px solid black;"></td>
                <td style="font-size: 12px !important;padding: 6px 5px 6px 5px;border: 1px solid black;"></td>
                <td style="font-size: 12px !important;padding: 6px 5px 6px 5px;border: 1px solid black;">Opening Balance</td>
                <td style="font-size: 12px !important;padding: 6px 5px 6px 5px;border: 1px solid black;"></td>
                <td style="font-size: 12px !important;padding: 6px 5px 6px 5px;border: 1px solid black;"></td>
                <td style="font-size: 12px !important;padding: 6px 5px 6px 5px;border: 1px solid black;text-align: right;"></td>
                <td style="font-size: 12px !important;padding: 6px 5px 6px 5px;border: 1px solid black;text-align: right;"></td>
                <td style="font-size: 12px !important;padding: 6px 5px 6px 5px;border: 1px solid black;text-align: right;">'. number_format($openingBlance,2) .'</td>

                </tr>
            <tbody>';
            $debit = 0; $credit=0;
        foreach($data as $value)
        {
            $opening_credit =  $value['ob'][0]->credit;
            $opening_debit =  $value['ob'][0]->debit;   
            $openingBlance = $opening_credit - $opening_debit;
            foreach($value['details'] as $tras)
            {
                $openingBlance += $tras->debit - $tras->credit;
                
                $html .='<tr>  
               

                <td style="font-size: 12px !important;padding: 6px 5px 6px 5px;border: 1px solid black;">'.  date('d-m-y', strtotime($tras->voucher_date)). '</td>
                <td style="font-size: 12px !important;padding: 6px 5px 6px 5px;border: 1px solid black;">'. $tras->voucher_number .'</td>
                <td style="font-size: 12px !important;padding: 6px 5px 6px 5px;border: 1px solid black;">'. $tras->description .'</td>
                <td style="font-size: 12px !important;padding: 6px 5px 6px 5px;border: 1px solid black;">'. $tras->bp_name  .'<br /> ('. $tras->bp_type .')</td>
                <td style="font-size: 12px !important;padding: 6px 5px 6px 5px;border: 1px solid black;">'. $tras->instrument_no .'</td>
                <td style="font-size: 12px !important;padding: 6px 5px 6px 5px;border: 1px solid black;text-align: right;">'. number_format($tras->debit,2) .'</td>
                <td style="font-size: 12px !important;padding: 6px 5px 6px 5px;border: 1px solid black;text-align: right;">'. number_format($tras->credit,2) .'</td>
                <td style="font-size: 12px !important;padding: 6px 5px 6px 5px;border: 1px solid black;text-align: right;">'. number_format($openingBlance,2) .'</td>

            </tr>    
            ';
            
            $debit += $tras->debit;
            $credit += $tras->credit; 

            }
        }
        echo $html; exit;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cost_center_type  $cost_center_type
     * @return \Illuminate\Http\Response
     */
    public function edit(cost_center_type $cost_center_type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cost_center_type  $cost_center_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cost_center_type $cost_center_type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cost_center_type  $cost_center_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(cost_center_type $cost_center_type)
    {
        //
    }
}
