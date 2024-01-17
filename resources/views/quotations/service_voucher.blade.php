<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Service Voucher</title>
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
                        <div class="invoice-title">
                            <h4 class="float-end font-size-15">MANABIR
                                <span class="badge bg-primary font-size-12 ms-2">TRAVOCOM (PVT.) LIMITED (MB)</span>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg"
                                    style="height:150px;" />

                            </h4>

                            <div class="mb-4">
                                <h2 class="mb-1 text-muted"><img src="{{ asset('img/logo.png') }}"
                                        style="height:100px;"></h2>
                            </div>
                            <div class="text-muted">
                                <p class="mb-1">TRAVOCOM (PVT) LTD.</p>
                                <p class="mb-1">Voucher Date: <span><b>{{ date('m/d/y') }} </b></span> </p>
                                <span></span>
                                <p class="mb-1">Package:</p>
                                <p class="mb-1">PAX:
                                    (<span>Adult:{{ $get_inquiry->no_of_adults }}</span><span>Children:{{ $get_inquiry->no_of_children }}</span><span>Infant:{{ $get_inquiry->no_of_infant }}</span>)
                                </p>
                            </div>
                        </div>
                        <center>
                            <h4>Service Voucher</h4>
                        </center>
                        <hr class="my-4">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Family Head: <span><b>{{ $head_name }}</b></span>
                                    </h5>

                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-sm-6">
                                <div class="text-muted text-sm-end">
                                    <div>
                                        <h5 class="font-size-15 mb-1">Inquiry No:
                                            <span><b>{{ $get_inquiry->id_inquiry }}</b></span>
                                        </h5>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">UM:</h5>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                        <hr>
                        <div class="card">
                            <div class="card-body">
                                <div class="py-2">
                                    <h5 class="font-size-15"><b>MUTAMERS</b></h5>

                                    <div class="table-responsive">
                                        <table class="table align-middle table-nowrap table-centered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>SNO</th>
                                                    <th>PASSPORT</th>
                                                    <th>MUTAMER NAME</th>
                                                    <th>PAX</th>
                                                    <th>MOFA #</th>
                                                    <th>VISA #</th>
                                                    <th>PNR</th>
                                                </tr>
                                            </thead><!-- end thead -->
                                            <tbody>
                                                @php
                                                    $decode_visa = json_decode($get_visa_details?->adult_entries);
                                                    // dd($decode_visa);
                                                    if (isset($decode_visa)) {
                                                        $count = count($decode_visa[0]->passport_no);
                                                    }
                                                    $key_count = 0;

                                                @endphp



                                                @isset($decode_visa)
                                                    @foreach ($decode_visa as $val)
                                                        @for ($i = 0; $i < $count; $i++)
                                                            <tr>

                                                                <td>{{ ++$key_count }}</td>
                                                                <td>{{ $val->passport_no[$i] }}</td>
                                                                <td>{{ $val->given_name[$i] }}{{ $val->sur_name[$i] }}
                                                                </td>
                                                                <td>{{ $val->person[$i] }}</td>
                                                                <td>{{ $val->mofa[$i] }}</td>
                                                                <td>{{ $val->visa_number[$i] }}</td>
                                                                <td>{{ $val->pnr[$i] }}</td>

                                                            </tr>
                                                        @endfor
                                                    @endforeach
                                                @endisset
                                            </tbody><!-- end tbody -->
                                        </table><!-- end table -->
                                    </div><!-- end table responsive -->
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-body">
                                <div class="py-2">
                                    <h5 class="font-size-15"><b>Accommodation</b></h5>

                                    <div class="table-responsive">
                                        <table class="table align-middle table-nowrap table-centered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>CITY</th>
                                                    <th>HOTEL NAME</th>
                                                    <th>CONF#</th>
                                                    <th>ROOM TYPE</th>
                                                    <th>CHECK-IN</th>
                                                    <th>NIGHTS</th>
                                                    <th>CHECK-OUT</th>
                                                </tr>
                                            </thead><!-- end thead -->
                                            <tbody>

                                                @php
                                                    $decode_hotel = json_decode($get_hotel_details?->adult_entries);
                                                @endphp
                                                @isset($decode_hotel)
                                                    @foreach ($decode_hotel as $val)
                                                        <tr>
                                                            <td>{{ get_hotel_issuance_details($get_hotel_details->quotation_id)['city'] }}
                                                            </td>
                                                            <td>{{ get_hotel_issuance_details($get_hotel_details->quotation_id)['hotel_name'] }}
                                                            </td>
                                                            <td>{{ $val->hotel_confirmation }}</td>
                                                            <td>{{ get_hotel_issuance_details($get_hotel_details->quotation_id)['room_type'] }}
                                                            </td>
                                                            <td>{{ get_hotel_issuance_details($get_hotel_details->quotation_id)['check_in'] }}
                                                            </td>
                                                            <td>{{ get_hotel_issuance_details($get_hotel_details->quotation_id)['hotel_nights'] }}
                                                            </td>
                                                            <td>{{ get_hotel_issuance_details($get_hotel_details->quotation_id)['check_out'] }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endisset
                                            </tbody><!-- end tbody -->
                                        </table><!-- end table -->
                                    </div><!-- end table responsive -->
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-body">
                                <div class="py-2">
                                    <h5 class="font-size-15"><b>TRANSPORT / SERVICES</b></h5>

                                    <div class="table-responsive">
                                        <table class="table align-middle table-nowrap table-centered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>TRANSPORTER</th>
                                                    <th>TYPE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @isset($get_land_services_details?->adult_entries)
                                                    @foreach (json_decode($get_land_services_details->adult_entries) as $val)
                                                        {{-- {{dd($val)}} --}}
                                                        <tr>
                                                            <td>{{ get_land_issuance_details($get_land_services_details->quotation_id)['transport'] }}
                                                            </td>
                                                            <td>{{ $val->land_services[0] }}</td>

                                                        </tr>
                                                    @endforeach
                                                @endisset
                                                {{-- {{dd($)}} --}}
                                            </tbody><!-- end tbody -->
                                        </table><!-- end table -->
                                    </div><!-- end table responsive -->
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-body">
                                <div class="py-2">
                                    <h5 class="font-size-15"><b>FLIGHT DETAILS</b></h5>

                                    <div class="table-responsive">
                                        <table class="table align-middle table-nowrap table-centered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>SNO</th>
                                                    <th>FLIGHT</th>
                                                    <th>ARRIVAL DATE</th>
                                                    <th>ARRIVAL TIME</th>
                                                    <th>DEPARTURE TIME</th>
                                                    <th>AIRLINE FLIGHT</th>
                                                    <th>Ticket #</th>
                                                    <th>Airline PNR</th>
                                                    <th>System PNR</th>
                                                </tr>
                                            </thead><!-- end thead -->
                                            <tbody>
                                                @isset($get_ticket_details)
                                                    @foreach (json_decode($get_ticket_details?->adult_entries) as $key => $val)
                                                        {{-- {{dd($val)}} --}}
                                                        @php
                                                            $count_flight = count($val->person);
                                                            $number = 0;
                                                        @endphp
                                                        @for ($i = 0; $i < $count_flight; $i++)
                                                            <tr>
                                                                <td>{{ ++$number }}</td>
                                                                <td>{{ get_flight_issuance_details($dec_id)[$key]['flight_no'] }}
                                                                </td>
                                                                <td>{{ get_flight_issuance_details($dec_id)[$key]['airline_arrival_date'] }}
                                                                </td>
                                                                <td>{{ get_flight_issuance_details($dec_id)[$key]['arrival_time'] }}
                                                                </td>
                                                                <td>{{ get_flight_issuance_details($dec_id)[$key]['departure_time'] }}
                                                                </td>
                                                                <td>{{ get_flight_issuance_details($dec_id)[$key]['airline_flight_class'] }}
                                                                </td>
                                                                <td>{{ $val->ticket_number[$i] }}</td>
                                                                <td>{{ $val->airline_pnr[$i] }}</td>
                                                                <td>{{ $val->system_pnr[$i] }}</td>

                                                            </tr>
                                                        @endfor
                                                    @endforeach
                                                @endisset
                                            </tbody><!-- end tbody -->
                                        </table><!-- end table -->
                                    </div><!-- end table responsive -->
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4>Special Instructions:</h4>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
    </div>

</body>

</html>
