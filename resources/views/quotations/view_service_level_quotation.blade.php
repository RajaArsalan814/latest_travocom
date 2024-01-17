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
           <script type="text/javascript">
        function disapproved(quotation_id, inquiry_id) {

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
                            url: "{{ url('quotation_disapproved/') }}/" + quotation_id + "/" + inquiry_id,
                            data: {
                                cancel_reason: get_cancel_reason
                            },
                            success: function(response) {
                                Swal.fire('Quotation Rejected!', '', 'success');
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire('Please Enter Valid Cancel Reason!', '', 'error');
                    }
                } else if (result.isDenied) {}
            })
        }
        
        //Approval
        function approval(quotation_id, inquiry_id) {

            Swal.fire({
                title: '<strong class="">Enter Approval Remarks</strong>',
                icon: 'success',
                html: '<textarea id="cancel_reason" class="form-control" style="height:80px;" ></textarea>',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: '<strong>Approve</strong>',
                cancelButtonText: '<strong>Cancel</strong>',
            }).then((result) => {


                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {

                    var get_cancel_reason = $('#cancel_reason').val();

                    if (get_cancel_reason.length > 0) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('quotation_approved/') }}/" + quotation_id + "/" + inquiry_id,
                            data: {
                                cancel_reason: get_cancel_reason
                            },
                            success: function(response) {
                                Swal.fire('Quotation Approved!', '', 'success');
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire('Please Enter Valid Cancel Reason!', '', 'error');
                    }
                } else if (result.isDenied) {}
            })
        }
    </script>
</head>

