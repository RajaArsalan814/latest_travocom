<?php

namespace App\Http\Controllers;

use App\addon;
use App\airlines;
use App\campaign;
use App\currency_exchange_rate;
use App\Customer;
use App\hotels;
use App\Http\Controllers\Controller;
use App\inquiry;
use App\land_services_type;
use App\Landservicestypes;
use App\other_service;
use App\quotation;
use App\quotations_detail;
use App\remarks;
use App\role_permission;
use App\room_type;
use App\Route;
use App\User;
use App\Visa_rates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class QuotationConversionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
               
    }
    function edit_quotation($inq_id, $q_id)
    {
        // dd($inq_id);

        $dec_inq_id = Crypt::decrypt($inq_id);
        $dec_quo_id = Crypt::decrypt($q_id);
        $get_quotation = quotation::where('id_quotations', $dec_quo_id)->first();
//         dd($dec_quo_id);
        $get_quotation_details = quotations_detail::where('uniq_id', $get_quotation->id_quotations)->first();
        $sales_person = User::get();
        $campaigns = \App\campaign::all();
        $services = other_service::where('parent_id', null)->get();
        $quotations = quotation::where('inquiry_id', $dec_inq_id)->get();
        $quotations_not_approved = quotation::where('inquiry_id', $dec_inq_id)->get();
        $visa_adult_cost_price = 0;


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
        $all_remarks = remarks::where('inquiry_id', $dec_inq_id)->orderBy('id_remarks', 'desc')->get();
        $get_latest_remarks_count = remarks::where('inquiry_id', $dec_inq_id)->max('id_remarks');
        $get_latest_remarks = remarks::where('id_remarks', $get_latest_remarks_count)->first();
        return view('quotations.edit_quotation', compact('dec_inq_id', 'get_quotation', 'get_quotation_details', 'currency_rates', 'quotations_not_approved', 'quotations', 'all_remarks', 'get_latest_remarks', 'get_inquiry', 'get_customer', 'get_campaign', 'campaigns', 'services_inq', 'sale_persons', 'echo_services_data'));
    }
    function edit_quotation_original($inq_id, $q_id)
    {
        // dd($inq_id);

        $dec_inq_id = Crypt::decrypt($inq_id);
        $dec_quo_id = Crypt::decrypt($q_id);
        $get_quotation = quotation::where('id_quotations', $dec_quo_id)->first();
//         dd($dec_quo_id);
        $get_quotation_details = quotations_detail::where('uniq_id', $get_quotation->id_quotations)->first();
        $sales_person = User::get();
        $campaigns = \App\campaign::all();
        $services = other_service::where('parent_id', null)->get();
        $quotations = quotation::where('inquiry_id', $dec_inq_id)->get();
        $quotations_not_approved = quotation::where('inquiry_id', $dec_inq_id)->get();
        $visa_adult_cost_price = 0;


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
        $all_remarks = remarks::where('inquiry_id', $dec_inq_id)->orderBy('id_remarks', 'desc')->get();
        $get_latest_remarks_count = remarks::where('inquiry_id', $dec_inq_id)->max('id_remarks');
        $get_latest_remarks = remarks::where('id_remarks', $get_latest_remarks_count)->first();
        return view('quotations.edit_quotation', compact('dec_inq_id', 'get_quotation', 'get_quotation_details', 'currency_rates', 'quotations_not_approved', 'quotations', 'all_remarks', 'get_latest_remarks', 'get_inquiry', 'get_customer', 'get_campaign', 'campaigns', 'services_inq', 'sale_persons', 'echo_services_data'));
    }

    public function append_quotation_details($sub_services, $append_count, $service_type, $legs_count = null, $inq_id = null, $q_id = null)
    {
        // dd($service_type);
        $data = "";

        // $sub_service_name = other_service::where('id_other_services', $sub_services)->first();
        // $get_parent_name = other_service::where('id_other_services', $sub_service_name->parent_id)->select('service_name')->first();
        $get_inq = inquiry::where('id_inquiry', $inq_id)->first();
        $no_of_adult = $get_inq->no_of_adults;
        $no_of_children = $get_inq->no_of_children;
        $no_of_infant = $get_inq->no_of_infants;
        // dd($get_inq);
        $dec_q_id = Crypt::decrypt($q_id);
        // dd($dec_q_id);
        $get_quotation = quotation::where('id_quotations', $dec_q_id)->select('quotations_details_id')->first();
        $get_quotation_details = quotations_detail::where('uniq_id', $get_quotation->quotations_details_id)->get();
        // dd($get_quotation_details);

        $get_user_role_id = auth()->user()->role_id;
        $get_roles_permission = role_permission::where('role_id', $get_user_role_id)->get();
        // foreach ($get_roles_permission as $key => $value) {
        // dd($value);
        $get_match_dtour = role_permission::where('role_id', $get_user_role_id)->where("menu_id", 97)->first();
        $get_match_inter = role_permission::where('role_id', $get_user_role_id)->where("menu_id", 98)->first();
        $get_match_umrah = role_permission::where('role_id', $get_user_role_id)->where("menu_id", 99)->first();
        $sub_service_name = "Hotel";

        // dd($get_match);
        if ($get_match_dtour) {
            $final_permission[] = $get_match_dtour;
            $permission[] = "D-Tour";
        }
        if ($get_match_inter) {
            $final_permission[] = $get_match_inter;
            $permission[] = "I-Tour";
        }
        if ($get_match_umrah) {
            $final_permission[] = $get_match_umrah;
            $permission[] = "Umrah";
        } else {
            $permission = [];
        }

        //dd($get_parent_name->service_name);
        $data = "";
        // $uniq_user_id = array_unique($final_user_ids);
        // $sale_persons = User::whereIn('id', $uniq_user_id)->get();
        $last_key = count($get_quotation_details);
        // dd($last_key);
        $total_cost_price = 0;
        $total_selling_price = 0;
        $adult_cost_price = 0;
        $children_cost_price = 0;
        $infant_cost_price = 0;
        $adult_selling_price = 0;
        $children_selling_price = 0;
        $infant_selling_price = 0;
        $discount = 0;
        // dd($get_quotation_details);
        $count_of_get_quotation_details = count($get_quotation_details);
        $total_cost_price_sl = 0;
        $total_selling_price_sl = 0;

        foreach ($get_quotation_details as $key => $get_q_d) {

            // ---------------------------Start----------------------------------------
            // dd($get_quotation_details);
            // Service Level To No Of Person----------------------
            if ($get_q_d->services_type == "Visa" && $get_q_d->type == "service_level" && $service_type == "no_of_person") {
                $visa_all_entries_decode = json_decode($get_q_d->all_entries);
                $visa_person_decode = json_decode($get_q_d->person_pricing_details);
                $visa_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                // dd($visa_person_decode);

                $visa_adult_cost_price = $visa_person_decode[0]->visa_adult_cost_price;
                $visa_children_cost_price = $visa_person_decode[0]->visa_children_cost_price;
                $visa_infant_cost_price = $visa_person_decode[0]->visa_infant_cost_price;

                $visa_adult_selling_price = $visa_person_decode[0]->visa_adult_selling_price;
                $visa_children_selling_price = $visa_person_decode[0]->visa_children_selling_price;
                $visa_infant_selling_price = $visa_person_decode[0]->visa_infant_selling_price;
            }
            if ($get_q_d->services_type == "Air Ticket" && $get_q_d->type == "service_level" && $service_type == "no_of_person") {
                $air_ticket_all_entries_decode = json_decode($get_q_d->all_entries);
                $air_ticket_person_decode = json_decode($get_q_d->person_pricing_details);
                $air_ticket_sub_total_details_decode = json_decode($get_q_d->sub_total_details);

                $airline_adult_cost_price = $air_ticket_sub_total_details_decode[0]->airline_adult_cost_price;
                $airline_children_cost_price = $air_ticket_sub_total_details_decode[0]->airline_children_cost_price;
                $airline_infant_cost_price = $air_ticket_sub_total_details_decode[0]->airline_infant_cost_price;

                $airline_adult_selling_price = $air_ticket_sub_total_details_decode[0]->airline_adult_selling_price;
                $airline_children_selling_price = $air_ticket_sub_total_details_decode[0]->airline_children_selling_price;
                $airline_infant_selling_price = $air_ticket_sub_total_details_decode[0]->airline_infant_selling_price;

                // dd($air_ticket_sub_total_details_decode);
                // $total_cost_price = round($total_cost_price + $air_ticket_sub_total_details_decode[0]->airline_total_cost_price);
                // $total_selling_price = round($total_cost_price + $air_ticket_sub_total_details_decode[0]->airline_total_selling_price);

                // // dd($air_ticket_sub_total_details_decode);
                // $discount = round($discount + $air_ticket_sub_total_details_decode[0]->airline_discount);

                // $adult_cost_price = round($adult_cost_price + ($air_ticket_sub_total_details_decode[0]->airline_adult_cost_price * $no_of_adult));
                // $children_cost_price = round($children_cost_price + $air_ticket_sub_total_details_decode[0]->airline_children_cost_price * $no_of_children);
                // $infant_cost_price = round($infant_cost_price + $air_ticket_sub_total_details_decode[0]->airline_infant_cost_price * $no_of_infant);
                // $adult_selling_price = round($adult_selling_price + ($air_ticket_sub_total_details_decode[0]->airline_adult_selling_price * $no_of_adult));

                // $children_selling_price = $children_selling_price + $air_ticket_sub_total_details_decode[0]->airline_children_selling_price * $no_of_children;
                // $infant_selling_price = $infant_selling_price + $air_ticket_sub_total_details_decode[0]->airline_infant_selling_price * $no_of_infant;

                // dd($total_cost_price);
            }
            if ($get_q_d->services_type == "Hotel" && $get_q_d->type == "service_level" && $service_type == "no_of_person") {
                $hotel_all_entries_decode = json_decode($get_q_d->all_entries);
                $hotel_person_decode = json_decode($get_q_d->person_pricing_details);
                $hotel_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                $hotel_total_cost_price = $hotel_sub_total_details_decode[0]->hotel_total_cost_price;
                $hotel_total_selling_price = $hotel_sub_total_details_decode[0]->hotel_total_selling_price;

                $count_of_legs_hotel = count($hotel_all_entries_decode);
                $step_1_divide_by_legs = $hotel_total_cost_price / $count_of_legs_hotel;
                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                // if ($no_of_children > 0) {
                //     $no_of_person = $no_of_person + 1;
                // }
                // if ($no_of_infant > 0) {
                //     $no_of_person = $no_of_person + 1;
                // }
                $step_2_divide_no_of_person_if_available = $step_1_divide_by_legs / $no_of_person;
                $get_hotel_adult_cost_price = $step_2_divide_no_of_person_if_available / $no_of_adult;
                $get_hotel_children_cost_price = $step_2_divide_no_of_person_if_available / $no_of_children;
                $get_hotel_infant_cost_price = $step_2_divide_no_of_person_if_available / $no_of_infant;



                $step_1_divide_by_legs_of_selling = $hotel_total_selling_price / $count_of_legs_hotel;
                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_children > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_infant > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                $step_2_divide_no_of_person_if_available_selling_price = $step_1_divide_by_legs_of_selling / $no_of_person;
                $get_hotel_adult_selling_price = $step_2_divide_no_of_person_if_available_selling_price / $no_of_adult;
                $get_hotel_children_selling_price = $step_2_divide_no_of_person_if_available_selling_price / $no_of_children;
                $get_hotel_infant_selling_price = $step_2_divide_no_of_person_if_available_selling_price / $no_of_infant;



                // dd($get_children_cost_price);
            }
            if ($get_q_d->services_type == "Land Services" && $get_q_d->type == "service_level" && $service_type == "no_of_person") {
                $land_services_all_entries_decode = json_decode($get_q_d->all_entries);
                $land_services_person_decode = json_decode($get_q_d->person_pricing_details);
                $land_services_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                // dd($land_services_sub_total_details_decode[0]->land_services_total_cost_price);
                $land_services_total_cost_price = $land_services_sub_total_details_decode[0]->land_services_total_cost_price;
                $land_services_total_selling_price = $land_services_sub_total_details_decode[0]->land_services_selling_total;

                $count_of_legs_land_services = count($land_services_all_entries_decode);
                $step_1_divide_by_legs = $land_services_total_cost_price / $count_of_legs_land_services;
                // dd($land_services_sub_total_details_decode);
                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                // if ($no_of_children > 0) {
                //     $no_of_person = $no_of_person + 1;
                // }
                // if ($no_of_infant > 0) {
                //     $no_of_person = $no_of_person + 1;
                // }
                $step_2_divide_no_of_person_if_available = ($step_1_divide_by_legs / $no_of_person);
                $get_land_services_adult_cost_price = ($step_2_divide_no_of_person_if_available / $no_of_adult);
                $get_land_services_children_cost_price = ($step_2_divide_no_of_person_if_available / $no_of_children);
                $get_land_services_infant_cost_price = ($step_2_divide_no_of_person_if_available / $no_of_infant);


                $step_1_divide_by_legs_selling_price = $land_services_total_selling_price / $count_of_legs_land_services;
                // dd($land_services_sub_total_details_decode);
                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_children > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_infant > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                $step_2_divide_no_of_person_if_available_selling_price = ($step_1_divide_by_legs_selling_price / $no_of_person);
                $get_land_services_adult_selling_price = ($step_2_divide_no_of_person_if_available_selling_price / $no_of_adult);
                $get_land_services_children_selling_price = ($step_2_divide_no_of_person_if_available_selling_price / $no_of_children);
                $get_land_services_infant_selling_price = ($step_2_divide_no_of_person_if_available_selling_price / $no_of_infant);
            }
            // Service Level To Lum Sum------------------------------
            if ($get_q_d->services_type == "Visa" && $get_q_d->type == "service_level" && $service_type == "lum_sum") {
                $visa_all_entries_decode = json_decode($get_q_d->all_entries);
                $visa_person_decode = json_decode($get_q_d->person_pricing_details);
                $visa_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                // dd($visa_person_decode);

                $visa_adult_cost_price = $visa_person_decode[0]->visa_adult_cost_price;
                $visa_children_cost_price = $visa_person_decode[0]->visa_children_cost_price;
                $visa_infant_cost_price = $visa_person_decode[0]->visa_infant_cost_price;

                $visa_adult_selling_price = $visa_person_decode[0]->visa_adult_selling_price;
                $visa_children_selling_price = $visa_person_decode[0]->visa_children_selling_price;
                $visa_infant_selling_price = $visa_person_decode[0]->visa_infant_selling_price;
            }
            if ($get_q_d->services_type == "Air Ticket" && $get_q_d->type == "service_level" && $service_type == "lum_sum") {
                $air_ticket_all_entries_decode = json_decode($get_q_d->all_entries);
                $air_ticket_person_decode = json_decode($get_q_d->person_pricing_details);
                $air_ticket_sub_total_details_decode = json_decode($get_q_d->sub_total_details);

                $airline_adult_cost_price = $air_ticket_sub_total_details_decode[0]->airline_adult_cost_price;
                $airline_children_cost_price = $air_ticket_sub_total_details_decode[0]->airline_children_cost_price;
                $airline_infant_cost_price = $air_ticket_sub_total_details_decode[0]->airline_infant_cost_price;

                $airline_adult_selling_price = $air_ticket_sub_total_details_decode[0]->airline_adult_selling_price;
                $airline_children_selling_price = $air_ticket_sub_total_details_decode[0]->airline_children_selling_price;
                $airline_infant_selling_price = $air_ticket_sub_total_details_decode[0]->airline_infant_selling_price;

                // dd($air_ticket_sub_total_details_decode);
                // $total_cost_price = round($total_cost_price + $air_ticket_sub_total_details_decode[0]->airline_total_cost_price);
                // $total_selling_price = round($total_cost_price + $air_ticket_sub_total_details_decode[0]->airline_total_selling_price);

                // // dd($air_ticket_sub_total_details_decode);
                // $discount = round($discount + $air_ticket_sub_total_details_decode[0]->airline_discount);

                // $adult_cost_price = round($adult_cost_price + ($air_ticket_sub_total_details_decode[0]->airline_adult_cost_price * $no_of_adult));
                // $children_cost_price = round($children_cost_price + $air_ticket_sub_total_details_decode[0]->airline_children_cost_price * $no_of_children);
                // $infant_cost_price = round($infant_cost_price + $air_ticket_sub_total_details_decode[0]->airline_infant_cost_price * $no_of_infant);
                // $adult_selling_price = round($adult_selling_price + ($air_ticket_sub_total_details_decode[0]->airline_adult_selling_price * $no_of_adult));

                // $children_selling_price = $children_selling_price + $air_ticket_sub_total_details_decode[0]->airline_children_selling_price * $no_of_children;
                // $infant_selling_price = $infant_selling_price + $air_ticket_sub_total_details_decode[0]->airline_infant_selling_price * $no_of_infant;

                // dd($total_cost_price);
            }
            if ($get_q_d->services_type == "Hotel" && $get_q_d->type == "service_level" && $service_type == "lum_sum") {
                $hotel_all_entries_decode = json_decode($get_q_d->all_entries);
                $hotel_person_decode = json_decode($get_q_d->person_pricing_details);
                $hotel_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                $hotel_total_cost_price = $hotel_sub_total_details_decode[0]->hotel_total_cost_price;
                $hotel_total_selling_price = $hotel_sub_total_details_decode[0]->hotel_total_selling_price;

                $count_of_legs_hotel = count($hotel_all_entries_decode);
                $step_1_divide_by_legs = $hotel_total_cost_price / $count_of_legs_hotel;
                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                // if ($no_of_children > 0) {
                //     $no_of_person = $no_of_person + 1;
                // }
                // if ($no_of_infant > 0) {
                //     $no_of_person = $no_of_person + 1;
                // }
                $step_2_divide_no_of_person_if_available = $step_1_divide_by_legs / $no_of_person;
                $get_hotel_adult_cost_price = $step_2_divide_no_of_person_if_available / $no_of_adult;
                $get_hotel_children_cost_price = $step_2_divide_no_of_person_if_available / $no_of_children;
                $get_hotel_infant_cost_price = $step_2_divide_no_of_person_if_available / $no_of_infant;



                $step_1_divide_by_legs_of_selling = $hotel_total_selling_price / $count_of_legs_hotel;
                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_children > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_infant > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                $step_2_divide_no_of_person_if_available_selling_price = $step_1_divide_by_legs_of_selling / $no_of_person;
                $get_hotel_adult_selling_price = $step_2_divide_no_of_person_if_available_selling_price / $no_of_adult;
                $get_hotel_children_selling_price = $step_2_divide_no_of_person_if_available_selling_price / $no_of_children;
                $get_hotel_infant_selling_price = $step_2_divide_no_of_person_if_available_selling_price / $no_of_infant;



                // dd($get_children_cost_price);
            }
            if ($get_q_d->services_type == "Land Services" && $get_q_d->type == "service_level" && $service_type == "lum_sum") {
                $land_services_all_entries_decode = json_decode($get_q_d->all_entries);
                $land_services_person_decode = json_decode($get_q_d->person_pricing_details);
                $land_services_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                // dd($land_services_sub_total_details_decode[0]->land_services_total_cost_price);
                $land_services_total_cost_price = $land_services_sub_total_details_decode[0]->land_services_total_cost_price;
                $land_services_total_selling_price = $land_services_sub_total_details_decode[0]->land_services_selling_total;

                $count_of_legs_land_services = count($land_services_all_entries_decode);
                $step_1_divide_by_legs = $land_services_total_cost_price / $count_of_legs_land_services;
                // dd($land_services_sub_total_details_decode);
                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                // if ($no_of_children > 0) {
                //     $no_of_person = $no_of_person + 1;
                // }
                // if ($no_of_infant > 0) {
                //     $no_of_person = $no_of_person + 1;
                // }
                $step_2_divide_no_of_person_if_available = ($step_1_divide_by_legs / $no_of_person);
                $get_land_services_adult_cost_price = ($step_2_divide_no_of_person_if_available / $no_of_adult);
                $get_land_services_children_cost_price = ($step_2_divide_no_of_person_if_available / $no_of_children);
                $get_land_services_infant_cost_price = ($step_2_divide_no_of_person_if_available / $no_of_infant);


                $step_1_divide_by_legs_selling_price = $land_services_total_selling_price / $count_of_legs_land_services;
                // dd($land_services_sub_total_details_decode);
                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_children > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_infant > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                $step_2_divide_no_of_person_if_available_selling_price = ($step_1_divide_by_legs_selling_price / $no_of_person);
                $get_land_services_adult_selling_price = ($step_2_divide_no_of_person_if_available_selling_price / $no_of_adult);
                $get_land_services_children_selling_price = ($step_2_divide_no_of_person_if_available_selling_price / $no_of_children);
                $get_land_services_infant_selling_price = ($step_2_divide_no_of_person_if_available_selling_price / $no_of_infant);
            }


            // No OF Person To Service Level--------------------------
            if ($get_q_d->services_type == "Visa" && $get_q_d->type == "no_of_person" && $service_type == "service_level") {
                $visa_all_entries_decode = json_decode($get_q_d->all_entries);
                $visa_person_decode = json_decode($get_q_d->person_pricing_details);
                $visa_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_children > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_infant > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                $get_profit_by_services = count($get_quotation_details);
                $adult_profit = ($visa_sub_total_details_decode[0]->no_of_person_adult_profit / $get_profit_by_services) / $no_of_adult;
                $infant_profit = ($visa_sub_total_details_decode[0]->no_of_person_children_profit / $get_profit_by_services) / $no_of_children;
                $children_profit = ($visa_sub_total_details_decode[0]->no_of_person_infant_profit / $get_profit_by_services) / $no_of_infant;


                $visa_adult_cost_price = $visa_person_decode[0]->visa_adult_cost_price;
                $visa_children_cost_price = $visa_person_decode[0]->visa_children_cost_price;
                $visa_infant_cost_price = $visa_person_decode[0]->visa_infant_cost_price;



                $visa_adult_selling_price = ($visa_adult_cost_price + $adult_profit);
                $visa_children_selling_price = ($visa_children_cost_price + $children_profit);
                $visa_infant_selling_price = ($visa_children_cost_price + $infant_profit);
                $visa_total_selling_price = $visa_adult_selling_price * $no_of_adult + $visa_children_selling_price * $no_of_children + $visa_infant_selling_price * $no_of_infant;
                $total_cost_price_sl = $total_cost_price_sl + $visa_sub_total_details_decode[0]->visa_total_cost_price;
                $total_selling_price_sl = $total_selling_price_sl + $visa_total_selling_price;
            }
            if ($get_q_d->services_type == "Air Ticket" && $get_q_d->type == "no_of_person" && $service_type == "service_level") {
                $air_ticket_all_entries_decode = json_decode($get_q_d->all_entries);
                $air_ticket_person_decode = json_decode($get_q_d->person_pricing_details);
                $air_ticket_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                // dd($air_ticket_person_decode);

                $airline_adult_cost_price = $air_ticket_person_decode[0]->airline_adult_cost_price;
                $airline_children_cost_price = $air_ticket_person_decode[0]->airline_children_cost_price;
                $airline_infant_cost_price = $air_ticket_person_decode[0]->airline_infant_cost_price;
                // dd($air_ticket_sub_total_details_decode);
                $total_cost_price_sl = $total_cost_price_sl + $air_ticket_sub_total_details_decode[0]->airline_sub_total;

                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_children > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_infant > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                $get_profit_by_services = count($get_quotation_details);
                $adult_profit = ($air_ticket_sub_total_details_decode[0]->no_of_person_adult_profit / $get_profit_by_services) / $no_of_adult;
                $infant_profit = ($air_ticket_sub_total_details_decode[0]->no_of_person_children_profit / $get_profit_by_services) / $no_of_children;
                $children_profit = ($air_ticket_sub_total_details_decode[0]->no_of_person_infant_profit / $get_profit_by_services) / $no_of_infant;


                $airline_adult_selling_price = $airline_adult_cost_price + $adult_profit;
                $airline_children_selling_price = $airline_children_cost_price + $children_profit;
                $airline_infant_selling_price = $airline_children_cost_price + $infant_profit;
                $airline_total_selling_price = $airline_adult_selling_price * $no_of_adult + $airline_children_selling_price * $no_of_children + $airline_infant_selling_price * $no_of_infant;
                $total_selling_price_sl = $total_selling_price_sl + $airline_total_selling_price;
                // dd($airline_total_selling_price);


            }
            if ($get_q_d->services_type == "Hotel" && $get_q_d->type == "no_of_person" && $service_type == "service_level") {
                $hotel_all_entries_decode = json_decode($get_q_d->all_entries);
                $hotel_person_decode = json_decode($get_q_d->person_pricing_details);
                $hotel_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                $hotel_total_cost_price = $hotel_sub_total_details_decode[0]->hotel_total_cost_price;
                // dd($hotel_sub_total_details_decode);
                $total_cost_price_sl = $total_cost_price_sl + $hotel_sub_total_details_decode[0]->hotel_total_cost_price;
                // $hotel_total_selling_price = $hotel_sub_total_details_decode[0]->hotel_total_selling_price;
                $count_of_legs_hotel = count($hotel_all_entries_decode);
                $step_1_divide_by_legs = $hotel_total_cost_price / $count_of_legs_hotel;
                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                // if ($no_of_children > 0) {
                //     $no_of_person = $no_of_person + 1;
                // }
                // if ($no_of_infant > 0) {
                //     $no_of_person = $no_of_person + 1;
                // }
                $step_2_divide_no_of_person_if_available = $step_1_divide_by_legs / $no_of_person;
                $get_hotel_adult_cost_price = $step_2_divide_no_of_person_if_available / $no_of_adult;
                $get_hotel_children_cost_price = $step_2_divide_no_of_person_if_available / $no_of_children;
                $get_hotel_infant_cost_price = $step_2_divide_no_of_person_if_available / $no_of_infant;


                $get_profit_by_services = count($get_quotation_details);
                $adult_profit = ($hotel_sub_total_details_decode[0]->no_of_person_adult_profit / $get_profit_by_services) / $no_of_adult;
                $infant_profit = ($hotel_sub_total_details_decode[0]->no_of_person_children_profit / $get_profit_by_services) / $no_of_children;
                $children_profit = ($hotel_sub_total_details_decode[0]->no_of_person_infant_profit / $get_profit_by_services) / $no_of_infant;









                // dd($get_children_cost_price);
            }
            if ($get_q_d->services_type == "Land Services" && $get_q_d->type == "no_of_person" && $service_type == "service_level") {
                $land_services_all_entries_decode = json_decode($get_q_d->all_entries);
                $land_services_person_decode = json_decode($get_q_d->person_pricing_details);
                $land_services_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                // dd($land_services_sub_total_details_decode);
                $total_cost_price_sl = $total_cost_price_sl + $land_services_sub_total_details_decode[0]->land_services_sub_total;
                $get_profit_by_services = count($get_quotation_details);
                $adult_profit = ($land_services_sub_total_details_decode[0]->no_of_person_adult_profit / $get_profit_by_services) / $no_of_adult;
                $infant_profit = ($land_services_sub_total_details_decode[0]->no_of_person_children_profit / $get_profit_by_services) / $no_of_children;
                $children_profit = ($land_services_sub_total_details_decode[0]->no_of_person_infant_profit / $get_profit_by_services) / $no_of_infant;
                // dd($children_profit);

            }

            // No OF Person To Lum Sum----------------------------------
            if ($get_q_d->services_type == "Visa" && $get_q_d->type == "no_of_person" && $service_type == "lum_sum") {
                $visa_all_entries_decode = json_decode($get_q_d->all_entries);
                $visa_person_decode = json_decode($get_q_d->person_pricing_details);
                $visa_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_children > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_infant > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                $get_profit_by_services = count($get_quotation_details);
                $adult_profit = ($visa_sub_total_details_decode[0]->no_of_person_adult_profit / $get_profit_by_services) / $no_of_adult;
                $infant_profit = ($visa_sub_total_details_decode[0]->no_of_person_children_profit / $get_profit_by_services) / $no_of_children;
                $children_profit = ($visa_sub_total_details_decode[0]->no_of_person_infant_profit / $get_profit_by_services) / $no_of_infant;


                $visa_adult_cost_price = $visa_person_decode[0]->visa_adult_cost_price;
                $visa_children_cost_price = $visa_person_decode[0]->visa_children_cost_price;
                $visa_infant_cost_price = $visa_person_decode[0]->visa_infant_cost_price;



                $visa_adult_selling_price = ($visa_adult_cost_price + $adult_profit);
                $visa_children_selling_price = ($visa_children_cost_price + $children_profit);
                $visa_infant_selling_price = ($visa_children_cost_price + $infant_profit);
                $visa_total_selling_price = $visa_adult_selling_price * $no_of_adult + $visa_children_selling_price * $no_of_children + $visa_infant_selling_price * $no_of_infant;
                $total_cost_price_sl = $total_cost_price_sl + $visa_sub_total_details_decode[0]->visa_total_cost_price;
                $total_selling_price_sl = $total_selling_price_sl + $visa_total_selling_price;
            }
            if ($get_q_d->services_type == "Air Ticket" && $get_q_d->type == "no_of_person" && $service_type == "lum_sum") {
                $air_ticket_all_entries_decode = json_decode($get_q_d->all_entries);
                $air_ticket_person_decode = json_decode($get_q_d->person_pricing_details);
                $air_ticket_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                // dd($air_ticket_person_decode);

                $airline_adult_cost_price = $air_ticket_person_decode[0]->airline_adult_cost_price;
                $airline_children_cost_price = $air_ticket_person_decode[0]->airline_children_cost_price;
                $airline_infant_cost_price = $air_ticket_person_decode[0]->airline_infant_cost_price;
                // dd($air_ticket_sub_total_details_decode);
                $total_cost_price_sl = $total_cost_price_sl + $air_ticket_sub_total_details_decode[0]->airline_sub_total;

                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_children > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_infant > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                $get_profit_by_services = count($get_quotation_details);
                $adult_profit = ($air_ticket_sub_total_details_decode[0]->no_of_person_adult_profit / $get_profit_by_services) / $no_of_adult;
                $infant_profit = ($air_ticket_sub_total_details_decode[0]->no_of_person_children_profit / $get_profit_by_services) / $no_of_children;
                $children_profit = ($air_ticket_sub_total_details_decode[0]->no_of_person_infant_profit / $get_profit_by_services) / $no_of_infant;


                $airline_adult_selling_price = $airline_adult_cost_price + $adult_profit;
                $airline_children_selling_price = $airline_children_cost_price + $children_profit;
                $airline_infant_selling_price = $airline_children_cost_price + $infant_profit;
                $airline_total_selling_price = $airline_adult_selling_price * $no_of_adult + $airline_children_selling_price * $no_of_children + $airline_infant_selling_price * $no_of_infant;
                $total_selling_price_sl = $total_selling_price_sl + $airline_total_selling_price;
                // dd($airline_total_selling_price);


            }
            if ($get_q_d->services_type == "Hotel" && $get_q_d->type == "no_of_person" && $service_type == "lum_sum") {
                $hotel_all_entries_decode = json_decode($get_q_d->all_entries);
                $hotel_person_decode = json_decode($get_q_d->person_pricing_details);
                $hotel_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                $hotel_total_cost_price = $hotel_sub_total_details_decode[0]->hotel_total_cost_price;
                // dd($hotel_sub_total_details_decode);
                $total_cost_price_sl = $total_cost_price_sl + $hotel_sub_total_details_decode[0]->hotel_total_cost_price;
                // $hotel_total_selling_price = $hotel_sub_total_details_decode[0]->hotel_total_selling_price;
                $count_of_legs_hotel = count($hotel_all_entries_decode);
                $step_1_divide_by_legs = $hotel_total_cost_price / $count_of_legs_hotel;
                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_children > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_infant > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                $step_2_divide_no_of_person_if_available = $step_1_divide_by_legs / $no_of_person;
                $get_hotel_adult_cost_price = $step_2_divide_no_of_person_if_available / $no_of_adult;
                $get_hotel_children_cost_price = $step_2_divide_no_of_person_if_available / $no_of_children;
                $get_hotel_infant_cost_price = $step_2_divide_no_of_person_if_available / $no_of_infant;

                $get_hotel_adult_cost_price = 0;
                $get_hotel_children_cost_price = 0;
                $get_hotel_infant_cost_price = 0;
                foreach ($hotel_person_decode as $key => $value) {
                    $adult_cost_price_l_s = $value->hotel_adult_cost_price * $no_of_adult;
                    $children_cost_price_l_s = $value->hotel_children_cost_price * $no_of_children;
                    $infant_cost_price_l_s = $value->hotel_infant_cost_price * $no_of_infant;
                    $get_hotel_adult_cost_price = ($get_hotel_adult_cost_price + (($adult_cost_price_l_s) * $value->hotel_qty) * $value->hotel_nights);
                    $get_hotel_children_cost_price = $get_hotel_children_cost_price + (($children_cost_price_l_s) * $value->hotel_qty) * $value->hotel_nights;
                    $get_hotel_infant_cost_price = $get_hotel_infant_cost_price + (($infant_cost_price_l_s) * $value->hotel_qty) * $value->hotel_nights;
                }
                // dd($get_hotel_children_cost_price);
                $get_profit_by_services = count($get_quotation_details);
                $adult_profit = ($hotel_sub_total_details_decode[0]->no_of_person_adult_profit / $get_profit_by_services) / $no_of_adult;
                $infant_profit = ($hotel_sub_total_details_decode[0]->no_of_person_children_profit / $get_profit_by_services) / $no_of_children;
                $children_profit = ($hotel_sub_total_details_decode[0]->no_of_person_infant_profit / $get_profit_by_services) / $no_of_infant;
                $count_of_legs_hotel = count($hotel_all_entries_decode);
                // dd($get_children_cost_price);
            }
            if ($get_q_d->services_type == "Land Services" && $get_q_d->type == "no_of_person" && $service_type == "lum_sum") {
                $land_services_all_entries_decode = json_decode($get_q_d->all_entries);
                $land_services_person_decode = json_decode($get_q_d->person_pricing_details);
                $land_services_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                // dd($land_services_sub_total_details_decode);
                $total_cost_price_sl = $total_cost_price_sl + $land_services_sub_total_details_decode[0]->land_services_sub_total;
                $get_profit_by_services = count($get_quotation_details);
                $adult_profit = ($land_services_sub_total_details_decode[0]->no_of_person_adult_profit / $get_profit_by_services) / $no_of_adult;
                $infant_profit = ($land_services_sub_total_details_decode[0]->no_of_person_children_profit / $get_profit_by_services) / $no_of_children;
                $children_profit = ($land_services_sub_total_details_decode[0]->no_of_person_infant_profit / $get_profit_by_services) / $no_of_infant;


                // dd($children_profit);

            }


            // Lum Sum To Service Level-------------------------------
            if ($get_q_d->services_type == "Visa" && $get_q_d->type == "lum_sum" && $service_type == "service_level") {
                $visa_all_entries_decode = json_decode($get_q_d->all_entries);
                $visa_person_decode = json_decode($get_q_d->person_pricing_details);
                $visa_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_children > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_infant > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                $get_profit_by_services = count($get_quotation_details);
                // $adult_profit = ($visa_sub_total_details_decode[0]->no_of_person_adult_profit / $get_profit_by_services) / $no_of_adult;
                // $infant_profit = ($visa_sub_total_details_decode[0]->no_of_person_children_profit / $get_profit_by_services) / $no_of_children;
                // $children_profit = ($visa_sub_total_details_decode[0]->no_of_person_infant_profit / $get_profit_by_services) / $no_of_infant;
                $adult_profit = 0;
                $infant_profit = 0;
                $children_profit = 0;


                $visa_adult_cost_price = $visa_person_decode[0]->visa_adult_cost_price;
                $visa_children_cost_price = $visa_person_decode[0]->visa_children_cost_price;
                $visa_infant_cost_price = $visa_person_decode[0]->visa_infant_cost_price;



                $visa_adult_selling_price = ($visa_adult_cost_price + $adult_profit);
                $visa_children_selling_price = ($visa_children_cost_price + $children_profit);
                $visa_infant_selling_price = ($visa_children_cost_price + $infant_profit);
                $visa_total_selling_price = $visa_adult_selling_price * $no_of_adult + $visa_children_selling_price * $no_of_children + $visa_infant_selling_price * $no_of_infant;
                $total_cost_price_sl = $total_cost_price_sl + $visa_sub_total_details_decode[0]->visa_total_cost_price;
                $total_selling_price_sl = $total_selling_price_sl + $visa_total_selling_price;
            }
            if ($get_q_d->services_type == "Air Ticket" && $get_q_d->type == "lum_sum" && $service_type == "service_level") {
                $air_ticket_all_entries_decode = json_decode($get_q_d->all_entries);
                $air_ticket_person_decode = json_decode($get_q_d->person_pricing_details);
                $air_ticket_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                // dd($air_ticket_person_decode);

                $airline_adult_cost_price = $air_ticket_person_decode[0]->airline_adult_cost_price;
                $airline_children_cost_price = $air_ticket_person_decode[0]->airline_children_cost_price;
                $airline_infant_cost_price = $air_ticket_person_decode[0]->airline_infant_cost_price;
                // dd($air_ticket_sub_total_details_decode);
                $total_cost_price_sl = $total_cost_price_sl + $air_ticket_sub_total_details_decode[0]->airline_sub_total;

                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_children > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_infant > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                $get_profit_by_services = count($get_quotation_details);
                // $adult_profit = ($air_ticket_sub_total_details_decode[0]->no_of_person_adult_profit / $get_profit_by_services) / $no_of_adult;
                // $infant_profit = ($air_ticket_sub_total_details_decode[0]->no_of_person_children_profit / $get_profit_by_services) / $no_of_children;
                // $children_profit = ($air_ticket_sub_total_details_decode[0]->no_of_person_infant_profit / $get_profit_by_services) / $no_of_infant;

                $adult_profit = 0;
                $infant_profit = 0;
                $children_profit = 0;

                $airline_adult_selling_price = $airline_adult_cost_price + $adult_profit;
                $airline_children_selling_price = $airline_children_cost_price + $children_profit;
                $airline_infant_selling_price = $airline_children_cost_price + $infant_profit;
                $airline_total_selling_price = $airline_adult_selling_price * $no_of_adult + $airline_children_selling_price * $no_of_children + $airline_infant_selling_price * $no_of_infant;
                $total_selling_price_sl = $total_selling_price_sl + $airline_total_selling_price;
                // dd($airline_total_selling_price);


            }
            if ($get_q_d->services_type == "Hotel" && $get_q_d->type == "lum_sum" && $service_type == "service_level") {
                $hotel_all_entries_decode = json_decode($get_q_d->all_entries);
                $hotel_person_decode = json_decode($get_q_d->person_pricing_details);
                $hotel_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                $hotel_total_cost_price = $hotel_sub_total_details_decode[0]->hotel_total_cost_price;
                // dd($hotel_sub_total_details_decode);
                $total_cost_price_sl = $total_cost_price_sl + $hotel_sub_total_details_decode[0]->hotel_total_cost_price;
                // $hotel_total_selling_price = $hotel_sub_total_details_decode[0]->hotel_total_selling_price;
                $count_of_legs_hotel = count($hotel_all_entries_decode);
                // dd($count_of_legs_hotel);
                $step_1_divide_by_legs = $hotel_total_cost_price / $count_of_legs_hotel;
                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                // if ($no_of_children > 0) {
                //     $no_of_person = $no_of_person + 1;
                // }
                // if ($no_of_infant > 0) {
                //     $no_of_person = $no_of_person + 1;
                // }
                $step_2_divide_no_of_person_if_available = $step_1_divide_by_legs / $no_of_person;
                $get_hotel_adult_cost_price = $step_2_divide_no_of_person_if_available / $no_of_adult;
                $get_hotel_children_cost_price = $step_2_divide_no_of_person_if_available / $no_of_children;
                $get_hotel_infant_cost_price = $step_2_divide_no_of_person_if_available / $no_of_infant;

                // dd($get_hotel_adult_cost_price);
                $get_profit_by_services = count($get_quotation_details);

                // dd($hotel_sub_total_details_decode[0]->lum_sum_profit);
                $adult_profit = ($hotel_sub_total_details_decode[0]->lum_sum_profit);
                $lum_sum_profit = ($hotel_sub_total_details_decode[0]->lum_sum_profit);
                $hotel_total_selling_price = 0;
                // dd($hotel_sub_total_details_decode[0]->lum_sum_profit);
            }
            if ($get_q_d->services_type == "Land Services" && $get_q_d->type == "lum_sum" && $service_type == "service_level") {
                $land_services_all_entries_decode = json_decode($get_q_d->all_entries);
                $land_services_person_decode = json_decode($get_q_d->person_pricing_details);
                $land_services_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                // dd($land_services_sub_total_details_decode);
                $total_cost_price_sl = $total_cost_price_sl + $land_services_sub_total_details_decode[0]->land_services_sub_total;
                $get_profit_by_services = count($get_quotation_details);
                // $adult_profit = ($land_services_sub_total_details_decode[0]->no_of_person_adult_profit / $get_profit_by_services) / $no_of_adult;
                // $infant_profit = ($land_services_sub_total_details_decode[0]->no_of_person_children_profit / $get_profit_by_services) / $no_of_children;
                // $children_profit = ($land_services_sub_total_details_decode[0]->no_of_person_infant_profit / $get_profit_by_services) / $no_of_infant;
                // dd($children_profit);

            }

            // Lum Sum To No Of Person----------------------------------
            if ($get_q_d->services_type == "Visa" && $get_q_d->type == "lum_sum" && $service_type == "no_of_person") {
                $visa_all_entries_decode = json_decode($get_q_d->all_entries);
                $visa_person_decode = json_decode($get_q_d->person_pricing_details);
                $visa_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_children > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_infant > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                $get_profit_by_services = count($get_quotation_details);
                // $adult_profit = ($visa_sub_total_details_decode[0]->no_of_person_adult_profit / $get_profit_by_services) / $no_of_adult;
                // $infant_profit = ($visa_sub_total_details_decode[0]->no_of_person_children_profit / $get_profit_by_services) / $no_of_children;
                // $children_profit = ($visa_sub_total_details_decode[0]->no_of_person_infant_profit / $get_profit_by_services) / $no_of_infant;
                $adult_profit = 0;
                $infant_profit = 0;
                $children_profit = 0;

                $visa_adult_cost_price = $visa_person_decode[0]->visa_adult_cost_price;
                $visa_children_cost_price = $visa_person_decode[0]->visa_children_cost_price;
                $visa_infant_cost_price = $visa_person_decode[0]->visa_infant_cost_price;



                $visa_adult_selling_price = ($visa_adult_cost_price + $adult_profit);
                $visa_children_selling_price = ($visa_children_cost_price + $children_profit);
                $visa_infant_selling_price = ($visa_children_cost_price + $infant_profit);
                $visa_total_selling_price = $visa_adult_selling_price * $no_of_adult + $visa_children_selling_price * $no_of_children + $visa_infant_selling_price * $no_of_infant;
                $total_cost_price_sl = $total_cost_price_sl + $visa_sub_total_details_decode[0]->visa_total_cost_price;
                $total_selling_price_sl = $total_selling_price_sl + $visa_total_selling_price;
            }
            if ($get_q_d->services_type == "Air Ticket" && $get_q_d->type == "lum_sum" && $service_type == "no_of_person") {
                $air_ticket_all_entries_decode = json_decode($get_q_d->all_entries);
                $air_ticket_person_decode = json_decode($get_q_d->person_pricing_details);
                $air_ticket_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                // dd($air_ticket_person_decode);

                $airline_adult_cost_price = $air_ticket_person_decode[0]->airline_adult_cost_price;
                $airline_children_cost_price = $air_ticket_person_decode[0]->airline_children_cost_price;
                $airline_infant_cost_price = $air_ticket_person_decode[0]->airline_infant_cost_price;
                // dd($air_ticket_sub_total_details_decode);
                $total_cost_price_sl = $total_cost_price_sl + $air_ticket_sub_total_details_decode[0]->airline_sub_total;

                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_children > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                if ($no_of_infant > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                $get_profit_by_services = count($get_quotation_details);
                // $adult_profit = ($air_ticket_sub_total_details_decode[0]->no_of_person_adult_profit / $get_profit_by_services) / $no_of_adult;
                // $infant_profit = ($air_ticket_sub_total_details_decode[0]->no_of_person_children_profit / $get_profit_by_services) / $no_of_children;
                // $children_profit = ($air_ticket_sub_total_details_decode[0]->no_of_person_infant_profit / $get_profit_by_services) / $no_of_infant;
                $adult_profit = 0;
                $infant_profit = 0;
                $children_profit = 0;

                $airline_adult_selling_price = $airline_adult_cost_price + $adult_profit;
                $airline_children_selling_price = $airline_children_cost_price + $children_profit;
                $airline_infant_selling_price = $airline_children_cost_price + $infant_profit;
                $airline_total_selling_price = $airline_adult_selling_price * $no_of_adult + $airline_children_selling_price * $no_of_children + $airline_infant_selling_price * $no_of_infant;
                $total_selling_price_sl = $total_selling_price_sl + $airline_total_selling_price;
                // dd($airline_total_selling_price);


            }
            if ($get_q_d->services_type == "Hotel" && $get_q_d->type == "lum_sum" && $service_type == "no_of_person") {
                $hotel_all_entries_decode = json_decode($get_q_d->all_entries);
                $hotel_person_decode = json_decode($get_q_d->person_pricing_details);
                $hotel_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                $hotel_total_cost_price = $hotel_sub_total_details_decode[0]->hotel_total_cost_price;
                // dd($hotel_sub_total_details_decode);
                $total_cost_price_sl = $total_cost_price_sl + $hotel_sub_total_details_decode[0]->hotel_total_cost_price;
                // $hotel_total_selling_price = $hotel_sub_total_details_decode[0]->hotel_total_selling_price;
                $count_of_legs_hotel = count($hotel_all_entries_decode);
                $step_1_divide_by_legs = $hotel_total_cost_price / $count_of_legs_hotel;
                $no_of_person = 0;
                if ($no_of_adult > 0) {
                    $no_of_person = $no_of_person + 1;
                }
                // if ($no_of_children > 0) {
                //     $no_of_person = $no_of_person + 1;
                // }
                // if ($no_of_infant > 0) {
                //     $no_of_person = $no_of_person + 1;
                // }
                $step_2_divide_no_of_person_if_available = $step_1_divide_by_legs / $no_of_person;
                $get_hotel_adult_cost_price = $step_2_divide_no_of_person_if_available / $no_of_adult;
                $get_hotel_children_cost_price = $step_2_divide_no_of_person_if_available / $no_of_children;
                $get_hotel_infant_cost_price = $step_2_divide_no_of_person_if_available / $no_of_infant;

                $get_hotel_adult_cost_price = 0;
                $get_hotel_children_cost_price = 0;
                $get_hotel_infant_cost_price = 0;
                foreach ($hotel_person_decode as $key => $value) {
                    $adult_cost_price_l_s = $value->hotel_adult_cost_price * $no_of_adult;
                    $children_cost_price_l_s = $value->hotel_children_cost_price * $no_of_children;
                    $infant_cost_price_l_s = $value->hotel_infant_cost_price * $no_of_infant;
                    $get_hotel_adult_cost_price = ($get_hotel_adult_cost_price + (($adult_cost_price_l_s) * $value->hotel_qty) * $value->hotel_nights);
                    $get_hotel_children_cost_price = $get_hotel_children_cost_price + (($children_cost_price_l_s) * $value->hotel_qty) * $value->hotel_nights;
                    $get_hotel_infant_cost_price = $get_hotel_infant_cost_price + (($infant_cost_price_l_s) * $value->hotel_qty) * $value->hotel_nights;
                }
                // dd($get_hotel_children_cost_price);
                $get_profit_by_services = count($get_quotation_details);
                $adult_profit = 0;
                $infant_profit = 0;
                $children_profit = 0;
                // $adult_profit = ($hotel_sub_total_details_decode[0]->no_of_person_adult_profit / $get_profit_by_services) / $no_of_adult;
                // $infant_profit = ($hotel_sub_total_details_decode[0]->no_of_person_children_profit / $get_profit_by_services) / $no_of_children;
                // $children_profit = ($hotel_sub_total_details_decode[0]->no_of_person_infant_profit / $get_profit_by_services) / $no_of_infant;
                $count_of_legs_hotel = count($hotel_all_entries_decode);
                // dd($get_children_cost_price);
            }
            if ($get_q_d->services_type == "Land Services" && $get_q_d->type == "lum_sum" && $service_type == "no_of_person") {
                $land_services_all_entries_decode = json_decode($get_q_d->all_entries);
                $land_services_person_decode = json_decode($get_q_d->person_pricing_details);
                $land_services_sub_total_details_decode = json_decode($get_q_d->sub_total_details);
                // dd($land_services_sub_total_details_decode);
                $total_cost_price_sl = $total_cost_price_sl + $land_services_sub_total_details_decode[0]->land_services_sub_total;
                $get_profit_by_services = count($get_quotation_details);
                // $adult_profit = ($land_services_sub_total_details_decode[0]->no_of_person_adult_profit / $get_profit_by_services) / $no_of_adult;
                // $infant_profit = ($land_services_sub_total_details_decode[0]->no_of_person_children_profit / $get_profit_by_services) / $no_of_children;
                // $children_profit = ($land_services_sub_total_details_decode[0]->no_of_person_infant_profit / $get_profit_by_services) / $no_of_infant;

                $adult_profit = 0;
                $infant_profit = 0;
                $children_profit = 0;
                // dd($children_profit);
            }
            // ---------------------------End----------------------------------------

            $get_parent_name = other_service::where('id_other_services', $get_q_d->services_id)->select('service_name')->first();
            $sub_service_name = $get_q_d->services_type;
            $sub_name = $get_q_d->services_type;
            $hotel_adult_cost_price = 0;
            $hotel_children_cost_price = 0;
            $hotel_infant_cost_price = 0;
            $land_services_total_selling_price = 0;

            if ($sub_service_name == "Hotel") {
                $sub_name = "Hotel";
                $all_types_rate = room_type::where('status', "Active")->get();
                $currency_rates = currency_exchange_rate::all();
                $addon = addon::where('status', 1)->get();
                // dd($addon);
                $hotel_options = "<option>Select Hotel</option>";
                $room_type_options = "<option>Select Room Type</option>";
                $currency_rate_options = "<option>Select Currency</option>";
                $addon_options = "<option>Select Addon</option>";

                foreach ($all_types_rate as $key => $value) {
                    $room_type_options .= "<option selected value='" . $value->id_room_types . "'>" . $value->name . "</option>";
                }

                foreach ($currency_rates as $key => $value) {
                    $currency_rate_options .= "<option value='" . $value->currency_rate . "'>" . $value->currency_name . "</option>";
                }

                foreach ($addon as $key => $value) {
                    $addon_options .= "<option  value='" . $value->id_addons . "'>" . $value->addon_name . "</option>";
                }
                // dd($addon_options);
                $hotel_legs = "";

                if ($get_q_d->type == "no_of_person" && $service_type == "service_level") {
                    $hotel_total_selling_price = 0;
                    $hotel_legs_count = count($hotel_all_entries_decode);
                    foreach ($hotel_all_entries_decode as $key => $hotel_leg_d) {

                        $hotel_nights = $hotel_person_decode[$key]->hotel_nights;
                        $hotel_qty = $hotel_person_decode[$key]->hotel_qty;

                        // $hotel_adult_cost_price = $hotel_adult_cost_price + round($hotel_person_decode[$key]->hotel_adult_cost_price) * $hotel_nights;
                        // $hotel_children_cost_price = $hotel_children_cost_price + round($hotel_person_decode[$key]->hotel_children_cost_price) * $hotel_nights;
                        // $hotel_infant_cost_price = $hotel_infant_cost_price + round($hotel_person_decode[$key]->hotel_infant_cost_price) * $hotel_nights;
                        $hotel_adult_cost_price =   (round($hotel_person_decode[$key]->hotel_adult_cost_price) * $no_of_adult);
                        $hotel_children_cost_price =  (round($hotel_person_decode[$key]->hotel_children_cost_price) * $no_of_children);
                        $hotel_infant_cost_price =  (round($hotel_person_decode[$key]->hotel_infant_cost_price) * $no_of_infant);
                        $hotel_cost_price = $hotel_adult_cost_price + $hotel_infant_cost_price + $hotel_children_cost_price;

                        $hotel_adult_selling_price = ($hotel_adult_cost_price + $adult_profit);
                        $hotel_children_selling_price = ($hotel_children_cost_price + $children_profit);
                        $hotel_infant_selling_price = ($hotel_infant_cost_price + $infant_profit);

                        $hotel_selling_price = $hotel_adult_selling_price + $hotel_children_selling_price + $hotel_infant_selling_price;

                        if ($hotel_nights > 0) {
                            $hotel_selling_price_calc = ($hotel_selling_price * $hotel_nights) * $hotel_qty;
                        }
                        // dd($hotel_selling_price);
                        $hotel_total_selling_price = $hotel_total_selling_price + $hotel_selling_price_calc;


                        // $hotel_selling_price = $selling_price / $hotel_legs_count + $hotel_cost_price;
                        // dd($hotel_leg_d);
                        // $hotel_cost_price = $hotel_person_decode[$key]->hotel_adult_cost_price + $hotel_person_decode[$key]->hotel_children_cost_price + $hotel_person_decode[$key]->hotel_infant_cost_price;


                        // dd($hotel_nights);


                        // dd($hotel_nights);
                        $all_types_rate = room_type::where('status', "Active")->where('id_room_types', $hotel_leg_d->room_type)->first();
                        $room_type_options .= "<option selected value='" . $all_types_rate->id_room_types . "'>" . $all_types_rate->name . "</option>";
                        $all_hotels = hotels::where('hotel_status', 1)->where('id_hotels', $hotel_leg_d->hotel_name)->join('hotel_details', 'hotel_details.id_hotel_details', 'hotels.id_hotels')->first();
//                         dd($all_hotels);
                        $explode = explode("-", $all_hotels?->country);
                        $hotel_options .= "<option selected value='" . $hotel_leg_d?->hotel_name . "'>" . $all_hotels->hotel_name . " | <span>" . $explode[1] . "</span></option>";
                        $hotel_legs .= '<table class="table table-striped table-inverse table-responsive mt-2">
                        <thead class="thead-inverse">
                            <tr>
                            <th>Hotels</th>
                            <th>Room Type</th>
                            <th>Qty</th>
                            <th>Addon</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div id="append_hotel">
                            <tr>
                            <td><select disabled id="hotels' . $append_count . '" name="hotel[' . $append_count . '][legs_count][hotel_name][]" onchange="modal_inventory_hotel(' . $append_count . ',this)" class="form-control select2' . $append_count . '" >
                            ' . $hotel_options . '
                                                    </select></td>
                                                    <input  value="' . $hotel_leg_d->hotel_inv_id . '" type="hidden" class="hotel_inv_id"  name="hotel[' . $append_count . '][legs_count][hotel_inv_id][]" id="hotel_inv_id' . $append_count . '">
                                                    <td><select disabled class="form-control select2' . $append_count . '" onchange="room_type_on_change(' . $append_count . ')" name="hotel[' . $append_count . '][legs_count][room_type][]" id="hotel_room_type' . $append_count . '">
                                                    ' . $room_type_options . '
                                                                            </select></td>
                                                    <input  type="hidden" class="get_sub_total_legs' . $append_count . '" id="get_sub_total_legs' . $append_count . '"/>
                                                    <td><input disabled value="' . $hotel_person_decode[$key]->hotel_qty . '"  type="number" id="hotel_qty' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][legs_count][hotel_qty][]" class="form-control"></td>
                                                    <td> <select disabled  multiple="multiple" onchange="hotel_calculate(' . $key . ')" name="hotel[' . $append_count . '][legs_count][hotel_addon][]"  class=" addon-select form-control hotel_addon js-example-basic-multiple' . $append_count . ' hotel_addon' . $append_count . ' " id="hotel_addon' . $key . '">' . $addon_options . '</select></td>
                            </tr>
                            </div>
                        </tbody>
                    </table>
                    <table class="table table-striped table-inverse table-responsive mt-2">
<thead class="thead-inverse">
    <tr>
    <th>Hotel Category</th>
    <th>City</th>
    </tr>
</thead>
<tbody>
    <div id="append_hotel">
    <tr>
    <td style="width:100%;" ><select style="width:100%;"  required id="" name="hotel[' . $append_count . '][legs_count][hotel_category][]"  class="form-control select2' . $append_count . '" >
    <option value="economy">Economy</option>
<option value="standard">Standard</option>
<option value="2-star" >2-Star</option>
<option value="3-star" >3-Star</option>
<option value="4-star" >4-Star</option>
<option value="5-star" >5-Star</option>
    </select></td>
    <td style="width:100%;" ><select required id="" style="width:100%;" name="hotel[' . $append_count . '][legs_count][hotel_city][]"  class="form-control livesearch_hotel_city select2' . $append_count . '" >
    </select></td>
    </tr>
    </div>
</tbody>
</table>
                    <table class="table table-striped table-inverse table-responsive mt-2">
                    <thead class="thead-inverse">
                        <tr>
                        <th>Cost Price</th>
                        <th>Selling Price</th>
                        <th>Check In</th>
                        <th>Nights</th>
                        <th>Check Out</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div id="append_hotel">
                        <tr>
                                                <td><input disabled value="' . $hotel_cost_price . '"   type="number"  id="hotel_cost_price' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_cost_price][]" class="form-control hotel_cost_price' . $append_count . ' "></td>
                                                <td><input disabled value="' . $hotel_selling_price . '"  type="number"  id="hotel_selling_price' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_selling_price][]" class="form-control  "></td>
                                                <td><input disabled value="' . $hotel_leg_d->hotel_check_in . '" type="text" placeholder="mm/dd/yyyy" readonly id="hotel_check_in' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"    name="hotel[' . $append_count . '][legs_count][hotel_check_in][]" class="form-control fc-datepicker' . $append_count . '"></td>
                                                <td><input disabled value="' . $hotel_person_decode[$key]->hotel_nights . '"  type="number" placeholder="2 Nights"  id="hotel_nights' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_nights][]" class="form-control"></td>
                                                <td><input disabled value="' . $hotel_leg_d->hotel_check_out . '"  type="text" placeholder="mm/dd/yyyy" readonly id="hotel_check_out' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_check_out][]" class="form-control fc-datepicker' . $append_count . '"></td>

                        </tr>
                        </div>
                    </tbody>
                    </table>';
                    }

                    $total_selling_price_sl = $total_selling_price_sl + $hotel_total_selling_price;
                }
                if ($get_q_d->type == "service_level") {
                    foreach ($hotel_all_entries_decode as $key => $hotel_leg_d) {
                        $hotel_qty = $hotel_person_decode[$key]->hotel_qty;
                        // dd($hotel_person_decode);
                        $hotel_nights = $hotel_all_entries_decode[$key]->hotel_nights;
                        if ($hotel_nights != "null" || $hotel_nights != 0) {
                            $hotel_cost_price = round((($hotel_person_decode[$key]->hotel_cost_price / 3) * $hotel_qty) * $hotel_nights);
                            $hotel_selling_price = round((($hotel_person_decode[$key]->hotel_selling_price / 3) * $hotel_qty) * $hotel_nights);
                        } else {
                            $hotel_cost_price = round(($hotel_person_decode[$key]->hotel_cost_price / 3) * $hotel_qty);
                            $hotel_selling_price = round(($hotel_person_decode[$key]->hotel_selling_price / 3) * $hotel_qty);
                        }

                        $adult_cost_price = (($adult_cost_price + $hotel_cost_price) * $no_of_adult);
                        $children_cost_price = ($children_cost_price + $hotel_cost_price) * $no_of_children;
                        $infant_cost_price = ($infant_cost_price + $hotel_cost_price) * $no_of_infant;

                        $adult_selling_price = ($adult_selling_price + $hotel_selling_price) * $no_of_adult;
                        $children_selling_price = ($children_selling_price + $hotel_selling_price) * $no_of_children;
                        $infant_selling_price = ($infant_selling_price + $hotel_selling_price) * $no_of_infant;
                        // dd($hotel_nights);
                        $all_types_rate = room_type::where('status', "Active")->where('id_room_types', $hotel_leg_d->room_type)->first();
                        $room_type_options .= "<option value='" . $all_types_rate?->id_room_types . "'>" . $all_types_rate?->name . "</option>";
                        $all_hotels = hotels::where('hotel_status', 1)->where('id_hotels', $hotel_leg_d->hotel_name)->join('hotel_details', 'hotel_details.hotel_id', 'hotels.id_hotels')->first();
                        $explode = explode("-", $all_hotels?->country);
                        // dd($hotel_leg_d->hotel_name);
                        // dd($hotel_leg_d->hotel_name);
                        $hotel_options .= "<option selected value='" . $hotel_leg_d?->hotel_name . "'>" . $all_hotels?->hotel_name . " | <span>" . $explode[1] . "</span></option>";
                        $hotel_legs .= '
        <table class="table table-striped table-inverse table-responsive mt-2">
        <thead class="thead-inverse">
            <tr>
            <th>Check In</th>
            <th>Nights</th>
            <th>Check Out</th>
            <th>Hotels</th>
            <th>Room Type</th>
            <th>Qty</th>
            <th>Addon</th>
            </tr>
        </thead>
        <tbody>
            <div id="append_hotel">
            <tr>
            <td><input disabled value="' . $hotel_leg_d->hotel_check_in . '"   type="text" placeholder="mm/dd/yyyy" readonly id="hotel_check_in' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"    name="hotel[' . $append_count . '][legs_count][hotel_check_in][]" class="form-control fc-datepicker' . $append_count . '"></td>
            <td><input disabled value="' . $hotel_nights . '"  type="number" placeholder="2 Nights"  id="hotel_nights' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_nights][]" class="form-control"></td>
            <td><input disabled value="' . $hotel_leg_d->hotel_check_out . '"  type="text" placeholder="mm/dd/yyyy" readonly id="hotel_check_out' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_check_out][]" class="form-control fc-datepicker' . $append_count . '"></td>
            <td><select disabled id="hotels' . $append_count . '" name="hotel[' . $append_count . '][legs_count][hotel_name][]" onchange="modal_inventory_hotel(' . $append_count . ',this)" class="form-control select2' . $append_count . '" >
            ' . $hotel_options . '
                                    </select></td>
                                    <input  type="hidden" class="hotel_inv_id"  name="hotel[' . $append_count . '][legs_count][hotel_inv_id][]" id="hotel_inv_id' . $append_count . '">
                                    <td><select disabled class="form-control select2' . $append_count . '" onchange="room_type_on_change(' . $append_count . ')" name="hotel[' . $append_count . '][legs_count][room_type][]" id="hotel_room_type' . $append_count . '">
                                    ' . $room_type_options . '
                                                            </select></td>
                                    <input type="hidden" class="get_sub_total_legs' . $append_count . '" id="get_sub_total_legs' . $append_count . '"/>
                                    <td><input disabled value="' . $hotel_person_decode[$key]->hotel_qty . '"  type="number" id="hotel_qty' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][legs_count][hotel_qty][]" class="form-control"></td>
                                    <td> <select disabled multiple="multiple" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][legs_count][hotel_addon][]"  class=" addon-select form-control hotel_addon js-example-basic-multiple' . $append_count . ' hotel_addon' . $append_count . ' " id="hotel_addon' . $append_count . '">' . $addon_options . '</select></td>

            </tr>
            </div>
        </tbody>
    </table>
    <table class="table table-striped table-inverse table-responsive mt-2">
<thead class="thead-inverse">
    <tr>
    <th>City</th>
    <th>Hotel Category</th>
    
    </tr>
</thead>
<tbody>
    <div id="append_hotel">
    <tr>
    <td style="width:100%;" ><select disabled="disabled" id="" style="width:100%;" name="hotel[' . $append_count . '][legs_count][hotel_city][]"  class="form-control livesearch_hotel_city select2' . $append_count . '" >
    </select></td>
    <td style="width:100%;" ><select style="width:100%;" disabled="disabled" id="" name="hotel[' . $append_count . '][legs_count][hotel_category][]"  class="form-control select2' . $append_count . '" >
    <option value="economy">Economy</option>
<option value="standard">Standard</option>
<option value="2-star" >2-Star</option>
<option value="3-star" >3-Star</option>
<option value="4-star" >4-Star</option>
<option value="5-star" >5-Star</option>
    </select></td>
    
    </tr>
    </div>
</tbody>
</table>
    <table class="table table-striped table-inverse table-responsive mt-2">
    <thead class="thead-inverse">
        <tr>
        <th>Cost Price</th>
        </tr>
    </thead>
    <tbody>
        <div id="append_hotel">
        <tr>
        <input  type="hidden"  id="hotel_adult_total_cost_price' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_cost_price][]" class="form-control hotel_cost_price' . $append_count . '  hotel_adult_total_cost_price' . $append_count . ' adult_cost_price_sum ">
                                <td><input disabled value="' . $get_hotel_adult_cost_price . '"  type="number"  id="hotel_adult_cost_price' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_adult_cost_price][]" class="form-control hotel_cost_price' . $append_count . ' "></td>
                                

        </tr>
        </div>
    </tbody>
    </table>
        ';
                    }
                }
                if ($get_q_d->type == "lum_sum" && $service_type == "service_level") {
                    // dd('sdsd');
                    foreach ($hotel_all_entries_decode as $key => $hotel_leg_d) {
                        $hotel_qty = $hotel_person_decode[$key]->hotel_qty;
                        $hotel_nights = $hotel_person_decode[$key]->hotel_nights;
                        if ($hotel_nights != "null" || $hotel_nights != 0) {
                            $hotel_cost_price = 0;
                            $hotel_selling_price = 0;
                        } else {
                            $hotel_cost_price = round(($hotel_person_decode[$key]->hotel_cost_price / 3) * $hotel_qty);
                            $hotel_selling_price = round(($hotel_person_decode[$key]->hotel_selling_price / 3) * $hotel_qty);
                        }


                        $hotel_adult_cost_price = $hotel_person_decode[$key]->hotel_adult_cost_price;
                        $hotel_children_cost_price = $hotel_person_decode[$key]->hotel_children_cost_price;
                        $hotel_infant_cost_price = $hotel_person_decode[$key]->hotel_infant_cost_price;
                        $adult_cost_price = round((($adult_cost_price + $hotel_adult_cost_price)));
                        $children_cost_price = round(($children_cost_price + $hotel_children_cost_price));
                        $infant_cost_price = round(($infant_cost_price + $hotel_infant_cost_price));



                        $adult_selling_price = ($adult_selling_price + $hotel_selling_price) * $no_of_adult;
                        $children_selling_price = ($children_selling_price + $hotel_selling_price) * $no_of_children;
                        $infant_selling_price = ($infant_selling_price + $hotel_selling_price) * $no_of_infant;
                        // dd($hotel_nights);
                        $all_types_rate = room_type::where('status', "Active")->where('id_room_types', $hotel_leg_d->room_type)->first();
                        $room_type_options .= "<option selected value='" . $all_types_rate->id_room_types . "'>" . $all_types_rate->name . "</option>";
                        $all_hotels = hotels::where('hotel_status', 1)->where('id_hotels', $hotel_leg_d->hotel_name)->join('hotel_details', 'hotel_details.id_hotel_details', 'hotels.id_hotels')->first();
                        $explode = explode("-", $all_hotels->country);
                        $hotel_options .= "<option selected value='" . $hotel_leg_d->hotel_name . "'>" . $all_hotels->hotel_name . " | <span>" . $explode[1] . "</span></option>";
                        $hotel_legs .= '
        <table class="table table-striped table-inverse table-responsive mt-2">
        <thead class="thead-inverse">
            <tr>
            <th>Check In</th>
            <th>Nights</th>
            <th>Check Out</th>
            <th>Hotels</th>
            <th>Room Type</th>
            <th>Qty</th>
            <th>Addon</th>
            </tr>
        </thead>
        <tbody>
            <div id="append_hotel">
            <tr>
            <td><input disabled value="' . $hotel_leg_d->hotel_check_in . '"   type="text" placeholder="mm/dd/yyyy" readonly id="hotel_check_in' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"    name="hotel[' . $append_count . '][legs_count][hotel_check_in][]" class="form-control fc-datepicker' . $append_count . '"></td>
            <td><input disabled value="' . $hotel_nights . '"  type="number" placeholder="2 Nights"  id="hotel_nights' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_nights][]" class="form-control"></td>
            <td><input disabled value="' . $hotel_leg_d->hotel_check_out . '"  type="text" placeholder="mm/dd/yyyy" readonly id="hotel_check_out' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_check_out][]" class="form-control fc-datepicker' . $append_count . '"></td>
            <td><select disabled id="hotels' . $append_count . '" name="hotel[' . $append_count . '][legs_count][hotel_name][]" onchange="modal_inventory_hotel(' . $append_count . ',this)" class="form-control select2' . $append_count . '" >
            ' . $hotel_options . '
                                    </select></td>
                                    <input  type="hidden" class="hotel_inv_id"  name="hotel[' . $append_count . '][legs_count][hotel_inv_id][]" id="hotel_inv_id' . $append_count . '">
                                    <td><select disabled class="form-control select2' . $append_count . '" onchange="room_type_on_change(' . $append_count . ')" name="hotel[' . $append_count . '][legs_count][room_type][]" id="hotel_room_type' . $append_count . '">
                                    ' . $room_type_options . '
                                                            </select></td>
                                    <input type="hidden" class="get_sub_total_legs' . $append_count . '" id="get_sub_total_legs' . $append_count . '"/>
                                    <td><input disabled value="' . $hotel_person_decode[$key]->hotel_qty . '"  type="number" id="hotel_qty' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][legs_count][hotel_qty][]" class="form-control"></td>
                                    <td> <select disabled multiple="multiple" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][legs_count][hotel_addon][]"  class=" addon-select form-control hotel_addon js-example-basic-multiple' . $append_count . ' hotel_addon' . $append_count . ' " id="hotel_addon' . $append_count . '">' . $addon_options . '</select></td>

            </tr>
            </div>
        </tbody>
    </table>
    <table class="table table-striped table-inverse table-responsive mt-2">
<thead class="thead-inverse">
    <tr>
    <th>Hotel Category</th>
    <th>City</th>
    </tr>
</thead>
<tbody>
    <div id="append_hotel">
    <tr>
    <td style="width:100%;" ><select style="width:100%;"  required id="" name="hotel[' . $append_count . '][legs_count][hotel_category][]"  class="form-control select2' . $append_count . '" >
    <option value="economy">Economy</option>
<option value="standard">Standard</option>
<option value="2-star" >2-Star</option>
<option value="3-star" >3-Star</option>
<option value="4-star" >4-Star</option>
<option value="5-star" >5-Star</option>
    </select></td>
    <td style="width:100%;" ><select required id="" style="width:100%;" name="hotel[' . $append_count . '][legs_count][hotel_city][]"  class="form-control livesearch_hotel_city select2' . $append_count . '" >
    </select></td>
    </tr>
    </div>
</tbody>
</table>
    <table class="table table-striped table-inverse table-responsive mt-2">
    <thead class="thead-inverse">
        <tr>
        <th>Adult Cost Price</th>
        </tr>
    </thead>
    <tbody>
        <div id="append_hotel">
        <tr>
        <input  type="hidden"  id="hotel_adult_total_cost_price' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_cost_price][]" class="form-control hotel_cost_price' . $append_count . '  hotel_adult_total_cost_price' . $append_count . ' adult_cost_price_sum ">
                                <td><input disabled value="' . $hotel_adult_cost_price . '"  type="number"  id="hotel_adult_cost_price' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_adult_cost_price][]" class="form-control hotel_cost_price' . $append_count . ' "></td>


        </tr>
        </div>
    </tbody>
    </table>
        ';
                    }
                }
                if ($get_q_d->type == "no_of_person" && $service_type == "lum_sum") {
                    // dd('sdsd');
                    foreach ($hotel_all_entries_decode as $key => $hotel_leg_d) {
                        $hotel_qty = $hotel_person_decode[$key]->hotel_qty;
                        $hotel_nights = $hotel_person_decode[$key]->hotel_nights;
                        if ($hotel_nights != "null" || $hotel_nights != 0) {
                            $hotel_cost_price = 0;
                            $hotel_selling_price = 0;
                        } else {
                            $hotel_cost_price = round(($hotel_person_decode[$key]->hotel_cost_price / 3) * $hotel_qty);
                            $hotel_selling_price = round(($hotel_person_decode[$key]->hotel_selling_price / 3) * $hotel_qty);
                        }


                        $hotel_adult_cost_price = $hotel_person_decode[$key]->hotel_adult_cost_price;
                        $hotel_children_cost_price = $hotel_person_decode[$key]->hotel_children_cost_price;
                        $hotel_infant_cost_price = $hotel_person_decode[$key]->hotel_infant_cost_price;
                        $adult_cost_price = round((($adult_cost_price + $hotel_adult_cost_price)));
                        $children_cost_price = round(($children_cost_price + $hotel_children_cost_price));
                        $infant_cost_price = round(($infant_cost_price + $hotel_infant_cost_price));



                        $adult_selling_price = ($adult_selling_price + $hotel_selling_price) * $no_of_adult;
                        $children_selling_price = ($children_selling_price + $hotel_selling_price) * $no_of_children;
                        $infant_selling_price = ($infant_selling_price + $hotel_selling_price) * $no_of_infant;
                        // dd($hotel_nights);
                        $all_types_rate = room_type::where('status', "Active")->where('id_room_types', $hotel_leg_d->room_type)->first();
                        $room_type_options .= "<option selected value='" . $all_types_rate->id_room_types . "'>" . $all_types_rate->name . "</option>";
                        $all_hotels = hotels::where('hotel_status', 1)->where('id_hotels', $hotel_leg_d->hotel_name)->join('hotel_details', 'hotel_details.id_hotel_details', 'hotels.id_hotels')->first();
                        $explode = explode("-", $all_hotels->country);
                        $hotel_options .= "<option selected value='" . $hotel_leg_d->hotel_name . "'>" . $all_hotels->hotel_name . " | <span>" . $explode[1] . "</span></option>";
                        $hotel_legs .= '
        <table class="table table-striped table-inverse table-responsive mt-2">
        <thead class="thead-inverse">
            <tr>
            <th>Check In</th>
            <th>Nights</th>
            <th>Check Out</th>
            <th>Hotels</th>
            <th>Room Type</th>
            <th>Qty</th>
            <th>Addon</th>
            </tr>
        </thead>
        <tbody>
            <div id="append_hotel">
            <tr>
            <td><input disabled value="' . $hotel_leg_d->hotel_check_in . '"   type="text" placeholder="mm/dd/yyyy" readonly id="hotel_check_in' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"    name="hotel[' . $append_count . '][legs_count][hotel_check_in][]" class="form-control fc-datepicker' . $append_count . '"></td>
            <td><input disabled value="' . $hotel_nights . '"  type="number" placeholder="2 Nights"  id="hotel_nights' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_nights][]" class="form-control"></td>
            <td><input disabled value="' . $hotel_leg_d->hotel_check_out . '"  type="text" placeholder="mm/dd/yyyy" readonly id="hotel_check_out' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_check_out][]" class="form-control fc-datepicker' . $append_count . '"></td>
            <td><select disabled id="hotels' . $append_count . '" name="hotel[' . $append_count . '][legs_count][hotel_name][]" onchange="modal_inventory_hotel(' . $append_count . ',this)" class="form-control select2' . $append_count . '" >
            ' . $hotel_options . '
                                    </select></td>
                                    <input  type="hidden" class="hotel_inv_id"  name="hotel[' . $append_count . '][legs_count][hotel_inv_id][]" id="hotel_inv_id' . $append_count . '">
                                    <td><select disabled class="form-control select2' . $append_count . '" onchange="room_type_on_change(' . $append_count . ')" name="hotel[' . $append_count . '][legs_count][room_type][]" id="hotel_room_type' . $append_count . '">
                                    ' . $room_type_options . '
                                                            </select></td>
                                    <input type="hidden" class="get_sub_total_legs' . $append_count . '" id="get_sub_total_legs' . $append_count . '"/>
                                    <td><input disabled value="' . $hotel_person_decode[$key]->hotel_qty . '"  type="number" id="hotel_qty' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][legs_count][hotel_qty][]" class="form-control"></td>
                                    <td> <select disabled multiple="multiple" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][legs_count][hotel_addon][]"  class=" addon-select form-control hotel_addon js-example-basic-multiple' . $append_count . ' hotel_addon' . $append_count . ' " id="hotel_addon' . $append_count . '">' . $addon_options . '</select></td>

            </tr>
            </div>
        </tbody>
    </table>
    <table class="table table-striped table-inverse table-responsive mt-2">
<thead class="thead-inverse">
    <tr>
    <th>Hotel Category</th>
    <th>City</th>
    </tr>
</thead>
<tbody>
    <div id="append_hotel">
    <tr>
    <td style="width:100%;" ><select style="width:100%;"  required id="" name="hotel[' . $append_count . '][legs_count][hotel_category][]"  class="form-control select2' . $append_count . '" >
    <option value="economy">Economy</option>
<option value="standard">Standard</option>
<option value="2-star" >2-Star</option>
<option value="3-star" >3-Star</option>
<option value="4-star" >4-Star</option>
<option value="5-star" >5-Star</option>
    </select></td>
    <td style="width:100%;" ><select required id="" style="width:100%;" name="hotel[' . $append_count . '][legs_count][hotel_city][]"  class="form-control livesearch_hotel_city select2' . $append_count . '" >
    </select></td>
    </tr>
    </div>
</tbody>
</table>
    <table class="table table-striped table-inverse table-responsive mt-2">
    <thead class="thead-inverse">
        <tr>
        <th>Adult Cost Price</th>
        </tr>
    </thead>
    <tbody>
        <div id="append_hotel">
        <tr>
        <input  type="hidden"  id="hotel_adult_total_cost_price' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_cost_price][]" class="form-control hotel_cost_price' . $append_count . '  hotel_adult_total_cost_price' . $append_count . ' adult_cost_price_sum ">
                                <td><input disabled value="' . $hotel_adult_cost_price . '"  type="number"  id="hotel_adult_cost_price' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_adult_cost_price][]" class="form-control hotel_cost_price' . $append_count . ' "></td>


        </tr>
        </div>
    </tbody>
    </table>
        ';
                    }
                }
                if ($get_q_d->type == "lum_sum" && $service_type == "no_of_person") {
                    // dd('sdsd');
                    foreach ($hotel_all_entries_decode as $key => $hotel_leg_d) {
                        $hotel_qty = $hotel_person_decode[$key]->hotel_qty;
                        $hotel_nights = $hotel_person_decode[$key]->hotel_nights;
                        if ($hotel_nights != "null" || $hotel_nights != 0) {
                            $hotel_cost_price = 0;
                            $hotel_selling_price = 0;
                        } else {
                            $hotel_cost_price = round(($hotel_person_decode[$key]->hotel_cost_price / 3) * $hotel_qty);
                            $hotel_selling_price = round(($hotel_person_decode[$key]->hotel_selling_price / 3) * $hotel_qty);
                        }


                        $hotel_adult_cost_price = $hotel_person_decode[$key]->hotel_adult_cost_price;
                        $hotel_children_cost_price = $hotel_person_decode[$key]->hotel_children_cost_price;
                        $hotel_infant_cost_price = $hotel_person_decode[$key]->hotel_infant_cost_price;
                        $adult_cost_price = round((($adult_cost_price + $hotel_adult_cost_price)));
                        $children_cost_price = round(($children_cost_price + $hotel_children_cost_price));
                        $infant_cost_price = round(($infant_cost_price + $hotel_infant_cost_price));



                        $adult_selling_price = ($adult_selling_price + $hotel_selling_price) * $no_of_adult;
                        $children_selling_price = ($children_selling_price + $hotel_selling_price) * $no_of_children;
                        $infant_selling_price = ($infant_selling_price + $hotel_selling_price) * $no_of_infant;
                        // dd($hotel_nights);
                        $all_types_rate = room_type::where('status', "Active")->where('id_room_types', $hotel_leg_d->room_type)->first();
                        $room_type_options .= "<option selected value='" . $all_types_rate->id_room_types . "'>" . $all_types_rate->name . "</option>";
                        $all_hotels = hotels::where('hotel_status', 1)->where('id_hotels', $hotel_leg_d->hotel_name)->join('hotel_details', 'hotel_details.id_hotel_details', 'hotels.id_hotels')->first();
                        $explode = explode("-", $all_hotels->country);
                        $hotel_options .= "<option selected value='" . $hotel_leg_d->hotel_name . "'>" . $all_hotels->hotel_name . " | <span>" . $explode[1] . "</span></option>";
                        $hotel_legs .= '
        <table class="table table-striped table-inverse table-responsive mt-2">
        <thead class="thead-inverse">
            <tr>
            <th>Check In</th>
            <th>Nights</th>
            <th>Check Out</th>
            <th>Hotels</th>
            <th>Room Type</th>
            <th>Qty</th>
            <th>Addon</th>
            </tr>
        </thead>
        <tbody>
            <div id="append_hotel">
            <tr>
            <td><input disabled value="' . $hotel_leg_d->hotel_check_in . '"   type="text" placeholder="mm/dd/yyyy" readonly id="hotel_check_in' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"    name="hotel[' . $append_count . '][legs_count][hotel_check_in][]" class="form-control fc-datepicker' . $append_count . '"></td>
            <td><input disabled value="' . $hotel_nights . '"  type="number" placeholder="2 Nights"  id="hotel_nights' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_nights][]" class="form-control"></td>
            <td><input disabled value="' . $hotel_leg_d->hotel_check_out . '"  type="text" placeholder="mm/dd/yyyy" readonly id="hotel_check_out' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_check_out][]" class="form-control fc-datepicker' . $append_count . '"></td>
            <td><select disabled id="hotels' . $append_count . '" name="hotel[' . $append_count . '][legs_count][hotel_name][]" onchange="modal_inventory_hotel(' . $append_count . ',this)" class="form-control select2' . $append_count . '" >
            ' . $hotel_options . '
                                    </select></td>
                                    <input  type="hidden" class="hotel_inv_id"  name="hotel[' . $append_count . '][legs_count][hotel_inv_id][]" id="hotel_inv_id' . $append_count . '">
                                    <td><select disabled class="form-control select2' . $append_count . '" onchange="room_type_on_change(' . $append_count . ')" name="hotel[' . $append_count . '][legs_count][room_type][]" id="hotel_room_type' . $append_count . '">
                                    ' . $room_type_options . '
                                                            </select></td>
                                    <input type="hidden" class="get_sub_total_legs' . $append_count . '" id="get_sub_total_legs' . $append_count . '"/>
                                    <td><input disabled value="' . $hotel_person_decode[$key]->hotel_qty . '"  type="number" id="hotel_qty' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][legs_count][hotel_qty][]" class="form-control"></td>
                                    <td> <select disabled multiple="multiple" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][legs_count][hotel_addon][]"  class=" addon-select form-control hotel_addon js-example-basic-multiple' . $append_count . ' hotel_addon' . $append_count . ' " id="hotel_addon' . $append_count . '">' . $addon_options . '</select></td>

            </tr>
            </div>
        </tbody>
    </table>
    <table class="table table-striped table-inverse table-responsive mt-2">
    <thead class="thead-inverse">
        <tr>
        <th>Adult Cost Price</th>
        </tr>
    </thead>
    <tbody>
        <div id="append_hotel">
        <tr>
        <input  type="hidden"  id="hotel_adult_total_cost_price' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_cost_price][]" class="form-control hotel_cost_price' . $append_count . '  hotel_adult_total_cost_price' . $append_count . ' adult_cost_price_sum ">
                                <td><input disabled value="' . $hotel_adult_cost_price . '"  type="number"  id="hotel_adult_cost_price' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')"   name="hotel[' . $append_count . '][legs_count][hotel_adult_cost_price][]" class="form-control hotel_cost_price' . $append_count . ' "></td>


        </tr>
        </div>
    </tbody>
    </table>
        ';
                    }
                }

                if ($service_type == "no_of_person") {
                    $data .= '<div id="hotel_table' . $append_count . '" class="row"><h4 class="mt-2">Add Hotel Details</h4><div class="col-md-12" style="border:2px solid lightgrey;" >

               ' . $hotel_legs . '
                <div id="append_hotel_legs' . $append_count . '"></div>
                    <table class="table table-striped table-inverse table-responsive">
                    <thead class="thead-inverse">
                        <tr>
                        <th>Total Cost Price</th>
                        <th>Discount</th>
                        <th>Total</th>
                        <th id="hotel_exchange_head' . $append_count . '">Exchange</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div id="append_hotel">
                            <tr>
                                <input  type="hidden"  id="hotel_service_id' . $append_count . '" name="hotel[' . $append_count . '][hotel_service_id][]">
                                <input  type="hidden" id="hotel_sub_service_id' . $append_count . '" name="hotel[' . $append_count . '][hotel_sub_service_id][]">
                                <input  type="hidden" id="hotel_currency_total' . $append_count . '" name="hotel[' . $append_count . '][hotel_currency_total][]">
                                <input type="hidden" id="hotel_currency_name' . $append_count . '" name="hotel[' . $append_count . '][hotel_currency_name][]">
                                <td><input disabled value="' . $hotel_sub_total_details_decode[0]->hotel_total_cost_price . '"  type="number" id="hotel_total_cost_price' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][hotel_total_cost_price][]" class="form-control"></td>
                                <td><input disabled value="' . $hotel_sub_total_details_decode[0]->hotel_discount . '"  type="number" id="hotel_discount' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][hotel_discount][]" class="form-control"></td>
                                <td><input disabled  value="' . $hotel_sub_total_details_decode[0]->hotel_total_cost_price . '" type="number" id="hotel_total' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][hotel_total][]" class="form-control"></td>
                                <td><select disabled name="hotel[' . $append_count . '][hotel_currency][]"   onchange="onchange_get_curr_data(' . $append_count . ')" id="hotel_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>


                            </tr>
                        </div>
                    </tbody>
                    </table>
                </div></div>
                ';
                } elseif ($service_type == "service_level") {
                    // dd($hotel_sub_total_details_decode);
                    $data .= '<div id="hotel_table' . $append_count . '" class="row"><h4 class="mt-2">Add Hotel Details</h4><div class="col-md-12" style="border:2px solid lightgrey;" >
' . $hotel_legs . '
    <div id="append_hotel_legs' . $append_count . '"></div>
        <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
            <th>Total Cost Price</th>
            <th>Total Selling Price</th>
            <th>Discount</th>
            <th>Total</th>
            <th id="hotel_exchange_head' . $append_count . '">Exchange</th>
            <th>Add</th>
            <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            <div id="append_hotel">
                <tr>
                    <input type="hidden" id="hotel_service_id' . $append_count . '" name="hotel[' . $append_count . '][hotel_service_id][]">
                    <input type="hidden" id="hotel_sub_service_id' . $append_count . '" name="hotel[' . $append_count . '][hotel_sub_service_id][]">
                    <input type="hidden" id="hotel_currency_total' . $append_count . '" name="hotel[' . $append_count . '][hotel_currency_total][]">
                    <input type="hidden" id="hotel_currency_name' . $append_count . '" name="hotel[' . $append_count . '][hotel_currency_name][]">
                    <td><input disabled value="' . $hotel_sub_total_details_decode[0]->hotel_total_cost_price . '"  type="number" id="hotel_total_cost_price' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][hotel_total_cost_price][]" class="form-control"></td>
                    <td><input disabled value="' . $hotel_total_selling_price . '"   type="number" id="hotel_sub_total' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][hotel_total_selling_price][]" class="form-control"></td>
                    <td><input disabled value="' . $hotel_sub_total_details_decode[0]->hotel_discount . '"  type="number" id="hotel_discount' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][hotel_discount][]" class="form-control"></td>
                    <td><input disabled value="' . $hotel_sub_total_details_decode[0]->hotel_total . '"  type="number" id="hotel_total' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][hotel_total][]" class="form-control"></td>
                    <td><select disabled name="hotel[' . $append_count . '][hotel_currency][]"   onchange="onchange_get_curr_data(' . $append_count . ')" id="hotel_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
                    <td><button class="btn btn-success text-white" type="button" style="margin:0;" onclick="add_hotel_legs(' . $append_count . ',' . $sub_services . ')"><i class="fa fa-plus"></i></button></td>
                    <td><button class="btn btn-danger" type="button" style="margin:0;"  onClick="remove_hotel(' . $append_count . ')"><i class="fa fa-trash"></i></button></td>
                </tr>
            </div>
        </tbody>
        </table>
    </div></div>
    ';
                } else {
                    $data .= '<div id="hotel_table' . $append_count . '" class="row"><h4 class="mt-2">Add Hotel Details</h4><div class="col-md-12" style="border:2px solid lightgrey;" >

                    ' . $hotel_legs . '
                     <div id="append_hotel_legs' . $append_count . '"></div>
                         <table class="table table-striped table-inverse table-responsive">
                         <thead class="thead-inverse">
                             <tr>
                             <th>Total Cost Price</th>
                             <th>Discount</th>
                             <th>Total</th>
                             <th id="hotel_exchange_head' . $append_count . '">Exchange</th>
                             </tr>
                         </thead>
                         <tbody>
                             <div id="append_hotel">
                                 <tr>
                                     <input  type="hidden"  id="hotel_service_id' . $append_count . '" name="hotel[' . $append_count . '][hotel_service_id][]">
                                     <input  type="hidden" id="hotel_sub_service_id' . $append_count . '" name="hotel[' . $append_count . '][hotel_sub_service_id][]">
                                     <input  type="hidden" id="hotel_currency_total' . $append_count . '" name="hotel[' . $append_count . '][hotel_currency_total][]">
                                     <input type="hidden" id="hotel_currency_name' . $append_count . '" name="hotel[' . $append_count . '][hotel_currency_name][]">
                                     <td><input disabled value="' . $hotel_sub_total_details_decode[0]->hotel_total_cost_price . '"  type="number" id="hotel_total_cost_price' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][hotel_total_cost_price][]" class="form-control"></td>
                                     <td><input disabled value="' . $hotel_sub_total_details_decode[0]->hotel_discount . '"  type="number" id="hotel_discount' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][hotel_discount][]" class="form-control"></td>
                                     <td><input  disabled value="' . $hotel_sub_total_details_decode[0]->hotel_total_cost_price . '" type="number" id="hotel_total' . $append_count . '" onchange="hotel_calculate(' . $append_count . ')" name="hotel[' . $append_count . '][hotel_total][]" class="form-control"></td>
                                     <td><select disabled name="hotel[' . $append_count . '][hotel_currency][]"   onchange="onchange_get_curr_data(' . $append_count . ')" id="hotel_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
                                 </tr>
                             </div>
                         </tbody>
                         </table>
                     </div></div>
                     ';
                }
            } elseif ($sub_service_name == "Visa") {
                // dd($get_inq);
                $sub_name = "Visa";
                $all_hotels = hotels::where('hotel_status', 1)->get();
                $all_types_rate = room_type::where('status', "Active")->get();
                $currency_rates = currency_exchange_rate::all();
                $addon = addon::where('status', 1)->get();
                $visa_rates = Visa_rates::where('id_visa_rates', $visa_all_entries_decode[0]->visa_service)->first();
                // dd($addon);
                $hotel_options = "";
                $visa_rates_options = "<option value=''>Select</option>";
                $room_type_options = "";
                $currency_rate_options = "";
                $addon_options = "";

                $visa_rates_options .= "<option selected value='" . $visa_all_entries_decode[0]->visa_service . "'>" . $visa_rates->name . "</option>";

                foreach ($all_hotels as $key => $value) {
                    $hotel_options .= "<option value='" . $value->id_hotels . "'>" . $value->hotel_name . "</option>";
                }
                foreach ($all_types_rate as $key => $value) {
                    $room_type_options .= "<option selected value='" . $value->id_room_types . "'>" . $value->name . "</option>";
                }
                foreach ($currency_rates as $key => $value) {
                    $currency_rate_options .= "<option data='" . $value->currency_name . "' value='" . $value->currency_rate . "'>" . $value->currency_name . "</option>";
                }
                foreach ($addon as $key => $value) {
                    $addon_options .= "<option value='" . $value->id_addons . "'>" . $value->addon_name . "</option>";
                }
                // dd($addon_options);
                if ($service_type == "no_of_person") {
                    $data .= '<div class="row" id="visa_table' . $append_count . '"><h4 class="mt-2">Add Visa Details</h4><div class="col-md-12" style="border:2px solid lightgrey;" >
                    <table class="table table-striped mt-2 table-inverse table-responsive">
                    <thead class="thead-inverse mt-2">
                        <tr>
                            <th>Service</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div id="append_hotel">
                            <tr>
                            <td><select disabled style="width:100%;" onchange="get_visa_rates(' . $append_count . ')" name="visa[' . $append_count . '][visa_service][]" id="visa_service' . $append_count . '" class="form-control select2' . $append_count . '">
                            ' . $visa_rates_options . '
                                                        </select></td>
                                <input type="hidden" id="visa_service_id' . $append_count . '" name="visa[' . $append_count . '][visa_service_id][]">
                                <input type="hidden" id="visa_sub_service_id' . $append_count . '" name="visa[' . $append_count . '][visa_sub_service_id][]">
                                <input type="hidden" id="visa_currency_total' . $append_count . '" name="visa[' . $append_count . '][visa_currency_total][]">
                                <input type="hidden" id="visa_currency_name' . $append_count . '" name="visa[' . $append_count . '][visa_currency_name][]">
                                </tr>
                        </div>
                    </tbody>
                </table>
            <table class="table table-striped mt-2 table-inverse table-responsive">
            <thead class="thead-inverse mt-2">
                <tr>

                <th>Adult Cost Price</th>
                <th>Children Cost Price</th>
                <th>Infant Cost Price</th>
                </tr>
            </thead>
            <tbody>
                <div id="append_hotel">
                <tr>
                <input  type="hidden"   id="visa_adult_total_cost_price' . $append_count . '" name="visa[' . $append_count . '][visa_adult_total_cost_price][]" class="adult_cost_price_sum">
                <input type="hidden"   id="visa_children_total_cost_price' . $append_count . '" name="visa[' . $append_count . '][visa_children_total_cost_price][]" class="children_cost_price_sum">
                <input type="hidden"   id="visa_infant_total_cost_price' . $append_count . '" name="visa[' . $append_count . '][visa_infant_total_cost_price][]" class="infant_cost_price_sum">
                <td><input disabled value="' . $visa_adult_cost_price . '"  type="number" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_adult_cost_price][]" id="visa_adult_cost_price' . $append_count . '" class="form-control"></td>
                <td><input disabled value="' . $visa_children_cost_price . '"  type="number" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_children_cost_price][]" id="visa_children_cost_price' . $append_count . '" class="form-control"></td>
                <td><input disabled value="' . $visa_infant_cost_price . '"  type="number" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_infant_cost_price][]" id="visa_infant_cost_price' . $append_count . '" class="form-control"></td>
                    </tr>
                </div>
            </tbody>
        </table>
        <table class="table table-striped mt-2 table-inverse table-responsive">
        <thead class="thead-inverse mt-2">
            <tr>
                <th>Total Cost Price</th>
                <th>Discount</th>
                <th>Total</th>
                <th id="visa_exchange_head' . $append_count . '">Exchange</th>

            </tr>
        </thead>
        <tbody>
            <div id="append_hotel">
                <tr>
                    <td><input disabled value="' . $visa_sub_total_details_decode[0]->visa_total_cost_price . '"  type="number" id="visa_sub_total' . $append_count . '" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_total_cost_price][]" class="form-control"></td>
                    <td><input disabled value="' . $visa_sub_total_details_decode[0]->visa_discount . '" type="number" id="visa_discount' . $append_count . '" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_discount][]" class="form-control"></td>
                    <td><input disabled value="' . $visa_sub_total_details_decode[0]->visa_total_cost_price . '" type="number" id="visa_total' . $append_count . '" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_total][]" class="form-control"></td>
                    <td><select disabled name="visa[' . $append_count . '][visa_currency][]"   onchange="onchange_get_curr_data_visa(' . $append_count . ')" id="visa_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
                    </tr>
            </div>
        </tbody>
        </table>
                </div></div>
            ';
                } elseif ($service_type == "service_level") {
                    // dd('service_level');
                    $data .= '<div class="row" id="visa_table' . $append_count . '"><h4 class="mt-2">Add Visa Details</h4><div class="col-md-12" style="border:2px solid lightgrey;" >
                    <table class="table table-striped mt-2 table-inverse table-responsive">
                    <thead class="thead-inverse mt-2">
                        <tr>
                            <th>Service</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div id="append_hotel">
                            <tr>
                                <td><select style="width:100%;" onchange="get_visa_rates(' . $append_count . ')" name="visa[' . $append_count . '][visa_service][]" id="visa_service' . $append_count . '" class="form-control select2' . $append_count . '">
    ' . $visa_rates_options . '
                                </select></td>

                                <input type="hidden" id="visa_service_id' . $append_count . '" name="visa[' . $append_count . '][visa_service_id][]">
                                <input type="hidden" id="visa_sub_service_id' . $append_count . '" name="visa[' . $append_count . '][visa_sub_service_id][]">
                                <input type="hidden" id="visa_currency_total' . $append_count . '" name="visa[' . $append_count . '][visa_currency_total][]">
                                <input type="hidden" id="visa_currency_name' . $append_count . '" name="visa[' . $append_count . '][visa_currency_name][]">
                                </tr>
                        </div>
                    </tbody>
                </table>
                <table class="table table-striped mt-2 table-inverse table-responsive">
                    <thead class="thead-inverse mt-2">
                        <tr>
                            <th>Adult Cost Price</th>
                            <th>Adult Selling Price</th>

                        </tr>
                    </thead>
                    <tbody>
                        <div id="append_hotel">
                            <tr>
                                <td><input disabled value="' . $visa_adult_cost_price . '" type="number" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_adult_cost_price][]" id="adult_visa_cost_price' . $append_count . '" class="form-control"></td>
                                <td><input disabled value="' . $visa_adult_selling_price . '" type="number" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_adult_selling_price][]" id="adult_visa_selling_price' . $append_count . '" class="form-control"></td>
                               <tr>
                        </div>
                    </tbody>
                </table>
                <table class="table table-striped mt-2 table-inverse table-responsive">
                <thead class="thead-inverse mt-2">
                    <tr>
                        <th>Children Cost Price</th>
                        <th>Children Selling Price</th>

                    </tr>
                </thead>
                <tbody>
                    <div id="append_hotel">
                        <tr>
                            <td><input disabled value="' . $visa_children_cost_price . '"  type="number" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_children_cost_price][]" id="children_visa_cost_price' . $append_count . '" class="form-control"></td>
                            <td><input disabled value="' . $visa_children_selling_price . '" type="number" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_children_selling_price][]" id="children_visa_selling_price' . $append_count . '" class="form-control"></td>
                            <tr>
                    </div>
                </tbody>
            </table>
            <table class="table table-striped mt-2 table-inverse table-responsive">
            <thead class="thead-inverse mt-2">
                <tr>
                    <th>Infant Cost Price</th>
                    <th>Infant Selling Price</th>
                </tr>
            </thead>
            <tbody>
                <div id="append_hotel">
                    <tr>
                        <td><input disabled value="' . $visa_infant_cost_price . '" type="number" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_infant_cost_price][]" id="infant_visa_cost_price' . $append_count . '" class="form-control"></td>
                        <td><input disabled value="' . $visa_infant_selling_price . '" type="number" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_infant_selling_price][]" id="infant_visa_selling_price' . $append_count . '" class="form-control"></td>
                        <tr>
                </div>
            </tbody>
        </table>

        <table class="table table-striped mt-2 table-inverse table-responsive">
        <thead class="thead-inverse mt-2">
            <tr>
                <th>Total Cost Price</th>
                <th>Total Selling Price</th>
                <th>Discount</th>
                <th>Total</th>
                <th id="visa_exchange_head' . $append_count . '">Exchange</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            <div id="append_hotel">
                <tr>
                    <td><input disabled value="' . $visa_sub_total_details_decode[0]->visa_total_cost_price . '" type="number" id="total_cost_price' . $append_count . '" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_total_cost_price][]" class="form-control"></td>
                    <td><input disabled value="' . $visa_total_selling_price . '"  type="number" id="visa_sub_total' . $append_count . '" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_total_selling_price][]" class="form-control"></td>
                    <td><input disabled value="' . $visa_sub_total_details_decode[0]->visa_discount . '"  type="number" id="visa_discount' . $append_count . '" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_discount][]" class="form-control"></td>
                    <td><input disabled value="' . $visa_sub_total_details_decode[0]->visa_total . '" type="number" id="visa_total' . $append_count . '" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_total][]" class="form-control"></td>
                    <td><select disabled name="visa[' . $append_count . '][visa_currency][]" onchange="onchange_get_curr_data_visa(' . $append_count . ')" id="visa_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
                    <td><button class="btn btn-danger" type="button" style="margin:0;" onClick="remove_visa(' . $append_count . ')">Remove</button></td>
                    </tr>
            </div>
        </tbody>
        </table>
                </div></div>
            ';
                } else {
                    $data .= '<div class="row" id="visa_table' . $append_count . '"><h4 class="mt-2">Add Visa Details</h4><div class="col-md-12" style="border:2px solid lightgrey;" >
                    <table class="table table-striped mt-2 table-inverse table-responsive">
                    <thead class="thead-inverse mt-2">
                        <tr>
                            <th>Service</th>

                        </tr>
                    </thead>
                    <tbody>
                        <div id="append_hotel">
                            <tr>
                            <td><select disabled style="width:100%;" onchange="get_visa_rates(' . $append_count . ')" name="visa[' . $append_count . '][visa_service][]" id="visa_service' . $append_count . '" class="form-control select2' . $append_count . '">
                            ' . $visa_rates_options . '
                                                        </select></td>
                                <input type="hidden" id="visa_service_id' . $append_count . '" name="visa[' . $append_count . '][visa_service_id][]">
                                <input type="hidden" id="visa_sub_service_id' . $append_count . '" name="visa[' . $append_count . '][visa_sub_service_id][]">
                                <input type="hidden" id="visa_currency_total' . $append_count . '" name="visa[' . $append_count . '][visa_currency_total][]">
                                <input type="hidden" id="visa_currency_name' . $append_count . '" name="visa[' . $append_count . '][visa_currency_name][]">
                                </tr>
                        </div>
                    </tbody>
                </table>
            <table class="table table-striped mt-2 table-inverse table-responsive">
            <thead class="thead-inverse mt-2">
                <tr>
                <th>Adult Cost Price</th>
                <th>Children Cost Price</th>
                <th>Infant Cost Price</th>
                </tr>
            </thead>
            <tbody>
                <div id="append_hotel">
                <tr>
                <input  type="hidden"    id="visa_adult_total_cost_price' . $append_count . '" name="visa[' . $append_count . '][visa_adult_total_cost_price][]" class="adult_cost_price_sum">
                <input type="hidden"     id="visa_children_total_cost_price' . $append_count . '" name="visa[' . $append_count . '][visa_children_total_cost_price][]" class="children_cost_price_sum">
                <input  type="hidden" id="visa_infant_total_cost_price' . $append_count . '" name="visa[' . $append_count . '][visa_infant_total_cost_price][]" class="infant_cost_price_sum">
                <td><input disabled value="' . $visa_adult_cost_price . '"  type="number" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_adult_cost_price][]" id="visa_adult_cost_price' . $append_count . '" class="form-control"></td>
                <td><input disabled value="' . $visa_children_cost_price . '"  type="number" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_children_cost_price][]" id="visa_children_cost_price' . $append_count . '" class="form-control"></td>
                <td><input disabled value="' . $visa_infant_cost_price . '"  type="number" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_infant_cost_price][]" id="visa_infant_cost_price' . $append_count . '" class="form-control"></td>
                    </tr>
                </div>
            </tbody>
        </table>
        <table class="table table-striped mt-2 table-inverse table-responsive">
        <thead class="thead-inverse mt-2">
            <tr>
                <th>Total Cost Price</th>
                <th>Discount</th>
                <th>Total</th>
                <th id="visa_exchange_head' . $append_count . '">Exchange</th>
            </tr>
        </thead>
        <tbody>
            <div id="append_hotel">
                <tr>
                    <td><input disabled value="' . $visa_sub_total_details_decode[0]->visa_total_cost_price . '"  type="number" id="visa_sub_total' . $append_count . '" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_total_cost_price][]" class="form-control"></td>
                    <td><input disabled value="' . $visa_sub_total_details_decode[0]->visa_discount . '" type="number" id="visa_discount' . $append_count . '" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_discount][]" class="form-control"></td>
                    <td><input disabled value="' . $visa_sub_total_details_decode[0]->visa_total . '" type="number" id="visa_total' . $append_count . '" onchange="visa_calculate(' . $append_count . ')" name="visa[' . $append_count . '][visa_total][]" class="form-control"></td>
                    <td><select disabled name="visa[' . $append_count . '][visa_currency][]"   onchange="onchange_get_curr_data_visa(' . $append_count . ')" id="visa_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
                    </tr>
            </div>
        </tbody>
        </table>
                </div></div>
            ';
                }
            } elseif ($sub_service_name == "Air Ticket") {

                $sub_name = "Air Ticket";
                $all_types_rate = room_type::where('status', "Active")->get();
                $currency_rates = currency_exchange_rate::all();
                $addon = addon::where('status', 1)->get();
                // dd($addon);
                $airline_options = "<option value=''>Select</option>";
                $room_type_options = "";
                $currency_rate_options = "";
                $addon_options = "<option value=''>Select</option>";

                foreach ($all_types_rate as $key => $value) {
                    $room_type_options .= "<option value='" . $value->id_room_types . "'>" . $value->name . "</option>";
                }
                foreach ($currency_rates as $key => $value) {
                    $currency_rate_options .= "<option data='" . $value->currency_name . "' value='" . $value->currency_rate . "'>" . $value->currency_name . "</option>";
                }
                foreach ($addon as $key => $value) {
                    $addon_options .= "<option value='" . $value->id_addons . "'>" . $value->addon_name . "</option>";
                }
                // dd($addon_options);
                $airline_legs = "";
                if ($get_q_d->type == "no_of_person") {
                    // dd('sds');
                    foreach ($air_ticket_all_entries_decode as $legs_entries) {
                        $airlines = airlines::where('id_airlines', $legs_entries->airline_name)->first();
                        // dd($legs_entries[1]);
                        $airline_options .= "<option selected value='" . $legs_entries?->airline_name . "'>" . $airlines?->Airline . "</option>";
                        $airline_legs .= '
            <table class="table table-striped mt-2 table-inverse table-responsive" >
            <thead class="thead-inverse mt-2">
              <tr>
              <th>Airline Name</th>
              <th>Flight Number</th>
              <th>Flight Date</th>
              <th>Arrival Destination</th>
              <th>Departure Destination</th>
              <th>Arrival Time</th>
              <th>Departure Time</th>
              <th>Ticket Type</th>
              </tr>
            </thead>
            <tbody>
              <div id="append_airline_destination_tr' . $append_count . '">
                  <tr>
                  <input type="hidden" value="' . $legs_entries->airline_inv_id . '" class="airline_inv_id"  name="air_ticket[' . $append_count . '][legs_count][airline_inv_id][]" id="airline_inv_id' . $append_count . '">
                  <td> <select disabled style="width:150px" onchange="modal_inventory_airline(' . $append_count . ',this)" class="form-control select2' . $append_count . '" name="air_ticket[' . $append_count . '][legs_count][airline_name][]"  id="airline_name' . $append_count . '">' . $airline_options . '</select></td>
                  <td><input disabled value="' . $legs_entries->flight_number . '" style="width:100px" type="text" id="flight_number' . $append_count . '" onchange="airline_calculate()" name="air_ticket[' . $append_count . '][legs_count][flight_number][]" class="form-control"></td>
                  <td><input disabled value="' . $legs_entries->airline_arrival_date . '" style="width:100px" type="text" readonly  placeholder="MM/DD/YYYY" id="airline_arrival_date' . $append_count . '" onchange="airline_calculate()" name="air_ticket[' . $append_count . '][legs_count][airline_arrival_date][]" class="form-control fc-datepicker' . $append_count . ' "></td>
                  <td><select disabled class="form-control livesearch_for_airline_destination' . $append_count . ' w-100" name="air_ticket[' . $append_count . '][legs_count][airline_arrival_destination][]" id="airline_arrival_destination' . $append_count . '">
                  <option selected value="' . $legs_entries->airline_arrival_destination . '">' . $legs_entries->airline_arrival_destination . '</option>
                  </select></td>
                  <td><select disabled class="form-control livesearch_for_airline_destination' . $append_count . '" name="air_ticket[' . $append_count . '][legs_count][airline_departure_destination][]" id="airline_departure_destination' . $append_count . '">
                  <option selected value="' . $legs_entries->airline_departure_destination . '">' . $legs_entries->airline_departure_destination . '</option>
                  </select></td>
                  <td><input disabled style="width:100px" value="' . $legs_entries->arrival_time . '"  type="text" id="arival_time' . $append_count . '" onchange="airline_calculate()" name="air_ticket[' . $append_count . '][legs_count][arrival_time][]" class="form-control time_picker"></td>
                  <td><input disabled style="width:100px" value="' . $legs_entries->departure_time . '"  type="text" id="departure_time' . $append_count . '" onchange="airline_calculate()" name="air_ticket[' . $append_count . '][legs_count][departure_time][]" class="form-control time_picker "></td>
                  <input type="hidden" class="airline_sum_legs" id="airline_sum_legs' . $append_count . '" name="airline_sum_legs">
                  <td><select disabled class="form-control select2"  onchange="onchange_ticket_type_airline(' . $append_count . ')" name="air_ticket[' . $append_count . '][legs_count][airline_flight_class][]" id="airline_flight_class' . $append_count . '"><option value="' . $legs_entries->airline_flight_class . '">' . $legs_entries->airline_flight_class . '</option></select></td>
                  </tr>
              </div>
               </tbody>
               </table>';
                    }
                }

                if ($get_q_d->type == "service_level") {
                    foreach ($air_ticket_all_entries_decode as $legs_entries) {
                        $airlines = airlines::where('id_airlines', $legs_entries->airline_name)->first();
                        // dd($legs_entries[1]);
                        $airline_options .= "<option selected value='" . $legs_entries?->airline_name . "'>" . $airlines?->Airline . "</option>";
                        $airline_legs .= '
            <table class="table table-striped mt-2 table-inverse table-responsive" >
            <thead class="thead-inverse mt-2">
              <tr>
              <th>Airline Name</th>
              <th>Flight Number</th>
              <th>Flight Date</th>
              <th>Arrival Destination</th>
              <th>Departure Destination</th>
              <th>Arrival Time</th>
              <th>Departure Time</th>
              <th>Ticket Type</th>
              </tr>
            </thead>
            <tbody>
              <div id="append_airline_destination_tr' . $append_count . '">
                  <tr>
                  <input type="hidden" value="' . $legs_entries->airline_inv_id . '" class="airline_inv_id"  name="air_ticket[' . $append_count . '][legs_count][airline_inv_id][]" id="airline_inv_id' . $append_count . '">
                  <td> <select disabled style="width:150px" onchange="modal_inventory_airline(' . $append_count . ',this)" class="form-control select2' . $append_count . '" name="air_ticket[' . $append_count . '][legs_count][airline_name][]"  id="airline_name' . $append_count . '">' . $airline_options . '</select></td>
                  <td><input disabled value="' . $legs_entries->flight_number . '" style="width:100px" type="text" id="flight_number' . $append_count . '" onchange="airline_calculate()" name="air_ticket[' . $append_count . '][legs_count][flight_number][]" class="form-control"></td>
                  <td><input disabled value="' . $legs_entries->airline_arrival_date . '" style="width:100px" type="text" readonly  placeholder="MM/DD/YYYY" id="airline_arrival_date' . $append_count . '" onchange="airline_calculate()" name="air_ticket[' . $append_count . '][legs_count][airline_arrival_date][]" class="form-control fc-datepicker' . $append_count . ' "></td>
                  <td><select disabled class="form-control livesearch_for_airline_destination' . $append_count . ' w-100" name="air_ticket[' . $append_count . '][legs_count][airline_arrival_destination][]" id="airline_arrival_destination' . $append_count . '">
                  <option selected value="' . $legs_entries->airline_arrival_destination . '">' . $legs_entries->airline_arrival_destination . '</option>
                  </select></td>
                  <td><select disabled class="form-control livesearch_for_airline_destination' . $append_count . '" name="air_ticket[' . $append_count . '][legs_count][airline_departure_destination][]" id="airline_departure_destination' . $append_count . '">
                  <option selected value="' . $legs_entries->airline_departure_destination . '">' . $legs_entries->airline_departure_destination . '</option>
                  </select></td>
                  <td><input disabled style="width:100px" value="' . $legs_entries->arrival_time . '"  type="text" id="arival_time' . $append_count . '" onchange="airline_calculate()" name="air_ticket[' . $append_count . '][legs_count][arrival_time][]" class="form-control time_picker"></td>
                  <td><input disabled style="width:100px" value="' . $legs_entries->departure_time . '"  type="text" id="departure_time' . $append_count . '" onchange="airline_calculate()" name="air_ticket[' . $append_count . '][legs_count][departure_time][]" class="form-control time_picker "></td>
                  <input type="hidden" class="airline_sum_legs" id="airline_sum_legs' . $append_count . '" name="airline_sum_legs">
                  <td><select disabled class="form-control select2"  onchange="onchange_ticket_type_airline(' . $append_count . ')" name="air_ticket[' . $append_count . '][legs_count][airline_flight_class][]" id="airline_flight_class' . $append_count . '"><option value="' . $legs_entries->airline_flight_class . '">' . $legs_entries->airline_flight_class . '</option></select></td>
                  </tr>
              </div>
               </tbody>
               </table>';
                    }
                }
                if ($get_q_d->type == "lum_sum") {
                    // dd('sds');
                    foreach ($air_ticket_all_entries_decode as $legs_entries) {
                        $airlines = airlines::where('id_airlines', $legs_entries->airline_name)->first();
                        // dd($legs_entries[1]);
                        $airline_options .= "<option selected value='" . $legs_entries?->airline_name . "'>" . $airlines?->Airline . "</option>";
                        $airline_legs .= '
            <table class="table table-striped mt-2 table-inverse table-responsive" >
            <thead class="thead-inverse mt-2">
              <tr>
              <th>Airline Name</th>
              <th>Flight Number</th>
              <th>Flight Date</th>
              <th>Arrival Destination</th>
              <th>Departure Destination</th>
              <th>Arrival Time</th>
              <th>Departure Time</th>
              <th>Ticket Type</th>
              </tr>
            </thead>
            <tbody>
              <div id="append_airline_destination_tr' . $append_count . '">
                  <tr>
                  <input type="hidden" value="' . $legs_entries->airline_inv_id . '" class="airline_inv_id"  name="air_ticket[' . $append_count . '][legs_count][airline_inv_id][]" id="airline_inv_id' . $append_count . '">
                  <td> <select disabled style="width:150px" onchange="modal_inventory_airline(' . $append_count . ',this)" class="form-control select2' . $append_count . '" name="air_ticket[' . $append_count . '][legs_count][airline_name][]"  id="airline_name' . $append_count . '">' . $airline_options . '</select></td>
                  <td><input disabled value="' . $legs_entries->flight_number . '" style="width:100px" type="text" id="flight_number' . $append_count . '" onchange="airline_calculate()" name="air_ticket[' . $append_count . '][legs_count][flight_number][]" class="form-control"></td>
                  <td><input disabled value="' . $legs_entries->airline_arrival_date . '" style="width:100px" type="text" readonly  placeholder="MM/DD/YYYY" id="airline_arrival_date' . $append_count . '" onchange="airline_calculate()" name="air_ticket[' . $append_count . '][legs_count][airline_arrival_date][]" class="form-control fc-datepicker' . $append_count . ' "></td>
                  <td><select disabled class="form-control livesearch_for_airline_destination' . $append_count . ' w-100" name="air_ticket[' . $append_count . '][legs_count][airline_arrival_destination][]" id="airline_arrival_destination' . $append_count . '">
                  <option selected value="' . $legs_entries->airline_arrival_destination . '">' . $legs_entries->airline_arrival_destination . '</option>
                  </select></td>
                  <td><select disabled class="form-control livesearch_for_airline_destination' . $append_count . '" name="air_ticket[' . $append_count . '][legs_count][airline_departure_destination][]" id="airline_departure_destination' . $append_count . '">
                  <option selected value="' . $legs_entries->airline_departure_destination . '">' . $legs_entries->airline_departure_destination . '</option>
                  </select></td>
                  <td><input disabled style="width:100px" value="' . $legs_entries->arrival_time . '"  type="text" id="arival_time' . $append_count . '" onchange="airline_calculate()" name="air_ticket[' . $append_count . '][legs_count][arrival_time][]" class="form-control time_picker"></td>
                  <td><input disabled style="width:100px" value="' . $legs_entries->departure_time . '"  type="text" id="departure_time' . $append_count . '" onchange="airline_calculate()" name="air_ticket[' . $append_count . '][legs_count][departure_time][]" class="form-control time_picker "></td>
                  <input type="hidden" class="airline_sum_legs" id="airline_sum_legs' . $append_count . '" name="airline_sum_legs">
                  <td><select disabled class="form-control select2"  onchange="onchange_ticket_type_airline(' . $append_count . ')" name="air_ticket[' . $append_count . '][legs_count][airline_flight_class][]" id="airline_flight_class' . $append_count . '"><option value="' . $legs_entries->airline_flight_class . '">' . $legs_entries->airline_flight_class . '</option></select></td>
                  </tr>
              </div>
               </tbody>
               </table>';
                    }
                }
                if ($get_q_d->type == "lum_sum" && $service_type == "no_of_person" || $get_q_d->type == "lum_sum" && $service_type == "service_level") {
                    $total_cost_air_ticket = $air_ticket_sub_total_details_decode[0]->airline_sub_total;
                } else {
                    $total_cost_air_ticket = $air_ticket_sub_total_details_decode[0]->airline_total_cost_price;
                }

                if ($service_type == "no_of_person") {
                    $data .= '<div class="row airline_table' . $append_count . '"  id="airline_table' . $append_count . '"><h4 class="mt-2">Add Air Ticket Details<div>
        <button type="button" onclick="modal_parsing_airline(' . $append_count . ')" class="btn btn-az-primary">Parsing<button/>
        <a type="button" href="#airline_name' . $append_count . '" class="btn btn-success text-white">From Inventory<a/>
        </h4><div class="col-md-12"  style="border:2px solid lightgrey;" >
       <div id="remove_for_parsing' . $append_count . '">
' . $airline_legs . '
        </div>
    <div id="add_more_airline_row' . $append_count . '"><div/>
    <div class="col-md-12" id="append_airline_destination' . $append_count . '" style="border-right:4px solid black" ></div>
        <table class="table table-striped mt-2 table-inverse table-responsive" >
        <thead class="thead-inverse mt-2">
            <tr>
                <th>Adult Cost Price</th>
                <th>Children Cost Price</th>
                <th>Infant Cost Price</th>
            </tr>
        </thead>
        <tbody>
            <div >
                <tr>
                <input type="hidden" id="airline_adult_total_cost_price' . $append_count . '" class="adult_cost_price_sum">
                <input type="hidden" id="airline_children_total_cost_price' . $append_count . '" class="children_cost_price_sum">
                <input type="hidden" id="airline_infant_total_cost_price' . $append_count . '" class="infant_cost_price_sum">
                <input type="hidden" id="airline_service_id" name="airline_service_id">
                <input type="hidden" id="airline_inventory_id' . $append_count . '" name="air_ticket[' . $append_count . '][legs_count][airline_inventory_id][]">
                <input type="hidden" id="airline_sub_service_id" name="airline_sub_service_id">
                <input type="hidden" id="airline_currency_total" name="air_ticket[' . $append_count . '][airline_currency_total][]">
                <input type="hidden" id="airline_currency_name" name="air_ticket[' . $append_count . '][airline_currency_name][]">
                <input type="hidden" class="airline_sum_legs" id="airline_sum_legs" name="airline_sum_legs">
                <td><input disabled type="number" value="' . $airline_adult_cost_price . '" id="airline_adult_cost_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_adult_cost_price][]" class="form-control"></td>
                <td><input disabled type="number" value="' . $airline_children_cost_price . '"  id="airline_children_cost_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_children_cost_price][]" class="form-control"></td>
                <td><input disabled type="number" value="' . $airline_infant_cost_price . '" id="airline_infant_cost_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_infant_cost_price][]" class="form-control"></td>
                </tr>
            </div>
        </tbody>
    </table>
    <table class="table table-striped mt-2 table-inverse table-responsive" >
    <thead class="thead-inverse mt-2">
        <tr>
            <th>Total Cost Price</th>
            <th>Discount</th>
            <th>Total</th>
            <th id="airline_exchange_head' . $append_count . '">Exchange</th>
        </tr>
    </thead>
    <tbody>
        <div id="append_airline">
            <tr>
                <td><input disabled value="' . $total_cost_air_ticket . '"  type="number" id="airline_total_cost_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_sub_total][]" class="form-control"></td>
                <td><input disabled value="' . $air_ticket_sub_total_details_decode[0]->airline_discount . '"  type="number" id="airline_discount' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_discount][]" class="form-control"></td>
                <td><input disabled value="' . $total_cost_air_ticket . '"  type="number" id="airline_total' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_total][]" class="form-control"></td>
                <td><select disabled name="air_ticket[' . $append_count . '][airline_currency][]"   onchange="onchange_get_curr_data_airline(' . $append_count . ')" id="airline_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
                </tr>
        </div>
    </tbody>
    </table>

    </div></div>
    ';
                } elseif ($service_type == "service_level") {
                    $data .= '<div class="row airline_table' . $append_count . '" id="airline_table' . $append_count . '"><h4 class="mt-2">Add Air Ticket Details<div>
        <button type="button" onclick="modal_parsing_airline(' . $append_count . ')" class="btn btn-az-primary">Parsing<button/>
        <a type="button" href="#airline_name' . $append_count . '" class="btn btn-success text-white">From Inventory<a/>
        </h4><div class="col-md-12"  style="border:2px solid lightgrey;" >
       <div id="remove_for_parsing' . $append_count . '">
' . $airline_legs . '
        </div>
    <div id="add_more_airline_row' . $append_count . '"><div/>
    <div class="col-md-12" id="append_airline_destination' . $append_count . '" style="border-right:4px solid black" ></div>
        <table class="table table-striped mt-2 table-inverse table-responsive" >
        <thead class="thead-inverse mt-2">
            <tr>
                <th>Adult Cost Price</th>
                <th>Adult Selling Price</th>
            </tr>
        </thead>
        <tbody>
            <div>
                <tr>
                <input type="hidden" id="airline_service_id" name="air_ticket[' . $append_count . '][legs_count][airline_departure_destination][]">
                <input type="hidden" id="airline_inventory_id' . $append_count . '" name="air_ticket[' . $append_count . '][legs_count][airline_inventory_id][]">
                <input type="hidden"  id="airline_sub_service_id" name="airline_sub_service_id">
                <input type="hidden" id="airline_currency_total' . $append_count . '" name="airline_currency_total[]">
                <input type="hidden" id="airline_currency_name' . $append_count . '" name="air_ticket[' . $append_count . '][currency_name][][]">
                <input type="hidden" class="airline_sum_legs" id="airline_sum_legs" name="airline_sum_legs">
                <td><input disabled type="number" value="' . $airline_adult_cost_price . '" id="adult_airline_cost_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_adult_cost_price][]" class="form-control"></td>
                <td><input disabled type="number" value="' . $airline_adult_selling_price . '" id="adult_airline_selling_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_adult_selling_price][]" class="form-control"></td>
                </tr>
            </div>
        </tbody>
    </table>
    <table class="table table-striped mt-2 table-inverse table-responsive" >
    <thead class="thead-inverse mt-2">
        <tr>
            <th>Children Cost Price</th>
            <th>Children Selling Price</th>
        </tr>
    </thead>
    <tbody>
        <div>
            <tr>
            <td><input disabled type="number" value="' . $airline_children_cost_price . '" id="children_airline_cost_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_children_cost_price][]" class="form-control"></td>
            <td><input disabled type="number" value="' . $airline_children_selling_price . '" id="children_airline_selling_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_children_selling_price][]" class="form-control"></td>
            </tr>
        </div>
    </tbody>
    </table>
    <table class="table table-striped mt-2 table-inverse table-responsive" >
    <thead class="thead-inverse mt-2">
        <tr>
            <th>Infant Cost Price</th>
            <th>Infant Selling Price</th>
        </tr>
    </thead>
    <tbody>
        <div>
            <tr>
            <td><input disabled type="number" value="' . $airline_infant_cost_price . '" id="infant_airline_cost_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_infant_cost_price][]" class="form-control"></td>
            <td><input disabled type="number" value="' . $airline_infant_selling_price . '"  id="infant_airline_selling_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_infant_selling_price][]" class="form-control"></td>
            </tr>
        </div>
    </tbody>
    </table>
    <table class="table table-striped mt-2 table-inverse table-responsive">
    <thead class="thead-inverse mt-2">
        <tr>
            <th>Total Cost Price</th>
            <th>Total Selling Price</th>
            <th>Discount</th>
            <th>Total</th>
            <th id="airline_exchange_head' . $append_count . '">Exchange</th>
            <th>Remove</th>
            <th class="add_more_clk">Add More </th>
        </tr>
    </thead>
    <tbody>
        <div id="append_airline">
            <tr>
                <td><input disabled value="' . $air_ticket_sub_total_details_decode[0]->airline_sub_total . '"  type="number" id="airline_total_cost_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_total_cost_price][]" class="form-control"></td>
                <td><input disabled value="' . $airline_total_selling_price . '"  type="number" id="airline_sub_total' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_total_selling_price][]" class="form-control"></td>
                <td><input disabled value="' . $air_ticket_sub_total_details_decode[0]->airline_discount . '"  type="number" id="airline_discount' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_discount][]" class="form-control"></td>
                <td><input disabled value="' . $air_ticket_sub_total_details_decode[0]->airline_total . '"  type="number" id="airline_total' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_total][]" class="form-control"></td>
                <td><select name="air_ticket[' . $append_count . '][airline_currency][]"   onchange="onchange_get_curr_data_airline(' . $append_count . ')" id="airline_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
                <td><button class="btn btn-danger" type="button" style="margin:0;" id="rmv_btn' . $append_count . '" onClick="remove_airline(' . $append_count . ')">Remove</button></td>
                <td><button class="btn btn-success add_more_clk " type="button" style="margin:0;" onclick="add_airline_destination_btn(' . $append_count . ')" ><i class="fa fa-plus text-white"></i></button></td>
                </tr>
        </div>
    </tbody>
    </table>

    </div></div>
    ';
                } else {
                    // dd($air_ticket_sub_total_details_decode);
                    if ($get_q_d->type == "service_level" && $service_type == "lum_sum") {
                        $data .= '<div class="row airline_table' . $append_count . '"  id="airline_table' . $append_count . '"><h4 class="mt-2">Add Air Ticket Details<div>
    <button type="button" onclick="modal_parsing_airline(' . $append_count . ')" class="btn btn-az-primary">Parsing<button/>
    <a type="button" href="#airline_name' . $append_count . '" class="btn btn-success text-white">From Inventory<a/>
    </h4><div class="col-md-12"  style="border:2px solid lightgrey;" >
   <div id="remove_for_parsing' . $append_count . '">
' . $airline_legs . '
    </div>
<div id="add_more_airline_row' . $append_count . '"><div/>
<div class="col-md-12" id="append_airline_destination' . $append_count . '" style="border-right:4px solid black" ></div>
    <table class="table table-striped mt-2 table-inverse table-responsive" >
    <thead class="thead-inverse mt-2">
        <tr>
            <th>Adult Cost Price</th>
            <th>Children Cost Price</th>
            <th>Infant Cost Price</th>
        </tr>
    </thead>
    <tbody>
        <div >
            <tr>
            <input type="hidden" id="airline_adult_total_cost_price' . $append_count . '" class="adult_cost_price_sum">
            <input type="hidden" id="airline_children_total_cost_price' . $append_count . '" class="children_cost_price_sum">
            <input type="hidden" id="airline_infant_total_cost_price' . $append_count . '" class="infant_cost_price_sum">
            <input type="hidden" id="airline_service_id" name="airline_service_id">
            <input type="hidden" id="airline_inventory_id' . $append_count . '" name="air_ticket[' . $append_count . '][legs_count][airline_inventory_id][]">
            <input type="hidden" id="airline_sub_service_id" name="airline_sub_service_id">
            <input type="hidden" id="airline_currency_total" name="air_ticket[' . $append_count . '][airline_currency_total][]">
            <input type="hidden" id="airline_currency_name" name="air_ticket[' . $append_count . '][airline_currency_name][]">
            <input type="hidden" class="airline_sum_legs" id="airline_sum_legs" name="airline_sum_legs">
            <td><input disabled type="number" value="' . $airline_adult_cost_price . '" id="airline_adult_cost_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_adult_cost_price][]" class="form-control"></td>
            <td><input disabled type="number" value="' . $airline_children_cost_price . '"  id="airline_children_cost_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_children_cost_price][]" class="form-control"></td>
            <td><input disabled type="number" value="' . $airline_infant_cost_price . '" id="airline_infant_cost_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_infant_cost_price][]" class="form-control"></td>
            </tr>
        </div>
    </tbody>
</table>
<table class="table table-striped mt-2 table-inverse table-responsive" >
<thead class="thead-inverse mt-2">
    <tr>
        <th>Total Cost Price</th>
        <th>Discount</th>
        <th>Total</th>
        <th id="airline_exchange_head' . $append_count . '">Exchange</th>
    </tr>
</thead>
<tbody>
    <div id="append_airline">
        <tr>
            <td><input disabled value="' . $air_ticket_sub_total_details_decode[0]->airline_total_cost_price . '"  type="number" id="airline_total_cost_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_sub_total][]" class="form-control"></td>
            <td><input disabled value="' . $air_ticket_sub_total_details_decode[0]->airline_discount . '"  type="number" id="airline_discount' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_discount][]" class="form-control"></td>
            <td><input disabled value="' . $air_ticket_sub_total_details_decode[0]->airline_total . '"  type="number" id="airline_total' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_total][]" class="form-control"></td>
            <td><select disabled name="air_ticket[' . $append_count . '][airline_currency][]"   onchange="onchange_get_curr_data_airline(' . $append_count . ')" id="airline_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
            </tr>
    </div>
</tbody>
</table>
</div></div>
';
                    }
                    if ($get_q_d->type == "no_of_person" && $service_type == "lum_sum") {
                        $data .= '<div class="row airline_table' . $append_count . '"  id="airline_table' . $append_count . '"><h4 class="mt-2">Add Air Ticket Details<div>
    <button type="button" onclick="modal_parsing_airline(' . $append_count . ')" class="btn btn-az-primary">Parsing<button/>
    <a type="button" href="#airline_name' . $append_count . '" class="btn btn-success text-white">From Inventory<a/>
    </h4><div class="col-md-12"  style="border:2px solid lightgrey;" >
   <div id="remove_for_parsing' . $append_count . '">
' . $airline_legs . '
    </div>
<div id="add_more_airline_row' . $append_count . '"><div/>
<div class="col-md-12" id="append_airline_destination' . $append_count . '" style="border-right:4px solid black" ></div>
    <table class="table table-striped mt-2 table-inverse table-responsive" >
    <thead class="thead-inverse mt-2">
        <tr>
            <th>Adult Cost Price</th>
            <th>Children Cost Price</th>
            <th>Infant Cost Price</th>
        </tr>
    </thead>
    <tbody>
        <div >
            <tr>
            <input type="hidden" id="airline_adult_total_cost_price' . $append_count . '" class="adult_cost_price_sum">
            <input type="hidden" id="airline_children_total_cost_price' . $append_count . '" class="children_cost_price_sum">
            <input type="hidden" id="airline_infant_total_cost_price' . $append_count . '" class="infant_cost_price_sum">
            <input type="hidden" id="airline_service_id" name="airline_service_id">
            <input type="hidden" id="airline_inventory_id' . $append_count . '" name="air_ticket[' . $append_count . '][legs_count][airline_inventory_id][]">
            <input type="hidden" id="airline_sub_service_id" name="airline_sub_service_id">
            <input type="hidden" id="airline_currency_total" name="air_ticket[' . $append_count . '][airline_currency_total][]">
            <input type="hidden" id="airline_currency_name" name="air_ticket[' . $append_count . '][airline_currency_name][]">
            <input type="hidden" class="airline_sum_legs" id="airline_sum_legs" name="airline_sum_legs">
            <td><input disabled type="number" value="' . $air_ticket_person_decode[0]->airline_adult_cost_price . '" id="airline_adult_cost_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_adult_cost_price][]" class="form-control"></td>
            <td><input disabled type="number" value="' . $air_ticket_person_decode[0]->airline_children_cost_price . '"  id="airline_children_cost_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_children_cost_price][]" class="form-control"></td>
            <td><input disabled type="number" value="' . $air_ticket_person_decode[0]->airline_infant_cost_price . '" id="airline_infant_cost_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_infant_cost_price][]" class="form-control"></td>
            </tr>
        </div>
    </tbody>
</table>
<table class="table table-striped mt-2 table-inverse table-responsive" >
<thead class="thead-inverse mt-2">
    <tr>
        <th>Total Cost Price</th>
        <th>Discount</th>
        <th>Total</th>
        <th id="airline_exchange_head' . $append_count . '">Exchange</th>
    </tr>
</thead>
<tbody>
    <div id="append_airline">
        <tr>
            <td><input disabled value="' . $air_ticket_sub_total_details_decode[0]->airline_sub_total . '"  type="number" id="airline_total_cost_price' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_sub_total][]" class="form-control"></td>
            <td><input disabled value="' . $air_ticket_sub_total_details_decode[0]->airline_discount . '"  type="number" id="airline_discount' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_discount][]" class="form-control"></td>
            <td><input disabled value="' . $air_ticket_sub_total_details_decode[0]->airline_total . '"  type="number" id="airline_total' . $append_count . '" onchange="airline_calculate(' . $append_count . ')" name="air_ticket[' . $append_count . '][airline_total][]" class="form-control"></td>
            <td><select disabled name="air_ticket[' . $append_count . '][airline_currency][]"   onchange="onchange_get_curr_data_airline(' . $append_count . ')" id="airline_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
            </tr>
    </div>
</tbody>
</table>
</div></div>
';
                    }
                }
            } elseif ($sub_service_name == "Land Services") { {

                    if ($get_q_d->type == "no_of_person") {
                        if ($service_type == "no_of_person") {
                            $sub_name = "Land Services";
                            $currency_rates = currency_exchange_rate::where('status', 1)->get();

                            $land_services_options = "<option value=''>Select</option>";
                            $currency_rate_options = "";
                            $addon_options = "<option value=''>Select</option>";
                            // foreach ($land_services as $key => $value) {
                            //     // dd($value->name);
                            //
                            // }
                            foreach ($currency_rates as $key => $value) {
                                $currency_rate_options .= "<option data='" . $value->currency_name . "' value='" . $value->currency_rate . "'>" . $value->currency_name . "</option>";
                            }

                            $legs_count = 0;
                            $add_more_legs = 0;
                            // means No OF Person (0)
                            $service_type_no = 0;
                            $land_legs = "";


                            foreach ($land_services_all_entries_decode as $key => $land_services_d) {
                                // dd($land_services_all_entries_decode);
                                $land_cost_price = round($land_services_person_decode[$key]->land_services_cost_price / 1);
                                $land_selling_price = round($land_services_person_decode[$key]->land_services_selling_price / 1);
                                $land_services = Landservicestypes::where('status', 1)->where('id_land_and_services_types', $land_services_d->land_service)->first();
                                $transport_decode = json_decode($land_services->total_entries);
                                // dd();
                                $land_services_types = land_services_type::where('id_land_services_types', $land_services->name)->first();
                                $get_routes = Route::where('id_route', $transport_decode[$land_services_d->transport]->route_id)->first();
                                $land_services_options .= "<option selected value='" . $land_services->id_land_and_services_types . "'>" . $land_services_types->service_name . "</option>";
                                // dd($land_services);
                                $adult_cost_price = ($adult_cost_price + $land_cost_price) * $no_of_adult;
                                $children_cost_price = ($children_cost_price + $land_cost_price) * $no_of_children;
                                $infant_cost_price = ($infant_cost_price + $land_cost_price) * $no_of_infant;


                                $adult_selling_price = ($adult_selling_price + $land_selling_price) * $no_of_adult;
                                $children_selling_price = ($children_selling_price + $land_selling_price) * $no_of_children;
                                $infant_selling_price = ($infant_selling_price + $land_selling_price) * $no_of_infant;

                                $land_legs .= ' <table class="table table-striped table-inverse table-responsive mt-2">
                            <thead class="thead-inverse">
                                <tr>
                                <th>Land Service</th>
                                <th>Transport</th>
                                <th>Route</th>
                                <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div id="append_hotel">
                                <tr>
                                <input type="hidden" name="service_type_id" id="service_type_id' . $append_count . '"/>
                                <td><select disabled style="width:100%;" id="land_service' . $append_count . '" name="land_services[' . $append_count . '][legs_count][land_service][]" onchange="get_land_services_route(' . $append_count . ')" class="form-control select2' . $append_count . '" >
                                ' . $land_services_options . '
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][transport][]" id="transport' . $append_count . '" >
                                                        <option value="' . $land_services_d->transport . '">' . $transport_decode[$land_services_d->transport]->transport . '</option>
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][land_services_route][]" id="land_services_route' . $append_count . '" >
                                                        <option value="' . $get_routes->id_route . '">' . $get_routes->route_location . '</option>
                                                        </select></td>
                                                        <td><input disabled value="' . $land_services_d->date . '" style="width:100%;" type="text" placeholder="mm/dd/yyyy" readonly id="land_services_date' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][date][]" class="form-control fc-datepicker' . $append_count . '"></td>
                                                        </tr>
                                </div>
                            </tbody>
                        </table>
                        <table class="table table-striped mt-2 table-inverse table-responsive" >
                        <thead class="thead-inverse mt-2">
                            <tr>
                                <th>Cost Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div>
                                <tr>
                                <input type="hidden" id="land_services_adult_total_cost_price' . $append_count . '"  class="adult_cost_price_sum">
                                <td><input disabled value="' . $get_land_services_adult_cost_price . '" type="number" id="adult_land_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][legs_count][land_services_adult_cost_price][]" class="form-control adult_land_services_sum_cost_price' . $append_count . '"></td>
                                </tr>
                            </div>
                        </tbody>
                    </table>';
                            }
                            // dd($addon_options);
                            $data .= '<div id="land_services_table' . $append_count . '" class="row"><h4 class="mt-2">Add Land Services Details</h4><div class="col-md-12" style="border:2px solid lightgrey;" >
                    <div id="append_land_services_legs' . $append_count . '"></div>
                    ' . $land_legs . '
                        <table class="table table-striped table-inverse table-responsive">
                        <thead class="thead-inverse">

                            <tr>
                            <th>Total Cost Price</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th id="land_services_exchange_head' . $append_count . '">Exchange</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div>
                                <tr>
                                    <input type="hidden" id="land_services_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_service_id][]">
                                    <input type="hidden" id="land_services_sub_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_sub_service_id][]">
                                    <input type="hidden" id="land_services_currency_name' . $append_count . '" name="land_services[' . $append_count . '][land_services_currency_name][]">
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_total_cost_price . '" type="number" id="land_services_total_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_sub_total][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_discount . '" type="number" id="land_services_discount' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_discount][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_total_cost_price . '" type="number" id="land_services_total' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_total][]" class="form-control"></td>
                                    <td><select disabled name="land_services[' . $append_count . '][land_services_currency][]"   onchange="onchange_get_curr_data_land_services(' . $append_count . ')" id="land_services_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
                                </tr>
                            </div>
                        </tbody>
                        </table>
                    </div></div>
                ';
                        } elseif ($service_type == "service_level") {
                            $sub_name = "Land Services";
                            $currency_rates = currency_exchange_rate::all();
                            $land_services = Landservicestypes::where('status', 1)->get();
                            // dd($addon);
                            $land_services_options = "<option value=''>Select</option>";
                            $currency_rate_options = "";
                            $add_more_legs = 0;
                            $addon_options = "<option value=''>Select</option>";
                            foreach ($land_services as $key => $value) {
                                // dd($value->name);
                                $land_services_types = land_services_type::where('id_land_services_types', $value->name)->first();
                                $land_services_options .= "<option value='" . $value->id_land_and_services_types . "'>" . $land_services_types->service_name . "</option>";
                            }
                            foreach ($currency_rates as $key => $value) {
                                $currency_rate_options .= "<option data='" . $value->currency_name . "' value='" . $value->currency_rate . "'>" . $value->currency_name . "</option>";
                            }
                            $legs_count = 0;
                            // means Service level (1)
                            $service_type_no = 1;
                            $land_legs = "";
                            $land_services_total_selling_price = 0;
                            $count_of_land_services = count($land_services_all_entries_decode);
                            foreach ($land_services_all_entries_decode as $key => $land_services_d) {
                                // dd($land_services_person_decode);
                                // $land_cost_price = round($land_services_person_decode[$key]->land_services_cost_price / 3);
                                // $land_selling_price = round($land_services_person_decode[$key]->land_services_selling_price / 3);
                                $land_services = Landservicestypes::where('status', 1)->where('id_land_and_services_types', $land_services_d->land_service)->first();
                                $transport_decode = json_decode($land_services->total_entries);
                                //  dd();
                                $land_services_types = land_services_type::where('id_land_services_types', $land_services->name)->first();
                                $get_routes = Route::where('id_route', $transport_decode[$land_services_d->transport]->route_id)->first();
                                $land_services_options .= "<option selected value='" . $land_services->id_land_and_services_types . "'>" . $land_services_types->service_name . "</option>";
                                // // dd($land_services);
                                $land_services_adult_cost_price = round($land_services_person_decode[$key]->land_services_adult_cost_price) * $no_of_adult;
                                $land_services_children_cost_price = round($land_services_person_decode[$key]->land_services_children_cost_price) * $no_of_children;
                                $land_services_infant_cost_price = round($land_services_person_decode[$key]->land_services_infant_cost_price) * $no_of_infant;
                                $land_services_cost_price = $land_services_adult_cost_price + $land_services_children_cost_price + $land_services_infant_cost_price;

                                // dd($children_profit);
                                $hotel_adult_selling_price = ($land_services_adult_cost_price + $adult_profit);
                                $hotel_children_selling_price = ($land_services_children_cost_price + $children_profit);
                                $hotel_infant_selling_price = ($land_services_infant_cost_price + $infant_profit);


                                $land_services_selling_price = $hotel_adult_selling_price + $hotel_children_selling_price + $hotel_infant_selling_price;

                                // dd($hotel_selling_price);
                                $land_services_total_selling_price = $land_services_total_selling_price + $land_services_selling_price;


                                // $adult_cost_price = ($adult_cost_price + $land_cost_price) * $no_of_adult;
                                // $children_cost_price = ($children_cost_price + $land_cost_price) * $no_of_children;
                                // $infant_cost_price = ($infant_cost_price + $land_cost_price) * $no_of_infant;

                                // $adult_selling_price = ($adult_selling_price + $land_selling_price) * $no_of_adult;
                                // $children_selling_price = ($children_selling_price + $land_selling_price) * $no_of_children;
                                // $infant_selling_price = ($infant_selling_price + $land_selling_price) * $no_of_infant;

                                $land_legs .= '
                            <table class="table table-striped table-inverse table-responsive mt-2">
                            <thead class="thead-inverse">
                                <tr>
                                <th>Land Service</th>
                                <th>Transport</th>
                                <th>Route</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div id="append_hotel">
                                <tr>
                                <td>
                                <input disabled type="hidden" name="service_type_id" id="service_type_id' . $append_count . '"/>

                                <select disabled style="width:100%;" id="land_service' . $append_count . '" name="land_services[' . $append_count . '][legs_count][land_service][]" onchange="get_land_services_route(' . $append_count . ')" class="form-control select2' . $append_count . '" >
                                ' . $land_services_options . '
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][transport][]" id="transport' . $append_count . '" >
                                                        <option value="' . $land_services_d->transport . '">' . $transport_decode[$land_services_d->transport]->transport . '</option>
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][land_services_route][]" id="land_services_route' . $append_count . '" >
                                                        <option value="' . $get_routes->id_route . '">' . $get_routes->route_location . '</option>
                                                        </select></td>

                                </tr>
                                </div>
                            </tbody>
                        </table>
                        <table class="table table-striped table-inverse table-responsive mt-2">
                    <thead class="thead-inverse">
                        <tr>
                        <th>Cost Price</th>
                        <th>Selling Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div id="append_hotel">
                        <tr>
                        <td><input disabled  type="number" value="' . $land_services_cost_price . '"  id="land_services_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][legs_count][land_services_cost_price][]" class="form-control land_services_cost_price' . $append_count . '"></td>
                        <td><input disabled  type="number" value="' . $land_services_selling_price . '" id="land_services_selling_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][legs_count][land_services_selling_price][]" class="form-control land_services_selling_price' . $append_count . '"></td>
                        </tr>
                        </div>
                    </tbody>
                </table>
                        ';
                            }
                            $total_selling_price_sl = $total_selling_price_sl + $land_services_total_selling_price;
                            // dd($land_services_sub_total_details_decode);
                            // dd($addon_options);
                            $data .= '<div id="land_services_table' . $append_count . '" class="row"><h4 class="mt-2">Add Land Services Details</h4><div class="col-md-12" style="border:2px solid lightgrey;" >
