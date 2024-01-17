@extends('layouts.master')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.6/dist/flatpickr.min.css">
    <style>
        .popover.clockpicker-popover.bottom.clockpicker-align-left {
            position: absolute;
        }

        .badge-primary {
            border: 1px solid #00beda;
            color: white;
            background: #00beda;
        }

        /* Styles for small screens */
        @media (max-width: 576px) {
            .card-body {
                padding: 10px;
            }

            .form-group {
                margin-bottom: 10px;
            }

            .btn {
                margin-top: 10px;
            }

            .table-responsive {
                overflow-x: auto;
            }

            .table {
                width: 100%;
            }

            .table td,
            .table th {
                padding: 5px;
                font-size: 12px;
            }

            .fc-datepicker {
                width: 100%;
            }
        }

        /* Styles for medium screens */
        @media (min-width: 577px) and (max-width: 992px) {
            .card-body {
                padding: 20px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .btn {
                margin-top: 15px;
            }

            .table-responsive {
                overflow-x: auto;
            }

            .table {
                width: 100%;
            }

            .table td,
            .table th {
                padding: 10px;
                font-size: 14px;
            }

            .fc-datepicker {
                width: 100%;
            }
        }

        /* Styles for large screens */
        @media (min-width: 993px) {
            .card-body {
                padding: 30px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .btn {
                margin-top: 20px;
            }

            .table-responsive {
                overflow-x: auto;
            }

            .table {
                width: 100%;
            }

            .table td,
            .table th {
                padding: 15px;
                font-size: 16px;
            }

            .fc-datepicker {
                width: 100%;
            }
        }

        .cell-1 {
            border-collapse: separate;
            border-spacing: 0 4em;
            border-bottom: 5px solid transparent;
            background-clip: padding-box;
            cursor: pointer;
        }



        .table-elipse {
            cursor: pointer
        }

        #demo {
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            -o-transition: all 0.3s 0.1s ease-in-out;
            transition: all 0.3s ease-in-out
        }


        .table td.collapse.in {
            display: table-cell;
        }

        button {
            background-color: white;
            color: grey;
            border: 0;
            font-size: 14px;
            font-weight: 500;
            border-radius: 7px;
            padding: 10px 10px;
            cursor: pointer;
            white-space: nowrap;
        }
    </style>
    <div class="az-content-breadcrumb">
        <span>Inquiry</span>
        {{-- <span>Add Airline</span> --}}
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline"> Issuance Verification & QUOTATION VIEW: INQUIRY# <span
            class="badge badge-success fs-2">{{ $dec_inq_id }} </span> <span class="badge badge-info fs-5"><a
                href="{{ url('customers') }}"
                style="text-decoration: none;color: white;font-size:28px;">{{ $get_customer->customer_name }}</a></span>
        <span class="badge badge-dark fs-5"><a href="{{ url('customers') }}"
                style="text-decoration: none;color: white;font-size:28px;">{{ $get_customer->customer_cell }}</a></span><span>
            <a href="{{ url('inquiry/create') }}" class="btn btn-az-primary" style="float: right">ADD NEW INQUIRY</a></span>
    </h2>
    <div class="row">
        <div class="col-md-12">
            <div class="card  bg-white">
                <img class="card-img-top" src="holder.js/100px180/" alt="">
                <div class="card-body">
                    <h4 class="card-title">Inquiry Details</h4>
                    <br>
                    @php
                        $get_inq_type = App\inquirytypes::where('type_id', $get_inquiry->inquiry_type)->first();
                        $get_campaign = App\campaign::where('id_campaigns', $get_inquiry->campaign_id)->first();
                        $get_sales_reference = App\sales_reference::where('type_id', $get_inquiry->sale_reference)->first();
                    @endphp
                    <div class="row" style="font-size:16px;">
                        <div class="col-md-2">
                            <ul style="list-style-type:none;">
                                <li>INQUIRY#</li>
                                <li>CUSTOMER:</li>
                                <li>CONTACT</li>
                                <li>INQUIRY TYPE</li>
                            </ul>
                        </div>
                        <div class="col-md-2" style="font-weight:bold;">
                            <ul style="list-style-type:none;">
                                <li>{{ $dec_inq_id }}</li>
                                <li><a href="{{ url('customers') }}"
                                        style="text-decoration: none;color: white">{{ $get_customer->customer_name }}</a>
                                </li>
                                <li>{{ $get_customer->customer_cell }}</li>
                                <li>{{ $get_inq_type->type_name }}</li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <ul style="list-style-type:none;">
                                <li>ADULT:</li>
                                <li>CHILD:</li>
                                <li>INFANT</li>
                                <li>TRAVEL DATE:</li>
                            </ul>
                        </div>
                        <div class="col-md-2" style="font-weight:bold;">
                            <ul style="list-style-type:none;">
                                <li>{{ $get_inquiry->no_of_adults }}</li>
                                <li>{{ $get_inquiry->no_of_children }}</li>
                                <li>{{ $get_inquiry->no_of_infants }}</li>
                                <li>{{ $get_inquiry->travel_date }}</li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <ul style="list-style-type:none;">
                                <li>CITY:</li>
                                <li>SALES REFERENCE:</li>
                                <li>FOLLOW-UP DATE:</li>
                                <li>CAMPAIGN:</li>
                            </ul>
                        </div>
                        <div class="col-md-2" style="font-weight:bold;">
                            <ul style="list-style-type:none;">
                                <li>{{ $get_inquiry->city }}</li>
                                <li>{{ $get_sales_reference?->type_name }}</li>
                                <li>
                                    @if ($get_latest_remarks != null)
                                        {{ $get_latest_remarks->followup_date }}
                                    @else
                                        -
                                    @endif
                                </li>
                                <li>{{ $get_campaign?->campaign_name }}</li>
                            </ul>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            @php
                                $decode_services = json_decode($get_inquiry->services_sub_services);
                                foreach ($decode_services as $key => $value) {
                                    $explode = explode('/', $value);
                                    $get_services = App\other_service::where('id_other_services', $explode[0])->first();
                                    $service_name[] = $get_services->service_name;
                                }

                            @endphp
                            @php
                                $decode_sub_services = json_decode($get_inquiry->services_sub_services);
                                foreach ($decode_sub_services as $key => $value) {
                                    $explode = explode('/', $value);
                                    $explode_sub = explode(',', $explode[1]);
                                    foreach ($explode_sub as $key => $sub_value) {
                                        $get_sub_services = App\other_service::where('id_other_services', $sub_value)->first();
                                        $sub_service_name[] = $get_sub_services->service_name;
                                    }
                                    // $explode_sub=explode(','.$explode[1]);
                                }
                                // dd($sub_service_name);
                            @endphp
                            <h6 class="fs-5">Services :</h6>
                            @foreach ($service_name as $name)
                                <li class="mt-2">
                                    <span class="fs-5">{{ $name }}</span> :
                                    @foreach ($sub_service_name as $key => $sub_name)
                                        @if ($key > $key - 1)
                                        @endif
                                        <span class="badge badge-success"
                                            style="font-size:16px;">{{ $sub_name }}</span>
                                    @endforeach
                                </li>
                            @endforeach


                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="card bd-0">
        <div class="card-header bg-gray-400 bd-b-0-f pd-b-0">
            <nav style="    display: inline-flex" class="nav nav-tabs">
                @foreach ($get_quotation_details as $key => $quote_detail)
                    <a class="nav-link @if ($key == 0) active @endif " data-bs-toggle="tab"
                        href="#tabCont{{ $key }}">{{ $quote_detail->services_type }}</a>
                @endforeach
                {{-- <a class="nav-link" data-bs-toggle="tab" href="#tabCont4">Visa</a> --}}
            </nav>
            <a href="{{ url('/create_service_voucher/' . \Crypt::encrypt($quote_detail->quotation_id)) }}"
                style="position: relative;
            top: -17px" @if ($voucher_create == 0) disabled @endif
                class="btn btn-az-primary float-end">Create
                Voucher</a>
        </div><!-- card-header -->
        <div class="card-body bd bd-t-0 tab-content">
            @foreach ($get_quotation_details as $key => $quote_detail)
                {{-- {{dd($quote_detail)}} --}}
                <div id="tabCont{{ $key }}"
                    class="tab-pane show @if ($key == 0) active @endif ">
                    <div class="row">

                        <div class="col-md-12" style="height: 500px !important;">
                            <div class="card bg-white" style="height: 498px;">
                                <div class="card-body"
                                    style="    height: 498px;
                            overflow: auto;">
                                    <h4 class="card-title "><u>{{ $quote_detail->services_type }} Details</u></h4>
                                    <p class="card-text"></p>
                                    <div class="row ">
                                        {{-- <div class="col-md-12"> --}}
                                        <iframe style="height:400px"
                                            src="{{ url('view_quotation_of_verification/' . \Crypt::encrypt($quote_detail->quotation_id) . '/' . \Crypt::encrypt($quote_detail->inquiry_id) . '/' . \Crypt::encrypt($quote_detail->services_type)) }}"
                                            frameborder="0"></iframe>
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                        @endphp
                        <div class="col-md-12 mt-2">
                            <div class="card bd-0">
                                <div class="card-header bg-gray-400 bd-b-0-f pd-b-0">
                                    <nav class="nav nav-tabs">
                                        {{-- @foreach ($get_issuance as $key2 => $issue)
                                            {{ dd($issue->send_for_verification) }}
                                            @if ($issue->services_type == 'Visa' || $issue->services_type == 'Air Ticket')
                                                @if ($issue->send_for_verification == 1 && $issue->services_type == $quote_detail->services_type)
                                                    <a class="nav-link active" data-bs-toggle="tab"
                                                        href="#tabCont{{ $key }}1">Adult</a>
                                                    <a class="nav-link" data-bs-toggle="tab"
                                                        href="#tabCont{{ $key }}2">Child</a>
                                                @endif


                                            @endif
                                        @endforeach --}}
                                    </nav>
                                </div><!-- card-header -->
                                <div class="card-body bd bd-t-0 tab-content">
                                    <div id="tabCont{{ $key }}1" class="tab-pane show active">
                                        <form action="{{ url('submit_issuance_details') }}" method="POST">
                                            {{-- {{dd()}} --}}
                                            @if ($quote_detail->services_type == 'Visa')
                                                @for ($i = 0; $i < count($get_issuance); $i++)
                                                    @if ($get_issuance[$i]->services_type == 'Visa')
                                                        <input type="hidden" name="issuance_id"
                                                            value="{{ $get_issuance[$i]->id_quotation_issuance }}">

                                                        @php
                                                            $get_visa_issuance_id = $get_issuance[$i]->id_quotation_issuance;
                                                            $get_visa_quo_id = $get_issuance[$i]->quotation_id;
                                                            $get_visa_inq_id = $get_issuance[$i]->inquiry_id;
                                                        @endphp
                                                    @endif
                                                @endfor
                                                <input type="hidden" name="quotation_id"
                                                    value="{{ $get_issuance[$key]->quotation_id }}">
                                                <input type="hidden" name="services_type" value="Visa">

                                                {{-- <input type="hidden" id="{{$get_issuance[$key]}}"> --}}
                                                @for ($i = 0; $i < $get_inquiry->no_of_adults; $i++)
                                                    <h4>Adult No {{ $i + 1 }}</h4>
                                                    <input type="hidden" name="person[]" value="adult">
                                                    <hr>
                                                    @php
                                                        // dd($get_visa_inq_id);
                                                        $get_documents = get_documents($get_visa_inq_id, $i, 'adult', $get_inquiry->no_of_adults, $get_inquiry->no_of_children);
                                                        // dd($get_documents);
                                                        $dec_visa = json_decode(check_issuance_details($get_visa_issuance_id, $get_visa_quo_id, $i, 'Visa'));
                                                        // dd($dec_visa != null);
                                                        // dd($dec_visa[0]);
                                                    @endphp
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Given Name<span
                                                                        style="color: red">*</span></label>
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="text" class="form-control"
                                                                    @if (isset($dec_visa[0]->given_name[$i])) value="{{ $dec_visa[0]->given_name[$i] }}" disabled @else value="{{ $get_documents->given_name }}" @endif
                                                                    name="given_name[]" id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Sur Name<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="text" class="form-control" name="sur_name[]"
                                                                    id=""
                                                                    @if (isset($dec_visa[0]->sur_name[$i])) value="{{ $dec_visa[0]->sur_name[$i] }}"  disabled @else value="{{ $get_documents->sur_name }}" @endif>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Passport Number<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="text" class="form-control"
                                                                    @if (isset($dec_visa[0]->passport_no[$i]) && $dec_visa != null) value="{{ $dec_visa[0]->passport_no[$i] }}" disabled  @else value="{{ $get_documents->passport_no }}" @endif
                                                                    name="passport_no[]" id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Visa Number<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}

                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="text" class="form-control"
                                                                    @if ($dec_visa != null) value="{{ $dec_visa[0]->visa_number[$i] }}" disabled  @else value="{{ isset($get_documents->visa_number) ? $get_documents->visa_number : '' }}" @endif
                                                                    name="visa_number[]" id="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Vendor<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <select @if (isset($dec_visa[0])) disabled @endif
                                                                    name="vendor[]" class="select2 form-control"
                                                                    style="width: 100%" id="">
                                                                    <option value="">Select</option>
                                                                    @foreach ($vendors as $vendor)
                                                                        <option
                                                                            @if (check_vendor_issuance($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa') == $vendor->id_service_vendors) selected @endif
                                                                            value="{{ $vendor->id_service_vendors }}">
                                                                            {{ $vendor->vendor_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Validity<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="number" min="1" class="form-control"
                                                                    @if (isset($dec_visa[0]->validity[$i])) value="{{ $dec_visa[0]->validity[$i] }}" disabled  @else value="{{ $get_documents->validity }}" @endif
                                                                    name="validity[]" id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Expiry<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="text" placeholder="15/Sep/23"
                                                                    @if (isset($dec_visa[0]->expiry[$i])) value="{{ $dec_visa[0]->expiry[$i] }}" disabled  @else value="{{ $get_documents->expiry }}" @endif
                                                                    class="form-control fc-datepicker" name="expiry[]"
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">MOFA #<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="text" class="form-control" name="mofa[]"
                                                                    @if (isset($dec_visa[0]->mofa[$i])) value="{{ $dec_visa[0]->mofa[$i] }}" disabled  @else @endif
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">PNR #<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="text" class="form-control" name="pnr[]"
                                                                    @if (isset($dec_visa[0]->pnr[$i])) disabled value="{{ $dec_visa[0]->pnr[$i] }}"  disabled @else @endif
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">CNIC<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else  disabled @endif
                                                                    type="text" class="form-control nic"
                                                                    name="cnic[]"
                                                                    data-inputmask="'mask': '99999-9999999-9'"
                                                                    placeholder="XXXXX-XXXXXXX-X"
                                                                    @if (isset($dec_visa[0]->cnic[$i])) value="{{ $dec_visa[0]->cnic[$i] }}" disabled  @else value="{{ $get_documents->cnic }}" @endif>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Gender<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <select @if (isset($dec_visa[0])) disabled @endif
                                                                    name="gender[]" class="select2 form-control"
                                                                    style="width: 100%" id="">
                                                                    <option
                                                                        @if ($get_documents->gender == 'Male') selected @endif
                                                                        value="Male">Male</option>
                                                                    <option
                                                                        @if ($get_documents->gender == 'Female') selected @endif
                                                                        value="Female">Female</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        @csrf
                                                    </div>
                                                @endfor
                                                @for ($i = 0; $i < $get_inquiry->no_of_children; $i++)
                                                    <h4>Child No {{ $i + 1 }}</h4>
                                                    <input type="hidden" name="person[]" value="child">
                                                    <hr>
                                                    @php
                                                        $get_documents = get_documents($get_visa_inq_id, $i, 'child', $get_inquiry->no_of_adults, $get_inquiry->no_of_children);
                                                        // dd($get_documents);
                                                        $dec_visa = json_decode(check_issuance_details($get_visa_issuance_id, $get_visa_quo_id, $i, 'Visa'));
                                                        //  dd($dec_visa[0]);
                                                    @endphp
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Given Name<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input type="text"
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    class="form-control" name="given_name[]" required
                                                                    @if (isset($dec_visa[0]->given_name[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->given_name[$get_inquiry->no_of_adults + $i] }}" disabled  @else value="{{ $get_documents->given_name }}" @endif
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Sur Name<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input type="text"
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    class="form-control" name="sur_name[]" required
                                                                    @if (isset($dec_visa[0]->sur_name[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->sur_name[$get_inquiry->no_of_adults + $i] }}" disabled  @else value="{{ $get_documents->sur_name }}" @endif
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Passport
                                                                    Number<span style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input type="text"
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    class="form-control" name="passport_no[]" required
                                                                    @if (isset($dec_visa[0]->passport_no[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->passport_no[$get_inquiry->no_of_adults + $i] }}" disabled  @else value="{{ $get_documents->passport_no }}" @endif
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Visa Number<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="text" class="form-control"
                                                                    @if (isset($dec_visa[0]->visa_number[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->visa_number[$get_inquiry->no_of_adults + $i] }}" disabled  @else value="{{ isset($get_documents->visa_number) ? $get_documents->visa_number : '' }}" @endif
                                                                    name="visa_number[]" required id="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Vendor<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <select @if (isset($dec_visa[0])) disabled @endif
                                                                    name="vendor[]" required class="select2 form-control"
                                                                    style="width: 100%" id="">
                                                                    <option value="">Select</option>
                                                                    @foreach ($vendors as $vendor)
                                                                        <option
                                                                            @if (check_vendor_issuance($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa') == $vendor->id_service_vendors) selected @endif
                                                                            value="{{ $vendor->id_service_vendors }}">
                                                                            {{ $vendor->vendor_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Validity<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="number" required min="1"
                                                                    @if (isset($dec_visa[0]->validity[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->validity[$get_inquiry->no_of_adults + $i] }}" disabled  @else value="{{ $get_documents->validity }}" @endif
                                                                    class="form-control" name="validity[]"
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Expiry<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="text" required placeholder="15/Sep/23"
                                                                    @if (isset($dec_visa[0]->expiry[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->expiry[$get_inquiry->no_of_adults + $i] }}" disabled  @else value="{{ $get_documents->expiry }}" @endif
                                                                    class="form-control fc-datepicker" name="expiry[]"
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">MOFA #<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="text" required class="form-control"
                                                                    @if (isset($dec_visa[0]->mofa[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->mofa[$get_inquiry->no_of_adults + $i] }}" disabled  @else @endif
                                                                    name="mofa[]" id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">PNR #<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="text" class="form-control" name="pnr[]"
                                                                    @if (isset($dec_visa[0]->pnr[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->pnr[$get_inquiry->no_of_adults + $i] }}" disabled  @else @endif
                                                                    required id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">CNIC<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else  disabled @endif
                                                                    type="text" class="form-control cnic"
                                                                    name="cnic[]"
                                                                    data-inputmask="'mask': '99999-9999999-9'"
                                                                    placeholder="XXXXX-XXXXXXX-X"
                                                                    @if (isset($dec_visa[0]->cnic[$i])) value="{{ $dec_visa[0]->cnic[$i] }}" disabled  @else value="{{ $get_documents->cnic }}" @endif>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Gender<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <select @if (isset($dec_visa[0])) disabled @endif
                                                                    name="gender[]" class="select2 form-control"
                                                                    style="width: 100%" id="">
                                                                    <option
                                                                        @if ($get_documents->gender == 'Male') selected @endif
                                                                        value="Male">Male</option>
                                                                    <option
                                                                        @if ($get_documents->gender == 'Female') selected @endif
                                                                        value="Female">Female</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        @csrf

                                                    </div>
                                                @endfor
                                                @for ($i = 0; $i < $get_inquiry->no_of_infants; $i++)
                                                    <h4>Infant No {{ $i + 1 }}</h4>
                                                    <input type="hidden" name="person[]" value="infant">
                                                    <hr>
                                                    @php
                                                        $get_documents = get_documents($get_visa_inq_id, $i, 'infant', $get_inquiry->no_of_adults, $get_inquiry->no_of_infants);
                                                        // dd($get_documents);
                                                        $dec_visa = json_decode(check_issuance_details($get_visa_issuance_id, $get_visa_quo_id, $i, 'Visa'));
                                                        //  dd($dec_visa[0]);
                                                    @endphp
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Given Name<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input type="text"
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    class="form-control" name="given_name[]" required
                                                                    @if (isset($dec_visa[0]->given_name[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->given_name[$get_inquiry->no_of_adults + $i] }}" disabled  @else value="{{ $get_documents->given_name }}" @endif
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Sur Name<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input type="text"
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    class="form-control" name="sur_name[]" required
                                                                    @if (isset($dec_visa[0]->sur_name[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->sur_name[$get_inquiry->no_of_adults + $i] }}" disabled  @else value="{{ $get_documents->sur_name }}" @endif
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Passport
                                                                    Number<span style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input type="text"
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    class="form-control" name="passport_no[]" required
                                                                    @if (isset($dec_visa[0]->passport_no[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->passport_no[$get_inquiry->no_of_adults + $i] }}" disabled  @else value="{{ $get_documents->passport_no }}" @endif
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Visa Number<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="text" class="form-control"
                                                                    @if (isset($dec_visa[0]->visa_number[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->visa_number[$get_inquiry->no_of_adults + $i] }}" disabled  @else value="{{ isset($get_documents->visa_number) ? $get_documents->visa_number : '' }}" @endif
                                                                    name="visa_number[]" required id="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Vendor<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <select @if (isset($dec_visa[0])) disabled @endif
                                                                    name="vendor[]" required class="select2 form-control"
                                                                    style="width: 100%" id="">
                                                                    <option value="">Select</option>
                                                                    @foreach ($vendors as $vendor)
                                                                        <option
                                                                            @if (check_vendor_issuance($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa') == $vendor->id_service_vendors) selected @endif
                                                                            value="{{ $vendor->id_service_vendors }}">
                                                                            {{ $vendor->vendor_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Validity<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="number" required min="1"
                                                                    @if (isset($dec_visa[0]->validity[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->validity[$get_inquiry->no_of_adults + $i] }}" disabled  @else value="{{ $get_documents->validity }}" @endif
                                                                    class="form-control" name="validity[]"
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Expiry<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="text" required placeholder="15/Sep/23"
                                                                    @if (isset($dec_visa[0]->expiry[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->expiry[$get_inquiry->no_of_adults + $i] }}" disabled  @else value="{{ $get_documents->expiry }}" @endif
                                                                    class="form-control fc-datepicker" name="expiry[]"
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">MOFA #<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="text" required class="form-control"
                                                                    @if (isset($dec_visa[0]->mofa[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->mofa[$get_inquiry->no_of_adults + $i] }}" disabled  @else @endif
                                                                    name="mofa[]" id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">PNR #<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else disabled @endif
                                                                    type="text" class="form-control" name="pnr[]"
                                                                    @if (isset($dec_visa[0]->pnr[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->pnr[$get_inquiry->no_of_adults + $i] }}" disabled  @else @endif
                                                                    required id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">CNIC<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_visa_issuance_id, $get_visa_quo_id, null, 'Visa')) @else  disabled @endif
                                                                    type="text" class="form-control cnic"
                                                                    name="cnic[]"
                                                                    data-inputmask="'mask': '99999-9999999-9'"
                                                                    placeholder="XXXXX-XXXXXXX-X"
                                                                    @if (isset($dec_visa[0]->cnic[$i])) value="{{ $dec_visa[0]->cnic[$i] }}" disabled  @else value="{{ $get_documents->cnic }}" @endif>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Gender<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <select @if (isset($dec_visa[0])) disabled @endif
                                                                    name="gender[]" class="select2 form-control"
                                                                    style="width: 100%" id="">
                                                                    <option
                                                                        @if ($get_documents->gender == 'Male') selected @endif
                                                                        value="Male">Male</option>
                                                                    <option
                                                                        @if ($get_documents->gender == 'Female') selected @endif
                                                                        value="Female">Female</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        @csrf

                                                    </div>
                                                @endfor
                                                <div class="form-group mt-2">
                                                    <button type="submit" id="btn_sub"
                                                        @if (isset($dec_visa[0])) disabled @endif
                                                        class="btn btn-success  text-white w-100">Add</button>
                                                </div>
                                            @endif
                                            @if ($quote_detail->services_type == 'Hotel')
                                                @for ($i = 0; $i < count($get_issuance); $i++)
                                                    @if ($get_issuance[$i]->services_type == 'Hotel')
                                                        @php
                                                            $get_hotel_issuance_id = $get_issuance[$i]->id_quotation_issuance;
                                                            $get_hotel_quotation_id = $get_issuance[$i]->id_quotation;
                                                        @endphp
                                                        <input type="hidden" name="issuance_id"
                                                            value="{{ $get_issuance[$i]->id_quotation_issuance }}">
                                                    @endif
                                                @endfor
                                                <input type="hidden" name="quotation_id"
                                                    value="{{ $get_issuance[$key]->quotation_id }}">
                                                <input type="hidden" name="services_type" value="Hotel">
                                                @php
                                                    $json_decode = json_decode($quote_detail->all_entries);
                                                @endphp
                                                @foreach ($json_decode as $leg_no => $hotel)
                                                    {{-- {{dd($get_issuance[$leg_no])}} --}}
                                                    {{-- @php
                                                        echo $leg_no;

                                                    @endphp --}}
                                                    @if (check_issuance_verification($get_hotel_issuance_id, $get_hotel_quotation_id, $leg_no, 'Hotel'))
                                                        <input type="hidden" name="legs[]"
                                                            value="{{ $leg_no }}">
                                                    @else
                                                    @endif
                                                    <h4>Hotel# {{ $leg_no + 1 }}</h4>
                                                    @php
                                                        $dec_hotel = json_decode(check_issuance_details($get_hotel_issuance_id, $get_hotel_quotation_id, $leg_no, 'Hotel'));
                                                        // dd($dec_hotel[0]->vendor_reference);
                                                    @endphp
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                @csrf
                                                                <label for="" class="mt-2">Vendor Reference
                                                                    #<span style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_hotel_issuance_id, $get_hotel_quotation_id, $leg_no, 'Hotel')) @else disabled @endif
                                                                    type="text" class="form-control" required
                                                                    @if (isset($dec_hotel[0]->vendor_reference)) disabled value="{{ $dec_hotel[0]->vendor_reference }}" @endif
                                                                    name="vendor_reference[]" id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Hotel confirmation
                                                                    #<span style="color: red">*</span></label>
                                                                <input
                                                                    @if (check_issuance_verification($get_hotel_issuance_id, $get_hotel_quotation_id, $leg_no, 'Hotel')) @else disabled @endif
                                                                    required type="text" min="1"
                                                                    @if (isset($dec_hotel[0]->hotel_confirmation)) disabled value="{{ $dec_hotel[0]->hotel_confirmation }}" @endif
                                                                    class="form-control" name="hotel_confirmation[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Vendor<span
                                                                        style="color: red">*</span></label>
                                                                <select
                                                                    @if (check_issuance_verification($get_hotel_issuance_id, $get_hotel_quotation_id, $leg_no, 'Hotel')) @else disabled @endif
                                                                    required
                                                                    @if (isset($dec_hotel[0]->hotel_confirmation)) disabled value="{{ $dec_hotel[0]->hotel_confirmation }}" @endif
                                                                    name="vendor[]" class="select2 form-control"
                                                                    style="width: 100%" id="">
                                                                    <option value="">Select</option>
                                                                    @foreach ($vendors as $vendor)
                                                                        <option
                                                                            @if (check_vendor_issuance($get_hotel_issuance_id, $get_hotel_quotation_id, $leg_no, 'Hotel') ==
                                                                                    $vendor->id_service_vendors) selected @endif
                                                                            value="{{ $vendor->id_service_vendors }}">
                                                                            {{ $vendor->vendor_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mt-2">
                                                            <button
                                                                @if (check_issuance_verification($get_hotel_issuance_id, $get_hotel_quotation_id, $leg_no, 'Hotel')) @else disabled @endif
                                                                type="submit" id="btn_sub"
                                                                @if (isset($dec_hotel[0]->hotel_confirmation)) disabled value="{{ $dec_hotel[0]->hotel_confirmation }}" @endif
                                                                class="btn btn-success  text-white ">Add</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @if ($quote_detail->services_type == 'Land Services')
                                                @for ($i = 0; $i < count($get_issuance); $i++)
                                                    @if ($get_issuance[$i]->services_type == 'Land Services')
                                                        <input type="hidden" name="issuance_id"
                                                            value="{{ $get_issuance[$i]->id_quotation_issuance }}">
                                                        @php
                                                            $get_land_issuance_id = $get_issuance[$i]->id_quotation_issuance;
                                                            $get_land_quo_id = $get_issuance[$i]->quotation_id;
                                                        @endphp
                                                    @endif
                                                @endfor
                                                <input type="hidden" name="quotation_id"
                                                    value="{{ $get_issuance[$key]->quotation_id }}">
                                                <input type="hidden" name="services_type" value="Land Services">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            @csrf

                                                            @php
                                                                $dec_land = json_decode(check_issuance_details($get_land_issuance_id, $get_land_quo_id, $i, 'Land Services'));
                                                                //    dd();
                                                            @endphp
                                                            <label for="" class="mt-2">Land Services<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}

                                                            <select @if (isset($dec_land[0]) && $dec_land[0]) disabled @endif
                                                                @if (check_issuance_verification($get_land_issuance_id, $get_land_quo_id, $leg_no, 'Land Services')) @else disabled @endif
                                                                name="land_services[]" class="form-control select2"
                                                                style="width: 100%" id="">
                                                                <option @if (isset($dec_land[0]) && $dec_land[0]->land_services[0] == 'private') selected @endif
                                                                    value="private">Private</option>
                                                                <option @if (isset($dec_land[0]) && $dec_land[0]->land_services[0] == 'self') selected @endif
                                                                    value="self">Self</option>
                                                                <option @if (isset($dec_land[0]) && $dec_land[0]->land_services[0] == 'public') selected @endif
                                                                    value="public">Public</option>
                                                            </select>


                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Vendor<span
                                                                    style="color: red">*</span></label>

                                                            <select @if (isset($dec_land[0]) && $dec_land[0]) disabled @endif
                                                                name="vendor[]" class="select2 form-control"
                                                                style="width: 100%" id="">
                                                                <option value="">Select</option>
                                                                @foreach ($vendors as $vendor)
                                                                    <option
                                                                        @if (check_vendor_issuance($get_land_issuance_id, $get_land_quo_id, null, 'Land Services') ==
                                                                                $vendor->id_service_vendors) selected @endif
                                                                        value="{{ $vendor->id_service_vendors }}">

                                                                        {{ $vendor->vendor_name }}</option>
                                                                @endforeach
                                                            </select>


                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group mt-2">
                                                    <button @if (check_issuance_verification($get_land_issuance_id, $get_land_quo_id, null, 'Land Services')) @else disabled @endif
                                                        type="submit" id="btn_sub"
                                                        @if (isset($dec_land[0]) && $dec_land[0]) disabled @endif
                                                        class="btn btn-success btn-block text-white w-100">Add</button>
                                                </div>
                                            @endif
                                            @if ($quote_detail->services_type == 'Air Ticket')
                                                @for ($i = 0; $i < count($get_issuance); $i++)
                                                    @if ($get_issuance[$i]->services_type == 'Air Ticket')
                                                        <input type="hidden" name="issuance_id"
                                                            value="{{ $get_issuance[$i]->id_quotation_issuance }}">
                                                        @php
                                                            $get_airline_issuance_id = $get_issuance[$i]->id_quotation_issuance;
                                                            $get_airline_quo_id = $get_issuance[$i]->quotation_id;
                                                            $dec_visa = json_decode(check_issuance_details($get_airline_issuance_id, $get_airline_quo_id, $i, 'Air Ticket'));
                                                            // dd($dec_visa[0]);
                                                        @endphp
                                                    @endif
                                                @endfor
                                                <input type="hidden" name="quotation_id"
                                                    value="{{ $get_issuance[$key]->quotation_id }}">
                                                <input type="hidden" name="services_type" value="Air Ticket">

                                                @for ($i = 0; $i < $get_inquiry->no_of_adults; $i++)
                                                    <h4>Adult No {{ $i + 1 }}</h4>
                                                    <hr>
                                                    <input type="hidden" name="person[]" value="adult">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Given Name<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket')) @else disabled @endif
                                                                    type="text" class="form-control"
                                                                    @if (isset($dec_visa[0]->given_name[$i])) value="{{ $dec_visa[0]->given_name[$i] }}" disabled  @else @endif
                                                                    name="given_name[]" id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Sur Name<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket')) @else disabled @endif
                                                                    @if (isset($dec_visa[0]->sur_name[$i])) value="{{ $dec_visa[0]->sur_name[$i] }}" disabled  @else @endif
                                                                    type="text" class="form-control" name="sur_name[]"
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Ticket Number<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket')) @else disabled @endif
                                                                    type="text" class="form-control"
                                                                    @if (isset($dec_visa[0]->ticket_number[$i])) value="{{ $dec_visa[0]->ticket_number[$i] }}" disabled  @else @endif
                                                                    name="ticket_number[]" id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Airline PNR<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket')) @else disabled @endif
                                                                    type="text" class="form-control"
                                                                    @if (isset($dec_visa[0]->airline_pnr[$i])) value="{{ $dec_visa[0]->airline_pnr[$i] }}" disabled  @else @endif
                                                                    name="airline_pnr[]" id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">System PNR<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket')) @else disabled @endif
                                                                    type="text" class="form-control"
                                                                    @if (isset($dec_visa[0]->system_pnr[$i])) value="{{ $dec_visa[0]->system_pnr[$i] }}" disabled  @else @endif
                                                                    name="system_pnr[]" id="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Vendor<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <select @if (isset($dec_visa[0]) && $dec_visa[0]) disabled @endif
                                                                    name="vendor[]" class="select2 form-control"
                                                                    style="width: 100%" id="">
                                                                    <option value="">Select</option>
                                                                    @foreach ($vendors as $vendor)
                                                                        <option
                                                                            @if (check_vendor_issuance($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket') ==
                                                                                    $vendor->id_service_vendors) selected @endif
                                                                            value="{{ $vendor->id_service_vendors }}">
                                                                            {{ $vendor->vendor_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>


                                                        @csrf

                                                    </div>
                                                @endfor
                                                @for ($i = 0; $i < $get_inquiry->no_of_children; $i++)
                                                    <h4>Child No {{ $i + 1 }}</h4>
                                                    <hr>
                                                    <input type="hidden" name="person[]" value="child">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Given Name<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket')) @else disabled @endif
                                                                    type="text" class="form-control"
                                                                    @if (isset($dec_visa[0]->given_name[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->given_name[$get_inquiry->no_of_adults + $i] }}" disabled  @else @endif
                                                                    name="given_name[]" id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Sur Name<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket')) @else disabled @endif
                                                                    type="text" class="form-control" name="sur_name[]"
                                                                    @if (isset($dec_visa[0]->sur_name[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->sur_name[$get_inquiry->no_of_adults + $i] }}" disabled  @else @endif
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Ticket
                                                                    Number<span style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket')) @else disabled @endif
                                                                    type="text" class="form-control"
                                                                    @if (isset($dec_visa[0]->ticket_number[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->ticket_number[$get_inquiry->no_of_adults + $i] }}" disabled  @else @endif
                                                                    name="ticket_number[]" id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Airline PNR<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input type="text"
                                                                    @if (check_issuance_verification($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket')) @else disabled @endif
                                                                    class="form-control" name="airline_pnr[]"
                                                                    @if (isset($dec_visa[0]->airline_pnr[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->airline_pnr[$get_inquiry->no_of_adults + $i] }}" disabled  @else @endif
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">System PNR<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket')) @else disabled @endif
                                                                    type="text" class="form-control"
                                                                    @if (isset($dec_visa[0]->system_pnr[$get_inquiry->no_of_adults + $i])) value="{{ $dec_visa[0]->system_pnr[$get_inquiry->no_of_adults + $i] }}" disabled  @else @endif
                                                                    name="system_pnr[]" id="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Vendor<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <select @if (isset($dec_visa[0])) disabled @endif
                                                                    name="vendor[]" class="select2 form-control"
                                                                    style="width: 100%" id="">
                                                                    <option value="">Select</option>
                                                                    @foreach ($vendors as $vendor)
                                                                        <option
                                                                            @if (check_vendor_issuance($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket') ==
                                                                                    $vendor->id_service_vendors) selected @endif
                                                                            value="{{ $vendor->id_service_vendors }}">
                                                                            {{ $vendor->vendor_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        @csrf
                                                    </div>
                                                @endfor
                                                @for ($i = 0; $i < $get_inquiry->no_of_infants; $i++)
                                                    <h4>Infant No {{ $i + 1 }}</h4>
                                                    <hr>
                                                    {{-- {{ dd($dec_visa) }} --}}
                                                    <input type="hidden" name="person[]" value="infant">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Given Name<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket')) @else disabled @endif
                                                                    type="text" class="form-control"
                                                                    @if (isset($dec_visa[0]->given_name[$get_inquiry->no_of_adults + $get_inquiry->no_of_children + $i])) value="{{ $dec_visa[0]->given_name[$get_inquiry->no_of_adults + $get_inquiry->no_of_children + $i] }}" disabled  @else @endif
                                                                    name="given_name[]" id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Sur Name<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket')) @else disabled @endif
                                                                    type="text" class="form-control" name="sur_name[]"
                                                                    @if (isset($dec_visa[0]->sur_name[$get_inquiry->no_of_adults + $get_inquiry->no_of_children + $i])) value="{{ $dec_visa[0]->sur_name[$get_inquiry->no_of_adults + $get_inquiry->no_of_children + $i] }}" disabled  @else @endif
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Ticket
                                                                    Number<span style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket')) @else disabled @endif
                                                                    type="text" class="form-control"
                                                                    @if (isset($dec_visa[0]->ticket_number[$get_inquiry->no_of_adults + $get_inquiry->no_of_children + $i])) value="{{ $dec_visa[0]->ticket_number[$get_inquiry->no_of_adults + $get_inquiry->no_of_children + $i] }}" disabled  @else @endif
                                                                    name="ticket_number[]" id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Airline PNR<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input type="text"
                                                                    @if (check_issuance_verification($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket')) @else disabled @endif
                                                                    class="form-control" name="airline_pnr[]"
                                                                    @if (isset($dec_visa[0]->airline_pnr[$get_inquiry->no_of_adults + $get_inquiry->no_of_children + $i])) value="{{ $dec_visa[0]->airline_pnr[$get_inquiry->no_of_adults + $get_inquiry->no_of_children + $i] }}" disabled  @else @endif
                                                                    id="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">System PNR<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <input
                                                                    @if (check_issuance_verification($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket')) @else disabled @endif
                                                                    type="text" class="form-control"
                                                                    @if (isset($dec_visa[0]->system_pnr[$get_inquiry->no_of_adults + $get_inquiry->no_of_children + $i])) value="{{ $dec_visa[0]->system_pnr[$get_inquiry->no_of_adults + $get_inquiry->no_of_children + $i] }}" disabled  @else @endif
                                                                    name="system_pnr[]" id="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="mt-2">Vendor<span
                                                                        style="color: red">*</span></label>
                                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                <select @if (isset($dec_visa[0])) disabled @endif
                                                                    name="vendor[]" class="select2 form-control"
                                                                    style="width: 100%" id="">
                                                                    <option value="">Select</option>
                                                                    @foreach ($vendors as $vendor)
                                                                        <option
                                                                            @if (check_vendor_issuance($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket') ==
                                                                                    $vendor->id_service_vendors) selected @endif
                                                                            value="{{ $vendor->id_service_vendors }}">
                                                                            {{ $vendor->vendor_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        @csrf
                                                    </div>
                                                @endfor
                                                <div class="form-group mt-2">
                                                    <button @if (check_issuance_verification($get_airline_issuance_id, $get_airline_quo_id, null, 'Air Ticket')) @else disabled @endif
                                                        type="submit" id="btn_sub"
                                                        @if (isset($dec_visa[0])) disabled  @else @endif
                                                        class="btn btn-success btn-block text-white w-100">Add</button>
                                                </div>
                                            @endif
                                        </form>
                                    </div>
                                    {{-- @if ($quote_detail->services_type == 'Visa' || $quote_detail->services_type == 'Air Ticket')
                                        <div id="tabCont{{ $key }}2" class="tab-pane show">
                                            <form action="{{ url('submit_issuance_details') }}" method="POST">
                                                @if ($quote_detail->services_type == 'Visa')
                                                    <input type="hidden" name="issuance_id"
                                                        value="{{ $get_issuance[$key]->id_quotation_issuance }}">
                                                    <input type="hidden" name="quotation_id"
                                                        value="{{ $get_issuance[$key]->quotation_id }}">
                                                    <input type="hidden" name="services_type"
                                                        value="{{ $get_issuance[$key]->services_type }}">


                                                    <div class="form-group mt-2">
                                                        <button type="submit"
                                                            class="btn btn-success btn-block text-white w-100">Add</button>
                                                    </div>
                                                @endif

                                                @if ($quote_detail->services_type == 'Air Ticket')
                                                    <input type="hidden" name="issuance_id"
                                                        value="{{ $get_issuance[$key]->id_quotation_issuance }}">
                                                    <input type="hidden" name="quotation_id"
                                                        value="{{ $get_issuance[$key]->quotation_id }}">
                                                    <input type="hidden" name="services_type"
                                                        value="{{ $get_issuance[$key]->services_type }}">


                                                    <div class="form-group mt-2">
                                                        <button type="submit" id="btn_sub"
                                                            class="btn btn-success btn-block text-white w-100">Add</button>
                                                    </div>
                                                @endif
                                            </form>
                                        </div>
                                    @endif --}}
                                </div><!-- card-body -->
                            </div>

                        </div>

                    </div>
                </div><!-- tab-pane -->
            @endforeach
        </div><!-- card-body -->
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">


@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>



    <script>
        $(".nic").inputmask();
    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('.fc-datepicker').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                dateFormat: 'd/M/y',
            });
        });
    </script>
@endpush
