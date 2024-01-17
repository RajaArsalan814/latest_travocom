<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View Quotation</title>
    <style>
        body {
            margin-top: 20px;
            background-color: #eee;
            font-size: 12px !important;
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
    <script src="{{ asset('/lib/jquery/jquery.min.js') }}"></script>
     <script src="
           https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js
           "></script>
           <script>
           function reject_issuance(quote_id, inq_id, service_type) {
//               alert(service_type);
            Swal.fire({
                title: '<strong class="">Enter Reject Reason</strong>',
                icon: 'warning',
                html: '<textarea id="cancel_reason" class="form-control" style="height:80px;" ></textarea>',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: '<strong>Reject</strong>',
                cancelButtonText: '<strong>Cancel</strong>',
            }).then((result) => {


                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {

                    var get_cancel_reason = $('#cancel_reason').val();
                    
                    if (get_cancel_reason.length > 0) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('reject_issuance/') }}/" + quote_id +"/"+ inq_id +"/"+ service_type,
                            data: {
                                cancel_reason: get_cancel_reason
                            },
                            success: function(response) {
                                Swal.fire('Issuance Rejected!', '', 'success');
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire('Please Enter Valid Cancel Reason!', '', 'error');
                    }
                } else if (result.isDenied) {}
            })
        }</script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="py-2">
                            <h5 class="font-size-15">Issuance Summary</h5>

                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px;">No.</th>
                                            <th>Description</th>
                                            <th>Service Type</th>
                                            {{-- <th></th> --}}
                                            <th>Sub Total</th>
                                            <th>Discount</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead><!-- end thead -->
                                    <tbody>
                                        {{-- {{dd($quotation_details)}} --}}
                                        @foreach ($quotation_details as $key => $q_details)
                                            @php
                                                $decode_all_entries = json_decode($q_details->all_entries);
                                                $decode_person_pricing_details = json_decode($q_details->person_pricing_details);
                                                $decode_sub_total_details = json_decode($q_details->sub_total_details);
                                                // dd($decode_person_pricing_details);
                                            @endphp
                                            <tr>
                                                <th scope="row">{{ $key = $key + 1 }}</th>
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
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $get_size = sizeof($decode_all_entries);
                                                                        // dd($decode_all_entries);
                                                                        // dd($hotel_json_decode_person_pricing_details);
                                                                        $i = 0;
                                                                    @endphp
                                                                    @for ($i; $i < $get_size; $i++)
                                                                        <tr>
                                                                            <td>
                                                                                @php
                                                                                    $visa_name = App\Visa_rates::where('id_visa_rates', $decode_all_entries[$i]->visa_service)
                                                                                        ->select('name')
                                                                                        ->first();
                                                                                @endphp
                                                                                {{ $visa_name->name }}

                                                                            </td>

                                                </td>
                                                <td>{{ $decode_person_pricing_details[$i]->visa_adult_cost_price }}
                                                </td>
                                                <td>{{ $decode_person_pricing_details[$i]->visa_children_cost_price }}
                                                </td>
                                                <td>{{ $decode_person_pricing_details[$i]->visa_infant_cost_price }}
                                                </td>


                                                {{-- <td style="width: 200px !important;">

                                                                                NO: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[$i]->visa_no_of_adults }}</span>
                                                                                CP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[$i]->visa_adult_cost_price }}</span>
                                                                                SP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[$i]->visa_adult_selling_price }}</span>
                                                                            </td> --}}
                                                {{-- <td style="width:200px !important;">

                                                                                NO: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[$i]->visa_no_of_children }}</span>
                                                                                CP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[$i]->visa_children_cost_price }}</span>
                                                                                SP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[$i]->visa_children_selling_price }}</span>
                                                                            </td> --}}
                                                {{-- <td style="width:200px !important;">

                                                                                NO: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[$i]->visa_no_of_infant }}</span>
                                                                                CP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[$i]->visa_infant_cost_price }}</span>
                                                                                SP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[$i]->visa_infant_selling_price }}</span>
                                                                            </td> --}}
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                                                        <div class="row">
                                                                    <div class="col-lg-12">
                                                                        Quotation ROE: <b>{{$q_details->default_rate_of_exchange_amt}}</b><span> - {{$q_details->default_rate_of_exchange}} </span> = Total (Quotation ROE): <b><?= $q_details->total * round($q_details->default_rate_of_exchange_amt) ?></b> = Total (Today ROE: <b><?= round($currency_rates->currency_rate)?></b> - <span><?= $currency_rates->currency_name?></span>): <b><?= round($q_details->total * $currency_rates->currency_rate) ?></b>
                                                                    </div>
                                                                </div>
                            @elseif($q_details->services_type == 'Air Ticket' && $services_type == 'Air Ticket')
                                <table class="table table-striped table-inverse table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Airline Name</th>
                                            <th>Flight No</th>
                                            <th>Airline Arrival Date</th>
                                            <th>Airline Arrival Destination</th>
                                            <th>Airline Departure Destination</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // dd($decode_person_pricing_details);
                                            $get_size = sizeof($decode_all_entries);
                                            // dd($hotel_json_decode_person_pricing_details);
                                            $i = 0;
                                        @endphp
                                        @for ($i; $i < $get_size; $i++)
                                            <tr>
                                                @php
                                                    $get_airline_name = App\airlines::where('id_airlines', $decode_all_entries[$i]->airline_name)
                                                        ->select('Airline')
                                                        ->first();
                                                @endphp

                                                <td> {{ $get_airline_name?->Airline }}
                                                </td>
                                                <td>{{ $decode_all_entries[$i]->flight_number }}
                                                </td>
                                                <td>{{ $decode_all_entries[$i]->airline_arrival_date }}
                                                </td>
                                                <td>{{ $decode_all_entries[$i]->airline_arrival_destination }}
                                                </td>
                                                <td>{{ $decode_all_entries[$i]->airline_departure_destination }}
                                                </td>
                                                {{-- <td>

                                                                                NO: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_no_of_adult }}</span>
                                                                                CP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_adult_cost_price }}</span>
                                                                                SP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_adult_selling_price }}</span>
                                                                            </td>
                                                                            <td>

                                                                                NO: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_no_of_children }}</span>
                                                                                CP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_children_cost_price }}</span>
                                                                                SP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_children_selling_price }}</span>
                                                                            </td>
                                                                            <td>

                                                                                NO: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_no_infants }}</span>
                                                                                CP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_infant_cost_price }}</span>
                                                                                SP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_infant_selling_price }}</span>
                                                                            </td> --}}
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                                <table class="table table-striped table-inverse table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Arrival Time</th>
                                            <th>Departure Time</th>
                                            <th>Airline Flight Class</th>
                                            <th>Adult</th>
                                            <th>Children</th>
                                            <th>Infant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // dd($decode_person_pricing_details);
                                            $get_size = sizeof($decode_all_entries);
                                            // dd($hotel_json_decode_person_pricing_details);
                                            $i = 0;
                                        @endphp
                                        @for ($i; $i < $get_size; $i++)
                                            <tr>
                                                @php
                                                    $get_airline_name = App\airlines::where('id_airlines', $decode_all_entries[$i]->airline_name)
                                                        ->select('Airline')
                                                        ->first();
                                                @endphp


                                                <td>{{ $decode_all_entries[$i]->arrival_time }}
                                                </td>
                                                <td>{{ $decode_all_entries[$i]->departure_time }}
                                                </td>
                                                <td>{{ $decode_all_entries[$i]->airline_flight_class }}
                                                </td>
                                                <td>{{ $decode_person_pricing_details[0]->airline_adult_cost_price }}
                                                </td>
                                                <td>{{ $decode_person_pricing_details[0]->airline_children_cost_price }}
                                                </td>
                                                <td>{{ $decode_person_pricing_details[0]->airline_infant_cost_price }}
                                                </td>
                                                {{-- <td>

                                                                                NO: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_no_of_adult }}</span>
                                                                                CP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_adult_cost_price }}</span>
                                                                                SP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_adult_selling_price }}</span>
                                                                            </td>
                                                                            <td>

                                                                                NO: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_no_of_children }}</span>
                                                                                CP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_children_cost_price }}</span>
                                                                                SP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_children_selling_price }}</span>
                                                                            </td>
                                                                            <td>

                                                                                NO: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_no_infants }}</span>
                                                                                CP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_infant_cost_price }}</span>
                                                                                SP: <span
                                                                                    class="badge bg-primary">{{ $decode_person_pricing_details[0]->airline_infant_selling_price }}</span>
                                                                            </td> --}}
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            @elseif($q_details->services_type == 'Land Services' && $services_type == 'Land Services')
                                <table class="table table-striped table-inverse table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Land Service</th>
                                            <th>Transport</th>
                                            <th>Route</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // dd($decode_all_entries);
                                            // dd($decode_person_pricing_details);
                                            $get_size = sizeof($decode_person_pricing_details);
                                            // dd($decode_all_entries);
                                            $i = 0;
                                        @endphp
                                        @for ($i; $i < $get_size; $i++)
                                            {{-- {{dd($decode_all_entries)}} --}}

                                            <tr>
                                                @php
                                                    $get_land_services_name = App\Landservicestypes::where('id_land_and_services_types', $decode_all_entries[0]->land_service)
                                                        ->select('service_name')
                                                        ->join('land_services_types', 'land_services_types.id_land_services_types', '=', 'land_and_services_types.name')
                                                        ->first();
                                                    // dd($get_land_services_name);
                                                @endphp

                                                @isset($decode_all_entries[$i]->land_service)
                                                    <td> {{ $get_land_services_name->service_name }}
                                                    </td>
                                                @endisset

                                                @isset($decode_all_entries[$i]->transport)
                                                    <td>{{ $decode_all_entries[$i]->transport }}
                                                    </td>
                                                @endisset
                                                @isset($decode_all_entries[$i]->land_services_route)
                                                    <td>{{ $decode_all_entries[$i]->land_services_route }}
                                                    </td>
                                                @endisset

                                                {{-- {{dd($decode_person_pricing_details)}} --}}


                                            </tr>
                                        @endfor
                                    </tbody>
                                    
                                </table>
                            <div class="col-lg-12">
                                                                        Quotation ROE: <b>{{$q_details->default_rate_of_exchange_amt}}</b><span> - {{$q_details->default_rate_of_exchange}} </span> = Total (Quotation ROE): <b><?= $q_details->total * round($q_details->default_rate_of_exchange_amt) ?></b> = Total (Today ROE: <b><?= round($currency_rates->currency_rate)?></b> - <span><?= $currency_rates->currency_name?></span>): <b><?= round($q_details->total * $currency_rates->currency_rate) ?></b>
                                                                    </div>
                            @elseif($q_details->services_type == 'Hotel' && $services_type == 'Hotel')
                                <table class="table table-striped table-inverse table-responsive">
                                    <thead>
                                        <tr>
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
                                            // dd($decode_all_entries);
                                            // dd($decode_person_pricing_details);
                                            $get_size = sizeof($decode_person_pricing_details);
                                            // dd($hotel_json_decode_person_pricing_details);
                                            $i = 0;
                                        @endphp
                                        @for ($i; $i < $get_size; $i++)
                                            <tr>
                                                @php
                                                    $get_hotel_name = App\hotels::where('id_hotels', $decode_all_entries[$i]->hotel_name)
                                                        ->select('hotel_name')
                                                        ->first();
                                                    $get_room_type = App\room_type::where('id_room_types', $decode_all_entries[$i]->room_type)
                                                        ->select('name')
                                                        ->first();
                                                @endphp

                                                <td> {{ $get_hotel_name?->hotel_name }}
                                                </td>
                                                <td>{{ $get_room_type?->name }}
                                                </td>
                                                <td>{{ $decode_person_pricing_details[$i]->hotel_qty }}
                                                </td>
                                                <td>{{ $decode_person_pricing_details[$i]->hotel_nights }}
                                                </td>
                                                <td>{{ $decode_all_entries[$i]->hotel_addon != 'Select Addon' ? $decode_all_entries[$i]->hotel_addon : '-' }}
                                                </td>
                                                <td> @if($get_rejected_issuance?->service_type == \Crypt::decrypt(request()->services_type))
                                                        <button type="button" disabled
                                                                 onclick="reject_issuance('{{ request()->uniq_id }}','{{ request()->inq_id }}','{{ request()->services_type }}')"
                                                                 class="btn-sm btn btn-danger">Issuance Rejected</button>
                                                        @elseif($get_rejected_issuance?->service_type !== request()->services_type)
                                                        <button type="button"
                                                                 onclick="reject_issuance('{{ request()->uniq_id }}','{{ request()->inq_id }}','{{ request()->services_type }}','{{ $i }}')"
                                                                 class="btn-sm btn btn-danger">Reject Issuance</button>
                                                         <button @if (check_issuance_verification(null, $q_details->quotation_id, $i, 'Hotel')) @endif
                                                        class=" btn-sm btn btn-primary"
                                                        onclick="send_for_verification('{{ request()->uniq_id }}','{{ request()->inq_id }}','{{ request()->services_type }}','{{ \Crypt::encrypt($i) }}')">Send
                                                        For Verification</button>
                                                        @endif
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                                <table class="table table-striped table-inverse table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Hotel Check In</th>
                                            <th>Hotel Check Out</th>
                                            <th>Adult</th>
                                            <th>Children</th>
                                            <th>Infant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // dd($decode_all_entries);
                                            // dd($decode_person_pricing_details);
                                            $get_size = sizeof($decode_person_pricing_details);
                                            // dd($hotel_json_decode_person_pricing_details);
                                            $i = 0;
                                        @endphp
                                        @for ($i; $i < $get_size; $i++)
                                            <tr>
                                                @php
                                                    $get_hotel_name = App\hotels::where('id_hotels', $decode_all_entries[$i]->hotel_name)
                                                        ->select('hotel_name')
                                                        ->first();
                                                    $get_room_type = App\room_type::where('id_room_types', $decode_all_entries[$i]->room_type)
                                                        ->select('name')
                                                        ->first();
                                                @endphp

                                                <td>{{ $decode_all_entries[$i]->hotel_check_in }}
                                                </td>
                                                <td>{{ $decode_all_entries[$i]->hotel_check_out }}
                                                </td>
                                                <td>{{ $decode_person_pricing_details[$i]->hotel_adult_cost_price }}
                                                </td>
                                                <td>{{ $decode_person_pricing_details[$i]->hotel_children_cost_price }}
                                                </td>
                                                <td>{{ $decode_person_pricing_details[$i]->hotel_infant_cost_price }}
                                                </td>
                                            </tr>
                                            @endfor
                                    </tbody>
                                </table>
                                      <div class="row">
                                    <div class="col-lg-12">
                                                                        Quotation ROE: <b>{{$q_details->default_rate_of_exchange_amt}}</b><span> - {{$q_details->default_rate_of_exchange}} </span> = Total (Quotation ROE): <b><?= $q_details->total * round($q_details->default_rate_of_exchange_amt) ?></b> = Total (Today ROE: <b><?= round($currency_rates->currency_rate)?></b> - <span><?= $currency_rates->currency_name?></span>): <b><?= round($q_details->total * $currency_rates->currency_rate) ?></b>
                                                                    </div>
                                </div>               
                            @endif
                            </div>
                            </td>

                            @if ($q_details->services_type == $services_type)
                                <td class="text-center">{{ $q_details->services_type }}</td>
                            @endif

                            @if ($q_details->services_type == 'Visa' && $services_type == 'Visa')
                                {{-- {{dd($decode_sub_total_details)}} --}}
                                <td class="text-center">
                                    {{ $decode_sub_total_details[0]->visa_total_cost_price }}</td>
                                <td class="text-center">
                                    {{ $decode_sub_total_details[0]->visa_discount ? $decode_sub_total_details[0]->visa_discount : '-' }}
                                </td>
                                <td class="text-center">
                                    {{ $decode_sub_total_details[0]->visa_total }}</td>
                            @elseif ($q_details->services_type == 'Air Ticket' && $services_type == 'Air Ticket')
                                <td class="text-center">
                                    {{ $decode_sub_total_details[0]->airline_total }}</td>
                                <td class="text-center">
                                    {{ $decode_sub_total_details[0]->airline_discount ? $decode_sub_total_details[0]->airline_discount : '-' }}
                                </td>
                                <td class="text-center">
                                    {{ $decode_sub_total_details[0]->airline_total }}</td>
                            @elseif($q_details->services_type == 'Land Services' && $services_type == 'Land Services')
                                <td class="text-center">
                                    {{ $decode_sub_total_details[0]->land_services_sub_total }}
                                </td>
                                <td class="text-center">
                                    {{ $decode_sub_total_details[0]->land_services_discount ? $decode_sub_total_details[0]->land_services_discount : '-' }}
                                </td>
                                <td class="text-center">
                                    {{ $decode_sub_total_details[0]->land_services_total }}</td>
                            @elseif($q_details->services_type == 'Hotel' && $services_type == 'Hotel')
                                <td class="text-center">
                                    {{ $decode_sub_total_details[0]->hotel_total_cost_price }}</td>
                                <td class="text-center">
                                    {{ $decode_sub_total_details[0]->hotel_discount ? $decode_sub_total_details[0]->hotel_discount : '-' }}
                                </td>
                                <td class="text-center">
                                    {{ $decode_sub_total_details[0]->hotel_total }}</td>
                            @endif
                             @if ($q_details->services_type == $services_type)
                                <td class="text-center">{{ $q_details->discount }}</td>
                                <td class="text-center">{{ $q_details->total }}</td>
                            @endif
                            {{-- <td class="text-center">{{$decode_sub_total_details[0]->visa_total_cost_price}}</td> --}}
                            {{-- <td class="text-center">{{ $decode_sub_total_details[0]->visa_discount }}</td> --}}
                            {{-- {{dd($decode_sub_total_details[0])}} --}}
                            </tr>
                            @endforeach
                            <hr>
                            <tr>
                                <th scope="row" colspan="5" class="border-1 text-end">
                                    Total Adult Selling Price :</th>
                                <td class="border-1 text-end">
                                    {{-- {{dd($decode_person_pricing_details)}} --}}
                                    {{ $decode_sub_total_details[0]->no_of_person_adult_selling_price }}/-
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" colspan="5" class="border-1 text-end">
                                    Total Children Selling Price :</th>
                                <td class="border-1 text-end">
                                    {{ $decode_sub_total_details[0]->no_of_person_children_selling_price }}/-
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" colspan="5" class="border-1 text-end">
                                    Total Infant Selling Price :</th>

                                <td class="border-1 text-end">
                                    {{ $decode_sub_total_details[0]->no_of_person_infant_selling_price }}/-
                                </td>
                            </tr>

                            <!-- end tr -->
                            {{-- <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">
                                                Discount</th>
                                            <td class="border-0 text-end">{{ $discount }}/-</td>
                                        </tr> --}}
                            <!-- end tr -->

                            <tr>
                                <th scope="row" colspan="5" class="border-1 text-end">Total</th>
                                <td class="border-1 text-end">
                                    <h4 class="m-0 fw-semibold">{{ $total }}/-</h4>
                                </td>
                            </tr>
                            <!-- end tr -->
                            </tbody><!-- end tbody -->
                            </table><!-- end table -->
                        </div><!-- end table responsive -->
                        <div class="d-print-none mt-4">
                            <div class="float-end">
                                <a href="javascript:window.print()" class="btn btn-success me-1"><i
                                        class="fa fa-print"></i></a>
                                        
                                        @if($get_rejected_issuance?->service_type == \Crypt::decrypt(request()->services_type))
                                   <button type="button" disabled
                                            onclick="reject_issuance('{{ request()->uniq_id }}','{{ request()->inq_id }}','{{ request()->services_type }}')"
                                            class="btn-sm btn btn-danger">Issuance Rejected</button>
                                   @elseif($get_rejected_issuance?->service_type !== \Crypt::decrypt(request()->services_type))
                                   <button type="button"
                                            onclick="reject_issuance('{{ request()->uniq_id }}','{{ request()->inq_id }}','{{ request()->services_type }}')"
                                            class="btn-sm btn btn-danger">Reject Issuance</button>
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
        <script type="text/javascript">
               
        
    </script>
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