' . $land_legs . '
                <div id="append_land_services_legs' . $append_count . '"></div>
                        <table class="table table-striped table-inverse table-responsive">
                        <thead class="thead-inverse">
                            <tr>
                            <th>Total Cost Price</th>
                            <th>Total Selling Price</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th id="land_services_exchange_head' . $append_count . '">Exchange</th>
                            <th>Add</th>
                            <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div>
                                <tr>
                                    <input disabled type="hidden" id="land_services_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_service_id][]">
                                    <input disabled type="hidden" id="land_services_sub_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_sub_service_id][]">
                                    <input disabled type="hidden" id="land_services_currency_name' . $append_count . '" name="land_services[' . $append_count . '][land_services_currency_name][]">
                                    <input disabled type="hidden" id="land_services_currency_total' . $append_count . '" name="land_services[' . $append_count . '][land_services_currency_total][]">
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_sub_total . '" type="number" id="land_services_total_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_total_cost_price][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_total_selling_price . '" type="number" id="land_services_sub_total' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_selling_total][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_discount . '" type="number" id="land_services_discount' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_discount][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_total . '"  type="number" id="land_services_total' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_total][]" class="form-control"></td>
                                    <td><select disabled name="land_services[' . $append_count . '][land_services_currency][]"   onchange="onchange_get_curr_data_land_services(' . $append_count . ')" id="land_services_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
                                    <td><button disabled class="btn btn-success text-white" type="button" style="margin:0;" onclick="get_route_details(' . $legs_count . ',' . $append_count . ',' . $add_more_legs . ')"><i class="fa fa-plus"></i></button></td>
                                    <td><button disabled class="btn btn-danger" type="button" style="margin:0;"  onClick="remove_land_services(' . $append_count . ')"><i class="fa fa-trash"></i></button></td>
                                </tr>
                            </div>
                        </tbody>
                        </table>
                    </div></div>
                ';
                        } else {
                            $sub_name = "Land Services";
                            $currency_rates = currency_exchange_rate::where('status', 1)->get();

                            $land_services_options = "<option value=''>Select</option>";
                            $currency_rate_options = "";
                            $addon_options = "<option value=''>Select</option>";

                            // foreach ($land_services as $key => $value) {
                            //     // dd($value->name);
                            //
                            // }
                            foreach ($currency_rates as $key => $value) {
                                $currency_rate_options .= "<option data='" . $value->currency_name . "' value='" . $value->currency_rate . "'>" . $value->currency_name . "</option>";
                            }
                            $legs_count = 0;
                            $add_more_legs = 0;
                            // means No OF Person (0)
                            $service_type_no = 0;
                            $land_legs = "";
                            $count_of_legs_land_services = count($land_services_all_entries_decode);
                            $get_land_services_adult_cost_price = 0;
                            $get_land_services_children_cost_price = 0;
                            $get_land_services_infant_cost_price = 0;
                            // dd($land_services_person_decode);

                            foreach ($land_services_all_entries_decode as $key => $land_services_d) {
                                // dd($land_services_person_decode);
                                // $land_cost_price = round($land_services_person_decode[$key]->land_services_cost_price / 3);
                                // $land_selling_price = round($land_services_person_decode[$key]->land_services_selling_price / 3);
                                $land_services = Landservicestypes::where('status', 1)->where('id_land_and_services_types', $land_services_d->land_service)->first();
                                $transport_decode = json_decode($land_services->total_entries);
                                // dd();
                                $land_services_types = land_services_type::where('id_land_services_types', $land_services->name)->first();
                                $get_routes = Route::where('id_route', $transport_decode[$land_services_d->transport]->route_id)->first();
                                $land_services_options .= "<option selected value='" . $land_services->id_land_and_services_types . "'>" . $land_services_types->service_name . "</option>";
                                // dd($land_services);
                                // $adult_cost_price = ($adult_cost_price + $land_cost_price) * $no_of_adult;
                                // $children_cost_price = ($children_cost_price + $land_cost_price) * $no_of_children;
                                // $infant_cost_price = ($infant_cost_price + $land_cost_price) * $no_of_infant;


                                $adult_cost_price =  $land_services_person_decode[$key]->land_services_adult_cost_price;
                                $children_cost_price = $land_services_person_decode[$key]->land_services_children_cost_price;
                                $infant_cost_price = $land_services_person_decode[$key]->land_services_infant_cost_price;

                                $get_land_services_adult_cost_price = $get_land_services_adult_cost_price + $land_services_person_decode[$key]->land_services_adult_cost_price;
                                $get_land_services_children_cost_price = $get_land_services_adult_cost_price + $land_services_person_decode[$key]->land_services_children_cost_price;
                                $get_land_services_infant_cost_price = $get_land_services_adult_cost_price + $land_services_person_decode[$key]->land_services_infant_cost_price;
                                $adult_selling_price = 0;
                                $children_selling_price = 0;
                                $infant_selling_price = 0;

                                // $adult_selling_price = ($adult_selling_price + $land_selling_price) * $no_of_adult;
                                // $children_selling_price = ($children_selling_price + $land_selling_price) * $no_of_children;
                                // $infant_selling_price = ($infant_selling_price + $land_selling_price) * $no_of_infant;

                                $land_legs .= ' <table class="table table-striped table-inverse table-responsive mt-2">
                            <thead class="thead-inverse">
                                <tr>
                                <th>Land Service</th>
                                <th>Transport</th>
                                <th>Route</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div id="append_hotel">
                                <tr>
                                <input type="hidden" name="service_type_id" id="service_type_id' . $append_count . '"/>
                                <td><select disabled style="width:100%;" id="land_service' . $append_count . '" name="land_services[' . $append_count . '][legs_count][land_service][]" onchange="get_land_services_route(' . $append_count . ')" class="form-control select2' . $append_count . '" >
                                ' . $land_services_options . '
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][transport][]" id="transport' . $append_count . '" >
                                                        <option value="' . $land_services_d->transport . '">' . $transport_decode[$land_services_d->transport]->transport . '</option>
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][land_services_route][]" id="land_services_route' . $append_count . '" >
                                                        <option value="' . $get_routes->id_route . '">' . $get_routes->route_location . '</option>
                                                        </select></td>
                                                        </tr>
                                </div>
                            </tbody>
                        </table>
                        <table class="table table-striped mt-2 table-inverse table-responsive" >
                        <thead class="thead-inverse mt-2">
                            <tr>
                                <th>Cost Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div>
                                <tr>
                                <input type="hidden" id="land_services_adult_total_cost_price' . $append_count . '"  class="adult_cost_price_sum">
                                <td><input disabled value="' . $adult_cost_price . '" type="number" id="adult_land_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][legs_count][land_services_adult_cost_price][]" class="form-control adult_land_services_sum_cost_price' . $append_count . '"></td>
                                </tr>
                            </div>
                        </tbody>
                    </table>';
                            }


                            // dd($addon_options);
                            $data .= '<div id="land_services_table' . $append_count . '" class="row"><h4 class="mt-2">Add Land Services Details</h4><div class="col-md-12" style="border:2px solid lightgrey;" >
                    <div id="append_land_services_legs' . $append_count . '"></div>
                    ' . $land_legs . '
                        <table class="table table-striped table-inverse table-responsive">
                        <thead class="thead-inverse">

                            <tr>
                            <th>Total Cost Price</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th id="land_services_exchange_head' . $append_count . '">Exchange</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div>
                                <tr>
                                    <input type="hidden" id="land_services_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_service_id][]">
                                    <input type="hidden" id="land_services_sub_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_sub_service_id][]">
                                    <input type="hidden" id="land_services_currency_name' . $append_count . '" name="land_services[' . $append_count . '][land_services_currency_name][]">
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_sub_total . '" type="number" id="land_services_total_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_sub_total][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_discount . '" type="number" id="land_services_discount' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_discount][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_total . '" type="number" id="land_services_total' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_total][]" class="form-control"></td>
                                    <td><select disabled name="land_services[' . $append_count . '][land_services_currency][]"   onchange="onchange_get_curr_data_land_services(' . $append_count . ')" id="land_services_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
                                </tr>
                            </div>
                        </tbody>
                        </table>
                    </div></div>
                ';
                        }
                    }
                    if ($get_q_d->type == "lum_sum") {
                        if ($service_type == "no_of_person") {
                            $sub_name = "Land Services";
                            $currency_rates = currency_exchange_rate::where('status', 1)->get();

                            $land_services_options = "<option value=''>Select</option>";
                            $currency_rate_options = "";
                            $addon_options = "<option value=''>Select</option>";
                            // foreach ($land_services as $key => $value) {
                            //     // dd($value->name);
                            //
                            // }
                            foreach ($currency_rates as $key => $value) {
                                $currency_rate_options .= "<option data='" . $value->currency_name . "' value='" . $value->currency_rate . "'>" . $value->currency_name . "</option>";
                            }

                            $legs_count = 0;
                            $add_more_legs = 0;
                            // means No OF Person (0)
                            $service_type_no = 0;
                            $land_legs = "";
                            $get_land_services_adult_cost_price = 0;
                            $get_land_services_children_cost_price = 0;
                            $get_land_services_infant_cost_price = 0;

                            foreach ($land_services_all_entries_decode as $key => $land_services_d) {
                                // dd($land_services_person_decode);
                                // $land_cost_price = round($land_services_person_decode[$key]->land_services_cost_price / 3);
                                // $land_selling_price = round($land_services_person_decode[$key]->land_services_selling_price / 3);
                                $land_services = Landservicestypes::where('status', 1)->where('id_land_and_services_types', $land_services_d->land_service)->first();
                                $transport_decode = json_decode($land_services->total_entries);
                                // dd();
                                $land_services_types = land_services_type::where('id_land_services_types', $land_services->name)->first();
                                $get_routes = Route::where('id_route', $transport_decode[$land_services_d->transport]->route_id)->first();
                                $land_services_options .= "<option selected value='" . $land_services->id_land_and_services_types . "'>" . $land_services_types->service_name . "</option>";
                                // // dd($land_services);
                                // $adult_cost_price = ($adult_cost_price + $land_cost_price) * $no_of_adult;
                                // $children_cost_price = ($children_cost_price + $land_cost_price) * $no_of_children;
                                // $infant_cost_price = ($infant_cost_price + $land_cost_price) * $no_of_infant;


                                // $adult_selling_price = ($adult_selling_price + $land_selling_price) * $no_of_adult;
                                // $children_selling_price = ($children_selling_price + $land_selling_price) * $no_of_children;
                                // $infant_selling_price = ($infant_selling_price + $land_selling_price) * $no_of_infant;


                                $get_land_services_adult_cost_price = $get_land_services_adult_cost_price + $land_services_person_decode[$key]->land_services_adult_cost_price;
                                $get_land_services_children_cost_price = $get_land_services_adult_cost_price + $land_services_person_decode[$key]->land_services_children_cost_price;
                                $get_land_services_infant_cost_price = $get_land_services_adult_cost_price + $land_services_person_decode[$key]->land_services_infant_cost_price;


                                $land_legs .= ' <table class="table table-striped table-inverse table-responsive mt-2">
                            <thead class="thead-inverse">
                                <tr>
                                <th>Land Service</th>
                                <th>Transport</th>
                                <th>Route</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div id="append_hotel">
                                <tr>
                                <input type="hidden" name="service_type_id" id="service_type_id' . $append_count . '"/>
                                <td><select disabled style="width:100%;" id="land_service' . $append_count . '" name="land_services[' . $append_count . '][legs_count][land_service][]" onchange="get_land_services_route(' . $append_count . ')" class="form-control select2' . $append_count . '" >
                                ' . $land_services_options . '
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][transport][]" id="transport' . $append_count . '" >
                                                        <option value="' . $land_services_d->transport . '">' . $transport_decode[$land_services_d->transport]->transport . '</option>
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][land_services_route][]" id="land_services_route' . $append_count . '" >
                                                        <option value="' . $get_routes->id_route . '">' . $get_routes->route_location . '</option>
                                                        </select></td>

                                                        </tr>
                                </div>
                            </tbody>
                        </table>
                        <table class="table table-striped mt-2 table-inverse table-responsive" >
                        <thead class="thead-inverse mt-2">
                            <tr>
                                <th>Cost Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div>
                                <tr>
                                <input type="hidden" id="land_services_adult_total_cost_price' . $append_count . '"  class="adult_cost_price_sum">
                                <td><input disabled value="' . $get_land_services_adult_cost_price . '" type="number" id="adult_land_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][legs_count][land_services_adult_cost_price][]" class="form-control adult_land_services_sum_cost_price' . $append_count . '"></td>
                                </tr>
                            </div>
                        </tbody>
                    </table>';
                            }
                            // dd($land_services_sub_total_details_decode);
                            $data .= '<div id="land_services_table' . $append_count . '" class="row"><h4 class="mt-2">Add Land Services Details</h4><div class="col-md-12" style="border:2px solid lightgrey;" >
                    <div id="append_land_services_legs' . $append_count . '"></div>
                    ' . $land_legs . '
                        <table class="table table-striped table-inverse table-responsive">
                        <thead class="thead-inverse">

                            <tr>
                            <th>Total Cost Price</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th id="land_services_exchange_head' . $append_count . '">Exchange</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div>
                                <tr>
                                    <input type="hidden" id="land_services_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_service_id][]">
                                    <input type="hidden" id="land_services_sub_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_sub_service_id][]">
                                    <input type="hidden" id="land_services_currency_name' . $append_count . '" name="land_services[' . $append_count . '][land_services_currency_name][]">
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_sub_total . '" type="number" id="land_services_total_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_sub_total][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_discount . '" type="number" id="land_services_discount' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_discount][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_sub_total . '" type="number" id="land_services_total' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_total][]" class="form-control"></td>
                                    <td><select disabled name="land_services[' . $append_count . '][land_services_currency][]"   onchange="onchange_get_curr_data_land_services(' . $append_count . ')" id="land_services_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
                                </tr>
                            </div>
                        </tbody>
                        </table>
                    </div></div>
                ';
                        } elseif ($service_type == "service_level") {
                            $sub_name = "Land Services";
                            $currency_rates = currency_exchange_rate::all();
                            $land_services = Landservicestypes::where('status', 1)->get();
                            // dd($addon);
                            $land_services_options = "<option value=''>Select</option>";
                            $currency_rate_options = "";
                            $add_more_legs = 0;
                            $addon_options = "<option value=''>Select</option>";
                            foreach ($land_services as $key => $value) {
                                // dd($value->name);
                                $land_services_types = land_services_type::where('id_land_services_types', $value->name)->first();
                                $land_services_options .= "<option value='" . $value->id_land_and_services_types . "'>" . $land_services_types->service_name . "</option>";
                            }
                            foreach ($currency_rates as $key => $value) {
                                $currency_rate_options .= "<option data='" . $value->currency_name . "' value='" . $value->currency_rate . "'>" . $value->currency_name . "</option>";
                            }
                            $legs_count = 0;
                            // means Service level (1)
                            $service_type_no = 1;
                            $land_legs = "";
                            $land_services_total_selling_price = 0;
                            $count_of_land_services = count($land_services_all_entries_decode);
                            foreach ($land_services_all_entries_decode as $key => $land_services_d) {
                                // dd($land_services_person_decode);
                                // $land_cost_price = round($land_services_person_decode[$key]->land_services_cost_price / 3);
                                // $land_selling_price = round($land_services_person_decode[$key]->land_services_selling_price / 3);
                                $land_services = Landservicestypes::where('status', 1)->where('id_land_and_services_types', $land_services_d->land_service)->first();
                                $transport_decode = json_decode($land_services->total_entries);
                                //  dd();
                                $land_services_types = land_services_type::where('id_land_services_types', $land_services->name)->first();
                                $get_routes = Route::where('id_route', $transport_decode[$land_services_d->transport]->route_id)->first();
                                $land_services_options .= "<option selected value='" . $land_services->id_land_and_services_types . "'>" . $land_services_types->service_name . "</option>";
                                // // dd($land_services);
                                $land_services_adult_cost_price = round($land_services_person_decode[$key]->land_services_adult_cost_price) * $no_of_adult;
                                $land_services_children_cost_price = round($land_services_person_decode[$key]->land_services_children_cost_price) * $no_of_children;
                                $land_services_infant_cost_price = round($land_services_person_decode[$key]->land_services_infant_cost_price) * $no_of_infant;
                                $land_services_cost_price = $land_services_adult_cost_price + $land_services_children_cost_price + $land_services_infant_cost_price;

                                // dd($children_profit);
                                $hotel_adult_selling_price = ($land_services_adult_cost_price + $adult_profit);
                                $hotel_children_selling_price = ($land_services_children_cost_price + $children_profit);
                                $hotel_infant_selling_price = ($land_services_infant_cost_price + $infant_profit);


                                $land_services_selling_price = $hotel_adult_selling_price + $hotel_children_selling_price + $hotel_infant_selling_price;

                                // dd($hotel_selling_price);
                                $land_services_total_selling_price = $land_services_total_selling_price + $land_services_selling_price;


                                // $adult_cost_price = ($adult_cost_price + $land_cost_price) * $no_of_adult;
                                // $children_cost_price = ($children_cost_price + $land_cost_price) * $no_of_children;
                                // $infant_cost_price = ($infant_cost_price + $land_cost_price) * $no_of_infant;

                                // $adult_selling_price = ($adult_selling_price + $land_selling_price) * $no_of_adult;
                                // $children_selling_price = ($children_selling_price + $land_selling_price) * $no_of_children;
                                // $infant_selling_price = ($infant_selling_price + $land_selling_price) * $no_of_infant;

                                $land_legs .= '
                            <table class="table table-striped table-inverse table-responsive mt-2">
                            <thead class="thead-inverse">
                                <tr>
                                <th>Land Service</th>
                                <th>Transport</th>
                                <th>Route</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div id="append_hotel">
                                <tr>
                                <td>
                                <input disabled type="hidden" name="service_type_id" id="service_type_id' . $append_count . '"/>

                                <select disabled style="width:100%;" id="land_service' . $append_count . '" name="land_services[' . $append_count . '][legs_count][land_service][]" onchange="get_land_services_route(' . $append_count . ')" class="form-control select2' . $append_count . '" >
                                ' . $land_services_options . '
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][transport][]" id="transport' . $append_count . '" >
                                                        <option value="' . $land_services_d->transport . '">' . $transport_decode[$land_services_d->transport]->transport . '</option>
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][land_services_route][]" id="land_services_route' . $append_count . '" >
                                                        <option value="' . $get_routes->id_route . '">' . $get_routes->route_location . '</option>
                                                        </select></td>

                                </tr>
                                </div>
                            </tbody>
                        </table>
                        <table class="table table-striped table-inverse table-responsive mt-2">
                    <thead class="thead-inverse">
                        <tr>
                        <th>Cost Price</th>
                        <th>Selling Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div id="append_hotel">
                        <tr>
                        <td><input disabled  type="number" value="' . $land_services_cost_price . '"  id="land_services_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][legs_count][land_services_cost_price][]" class="form-control land_services_cost_price' . $append_count . '"></td>
                        <td><input disabled  type="number" value="' . $land_services_selling_price . '" id="land_services_selling_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][legs_count][land_services_selling_price][]" class="form-control land_services_selling_price' . $append_count . '"></td>
                        </tr>
                        </div>
                    </tbody>
                </table>
                        ';
                            }
                            $total_selling_price_sl = $total_selling_price_sl + $land_services_total_selling_price;
                            // dd($land_services_sub_total_details_decode);
                            // dd($addon_options);
                            $data .= '<div id="land_services_table' . $append_count . '" class="row"><h4 class="mt-2">Add Land Services Details</h4><div class="col-md-12" style="border:2px solid lightgrey;" >
