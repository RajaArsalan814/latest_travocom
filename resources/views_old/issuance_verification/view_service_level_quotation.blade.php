<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View Quotation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            margin-top: 20px;
            background-color: #eee;
        }

        .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: 1rem;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css"
        integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        {{-- <hr class="my-4"> --}}


                        <!-- end row -->

                        <div class="py-2">
                            <h5 class="font-size-15">Issuance Summary</h5>

                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px;">No.</th>
                                            <th>Description</th>
                                            <th>Service Type</th>
                                            <th>Sub Total</th>
                                            <th>Discount</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead><!-- end thead -->
                                    <tbody>
                                        {{-- {{dd($quotation_details)}} --}}
                                        @foreach ($quotation_details as $key => $q_details)
                                            @php
                                                $visa_json_decode_all_entries = json_decode($q_details->all_entries);
                                                $air_ticket_json_decode_all_entries = json_decode($q_details->all_entries);
                                                $land_services_json_decode_all_entries = json_decode($q_details->all_entries);
                                                $land_services_json_decode_person_pricing_details = json_decode($q_details->person_pricing_details);
                                                $hotel_json_decode_person_pricing_details = json_decode($q_details->person_pricing_details);
                                                $hotel_json_decode_all_entries = json_decode($q_details->all_entries);
                                                $get_sub_total_entries = json_decode($q_details->sub_total_details);
                                                // dd($hotel_json_decode_all_entries);
                                                // dd($land_services_json_decode_person_pricing_details);
                                            @endphp
                                            <tr>
                                                @if ($q_details->services_type == $services_type)
                                                    <th scope="row">{{ $key = $key + 1 }}</th>
                                                @endif
                                                <td>
                                                    <div>
                                                        @if ($q_details->services_type == 'Visa' && $services_type == 'Visa')
                                                            <table
                                                                class="table table-striped table-inverse table-responsive">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Visa Service</th>
                                                                        <th>Adult CP</th>
                                                                        <th>Children CP</th>
                                                                        <th>Infant CP</th>
                                                                        <th>Adult SP</th>
                                                                        <th>Children SP</th>
                                                                        <th>Infant SP</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($visa_json_decode_all_entries as $key_visa => $visa_all_entries)
                                                                        <tr>
                                                                            <td scope="row">
                                                                                @php
                                                                                    $visa_name = App\Visa_rates::where('id_visa_rates', $visa_all_entries->visa_service)->first();
                                                                                    $issue_visa_adult_cp = $hotel_json_decode_person_pricing_details[0]->visa_adult_cost_price;
                                                                                    $issue_visa_children_cp = $hotel_json_decode_person_pricing_details[0]->visa_children_cost_price;
                                                                                    $issue_visa_infant_cp = $hotel_json_decode_person_pricing_details[0]->visa_infant_cost_price;
                                                                                    $issue_visa_adult_sp = $hotel_json_decode_person_pricing_details[0]->visa_adult_selling_price;
                                                                                    $issue_visa_children_sp = $hotel_json_decode_person_pricing_details[0]->visa_children_selling_price;
                                                                                    $issue_visa_infant_sp = $hotel_json_decode_person_pricing_details[0]->visa_infant_selling_price;
                                                                                    $issue_q_detail_id = $q_details->id_quotation_details;
                                                                                    $issue_q_id = $q_details->quotation_id;
                                                                                    $issue_service_type = $q_details->services_type;
                                                                                    $issue_inq_id = $q_details->inquiry_id;
                                                                                    $issue_legs = $key_visa;
                                                                                @endphp


                                                                                {{ $visa_name->name }}
                                                                            <td>
                                                                                {{-- {{dd(get_issuance_cost_price($issue_q_id, $issue_service_type, $issue_legs, 'adult'))}} --}}
                                                                                {{ get_issuance_cost_price($issue_q_id, $issue_service_type, $issue_legs, 'adult') != null ? get_issuance_cost_price($issue_q_id, $issue_service_type, $issue_legs, 'adult') : $land_services_json_decode_person_pricing_details[0]->visa_adult_cost_price }}
                                                                                <button
                                                                                    onclick="edit_visa_cp({{ $issue_visa_adult_cp }},{{ $issue_visa_children_cp }},'adult',{{ $issue_q_detail_id }},{{ $issue_q_id }},'{{ $issue_service_type }}',{{ $issue_legs }},{{ $issue_inq_id }})"
                                                                                    class="btn btn-az-primary"> <i
                                                                                        class="fa fa-edit"></i></button>


                                                                            </td>
                                                                            <td>

                                                                                {{ get_issuance_cost_price($issue_q_id, $issue_service_type, $issue_legs, 'children') != null ? get_issuance_cost_price($issue_q_id, $issue_service_type, $issue_legs, 'children') : $land_services_json_decode_person_pricing_details[0]->visa_children_cost_price }}
                                                                                <button
                                                                                    onclick="edit_visa_cp({{ $issue_visa_children_cp }},{{ $issue_visa_children_cp }},'children',{{ $issue_q_detail_id }},{{ $issue_q_id }},'{{ $issue_service_type }}',{{ $issue_legs }},{{ $issue_inq_id }})"
                                                                                    class="btn btn-az-primary"> <i
                                                                                        class="fa fa-edit"></i></button>

                                                                            </td>
                                                                            <td>
                                                                                {{ get_issuance_cost_price($issue_q_id, $issue_service_type, $issue_legs, 'infant') != null ? get_issuance_cost_price($issue_q_id, $issue_service_type, $issue_legs, 'infant') : $land_services_json_decode_person_pricing_details[0]->visa_infant_cost_price }}
                                                                                <button
                                                                                    onclick="edit_visa_cp({{ $issue_visa_infant_cp }},{{ $issue_visa_children_cp }},'infant',{{ $issue_q_detail_id }},{{ $issue_q_id }},'{{ $issue_service_type }}',{{ $issue_legs }},{{ $issue_inq_id }})"
                                                                                    class="btn btn-az-primary"> <i
                                                                                        class="fa fa-edit"></i></button>

                                                                            </td>
                                                                            <td>
                                                                                {{ $land_services_json_decode_person_pricing_details[0]->visa_adult_selling_price }}
                                                                            </td>
                                                                            <td>
                                                                                {{ $land_services_json_decode_person_pricing_details[0]->visa_children_selling_price }}
                                                                            </td>
                                                                            <td>
                                                                                {{ $land_services_json_decode_person_pricing_details[0]->visa_infant_selling_price }}
                                                                            </td>
                                                                            <td></td>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @elseif($q_details->services_type == 'Air Ticket' && $services_type == 'Air Ticket')
                                <table class="table table-striped table-inverse table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Airline Name</th>
                                            <th>Flight No</th>
                                            <th>Adult CP</th>
                                            <th>Children CP</th>
                                            <th>Infant CP</th>
                                            <th>Adult SP</th>
                                            <th>Children SP</th>
                                            <th>Infant SP</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- {{dd($get_sub_total_entries)}} --}}
                                        @foreach ($air_ticket_json_decode_all_entries as $key_airline => $air_ticket_all_entries)
                                            <tr>
                                                @php

                                                    $issue_airline_adult_cp = $get_sub_total_entries[0]->airline_adult_cost_price;
                                                    $issue_airline_children_cp = $get_sub_total_entries[0]->airline_children_cost_price;
                                                    $issue_airline_infant_cp = $get_sub_total_entries[0]->airline_infant_cost_price;
                                                    $issue_airline_adult_sp = $get_sub_total_entries[0]->airline_adult_selling_price;
                                                    $issue_airline_children_sp = $get_sub_total_entries[0]->airline_children_selling_price;
                                                    $issue_airline_infant_sp = $get_sub_total_entries[0]->airline_infant_selling_price;
                                                    $issue_q_detail_id = $q_details->id_quotation_details;
                                                    $issue_q_id = $q_details->quotation_id;
                                                    $issue_service_type = $q_details->services_type;
                                                    $issue_inq_id = $q_details->inquiry_id;
                                                    $issue_legs = $key_airline;
                                                @endphp
                                                <td scope="row">
                                                    @php
                                                        $get_airline_name = App\airlines::where('id_airlines', $air_ticket_all_entries->airline_name)
                                                            ->select('Airline')
                                                            ->first();
                                                    @endphp
                                                    {{ $get_airline_name->Airline }}
                                                </td>
                                                <td>{{ $air_ticket_all_entries?->flight_number }}
                                                </td>
                                                <td>
                                                    {{ get_issuance_cost_price($issue_q_id, $issue_service_type, $issue_legs, 'adult') != null ? get_issuance_cost_price($issue_q_id, $issue_service_type, $issue_legs, 'adult') : $get_sub_total_entries[0]->airline_adult_cost_price }}
                                                    <button
                                                        onclick="edit_visa_cp({{ $issue_airline_adult_cp }},{{ $issue_airline_adult_sp }},'adult',{{ $issue_q_detail_id }},{{ $issue_q_id }},'{{ $issue_service_type }}',{{ $issue_legs }},{{ $issue_inq_id }})"
                                                        class="btn btn-az-primary"> <i class="fa fa-edit"></i></button>
                                                </td>
                                                <td>
                                                    {{ get_issuance_cost_price($issue_q_id, $issue_service_type, $issue_legs, 'children') != null ? get_issuance_cost_price($issue_q_id, $issue_service_type, $issue_legs, 'children') : $get_sub_total_entries[0]->airline_children_cost_price }}
                                                    <button
                                                        onclick="edit_visa_cp({{ $issue_airline_children_cp }},{{ $issue_airline_children_sp }},'children',{{ $issue_q_detail_id }},{{ $issue_q_id }},'{{ $issue_service_type }}',{{ $issue_legs }},{{ $issue_inq_id }})"
                                                        class="btn btn-az-primary"> <i class="fa fa-edit"></i></button>
                                                </td>
                                                <td>
                                                    {{ get_issuance_cost_price($issue_q_id, $issue_service_type, $issue_legs, 'infant') != null ? get_issuance_cost_price($issue_q_id, $issue_service_type, $issue_legs, 'infant') : $get_sub_total_entries[0]->airline_infant_cost_price }}
                                                    <button
                                                        onclick="edit_visa_cp({{ $issue_airline_infant_cp }},{{ $issue_airline_infant_sp }},'infant',{{ $issue_q_detail_id }},{{ $issue_q_id }},'{{ $issue_service_type }}',{{ $issue_legs }},{{ $issue_inq_id }})"
                                                        class="btn btn-az-primary"> <i class="fa fa-edit"></i></button>
                                                </td>
                                                <td>
                                                    {{ $get_sub_total_entries[0]->airline_adult_selling_price }}
                                                </td>
                                                <td>
                                                    {{ $get_sub_total_entries[0]->airline_children_selling_price }}
                                                </td>
                                                <td>
                                                    {{ $get_sub_total_entries[0]->airline_infant_selling_price }}
                                                </td>


                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <table class="table table-striped table-inverse table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Airline Arrival Date</th>
                                            <th>Airline Arrival Destination</th>
                                            <th>Airline Departure Destination</th>
                                            <th>Arrival Time</th>
                                            <th>Departure Time</th>
                                            <th>Airline Flight Class</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($air_ticket_json_decode_all_entries as $air_ticket_all_entries)
                                            <tr>
                                                <td>{{ $air_ticket_all_entries?->airline_arrival_date }}
                                                </td>
                                                <td>{{ $air_ticket_all_entries?->airline_arrival_destination }}
                                                </td>
                                                <td>{{ $air_ticket_all_entries?->airline_departure_destination }}
                                                </td>
                                                <td>{{ $air_ticket_all_entries?->arrival_time }}
                                                </td>
                                                <td>{{ $air_ticket_all_entries?->departure_time }}
                                                </td>
                                                <td>{{ $air_ticket_all_entries?->airline_flight_class }}
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @elseif($q_details->services_type == 'Land Services' && $services_type == 'Land Services')
                                <table class="table table-striped table-inverse table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Land Service Name</th>
                                            <th>Transport</th>
                                            <th>Route</th>
                                            <th>Cost Price</th>
                                            <th>Selling Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($land_services_json_decode_all_entries as $key_land => $land_services_all_entries)
                                            <tr>
                                                {{-- {{ dd($land_services_json_decode_person_pricing_details) }} --}}
                                                {{-- @foreach ($land_services_json_decode_person_pricing_details as $land_pricing) --}}
                                            <tr>
                                                <td scope="row">
                                                    @php
                                                        $get_land_services_name = App\Landservicestypes::where('id_land_and_services_types', $land_services_all_entries->land_service)
                                                            ->select('service_name')
                                                            ->join('land_services_types', 'land_services_types.id_land_services_types', '=', 'land_and_services_types.name')
                                                            ->first();
                                                        // dd($get_land_services_name);
                                                    @endphp
                                                    {{ $get_land_services_name->service_name }}
                                                </td>
                                                <td>{{ $land_services_all_entries?->transport }}
                                                </td>
                                                <td>{{ $land_services_all_entries?->land_services_route }}
                                                </td>
                                                @php
                                                    $issue_cp = $land_services_json_decode_person_pricing_details[$key_land]->land_services_cost_price;
                                                    $issue_sp = $land_services_json_decode_person_pricing_details[$key_land]->land_services_selling_price;
                                                    $issue_q_detail_id = $q_details->id_quotation_details;
                                                    $issue_q_id = $q_details->quotation_id;
                                                    $issue_service_type = $q_details->services_type;
                                                    $issue_inq_id = $q_details->inquiry_id;
                                                    $issue_legs = $key_land;
                                                    // dd($issue_q_details);
                                                @endphp

                                                <td>
                                                    {{ get_issuance_cost_price($issue_q_id, $issue_service_type, $issue_legs) != null ? get_issuance_cost_price($issue_q_id, $issue_service_type, $issue_legs) : $land_services_json_decode_person_pricing_details[$key_land]->land_services_cost_price }}


                                                    <button
                                                        onclick="edit_hotel_cp({{ $issue_cp }},{{ $issue_sp }},{{ $issue_q_detail_id }},{{ $issue_q_id }},'{{ $issue_service_type }}',{{ $issue_legs }},{{ $issue_inq_id }})"
                                                        class="btn btn-az-primary"> <i class="fa fa-edit"></i></button>
                                                </td>
                                                <td>{{ $land_services_json_decode_person_pricing_details[$key_land]->land_services_selling_price }}
                                                </td>
                                            </tr>
                                            {{-- @endforeach --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @elseif($q_details->services_type == 'Hotel' && $services_type == 'Hotel')
                                <table class="table table-striped table-inverse table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Hotel Name</th>
                                            <th>Room Type</th>
                                            <th>Qty</th>
                                            <th>Nights</th>
                                            <th>Hotel Addon</th>
                                            <th>Send Verification</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $get_size_hotel_name = sizeof($hotel_json_decode_all_entries);
                                            // dd($hotel_json_decode_all_entries);
                                            $i = 0;
                                        @endphp
                                        @for ($i; $i < $get_size_hotel_name; $i++)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td scope="row">
                                                    @php
                                                        $get_hotel_name = App\hotels::where('id_hotels', $hotel_json_decode_all_entries[$i]->hotel_name)
                                                            ->select('hotel_name')
                                                            ->first();
                                                        $get_room_type = App\room_type::where('id_room_types', $hotel_json_decode_all_entries[$i]->room_type)
                                                            ->select('name')
                                                            ->first();
                                                    @endphp
                                                    {{ $get_hotel_name?->hotel_name }}

                                                </td>
                                                <td> {{ $get_room_type?->name }}
                                                </td>
                                                <td>{{ $hotel_json_decode_person_pricing_details[$i]->hotel_qty }}
                                                </td>
                                                <td>{{ $hotel_json_decode_all_entries[$i]->hotel_nights }}
                                                </td>
                                                <td>{{ $hotel_json_decode_all_entries[$i]->hotel_addon != 'Select Addon' ? $hotel_json_decode_all_entries[$i]->hotel_addon : '-' }}
                                                </td>
                                                <td>
                                                    @php
                                                        // dd(check_issuance_verification(null, $q_details->quotation_id, $i, 'Hotel'));
                                                    @endphp
                                                    <button @if (check_issuance_verification(null, $q_details->quotation_id, $i, 'Hotel')) disabled @endif
                                                        class=" btn-sm btn btn-primary"
                                                        onclick="send_for_verification('{{ request()->uniq_id }}','{{ request()->inq_id }}','{{ request()->services_type }}','{{ \Crypt::encrypt($i) }}')">Send
                                                        For Verification</button>
                                                    {{-- <a href="{{ url('send_issuance_for_verification/' . request()->uniq_id . '/' . request()->inq_id . '/' . request()->services_type . '/' . \Crypt::encrypt($i)) }}"
                                                        class="btn btn-primary">Send For Verification</a> --}}
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                                <table class="table table-striped table-inverse table-responsive">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Cost Price</th>
                                            <th>Selling Price</th>
                                            <th>Hotel Check In</th>
                                            <th>Hotel Check Out</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $get_size_hotel_name = sizeof($hotel_json_decode_all_entries);
                                            // dd($hotel_json_decode_person_pricing_details);
                                            $i = 0;
                                        @endphp
                                        @for ($i; $i < $get_size_hotel_name; $i++)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>
                                                    @php
                                                        $issue_cp = $hotel_json_decode_person_pricing_details[$i]->hotel_cost_price;
                                                        $issue_sp = $hotel_json_decode_person_pricing_details[$i]->hotel_selling_price;
                                                        $issue_q_detail_id = $q_details->id_quotation_details;
                                                        $issue_q_id = $q_details->quotation_id;
                                                        $issue_service_type = $q_details->services_type;
                                                        $issue_inq_id = $q_details->inquiry_id;
                                                        $issue_legs = $i;
                                                        // dd($issue_q_details);
                                                    @endphp

                                                    {{ get_issuance_cost_price($issue_q_id, $issue_service_type, $issue_legs) != null ? get_issuance_cost_price($issue_q_id, $issue_service_type, $issue_legs) : $hotel_json_decode_person_pricing_details[$i]->hotel_cost_price }}

                                                    <button
                                                        onclick="edit_hotel_cp({{ $issue_cp }},{{ $issue_sp }},{{ $issue_q_detail_id }},{{ $issue_q_id }},'{{ $issue_service_type }}',{{ $issue_legs }},{{ $issue_inq_id }})"
                                                        class="btn btn-az-primary"> <i class="fa fa-edit"></i></button>
                                                </td>
                                                <td>{{ $hotel_json_decode_person_pricing_details[$i]->hotel_selling_price }}
                                                </td>
                                                <td>{{ $hotel_json_decode_all_entries[$i]->hotel_check_in }}
                                                </td>
                                                <td>{{ $hotel_json_decode_all_entries[$i]->hotel_check_out }}
                                                </td>

                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                                @endif
                            </div>
                            </td>
                            {{-- {{dd($q_details)}} --}}
                            @if ($q_details->services_type == $services_type)
                                <td class="text-center">{{ $q_details->services_type }}</td>
                            @endif
                            @if ($q_details->services_type == 'Visa' && $services_type == 'Visa')
                                <td class="text-center">{{ $get_sub_total_entries[0]->visa_total_selling_price }}</td>
                            @elseif ($q_details->services_type == 'Air Ticket' && $services_type == 'Air Ticket')
                                <td class="text-center">{{ $get_sub_total_entries[0]->airline_total_selling_price }}
                                </td>
                            @elseif($q_details->services_type == 'Land Services' && $services_type == 'Land Services')
                                <td class="text-center">{{ $q_details->sub_total }}</td>
                            @elseif($q_details->services_type == 'Hotel' && $services_type == 'Hotel')
                                <td class="text-center">{{ $get_sub_total_entries[0]->hotel_total_selling_price }}
                                </td>
                            @endif
                            @if ($q_details->services_type == $services_type)
                                <td class="text-center">{{ $q_details->discount }}</td>
                                <td class="text-center">{{ $q_details->total }}</td>
                            @endif

                            </tr>
                            @endforeach
                            <hr>

                            {{-- <tr>
                                <th scope="row" colspan="4" class="border-0 text-end">
                                    Sub Total :</th>
                                <td class="border-0 text-end">{{$sub_total}}/-</td>
                            </tr> --}}
                            <!-- end tr -->
                            {{-- <tr>
                                <th scope="row" colspan="4" class="border-0 text-end">
                                    Discount</th>
                                <td class="border-0 text-end">{{$discount}}/-</td>
                            </tr> --}}
                            <!-- end tr -->
                            {{-- <tr>
                                <th scope="row" colspan="5" class="border-1 text-end">Total</th>
                                <td class="border-1 text-end">
                                    <h4 class="m-0 fw-semibold">{{ $total }}/-</h4>
                                </td>
                            </tr> --}}
                            <!-- end tr -->
                            </tbody><!-- end tbody -->
                            </table><!-- end table -->
                        </div><!-- end table responsive -->
                        <div class="d-print-none mt-4">
                            <div class="float-end">
                                {{-- {{dd(request()->quote_id)}} --}}
                                @if (\Crypt::decrypt(request()->services_type) != 'Hotel')
                                    {{-- <a href="{{ url('send_issuance_for_verification/' . request()->uniq_id . '/' . request()->inq_id . '/' . request()->services_type) }}"
                                        class="btn btn-primary">Send For Issuance</a> --}}
                                    {{-- <button  @if (check_issuance_verification(null, $q_details->quotation_id, null, request()->services_type)) disabled  @endif class=" btn-sm btn btn-primary"
                                        onclick="send_for_verification('{{ request()->uniq_id }}','{{ request()->inq_id }}','{{ request()->services_type }}')">Send
                                        For Verification</button> --}}
                                    <button class=" btn-sm btn btn-primary"
                                        onclick="send_for_verification('{{ request()->uniq_id }}','{{ request()->inq_id }}','{{ request()->services_type }}')">Send
                                        For Verification</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end col -->
    </div>
    </div>
    <div id="edit_cost_price_modal" class="modal fade bd-example-modal-lg " role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Edit Cost Price</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="inv_id_append">

                    </div>
                    {{-- <label for="">Assign Services And Sub Services</label> --}}
                    <form method="POST" action="{{ url('update_cost_price_sale_person') }}">
                        <input type="hidden" name="edit_issuance_cost_price" id="edit_issuance_cost_price">
                        <input type="hidden" name="edit_issuance_selling_price" id="edit_issuance_selling_price">
                        <input type="hidden" name="edit_issuance_inquiry_id" id="edit_issuance_inquiry_id">
                        <input type="hidden" name="edit_issuance_quotation_id" id="edit_issuance_quotation_id">
                        <input type="hidden" name="edit_issuance_quotation_detail_id"
                            id="edit_issuance_quotation_detail_id">
                        <input type="hidden" name="edit_issuance_services_type" id="edit_issuance_services_type">
                        <input type="hidden" name="edit_issuance_legs" id="edit_issuance_legs">
                        <input type="hidden" name="edit_issuance_person" id="edit_issuance_person">

                        <input type="hidden" name="edit_issuance_adult_cost_price"
                            id="edit_issuance_adult_cost_price">
                        <input type="hidden" name="edit_issuance_children_cost_price"
                            id="edit_issuance_children_cost_price">
                        <input type="hidden" name="edit_issuance_infant_cost_price"
                            id="edit_issuance_infant_cost_price">
                        <input type="hidden" name="edit_issuance_adult_selling_price"
                            id="edit_issuance_adult_selling_price">
                        <input type="hidden" name="edit_issuance_children_selling_price"
                            id="edit_issuance_children_selling_price">
                        <input type="hidden" name="edit_issuance_infant_selling_price"
                            id="edit_issuance_infant_selling_price">


                        @csrf
                        <div class="form-group d-none">
                            <label for="">Old Cost Price</label>
                            <input type="text" disabled class="form-control" name="old_cost_price"
                                id="old_cost_price">
                        </div>
                        <div class="form-group">
                            <label for="">Enter New Cost Price</label>
                            <input type="number" min="1" minlength="1" class="form-control"
                                name="edit_issuance_new_cost_price" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Enter New Selling Price</label>
                            <input type="number" min="1" minlength="1" class="form-control"
                                name="edit_issuance_new_selling_price" id="">
                        </div>

                </div>
                <div class="modal-footer">
                    <button id="btn_parse" type="submit" class="btn btn-indigo">Update</button>
                    </form>
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="send_for_verification_modal" class="modal fade bd-example-modal-lg " role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Send For Verification</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">

                        <input type="hidden" id="veri_uniq_id">
                        <input type="hidden" id="veri_inq_id">
                        <input type="hidden" id="veri_services_type">
                        <input type="hidden" id="veri_legs">
                        <div class="form-group">
                            <label for="" class="mt-2">Select Vendor<span
                                    style="color: red">*</span></label>
                            <select name="veri_vendor" id="veri_vendor" class="select2 form-control"
                                style="width: 100%" id="">
                                <option value="">Select</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id_service_vendors }}">
                                        {{ $vendor->vendor_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-primary mt-2" onclick="send_for_verification_ajax()">Send</button>
                    </div>

                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"
        integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function edit_hotel_cp(issue_cp, issue_sp, issue_q_detail_id, issue_q_id, issue_service_type, issue_legs,
            issue_inq_id) {
            $('#edit_issuance_cost_price').val(issue_cp)
            $('#old_cost_price').val(issue_cp)
            $('#edit_issuance_selling_price').val(issue_sp)
            $('#edit_issuance_inquiry_id').val(issue_inq_id)
            $('#edit_issuance_quotation_id').val(issue_q_id)
            $('#edit_issuance_quotation_detail_id').val(issue_q_detail_id)
            $('#edit_issuance_services_type').val(issue_service_type)
            $('#edit_issuance_legs').val(issue_legs)
            $('#edit_cost_price_modal').modal('show');
        }

        function edit_visa_cp(issue_cp, issue_sp, person, issue_q_detail_id, issue_q_id, issue_service_type, issue_legs,
            issue_inq_id) {
            $('#edit_issuance_cost_price').val(issue_cp)
            $('#old_cost_price').val(issue_cp)
            $('#edit_issuance_selling_price').val(issue_sp)
            $('#edit_issuance_person').val(person)
            $('#edit_issuance_inquiry_id').val(issue_inq_id)
            $('#edit_issuance_quotation_id').val(issue_q_id)
            $('#edit_issuance_quotation_detail_id').val(issue_q_detail_id)
            $('#edit_issuance_services_type').val(issue_service_type)
            $('#edit_issuance_legs').val(issue_legs)
            $('#edit_cost_price_modal').modal('show');
        }

        function send_for_verification(uniq_id, inq_id, services_type, legs) {
            $('#veri_uniq_id').val(uniq_id);
            $('#veri_inq_id').val(inq_id);
            $('#veri_services_type').val(services_type);
            $('#veri_legs').val(legs);
            $('#send_for_verification_modal').modal('show');
        }

        function send_for_verification_ajax() {
            var unq_id = $('#veri_uniq_id').val();
            var vendor = $('#veri_vendor').val();
            var inq_id = $('#veri_inq_id').val();
            var services_type = $('#veri_services_type').val();
            var legs = $('#veri_legs').val();
            $.ajax({
                type: "GET",
                url: "{{ url('send_issuance_for_verification/') }}/" + vendor + '/' +
                    unq_id + '/' + inq_id + '/' + services_type + '/' + legs,
                success: function(response) {
                    // location.reload(true);
                    parent.location.reload();
                }
            });
        }
        $(document).ready(function() {
            $(".select2").select2({
                dropdownParent: $("#send_for_verification_modal")
            });
        });
    </script>

</body>

</html>
