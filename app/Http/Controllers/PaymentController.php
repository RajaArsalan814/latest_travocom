<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\payment;
use App\payments_account;
use App\quotation;
use App\quotations_detail;
use App\remarks;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    public function pay_quotation_amount(Request $request)
    {
//         dd($request->pay_inq_id);
        $request->validate([
            'enter_amount' => "required",
            // 'image_file' => "required",
            'payment_type' => "required",
        ]);
        $get_total_r_payment = 0;
        $get_q = quotation::where('inquiry_id', $request->pay_inq_id)->where('status', '>=', 3)->latest()->first();
//        dd($get_q);
        $get_quote_details = quotations_detail::Where("id_quotation_details", $get_q?->quotations_details_id)->first();
        $get_quote_payment = payment::Where("quotation_id", $get_q?->id_quotations)->first();
         
        $get_details = quotations_detail::where('uniq_id', $get_q?->quotations_details_id)
            ->get();
        $get_total = 0;
//         dd($get_quote_payment);
        foreach ($get_details as $key => $value) {
            if ($value->type == 'service_level') {
                $get_total_detail = quotations_detail::where('uniq_id',  $get_q?->quotations_details_id)
                    ->select('total')
                    ->get()
                    ->sum('total');
                $get_total = $get_total_detail;
            } else {
                $get_total_detail = quotations_detail::where('uniq_id',  $get_q?->quotations_details_id)
                    ->select('total')
                    ->first();
                $get_total += $get_total_detail?->total;
            }
        }
//         dd($request->pay_inq_id);
        $max_id_pay_acc = payments_account::max('id_account_payments');
        if ($max_id_pay_acc) {
            $max_id_pay_acc = $max_id_pay_acc + 1;
        } else {
            $max_id_pay_acc = 1;
        }
        if($get_q?->id_quotations !== null){
         
        $get_total_r_payment = payment::Where("quotation_id", $get_q?->id_quotations)->get()->sum('paid_amount');
           
        }else{
            $get_total_r_payment = 0;
        }
//        dd($get_total_r_payment);
        if ($get_quote_details?->type == 'service_level') {
            $get_pay_sum = quotations_detail::Where("uniq_id", $get_q?->quotations_details_id)->get()->sum('total');
            // dd($get_pay_sum);
        } else {
            $get_pay_sum = $get_quote_details?->total;
        }
        if ($get_quote_payment != null) {
            if ($request->enter_amount) {
                $get_quote_payment->quotation_id = $get_q?->id_quotations;

                $get_quote_payment->quotation_detail_id = json_encode($request->services_type);
                $get_quote_payment->total_quotation_amount = $get_total;
//                $get_quote_payment->services_type = json_encode($request->services_type);;
                $get_quote_payment->total_amount = $get_quote_details?->total;
                $paid_amount = $get_quote_payment->paid_amount + $request->enter_amount;
                $get_quote_payment->paid_amount = $paid_amount;
                $get_quote_payment->total_quotation_r_amount = $get_quote_payment->total_quotation_r_amount + $request->enter_amount;
                $get_quote_payment->remaining_amount = ($get_quote_details?->total - $paid_amount);
                $get_quote_payment->save();
                // dd($get_quote_payment->total_quotation_r_amount);
                if (isset($request->image_file)) {
                    $fileName = time() . '.' . $request->image_file->extension();
                    // dd($fileName);
                    $request->image_file->move(public_path('images/payments'), $fileName);
                    $get_file_name = 'images/payments/' . $fileName;
                }
                $payment = new payments_account();
                $payment->quotation_id = $get_q?->id_quotations;
                $payment->inquiry_id = $request->pay_inq_id;
                $payment->pay_no = 'PAY#' . date('ym') . '-' . $max_id_pay_acc;
                $payment->quotation_detail_id = json_encode($request->services_type);
//                $payment->services_type = json_encode($request->services_type);
                $payment->payment_id = $get_quote_payment->id_payments;
                $payment->total_quotation_remaining_amount = $get_total - $get_quote_payment->total_quotation_r_amount;
                $payment->total_amount = $get_quote_details?->total;
                if (isset($request->image_file)) {
                    $payment->attachment = $get_file_name;
                }
                $payment->paid_amount = $request->enter_amount;
                $payment->total_quotation_amount = $get_total;
                $payment->total_quotation_recived_amount = $get_quote_payment->total_quotation_r_amount;
                $payment->payment_type = $request->payment_type;
                $payment->bank_name = $request->bank_name;
                $payment->our_bank = $request->my_bank;
                $payment->deposit_date = $request->deposit_date;
                $payment->clearing_date = $request->clearing_date;
                
                $payment->payment_remarks = $request->payment_remarks;
                $payment->cheque_date = $request->cheque_date;
                $payment->created_by = auth()->user()->id;
                $payment->remaining_amount = 0;
                $payment->save();


                $store = new remarks();
                $store->inquiry_id = $request->pay_inq_id;
                $store->remarks = "Payment Send To Accounts - " . 'PAY#' . date('ym') . '-' . $max_id_pay_acc;
                $store->remarks_status = "Quotation Shared";
                $store->type = "payments";
                $store->cancel_reason = "";
                $store->followup_date = "";
                $store->created_by = auth()->user()->id;
                $store->save();

                sendNoti('New Payment Received PAY#' . date('ym') . '-' . $max_id_pay_acc, auth()->user()->name, 'Payments', auth()->user()->id, null);
                session()->flash('success', 'Payment Received Successfully');
                return redirect()->back();
            } else {
                session()->flash('error', 'Please enter a valid amount');
                return redirect()->back();
            }
        } else {
            if ($request->enter_amount) {
                // dd($get_q->id_quotations);
                $payment = new payment();
                $payment->quotation_id = $get_q?->id_quotations;
                $payment->quotation_detail_id = json_encode($request->services_type);
//                $payment->services_type = json_encode($request->services_type);
                $payment->total_quotation_amount = $get_total;
                $payment->total_amount = $get_quote_details?->total;
                $payment->total_quotation_r_amount = $payment->total_quotation_r_amount + $request->enter_amount;
                $payment->paid_amount = $request->enter_amount;
                $payment->remaining_amount = ($get_quote_details?->total - $request->enter_amount);
                $payment->save();

                if (isset($request->image_file)) {
                    $fileName = time() . '.' . $request->image_file->extension();
                    // dd($fileName);
                    $request->image_file->move(public_path('images/payments'), $fileName);
                    $get_file_name = 'images/payments/' . $fileName;
                }

                $payment_ac = new payments_account();
                $payment_ac->quotation_id = $get_q?->id_quotations;
                $payment_ac->inquiry_id = $request->pay_inq_id;
                $payment_ac->pay_no = 'PAY#' . date('ym') . '-' . $max_id_pay_acc;
                // dd($get_q->id_quotations);
                $payment_ac->quotation_detail_id = json_encode($request->services_type);
//                $payment_ac->services_type = json_encode($request->services_type);
                $payment_ac->payment_id = $payment->id_payments;
                $payment_ac->total_amount = $get_quote_details->total;
                if (isset($request->image_file)) {
                    $payment->attachment = $get_file_name;
                }
                $payment_ac->paid_amount = $request->enter_amount;
                $payment_ac->total_quotation_amount = $get_total;
                $payment_ac->total_quotation_recived_amount = $payment->total_quotation_r_amount;
                $payment_ac->total_quotation_remaining_amount = $get_total - $payment->total_quotation_r_amount;
                $payment_ac->payment_type = $request->payment_type;
                $payment_ac->bank_name = $request->bank_name;
                $payment_ac->account_number = $request->account_number;
                $payment_ac->cheque_number = $request->cheque_no;
                $payment_ac->created_by = auth()->user()->id;
                $payment_ac->remaining_amount = ($get_quote_details->total - $request->enter_amount);
                $payment_ac->save();



                $store = new remarks();
                $store->inquiry_id = $request->pay_inq_id;
                $store->remarks = "Payment Send To Accounts - " . 'PAY#' . date('ym') . '-' . $max_id_pay_acc;
                $store->remarks_status = "Quotation Shared";
                $store->type = "payments";
                $store->cancel_reason = "";
                $store->followup_date = "";
                $store->created_by = auth()->user()->id;
                $store->save();

                sendNoti('New Payment Received Against PAY#' . date('ym') . '-' . $max_id_pay_acc, auth()->user()->name, 'Payments', auth()->user()->id, null);

                session()->flash('success', 'Payment Paid Successfully');
                return redirect()->back();
            } else {
                session()->flash('error', 'Please Enter Valid Amount');
                return redirect()->back();
            }
        }
    }
}