' . $land_legs . '
                <div id="append_land_services_legs' . $append_count . '"></div>
                        <table class="table table-striped table-inverse table-responsive">
                        <thead class="thead-inverse">
                            <tr>
                            <th>Total Cost Price</th>
                            <th>Total Selling Price</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th id="land_services_exchange_head' . $append_count . '">Exchange</th>
                            <th>Add</th>
                            <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div>
                                <tr>
                                    <input disabled type="hidden" id="land_services_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_service_id][]">
                                    <input disabled type="hidden" id="land_services_sub_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_sub_service_id][]">
                                    <input disabled type="hidden" id="land_services_currency_name' . $append_count . '" name="land_services[' . $append_count . '][land_services_currency_name][]">
                                    <input disabled type="hidden" id="land_services_currency_total' . $append_count . '" name="land_services[' . $append_count . '][land_services_currency_total][]">
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_sub_total . '" type="number" id="land_services_total_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_total_cost_price][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_total_selling_price . '" type="number" id="land_services_sub_total' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_selling_total][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_discount . '" type="number" id="land_services_discount' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_discount][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_total . '"  type="number" id="land_services_total' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_total][]" class="form-control"></td>
                                    <td><select disabled name="land_services[' . $append_count . '][land_services_currency][]"   onchange="onchange_get_curr_data_land_services(' . $append_count . ')" id="land_services_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
                                    <td><button disabled class="btn btn-success text-white" type="button" style="margin:0;" onclick="get_route_details(' . $legs_count . ',' . $append_count . ',' . $add_more_legs . ')"><i class="fa fa-plus"></i></button></td>
                                    <td><button disabled class="btn btn-danger" type="button" style="margin:0;"  onClick="remove_land_services(' . $append_count . ')"><i class="fa fa-trash"></i></button></td>
                                </tr>
                            </div>
                        </tbody>
                        </table>
                    </div></div>
                ';
                        } else {
                            $sub_name = "Land Services";
                            $currency_rates = currency_exchange_rate::where('status', 1)->get();

                            $land_services_options = "<option value=''>Select</option>";
                            $currency_rate_options = "";
                            $addon_options = "<option value=''>Select</option>";

                            // foreach ($land_services as $key => $value) {
                            //     // dd($value->name);
                            //
                            // }
                            foreach ($currency_rates as $key => $value) {
                                $currency_rate_options .= "<option data='" . $value->currency_name . "' value='" . $value->currency_rate . "'>" . $value->currency_name . "</option>";
                            }
                            $legs_count = 0;
                            $add_more_legs = 0;
                            // means No OF Person (0)
                            $service_type_no = 0;
                            $land_legs = "";
                            $count_of_legs_land_services = count($land_services_all_entries_decode);
                            $get_land_services_adult_cost_price = 0;
                            $get_land_services_children_cost_price = 0;
                            $get_land_services_infant_cost_price = 0;
                            // dd($land_services_person_decode);

                            foreach ($land_services_all_entries_decode as $key => $land_services_d) {
                                // dd($land_services_person_decode);
                                // $land_cost_price = round($land_services_person_decode[$key]->land_services_cost_price / 3);
                                // $land_selling_price = round($land_services_person_decode[$key]->land_services_selling_price / 3);
                                $land_services = Landservicestypes::where('status', 1)->where('id_land_and_services_types', $land_services_d->land_service)->first();
                                $transport_decode = json_decode($land_services->total_entries);
                                // dd();
                                $land_services_types = land_services_type::where('id_land_services_types', $land_services->name)->first();
                                $get_routes = Route::where('id_route', $transport_decode[$land_services_d->transport]->route_id)->first();
                                $land_services_options .= "<option selected value='" . $land_services->id_land_and_services_types . "'>" . $land_services_types->service_name . "</option>";
                                // dd($land_services);
                                // $adult_cost_price = ($adult_cost_price + $land_cost_price) * $no_of_adult;
                                // $children_cost_price = ($children_cost_price + $land_cost_price) * $no_of_children;
                                // $infant_cost_price = ($infant_cost_price + $land_cost_price) * $no_of_infant;


                                $adult_cost_price =  $land_services_person_decode[$key]->land_services_adult_cost_price;
                                $children_cost_price = $land_services_person_decode[$key]->land_services_children_cost_price;
                                $infant_cost_price = $land_services_person_decode[$key]->land_services_infant_cost_price;

                                $get_land_services_adult_cost_price = $get_land_services_adult_cost_price + $land_services_person_decode[$key]->land_services_adult_cost_price;
                                $get_land_services_children_cost_price = $get_land_services_adult_cost_price + $land_services_person_decode[$key]->land_services_children_cost_price;
                                $get_land_services_infant_cost_price = $get_land_services_adult_cost_price + $land_services_person_decode[$key]->land_services_infant_cost_price;
                                $adult_selling_price = 0;
                                $children_selling_price = 0;
                                $infant_selling_price = 0;

                                // $adult_selling_price = ($adult_selling_price + $land_selling_price) * $no_of_adult;
                                // $children_selling_price = ($children_selling_price + $land_selling_price) * $no_of_children;
                                // $infant_selling_price = ($infant_selling_price + $land_selling_price) * $no_of_infant;

                                $land_legs .= ' <table class="table table-striped table-inverse table-responsive mt-2">
                            <thead class="thead-inverse">
                                <tr>
                                <th>Land Service</th>
                                <th>Transport</th>
                                <th>Route</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div id="append_hotel">
                                <tr>
                                <input type="hidden" name="service_type_id" id="service_type_id' . $append_count . '"/>
                                <td><select disabled style="width:100%;" id="land_service' . $append_count . '" name="land_services[' . $append_count . '][legs_count][land_service][]" onchange="get_land_services_route(' . $append_count . ')" class="form-control select2' . $append_count . '" >
                                ' . $land_services_options . '
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][transport][]" id="transport' . $append_count . '" >
                                                        <option value="' . $land_services_d->transport . '">' . $transport_decode[$land_services_d->transport]->transport . '</option>
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][land_services_route][]" id="land_services_route' . $append_count . '" >
                                                        <option value="' . $get_routes->id_route . '">' . $get_routes->route_location . '</option>
                                                        </select></td>
                                                        </tr>
                                </div>
                            </tbody>
                        </table>
                        <table class="table table-striped mt-2 table-inverse table-responsive" >
                        <thead class="thead-inverse mt-2">
                            <tr>
                                <th>Cost Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div>
                                <tr>
                                <input type="hidden" id="land_services_adult_total_cost_price' . $append_count . '"  class="adult_cost_price_sum">
                                <td><input disabled value="' . $adult_cost_price . '" type="number" id="adult_land_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][legs_count][land_services_adult_cost_price][]" class="form-control adult_land_services_sum_cost_price' . $append_count . '"></td>
                                </tr>
                            </div>
                        </tbody>
                    </table>';
                            }


                            // dd($addon_options);
                            $data .= '<div id="land_services_table' . $append_count . '" class="row"><h4 class="mt-2">Add Land Services Details</h4><div class="col-md-12" style="border:2px solid lightgrey;" >
                    <div id="append_land_services_legs' . $append_count . '"></div>
                    ' . $land_legs . '
                        <table class="table table-striped table-inverse table-responsive">
                        <thead class="thead-inverse">

                            <tr>
                            <th>Total Cost Price</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th id="land_services_exchange_head' . $append_count . '">Exchange</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div>
                                <tr>
                                    <input type="hidden" id="land_services_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_service_id][]">
                                    <input type="hidden" id="land_services_sub_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_sub_service_id][]">
                                    <input type="hidden" id="land_services_currency_name' . $append_count . '" name="land_services[' . $append_count . '][land_services_currency_name][]">
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_sub_total . '" type="number" id="land_services_total_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_sub_total][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_discount . '" type="number" id="land_services_discount' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_discount][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_total . '" type="number" id="land_services_total' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_total][]" class="form-control"></td>
                                    <td><select disabled name="land_services[' . $append_count . '][land_services_currency][]"   onchange="onchange_get_curr_data_land_services(' . $append_count . ')" id="land_services_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
                                </tr>
                            </div>
                        </tbody>
                        </table>
                    </div></div>
                ';
                        }
                    }

                    if ($get_q_d->type == "service_level") {
                        if ($service_type == "no_of_person") {
                            $sub_name = "Land Services";
                            $currency_rates = currency_exchange_rate::where('status', 1)->get();

                            $land_services_options = "<option value=''>Select</option>";
                            $currency_rate_options = "";
                            $addon_options = "<option value=''>Select</option>";
                            // foreach ($land_services as $key => $value) {
                            //     // dd($value->name);
                            //
                            // }
                            foreach ($currency_rates as $key => $value) {
                                $currency_rate_options .= "<option data='" . $value->currency_name . "' value='" . $value->currency_rate . "'>" . $value->currency_name . "</option>";
                            }
                            $legs_count = 0;
                            $add_more_legs = 0;
                            // means No OF Person (0)
                            $service_type_no = 0;
                            $land_legs = "";


                            foreach ($land_services_all_entries_decode as $key => $land_services_d) {
                                // dd($land_services_all_entries_decode);
                                $land_cost_price = round($land_services_person_decode[$key]->land_services_cost_price / 1);
                                $land_selling_price = round($land_services_person_decode[$key]->land_services_selling_price / 1);
                                $land_services = Landservicestypes::where('status', 1)->where('id_land_and_services_types', $land_services_d->land_service)->first();
                                $transport_decode = json_decode($land_services->total_entries);
                                // dd();
                                $land_services_types = land_services_type::where('id_land_services_types', $land_services->name)->first();
                                $get_routes = Route::where('id_route', $transport_decode[$land_services_d->transport]->route_id)->first();
                                $land_services_options .= "<option selected value='" . $land_services->id_land_and_services_types . "'>" . $land_services_types->service_name . "</option>";
                                // dd($land_services);
                                $adult_cost_price = ($adult_cost_price + $land_cost_price) * $no_of_adult;
                                $children_cost_price = ($children_cost_price + $land_cost_price) * $no_of_children;
                                $infant_cost_price = ($infant_cost_price + $land_cost_price) * $no_of_infant;

                                $adult_selling_price = ($adult_selling_price + $land_selling_price) * $no_of_adult;
                                $children_selling_price = ($children_selling_price + $land_selling_price) * $no_of_children;
                                $infant_selling_price = ($infant_selling_price + $land_selling_price) * $no_of_infant;

                                $land_legs .= ' <table class="table table-striped table-inverse table-responsive mt-2">
                            <thead class="thead-inverse">
                                <tr>
                                <th>Land Service</th>
                                <th>Transport</th>
                                <th>Route</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div id="append_hotel">
                                <tr>
                                <input type="hidden" name="service_type_id" id="service_type_id' . $append_count . '"/>
                                <td><select disabled style="width:100%;" id="land_service' . $append_count . '" name="land_services[' . $append_count . '][legs_count][land_service][]" onchange="get_land_services_route(' . $append_count . ')" class="form-control select2' . $append_count . '" >
                                ' . $land_services_options . '
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][transport][]" id="transport' . $append_count . '" >
                                                        <option value="' . $land_services_d->transport . '">' . $transport_decode[$land_services_d->transport]->transport . '</option>
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][land_services_route][]" id="land_services_route' . $append_count . '" >
                                                        <option value="' . $get_routes->id_route . '">' . $get_routes->route_location . '</option>
                                                        </select></td>
                                                        </tr>
                                </div>
                            </tbody>
                        </table>
                        <table class="table table-striped mt-2 table-inverse table-responsive" >
                        <thead class="thead-inverse mt-2">
                            <tr>
                                <th>Cost Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div>
                                <tr>
                                <input type="hidden" id="land_services_adult_total_cost_price' . $append_count . '"  class="adult_cost_price_sum">
                                <td><input disabled value="' . $get_land_services_adult_cost_price . '" type="number" id="adult_land_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][legs_count][land_services_adult_cost_price][]" class="form-control adult_land_services_sum_cost_price' . $append_count . '"></td>
                                </tr>
                            </div>
                        </tbody>
                    </table>';
                            }
                            // dd($addon_options);
                            $data .= '<div id="land_services_table' . $append_count . '" class="row"><h4 class="mt-2">Add Land Services Details</h4><div class="col-md-12" style="border:2px solid lightgrey;" >
                    <div id="append_land_services_legs' . $append_count . '"></div>
                    ' . $land_legs . '
                        <table class="table table-striped table-inverse table-responsive">
                        <thead class="thead-inverse">

                            <tr>
                            <th>Total Cost Price</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th id="land_services_exchange_head' . $append_count . '">Exchange</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div>
                                <tr>
                                    <input type="hidden" id="land_services_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_service_id][]">
                                    <input type="hidden" id="land_services_sub_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_sub_service_id][]">
                                    <input type="hidden" id="land_services_currency_name' . $append_count . '" name="land_services[' . $append_count . '][land_services_currency_name][]">
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_total_cost_price . '" type="number" id="land_services_total_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_sub_total][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_discount . '" type="number" id="land_services_discount' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_discount][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_total_cost_price . '" type="number" id="land_services_total' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_total][]" class="form-control"></td>
                                    <td><select disabled name="land_services[' . $append_count . '][land_services_currency][]"   onchange="onchange_get_curr_data_land_services(' . $append_count . ')" id="land_services_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
                                </tr>
                            </div>
                        </tbody>
                        </table>
                    </div></div>
                ';
                        } elseif ($service_type == "service_level") {
                            $sub_name = "Land Services";
                            $currency_rates = currency_exchange_rate::all();
                            $land_services = Landservicestypes::where('status', 1)->get();
                            // dd($addon);
                            $land_services_options = "<option value=''>Select</option>";
                            $currency_rate_options = "";
                            $add_more_legs = 0;
                            $addon_options = "<option value=''>Select</option>";
                            foreach ($land_services as $key => $value) {
                                // dd($value->name);
                                $land_services_types = land_services_type::where('id_land_services_types', $value->name)->first();
                                $land_services_options .= "<option value='" . $value->id_land_and_services_types . "'>" . $land_services_types->service_name . "</option>";
                            }
                            foreach ($currency_rates as $key => $value) {
                                $currency_rate_options .= "<option data='" . $value->currency_name . "' value='" . $value->currency_rate . "'>" . $value->currency_name . "</option>";
                            }
                            $legs_count = 0;
                            // means Service level (1)
                            $service_type_no = 1;
                            $land_legs = "";
                            $land_services_total_selling_price = 0;
                            $count_of_land_services = count($land_services_all_entries_decode);
                            foreach ($land_services_all_entries_decode as $key => $land_services_d) {
                                // dd($land_services_person_decode);
                                // $land_cost_price = round($land_services_person_decode[$key]->land_services_cost_price / 3);
                                // $land_selling_price = round($land_services_person_decode[$key]->land_services_selling_price / 3);
                                $land_services = Landservicestypes::where('status', 1)->where('id_land_and_services_types', $land_services_d->land_service)->first();
                                $transport_decode = json_decode($land_services->total_entries);
                                //  dd();
                                $land_services_types = land_services_type::where('id_land_services_types', $land_services->name)->first();
                                $get_routes = Route::where('id_route', $transport_decode[$land_services_d->transport]->route_id)->first();
                                $land_services_options .= "<option selected value='" . $land_services->id_land_and_services_types . "'>" . $land_services_types->service_name . "</option>";
                                // // dd($land_services);
                                $land_services_adult_cost_price = round($land_services_person_decode[$key]->land_services_adult_cost_price) * $no_of_adult;
                                $land_services_children_cost_price = round($land_services_person_decode[$key]->land_services_children_cost_price) * $no_of_children;
                                $land_services_infant_cost_price = round($land_services_person_decode[$key]->land_services_infant_cost_price) * $no_of_infant;
                                $land_services_cost_price = $land_services_adult_cost_price + $land_services_children_cost_price + $land_services_infant_cost_price;

                                // dd($children_profit);
                                $hotel_adult_selling_price = ($land_services_adult_cost_price + $adult_profit);
                                $hotel_children_selling_price = ($land_services_children_cost_price + $children_profit);
                                $hotel_infant_selling_price = ($land_services_infant_cost_price + $infant_profit);


                                $land_services_selling_price = $hotel_adult_selling_price + $hotel_children_selling_price + $hotel_infant_selling_price;

                                // dd($hotel_selling_price);
                                $land_services_total_selling_price = $land_services_total_selling_price + $land_services_selling_price;


                                // $adult_cost_price = ($adult_cost_price + $land_cost_price) * $no_of_adult;
                                // $children_cost_price = ($children_cost_price + $land_cost_price) * $no_of_children;
                                // $infant_cost_price = ($infant_cost_price + $land_cost_price) * $no_of_infant;

                                // $adult_selling_price = ($adult_selling_price + $land_selling_price) * $no_of_adult;
                                // $children_selling_price = ($children_selling_price + $land_selling_price) * $no_of_children;
                                // $infant_selling_price = ($infant_selling_price + $land_selling_price) * $no_of_infant;

                                $land_legs .= '
                            <table class="table table-striped table-inverse table-responsive mt-2">
                            <thead class="thead-inverse">
                                <tr>
                                <th>Land Service</th>
                                <th>Transport</th>
                                <th>Route</th>
                                <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div id="append_hotel">
                                <tr>
                                <td>
                                <input disabled type="hidden" name="service_type_id" id="service_type_id' . $append_count . '"/>

                                <select disabled style="width:100%;" id="land_service' . $append_count . '" name="land_services[' . $append_count . '][legs_count][land_service][]" onchange="get_land_services_route(' . $append_count . ')" class="form-control select2' . $append_count . '" >
                                ' . $land_services_options . '
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][transport][]" id="transport' . $append_count . '" >
                                                        <option value="' . $land_services_d->transport . '">' . $transport_decode[$land_services_d->transport]->transport . '</option>
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][land_services_route][]" id="land_services_route' . $append_count . '" >
                                                        <option value="' . $get_routes->id_route . '">' . $get_routes->route_location . '</option>
                                                        </select></td>
                                                        <td><input disabled value="' . $land_services_d->date . '" style="width:100%;" type="text" placeholder="mm/dd/yyyy" readonly id="land_services_date' . $append_count . '" name="land_services[' . $append_count . '][legs_count][date][]" class="form-control fc-datepicker' . $append_count . '"></td>
                                </tr>
                                </div>
                            </tbody>
                        </table>
                        <table class="table table-striped table-inverse table-responsive mt-2">
                    <thead class="thead-inverse">
                        <tr>
                        <th>Cost Price</th>
                        <th>Selling Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div id="append_hotel">
                        <tr>
                        <td><input disabled  type="number" value="' . $land_services_cost_price . '"  id="land_services_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][legs_count][land_services_cost_price][]" class="form-control land_services_cost_price' . $append_count . '"></td>
                        <td><input disabled  type="number" value="' . $land_services_selling_price . '" id="land_services_selling_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][legs_count][land_services_selling_price][]" class="form-control land_services_selling_price' . $append_count . '"></td>
                        </tr>
                        </div>
                    </tbody>
                </table>
                        ';
                            }
                            $total_selling_price_sl = $total_selling_price_sl + $land_services_total_selling_price;
                            // dd($land_services_sub_total_details_decode);
                            // dd($addon_options);
                            $data .= '<div id="land_services_table' . $append_count . '" class="row"><h4 class="mt-2">Add Land Services Details</h4><div class="col-md-12" style="border:2px solid lightgrey;" >
