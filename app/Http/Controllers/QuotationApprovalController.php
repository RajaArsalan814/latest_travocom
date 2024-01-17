<?php

namespace App\Http\Controllers;

use App\approval_group;
use App\campaign;
use App\cost_price_of_sales_person;
use App\currency_exchange_rate;
use App\Customer;
use App\follow_up_type;
use App\inquiry;
use App\issuance_verification;
use App\issuance_rejection;
use App\issuance_verified_detail;
use App\office_working_hour;
use App\other_service;
use App\quotation;
use App\quotation_approval;
use App\quotation_issuance;
use App\quotations_detail;
use App\remarks;
use App\role_permission;
use App\service_vendor;
use App\service_voucher;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class QuotationApprovalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware(function ($request, $next) {
    //         $this->role_id = Auth::user()->role_id;
    //         //    $slug_filter = preg_replace('/[0-9]+/', '', $request->path());
    //         //    $slug_filter = preg_replace('/[0-9]+/', '', $request->path());
    //         $ex = explode('/', $request->path());
    //         if (count($ex) >= 3) {
    //             $sliced = array_slice($ex, 0, -1);
    //         } else {
    //             $sliced = $ex;
    //         }

    //         $string = implode("/", $sliced);
    //         //                 dd($string);
    //         if (checkConstructor($this->role_id, count($ex) >= 3 ? $string . '/' : $string) == 1) {
    //             return $next($request);
    //         } else if (strpos($request->path(), 'store') !== false) {
    //             return $next($request);
    //         } else if (strpos($request->path(), 'update') !== false) {
    //             return $next($request);
    //         } else {
    //             abort(404);
    //         }
    //     });
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $quotation_approval = quotation_approval::join('quotations', 'quotations.id_quotations', '=', 'quotation_approvals.quotation_id')->select('*', 'quotation_approvals.status as q_status', 'quotation_approvals.created_at')->where('quotation_approvals.status', "Open")->get();
        $get_quotations_approval_data = [];
        foreach ($quotation_approval as $key => $value) {
//             dd($value);
            $get_id_array = json_decode($value->user_id);
            // dd($get_id_array);
            $get_count = count($get_id_array);
            for ($i = 0; $i < $get_count; $i++) {
                $user_name = User::select('name')->where('id', $value->created_by)->first();
//                 dd($user_name);
                if ($get_id_array[$i] == auth()->user()->id) {
                    $get_user_name = $value->created_name;
                    $get_quotations_approval_data[] = [
                        'id_quotation_approvals' => $value->id_quotation_approvals,
                        'quotation_no' => $value->quotation_no,
                        'inquiry_id' => $value->inquiry_id,
                        'user_id' => auth()->user()->id,
                        'status' => $value->q_status,
                        'quotation_id' => $value->quotation_id,
                        'user_name' => $user_name->name,
                        'created_at' => $value->created_at,
                        'approved_by' => $value->approved_by,
                    ];
                }
            }
        }

        $get_my_quotations_approval_data = quotation_approval::where('approved_by', auth()->user()->id)->with('get_quotation', 'get_user')->get();
//        dd($get_my_quotations_approval_data);
        $get_all_quotations_issuance = quotation_issuance::with('get_quotation', 'get_user')->get();
        $access_services = [];
        $get_all_quotations_issuance_id = [];
        $unaccess_services = [];
        $get_roles_permission_of_visa = role_permission::where('role_id', auth()->user()->role_id)->where("menu_id", 109)->first();
        $get_roles_permission_hotel = role_permission::where('role_id', auth()->user()->role_id)->where("menu_id", 110)->first();
        $get_roles_permission_air_ticket = role_permission::where('role_id', auth()->user()->role_id)->where("menu_id", 111)->first();
        $get_roles_permission_land_services = role_permission::where('role_id', auth()->user()->role_id)->where("menu_id", 112)->first();


        foreach ($get_all_quotations_issuance as $key => $value) {
            $find_user = User::find($value->assign_to);
            // dd($get_all_quotations_issuance);
            $quo_details = quotations_detail::where('quotation_id', $value->quotation_id)->get();
            $get_all_services_type = $value->services_type;
            if ($get_all_services_type == "Visa" && $get_roles_permission_of_visa) {

                if ($get_roles_permission_of_visa) {
                    $access_services[$value->quotation_id]["service_name"][] = "Visa";
                    // dd($value->quotation_id);
                    $access_services[$value->quotation_id]["user_name"][] = $find_user?->name;
                    $access_services[$value->quotation_id]["id_issuance"][] = $value->id_quotation_issuance;
                    // $access_services[$value->quotation_id][] = $find_user->name;
                    $get_all_quotations_issuance_id[] = $value->id_quotation_issuance;
                } else {
                    $unaccess_services[$value->quotation_id][] = "Visa";
                }
            }
            if ($get_all_services_type == "Hotel" && $get_roles_permission_hotel) {
                if ($get_roles_permission_hotel) {
                    $access_services[$value->quotation_id]['service_name'][] = "Hotel";
                    $access_services[$value->quotation_id]["user_name"][] = $find_user?->name;
                    $access_services[$value->quotation_id]["id_issuance"][] = $value->id_quotation_issuance;
                    $get_all_quotations_issuance_id[] = $value->id_quotation_issuance;
                } else {
                    $unaccess_services[$value->quotation_id][] = "Hotel";
                }
            }
            if ($get_all_services_type == "Air Ticket" && $get_roles_permission_air_ticket) {
                if ($get_roles_permission_air_ticket) {
                    $access_services[$value->quotation_id]["service_name"][] = "Air Ticket";
                    $access_services[$value->quotation_id]["user_name"][] = $find_user?->name;
                    $access_services[$value->quotation_id]["id_issuance"][] = $value->id_quotation_issuance;

                    $get_all_quotations_issuance_id[] = $value->id_quotation_issuance;
                } else {
                    $unaccess_services[$value->quotation_id][] = "Air Ticket";
                }
            }
            if ($get_all_services_type == "Land Services" && $get_roles_permission_land_services) {
                if ($get_roles_permission_land_services) {
                    $access_services[$value->quotation_id]['service_name'][] = "Land Services";
                    $access_services[$value->quotation_id]["user_name"][] = $find_user?->name;
                    $access_services[$value->quotation_id]["id_issuance"][] = $value->id_quotation_issuance;
                    $get_all_quotations_issuance_id[] = $value->id_quotation_issuance;
                } else {
                    $unaccess_services[$value->quotation_id][] = "Land Services";
                }
            }
        }
        // dd($access_services);
        $get_all_quotations_issuance_data = quotation_issuance::whereIn('id_quotation_issuance', $get_all_quotations_issuance_id)->with('get_quotation', 'get_user')->groupBy('quotation_id')->get();

        $get_my_quotations_issuance_data = quotation_issuance::where('assign_to', auth()->user()->id)->with('get_quotation', 'get_user')->groupBy('quotation_id')->get();
//         dd($get_all_quotations_issuance_data);

        return view('quotation_approvals.index', compact('get_quotations_approval_data', 'get_my_quotations_approval_data', 'get_all_quotations_issuance_data', 'unaccess_services', 'access_services', 'get_my_quotations_issuance_data'));
    }


    function issuance_verification($inq_id, $quote_id)
    {
        // dd($inq_id);

        $dec_inq_id = Crypt::decrypt($inq_id);
        $dec_quote_id = Crypt::decrypt($quote_id);
        $sales_person = User::get();
        $campaigns = \App\campaign::all();
        $services = other_service::where('parent_id', null)->get();
        $quotations = quotation::where('inquiry_id', $dec_inq_id)->orderBy('id_quotations', 'desc')->with('get_issuance')->get();

        $vendors = service_vendor::where('vendor_status', 1)->get();
        // dd($quotations);
        $quotations_not_approved = quotation::where('inquiry_id', $dec_inq_id)->get();

        $quotations_issuance = quotation_issuance::where('quotation_id', $dec_quote_id)->where('assign_to', auth()->user()->id)->get();
        foreach ($quotations_issuance as $key => $value) {
            $get_services_type[] = $value->services_type;
        }

        // dd($get_services_type);

        $get_quotation_details = quotations_detail::where('quotation_id', $dec_quote_id)->whereIn('services_type', $get_services_type)->get();
        $get_issuance = quotation_issuance::where('quotation_id', $dec_quote_id)->whereIn('services_type', $get_services_type)->where('assign_to', auth()->user()->id)->get();
        $get_rejected_issuance = issuance_rejection::where('inquiry_id', $dec_inq_id)->where('quotation_id', $dec_quote_id)->where('service_type', $get_services_type)->first();
//        dd($get_rejected_issuance);
        foreach ($get_issuance as $key => $value) {

            foreach ($get_services_type as $val2) {
                if ($value->services_type == $val2) {
                    $voucher_create = 1;
                } else {
                    $voucher_create = 0;
                }
            }
        }
        // dd($true);

        // if ($get_roles_permission) {
        //     $final_permission[] = $get_roles_permission;
        //     $final_user_ids[] = $value[1];
        // }
        // $sale_persons = \App\User::select('users.name', 'users.id')->where('role_id', '=', 6)->get()->toArray();
        $users = User::all();
        foreach ($users as $key => $value) {
            $user_role_id = $value->role_id;
            $all_roles_id[] = array($user_role_id, $value->id);
        }


        foreach ($all_roles_id as $key => $value) {
            $get_roles_permission = role_permission::where('role_id', $value[0])->where("menu_id", 96)->first();
            if ($get_roles_permission) {
                $final_permission[] = $get_roles_permission;
                $final_user_ids[] = $value[1];
            }
        }

        $uniq_user_id = array_unique($final_user_ids);
        $sale_persons = User::whereIn('id', $uniq_user_id)->get();

        $get_inquiry = inquiry::where('id_inquiry', $dec_inq_id)->first();

        $decode_services = json_decode($get_inquiry->services_sub_services);
        foreach ($decode_services as $key => $value) {
            $explode = explode('/', $value);
            $get_explode_sub_services = $explode[1];
            $services_id[] = $explode[0];
            $explode_sub_services[] = explode(',', $get_explode_sub_services);
        }
        $echo_services_data = "";

        $services_option = "";
        foreach ($services_id as $key => $service) {
            $services_inq[] = other_service::where('id_other_services', $service)->first();
        }
        // dd($services_inq);
        // dd($services_option);
        // dd($services);
        $get_customer = Customer::where('id_customers', $get_inquiry->customer_id)->first();
        $get_campaign = campaign::where('id_campaigns', $get_inquiry->campaign_id)->first();
        $currency_rates = currency_exchange_rate::all();
        // dd($get_inquiry);
        $all_remarks = remarks::where('inquiry_id', $dec_inq_id)->where('followup_remarks', null)->where('type', Null)->orderBy('id_remarks', 'desc')->get();
        $quotation_remarks = remarks::where('inquiry_id', $dec_inq_id)->where('followup_remarks', null)->where('type', "quotation")->orderBy('id_remarks', 'desc')->get();
        $followup_remarks = remarks::where('inquiry_id', $dec_inq_id)->where('remarks', null)->orderBy('id_remarks', 'desc')->get();
        $followup_types = follow_up_type::get();
        $get_latest_remarks_count = remarks::where('inquiry_id', $dec_inq_id)->max('id_remarks');
        $get_latest_remarks = remarks::where('id_remarks', $get_latest_remarks_count)->first();
//        dd($dec_quote_id);exit;
        return view('issuance_verification.issuance_verification', compact('get_rejected_issuance', 'dec_quote_id', 'dec_inq_id', 'voucher_create', 'vendors', 'get_issuance', 'get_quotation_details', 'sales_person', 'quotation_remarks', 'currency_rates', 'quotations_not_approved', 'quotations', 'all_remarks', 'get_latest_remarks', 'get_inquiry', 'get_customer', 'get_campaign', 'campaigns', 'services_inq', 'sale_persons', 'echo_services_data', 'followup_remarks', 'followup_types'));
    }
    public function create_voucher($id)
    {
        $dec_id = Crypt::decrypt($id);
//         dd($dec_id);
        $get_quotation = quotation::where('id_quotations', $dec_id)->first();
        $get_inquiry_id = Crypt::encrypt($get_quotation->inquiry_id);
        $quotation_details = quotations_detail::where('uniq_id', $get_quotation->quotations_details_id)->get();
        // $quotation_details = issuance_verified_detail::where('quotation_id', $dec_id)->get();
        $get_max = service_voucher::max('id_service_vouchers');
        if ($get_max) {
            $get_max = $get_max + 1;
        } else {
            $get_max = 1;
        }
        // dd($get_max);
        $voucher = new service_voucher();
        $voucher->voucher_no = 'V#' . date('ym') . '-' . $get_max;
        $voucher->quotation_id = $get_quotation->id_quotations;
        $voucher->created_by = auth()->user()->id;
        $voucher->save();
        session()->flash('success', 'Voucher Created Successfully');
        return redirect('view_voucher/' . $id . '/' . $get_inquiry_id);
    }

    public function quotation_approved($quotation_id, $inquiry_id)
    {
        try {
            $quote_id = Crypt::decrypt($quotation_id);
            $inq_id = Crypt::decrypt($inquiry_id);
            $store = quotation_approval::where('quotation_id', $quote_id)->where('inquiry_id', $inq_id)->first();
            $store->status = "Approved";
            $store->approved_by = auth()->user()->id;
            $store->save();
            if ($store) {
                 
                $store_quo = quotation::where('id_quotations', $store->quotation_id)->first();
                $store_quo->status = 3;
                $store_quo->save();
//                dd($store->quotation_id);
                $store_rem = new remarks();
                $store_rem->inquiry_id = $store->inquiry_id;
                $store_rem->remarks = "Quotation Approved - " . $store_quo->quotation_no;
                $store_rem->remarks_status = "Quotation Approved";
                $store_rem->quotation_id = $store->quotation_id;
                $store_rem->type = "quotation";
                $store_rem->cancel_reason = "";
                $store_rem->followup_date = "";
                $store_rem->created_by = auth()->user()->id;
                $store_rem->save();
            }
            $get_approval_group_id = approval_group::select('user_id')->get()->toArray();
            $get_approval_ids = [];
            foreach ($get_approval_group_id as $app_user_id) {
                sendNoti('Quotation Approved Against-' . $store_quo->quotation_no, null, 'quotation_approval', $app_user_id['user_id']);
            }
            session()->flash('success', 'Update Successfully');
            return redirect('quotation_approvals');
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->back();
    }
    public function quotation_disapproved($quotation_id, $inquiry_id, Request $request)
    {
        try {
            $quote_id = Crypt::decrypt($quotation_id);
            $inq_id = Crypt::decrypt($inquiry_id);
            // dd();
            $store = quotation_approval::where('quotation_id', $quote_id)->where('inquiry_id', $inq_id)->first();
            $store->status = "DisApproved";
            $store->approved_by = auth()->user()->id;
            $store->save();
            if ($store) {
                $store_quo = quotation::where('id_quotations', $store->quotation_id)->first();
                $store_quo->status = 4;
                $store_quo->save();

                $store_rem = new remarks();
                $store_rem->inquiry_id = $store->inquiry_id;
                $store_rem->quotation_id = $store->quotation_id;
                $store_rem->remarks = "Quotation Rejected - " . $store_quo->quotation_no;
                $store_rem->remarks_status = "Quotation Rejected";
                $store_rem->type = "quotation";
                $store_rem->cancel_reason = $request->cancel_reason;
                $store_rem->followup_date = "";
                $store_rem->created_by = auth()->user()->id;
                $store_rem->save();
            }

            $get_approval_group_id = approval_group::select('user_id')->get()->toArray();
            $get_approval_ids = [];
            foreach ($get_approval_group_id as $app_user_id) {
                sendNoti('Quotation Rejected Against-' . $store_quo->quotation_no, null, 'quotation_approval', $app_user_id['user_id']);
            }
            session()->flash('success', 'Update Successfully');
            return redirect('quotation_approvals');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function reject_issuance($quote_id, $inq_id, $service_type, Request $request)
    {
//        dd($hotel_leg_no);exit;
        try {
            $quotation_id = Crypt::decrypt($quote_id);
            $inquiry_id = Crypt::decrypt($inq_id);
            $service_type = Crypt::decrypt($service_type);
//            $leg_no = Crypt::decrypt($hotel_leg_no);
//             dd($hotel_leg_no);
            $store = quotation_issuance::where('inquiry_id', $inquiry_id)->where('quotation_id', $quotation_id)->where('services_type', $service_type)->first();
            $store->status = "Rejected";
            $store->save();
//            dd($store);
            if ($store) {
                $store_quo = quotation::where('id_quotations', $quotation_id)->first();
                $store_quo->save();

                $store_rem = new remarks();
                $store_rem->inquiry_id = $store->inquiry_id;
                $store_rem->quotation_id = $store->quotation_id;
                $store_rem->remarks = "Quotation Issuance (".$service_type.") Rejected - " . $store_quo->quotation_no;
                $store_rem->remarks_status = "Quotation Issuance Rejected";
                $store_rem->type = "quotation";
                $store_rem->cancel_reason = $request->cancel_reason;
                $store_rem->followup_date = "";
                $store_rem->created_by = auth()->user()->id;
                $store_rem->save();
                
                $store_rejection = new issuance_rejection();
                $store_rejection->issuance_id = $store->id_quotation_issuance;
                $store_rejection->inquiry_id = $store->inquiry_id;
                $store_rejection->quotation_id = $store->quotation_id;
                $store_rejection->leg_no = $hotel_leg_no;
                $store_rejection->service_type = $service_type;
                $store_rejection->status = $service_type.' Issuance Rejected';
                $store_rejection->created_by = auth()->user()->id;
                $store_rejection->save();
            }

            
                sendNoti('Quotation Issuance ('.$service_type.') Rejected Against-' . $store_quo->quotation_no, null, 'quotation_issuance', auth()->user()->id);
            
            session()->flash('success', 'Issuance Rejected Successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\office_working_hour  $office_working_hour
     * @return \Illuminate\Http\Response
     */
    public function take_quotation_issuance($quotation_id, $assuance_id)
    {
        // dd($quotation_id);
        $dec_q_id = Crypt::decrypt($quotation_id);
        $dec_assuance_id = Crypt::decrypt($assuance_id);
        $get_quotation_issuance = quotation_issuance::where('quotation_id', $dec_q_id)->get();
        $get_quotation = quotation::where('id_quotations', $dec_q_id)->select('quotation_no','inquiry_id')->first();
        $get_sale_person = inquiry::where('id_inquiry', $get_quotation->inquiry_id)->select('saleperson')->first();
        // dd($get_sale_person);

        $get_roles_permission_of_visa = role_permission::where('role_id', auth()->user()->role_id)->where("menu_id", 109)->first();
        $get_roles_permission_hotel = role_permission::where('role_id', auth()->user()->role_id)->where("menu_id", 110)->first();
        $get_roles_permission_air_ticket = role_permission::where('role_id', auth()->user()->role_id)->where("menu_id", 111)->first();
        $get_roles_permission_land_services = role_permission::where('role_id', auth()->user()->role_id)->where("menu_id", 112)->first();
        foreach ($get_quotation_issuance as $key => $value) {
            $get_all_services_type = $value->services_type;

            if ($get_all_services_type == "Visa" && $get_roles_permission_of_visa) {

                if ($get_roles_permission_of_visa) {
                    $get_quotation_issuance = quotation_issuance::where('id_quotation_issuance', $value->id_quotation_issuance)->first();
                    $get_quotation_issuance->assign_to = auth()->user()->id;
                    $get_quotation_issuance->status = "Assign";
                    $get_quotation_issuance->save();

                    if ($get_quotation_issuance) {
                        $store_rem = new remarks();
                        $store_rem->inquiry_id = $get_quotation_issuance->inquiry_id;
                        $store_rem->quotation_id = $dec_q_id;
                        $store_rem->remarks = "Quotation Issuance(Visa) Assign To  - " . auth()->user()->name . $get_quotation->quotation_no;
                        $store_rem->remarks_status = "Quotation Issuance Assign";
                        $store_rem->type = "quotation";
                        $store_rem->cancel_reason = $get_quotation_issuance->cancel_reason;
                        $store_rem->followup_date = "";
                        $store_rem->created_by = auth()->user()->id;
                        $store_rem->save();
                        sendNoti('Issuance(Visa) Taken By -' . auth()->user()->name, null, 'quotation_issuance', $get_sale_person->saleperson, null);
                    }
                } else {
                }
            }
            if ($get_all_services_type == "Hotel" && $get_roles_permission_hotel) {
                if ($get_roles_permission_hotel) {
                    $get_quotation_issuance = quotation_issuance::where('id_quotation_issuance', $value->id_quotation_issuance)->first();
                    $get_quotation_issuance->assign_to = auth()->user()->id;
                    $get_quotation_issuance->status = "Assign";
                    $get_quotation_issuance->save();
                    if ($get_quotation_issuance) {
                        $store_rem = new remarks();
                        $store_rem->inquiry_id = $get_quotation_issuance->inquiry_id;
                        $store_rem->remarks = "Quotation Issuance(Hotel) Assign To  - " . auth()->user()->name . $get_quotation->quotation_no;
                        $store_rem->remarks_status = "Quotation Issuance Assign";
                        $store_rem->type = "quotation";
                        $store_rem->cancel_reason = $get_quotation_issuance->cancel_reason;
                        $store_rem->followup_date = "";
                        $store_rem->created_by = auth()->user()->id;
                        $store_rem->save();
                        sendNoti('Issuance(Hotel) Taken By -' . auth()->user()->name, null, 'quotation_issuance', $get_sale_person->saleperson, null);
                    }
                } else {
                }
            }
            if ($get_all_services_type == "Air Ticket" && $get_roles_permission_air_ticket) {
                if ($get_roles_permission_air_ticket) {
                    $get_quotation_issuance = quotation_issuance::where('id_quotation_issuance', $value->id_quotation_issuance)->first();
                    $get_quotation_issuance->assign_to = auth()->user()->id;
                    $get_quotation_issuance->status = "Assign";
                    $get_quotation_issuance->save();

                    if ($get_quotation_issuance) {
                        $store_rem = new remarks();
                        $store_rem->inquiry_id = $get_quotation_issuance->inquiry_id;
                        $store_rem->remarks = "Quotation Issuance(Air Ticket) Assign To  - " . auth()->user()->name . $get_quotation->quotation_no;
                        $store_rem->remarks_status = "Quotation Issuance Assign";
                        $store_rem->type = "quotation";
                        $store_rem->cancel_reason = $get_quotation_issuance->cancel_reason;
                        $store_rem->followup_date = "";
                        $store_rem->created_by = auth()->user()->id;
                        $store_rem->save();
                        sendNoti('Issuance(Air Ticket) Taken By -' . auth()->user()->name, null, 'quotation_issuance', $get_sale_person->saleperson, null);
                    }
                } else {
                }
            }
            if ($get_all_services_type == "Land Services" && $get_roles_permission_land_services) {
                if ($get_roles_permission_land_services) {
                    $get_quotation_issuance = quotation_issuance::where('id_quotation_issuance', $value->id_quotation_issuance)->first();
                    $get_quotation_issuance->assign_to = auth()->user()->id;
                    $get_quotation_issuance->status = "Assign";
                    $get_quotation_issuance->save();

                    if ($get_quotation_issuance) {
                        $store_rem = new remarks();
                        $store_rem->inquiry_id = $get_quotation_issuance->inquiry_id;
                        $store_rem->remarks = "Quotation Issuance(Land Services) Assign To  - " . auth()->user()->name . $get_quotation->quotation_no;
                        $store_rem->remarks_status = "Quotation Issuance Assign";
                        $store_rem->type = "quotation";
                        $store_rem->cancel_reason = $get_quotation_issuance->cancel_reason;
                        $store_rem->followup_date = "";
                        $store_rem->created_by = auth()->user()->id;
                        $store_rem->save();
                        sendNoti('Issuance(Land Services) Taken By -' . auth()->user()->name, null, 'quotation_issuance', $get_sale_person->saleperson, null);
                    }
                } else {
                }
            }
            // dd($value);
        }
        // $store->status = "Assign";
        // $get_approval_group_id = role_permission::where('role_id',auth()->user()->role_id)->whereIn("menu_id", [109, 110, 111, 112])->get();


        // $get_approval_ids = [];
        // foreach ($get_approval_group_id as $app_user_id) {
        // }
        // $store_quo = quotation::where('id_quotations', $store->quotation_id)->first();
        // $store_quo->status = 4;
        // $store_quo->save();
        session()->flash('success', 'Update Successfully');
        return redirect('quotation_approvals');
    }


    public function view_quotation_of_verification($id, $inq_id, $services_type)
    {
        $dec_id = Crypt::decrypt($id);
        $inq_id = Crypt::decrypt($inq_id);
        $services_type = Crypt::decrypt($services_type);
        // dd($dec_services_type);
        $get_inquiry = inquiry::where('id_inquiry', $inq_id)->first();
        $get_quotation = quotation::where('id_quotations', $dec_id)->first();
        // dd($get_quotation);
        $vendors = service_vendor::where('vendor_status', 1)->get();
        $get_rejected_issuance = issuance_rejection::where('inquiry_id', $inq_id)->where('quotation_id', $dec_id)->where('service_type', $services_type)->first();
//        dd($get_rejected_issuance);
        $get_customer = Customer::where('id_customers', $get_inquiry->customer_id)->first();
        $quotation_details = quotations_detail::where('inquiry_id', $inq_id)->where('uniq_id', $get_quotation->quotations_details_id)->get();
        $quotation_details_for_rate = quotations_detail::where('inquiry_id', $inq_id)->where('uniq_id', $get_quotation->quotations_details_id)->first();
        $get_lum_sum_price = quotations_detail::where('inquiry_id', $inq_id)->where('uniq_id', $get_quotation->quotations_details_id)->first();
        $currency_rates = currency_exchange_rate::where('currency_name', $quotation_details_for_rate->default_rate_of_exchange)->first();
//         dd($quotation_details_for_rate->default_rate_of_exchange);
        $sub_total = quotations_detail::where('inquiry_id', $inq_id)->where('uniq_id', $get_quotation->quotations_details_id)->sum('sub_total');
        // dd($sub_total);
        $total = quotations_detail::where('inquiry_id', $inq_id)->where('uniq_id', $get_quotation->quotations_details_id)->sum('total');
        $discount = $sub_total - $total;
        // dd($quotation_details);
        if ($get_quotation->quotation_type == "service_level") {
            return view('issuance_verification.view_service_level_quotation', compact('get_rejected_issuance', 'currency_rates', 'quotation_details', 'vendors', 'services_type', 'get_customer', 'get_inquiry', 'get_quotation', 'sub_total', 'total', 'discount'));
        } elseif ($get_quotation->quotation_type == "no_of_person") {
            return view('issuance_verification.view_no_of_person_quotation', compact('get_rejected_issuance', 'currency_rates', 'quotation_details', 'vendors', 'services_type', 'get_customer', 'get_inquiry', 'get_quotation', 'sub_total', 'total', 'discount'));
        } elseif ($get_quotation->quotation_type == "lum_sum") {
            return view('issuance_verification.view_lum_sum_quotation', compact('get_rejected_issuance', 'currency_rates', 'quotation_details', 'vendors', 'services_type', 'get_customer', 'get_inquiry', 'get_quotation', 'sub_total', 'total', 'discount', 'get_lum_sum_price'));
        }
    }

    public function customer_verification($q_id)
    {
        $hotel_check_in = null;
        $dec_id = Crypt::decrypt($q_id);
        $get_quotation = quotation::where('id_quotations', $dec_id)->first();
         
        $get_quotation->customer_verified=1;
        $get_quotation->save();
        
        $get_quotation_details = quotations_detail::where('quotation_id', $dec_id)->get();
        
        foreach($get_quotation_details as $quo_details){
        $all_entries = json_decode($quo_details->all_entries);
        if($quo_details->services_type == 'Hotel'){
          $hotel_check_in = $all_entries[0]->hotel_check_in;
        }
        }
//        dd($hotel_check_in);
        $store_rem = new remarks();
        $store_rem->inquiry_id = $get_quotation->inquiry_id;
        $store_rem->remarks = "Customer Verified  - " . $get_quotation->quotation_no;
        $store_rem->remarks_status = "Customer Verified" ;
        $store_rem->quotation_id = $get_quotation->id_quotations;
        $store_rem->type = "quotation";
        $store_rem->cancel_reason = "";
        $store_rem->followup_date = "";
        $store_rem->created_by = auth()->user()->id;
        $store_rem->save();
        
        $inquiry_update = inquiry::where('id_inquiry', $get_quotation->inquiry_id)->first();
        if($hotel_check_in !== null){
            $inquiry_update->travel_date = $hotel_check_in;
        }
        
        $inquiry_update->save();
//        dd(date('d-M-y', strtotime($hotel_check_in)));
        sendNoti('Customer Verified Against-' . $get_quotation->quotation_no, null, 'general', auth()->user()->id);
        session()->flash('success', 'Customer verified Successfully');
        return redirect()->back();


    }

    public function send_issuance_for_verification($vendor, $quote_id, $inq_id, $services_type, $hotel_leg_no = null)
    {
        // dd($vendor);
        $dec_quote_id = Crypt::decrypt($quote_id);
        $dec_inq_id = Crypt::decrypt($inq_id);
        $dec_services_type = Crypt::decrypt($services_type);
        if ($hotel_leg_no) {
            $dec_hotel_leg_no = Crypt::decrypt($hotel_leg_no);
        } else {
            $dec_hotel_leg_no = null;
        }
        $get_issuance = quotation_issuance::where('quotation_id', $dec_quote_id)->where('services_type', $dec_services_type)->where('assign_to', auth()->user()->id)->first();
        $get_quotation = quotation::where('id_quotations', $dec_quote_id)->first();
        $get_sale_person = inquiry::where('id_inquiry', $dec_inq_id)->select('saleperson')->first();
        if ($get_issuance) {

            $get_issuance->send_for_verification = 1;
            $get_issuance->status = "Send For Issuance Verification";
            $get_issuance->save();



            $store_isu = new issuance_verification();
            $store_isu->issuance_id = $get_issuance->id_quotation_issuance;
            $store_isu->quotation_id = $dec_quote_id;
            $store_isu->services_type = $dec_services_type;
            $store_isu->vendor_id = $vendor;
            $store_isu->status = "Send For Issuance Verification";
            $store_isu->created_by = auth()->user()->id;
            $store_isu->hotel_leg_no = $dec_hotel_leg_no;
            $store_isu->save();


            $store_rem = new remarks();
            $store_rem->inquiry_id = $dec_inq_id;
            $store_rem->remarks = "Quotation Issuance(Visa) Send For Verification  - " . $get_quotation->quotation_no;
            $store_rem->remarks_status = "Quotation Sent For Verification";
            $store_rem->type = "quotation";
            $store_rem->cancel_reason = "";
            $store_rem->followup_date = "";
            $store_rem->created_by = auth()->user()->id;
            $store_rem->save();

            sendNoti('Send Issuance For Verification Against -' . $get_quotation->quotation_no, null, 'quotation_issuance', $get_sale_person->saleperson, null);
            session()->flash('success', 'Update Successfully');
            return redirect()->back();
        }
    }

    public function submit_issuance_details(Request $request)
    {
        // dd($request);
        if ($request->services_type == "Visa") {
            $request->validate([
                'given_name' => 'required',
                'sur_name' => 'required',
                'passport_no' => 'required',
                'visa_number' => 'required',
                'vendor' => 'required',
                'validity' => 'required',
                'expiry' => 'required',
                'mofa' => 'required',
                'pnr' => 'required',
            ]);
            $entries = [];
            // dd('sds');
            $get_issuance_verification = issuance_verification::where('quotation_id', $request->quotation_id)->where('services_type', $request->services_type)->where('issuance_id', $request->issuance_id)->first();
            $get_issuance_verified_detail = issuance_verified_detail::where('quotation_id', $request->quotation_id)->where('services_type', $request->services_type)->where('issuance_verification_id', $get_issuance_verification->id_issuance_verification)->where('issuance_id', $request->issuance_id)->first();
            $get_quotation = quotation::where('id_quotations', $request->quotation_id)->first();
            $get_sale_person = inquiry::where('id_inquiry', $get_quotation->inquiry_id)->select('saleperson')->first();
            if ($get_issuance_verification) {
                $store = new issuance_verified_detail();
                $store->issuance_id = $request->issuance_id;
                $store->issuance_verification_id = $get_issuance_verification->id_issuance_verification;
                $store->quotation_id = $request->quotation_id;
                $store->inquiry_id = $get_quotation->inquiry_id;
                $store->services_type = $request->services_type;
                $store->created_by = auth()->user()->id;

                $entries[] = [
                    'person' => $request->person,
                    'given_name' => $request->given_name,
                    'sur_name' => $request->sur_name,
                    'passport_no' => $request->passport_no,
                    'visa_number' => $request->visa_number,
                    'vendor' => $request->vendor,
                    'validity' => $request->validity,
                    'expiry' => $request->expiry,
                    'mofa' => $request->mofa,
                    'pnr' => $request->pnr,
                ];
                // dd($entries);
                $store->adult_entries = json_encode($entries);
                $store->status = "Verified";
                $store->save();
                
                $get_issuance = quotation_issuance::where('quotation_id', $request->quotation_id)->where('services_type', 'Visa')->where('assign_to', auth()->user()->id)->first();
        
                if ($get_issuance) {
                $get_issuance->status = "Service Issued";
                $get_issuance->save();
                }
                $store_rem = new remarks();
                $store_rem->inquiry_id = $get_quotation->inquiry_id;
                $store_rem->remarks = "Quotation Issuance(Visa) Verified  - " . $get_quotation->quotation_no;
                $store_rem->remarks_status = "Quotation Issuance Verified";
                $store_rem->type = "quotation";
                $store_rem->cancel_reason = "";
                $store_rem->followup_date = "";
                $store_rem->created_by = auth()->user()->id;
                $store_rem->save();

                sendNoti('Issuance Verified(Visa) -' . $get_quotation->quotation_no, null, 'quotation_issuance', $get_sale_person->saleperson, null);
                session()->flash('success', "Details Added Successfully");
                return redirect()->back();
            }
        }

        if ($request->services_type == "Air Ticket") {
            $request->validate([
                'given_name' => 'required',
                'sur_name' => 'required',
                'ticket_number' => 'required',
                'airline_pnr' => 'required',
                'system_pnr' => 'required',
                'vendor' => 'required',
            ]);
            $entries = [];
            $get_issuance_verification = issuance_verification::where('quotation_id', $request->quotation_id)->where('services_type', $request->services_type)->where('issuance_id', $request->issuance_id)->first();
            $get_issuance_verified_detail = issuance_verified_detail::where('quotation_id', $request->quotation_id)->where('services_type', $request->services_type)->where('issuance_verification_id', $get_issuance_verification->id_issuance_verification)->where('issuance_id', $request->issuance_id)->first();
            $get_quotation = quotation::where('id_quotations', $request->quotation_id)->first();
            $get_sale_person = inquiry::where('id_inquiry', $get_quotation->inquiry_id)->select('saleperson')->first();
            // dd($request);
            if ($get_issuance_verification) {

                $store = new issuance_verified_detail();
                $store->issuance_id = $request->issuance_id;
                $store->issuance_verification_id = $get_issuance_verification->id_issuance_verification;
                $store->quotation_id = $request->quotation_id;
                $store->inquiry_id = $get_quotation->inquiry_id;
                $store->services_type = $request->services_type;
                $store->created_by = auth()->user()->id;

                $entries[] = [
                    'person' => $request->person,
                    'given_name' => $request->given_name,
                    'sur_name' => $request->sur_name,
                    'ticket_number' => $request->ticket_number,
                    'airline_pnr' => $request->airline_pnr,
                    'system_pnr' => $request->system_pnr,
                    'vendor' => $request->vendor,

                ];
                $get_issuance = quotation_issuance::where('quotation_id', $request->quotation_id)->where('services_type', 'Air Ticket')->where('assign_to', auth()->user()->id)->first();
        
                if ($get_issuance) {
                $get_issuance->status = "Service Issued";
                $get_issuance->save();
                }
                $store->adult_entries = json_encode($entries);

                $store->status = "Verified";
                $store->save();
                $store_rem = new remarks();
                $store_rem->inquiry_id = $get_quotation->inquiry_id;
                $store_rem->remarks = "Quotation Issuance(Visa) Verified  - " . $get_quotation->quotation_no;
                $store_rem->remarks_status = "Quotation Issuance Verified";
                $store_rem->type = "quotation";
                $store_rem->cancel_reason = "";
                $store_rem->followup_date = "";
                $store_rem->created_by = auth()->user()->id;
                $store_rem->save();

                sendNoti('Issuance Verified(Air Ticket) -' . $get_quotation->quotation_no, null, 'quotation_issuance', $get_sale_person->saleperson, null);
                session()->flash('success', "Details Added Successfully");
                return redirect()->back();
            }
        }

        if ($request->services_type == "Land Services") {
            $request->validate([
                'land_services' => 'required',
                'vendor' => 'required',
            ]);
            $entries = [];
            $get_issuance_verification = issuance_verification::where('quotation_id', $request->quotation_id)->where('services_type', $request->services_type)->where('issuance_id', $request->issuance_id)->first();
            // dd($get_issuance_verification);
            $get_issuance_verified_detail = issuance_verified_detail::where('quotation_id', $request->quotation_id)->where('services_type', $request->services_type)->where('issuance_verification_id', $get_issuance_verification?->id_issuance_verification)->where('issuance_id', $request->issuance_id)->first();
            $get_quotation = quotation::where('id_quotations', $request->quotation_id)->first();
            $get_sale_person = inquiry::where('id_inquiry', $get_quotation->inquiry_id)->select('saleperson')->first();
            // dd($request);
            if ($get_issuance_verification) {

                $get_issuance_verified_detail = new issuance_verified_detail();
                $get_issuance_verified_detail->issuance_id = $request->issuance_id;
                $get_issuance_verified_detail->issuance_verification_id = $get_issuance_verification->id_issuance_verification;
                $get_issuance_verified_detail->quotation_id = $request->quotation_id;
                $get_issuance_verified_detail->inquiry_id = $get_quotation->inquiry_id;
                $get_issuance_verified_detail->services_type = $request->services_type;
                $get_issuance_verified_detail->created_by = auth()->user()->id;

                $entries[] = [
                    'land_services' => $request->land_services,
                    'vendor' => $request->vendor,
                ];
                $get_issuance = quotation_issuance::where('quotation_id', $request->quotation_id)->where('services_type', 'Land Services')->where('assign_to', auth()->user()->id)->first();
        
                if ($get_issuance) {
                $get_issuance->status = "Service Issued";
                $get_issuance->save();
                }
                $get_issuance_verified_detail->adult_entries = json_encode($entries);

                $get_issuance_verified_detail->status = "Verified";
                $get_issuance_verified_detail->save();

                $store_rem = new remarks();
                $store_rem->inquiry_id = $get_quotation->inquiry_id;
                $store_rem->remarks = "Quotation Issuance(Visa) Verified  - " . $get_quotation->quotation_no;
                $store_rem->remarks_status = "Quotation Issuance Verified";
                $store_rem->type = "quotation";
                $store_rem->cancel_reason = "";
                $store_rem->followup_date = "";
                $store_rem->created_by = auth()->user()->id;
                $store_rem->save();

                sendNoti('Issuance Verified(Land Services) -' . $get_quotation->quotation_no, null, 'quotation_issuance', $get_sale_person->saleperson, null);

                session()->flash('success', "Details Added Successfully");
                return redirect()->back();
            }
        }
        if ($request->services_type == "Hotel") {
            $request->validate([
                'vendor_reference' => 'required',
                'hotel_confirmation' => 'required',
                'vendor' => 'required',
            ]);
            $entries = [];
            $get_issuance_verification = issuance_verification::where('quotation_id', $request->quotation_id)->where('services_type', $request->services_type)->where('issuance_id', $request->issuance_id)->first();
            // dd($get_issuance_verification);
            $get_issuance_verified_detail = issuance_verified_detail::where('quotation_id', $request->quotation_id)->where('services_type', $request->services_type)->where('issuance_verification_id', $get_issuance_verification->id_issuance_verification)->where('issuance_id', $request->issuance_id)->first();
            $get_quotation = quotation::where('id_quotations', $request->quotation_id)->first();
            $get_sale_person = inquiry::where('id_inquiry', $get_quotation->inquiry_id)->select('saleperson')->first();
            // dd($request);
            if ($get_issuance_verification) {

                for ($i = 0; $i < count($request->legs); $i++) {
                    $get_issuance_verified_detail = new issuance_verified_detail();
                    $get_issuance_verified_detail->issuance_id = $request->issuance_id;
                    $get_issuance_verified_detail->issuance_verification_id = $get_issuance_verification->id_issuance_verification;
                    $get_issuance_verified_detail->quotation_id = $request->quotation_id;
                    $get_issuance_verified_detail->inquiry_id = $get_quotation->inquiry_id;
                    $get_issuance_verified_detail->services_type = $request->services_type;
                    $get_issuance_verified_detail->created_by = auth()->user()->id;

                    $entries[] = [
                        'vendor_reference' => $request->vendor_reference[$i],
                        'hotel_confirmation' => $request->hotel_confirmation[$i],
                        'vendor' => $request->vendor[$i],
                    ];

                    $get_issuance_verified_detail->adult_entries = json_encode($entries);

                    $get_issuance_verified_detail->status = "Verified";
                    $get_issuance_verified_detail->legs = $request->legs[$i];
                    $get_issuance_verified_detail->save();
                    
                    $get_issuance = quotation_issuance::where('quotation_id', $request->quotation_id)->where('services_type', 'Hotel')->where('assign_to', auth()->user()->id)->first();
        
                    if ($get_issuance) {
                    $get_issuance->status = "Service Issued";
                    $get_issuance->save();
                    }
                    
                    $store_rem = new remarks();
                    $store_rem->inquiry_id = $get_quotation->inquiry_id;
                    $store_rem->remarks = "Quotation Issuance(Hotel#" . $i + 1 . ") Verified  - " . $get_quotation->quotation_no;
                    $store_rem->remarks_status = "Quotation Issuance Verified";
                    $store_rem->type = "quotation";
                    $store_rem->cancel_reason = "";
                    $store_rem->followup_date = "";
                    $store_rem->created_by = auth()->user()->id;
                    $store_rem->save();
                }

                sendNoti('Issuance Verified(Hotel) -' . $get_quotation->quotation_no, null, 'quotation_issuance', $get_sale_person->saleperson, null);


                session()->flash('success', "Details Added Successfully");
                return redirect()->back();
            }
        }

        session()->flash('error', "Please Send  " . $request->services_type . " On Issuance First");
        return redirect()->back();
    }

    public function update_cost_price_sale_person(Request $request)
    {
        //  dd($request);
        $request->validate([
            'edit_issuance_cost_price' => "required",
            'edit_issuance_new_cost_price' => "required",
        ]);

        $store = new cost_price_of_sales_person();
        $store->inquiry_id = $request->edit_issuance_inquiry_id;
        $store->quotation_id = $request->edit_issuance_quotation_id;
        $store->quotation_detail_id = $request->edit_issuance_quotation_detail_id;
        $store->cost_price = $request->edit_issuance_new_cost_price;
        $store->old_cost_price = $request->edit_issuance_cost_price;
        $store->old_selling_price = $request->edit_issuance_selling_price;
        $store->selling_price = $request->edit_issuance_new_selling_price;
        $store->services_type = $request->edit_issuance_services_type;
        if (isset($request->edit_issuance_person) && $request->edit_issuance_person != null) {
            $store->person = $request->edit_issuance_person;
            // if Null means for all
        }
        $store->legs = $request->edit_issuance_legs;
        $store->created_by = auth()->user()->id;
        $store->save();

        session()->flash('success', "Cost Price Updated Successfully");
        return redirect()->back();
    }
}
