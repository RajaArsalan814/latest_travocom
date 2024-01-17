<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Branches;
use App\Plots;
use App\Customers;

#Get Branch By Id
function getBranchById($branch_id){
    $data = Branches::find($branch_id);
    return $data;
}

#Get Plot By Id
function getPlotById($plot_id){
	$data = Plots::find($plot_id);
    return $data;
}

#This function is using for send sms to customer where their need this fucntion to call from
function sendsms($num, $msg, $customerId, $branchId, $msgType = 'auto' ){
    // $cred = DB::table('sms_cred')->select('*');
    // $username= $cred->username;
    // $pwd = $cred->password;
    // $api = $cred->domain;


    $username = "meer123";///Your Username
    $password = "meer123";///Your Password
    $mobile = $num;///Recepient Mobile Number
    $sender = "SenderID";
    $message = $msg;
    
    ////sending sms
    
    $post = "sender=".urlencode($sender)."&mobile=".urlencode($mobile)."&message=".urlencode($message)."";
    $url = "http://send.eschools.cloud/web_distributor/api/sms.php?username=".$username."&password=".$password."";
    $ch = curl_init();
    $timeout = 10; // set to zero for no timeout
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $result = curl_exec($ch);
    /*Print Responce*/
    //$result = '1 : Invalid Username Or Password';
   
   // $result = explode(':', $result);
   
    $errorno = 0;
    $status = 'Successfully sent';
    if($result[0] != 'OK ID'){
        //$errorno = $result[0];
        //$status = $result[1];
    }

    //insert into db
    DB::table('sms_log')->insert(
        [
            'customer_id' => $customerId , 
            'errorno' => $errorno , 
            'status' => $result, 
            'msgdata' => $msg, 
            'receiver' => $num, 
            'sent_on' => date('Y-m-d H:i:s'), 
            'branch_id' => $branchId,  
            'user_id' => auth()->user()->id
        ]
    );

}

function smslimit(){

}

function insertreceivable(){
    
}