' . $land_legs . '
                <div id="append_land_services_legs' . $append_count . '"></div>
                        <table class="table table-striped table-inverse table-responsive">
                        <thead class="thead-inverse">
                            <tr>
                            <th>Total Cost Price</th>
                            <th>Total Selling Price</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th id="land_services_exchange_head' . $append_count . '">Exchange</th>
                            <th>Add</th>
                            <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div>
                                <tr>
                                    <input disabled type="hidden" id="land_services_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_service_id][]">
                                    <input disabled type="hidden" id="land_services_sub_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_sub_service_id][]">
                                    <input disabled type="hidden" id="land_services_currency_name' . $append_count . '" name="land_services[' . $append_count . '][land_services_currency_name][]">
                                    <input disabled type="hidden" id="land_services_currency_total' . $append_count . '" name="land_services[' . $append_count . '][land_services_currency_total][]">
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_sub_total . '" type="number" id="land_services_total_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_total_cost_price][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_total_selling_price . '" type="number" id="land_services_sub_total' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_selling_total][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_discount . '" type="number" id="land_services_discount' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_discount][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_total . '"  type="number" id="land_services_total' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_total][]" class="form-control"></td>
                                    <td><select disabled name="land_services[' . $append_count . '][land_services_currency][]"   onchange="onchange_get_curr_data_land_services(' . $append_count . ')" id="land_services_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
                                    <td><button disabled class="btn btn-success text-white" type="button" style="margin:0;" onclick="get_route_details(' . $legs_count . ',' . $append_count . ',' . $add_more_legs . ')"><i class="fa fa-plus"></i></button></td>
                                    <td><button disabled class="btn btn-danger" type="button" style="margin:0;"  onClick="remove_land_services(' . $append_count . ')"><i class="fa fa-trash"></i></button></td>
                                </tr>
                            </div>
                        </tbody>
                        </table>
                    </div></div>
                ';
                        } else {
                            $sub_name = "Land Services";
                            $currency_rates = currency_exchange_rate::where('status', 1)->get();
                            $land_services = Landservicestypes::where('status', 1)->get();
                            // dd($addon);
                            $land_services_options = "<option value=''>Select</option>";
                            $currency_rate_options = "";
                            $addon_options = "<option value=''>Select</option>";
                            foreach ($land_services as $key => $value) {
                                $land_services_types = land_services_type::where('id_land_services_types', $value->name)->first();
                                $land_services_options .= "<option value='" . $value->id_land_and_services_types . "'>" . $land_services_types->service_name . "</option>";
                            }
                            foreach ($currency_rates as $key => $value) {
                                $currency_rate_options .= "<option data='" . $value->currency_name . "' value='" . $value->currency_rate . "'>" . $value->currency_name . "</option>";
                            }
                            $legs_count = 0;
                            $add_more_legs = 0;
                            // means No OF Person (0)
                            $service_type_no = 0;
                            $land_legs = "";
                            // dd($addon_options);

                            foreach ($land_services_all_entries_decode as $key => $land_services_d) {
                                // dd($land_services_all_entries_decode);
                                $land_cost_price = round($land_services_person_decode[$key]->land_services_cost_price / 1);
                                $land_selling_price = round($land_services_person_decode[$key]->land_services_selling_price / 1);
                                $land_services = Landservicestypes::where('status', 1)->where('id_land_and_services_types', $land_services_d->land_service)->first();
                                $transport_decode = json_decode($land_services->total_entries);
                                // dd();
                                $land_services_types = land_services_type::where('id_land_services_types', $land_services->name)->first();
                                $get_routes = Route::where('id_route', $transport_decode[$land_services_d->transport]->route_id)->first();
                                $land_services_options .= "<option selected value='" . $land_services->id_land_and_services_types . "'>" . $land_services_types->service_name . "</option>";
                                // dd($land_services);
                                $adult_cost_price = ($adult_cost_price + $land_cost_price) * $no_of_adult;
                                $children_cost_price = ($children_cost_price + $land_cost_price) * $no_of_children;
                                $infant_cost_price = ($infant_cost_price + $land_cost_price) * $no_of_infant;

                                $adult_selling_price = ($adult_selling_price + $land_selling_price) * $no_of_adult;
                                $children_selling_price = ($children_selling_price + $land_selling_price) * $no_of_children;
                                $infant_selling_price = ($infant_selling_price + $land_selling_price) * $no_of_infant;

                                $land_legs .= ' <table class="table table-striped table-inverse table-responsive mt-2">
                            <thead class="thead-inverse">
                                <tr>
                                <th>Land Service</th>
                                <th>Transport</th>
                                <th>Route</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div id="append_hotel">
                                <tr>
                                <input type="hidden" name="service_type_id" id="service_type_id' . $append_count . '"/>
                                <td><select disabled style="width:100%;"  id="land_service' . $append_count . '" name="land_services[' . $append_count . '][legs_count][land_service][]" onchange="get_land_services_route(' . $append_count . ')" class="form-control select2' . $append_count . '" >
                                ' . $land_services_options . '
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][transport][]" id="transport' . $append_count . '" >
                                                        <option value="' . $land_services_d->transport . '">' . $transport_decode[$land_services_d->transport]->transport . '</option>
                                                        </select></td>
                                                        <td><select disabled style="width:100%;" class="form-control select2' . $append_count . '"  name="land_services[' . $append_count . '][legs_count][land_services_route][]" id="land_services_route' . $append_count . '" >
                                                        <option value="' . $get_routes->id_route . '">' . $get_routes->route_location . '</option>
                                                        </select></td>
                                                        </tr>
                                </div>
                            </tbody>
                        </table>
                        <table class="table table-striped mt-2 table-inverse table-responsive" >
                        <thead class="thead-inverse mt-2">
                            <tr>
                                <th>Cost Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div>
                                <tr>
                                <input type="hidden" id="land_services_adult_total_cost_price' . $append_count . '"  class="adult_cost_price_sum">
                                <td><input disabled value="' . $get_land_services_adult_cost_price . '" type="number" id="adult_land_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][legs_count][land_services_adult_cost_price][]" class="form-control adult_land_services_sum_cost_price' . $append_count . '"></td>
                                </tr>
                            </div>
                        </tbody>
                    </table>';
                            }
                            // dd($addon_options);
                            $data .= '<div id="land_services_table' . $append_count . '" class="row"><h4 class="mt-2">Add Land Services Details</h4><div class="col-md-12" style="border:2px solid lightgrey;" >
                    <div id="append_land_services_legs' . $append_count . '"></div>
                    ' . $land_legs . '
                        <table class="table table-striped table-inverse table-responsive">
                        <thead class="thead-inverse">
                            <tr>
                            <th>Total Cost Price</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th id="land_services_exchange_head' . $append_count . '">Exchange</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div>
                                <tr>
                                    <input type="hidden" id="land_services_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_service_id][]">
                                    <input type="hidden" id="land_services_sub_service_id' . $append_count . '" name="land_services[' . $append_count . '][land_services_sub_service_id][]">
                                    <input type="hidden" id="land_services_currency_name' . $append_count . '" name="land_services[' . $append_count . '][land_services_currency_name][]">
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_total_cost_price . '" type="number" id="land_services_total_cost_price' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_sub_total][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_discount . '" type="number" id="land_services_discount' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_discount][]" class="form-control"></td>
                                    <td><input disabled value="' . $land_services_sub_total_details_decode[0]->land_services_total_cost_price . '" type="number" id="land_services_total' . $append_count . '" onchange="land_services_calculate(' . $legs_count . ',' . $append_count . ',' . $service_type_no . ')" name="land_services[' . $append_count . '][land_services_total][]" class="form-control"></td>
                                    <td><select disabled name="land_services[' . $append_count . '][land_services_currency][]"   onchange="onchange_get_curr_data_land_services(' . $append_count . ')" id="land_services_currency' . $append_count . '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' . $currency_rate_options . ' </select></td>
                                </tr>
                            </div>
                        </tbody>
                        </table>
                    </div></div>
                ';
                        }
                    }
                }
            }
        }
        $lum_sum = null;
        // dd($visa_adult_cost_price);
        if (!isset($visa_adult_cost_price)) {
            $visa_adult_cost_price = 0;
            $visa_adult_selling_price = 0;
        }
        if (!isset($airline_adult_cost_price)) {
            $airline_adult_cost_price = 0;
            $airline_adult_selling_price = 0;
        }
        if (!isset($get_hotel_adult_cost_price)) {
            $get_hotel_adult_cost_price = 0;
            $get_hotel_adult_selling_price = 0;
            $count_of_legs_hotel = 0;
        }
        if (!isset($get_land_services_adult_cost_price)) {
            $get_land_services_adult_cost_price = 0;
            $get_land_services_adult_selling_price = 0;
            $count_of_legs_land_services = 0;
        }

        if (!isset($visa_children_cost_price)) {
            $visa_children_cost_price = 0;
            $visa_children_selling_price = 0;
        }
        if (!isset($airline_children_cost_price)) {
            $airline_children_cost_price = 0;
            $airline_children_selling_price = 0;
        }
        if (!isset($get_hotel_children_cost_price)) {
            $get_hotel_children_cost_price = 0;
            $get_hotel_children_selling_price = 0;
            $count_of_legs_hotel = 0;
        }
        if (!isset($get_land_services_children_cost_price)) {
            $get_land_services_children_cost_price = 0;
            $get_land_services_children_selling_price = 0;
            $count_of_legs_land_services = 0;
        }


        if (!isset($visa_infant_cost_price)) {
            $visa_infant_cost_price = 0;
            $visa_infant_selling_price = 0;
        }
        if (!isset($airline_infant_cost_price)) {
            $airline_infant_cost_price = 0;
            $airline_infant_selling_price = 0;
        }
        if (!isset($get_hotel_infant_cost_price)) {
            $get_hotel_infant_cost_price = 0;
            $get_hotel_infant_selling_price = 0;
            $count_of_legs_hotel = 0;
        }
        if (!isset($get_land_services_infant_cost_price)) {
            $get_land_services_infant_cost_price = 0;
            $get_land_services_infant_selling_price = 0;
            $count_of_legs_land_services = 0;
        }


        if ($get_q_d->type == "service_level" && $service_type == "no_of_person") {

            // dd('sdsd');

            $adult_cost_price_person = round(($visa_adult_cost_price + $airline_adult_cost_price + ($get_hotel_adult_cost_price * $count_of_legs_hotel) + ($get_land_services_adult_cost_price * $count_of_legs_land_services)) * $no_of_adult);
            $children_cost_price_person = round(($visa_children_cost_price + $airline_children_cost_price + ($get_hotel_children_cost_price * $count_of_legs_hotel) + ($get_land_services_children_cost_price * $count_of_legs_land_services)) * $no_of_children);
            $infant_cost_price_person = round(($visa_infant_cost_price + $airline_infant_cost_price + ($get_hotel_infant_cost_price * $count_of_legs_hotel) + ($get_land_services_infant_cost_price * $count_of_legs_land_services)) * $no_of_infant);

            $adult_selling_price_person = round(($visa_adult_selling_price + $airline_adult_selling_price + ($get_hotel_adult_selling_price * $count_of_legs_hotel) + ($get_land_services_adult_selling_price * $count_of_legs_land_services)) * $no_of_adult);
            $children_selling_price_person = round(($visa_children_selling_price + $airline_children_selling_price + ($get_hotel_children_selling_price * $count_of_legs_hotel) + ($get_land_services_children_selling_price * $count_of_legs_land_services)) * $no_of_children);
            $infant_selling_price_person = round(($visa_infant_selling_price + $airline_infant_selling_price + ($get_hotel_infant_selling_price * $count_of_legs_hotel) + ($get_land_services_infant_selling_price * $count_of_legs_land_services)) * $no_of_infant);
            // $adult_cost_price_person = $adult_cost_price;
            // dd($adult_cost_price_person);
            // $children_cost_price_person = $children_cost_price;
            // $infant_cost_price_person = $infant_cost_price;
            // dd($children_cost_price_person);
            $adult_profit_price_person = $adult_selling_price_person - $adult_cost_price_person;
            $children_profit_price_person = $children_selling_price_person - $adult_cost_price_person;
            $infant_profit_price_person = $infant_selling_price_person - $infant_cost_price_person;
            // dd($adult_selling_price);
            $grand_total = $adult_selling_price_person + $children_selling_price_person + $infant_selling_price_person;

            // $cost_selling_person = $total_selling_price / 3;
            // $cost_profit_person = $cost_selling_person - $cost_price_person;
        }
        if ($get_q_d->type == "service_level" && $service_type == "lum_sum") {
            $adult_cost_price_person = round(($visa_adult_cost_price + $airline_adult_cost_price + ($get_hotel_adult_cost_price * $count_of_legs_hotel) + ($get_land_services_adult_cost_price * $count_of_legs_land_services)) * $no_of_adult);
            $children_cost_price_person = round(($visa_children_cost_price + $airline_children_cost_price + ($get_hotel_children_cost_price * $count_of_legs_hotel) + ($get_land_services_children_cost_price * $count_of_legs_land_services)) * $no_of_children);
            $infant_cost_price_person = round(($visa_infant_cost_price + $airline_infant_cost_price + ($get_hotel_infant_cost_price * $count_of_legs_hotel) + ($get_land_services_infant_cost_price * $count_of_legs_land_services)) * $no_of_infant);

            $adult_selling_price_person = round(($visa_adult_selling_price + $airline_adult_selling_price + ($get_hotel_adult_selling_price * $count_of_legs_hotel) + ($get_land_services_adult_selling_price * $count_of_legs_land_services)) * $no_of_adult);
            $children_selling_price_person = round(($visa_children_selling_price + $airline_children_selling_price + ($get_hotel_children_selling_price * $count_of_legs_hotel) + ($get_land_services_children_selling_price * $count_of_legs_land_services)) * $no_of_children);
            $infant_selling_price_person = round(($visa_infant_selling_price + $airline_infant_selling_price + ($get_hotel_infant_selling_price * $count_of_legs_hotel) + ($get_land_services_infant_selling_price * $count_of_legs_land_services)) * $no_of_infant);
            // $adult_cost_price_person = $adult_cost_price;
            // dd($adult_cost_price_person);
            // $children_cost_price_person = $children_cost_price;
            // $infant_cost_price_person = $infant_cost_price;
            // dd($children_cost_price_person);
            $adult_profit_price_person = $adult_selling_price_person - $adult_cost_price_person;
            $children_profit_price_person = $children_selling_price_person - $adult_cost_price_person;
            $infant_profit_price_person = $infant_selling_price_person - $infant_cost_price_person;

            $lum_sum_profit = $adult_profit_price_person + $children_profit_price_person + $infant_profit_price_person;
            // dd($adult_selling_price);
            $grand_total = $adult_selling_price_person + $children_selling_price_person + $infant_selling_price_person;

            // $cost_selling_person = $total_selling_price / 3;
            // $cost_profit_person = $cost_selling_person - $cost_price_person;
        }
        if ($get_q_d->type == "lum_sum" && $service_type == "no_of_person") {



            $adult_cost_price_person = round((($visa_adult_cost_price * $no_of_adult) + ($airline_adult_cost_price * $no_of_adult) + ($get_hotel_adult_cost_price) + ($get_land_services_adult_cost_price * $no_of_adult)));
            $children_cost_price_person = round(($visa_children_cost_price * $no_of_children + $airline_children_cost_price + ($get_hotel_children_cost_price) + ($get_land_services_children_cost_price)));
            $infant_cost_price_person = round(($visa_infant_cost_price * $no_of_infant + $airline_infant_cost_price + ($get_hotel_infant_cost_price) + ($get_land_services_infant_cost_price)));
            // dd('sds');

            $decode_details = json_decode($get_q_d->sub_total_details);
            if (isset($decode_details[0]->lum_sum_profit)) {
                $prof = $decode_details[0]->lum_sum_profit;
            } else {
                $decode_details = json_decode($get_q_d->person_pricing_details);
                $prof = $decode_details[0]->lum_sum_profit;
            }

            $lum_sum_divide = $prof / 3;
            $adult_profit_price_person = $lum_sum_divide;
            $children_profit_price_person =  $lum_sum_divide;
            $infant_profit_price_person =   $lum_sum_divide;

            $lum_sum_profit = $adult_profit_price_person + $children_profit_price_person + $infant_profit_price_person;
            // dd($decode_details);
            $adult_selling_price_person = $adult_cost_price_person + $lum_sum_profit;
            $children_selling_price_person = $children_cost_price_person + $lum_sum_profit;
            $infant_selling_price_person = $infant_cost_price_person + $lum_sum_profit;

            // dd($adult_selling_price);
            $grand_total = $adult_selling_price_person + $children_selling_price_person + $infant_selling_price_person;


            // $cost_selling_person = $total_selling_price / 3;
            // $cost_profit_person = $cost_selling_person - $cost_price_person;
        }
        if ($get_q_d->type == "no_of_person" && $service_type == "lum_sum") {



            $adult_cost_price_person = round((($visa_adult_cost_price * $no_of_adult) + ($airline_adult_cost_price * $no_of_adult) + ($get_hotel_adult_cost_price) + ($get_land_services_adult_cost_price * $no_of_adult)));
            $children_cost_price_person = round(($visa_children_cost_price + $airline_children_cost_price + ($get_hotel_children_cost_price) + ($get_land_services_children_cost_price)));
            $infant_cost_price_person = round(($visa_infant_cost_price + $airline_infant_cost_price + ($get_hotel_infant_cost_price) + ($get_land_services_infant_cost_price)));

            // dd($airline_adult_cost_price);

            $decode_details = json_decode($get_q_d->sub_total_details);
            $adult_profit_price_person = $decode_details[0]->no_of_person_adult_profit;
            $children_profit_price_person =  $decode_details[0]->no_of_person_children_profit;
            $infant_profit_price_person =   $decode_details[0]->no_of_person_infant_profit;

            $lum_sum_profit = $adult_profit_price_person + $children_profit_price_person + $infant_profit_price_person;
            // dd($decode_details);
            $adult_selling_price_person = $adult_cost_price_person + $lum_sum_profit;
            $children_selling_price_person = $children_cost_price_person + $lum_sum_profit;
            $infant_selling_price_person = $infant_cost_price_person + $lum_sum_profit;

            // dd($adult_selling_price);
            $grand_total = $adult_selling_price_person + $children_selling_price_person + $infant_selling_price_person;


            // $cost_selling_person = $total_selling_price / 3;
            // $cost_profit_person = $cost_selling_person - $cost_price_person;
        }

        if (request()->service_type == "lum_sum") {
        }
        if ($service_type == 'lum_sum' && $append_count == 0) {
            $lum_sum = '<div class="row" id="visa_table' . $append_count . '"><h4 class="mt-2">Add Lum Sum Profit</h4><div class="col-md-12" style="border:2px solid lightgrey;" >
            <div class="row">
            <div class="col-md-11">
            <table class="table table-striped mt-2 table-inverse table-responsive">
                <thead class="thead-inverse mt-2">
                    <tr>
                    <th style="width:200px;">Adult Total Cost Price</th>
                    <th style="width:44%;"></th>
                    <th></th>
                    <th></th>
                    <th>Adult Selling Price</th>
                    </tr>
                </thead>
                <tbody>
                    <div id="append_hotel">
                        <tr>
                            <td class="text-center"><input value="' . $adult_cost_price_person . '" onchange="get_profit_calculation()" style="background: transparent;border: none;" value="0" type="text" readonly    name="lum_sum_adult_total_cost_price" id="adult_total_cost_price_all_sum" class="form-control"></td>
                            <td></td>
                            <td><input  type="number"  class="d-none" onchange="get_profit_calculation()" style="width:40%;"  name="lum_sum_selling_price" id="visa_selling_price' . $append_count . '" class="form-control"></td>
                            <td class="text-center"></td>
                            <td><input value="' . $adult_selling_price_person . '" onchange="get_profit_calculation()" style="background: transparent;border: none;" value="0" type="text" readonly    name="lum_sum_adult_total_selling_price" id="adult_selling_price" class="form-control"></td>
                            </tr>
                    </div>
                </tbody>
            </table>
            <table class="table table-striped mt-2 table-inverse table-responsive">
            <thead class="thead-inverse mt-2">
                <tr>
                <th style="width:200px;">Children Total Cost Price</th>
                <th></th>
                <th>Profit</th>
                <th></th>
                <th>Children Selling Price</th>
                </tr>
            </thead>
            <tbody>
                <div id="append_hotel">
                    <tr>
                        <td class="text-center"><input value="' . $children_cost_price_person . '" onchange="get_profit_calculation()" style="background: transparent;border: none;" value="0" type="text" readonly    name="lum_sum_children_total_cost_price" id="children_total_cost_price_all_sum" class="form-control"></td>
                        <td></td>
                        <td><input  type="number" disabled value="0"  onchange="get_profit_calculation()"   name="lum_sum_profit" id="lum_sum_profit" class="form-control"></td>
                        <td class="text-center"></td>
                        <td><input value="' . $children_selling_price_person . '" onchange="get_profit_calculation()" style="background: transparent;border: none;" value="0" type="text" readonly    name="lum_sum_children_total_selling_price" id="children_selling_price" class="form-control"></td>
                        </tr>
                </div>
            </tbody>
        </table>
        <table class="table table-striped mt-2 table-inverse table-responsive">
        <thead class="thead-inverse mt-2">
            <tr>
            <th style="width:200px;">Infant Total Cost Price</th>
            <th></th>
            <th style="width:42.5%;"></th>
            <th></th>
            <th>Infant Selling Price</th>
            </tr>
        </thead>
        <tbody>
            <div id="append_hotel">
                <tr>
                    <td class="text-center"><input value="' . $infant_cost_price_person . '" onchange="get_profit_calculation()" style="background: transparent;border: none;" value="0" type="text" readonly    name="lum_sum_infant_total_cost_price" id="infant_total_cost_price_all_sum" class="form-control"></td>
                    <td></td>
                    <td><input type="number" onchange="get_profit_calculation()" class="d-none "  name="lum_sum_selling_price" id="visa_selling_price' . $append_count . '" class="form-control"></td>
                    <td class="text-center"></td>
                    <td><input value="' . $infant_selling_price_person . '" onchange="get_profit_calculation()" style="background: transparent;border: none;" value="0" type="text" readonly    name="lum_sum_infant_total_selling_price" id="infant_selling_price" class="form-control"></td>
                    </tr>
            </div>
        </tbody>
    </table>
        </div>
            <div style="display:flex;justify-content:center;align-items:center;"  class="col-md-1">
       <div class="row">
       <input type="hidden" name="grand_total" value="' . $grand_total . '" id="grand_total">
       <div class="col-md-12"><h5 style="color:grey;">Grand Total</h5></div>
       <div class="col-md-12 text-success"><h3 id="grand_total_html">' . $grand_total . '</h3></div>
       </div>

            </div>
            </div></div>
        ';
        } elseif ($service_type == 'no_of_person' && $append_count == 0) {
            $lum_sum = '<div class="row" id="visa_table' . $append_count . '"><h4 class="mt-2">Add Profit According To (Adults|Children|Infants)</h4><div class="col-md-12" style="border:2px solid lightgrey;">
            <div class="row">
            <div class="col-md-11">
            <table class="table table-striped mt-2 table-inverse table-responsive">
                <thead class="thead-inverse mt-2">
                    <tr>
                    <th style="width:200px;">Adult Total Cost Price</th>
                    <th></th>
                    <th>Adult Profit</th>
                    <th></th>
                    <th>Adult Selling Price</th>
                    </tr>
                </thead>
                <tbody>
                    <div id="append_hotel">
                        <tr>
                        <td class="text-center"><input disabled value="' . $adult_cost_price_person . '" onchange="get_profit_calculation()" style="background: transparent;border: none;" value="0" type="text" readonly    name="no_of_person_adult_total_cost_price" id="adult_total_cost_price_all_sum" class="form-control"></td>
                            <td>+</td>
                            <td><input  disabled type="number" value="' . $adult_profit_price_person . '" onchange="get_profit_calculation()"  name="no_of_person_adult_profit" id="adult_profit" class="form-control"></td>
                            <td class="text-center">=</td>
                            <td class="text-center"><input disabled value="' . $adult_selling_price_person . '" onchange="get_profit_calculation()" style="background: transparent;border: none;" value="0" type="text" readonly    name="no_of_person_adult_selling_price" id="adult_selling_price" class="form-control"></td>
                            </tr>
                    </div>
                </tbody>
            </table>
            <table class="table table-striped mt-2 table-inverse table-responsive">
            <thead class="thead-inverse mt-2">
                <tr>
                <th style="width:200px;">Children Total Cost Price</th>
                <th></th>
                <th>Children Profit</th>
                <th></th>
                <th>ChildrenSelling Price</th>
                </tr>
            </thead>
            <tbody>
                <div id="append_hotel">
                    <tr>
                    <td class="text-center"><input disabled value="' . $children_cost_price_person . '" onchange="get_profit_calculation()" style="background: transparent;border: none;" value="0" type="text" readonly    name="no_of_person_children_total_cost_price" id="children_total_cost_price_all_sum" class="form-control"></td>
                        <td>+</td>
                        <td><input  type="number" disabled value="0" onchange="get_profit_calculation()"  name="no_of_person_children_profit" id="children_profit" class="form-control"></td>
                        <td class="text-center">=</td>
                        <td class="text-center"><input disabled value="0" onchange="get_profit_calculation()" style="background: transparent;border: none;" value="0" type="text" readonly    name="no_of_person_children_selling_price" id="children_selling_price" class="form-control"></td>
                        </tr>
                </div>
            </tbody>
        </table>
        <table class="table table-striped mt-2 table-inverse table-responsive">
        <thead class="thead-inverse mt-2">
            <tr>
            <th style="width:200px;">Infant Total Cost Price</th>
            <th></th>
            <th>Infant Profit</th>
            <th></th>
            <th>Infant Selling Price</th>
            </tr>
        </thead>
        <tbody>
            <div id="append_hotel">
                <tr>
                <td class="text-center"><input disabled value="' . $infant_cost_price_person . '" onchange="get_profit_calculation()" style="background: transparent;border: none;" value="0" type="text" readonly    name="no_of_person_infant_total_cost_price" id="infant_total_cost_price_all_sum" class="form-control"></td>
                    <td>+</td>
                    <td><input  type="number" disabled value="0" onchange="get_profit_calculation()" name="no_of_person_infant_profit" id="infant_profit" class="form-control"></td>
                    <td class="text-center">=</td>
                    <td class="text-center"><input disabled value="0" onchange="get_profit_calculation()" style="background: transparent;border: none;" value="0" type="text" readonly    name="no_of_person_infant_selling_price" id="infant_selling_price" class="form-control"></td>
                    </tr>
            </div>
        </tbody>
    </table>
        </div>
            <div style="display:flex;justify-content:center;align-items:center;"  class="col-md-1">
       <div class="row">
       <input type="hidden" name="grand_total" value="' . $grand_total . '" id="grand_total">
       <div class="col-md-12"><h5 style="color:grey;">Grand Total</h5></div>
       <div class="col-md-12 text-success"><h3 id="grand_total_html">' . $grand_total . '</h3></div>
       </div>
            </div>
            </div></div>
        ';
        } else {
            if ($get_q_d->type == "lum_sum" && $service_type == "service_level") {
                $lum_sum = '<div class="row" id="visa_table' . $append_count . '"><h4 class="mt-2">Sub Total Details</h4><div class="col-md-12" style="border:2px solid lightgrey;" >
    <div class="row">
    <div class="col-md-11">
<table class="table table-striped mt-2 table-inverse table-responsive">
<thead class="thead-inverse mt-2">
    <tr>
    <th style="width:200px;"> Total Cost Price</th>
    <th></th>
    <th></th>
    <th> Selling Price</th>
    </tr>
</thead>
<tbody>
    <div id="append_hotel">
        <tr>
        <td class="text-center"><input value="' . $total_cost_price_sl . '" onchange="get_profit_calculation()" style="background: transparent;border: none;" value="0" type="text" readonly    name="no_of_person_infant_total_cost_price" id="total_cost_price_sl" class="form-control"></td>
        <td></td>
        <td></td>
        <td class="text-center"><input value="' . $total_cost_price_sl + $total_selling_price_sl . '" onchange="get_profit_calculation()" style="background: transparent;border: none;" value="0" type="text" readonly    name="no_of_person_infant_selling_price" id="total_selling_price_sl" class="form-control"></td>
        </tr>
    </div>
</tbody>
</table>
</div>
    <div style="display:flex;justify-content:center;align-items:center;"  class="col-md-1">
<div class="row">
<input type="hidden" name="grand_total" value="' . $total_cost_price_sl + $total_selling_price_sl . '" id="grand_total">
<div class="col-md-12"><h5 style="color:grey;">Grand Total</h5></div>
<div class="col-md-12 text-success"><h3 id="grand_total_html">' . $total_cost_price_sl + $total_selling_price_sl . '</h3></div>
</div>

    </div>
    </div></div>
';
            } else {
                $lum_sum = '<div class="row" id="visa_table' . $append_count . '"><h4 class="mt-2">Sub Total Details</h4><div class="col-md-12" style="border:2px solid lightgrey;" >
    <div class="row">
    <div class="col-md-11">
<table class="table table-striped mt-2 table-inverse table-responsive">
<thead class="thead-inverse mt-2">
    <tr>
    <th style="width:200px;"> Total Cost Price</th>
    <th></th>
    <th></th>
    <th> Selling Price</th>
    </tr>
</thead>
<tbody>
    <div id="append_hotel">
        <tr>
        <td class="text-center"><input value="' . $total_cost_price_sl . '" onchange="get_profit_calculation()" style="background: transparent;border: none;" value="0" type="text" readonly    name="no_of_person_infant_total_cost_price" id="total_cost_price_sl" class="form-control"></td>
        <td></td>
        <td></td>
        <td class="text-center"><input value="' . $total_selling_price_sl . '" onchange="get_profit_calculation()" style="background: transparent;border: none;" value="0" type="text" readonly    name="no_of_person_infant_selling_price" id="total_selling_price_sl" class="form-control"></td>
        </tr>
    </div>
</tbody>
</table>
</div>
    <div style="display:flex;justify-content:center;align-items:center;"  class="col-md-1">
<div class="row">
<input type="hidden" name="grand_total" value="' . $total_selling_price_sl . '" id="grand_total">
<div class="col-md-12"><h5 style="color:grey;">Grand Total</h5></div>
<div class="col-md-12 text-success"><h3 id="grand_total_html">' . $total_selling_price_sl . '</h3></div>
</div>

    </div>
    </div></div>
';
            }
        }
        return response()->json([
            'data' => $data,
            'lum_sum' => $lum_sum,
            // 'sub_service_name' => "Visa"
        ]);
    }


    public function store(Request $request)
    {
        $all_services_entries = [];
        $get_q_details_id = [];
        $no_of_persons_entries = [];
        $sub_total_details = [];
        // dd($request);
        $dec_q_id = Crypt::encrypt($request->inq_id);
        $get_max_num_detail = quotations_detail::max('id_quotation_details');
        // dd($request);
        if ($get_max_num_detail >= 1) {
            $get_max_num_detail = $get_max_num_detail + 1;
        } else {
            $get_max_num_detail = 1;
        }
        if (isset($request->hotel)) {
            $services_for = "Hotel";
            $all_services_entries[] = [
                'sub_service_for' => "Hotel",
                'services_id' => $request->hotel_service_id,
                'sub_services_id' => $request->hotel_sub_service_id,
            ];
            // dd($request);
            $all_entries = [];
            $no_of_persons_entries = [];
            $sub_total_details = [];
            foreach ($request->hotel as $key => $value_hotel) {
                // dd($value_hotel['hotel_addon']);
                if ($request->service_type == "service_level" || $request->service_type == "no_of_person" || $request->service_type == "lum_sum") {
                    // dd($value_hotel['legs_count']);
                    $size_of_airline = sizeof($value_hotel['legs_count']['hotel_name']);
                    for ($i = 0; $i < $size_of_airline; $i++) {
                        // dd($value_hotel);
                        if ($request->service_type == 'service_level') {
                            $all_entries[] = [
                                'hotel_name' => $value_hotel['legs_count']['hotel_name'][$i],
                                'hotel_inv_id' => isset($value_hotel['legs_count']['hotel_inv_id'][$i]) ? $value_hotel['legs_count']['hotel_inv_id'][$i] : "",
                                'room_type' => $value_hotel['legs_count']['room_type'][$i],
                                'hotel_addon' => isset($value_hotel['legs_count']['hotel_addon'][$i]) ? $value_hotel['legs_count']['hotel_addon'][$i] : "",
                                'hotel_check_in' => $value_hotel['legs_count']['hotel_check_in'][$i],
                                'hotel_nights' => $value_hotel['legs_count']['hotel_nights'][$i],
                                'hotel_check_out' => $value_hotel['legs_count']['hotel_check_out'][$i],

                            ];
                            $no_of_persons_entries[] = [
                                'hotel_qty' => $value_hotel['legs_count']['hotel_qty'][$i],
                                'hotel_cost_price' => $value_hotel['legs_count']['hotel_cost_price'][$i],
                                'hotel_selling_price' => $value_hotel['legs_count']['hotel_selling_price'][$i],
                            ];
                        } elseif ($request->service_type == "no_of_person") {
                            $all_entries[] = [
                                'hotel_name' => $value_hotel['legs_count']['hotel_name'][$i],
                                'hotel_inv_id' => isset($value_hotel['legs_count']['hotel_inv_id'][$i]) ? $value_hotel['legs_count']['hotel_inv_id'][$i] : "",
                                'room_type' => $value_hotel['legs_count']['room_type'][$i],
                                'hotel_addon' => isset($value_hotel['legs_count']['hotel_addon'][$i]) ? $value_hotel['legs_count']['hotel_addon'][$i] : "",
                                'hotel_check_in' => $value_hotel['legs_count']['hotel_check_in'][$i],
                                'hotel_check_out' => $value_hotel['legs_count']['hotel_check_out'][$i],
                            ];
                            $no_of_persons_entries[] = [
                                'hotel_adult_cost_price' => $value_hotel['legs_count']['hotel_adult_cost_price'][$i],
                                'hotel_children_cost_price' => isset($value_hotel['legs_count']['hotel_children_cost_price'][$i]) ? $value_hotel['legs_count']['hotel_children_cost_price'][$i] : "",
                                'hotel_infant_cost_price' => isset($value_hotel['legs_count']['hotel_infant_cost_price'][$i]) ? $value_hotel['legs_count']['hotel_infant_cost_price'][$i] : "",
                                'hotel_nights' => $value_hotel['legs_count']['hotel_nights'][$i],
                                'hotel_qty' => $value_hotel['legs_count']['hotel_qty'][$i],
                            ];
                        } else {
                            $all_entries[] = [
                                'hotel_name' => $value_hotel['legs_count']['hotel_name'][$i],
                                'hotel_inv_id' => $value_hotel['legs_count']['hotel_inv_id'][$i],
                                'room_type' => $value_hotel['legs_count']['room_type'][$i],
                                'hotel_addon' => isset($value_hotel['legs_count']['hotel_addon'][$i]) ? $value_hotel['legs_count']['hotel_addon'][$i] : "",
                                'hotel_check_in' => $value_hotel['legs_count']['hotel_check_in'][$i],
                                'hotel_check_out' => $value_hotel['legs_count']['hotel_check_out'][$i],
                            ];
                            $no_of_persons_entries[] = [
                                'hotel_adult_cost_price' => $value_hotel['legs_count']['hotel_adult_cost_price'][$i],
                                'hotel_children_cost_price' => isset($value_hotel['legs_count']['hotel_children_cost_price'][$i]) ? $value_hotel['legs_count']['hotel_children_cost_price'][$i] : "",
                                'hotel_infant_cost_price' => isset($value_hotel['legs_count']['hotel_infant_cost_price'][$i]) ? $value_hotel['legs_count']['hotel_infant_cost_price'][$i] : "",
                                'hotel_nights' => $value_hotel['legs_count']['hotel_nights'][$i],
                                'hotel_qty' => $value_hotel['legs_count']['hotel_qty'][$i],
                            ];
                        }
                    }
                }
                // dd($request);
                // dd($all_entries);
                if ($request->service_type == 'lum_sum') {
                    $sub_total_details[] = [
                        'hotel_service_id' => $value_hotel['hotel_service_id'][0],
                        'hotel_sub_service_id' => $value_hotel['hotel_sub_service_id'][0],
                        'hotel_currency_total' => $value_hotel['hotel_currency_total'][0],
                        'hotel_currency_name' => $value_hotel['hotel_currency_name'][0],
                        'hotel_total_cost_price' => $value_hotel['hotel_total_cost_price'][0],
                        'hotel_discount' => $value_hotel['hotel_discount'][0],
                        'hotel_total' => $value_hotel['hotel_total'][0],
                        'hotel_currency' => $value_hotel['hotel_currency'][0],
                        'lum_sum_adult_total_cost_price' => $request->lum_sum_adult_total_cost_price,
                        'lum_sum_children_total_cost_price' => $request->lum_sum_children_total_cost_price,
                        'lum_sum_infant_total_cost_price' => $request->lum_sum_infant_total_cost_price,
                        'lum_sum_adult_total_selling_price' => $request->lum_sum_adult_total_selling_price,
                        'lum_sum_children_total_selling_price' => $request->lum_sum_children_total_selling_price,
                        'lum_sum_infant_total_selling_price' => $request->lum_sum_infant_total_selling_price,
                        'grand_total' => $request->grand_total,
                        'lum_sum_profit' => $request->lum_sum_profit,
                    ];
                }
                if ($request->service_type == 'service_level') {
                    $sub_total_details[] = [
                        'hotel_service_id' => $value_hotel['hotel_service_id'][0],
                        'hotel_sub_service_id' => $value_hotel['hotel_sub_service_id'][0],
                        'hotel_currency_total' => $value_hotel['hotel_currency_total'][0],
                        'hotel_currency_name' => $value_hotel['hotel_currency_name'][0],
                        'hotel_total_cost_price' => $value_hotel['hotel_total_cost_price'][0],
                        'hotel_total_selling_price' => $value_hotel['hotel_total_selling_price'][0],
                        'hotel_discount' => $value_hotel['hotel_discount'][0],
                        'hotel_total' => $value_hotel['hotel_total'][0],
                        'hotel_currency' => $value_hotel['hotel_currency'][0],
                    ];
                }
                if ($request->service_type == 'no_of_person') {
                    $sub_total_details[] = [
                        'hotel_service_id' => $value_hotel['hotel_service_id'][0],
                        'hotel_sub_service_id' => $value_hotel['hotel_sub_service_id'][0],
                        'hotel_currency_total' => $value_hotel['hotel_currency_total'][0],
                        'hotel_currency_name' => $value_hotel['hotel_currency_name'][0],
                        'hotel_total_cost_price' => $value_hotel['hotel_total_cost_price'][0],
                        'hotel_discount' => $value_hotel['hotel_discount'][0],
                        'hotel_total' => $value_hotel['hotel_total'][0],
                        'hotel_currency' => $value_hotel['hotel_currency'][0],
                        'no_of_person_adult_profit' => $request->no_of_person_adult_profit,
                        'no_of_person_children_profit' => $request->no_of_person_children_profit,
                        'no_of_person_infant_profit' => $request->no_of_person_infant_profit,
                        'no_of_person_adult_selling_price' => $request->no_of_person_adult_selling_price,
                        'no_of_person_children_selling_price' => $request->no_of_person_children_selling_price,
                        'no_of_person_infant_selling_price' => $request->no_of_person_infant_selling_price,
                        'grand_total' => $request->grand_total,
                    ];
                }

                $store = new quotations_detail();
                $store->inquiry_id = $request->inq_id;
                $store->type = $request->service_type;
                $store->uniq_id = $get_max_num_detail;
                $store->services_type = $services_for;
                $store->all_entries = json_encode($all_entries);
                $store->person_pricing_details = json_encode($no_of_persons_entries);
                $store->sub_total_details = json_encode($sub_total_details);
                $store->services_id = $request->visa_service_id;
                $store->sub_services_id = $request->visa_sub_service_id;
                // $store->services_parent_type = $request->services_;
                if ($request->service_type == "lum_sum") {
                    $store->sub_total = $value_hotel['hotel_total_cost_price'][0];
                    $store->discount = $value_hotel['hotel_discount'][0];
                    $store->total = $request->grand_total;
                } elseif ($request->service_type == "no_of_person") {
                    $store->sub_total = $value_hotel['hotel_total_cost_price'][0];
                    $store->discount = $value_hotel['hotel_discount'][0];
                    $store->total = $request->grand_total;
                } else {
                    $store->sub_total = $value_hotel['hotel_total_selling_price'][0];
                    $store->discount = $value_hotel['hotel_discount'][0];
                    $store->total = $value_hotel['hotel_total'][0];
                }
                $store->save();
            }
        }
        if (isset($request->visa)) {
            $services_for = "Visa";
            $all_services_entries[] = [
                'sub_service_for' => "Visa",
                'services_id' => $request->visa_service_id,
                'sub_services_id' => $request->visa_sub_service_id,
            ];
            $all_entries = [];
            $no_of_persons_entries = [];
            $sub_total_details = [];

            foreach ($request->visa as $key => $value_visa) {
                // dd($value_hotel['hotel_addon']);
                if ($request->service_type == 'service_level') {
                    $all_entries[] = [
                        'visa_service' => $value_visa['visa_service'][0],
                    ];
                    $no_of_persons_entries[] = [
                        'visa_adult_cost_price' => $value_visa['visa_adult_cost_price'][0],
                        'visa_adult_selling_price' => $value_visa['visa_adult_selling_price'][0],
                        'visa_children_cost_price' => $value_visa['visa_children_cost_price'][0],
                        'visa_children_selling_price' => $value_visa['visa_children_selling_price'][0],
                        'visa_infant_cost_price' => $value_visa['visa_infant_cost_price'][0],
                        'visa_infant_selling_price' => $value_visa['visa_infant_selling_price'][0],
                    ];
                    $sub_total_details[] = [
                        'visa_total_cost_price' => $value_visa['visa_total_cost_price'][0],
                        'visa_total_selling_price' => $value_visa['visa_total_selling_price'][0],
                        'visa_discount' => $value_visa['visa_discount'][0],
                        'visa_total' => $value_visa['visa_total'][0],
                        'visa_currency' => $value_visa['visa_currency'][0],
                        'visa_currency_total' => $value_visa['visa_currency_total'][0],
                        'visa_currency_name' => $value_visa['visa_currency_name'][0],
                    ];
                } elseif ($request->service_type == "no_of_person") {

                    $all_entries[] = [
                        'visa_service' => $value_visa['visa_service'][0],
                    ];

                    $no_of_persons_entries[] = [
                        'visa_adult_cost_price' => $value_visa['visa_adult_cost_price'][0],
                        'visa_children_cost_price' => $value_visa['visa_children_cost_price'][0],
                        'visa_infant_cost_price' => $value_visa['visa_infant_cost_price'][0],
                        'visa_adult_total_cost_price' => $value_visa['visa_adult_total_cost_price'][0],
                        'visa_children_total_cost_price' => $value_visa['visa_children_total_cost_price'][0],
                        'visa_infant_total_cost_price' => $value_visa['visa_infant_total_cost_price'][0],
                        'no_of_person_adult_total_cost_price' => $request->no_of_person_adult_total_cost_price,
                        'no_of_person_children_total_cost_price' => $request->no_of_person_children_total_cost_price,
                        'no_of_person_infant_total_cost_price' => $request->no_of_person_infant_total_cost_price,
                    ];
                    $sub_total_details[] = [
                        'visa_total_cost_price' => $value_visa['visa_total_cost_price'][0],
                        'visa_discount' => $value_visa['visa_discount'][0],
                        'visa_total' => $value_visa['visa_total'][0],
                        'visa_currency' => $value_visa['visa_currency'][0],
                        'visa_currency_total' => $value_visa['visa_currency_total'][0],
                        'visa_currency_name' => $value_visa['visa_currency_name'][0],
                        'no_of_person_adult_profit' => $request->no_of_person_adult_profit,
                        'no_of_person_children_profit' => $request->no_of_person_children_profit,
                        'no_of_person_infant_profit' => $request->no_of_person_infant_profit,
                        'no_of_person_adult_selling_price' => $request->no_of_person_adult_selling_price,
                        'no_of_person_children_selling_price' => $request->no_of_person_children_selling_price,
                        'no_of_person_infant_selling_price' => $request->no_of_person_infant_selling_price,
                        'grand_total' => $request->grand_total,
                    ];
                } else {
                    $all_entries[] = [
                        'visa_service' => $value_visa['visa_service'][0],
                    ];

                    $no_of_persons_entries[] = [
                        'visa_adult_cost_price' => $value_visa['visa_adult_cost_price'][0],
                        'visa_children_cost_price' => $value_visa['visa_children_cost_price'][0],
                        'visa_infant_cost_price' => $value_visa['visa_infant_cost_price'][0],
                        'visa_adult_total_cost_price' => $value_visa['visa_adult_total_cost_price'][0],
                        'visa_children_total_cost_price' => $value_visa['visa_children_total_cost_price'][0],
                        'visa_infant_total_cost_price' => $value_visa['visa_infant_total_cost_price'][0],
                        'lum_sum_adult_total_cost_price' => $request->lum_sum_adult_total_cost_price,
                        'lum_sum_children_total_cost_price' => $request->lum_sum_children_total_cost_price,
                        'lum_sum_infant_total_cost_price' => $request->lum_sum_infant_total_cost_price,
                        'lum_sum_adult_total_selling_price' => $request->lum_sum_adult_total_selling_price,
                        'lum_sum_children_total_selling_price' => $request->lum_sum_children_total_selling_price,
                        'lum_sum_infant_total_selling_price' => $request->lum_sum_infant_total_selling_price,
                        'lum_sum_profit' => $request->lum_sum_profit,
                        'grand_total' => $request->grand_total,

                    ];
                    $sub_total_details[] = [
                        'visa_total_cost_price' => $value_visa['visa_total_cost_price'][0],
                        'visa_discount' => $value_visa['visa_discount'][0],
                        'visa_total' => $value_visa['visa_total'][0],
                        'visa_currency' => $value_visa['visa_currency'][0],
                        'visa_currency_total' => $value_visa['visa_currency_total'][0],
                        'visa_currency_name' => $value_visa['visa_currency_name'][0],
                    ];
                }

                $store = new quotations_detail();
                $store->inquiry_id = $request->inq_id;
                $store->type = $request->service_type;
                $store->uniq_id = $get_max_num_detail;
                $store->services_type = $services_for;
                $store->all_entries = json_encode($all_entries);
                $store->person_pricing_details = json_encode($no_of_persons_entries);
                $store->sub_total_details = json_encode($sub_total_details);
                $store->services_id = $value_visa['visa_service_id'][0];
                $store->sub_services_id = $value_visa['visa_sub_service_id'][0];
                if ($request->service_type == "lum_sum") {
                    $store->sub_total = $value_visa['visa_total_cost_price'][0];
                    $store->total = $request->grand_total;
                } elseif ($request->service_type == "no_of_person") {
                    $store->sub_total = $value_visa['visa_total_cost_price'][0];
                    $store->discount = isset($value_visa['visa_discount'][0]) ? $value_visa['visa_discount'][0] : null;
                    $store->total = $request->grand_total;
                } else {
                    $store->sub_total = isset($value_visa['visa_total_selling_price'][0]) ? $value_visa['visa_total_selling_price'][0] : null;
                    $store->discount = isset($value_visa['visa_discount'][0]) ? $value_visa['visa_discount'][0] : null;
                    $store->total = isset($value_visa['visa_total'][0]) ? $value_visa['visa_total'][0] : null;
                }

                $store->save();
            }
        }
        if (isset($request->air_ticket) && isset($request->airline_services) && $request->airline_services[0] != null) {
            $services_for = "Air Ticket";
            // dd($request);
            $all_services_entries[] = [
                'sub_service_for' => "Air Ticket",
                'services_id' => $request->airline_service_id,
                'sub_services_id' => $request->airline_sub_service_id,
            ];
            $all_entries = [];
            $no_of_persons_entries = [];
            $sub_total_details = [];
            foreach ($request->air_ticket as $key => $value_airline) {
                // dd($value_airline);
                $size_of_airline = sizeof($value_airline['legs_count']['airline_name']);
                // dd($size_of_airline);
                for ($i = 0; $i < $size_of_airline; $i++) {
                    if ($request->service_type == 'service_level') {
                        $all_entries[] = [
                            'airline_name' => $value_airline['legs_count']['airline_name'][$i],
                            'airline_inv_id' => $value_airline['legs_count']['airline_inv_id'][$i],
                            'flight_number' => $value_airline['legs_count']['flight_number'][$i],
                            'airline_arrival_date' => $value_airline['legs_count']['airline_arrival_date'][$i],
                            'airline_arrival_destination' => $value_airline['legs_count']['airline_arrival_destination'][$i],
                            'airline_departure_destination' => $value_airline['legs_count']['airline_departure_destination'][$i],
                            'arrival_time' => $value_airline['legs_count']['arrival_time'][$i],
                            'departure_time' => $value_airline['legs_count']['departure_time'][$i],
                            'airline_flight_class' => $value_airline['legs_count']['airline_flight_class'][$i],
                        ];
                    } elseif ($request->service_type == "no_of_person") {
                        // dd($value_airline['legs_count']['airline_name'][$i]);
                        $all_entries[] = [
                            'airline_name' => $value_airline['legs_count']['airline_name'][$i],
                            'airline_inv_id' => $value_airline['legs_count']['airline_inv_id'][$i],
                            'flight_number' => $value_airline['legs_count']['flight_number'][$i],
                            'airline_arrival_date' => $value_airline['legs_count']['airline_arrival_date'][$i],
                            'airline_arrival_destination' => $value_airline['legs_count']['airline_arrival_destination'][$i],
                            'airline_departure_destination' => $value_airline['legs_count']['airline_departure_destination'][$i],
                            'arrival_time' => $value_airline['legs_count']['arrival_time'][$i],
                            'departure_time' => $value_airline['legs_count']['departure_time'][$i],
                            'airline_flight_class' => $value_airline['legs_count']['airline_flight_class'][$i],
                        ];
                    } else {
                        $all_entries[] = [
                            'airline_name' => $value_airline['legs_count']['airline_name'][$i],
                            'airline_inv_id' => $value_airline['legs_count']['airline_inv_id'][$i],
                            'flight_number' => $value_airline['legs_count']['flight_number'][$i],
                            'airline_arrival_date' => $value_airline['legs_count']['airline_arrival_date'][$i],
                            'airline_arrival_destination' => $value_airline['legs_count']['airline_arrival_destination'][$i],
                            'airline_departure_destination' => $value_airline['legs_count']['airline_departure_destination'][$i],
                            'arrival_time' => $value_airline['legs_count']['arrival_time'][$i],
                            'departure_time' => $value_airline['legs_count']['departure_time'][$i],
                            'airline_flight_class' => $value_airline['legs_count']['airline_flight_class'][$i],
                        ];
                    }
                }

                if ($request->service_type == 'service_level') {
                    $sub_total_details[] = [
                        'airline_adult_cost_price' => $value_airline['airline_adult_cost_price'][0],
                        'airline_adult_selling_price' => $value_airline['airline_adult_selling_price'][0],
                        'airline_children_cost_price' => $value_airline['airline_children_cost_price'][0],
                        'airline_children_selling_price' => $value_airline['airline_children_selling_price'][0],
                        'airline_infant_cost_price' => $value_airline['airline_infant_cost_price'][0],
                        'airline_infant_selling_price' => $value_airline['airline_infant_selling_price'][0],
                        'airline_total_cost_price' => $value_airline['airline_total_cost_price'][0],
                        'airline_total_selling_price' => $value_airline['airline_total_selling_price'][0],
                        'airline_discount' => $value_airline['airline_discount'][0],
                        'airline_total' => $value_airline['airline_total'][0],
                        'airline_currency' => $value_airline['airline_currency'][0],
                    ];
                } elseif ($request->service_type == "no_of_person") {
                    $no_of_persons_entries[] = [
                        'airline_adult_cost_price' => $value_airline['airline_adult_cost_price'][0],
                        'airline_children_cost_price' => $value_airline['airline_children_cost_price'][0],
                        'airline_infant_cost_price' => $value_airline['airline_infant_cost_price'][0],
                        'airline_discount' => $value_airline['airline_discount'][0],
                        'airline_total' => $value_airline['airline_total'][0],
                        'airline_currency' => $value_airline['airline_currency'][0],
                        'no_of_person_adult_total_cost_price' => $request->no_of_person_adult_total_cost_price,
                        'no_of_person_children_total_cost_price' => $request->no_of_person_children_total_cost_price,
                        'no_of_person_infant_total_cost_price' => $request->no_of_person_infant_total_cost_price,
                    ];
                    $sub_total_details[] = [
                        'airline_sub_total' => $value_airline['airline_sub_total'][0],
                        'airline_discount' => $value_airline['airline_discount'][0],
                        'airline_total' => $value_airline['airline_total'][0],
                        'airline_currency' => $value_airline['airline_currency'][0],
                        'airline_currency_name' => $value_airline['airline_currency_name'][0],
                        'no_of_person_adult_profit' => $request->no_of_person_adult_profit,
                        'no_of_person_children_profit' => $request->no_of_person_children_profit,
                        'no_of_person_infant_profit' => $request->no_of_person_infant_profit,
                        'no_of_person_adult_selling_price' => $request->no_of_person_adult_selling_price,
                        'no_of_person_children_selling_price' => $request->no_of_person_children_selling_price,
                        'no_of_person_infant_selling_price' => $request->no_of_person_infant_selling_price,
                        'grand_total' => $request->grand_total,
                    ];
                } else {
                    $no_of_persons_entries[] = [
                        'airline_adult_cost_price' => $value_airline['airline_adult_cost_price'][0],
                        'airline_children_cost_price' => $value_airline['airline_children_cost_price'][0],
                        'airline_infant_cost_price' => $value_airline['airline_infant_cost_price'][0],
                        'airline_discount' => $value_airline['airline_discount'][0],
                        'airline_total' => $value_airline['airline_total'][0],
                        'airline_currency' => $value_airline['airline_currency'][0],
                    ];
                    $sub_total_details[] = [
                        'airline_sub_total' => $value_airline['airline_sub_total'][0],
                        'airline_discount' => $value_airline['airline_discount'][0],
                        'airline_total' => $value_airline['airline_total'][0],
                        'airline_currency' => $value_airline['airline_currency'][0],
                        'airline_currency_name' => $value_airline['airline_currency_name'][0],
                        'lum_sum_adult_total_cost_price' => $request->lum_sum_adult_total_cost_price,
                        'lum_sum_children_total_cost_price' => $request->lum_sum_children_total_cost_price,
                        'lum_sum_infant_total_cost_price' => $request->lum_sum_infant_total_cost_price,
                        'lum_sum_adult_total_selling_price' => $request->lum_sum_adult_total_selling_price,
                        'lum_sum_children_total_selling_price' => $request->lum_sum_children_total_selling_price,
                        'lum_sum_infant_total_selling_price' => $request->lum_sum_infant_total_selling_price,
                        'lum_sum_profit' => $request->lum_sum_profit,
                        'grand_total' => $request->grand_total,
                    ];
                }
                // dd($request);
                $store = new quotations_detail();
                $store->inquiry_id = $request->inq_id;
                $store->type = $request->service_type;
                $store->uniq_id = $get_max_num_detail;
                $store->services_type = $services_for;
                $store->all_entries = json_encode($all_entries);
                $store->person_pricing_details = json_encode($no_of_persons_entries);
                $store->sub_total_details = json_encode($sub_total_details);
                // $store->services_id = $request->airline_services_service_id;
                // $store->sub_services_id = $request->airline_services_sub_service_id;
                if ($request->service_type == "lum_sum") {
                    $store->sub_total = $value_airline['airline_sub_total'][0];
                    $store->total = $request->grand_total;
                } elseif ($request->service_type == "no_of_person") {
                    $store->sub_total = $value_airline['airline_sub_total'][0];
                    $store->discount = isset($value_airline['airline_discount'][0]) ? $value_airline['airline_discount'][0] : null;
                    $store->total = $request->grand_total;
                } else {
                    $store->sub_total = isset($value_airline['airline_total_selling_price'][0]) ? $value_airline['airline_total_selling_price'][0] : null;
                    $store->discount = isset($value_airline['airline_discount'][0]) ? $value_airline['airline_discount'][0] : null;
                    $store->total = isset($value_airline['airline_total'][0]) ? $value_airline['airline_total'][0] : null;
                }
                $store->save();
            }
            // dd($no_of_persons_entries);
            // dd($get_airline_person_pricing_details);

            // dd($get_airline_person_pricing_details);
            // $store = new quotations_detail();
            // $store->inquiry_id = $request->inq_id;
            // $store->uniq_id = $get_max_num_detail;
            // $store->services_type = $services_for;
            // $store->all_entries = json_encode($all_entries);
            // $store->person_pricing_details = json_encode($no_of_persons_entries);
            // $store->sub_total_details = json_encode($sub_total_details);
            // $store->services_id = $request->airline_services[0];
            // $store->sub_services_id = $request->airline_sub_services[0];
            // $store->save();
            // $get_q_details_id[] = $store->id_quotation_details;
            // dd($get_q_details_id);
        }
        if (isset($request->land_services)) {
            $all_entries = [];
            $no_of_persons_entries = [];
            $sub_total_details = [];

            $services_for = "Land Services";

            // dd($value_hotel['legs_count']);
            // dd($value_hotel['legs_count']);
            foreach ($request->land_services as $key => $value_land) {
                // dd($value_land);
                $size_of_land = sizeof($value_land['legs_count']['land_services_route']);
                // dd($size_of_airline);

                for ($i = 0; $i < $size_of_land; $i++) {
                    if ($request->service_type == 'service_level') {
                        $no_of_persons_entries[] = [
                            'land_services_cost_price' => $value_land['legs_count']['land_services_cost_price'][$i],
                            'land_services_selling_price' => $value_land['legs_count']['land_services_selling_price'][$i],
                        ];
                        $all_entries[] = [
                            'land_service' => $value_land['legs_count']['land_service'][$i],
                            'transport' => $value_land['legs_count']['transport'][$i],
                            'land_services_route' => $value_land['legs_count']['land_services_route'][$i],
                        ];
                    } elseif ($request->service_type == "no_of_person") {
                        $no_of_persons_entries[] = [
                            'land_services_adult_cost_price' => $value_land['legs_count']['land_services_adult_cost_price'][$i],
                            'land_services_children_cost_price' => isset($value_land['legs_count']['land_services_children_cost_price'][$i]) ? $value_land['legs_count']['land_services_children_cost_price'][$i] : "",
                            'land_services_infant_cost_price' => isset($value_land['legs_count']['land_services_infant_cost_price'][$i]) ? $value_land['legs_count']['land_services_infant_cost_price'][$i] : "",
                        ];
                        $all_entries[] = [
                            'land_service' => $value_land['legs_count']['land_service'][$i],
                            'transport' => $value_land['legs_count']['transport'][$i],
                            'land_services_route' => $value_land['legs_count']['land_services_route'][$i],
                        ];
                    } else {
                        $no_of_persons_entries[] = [
                            'land_services_adult_cost_price' => $value_land['legs_count']['land_services_adult_cost_price'][$i],
                            'land_services_children_cost_price' => isset($value_land['legs_count']['land_services_children_cost_price'][$i]) ? $value_land['legs_count']['land_services_children_cost_price'][$i] : "",
                            'land_services_infant_cost_price' => isset($value_land['legs_count']['land_services_infant_cost_price'][$i]) ? $value_land['legs_count']['land_services_infant_cost_price'][$i] : "",
                        ];
                        $all_entries[] = [
                            'land_service' => $value_land['legs_count']['land_service'][$i],
                            'transport' => $value_land['legs_count']['transport'][$i],
                            'land_services_route' => $value_land['legs_count']['land_services_route'][$i],

                        ];
                    }
                }

                if ($request->service_type == 'no_of_person') {
                    $sub_total_details[] = [
                        'land_services_currency_name' => $value_land['land_services_currency_name'][0],
                        'land_services_sub_total' => $value_land['land_services_sub_total'][0],
                        'land_services_discount' => $value_land['land_services_discount'][0],
                        'land_services_total' => $value_land['land_services_total'][0],
                        'land_services_currency' => $value_land['land_services_currency'][0],
                        'no_of_person_adult_profit' => $request->no_of_person_adult_profit,
                        'no_of_person_children_profit' => $request->no_of_person_children_profit,
                        'no_of_person_infant_profit' => $request->no_of_person_infant_profit,
                        'no_of_person_adult_selling_price' => $request->no_of_person_adult_selling_price,
                        'no_of_person_children_selling_price' => $request->no_of_person_children_selling_price,
                        'no_of_person_infant_selling_price' => $request->no_of_person_infant_selling_price,
                        'grand_total' => $request->grand_total,
                    ];
                } elseif ($request->service_type == 'service_level') {
                    $sub_total_details[] = [
                        'land_services_total_cost_price' => $value_land['land_services_total_cost_price'][0],
                        'land_services_selling_total' => $value_land['land_services_selling_total'][0],
                        'land_services_discount' => $value_land['land_services_discount'][0],
                        'land_services_total' => $value_land['land_services_total'][0],
                        'land_services_currency' => $value_land['land_services_currency'][0],
                        'land_services_currency_name' => $value_land['land_services_currency_name'][0],
                        'land_services_currency_total' => $value_land['land_services_currency_name'][0],
                    ];
                } else {
                    $sub_total_details[] = [
                        'land_services_currency_name' => $value_land['land_services_currency_name'][0],
                        'land_services_sub_total' => $value_land['land_services_sub_total'][0],
                        'land_services_discount' => $value_land['land_services_discount'][0],
                        'land_services_total' => $value_land['land_services_total'][0],
                        'land_services_currency' => $value_land['land_services_currency'][0],
                        'lum_sum_adult_total_cost_price' => $request->lum_sum_adult_total_cost_price,
                        'lum_sum_children_total_cost_price' => $request->lum_sum_children_total_cost_price,
                        'lum_sum_infant_total_cost_price' => $request->lum_sum_infant_total_cost_price,
                        'lum_sum_adult_total_selling_price' => $request->lum_sum_adult_total_selling_price,
                        'lum_sum_children_total_selling_price' => $request->lum_sum_children_total_selling_price,
                        'lum_sum_infant_total_selling_price' => $request->lum_sum_infant_total_selling_price,
                        'lum_sum_profit' => $request->lum_sum_profit,
                        'grand_total' => $request->grand_total,
                    ];
                }
                // dd($no_of_persons_entries);
                // dd($value_land['land_services_sub_total'][0]);
                $store = new quotations_detail();
                $store->inquiry_id = $request->inq_id;
                $store->type = $request->service_type;
                $store->uniq_id = $get_max_num_detail;
                $store->services_type = $services_for;
                $store->all_entries = json_encode($all_entries);
                $store->person_pricing_details = json_encode($no_of_persons_entries);
                $store->sub_total_details = json_encode($sub_total_details);
                $store->services_id = $request->land_services_service_id;
                $store->sub_services_id = $request->land_services_sub_service_id;
                if ($request->service_type == "lum_sum") {
                    $store->sub_total = $value_land['land_services_sub_total'][0];
                    $store->total = $request->grand_total;
                } elseif ($request->service_type == "no_of_person") {
                    $store->sub_total = $value_land['land_services_sub_total'][0];
                    $store->discount = isset($value_land['land_services_discount'][0]) ? $value_land['land_services_discount'][0] : null;
                    $store->total = $request->grand_total;
                } else {
                    $store->sub_total = isset($value_land['land_services_selling_total'][0]) ? $value_land['land_services_selling_total'][0] : null;
                    $store->discount = isset($value_land['land_services_discount'][0]) ? $value_land['land_services_discount'][0] : null;
                    $store->total = isset($value_land['land_services_total'][0]) ? $value_land['land_services_total'][0] : null;
                }
                // $store->lum_sum_cost_price = $request->lum_sum_cost_price;
                // $store->lum_sum_selling_price = $request->lum_sum_selling_price;
                $store->save();
                $get_q_details_id[] = $store->id_quotation_details;
            }
            // dd($no_of_persons_entries);

        }
        $get_max_num = quotation::max('id_quotations');
        if ($get_max_num >= 1) {
            $get_max_num = $get_max_num + 1;
        } else {
            $get_max_num = 1;
        }
        $store_quotation = new quotation();
        $store_quotation->quotation_no = "QUO-" . date('Ymd') . "#" . $get_max_num;
        $store_quotation->inquiry_id = $request->inq_id;
        $store_quotation->quotation_type = $request->service_type;
        $store_quotation->quotations_details_id = $get_max_num_detail;
        $store_quotation->save();
        session()->flash('success', 'Quotation Created Successfully');
        // sendNoti('Quotation Created Successfully By ' . auth()->user()->name, auth()->user()->name, 'create_quotation');
        return redirect('create_quotation/' . $dec_q_id);
    }
}
