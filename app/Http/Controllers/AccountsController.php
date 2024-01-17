<?php

namespace App\Http\Controllers;

use App\my_job;
use App\Http\Controllers\Controller;
use App\my_team_job;
use App\payment;
use App\payments_account;
use App\quotation;
use App\remarks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment_invoice_list()
    {
        $payments = payments_account::with('get_quotation', 'get_quotation.get_inquiry', 'get_quotation_details')->orderby('status', 'desc')->groupBy('payment_id')->get();
        $payment_invoice_list = payments_account::with('get_quotation', 'get_quotation.get_inquiry', 'get_quotation_details')->orderby('status', 'desc')->get();
//         dd($payments);
        // dd($payment_invoice_list);
        return view('accounts.payment_invoice_list', compact('payments', 'payment_invoice_list'));
    }
    public function pending_payment_list()
    {
        $payments = payments_account::with('get_quotation', 'get_quotation.get_inquiry', 'get_quotation_details')->orderby('status', 'desc')->groupBy('payment_id')->where('total_quotation_remaining_amount', '!=', 0)->get();
        // dd($payments);
        $pending_payment_list = payments_account::with('get_quotation', 'get_quotation.get_inquiry', 'get_quotation_details')->orderby('status', 'desc')->get();

        // dd($pending_payment_list);
        return view('accounts.pending_amount_list', compact('pending_payment_list', 'payments'));
    }
    public function cheque_list()
    {
        $payments = payments_account::with('get_quotation', 'get_quotation.get_inquiry', 'get_quotation_details')->orderby('status', 'asc')->groupBy('payment_id')->where('payment_type', '=', 'Cheque')->get();
        // dd($payments);
        $cheque_list = payments_account::with('get_quotation', 'get_quotation.get_inquiry', 'get_quotation_details')->where('payment_type', '=', 'Cheque')->orderby('cheque_date', 'desc')->get();

        // dd($pending_payment_list);
        return view('accounts.cheque_list', compact('cheque_list', 'payments'));
    }
    public function roe_difference_list()
    {
        $payments = payments_account::with('get_quotation', 'get_quotation.get_inquiry', 'get_quotation_details')->orderby('status', 'asc')->groupBy('payment_id')->where('payment_type', '=', 'Cheque')->get();
        // dd($payments);
        $cheque_list = payments_account::with('get_quotation', 'get_quotation.get_inquiry', 'get_quotation_details')->where('payment_type', '=', 'Cheque')->orderby('cheque_date', 'desc')->get();

        // dd($pending_payment_list);
        return view('accounts.roe_difference_list', compact('cheque_list', 'payments'));
    }
    public function accounts_issuance_list()
    {
        $payments = payments_account::with('get_quotation', 'get_quotation.get_inquiry', 'get_quotation_details')->orderby('status', 'asc')->groupBy('payment_id')->where('payment_type', '=', 'Cheque')->get();
        // dd($payments);
        $cheque_list = payments_account::with('get_quotation', 'get_quotation.get_inquiry', 'get_quotation_details')->where('payment_type', '=', 'Cheque')->orderby('cheque_date', 'desc')->get();

        // dd($pending_payment_list);
        return view('accounts.issuance_list', compact('cheque_list', 'payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($inq_id, $team_id)
    {

        $dec_inq_id = Crypt::decrypt($inq_id);
        $dec_team_id = Crypt::decrypt($team_id);

        $inquiry = \App\inquiry::where('id_inquiry', $dec_inq_id)->first();
        $inquiry_types = \App\inquirytypes::where('type_id', $inquiry->inquiry_type)->first();

        $my_job_create = new my_job();
        $my_job_create->inquiry_id = $dec_inq_id;
        $my_job_create->user_id = auth()->user()->id;
        $my_job_create->team_job_id = $dec_team_id;
        $my_job_create->save();

        $find_team_job = my_team_job::where('id_my_team_jobs', $dec_team_id)->first();
        $find_team_job->taken_by = $my_job_create->user_id;
        $find_team_job->taken_by_status = 1;
        $find_team_job->save();

        $users = \App\User::where('id', auth()->user()->id)->first();
        sendNoti('New ' . $inquiry_types->type_name . ' Inquiry', $users->name, 'self_inquiry', auth()->user()->id);
        session()->flash('success', 'Inquiry Assign Successfully');
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function update_receiving_number(Request $request)
    {
//        dd($request->quote_pay_id);exit;
//        $request->validate([
//            'accounts_rv_number' => 'required',
//        ]);
         
        $get_payment_details = payments_account::where('id_account_payments', $request->quote_pay_id)->first();
        $get_inquiry_id = quotation::where('id_quotations', $get_payment_details->quotation_id)->select('inquiry_id')->first();
        // dd($get_inquiry_id);

        if ($request->accounts_rv_number !== null && $request->accounts_payment_verification == null) {
            $get_payment_details->recieving_number = $request->accounts_rv_number;
            $get_payment_details->account_number = $request->accounts_ac_number;
            $get_payment_details->cheque_number = $request->accounts_cheque_number;
            $get_payment_details->status = 1;
            $get_payment_details->r_number_created_by = auth()->user()->id;
            $get_payment_details->save();
            // dd($get_payment_details);
            $store = new remarks();
            $store->inquiry_id = $get_inquiry_id->inquiry_id;
            $store->remarks = "RV Number Received By " . auth()->user()->name . " Against -" . $get_payment_details->pay_no;
            $store->remarks_status = "Quotation Shared";
            $store->type = "payments";
            $store->cancel_reason = "";
            $store->followup_date = "";
            $store->created_by = auth()->user()->id;
            $store->save();
            sendNoti("RV Number Received By " . auth()->user()->name . " Against -" . $get_payment_details->pay_no, auth()->user()->name, 'Payments', auth()->user()->id, null);
            session()->flash('success', 'Payment Successfully Received!');


        return redirect()->back();
        }
        if ($request->accounts_payment_verification !== null) {
            $payment_verification = 1;
//            dd($request->accounts_payment_verification);exit;
            $get_payment_details->recieving_number = $request->accounts_rv_number;
            $get_payment_details->account_number = $request->accounts_ac_number;
            $get_payment_details->cheque_number = $request->accounts_cheque_number;
            $get_payment_details->payment_verification = $payment_verification;
            $get_payment_details->status = 2;
            $get_payment_details->r_number_created_by = auth()->user()->id;
            $get_payment_details->save();
            // dd($get_payment_details);
            $store = new remarks();
            $store->inquiry_id = $get_inquiry_id->inquiry_id;
            $store->remarks = "RV Number & Payment Verified By " . auth()->user()->name . " Against -" . $get_payment_details->pay_no;
            $store->remarks_status = "Quotation Shared";
            $store->type = "payments";
            $store->cancel_reason = "";
            $store->followup_date = "";
            $store->created_by = auth()->user()->id;
            $store->save();
            sendNoti("RV Number Received By " . auth()->user()->name . " Against -" . $get_payment_details->pay_no, auth()->user()->name, 'Payments', auth()->user()->id, null);
            session()->flash('success', 'Success!, Payment Received & Verified');
            return redirect()->back();
            }
        
    }
    public function assign_job(Request $request)
    {
        // dd($request);
        $dec_inq_id = $request->inq_id;
        $dec_team_id = $request->t_id;

        $inquiry = \App\inquiry::where('id_inquiry', $dec_inq_id)->first();
        $inquiry_types = \App\inquirytypes::where('type_id', $inquiry->inquiry_type)->first();

        $my_job_create = new my_job();
        $my_job_create->inquiry_id = $dec_inq_id;
        $my_job_create->user_id = $request->user_id;
        $my_job_create->team_job_id = $dec_team_id;
        $my_job_create->assign_by = auth()->user()->id;
        $my_job_create->save();

        $find_team_job = my_team_job::where('id_my_team_jobs', $dec_team_id)->first();
        $find_team_job->taken_by = $my_job_create->user_id;
        $find_team_job->taken_by_status = 1;
        $find_team_job->save();

        $users = \App\User::where('id', $my_job_create->user_id)->first();
        sendNoti('New ' . $inquiry_types->type_name . ' Inquiry', $users->name, 'self_inquiry', $my_job_create->user_id);
        return redirect()->back();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\my_job  $my_job
     * @return \Illuminate\Http\Response
     */
    public function show(my_job $my_job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\my_job  $my_job
     * @return \Illuminate\Http\Response
     */
    public function edit(my_job $my_job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\my_job  $my_job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, my_job $my_job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\my_job  $my_job
     * @return \Illuminate\Http\Response
     */
    public function destroy(my_job $my_job)
    {
        //
    }

    public function followups()
    {

        return view('followups.index');
    }
}