#this function is use for auto voucher creation 
function autoVoucherCreation($customer_id
                            ,$customer_name
                            ,$voucher_type_id
                            ,$remarks
                            ,$bp_type
                            ,$inv_id=0                            
                            ,$amount
                            ,$mapping_account
                            ,$po_id=0
                            ,$credit_ac=0
                            ,$tax_amount=0
                            ,$payment_mode='Other'
                            ,$discount_amount=0
                            ){
	
    # Getting accounts mapping data
    $voucherStatus = "success";
    $account_map = DB::table('account_voucher_mapping')->select()
    ->where('status', $mapping_account)
    ->where('business_id', auth()->user()->business_id)->first();

    $account_debit_id = $account_map->debit_account_id;
    #check if credit bank
    if ($credit_ac > 0)
        $account_credit_id = $credit_ac;
    else
        $account_credit_id = $account_map->credit_account_id;

    ///Creating Account Voucher 
    $last_voucher_id = DB::table('account_voucher')->latest('id_account_voucher')->where('account_voucher_type_id', $voucher_type_id)->first();

    #if tax applied
    $debitAmount = 0;
    if ($tax_amount > 0)
        $debitAmount = $amount + $tax_amount;
    else
        $debitAmount = $amount;

    $voucher_type = "";
    if ($voucher_type_id == 1) {
        $voucher_type = "RV-";
    } elseif ($voucher_type_id == 2) {
        $voucher_type = "PV-";
    } elseif ($voucher_type_id == 3) {
        $voucher_type = "JV-";
    } elseif ($voucher_type_id == 4) {
        $voucher_type = "SRV-";
    } elseif ($voucher_type_id == 5) {
        $voucher_type = "PRV-";
    }
    $VN = "";
    $voucher_number = "";
    $current_year_month = date('y') . date('m');
    if (isset($last_voucher_id)) {
        if (strpos($last_voucher_id->voucher_number, '-') !== false) {
            $temp = explode("-", $last_voucher_id->voucher_number);
            $db_year_month = substr($temp[1], 0, 4);
            if ($db_year_month == $current_year_month) {
                $VN = intval(substr($temp[1], 4, 10)) + 1;
                $voucher_number = $voucher_type . date('y') . date('m') . $VN;
            } else {
                $voucher_number = $voucher_type . date('y') . date('m') . '1';
            }
        } else {
            $voucher_number = $voucher_type . date('y') . date('m') . '1';
        }
    } else {
        $voucher_number = $voucher_type . date('y') . date('m') . '1';
    }

    $account_voucher = new AccountVoucher;
    $account_voucher->voucher_number = $voucher_number;
    $account_voucher->account_voucher_type_id = $voucher_type_id;
    $account_voucher->voucher_date = date("Y-m-d");
    $account_voucher->description = $remarks;
    $account_voucher->voucher_status = "Posted";
    $account_voucher->bp_id = $customer_id;
    $account_voucher->bp_type = $bp_type;
    $account_voucher->bp_name = $customer_name;
    $account_voucher->purchase_order_id = 0;
    //$account_voucher->grn_id = $po_id;
    //$account_voucher->gdn_id = $gdn_id;
    //$account_voucher->av_sale_order_id = $sale_order_id; 
    $account_voucher->invoice_number = $inv_id;
    //$account_voucher->sale_return_note_id = $RN_note_id;
    $account_voucher->verified = 'Unverified';
    $account_voucher->created_by = auth()->user()->id;
    $account_voucher->business_id = auth()->user()->business_id;

    //$details = $request->get('transactions');
    if ($account_voucher->save()) {

        $last_voucher_id = DB::table('account_voucher')->latest('id_account_voucher')->first();
        $account_voucher_details = new AccountVoucherDetails;
        $account_voucher_details->transaction_account_id = $account_debit_id;
        $account_voucher_details->account_voucher_id = $last_voucher_id->id_account_voucher;
        $account_voucher_details->remarks = $remarks;
        $account_voucher_details->payment_mode = $payment_mode;
        $account_voucher_details->payment_method = $payment_mode;
        $account_voucher_details->instrument_no = 0;
        $account_voucher_details->cost_center_type = "Branch";
        $account_voucher_details->cost_center_name = "Main Outlet";
        $account_voucher_details->cost_center_id = 1;
        $account_voucher_details->invoice_number = $inv_id;
        $account_voucher_details->voucher_detail_date = date("Y-m-d");
        $account_voucher_details->transaction_type = "Debit";
        $debits = str_replace(',', '', $debitAmount);
        if ($discount_amount > 0) {
            $debits = $debits; //- $discount_amount;
        }

        $account_voucher_details->debit = $debits;
        $account_voucher_details->credit = 0;
        $account_voucher_details->save();

        $account_voucher_details = new AccountVoucherDetails;
        $account_voucher_details->transaction_account_id = $account_credit_id;
        $account_voucher_details->account_voucher_id = $last_voucher_id->id_account_voucher;
        $account_voucher_details->remarks = $remarks;
        $account_voucher_details->payment_mode = $payment_mode;
        $account_voucher_details->payment_method = $payment_mode;
        $account_voucher_details->instrument_no = 0;
        $account_voucher_details->cost_center_type = "Branch";
        $account_voucher_details->cost_center_name = "Main Outlet";
        $account_voucher_details->cost_center_id = 1;
        $account_voucher_details->invoice_number = $inv_id;
        $account_voucher_details->voucher_detail_date = date("Y-m-d");
        $account_voucher_details->transaction_type = "Credit";
        $account_voucher_details->debit = 0;
        $account_voucher_details->credit = str_replace(',', '', $amount + $discount_amount);
        $account_voucher_details->save();
        
        if ($tax_amount > 0) {
            # Getting accounts mapping data
            $account_map = DB::table('account_voucher_mapping')->select()->
            where('status', 'Sale_tax')->where('business_id', auth()->user()->business_id)->first();
            $tax_account_credit_id = $account_map->credit_account_id;

            $account_voucher_details = new AccountVoucherDetails;
            $account_voucher_details->transaction_account_id = $tax_account_credit_id; // sale tax
            $account_voucher_details->account_voucher_id = $last_voucher_id->id_account_voucher;
            $account_voucher_details->remarks = "Sale tax added against Invoice # $inv_id";
            $account_voucher_details->payment_mode = $payment_mode;
            $account_voucher_details->payment_method = $payment_mode;
            $account_voucher_details->instrument_no = 0;
            $account_voucher_details->cost_center_type = "Branch";
            $account_voucher_details->cost_center_name = "Main Outlet";
            $account_voucher_details->cost_center_id = 1;
            $account_voucher_details->invoice_number = $inv_id;
            $account_voucher_details->voucher_detail_date = date("Y-m-d");
            $account_voucher_details->transaction_type = "Credit";
            $account_voucher_details->debit = 0;
            $account_voucher_details->credit = str_replace(',', '', $tax_amount);
            $account_voucher_details->save();
            $voucherStatus = "success";
        }

        if ($discount_amount > 0) {

            # Get Sale Discount account mapping
            $account_map = DB::table('account_voucher_mapping')->select()->where('status', 'Sale_Discount')
            ->where('business_id', auth()->user()->business_id)->first();
            $sale_discount_ac = $account_map->credit_account_id;
            $ac_type = $account_map->debit_account_id;

            $sale_discount_type = "";
            if ($ac_type == 1) {
                $sale_discount_type = "Debit";
            } else {
                $sale_discount_type = "Credit";
            }

            $account_voucher_details = new AccountVoucherDetails;
            $account_voucher_details->transaction_account_id = $sale_discount_ac; // sale tax
            $account_voucher_details->account_voucher_id = $last_voucher_id->id_account_voucher;
            $account_voucher_details->remarks = "Sale Discount added against Invoice # $inv_id";
            $account_voucher_details->payment_mode = $payment_mode;
            $account_voucher_details->payment_method = $payment_mode;
            $account_voucher_details->instrument_no = 0;
            $account_voucher_details->cost_center_type = "Branch";
            $account_voucher_details->cost_center_name = "Main Outlet";
            $account_voucher_details->cost_center_id = 1;
            $account_voucher_details->invoice_number = $inv_id;
            $account_voucher_details->voucher_detail_date = date("Y-m-d");
            $account_voucher_details->transaction_type = $sale_discount_type;
            if ($sale_discount_type == 'Debit') {
                $account_voucher_details->debit = str_replace(',', '', $discount_amount);
                $account_voucher_details->credit = 0;
            } else {
                $account_voucher_details->debit = 0;
                $account_voucher_details->credit = str_replace(',', '', $discount_amount);
            }
            if($account_voucher_details->save()){
                $voucherStatus ="success";
            }
            else{
                $voucherStatus="voucher details fail";
            }
        }
             
    } else{
         $voucherStatus = "voucher creation failed";
        } 

        return $voucherStatus;
    
}

#Get Total Customer count
function getTotalCustomerCount(){
    $customers = Customers::count();
    return $customers;
}

function getTotalPlotCount(){
    $plots = Plots::count();
    return $plots;
}

function getTotalSellPlotCount(){
    $plots = Plots::where('is_booked', 'Yes')->count();
    return $plots;
}

function getTotalRemainPlotCount(){
    $plots = Plots::where('is_booked', 'No')->count();
    return $plots;
}

function metaOption($option){
    $metaOption = DB::table('meta_option')->where('option_title', $option)->first();
    return $metaOption->option_value;
}