<body>
    

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <h4 class="float-end font-size-15">{{ $get_quotation->quotation_no }}
                                <span class="badge bg-primary font-size-12 ms-2">Service Level</span>
                                @if ($get_quotation->status == 0)
                                    <span class="badge bg-primary font-size-12 ms-2">Pending</span>
                                @endif
                            </h4>
                            <div class="mb-4">
                                <h2 class="mb-1 text-muted"><img src="{{ asset('img/logo.png') }}"
                                        style="height:100px;"></h2>
                            </div>
                            <div class="text-muted">
                                <p class="mb-1">Travocom, Travel and Tour Company</p>
                                <p class="mb-1">A-251, PIA-ECHS, Gulistan-e-Johar Block 9, PIA Housing Society,
                                    Karachi.</p>
                                <p class="mb-1"><i class="uil uil-envelope-alt me-1"></i>support@travocom.com</p>
                                <p><i class="uil uil-phone me-1"></i> 09-00-78601</p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Quotatation To:</h5>
                                    <h5 class="font-size-15 mb-2">{{ $get_customer->customer_name }}</h5>
                                    <p class="mb-1">{{ $get_customer->customer_email }}</p>
                                    <p>{{ $get_customer->customer_cell }}</p>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-sm-6">
                                <div class="text-muted text-sm-end">
                                    <div>
                                        <h5 class="font-size-15 mb-1">Quotation No:</h5>
                                        <p>{{ $get_quotation->quotation_no }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Quotation Date:</h5>
                                        <p>{{ $get_quotation->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="py-2">
                            <h5 class="font-size-15">Quotation Summary</h5>

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
                                                $visa_json_decode_person_pricing_details = json_decode($q_details->person_pricing_details);
                                                $air_ticket_json_decode_all_entries = json_decode($q_details->all_entries);
                                                $land_services_json_decode_all_entries = json_decode($q_details->all_entries);
                                                $land_services_json_decode_person_pricing_details = json_decode($q_details->person_pricing_details);
                                                $hotel_json_decode_person_pricing_details = json_decode($q_details->person_pricing_details);
                                                $hotel_json_decode_all_entries = json_decode($q_details->all_entries);
                                                $get_sub_total_entries = json_decode($q_details->sub_total_details);
                                                
                                                 //dd($land_services_json_decode_all_entries);
                                                // dd($get_sub_total_entries);
                                            @endphp
                                            <tr>
                                                <th scope="row">{{ $key = $key + 1 }}</th>
                                                <td>
                                                    <div>
                                                        @if ($q_details->services_type == 'Visa')
                                                            <table
                                                                class="table table-striped table-inverse table-responsive">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Visa Service</th>
                                                                        <th>Adult CP</th>
                                                                        <th>Child CP</th>
                                                                        <th>Infant CP</th>
                                                                        <th>Adult SP</th>
                                                                        <th>Child SP</th>
                                                                        <th>Infant SP</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($visa_json_decode_all_entries as $visa_all_entries)
                                                                        <tr>
                                                                            <td scope="row">
                                                                                @php
                                                                                    $visa_name = App\Visa_rates::where('id_visa_rates', $visa_all_entries->visa_service)
                                                                                        ->select('name')
                                                                                        ->first();
                                                                                @endphp
                                                                                {{ $visa_name->name }}
                                                                            </td>
                                                                        @foreach ($visa_json_decode_person_pricing_details as $visa_details)    
                                                                            <td>{{$visa_details->visa_adult_cost_price}}</td>
                                                                            <td>{{$visa_details->visa_infant_cost_price}}</td>
                                                                            <td>{{$visa_details->visa_children_cost_price}}</td>
                                                                            <td>{{$visa_details->visa_adult_selling_price}}</td>
                                                                            <td>{{$visa_details->visa_infant_selling_price}}</td>
                                                                            <td>{{$visa_details->visa_children_selling_price}}</td>
                                                                        @endforeach    
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        @elseif($q_details->services_type == 'Air Ticket')
                                                            <table
                                                                class="table table-striped table-inverse table-responsive">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Airline Name</th>
                                                                        <th>Flight No</th>
                                                                        <th>Airline Arrival Date</th>
                                                                        <th>Airline Arrival Destination</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($air_ticket_json_decode_all_entries as $air_ticket_all_entries)
                                                                        <tr>
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
                                                                            <td>{{ $air_ticket_all_entries?->airline_arrival_date }}
                                                                            </td>
                                                                            <td>{{ $air_ticket_all_entries?->airline_arrival_destination }}
                                                                            </td>

                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            <table
                                                                class="table table-striped table-inverse table-responsive">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Airline Departure Destination</th>
                                                                        <th>Arrival Time</th>
                                                                        <th>Departure Time</th>
                                                                        <th>Airline Flight Class</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($air_ticket_json_decode_all_entries as $air_ticket_all_entries)
                                                                        <tr>

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
                                                        @elseif($q_details->services_type == 'Land Services')
                                                            <table
                                                                class="table table-striped table-inverse table-responsive">
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
                                                                    @foreach ($land_services_json_decode_all_entries as $land_services_all_entries)
                                                                        <!--<tr>-->
                                                                            @foreach ($land_services_json_decode_person_pricing_details as $land_pricing)
                                                                                  
                                                                        <tr>
                                                                            <td scope="row">
                                                                                @php
                                                                                    $get_land_services_name = App\Landservicestypes::where('id_land_and_services_types', $land_services_all_entries->land_service)
                                                                                        ->select('service_name')
                                                                                        ->join('land_services_types', 'land_services_types.id_land_services_types', '=', 'land_and_services_types.name')
                                                                                        ->groupBy('id_land_and_services_types')->first();
                                                                                        
                                                                                        $get_land_service_route = App\Route::where('id_route', $land_services_all_entries?->land_services_route)->first();
                                                                                     //dd($get_land_service_route->route_location);
                                                                                @endphp
                                                                                {{ $get_land_services_name->service_name }}
                                                                            </td>
                                                                            <td>{{ $land_services_all_entries?->transport }}
                                                                            </td>
                                                                            <td>{{ $get_land_service_route?->route_location }}
                                                                            </td>
                                                                            <td>{{ $land_pricing?->land_services_cost_price }}
                                                                            </td>
                                                                            <td>{{ $land_pricing?->land_services_selling_price }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                            <!--</tr>-->
                                            
                                        @endforeach
                                        <?php dd($land_services_json_decode_person_pricing_details);?>
                                    </tbody>
                                </table>
                            @elseif($q_details->services_type == 'Hotel')
                                <table class="table table-striped table-inverse table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Hotel Name</th>
                                            <th>Room Type</th>
                                            <th>Qty</th>
                                            <th>Nights</th>
                                            <th>Hotel Addon</th>
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



                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                                <table class="table table-striped table-inverse table-responsive">
                                    <thead>
                                        <tr>
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

                                                <td>{{ $hotel_json_decode_person_pricing_details[$i]->hotel_cost_price }}
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
                            
                            <td class="text-center">{{ $q_details->services_type }}</td>
                            @if ($q_details->services_type == 'Visa')
                                <td class="text-center">{{ $get_sub_total_entries[0]->visa_total_selling_price }}</td>
                            @elseif ($q_details->services_type == 'Air Ticket')
                                <td class="text-center">{{ $get_sub_total_entries[0]->airline_total_selling_price }}
                                </td>
                            @elseif($q_details->services_type == 'Land Services')
                                <td class="text-center">{{ $q_details->sub_total }}</td>
                            @elseif($q_details->services_type == 'Hotel')
                                <td class="text-center">{{ $get_sub_total_entries[0]->hotel_total_selling_price }}</td>
                            @endif
                            <td class="text-center">{{ $q_details->discount }}</td>
                            <td class="text-center">{{ $q_details->total }}</td>
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
                            <?php 
                                    $hotel_exchange_total = null;
                                    $visa_exchange_total = null;
                                    $land_exchange_total = null;
                                    $ticket_exchange_total = null;
                                    $quote_grand_total = null;
                                    
                            if(isset($total)){
                                        foreach($total as $quote_total){
                                            if($quote_total->services_type == 'Hotel'){
                                                $hotel_exchange_total = $quote_total->total*$quote_total->default_rate_of_exchange_amt;
                                            }
                                            if($quote_total->services_type == 'Visa'){
                                                $visa_exchange_total = $quote_total->total*$quote_total->default_rate_of_exchange_amt;
                                            }
                                            if($quote_total->services_type == 'Land Services'){
                                                $land_exchange_total = $quote_total->total*$quote_total->default_rate_of_exchange_amt;
                                            }
                                            if($quote_total->services_type == 'Air Ticket'){
                                                $ticket_exchange_total = $quote_total->total;
                                            }
                                            
                                        }
                                        $quote_grand_total = $hotel_exchange_total+$visa_exchange_total+$land_exchange_total+$ticket_exchange_total;
//                                        dd($quote_grand_total);
                            }
                            ?>
                            <tr>
                                <th scope="row" colspan="5" class="border-1 text-end">Total</th>
                                <td class="border-1 text-end">
                                    <h4 class="m-0 fw-semibold">{{ $quote_grand_total }}/-</h4>
                                </td>
                            </tr>
                            <!-- end tr -->
                            </tbody><!-- end tbody -->
                            </table><!-- end table -->
                            </div><!-- end table responsive -->
                            @if ($get_approval_group !== null)

                            @if($get_quotation_approval > 0)

                            @if($get_rejected_remarks !== 1 && $get_approval_remarks !== 1)
                            <div style="position: fixed;

                                bottom: 500px;

                                left: 500px;
                                Top:200px;
                                z-index: 10000;

                                font-size:100px;

                                color: orange;

                                transform:rotate(-30deg);

                                opacity: 0.4;">

                                UN-APPROVED

                            </div>
                            <div class="d-print-none mt-4" style="float:right;border:1px solid lightgrey;padding:5px;border-radius:5%;">
                                <label class="form-control">Approve / Reject</label><br>
                                <button onclick="approval('{{ Crypt::encrypt($q_details->quotation_id) }}', '{{ Crypt::encrypt($q_details->inquiry_id)}}')"
                                                        class="btn btn-success"><i class="fa fa-check text-white"></i></a>
                                     
                            <button
                                                        onclick="disapproved('{{ Crypt::encrypt($q_details->quotation_id) }}', '{{ Crypt::encrypt($q_details->inquiry_id)}}')"
                                                        class="btn btn-danger" style="float:right;"><i
                                                            class="fa fa-ban text-white"></i></button>
                            {{-- <div class="float-end">
                                <a href="javascript:window.print()" class="btn btn-success me-1"><i
                                        class="fa fa-print"></i></a>
                                <!--<a href="#" class="btn btn-primary w-md">Send</a>-->
                            </div> --}}
                        </div>
                        @elseif($get_rejected_remarks == 1)
                        <div style="position: fixed;

                                bottom: 500px;

                                left: 500px;
                                Top:200px;
                                z-index: 10000;

                                font-size:100px;

                                color: red;

                                transform:rotate(-30deg);

                                opacity: 0.4;">

                            REJECTED

                        </div>
                        <br>
                        <center><h3 style="color:red;">QUOTATION REJECTED</h3><h6>Reason: <?=$get_rejected_reason?->cancel_reason?></h6></center>
                        @elseif($get_approval_remarks == 1)
                        <div style="position: fixed;

                                bottom: 500px;

                                left: 500px;
                                Top:200px;
                                z-index: 10000;

                                font-size:100px;

                                color: green;

                                transform:rotate(-30deg);

                                opacity: 0.4;">

                            APPROVED

                        </div>
                        <br>
                        <center><h3 style="color:green;">QUOTATION APPROVED</h3><h6>Reason: <?=$get_approval_reason?->remarks_status?></h6></center>
                        
                        @endif
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div><!-- end col -->
    </div>
    </div>

</body>

</html>
@push('scripts')
    
@endpush
