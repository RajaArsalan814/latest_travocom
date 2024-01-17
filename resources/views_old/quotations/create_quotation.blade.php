@extends('layouts.master')
@section('content')
    <style>

    </style>
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
    <h2 class="az-content-title" style="display: inline">  <span
            class="badge badge-success fs-2">CRM#{{ $dec_inq_id }} </span>
                <a href="{{ url('customers') }}" style="text-decoration: none;color:gray; font-size:28px;"> {{ $get_customer->customer_name }}</a>
        | <a href="{{ url('customers') }}"
                style="text-decoration: none;color: gray;font-size:28px;">{{ $get_customer->customer_cell }}</a><span>
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
                        <div class="col-md-3">
                            @php
                                $decode_services = json_decode($get_inquiry->services_sub_services);
                                // dd( $decode_services);
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
                                    <span class="fs-5">{{ $name }}</span> :<br>
                                    @foreach ($sub_service_name as $key => $sub_name)
                                        @if ($key > $key - 1)
                                        @endif
                                        <span class="badge badge-round badge-success"
                                            style="font-size:16px;">{{ $sub_name }}</span>
                                    @endforeach
                                </li>
                            @endforeach


                        </div>
                        <div class="col-md-3" style="border-left:1px solid lightgray;">
                            <h6 class="fs-5">Quotation Status :</h6>
                            @if (isset($get_quotation_status->remarks_status) && $get_quotation_status->remarks_status == 'Quotation Approved')
                                <button class="btn btn-rounded btn-success  mb-3" style="color:#fff;" disabled>
                                    <span style="color:white">{{ $get_quotation_status?->remarks_status }}</span>
                                </button>
                            @elseif(isset($get_quotation_status->remarks_status))
                                <button class="btn btn-rounded btn-danger  mb-3" style="color:#fff;" disabled>
                                    <span style="color:white">{{ $get_quotation_status?->remarks_status }}</span>
                                </button>
                            @endif
                            @if (!isset($get_quotation_status->remarks_status))
                                <button class="btn btn-rounded btn-danger  mb-3" style="color:#fff;" disabled>
                                    <span style="color:white">N/A</span>
                                </button>
                            @endif
                        </div>
                        <div class="col-md-3" style="border-left:1px solid lightgray;">
                            <h6 class="fs-5">Issuance Status :</h6>

                            @if (isset($get_quotation_status->remarks_status))
                                <button class="btn btn-rounded btn-success  mb-3" style="color:#fff;" disabled>
                                    <span style="color:white">{{ $get_issuance_status?->status }}</span>
                                </button>
                            @else
                                <button class="btn btn-rounded btn-danger  mb-3" style="color:#fff;" disabled>
                                    <span style="color:white">N/A</span>
                                </button>
                            @endif


                        </div>
                        <div class="col-md-3" style="border-left:1px solid lightgray;">
                            <h6 class="fs-5">Payment Status :</h6>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="progress mg-b-20">
        <div class="progress-bar progress-bar-striped bg-warning wd-10p" role="progressbar" aria-valuenow="35"
            aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="card bd-0">
        <div class="card-header bg-gray-400 bd-b-0-f pd-b-0">
            <nav class="nav nav-tabs">
                <a class="nav-link active" data-bs-toggle="tab" href="#tabCont1">INQUIRY REMARKS @if ($all_remarks != null)<badge class='badge badge-success'>~</badge>@endif</a>
                <a class="nav-link" data-bs-toggle="tab" href="#tabCont2">FOLLOW-UPS / REMINDERS @if ($need_further_follow_ups != null)<badge class='badge badge-warning'>!</badge> @endif</a>
                <a class="nav-link" data-bs-toggle="tab" href="#tabCont3">QUOTATION REMARKS</a>
                <a class="nav-link" data-bs-toggle="tab" href="#tabCont5">ISSUANCE STATUS</a>
                <a class="nav-link" data-bs-toggle="tab" href="#tabCont6">ACCOUNTS <badge class='badge badge-warning'>!</badge></a>
                <a class="nav-link" data-bs-toggle="tab" href="#tabCont7">DOCUMENTATION <badge class='badge badge-warning'>!</badge></a>
                <a class="nav-link" data-bs-toggle="tab" href="#tabCont8">ESCALATIONS</a>
            </nav>
        </div><!-- card-header -->
        <div class="card-body bd bd-t-0 tab-content">
            <!--Inquiry Remarks-->
            <div id="tabCont1" class="tab-pane show active">
                <div class="row">

                    <div class="col-md-7" style="height: 500px !important;">
                        <div class="card bg-white" style="height: 498px;">
                            <div class="card-body" style="    height: 498px;
                            overflow: auto;">
                                <h4 class="card-title "><u>INQUIRY REMARKS</u></h4>
                                <p class="card-text"></p>
                                <div class="row ">
                                    @if ($all_remarks != null)
                                        @forelse ($all_remarks as $key => $remark)
                                            <div class="col-md-6 mt-2">
                                                <h6 class="text-warning" style="font-weight: 600">PROGRESS REMARKS</h6>
                                            </div>

                                            <div class="col-md-9 mt-2"><span class="text-success"><i
                                                        style="font-weight: 500">{{ $remark->remarks }}</i></span>
                                            </div>
                                            <div class="col-md-3 mt-2" style="position: relative;bottom: 34px;">
                                                @php
                                                    $user_name = App\User::where('id', $remark->created_by)
                                                        ->select('name')
                                                        ->first();
                                                @endphp

                                                <span class="text-secondary"> ~{{ $user_name->name }}</span><br>

                                                @if ($remark->followup_date)
                                                    <span class="">Follow Up Date :</span><span
                                                        class="badge badge-info mt-2">
                                                        {{ $remark->followup_date }}</span>
                                                @endif
                                                <span class="">Remarks Date :</span><span
                                                    class="badge badge-info mt-2">
                                                    {{ $remark->created_at }}</span>
                                                <span class="mt-2">

                                                    @if ($remark->remarks_status == 0)
                                                        <p class="">Status <span
                                                                class="badge badge-warning mt-2">Open</span></p>
                                                    @elseif($remark->remarks_status == 1)
                                                        <p class="">Status <span
                                                                class="badge badge-primary mt-2">In-Progress</span></p>
                                                    @elseif($remark->remarks_status == 2)
                                                        <p class="">Status <span
                                                                class="badge badge-Info mt-2">Quotation Shared</span></p>
                                                    @elseif($remark->remarks_status == 3)
                                                        <p class="">Status <span
                                                                class="badge badge-success mt-2">Confirmed</span></p>
                                                    @elseif($remark->remarks_status == 4)
                                                        <p class="">Status <span
                                                                class="badge badge-success mt-2">Completed</span></p>
                                                    @elseif($remark->remarks_status == 5)
                                                        <p class="">Status <span
                                                                class="badge badge-danger mt-2">Canceled</span></p>
                                                    @endif
                                                </span>
                                                @if ($remark->remarks_status == 5)
                                                    <span class="badge badge-danger"><span class="">Cancel Reason :
                                                        </span>
                                                        {{ $remark->cancel_reason }}</span>
                                                @endif
                                            </div>
                                            <hr class="mt-2">
                                        @empty
                                        @endforelse
                                    @endif
                                    <div class="col-md-6 mt-2">
                                        <h6 class="text-success" style="font-weight: 600">INITIAL REMARKS</h6>
                                    </div>

                                    <div class="col-md-9 mt-2"><span class="text-success"><i
                                                style="font-weight: 500">{{ $get_inquiry->remarks }}</i></span>
                                    </div>
                                    <div class="col-md-3 mt-2" style="position: relative;bottom: 34px;">
                                        @php
                                            $user_name = App\User::where('id', $get_inquiry->created_by)
                                                ->select('name')
                                                ->first();
                                            // dd($user_name);
                                        @endphp
                                        <span class="text-secondary"> ~{{ $user_name->name }}</span>
                                        <p class="">Remarks Date <span
                                                class="badge badge-info mt-2">{{ $get_inquiry->created_at }}</span></p>
                                        <p class="">Status <span class="badge badge-warning mt-2">Open</span></p>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 inline-flex" style="display: inline-block;height: 500px !important;">
                        <div class="card bg-white">
                            <div class="card-body">
                                <h4 class="card-title"><u>ADD PROGRESS REMARKS</u></h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        @if ($errors->any())
                                            @foreach ($errors->all() as $error)
                                                <span style="color: red">{{ $error }}</span>
                                            @endforeach
                                        @endif
                                        <form action="{{ url('add_inquiry_remarks') }}" id="submit_form" method="POST">
                                            <!--                                            <div class="form-group">
                                                                                                                                                                                                                                                                                                                                                                                                                                        <label for="" class="mt-2">FOLLOW-UP DATE <span
                                                                                                                                                                                                                                                                                                                                                                                                                                                style="color: red">*</span></label>
                                                                                                                                                                                                                                                                                                                                                                                                                                        <input type="text" name="followup_date" id="datetimepicker2"
                                                                                                                                                                                                                                                                                                                                                                                                                                               class="form-control">
                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>-->
                                            <input type="hidden" name="inquiry_id" value="{{ $dec_inq_id }}"
                                                id="">
                                            <div class="form-group">
                                                @csrf
                                                <label for="" class="mt-2">STATUS <span
                                                        style="color: red">*</span></label>
                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                <select class="select2 form-control" name="status" id="status">

                                                    <option
                                                        @if ($get_latest_remarks != null) @if ($get_latest_remarks->remarks_status == 1) selected @endif
                                                        @endif value="1">
                                                        In-Progress
                                                    </option>
                                                    <option
                                                        @if ($get_latest_remarks != null) @if ($get_latest_remarks->remarks_status == 4) selected @endif
                                                        @endif value="4">
                                                        Completed
                                                    </option>
                                                    <option
                                                        @if ($get_latest_remarks != null) @if ($get_latest_remarks->remarks_status == 5) selected @endif
                                                        @endif value="5">
                                                        Cancelled
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="reasons">
                                                @csrf
                                                <label for="" class="mt-2">Reason <span
                                                        style="color: red">*</span></label>
                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                <select class="select2 form-control" name="reason" id="reason_input">
                                                    <option value="">Select</option>
                                                    <option value="CANCELLED PLAN">CANCELLED PLAN</option>
                                                    <option value="POSTPONED">POSTPONED</option>
                                                    <option value="HIGH PRICE">HIGH PRICE</option>
                                                    <option value="ONLINE">ONLINE</option>
                                                    <option value="OTHER AGENT">OTHER AGENT</option>
                                                    <option value="INFO QUERY">INFO QUERY</option>
                                                    <option value="NOT RESPONDING">NOT RESPONDING</option>

                                                </select>
                                            </div>
                                            <div class="form-group" id="quotations">
                                                @csrf
                                                <label for="" class="mt-2">Quotations <span
                                                        style="color: red">*</span></label>
                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                <select class="select2 form-control" name="quotation"
                                                    id="quotations_input">
                                                    @foreach ($quotations_not_approved as $quote)
                                                        <option value="">Select</option>
                                                        <option value="{{ $quote->id_quotations }}">
                                                            {{ $quote->quotation_no }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="mt-2">Remarks<span
                                                        style="color: red">*</span></label>
                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                <textarea name="remarks" class="form-control" id="" cols="50" rows="50"></textarea>
                                            </div>
                                            <div class="form-group mt-2">
                                                <button type="submit" id="btn_sub"
                                                    class="btn btn-success btn-block text-white w-100">Add</button>
                                            </div>


                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- tab-pane -->
            <!--Follow-up Remarks-->
            <div id="tabCont2" class="tab-pane">
                <div class="row">

                    <div class="col-md-7" style="height: 500px !important;overflow: auto;">
                        <div class="card bg-white" style="height: 498px;overflow: auto;">
                            <div class="card-body">
                                <h4 class="card-title "><u>FOLLOW-UPS / REMINDERS</u></h4>
                                <div class="card bd-0">
                                    <div class="card-header bg-gray-400 bd-b-0-f pd-b-0">
                                        <nav class="nav nav-tabs">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#tabCont11">ALL</a>
                                            <a class="nav-link" data-bs-toggle="tab" href="#tabCont11">OPEN</a>
                                            <a class="nav-link" data-bs-toggle="tab" href="#tabCont33">CLOSED</a>
                                        </nav>
                                    </div><!-- card-header -->
                                    <div class="card-body bd bd-t-0 tab-content">
                                        <div id="tabCont11" class="tab-pane active show">
                                            <div class="row ">
                                                @if ($need_further_follow_ups != null)
                                                    {{-- get_need_follow_up_remarks --}}
                                                    @forelse ($need_further_follow_ups as $key => $remark)
                                                        <div class="col-md-6 mt-2">
                                                            <h6 class="text-warning" style="font-weight: 600">FOLLOW-UP
                                                                PROGRESS</h6>
                                                        </div>

                                                        <div class="col-md-9 mt-2"><span class="text-success"><i
                                                                    style="font-weight: 500">{{ $remark->remarks }}</i></span>
                                                        </div>
                                                        <div class="col-md-3 mt-2"
                                                            style="position: relative;bottom: 34px;">

                                                            @php
                                                                $user_name = App\User::where('id', $remark->created_by)
                                                                    ->select('name')
                                                                    ->first();
                                                            @endphp


                                                            <span class="text-secondary"><br>
                                                                ~{{ $user_name->name }}</span><br>
                                                            <span class="">Follow Up Date :</span><span
                                                                class="badge badge-info mt-2">
                                                                {{ $remark->followup_date }}</span>
                                                            <br>
                                                            <span class="">Remarks Date :</span><span
                                                                class="badge badge-info mt-2">
                                                                {{ $remark->created_at }}</span>
                                                            <span class="mt-2">
                                                                @if ($remark->followup_status == 'Open')
                                                                    <p class="">Status <span
                                                                            class="badge badge-warning mt-2">Open</span>
                                                                    </p>
                                                                @elseif($remark->followup_status == 'Need Further Follow-up')
                                                                    <p class="">Status <span
                                                                            class="badge badge-primary mt-2">Need Further
                                                                            Follow-up</span></p>
                                                                @elseif($remark->followup_status == 'Closed')
                                                                    <p class="">Status <span
                                                                            class="badge badge-danger mt-2">Closed</span>
                                                                    </p>
                                                                @endif
                                                            </span>
                                                            <span class="">
                                                                <p class="">Type <span
                                                                        class="badge badge-primary ">{{ get_follow_up_type($remark->followup_type) }}</span>
                                                                </p>
                                                            </span>
                                                            <span>
                                                                <button style="margin: 0px" type="button"
                                                                    onclick="edit_followup({{ $remark->id_followup_remarks }})"
                                                                    class="btn btn-sm  btn-warning">Edit</button>
                                                            </span>
                                                        </div>
                                                        @forelse (get_need_follow_up_remarks($remark->followup_id) as $key => $followup_detail)
                                                            <div class="col-md-6 mt-2">
                                                                <h6 class="text-warning" style="font-weight: 600">
                                                                    FOLLOW-UP
                                                                    PROGRESS</h6>
                                                            </div>

                                                            <div class="col-md-9 mt-2"><span class="text-success"><i
                                                                        style="font-weight: 500">{{ $remark->remarks }}</i></span>
                                                            </div>
                                                            <div class="col-md-3 mt-2"
                                                                style="position: relative;bottom: 34px;">

                                                                @php
                                                                    $user_name = App\User::where('id', $remark->created_by)
                                                                        ->select('name')
                                                                        ->first();
                                                                @endphp


                                                                <span class="text-secondary"><br>
                                                                    ~{{ $user_name->name }}</span><br>
                                                                <span class="">Follow Up Date :</span><span
                                                                    class="badge badge-info mt-2">
                                                                    {{ $remark->followup_date }}</span>
                                                                <br>
                                                                <span class="">Remarks Date :</span><span
                                                                    class="badge badge-info mt-2">
                                                                    {{ $remark->created_at }}</span>
                                                                <span class="mt-2">
                                                                    @if ($remark->followup_status == 'Open')
                                                                        <p class="">Status <span
                                                                                class="badge badge-warning mt-2">Open</span>
                                                                        </p>
                                                                    @elseif($remark->followup_status == 'Need Further Follow-up')
                                                                        <p class="">Status <span
                                                                                class="badge badge-primary mt-2">Need
                                                                                Further
                                                                                Follow-up</span></p>
                                                                    @elseif($remark->followup_status == 'Closed')
                                                                        <p class="">Status <span
                                                                                class="badge badge-danger mt-2">Closed</span>
                                                                        </p>
                                                                    @endif
                                                                </span>
                                                                <span class="">
                                                                    <p class="">Type <span
                                                                            class="badge badge-primary ">{{ get_follow_up_type($remark->followup_type) }}</span>
                                                                    </p>
                                                                </span>
                                                                <span>
                                                                    <button style="margin: 0px" type="button"
                                                                        onclick="edit_followup({{ $remark->id_followup_remarks }})"
                                                                        class="btn btn-sm  btn-warning">Edit</button>
                                                                </span>
                                                            </div>
                                                            <hr class="mt-2">
                                                        @empty
                                                        @endforelse
                                                        <hr class="mt-2">
                                                    @empty
                                                    @endforelse
                                                @endif
                                            </div>
                                        </div>
                                        {{-- {{dd($need_further_follow_ups)}} --}}
                                        <div id="tabCont22" class="tab-pane  show">
                                            <div class="row ">

                                            </div>
                                        </div>

                                        <div id="tabCont33" class="tab-pane  show">
                                            <div class="row ">
                                                @if ($closed_follow_ups != null)
                                                    @forelse ($closed_follow_ups as $key => $remark)
                                                        <div class="col-md-6 mt-2">
                                                            <h6 class="text-warning" style="font-weight: 600">FOLLOW-UP
                                                                PROGRESS</h6>
                                                        </div>

                                                        <div class="col-md-9 mt-2"><span class="text-success"><i
                                                                    style="font-weight: 500">{{ $remark->remarks }}</i></span>
                                                        </div>
                                                        <div class="col-md-3 mt-2"
                                                            style="position: relative;bottom: 34px;">
                                                            @php
                                                                $user_name = App\User::where('id', $remark->created_by)
                                                                    ->select('name')
                                                                    ->first();
                                                            @endphp
                                                            <span class="text-secondary"><br>
                                                                ~{{ $user_name->name }}</span><br>
                                                            <span class="">Follow Up Date :</span><span
                                                                class="badge badge-info mt-2">
                                                                {{ $remark->followup_date }}</span>
                                                            <br>
                                                            <span class="">Remarks Date :</span><span
                                                                class="badge badge-info mt-2">
                                                                {{ $remark->created_at }}</span>
                                                            <span class="mt-2">

                                                                @if ($remark->followup_status == 'Open')
                                                                    <p class="">Status <span
                                                                            class="badge badge-warning mt-2">Open</span>
                                                                    </p>
                                                                @elseif($remark->followup_status == 'Need Further Follow-up')
                                                                    <p class="">Status <span
                                                                            class="badge badge-primary mt-2">Need Further
                                                                            Follow-up</span></p>
                                                                @elseif($remark->followup_status == 'Closed')
                                                                    <p class="">Status <span
                                                                            class="badge badge-danger mt-2">Closed</span>
                                                                    </p>
                                                                @endif
                                                            </span>
                                                            <span class="">
                                                                <p class="">Type <span
                                                                        class="badge badge-primary ">{{ get_follow_up_type($remark->followup_type) }}</span>
                                                                </p>
                                                            </span>
                                                            <span>
                                                                <button style="margin: 0px" type="button"
                                                                    onclick="edit_followup({{ $remark->id_remarks }})"
                                                                    class="btn btn-sm  btn-warning">Edit</button>
                                                            </span>
                                                        </div>
                                                        <hr class="mt-2">
                                                    @empty
                                                    @endforelse
                                                @endif
                                            </div>
                                        </div><!-- tab-pane -->
                                    </div><!-- card-body -->
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 inline-flex" style="display: inline-block;">
                        <div class="card bg-white">
                            <div class="card-body">
                                <h4 class="card-title"><u>ADD FOLLOW-UP REMARKS</u></h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        @if ($errors->any())
                                            @foreach ($errors->all() as $error)
                                                <span style="color: red">{{ $error }}</span>
                                            @endforeach
                                        @endif
                                        <form action="{{ url('add_followup_remarks') }}" id="submit_form"
                                            method="POST">

                                            <input type="hidden" name="inquiry_id" value="{{ $dec_inq_id }}"
                                                id="">
                                            <div class="form-group">
                                                @csrf
                                                <label class="mt-2">TYPE <span style="color: red">*</span></label>
                                                <select class="form-control" name="followup_type" id="followup_type"
                                                    required="required">
                                                    <option value="">Select</option>
                                                    @if ($followup_types)
                                                        @foreach ($followup_types as $follow_type)
                                                            <option value="{{ $follow_type->id_follow_up_types }}">
                                                                {{ $follow_type->type_name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="mt-2">REMARKS <span
                                                        style="color: red">*</span></label>
                                                {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                <textarea name="followup_remarks" required="required" class="form-control" id="followup_remarks" cols="50"
                                                    rows="50"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="mt-2">FOLLOW-UP DATE <span
                                                        style="color: red">*</span></label>
                                                <input type="text" name="followup_date" id="datetimepicker22"
                                                    required="required" class="form-control">
                                            </div>
                                            <input type="hidden" name="id_follow_up_remarks" id="id_follow_up_remarks">
                                            <input type="hidden" name="follow_up_id" id="follow_up_id">
                                            <div class="form-group">
                                                @csrf
                                                <label class="mt-2">STATUS <span style="color: red">*</span></label>
                                                <select class="form-control" name="followup_status" id="followup_status"
                                                    required="required">
                                                    <option value="Open">Open</option>
                                                    <option value="Need Further Follow up">Need Further Follow up</option>
                                                    <option value="Closed">Closed</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                @csrf
                                                <label class="mt-2">USER</label>
                                                <select class="form-control" name="followup_user" id="followup_user">
                                                    <option value="">Select</option>
                                                    @if ($sales_person)
                                                        @foreach ($sales_person as $sales_persons)
                                                            <option @if ($sales_persons->id == auth()->user()->id) selected @endif
                                                                value="{{ $sales_persons->id }}">
                                                                {{ $sales_persons->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="form-group mt-2">
                                                <button type="submit" id="btn_sub"
                                                    class="btn btn-success btn-block text-white w-100">Add
                                                    Follow-up</button>
                                            </div>


                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--Quotation Remarks-->
            <div id="tabCont3" class="tab-pane show ">
                <div class="row">

                    <div class="col-md-12" style="height: 500px !important;">
                        <div class="card bg-white" style="height: 498px;">
                            <div class="card-body" style="    height: 498px;
                            overflow: auto;">
                                <h4 class="card-title "><u>QUOTATION REMARKS</u></h4>
                                <p class="card-text"></p>
                                <div class="row ">
                                    @if ($all_remarks != null)
                                        @forelse ($quotation_remarks as $key => $remark)
                                            <div class="col-md-6 mt-2">
                                                <h6 class="text-warning" style="font-weight: 600">PROGRESS REMARKS</h6>
                                            </div>

                                            <div class="col-md-9 mt-2"><span class="text-success"><i
                                                        style="font-weight: 500">{{ $remark->remarks }}</i></span>
                                            </div>
                                            <div class="col-md-3 mt-2" style="position: relative;bottom: 34px;">
                                                @php
                                                    $user_name = App\User::where('id', $remark->created_by)
                                                        ->select('name')
                                                        ->first();
                                                @endphp

                                                <span class="text-secondary"> ~{{ $user_name->name }}</span><br>

                                                @if ($remark->followup_date)
                                                    <span class="">Follow Up Date :</span><span
                                                        class="badge badge-info mt-2">
                                                        {{ $remark->followup_date }}</span>
                                                @endif
                                                <span class="">Remarks Date :</span><span
                                                    class="badge badge-info mt-2">
                                                    {{ $remark->created_at }}</span>
                                                <span class="mt-2">

                                                    @if ($remark->remarks_status == 0)
                                                        <p class="">Status <span
                                                                class="badge badge-warning mt-2">Open</span></p>
                                                    @elseif($remark->remarks_status == 1)
                                                        <p class="">Status <span
                                                                class="badge badge-primary mt-2">In-Progress</span></p>
                                                    @elseif($remark->remarks_status == 2)
                                                        <p class="">Status <span
                                                                class="badge badge-Info mt-2">Quotation Shared</span></p>
                                                    @elseif($remark->remarks_status == 3)
                                                        <p class="">Status <span
                                                                class="badge badge-success mt-2">Confirmed</span></p>
                                                    @elseif($remark->remarks_status == 4)
                                                        <p class="">Status <span
                                                                class="badge badge-success mt-2">Completed</span></p>
                                                    @elseif($remark->remarks_status == 5)
                                                        <p class="">Status <span
                                                                class="badge badge-danger mt-2">Canceled</span></p>
                                                    @endif
                                                </span>
                                                @if ($remark->remarks_status == 5)
                                                    <span class="badge badge-danger"><span class="">Cancel Reason :
                                                        </span>
                                                        {{ $remark->cancel_reason }}</span>
                                                @endif
                                            </div>
                                            <hr class="mt-2">
                                        @empty
                                        @endforelse
                                        @php
                                            if (count($quotations) < 1) {
                                                echo '<h2 style="    display: flex;justify-content: center;align-items: center;color:#00beda;" class="text-center">No Quotations Shared Yet</h2>';
                                            }
                                        @endphp
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Issuance Status-->
            <div id="tabCont5" class="tab-pane show ">
                <div class="row">
                    {{-- <div class="col-md-12" style="height: 500px !important;">
                        <div class="card bg-white" style="height: 498px;">
                            <div class="card-body" style="    height: 498px;
                            overflow: auto;">
                                <h4 class="card-title "><u>ISSUANCE STATUS</u></h4>
                                <p class="card-text"></p>
                                <div class="row ">
                                    @if ($all_remarks != null)
                                        @forelse ($quotation_remarks as $key => $remark)
                                            <div class="col-md-6 mt-2">
                                                <h6 class="text-warning" style="font-weight: 600">PROGRESS REMARKS</h6>
                                            </div>

                                            <div class="col-md-9 mt-2"><span class="text-success"><i
                                                        style="font-weight: 500">{{ $remark->remarks }}</i></span>
                                            </div>
                                            <div class="col-md-3 mt-2" style="position: relative;bottom: 34px;">
                                                @php
                                                    $user_name = App\User::where('id', $remark->created_by)
                                                        ->select('name')
                                                        ->first();
                                                @endphp

                                                <span class="text-secondary"> ~{{ $user_name->name }}</span><br>

                                                @if ($remark->followup_date)
                                                    <span class="">Follow Up Date :</span><span
                                                        class="badge badge-info mt-2">
                                                        {{ $remark->followup_date }}</span>
                                                @endif
                                                <span class="">Remarks Date :</span><span
                                                    class="badge badge-info mt-2">
                                                    {{ $remark->created_at }}</span>
                                                <span class="mt-2">

                                                    @if ($remark->remarks_status == 0)
                                                        <p class="">Status <span
                                                                class="badge badge-warning mt-2">Open</span></p>
                                                    @elseif($remark->remarks_status == 1)
                                                        <p class="">Status <span
                                                                class="badge badge-primary mt-2">In-Progress</span></p>
                                                    @elseif($remark->remarks_status == 2)
                                                        <p class="">Status <span
                                                                class="badge badge-Info mt-2">Quotation Shared</span></p>
                                                    @elseif($remark->remarks_status == 3)
                                                        <p class="">Status <span
                                                                class="badge badge-success mt-2">Confirmed</span></p>
                                                    @elseif($remark->remarks_status == 4)
                                                        <p class="">Status <span
                                                                class="badge badge-success mt-2">Completed</span></p>
                                                    @elseif($remark->remarks_status == 5)
                                                        <p class="">Status <span
                                                                class="badge badge-danger mt-2">Canceled</span></p>
                                                    @endif
                                                </span>
                                                @if ($remark->remarks_status == 5)
                                                    <span class="badge badge-danger"><span class="">Cancel Reason :
                                                        </span>
                                                        {{ $remark->cancel_reason }}</span>
                                                @endif
                                            </div>
                                            <hr class="mt-2">
                                        @empty
                                        @endforelse
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-md-12" style="">
                        <div class="card bg-white">
                            <div id="hotel_inv_ids">

                            </div>

                            {{-- <img class="card-img-top" src="holder.js/100px180/" alt=""> --}}
                            <div class="card-body">
                                <div class="col-md-12">
                                    <h4><u>ISSUANCE STATUS</u></h4>
                                </div><br>

                                <div class="row" style="height: auto;overflow: scroll">
                                    {{-- {{dd($quotations)}} --}}
                                    @foreach ($get_issuance as $key => $issue)
                                        {{-- {{dd($quote)}} --}}


                                        {{-- <div>
                                            <a class="d-none" id="service_level_btn{{ $key }}" class="btn btn-az-primary"
                                                href="{{ url('edit_quotation/' . \Crypt::encrypt($dec_inq_id) . '/' . \Crypt::encrypt($quote->id_quotations) . '/service_level') }}">Convert(S.L)</a>
                                            <a class="d-none" id="lum_sum_btn{{ $key }}" class="btn btn-az-primary"
                                                href="{{ url('edit_quotation/' . \Crypt::encrypt($dec_inq_id) . '/' . \Crypt::encrypt($quote->id_quotations) . '/lum_sum') }}">Convert(L.S)</a>
                                            <a class="d-none" id="no_of_person_btn{{ $key }}" class="btn btn-az-primary"
                                                href="{{ url('edit_quotation/' . \Crypt::encrypt($dec_inq_id) . '/' . \Crypt::encrypt($quote->id_quotations) . '/no_of_person') }}">Convert(N.P)</a>
                                        </div> --}}
                                        <a class="tickets-card row">
                                            <div class="tickets-details col-lg-3 col-12">
                                                <div class="wrapper">
                                                    <h5>
                                                        {{ $issue->get_quotation->quotation_no }}
                                                    </h5>
                                                    <span class="badge badge-success"> {{ $issue->services_type }}</span>
                                                </div>
                                                <div class="wrapper text-muted d-none d-md-block">
                                                    {{-- <span>Total </span>
                                                    <span class="text-success"><strong>/-</strong></span> --}}
                                                    <span><i
                                                            class="typcn icon typcn-time"></i>{{ $quote->created_at->format('d-M-Y H:i') }}</span>
                                                </div>
                                            </div>

                                            <div class="ticket-float col-lg-3 col-sm-6 d-none d-md-block"
                                                style="border-left:1px solid lightgray;">
                                                {{-- <select name="" id="conversion{{ $key }}"
                                                    class="form-control">
                                                    <option value="">Select</option>
                                                    <option @if ($quote->quotation_type == 'service_level') class="d-none" @endif
                                                        value="service_level">Convert Quotation To Service Level</option>
                                                    <option @if ($quote->quotation_type == 'no_of_person') class="d-none" @endif
                                                        value="no_of_person">Convert Quotation To No Of Person</option>
                                                    <option @if ($quote->quotation_type == 'lum_sum') class="d-none" @endif
                                                        value="lum_sum">
                                                        Convert Quotation To Lum Sum</option>
                                                </select> --}}


                                            </div>
                                            {{-- <div class="ticket-float col-lg-2 col-sm-6 d-none d-md-block">
                                                <button class="btn btn-rounded btn-az-primary mb-3"
                                                    onclick="convert({{ $quote->id_quotations }},{{ $key }})">
                                                    Convert
                                                </button>

                                            </div> --}}
                                            <div class="ticket-float col-lg-2 col-sm-6 d-none d-md-block "
                                                style="border-left:1px solid lightgray;">


                                                <button class="btn btn-success mb-3" style="color:#fff;" disabled>
                                                    <span style="color:white">Status:</span> {{ $issue->status }}
                                                </button>

                                                <button class="btn btn-success mb-3" style="color:#fff;" disabled>
                                                    <span style="color:white">Assign-To:</span>
                                                    {{ $issue->get_user_assign?->name }}
                                                </button>
                                                {{-- {{dd()}} --}}

                                                {{-- @endif --}}

                                            </div>
                                            {{-- <div class="ticket-float col-lg-2 col-sm-6 d-none d-md-block "
                                                style="border-left:1px solid lightgray;">
                                                <button class="btn btn-az-primary mb-3"
                                                    onclick="window.location.href='{{ url('/view_quotation/' . \Crypt::encrypt($quote->id_quotations) . '/' . \Crypt::encrypt($quote->inquiry_id)) }}'">
                                                    View
                                                </button>
                                            </div> --}}
                                        </a>
                                    @endforeach
                                    @php
                                        if (count($quotations) < 1) {
                                            echo '<h2 style="    display: flex;justify-content: center;align-items: center;color:#00beda;" class="text-center">No Quotations Shared Yet</h2>';
                                        }
                                    @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Accounts Status-->
            <div id="tabCont6" class="tab-pane show ">
                <div class="row">
                    <div class="col-md-12" style="">
                        <div class="card bg-white">
                            <div id="hotel_inv_ids">

                            </div>

                            {{-- <img class="card-img-top" src="holder.js/100px180/" alt=""> --}}
                            <div class="card-body">
                                <div class="col-md-12">
                                    <h4><u>ACCOUNTS</u></h4>
                                    <div>
                                        <button class="btn btn-az-primary"
                                            onclick="pay_quotation({{ $dec_inq_id }})">Pay
                                            Now</button>
                                    </div>
                                </div><br>

                                <div class="row">
                                    {{-- @foreach ($quotations as $quo)
                                        @if ($quo->status == 3)
                                            @php
                                                $get_details_quo = App\quotations_detail::where('uniq_id', $quote->quotations_details_id)->get();
                                                //    dd($get_details);
                                            @endphp


                                            @foreach ($get_details_quo as $get_d)
                                                <a class="tickets-card row">
                                                    <div class="tickets-details col-lg-3 col-12">
                                                        <div class="wrapper">
                                                            <h5>
                                                                {{ $quo->quotation_no }}
                                                                <span
                                                                    class=" badge badge-success">{{ $get_d->services_type }}</span>
                                                            </h5>
                                                        </div>
                                                        <div class="wrapper text-muted d-none d-md-block">
                                                            <span>Total </span>
                                                            <span
                                                                class="text-success">{{ $get_d->total }}<strong>/-</strong></span>

                                                            <span><i class="typcn icon typcn-time"></i></span>
                                                        </div>
                                                    </div>

                                                    <div class="ticket-float col-lg-3 col-sm-6 d-none d-md-block"
                                                        style="border-left:1px solid lightgray;">



                                                    </div>

                                                    <div class="ticket-float col-lg-2 col-sm-6 d-none d-md-block"
                                                        style="border-left:1px solid lightgray;">
                                                        <label for="">Paid Amount
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                        <button
                                                            class="btn btn-az-primary ">{{ $get_d->get_payment?->paid_amount ? $get_d->get_payment?->paid_amount : 0 }}/-</button>
                                                    </div>
                                                    <div class="ticket-float col-lg-2 col-sm-6 d-none d-md-block "
                                                        style="border-left:1px solid lightgray;">
                                                        <label for="">Remaining Amount</label>
                                                        <button
                                                            class="btn btn-danger ">{{ isset($get_d->get_payment?->remaining_amount) ? $get_d->get_payment?->remaining_amount : $get_d->total }}/-</button>
                                                    </div>
                                                    <div class="ticket-float col-lg-2 col-sm-6 d-none d-md-block "
                                                        style="border-left:1px solid lightgray;">
                                                        <label for="">Pay Now
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                        <button class="btn btn-az-primary"
                                                            onclick="pay_quotation({{ $quo->id_quotations }},{{ $get_d->id_quotation_details }},{{ $get_d->get_payment?->remaining_amount ? $get_d->get_payment?->remaining_amount : $get_d->total }},'{{ $get_d->services_type }}')">Pay
                                                            Now</button>
                                                    </div>

                                                </a>
                                            @endforeach
                                        @endif
                                    @endforeach --}}

                                    <table id="example2" style="width: 100%;" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="wd-10p">S.No</th>
                                                <th class="wd-20p">Payment #</th>
                                                <th class="wd-20p">RV Number</th>
                                                <th class="wd-20p">Services</th>
                                                <th class="wd-20p">Paid Amount</th>
                                                <th class="wd-20p">Remaining Amount</th>
                                                <th class="wd-20p">Status</th>
                                                <th class="wd-10p">Created At</th>
                                                <th class="wd-10p">Action</th>


                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($payment_invoice_list as $key => $pay_ac)
                                                @if (get_payment_quotation($dec_inq_id) == $pay_ac->quotation_id)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $pay_ac->pay_no }}</td>
                                                        <td>{{ $pay_ac->recieving_number }}</td>
                                                        <td>{{ get_services_name_array($pay_ac->services_type) }}</td>
                                                        <td>{{ $pay_ac->paid_amount }}</td>
                                                        <td>{{ $pay_ac->total_quotation_remaining_amount }}</td>
                                                        <td>
                                                            @if ($pay_ac->status == 0)
                                                                <span class="badge badge-warning">Pending</span>
                                                            @elseif($pay_ac->status == 1)
                                                                <span class="badge badge-success">Completed</span>
                                                            @endif
                                                        </td>
                                                        {{-- <td>{{ get_total_quotation_received_amount($pay->quotation_id) }}</td> --}}
                                                        <td>{{ $pay_ac->created_at }}</td>
                                                        <td><button class="btn btn-primary"
                                                                onclick="get_details({{ $pay_ac->id_account_payments }},'{{ $pay_ac->payment_type }}')">View
                                                                Details</button>
                                                        </td>

                                                    </tr>
                                                @endif
                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="wd-10p">S.No</th>
                                                <th class="wd-20p">Payment #</th>
                                                <th class="wd-20p">RV Number</th>
                                                <th class="wd-20p">Services</th>
                                                <th class="wd-20p">Paid Amount</th>
                                                <th class="wd-20p">Remaining Amount</th>
                                                <th class="wd-20p">Status</th>
                                                <th class="wd-10p">Created At</th>
                                                <th class="wd-10p">Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- tab-pane -->
            <div id="tabCont7" class="tab-pane show ">
                <div class="row">
                    <div class="col-md-12" style="">
                        <div class="card bg-white">
                            <div id="hotel_inv_ids">

                            </div>

                            {{-- <img class="card-img-top" src="holder.js/100px180/" alt=""> --}}
                            <div class="card-body">
                                <div class="col-md-12">
                                    <h4><u>Documentation</u></h4>
                                </div><br>

                                <div class="row" style="height: auto;overflow: scroll">
                                    {{-- {{dd($quotations)}} --}}

                                    @php
                                        $document_data = json_decode($documents?->entries);

                                        // dd($document_data[0])

                                    @endphp
                                    <form action="{{ url('add_documentation') }}" method="POST">

                                        <input type="hidden" name="inq_id" value="{{ $dec_inq_id }}"
                                            id="">
                                        <input type="hidden" name="customer_id"
                                            value="{{ $get_customer->id_customers }}" id="">

                                        @csrf

                                        @if (isset($documents) && $documents !== null)
                                            @for ($i = 0; $i < count($document_data); $i++)
                                                <h4>{{ $document_data[$i]->person }} No {{ $i + 1 }}</h4>

                                                <div class="form-group">
                                                    <label for="">Upload Passport</label>
                                                    <input type="file" name="" id=""
                                                        class="form-control" placeholder="" aria-describedby="helpId">

                                                </div>
                                                @if ($document_data[$i]->person == 'Adult')
                                                    <input type="hidden" name="person[]" value="Adult">
                                                @else
                                                    <input type="hidden" name="person[]" value="Child">
                                                @endif
                                                <hr>
                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <div class="form-check form-check-inline float-end">
                                                            <label class="form-check-label">
                                                                <input onclick="onlyOne(this)"
                                                                    class="form-check-input is_head" type="radio"
                                                                    @if ($document_data[$i]->is_head == 1) checked @endif
                                                                    name="is_head[{{ $i }}]" id="is_head"
                                                                    value="checkedValue"> Is Head
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Given Name<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text"
                                                                value="{{ $document_data[$i]->given_name }}"
                                                                class="form-control" name="given_name[]" id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Sur Name<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text"
                                                                value="{{ $document_data[$i]->sur_name }}"
                                                                class="form-control" name="sur_name[]" id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Passport Number<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text"
                                                                value="{{ $document_data[$i]->passport_no }}"
                                                                class="form-control" name="passport_no[]" id="">
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-4"> --}}
                                                    {{-- <div class="form-group"> --}}
                                                    {{-- <label for="" class="mt-2">Visa Number<span --}}
                                                    {{-- style="color: red">*</span></label> --}}
                                                    {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                    {{-- <input type="text" --}}
                                                    {{-- value="{{ $document_data[$i]->visa_number }}" --}}
                                                    {{-- class="form-control" name="visa_number[]" id=""> --}}
                                                    {{-- </div> --}}
                                                    {{-- </div> --}}
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Validity<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="number"
                                                                value="{{ $document_data[$i]->validity }}" min="1"
                                                                class="form-control" name="validity[]" id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Expiry<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text"
                                                                value="{{ $document_data[$i]->expiry }}"
                                                                placeholder="15/Sep/23" class="form-control fc-datepicker"
                                                                name="expiry[]" id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Gender<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <select name="gender[]" class="form-control" id="gender">
                                                                <option @if ($document_data[$i]->gender == 'Male') selected @endif
                                                                    value="Male">Male</option>
                                                                <option @if ($document_data[$i]->gender == 'Female') selected @endif
                                                                    value="Female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">CNIC<span
                                                                    style="color: red"></span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text" class="form-control cnic"
                                                                value="{{ $document_data[$i]->cnic }}"
                                                                data-inputmask="'mask': '99999-9999999-9'"
                                                                placeholder="XXXXX-XXXXXXX-X" name="cnic[]">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endfor
                                        @else
                                            @for ($i = 0; $i < $get_inquiry->no_of_adults; $i++)
                                                <h4>Adult No {{ $i + 1 }}</h4>
                                                <div class="form-group">
                                                    <label for="">Upload Passport</label>
                                                    <input type="file" name="" id=""
                                                        class="form-control" placeholder="" aria-describedby="helpId">

                                                </div>
                                                <input type="hidden" name="person[]" value="Adult">
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-check form-check-inline float-end">
                                                            <label class="form-check-label">
                                                                <input onclick="onlyOne(this)"
                                                                    class="form-check-input is_head" type="radio"
                                                                    name="is_head[{{ $i }}]" id="is_head"
                                                                    value="checkedValue"> Is Head
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Given Name<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text" value="" class="form-control"
                                                                name="given_name[]" id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Sur Name<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text" value="" class="form-control"
                                                                name="sur_name[]" id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Passport Number<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text" value="" class="form-control"
                                                                name="passport_no[]" id="">
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Visa Number<span
                                                                    style="color: red">*</span></label>
                                                            <small id="helpId" class="text-muted">Help text</small>
                                                            <input type="text" value="" class="form-control"
                                                                name="visa_number[]" id="">
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Validity<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="number" value="" min="1"
                                                                class="form-control" name="validity[]" id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Expiry<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text" value="" placeholder="15/Sep/23"
                                                                class="form-control fc-datepicker" name="expiry[]"
                                                                id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Gender<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <select name="gender[]" class="form-control" id="gender">
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">CNIC<span
                                                                    style="color: red"></span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text" class="form-control cnic"
                                                                data-inputmask="'mask': '99999-9999999-9'"
                                                                placeholder="XXXXX-XXXXXXX-X" name="cnic[]">
                                                        </div>
                                                    </div>

                                                </div>
                                            @endfor
                                            @for ($i = 0; $i < $get_inquiry->no_of_children; $i++)
                                                <h4>Child No {{ $i + 1 }}</h4>
                                                <div class="form-group">
                                                    <label for="">Upload Passport</label>
                                                    <input type="file" name="" id=""
                                                        class="form-control" placeholder="" aria-describedby="helpId">
                                                </div>
                                                <hr>
                                                <input type="hidden" name="person[]" value="Child">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Given Name<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text" class="form-control"
                                                                name="given_name[]" id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Sur Name<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text" class="form-control" name="sur_name[]"
                                                                id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Passport Number<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text" class="form-control"
                                                                name="passport_no[]" id="">
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Visa Number<span
                                                                    style="color: red">*</span></label>
                                                            <small id="helpId" class="text-muted">Help text</small>
                                                            <input type="text" class="form-control"
                                                                name="visa_number[]" id="">
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Validity<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="number" min="1" class="form-control"
                                                                name="validity[]" id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Expiry<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text" placeholder="15/Sep/23"
                                                                class="form-control fc-datepicker" name="expiry[]"
                                                                id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Gender<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <select name="gender[]" class="form-control" id="gender">
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">CNIC<span
                                                                    style="color: red"></span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text" class="form-control cnic"
                                                                data-inputmask="'mask': '99999-9999999-9'"
                                                                placeholder="XXXXX-XXXXXXX-X" name="cnic[]">
                                                        </div>
                                                    </div>
                                                    @csrf
                                                </div>
                                            @endfor
                                            @for ($i = 0; $i < $get_inquiry->no_of_infants; $i++)
                                                <h4>Infant No {{ $i + 1 }}</h4>
                                                <div class="form-group">
                                                    <label for="">Upload Passport</label>
                                                    <input type="file" name="" id=""
                                                        class="form-control" placeholder="" aria-describedby="helpId">
                                                </div>
                                                <hr>
                                                <input type="hidden" name="person[]" value="infant">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Given Name<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text" class="form-control"
                                                                name="given_name[]" id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Sur Name<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text" class="form-control" name="sur_name[]"
                                                                id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Passport Number<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text" class="form-control"
                                                                name="passport_no[]" id="">
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="" class="mt-2">Visa Number<span
                                                                style="color: red">*</span></label>
                                                        <small id="helpId" class="text-muted">Help text</small>
                                                        <input type="text" class="form-control"
                                                            name="visa_number[]" id="">
                                                    </div>
                                                </div> --}}
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Validity<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="number" min="1" class="form-control"
                                                                name="validity[]" id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Expiry<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text" placeholder="15/Sep/23"
                                                                class="form-control fc-datepicker" name="expiry[]"
                                                                id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">Gender<span
                                                                    style="color: red">*</span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <select name="gender[]" class="form-control" id="gender">
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2">CNIC<span
                                                                    style="color: red"></span></label>
                                                            {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                            <input type="text" class="form-control cnic"
                                                                data-inputmask="'mask': '99999-9999999-9'"
                                                                placeholder="XXXXX-XXXXXXX-X" name="cnic[]">
                                                        </div>
                                                    </div>
                                                    @csrf
                                                </div>
                                            @endfor
                                        @endif



                                        <input type="submit" value="Submit" class="btn btn-az-primary">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- tab-pane -->
        </div><!-- card-body -->
    </div>
    <div class="row mt-2">
        <div class="col-md-12" style="">
            <div class="card bg-white">
                <div id="hotel_inv_ids">

                </div>

                <img class="card-img-top" src="holder.js/100px180/" alt="">
                <div class="card-body">
                    <div class="col-md-12">
                        <h4><u>Quotation List</u><a class="btn btn-az-primary" style="float: right;margin: 0"
                                href="#services">Create New Quotation</a></h4>
                    </div><br>
                    <p class="card-text"></p>
                    <div class="row" style="height: auto;overflow: scroll">
                        {{-- {{dd($quotations)}} --}}
                        @foreach ($quotations as $key_main => $quote)
                            @php

                                // echo $c_cou;
                                if ($quote->quotation_type == 'service_level') {
                                    $get_total = App\quotations_detail::where('uniq_id', $quote->quotations_details_id)
                                        ->select('total')
                                        ->get()
                                        ->sum('total');
                                } else {
                                    $get_total = App\quotations_detail::where('uniq_id', $quote->quotations_details_id)
                                        ->select('total')
                                        ->first();
                                    $get_total = $get_total?->total;
                                }

                            @endphp

                            <div>
                                <a class="d-none" id="service_level_btn{{ $key_main }}" class="btn btn-az-primary"
                                    href="{{ url('edit_quotation/' . \Crypt::encrypt($dec_inq_id) . '/' . \Crypt::encrypt($quote->id_quotations) . '/service_level') }}">Convert(S.L)</a>
                                <a class="d-none" id="lum_sum_btn{{ $key_main }}" class="btn btn-az-primary"
                                    href="{{ url('edit_quotation/' . \Crypt::encrypt($dec_inq_id) . '/' . \Crypt::encrypt($quote->id_quotations) . '/lum_sum') }}">Convert(L.S)</a>
                                <a class="d-none" id="no_of_person_btn{{ $key_main }}" class="btn btn-az-primary"
                                    href="{{ url('edit_quotation/' . \Crypt::encrypt($dec_inq_id) . '/' . \Crypt::encrypt($quote->id_quotations) . '/no_of_person') }}">Convert(N.P)</a>
                            </div>
                            <a class="tickets-card row">
                                <div class="tickets-details col-lg-3 col-12">
                                    <div class="wrapper">
                                        <h5>{{ $quote->quotation_no }}<br>
                                            @if ($quote->quotation_type == 'service_level')
                                                Service Level
                                            @elseif ($quote->quotation_type == 'no_of_person')
                                                No Of Person
                                            @else
                                                Lum Sum
                                            @endif
                                        </h5>

                                        @if ($quote->status == 0)
                                            <div class="badge badge-primary">
                                                Status : <span>Open</span>
                                            </div>
                                        @elseif ($quote->status == 1)
                                            <div class="badge badge-warning">
                                                Status : <span>Sent for Approval</span>
                                            </div>
                                        @elseif ($quote->status == 3)
                                            <div class="badge badge-success">
                                                Status : <span>Approved</span>
                                            </div>
                                        @elseif ($quote->status == 4)
                                            <div class="badge badge-danger">
                                                Status : <span>DisApproved</span>
                                            </div>
                                        @elseif ($quote->status == 2)
                                            Status : <span>Cancelled</span>
                                        @endif
                                    </div>
                                    <div class="wrapper text-muted d-none d-md-block">
                                        <span>Total </span>
                                        <span class="text-success"><strong>{{ $get_total }}/-</strong></span>
                                        <span><i
                                                class="typcn icon typcn-time"></i>{{ $quote->created_at->format('d-M-Y H:i') }}</span>
                                    </div>
                                </div>

                                <div class="ticket-float col-lg-3 col-sm-6 d-none d-md-block"
                                    style="border-left:1px solid lightgray;">
                                    <select name="" id="conversion{{ $key_main }}" class="form-control">
                                        <option value="">Select</option>
                                        <option @if ($quote->quotation_type == 'service_level') class="d-none" @endif
                                            value="service_level">Convert Quotation To Service Level</option>
                                        <option @if ($quote->quotation_type == 'no_of_person') class="d-none" @endif
                                            value="no_of_person">Convert Quotation To No Of Person</option>
                                        <option @if ($quote->quotation_type == 'lum_sum') class="d-none" @endif value="lum_sum">
                                            Convert Quotation To Lum Sum</option>
                                    </select>
                                    {{-- {{get_issuance_services($quote->id_quotations,$sub_name)}} --}}
                                    {{-- {{dd($quote->Issuancedata[0])}} --}}
                                    {{-- {{dd(check_payment($quote->quotation_id))}} --}}
                                    {{-- {{check_payment($quote->id_quotations,$get_total)}} --}}
                                    @if ($quote->status == 3 && check_doc($dec_inq_id) && check_payment($quote->id_quotations, $get_total))
                                        <br>
                                        <br>
                                        <select name="" multiple id="issuance_service{{ $key_main }}"
                                            class="form-control select2 ">
                                            <option value="">Select</option>
                                            @foreach ($service_name as $name)
                                                <li class="mt-2">
                                                    <span class="fs-5">{{ $name }}</span> :
                                                    @foreach ($sub_service_name as $key => $sub_name)
                                                        @if (get_issuance_services($quote->id_quotations, $sub_name))
                                                        @else
                                                            <option value="{{ $sub_name }}">{{ $sub_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </li>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="ticket-float col-lg-2 col-sm-6 d-none d-md-block">
                                    <button class="btn btn-az-primary mb-3"
                                        onclick="convert({{ $quote->id_quotations }},{{ $key_main }})">
                                        Convert
                                    </button>
                                    @if ($quote->status == 3 && check_doc($dec_inq_id) && check_payment($quote->id_quotations, $get_total))
                                        <br>
                                        <button class="btn btn-rounded btn-az-primary mb-3"
                                            onclick="send_quotation_to_issuance({{ $quote->id_quotations }},{{ $key_main }})">
                                            Sent for Issuance
                                        </button>
                                    @endif

                                </div>
                                <div class="ticket-float col-lg-2 col-sm-6 d-none d-md-block "
                                    style="border-left:1px solid lightgray;">
                                    @php
                                        $get_quotations = app\remarks::where('quotation_id', $quote->id_quotations)
                                            ->where('remarks_status', 'Quotation Send For Approval')
                                            ->count();
                                        // dd($get_quotations);
                                    @endphp
                                    @if ($get_quotations < 1)
                                        <button class="btn btn-warning mb-3" style="color:#fff;"
                                            onclick="send_quotation_to_approval({{ $quote->id_quotations }})">
                                            Send For Approval
                                        </button>
                                    @else
                                        <button class="btn btn-rounded btn-success mb-3" style="color:#fff;" disabled>
                                            Approved
                                        </button>
                                        {{-- {{dd()}} --}}
                                        @if ($quote->status == 3 && $quote->get_issuance?->id_quotation_issuance == null)
                                            {{-- <button class="btn btn-success mb-3" style="color:#fff;"
                                                onclick="send_quotation_to_issuance({{ $quote->id_quotations }})">
                                                Send For Issuance
                                            </button> --}}
                                        @else
                                            <button class="btn btn-rounded btn-warning mb-3" disabled>
                                                Sent for Issuance
                                            </button>
                                        @endif
                                    @endif

                                </div>
                                <div class="ticket-float col-lg-2 col-sm-6 d-none d-md-block "
                                    style="border-left:1px solid lightgray;">
                                    <button class="btn btn-rounded btn-az-primary mb-3"
                                        onclick="window.location.href='{{ url('/view_quotation/' . \Crypt::encrypt($quote->id_quotations) . '/' . \Crypt::encrypt($quote->inquiry_id)) }}'">
                                        View Quotation
                                    </button>
                                </div>
                            </a>
                        @endforeach
                        @php
                            if (count($quotations) < 1) {
                                echo '<h2 style="    display: flex;justify-content: center;align-items: center;color:#00beda;" class="text-center">No Quotations Shared Yet</h2>';
                            }
                        @endphp
                    </div>
                </div>
            </div>
        </div>
        @include('quotations.modals.modals')
    </div>
    <div class="row mt-2">
        <div class="col-md-12" style="">
            <div class="card bg-white">
                <input type="hidden" id="inv_id_hidden">
                <img class="card-img-top" src="holder.js/100px180/" alt="">
                <div class="card-body">
                    <h4 class="card-title "><u>Create Quotation</u></h4>
                    <p class="card-text"></p>
                    <form action="{{ url('create_quotation/' . \Crypt::encrypt($dec_inq_id)) }}" method="POST">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="hidden" id="airline_services_id" name="airline_services[]">
                                    <input type="hidden" id="airline_sub_services_id" name="airline_sub_services[]">
                                    <label for="">Select Service</label>
                                    <select name="services" class="form-control select2" id="services">
                                        @foreach ($services_inq as $service)
                                            <option value="">Select</option>
                                            <option value="{{ $service->id_other_services }}">
                                                {{ $service->service_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Select Sub Service</label>
                                    <select name="sub_services" class="select2 form-control " id="sub_services_option">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Select Service Type</label>
                                    <select name="service_type" class="select2 form-control " id="service_type">
                                        <option value="">Select</option>
                                        <option value="service_level">Service Level (S.L)</option>
                                        <option value="no_of_person">No Of Person</option>
                                        <option value="lum_sum">Lum Sum</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Select Default ROE</label>
                                    <select name="" class="select2 form-control" id="default_rate_of_exchange">
                                        <option value="">Select</option>
                                        @foreach ($currency_rates as $roe)
                                            <option @if ($roe->currency_name == 'Saudi Riyal (SAR)') selected @endif
                                                value="{{ $roe->currency_rate }}">{{ $roe->currency_name }} |
                                                {{ $roe->currency_rate }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Quotation Expiry</label>
                                    <select name="" class="select2 form-control" required="required">
                                        <option value="">Select</option>
                                        <option value="24 Hours">24 Hours</option>
                                        <option value="48 Hours">48 Hours</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <button type="button" onclick="check_append_quotation_details()"
                                        class="btn btn-sm btn-rounded btn-success text-white">Add</button>
                                    <button type="button" onclick="reset_all()"
                                        class="btn btn-sm btn-rounded btn-danger text-white">Reset</button>

                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="spinner-border text-info mt-4 d-none " id="loading-image"
                                        role="status">
                                        <span class="sr-only  ">Loading...</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4" id="append_table">
                            </div>
                            @csrf
                            <div style="display: none" id="submit_buttons">
                                <input type="hidden" value="{{ $dec_inq_id }}" name="inq_id">
                                <button class="btn btn-danger" type="submit">Cancel</button>
                                <div style="float: right">
                                    <button class="btn btn-az-primary" type="submit">Create</button>
                                    <button class="btn btn-az-primary" type="submit">Create & Print</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('quotations.modals.modals')



    </div>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">

@endsection



@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.6/dist/flatpickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script> --}}



    <script></script>
    <script>
        $(".cnic").inputmask();
        $(document).ready(function() {
            $('#datetimepicker22').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                minDate: 0
            });
        });

        function onlyOne(checkbox) {
            $(".is_head").each(function(index, element) {
                $(element).prop('checked', false);
            });
            $(checkbox).prop('checked', true);
        }

        function get_details(pay_id, p_type) {
            $.ajax({
                type: "get",
                url: "{{ url('/view_invoice_payment_details') }}/" + pay_id,
                success: function(response) {
                    $('#ac_payment_type').val(response.payment_type)
                    $('#ac_bank_name').val(response.bank_name)
                    $('#ac_account_number').val(response.account_number)
                    $('#ac_cheque_no').val(response.cheque_number)
                    $('#ac_amount').val(response.amount)
                    // alert(response.attachment)
                    $("#attachment").attr("src", "{{ url('/') }}/" + response.attachment);

                    if (response.recieving_number != null) {
                        $('#ac_recieving_number').val(response.recieving_number)
                        $('#ac_recieving_number').prop('disabled', true);
                        $('#view_pay_details_btn').prop('disabled', true);
                    } else {
                        $('#ac_recieving_number').prop('disabled', true);
                        $('#view_pay_details_btn').prop('disabled', true);
                    }
                    if (p_type == "Cash") {
                        $('#d_cheque_number').css('display', 'none');
                        $('#d_bank_name').css('display', 'none');
                        $('#d_account_number_ac').css('display', 'none');
                    } else {
                        $('#d_cheque_number').css('display', 'block');
                        $('#d_bank_name').css('display', 'block');
                        $('#d_account_number_ac').css('display', 'block');
                    }

                    if (p_type == 'Online') {
                        $('#d_cheque_no').css('display', 'none');
                    }
                    $('#pay_id').val(pay_id)

                    $('#modaldemo8').modal('show');
                }

            });
        }

        function edit_followup(id_remarks) {
            $.ajax({
                type: "get",
                url: "{{ url('/get_followup_details') }}/" + id_remarks,
                success: function(response) {
                    $('#id_follow_up_remarks').val(id_remarks);
                    $('#followup_id').val(response.followup_id);
                    $('#datetimepicker22').val(response.followup_date);
                    $('#followup_status').val(response.followup_status);
                    $('#followup_remarks').val(response.remarks);
                    $('#follow_up_id').val(response.followup_id);
                    var follow_user = $('#followup_user').val(response.user_id);
                    var follow_type = $('#followup_type').val(response.followup_type);
                    if (response.followup_type == follow_type) {
                        $('#followup_type').prop('checked', true);
                    } else {
                        $('#followup_type').prop('checked', false);
                    }
                    if (response.follow_user == follow_user) {
                        $('#followup_user').prop('checked', true);
                    } else {
                        $('#followup_user').prop('checked', false);
                    }
                }
            });
        }
        $(document).ready(function() {

            $('#example2 tfoot th').each(function() {
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
            });

            $('#example2').DataTable({
                "ordering": true,
                "dom": 'Blfrtip',
                "buttons": [
                    'excel', 'pdf', 'print'
                ],
                responsive: !0,
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: 0
                }],
                initComplete: function() {
                    // Apply the search
                    this.api()
                        .columns()
                        .every(function() {
                            var that = this;

                            $('input', this.footer()).on('keyup change clear', function() {
                                if (that.search() !== this.value) {
                                    that.search(this.value).draw();
                                }
                            });
                        });
                }
            });
        });

        function pay_quotation(inq_id) {

            $.ajax({
                type: "get",
                url: "{{ url('get_pay_quotation_details') }}/" + inq_id,
                success: function(response) {
                    $('.select2').select2();
                    $('#pay_services_append').html(response.services_option);
                    $('#modaldemo7').modal('show');
                    $('#total_amount').val(response.total_amount);
                    $('#pay_inq_id').val(inq_id);
                    $("#pay_services_append").select2({
                        dropdownParent: $("#modaldemo7")
                    });
                }
            });
            // $('#pay_quote_detail_id').val(quote_detail_id);
            // $('#quote_pay_id').val(quote_id);
            // $('#pay_services_type').val(services_type);

        }
        // function onchange_services_get_s_amount(_id) {

        //     $.ajax({
        //         type: "get",
        //         url: "{{ url('onchange_services_get_s_amount') }}/"+quote_id,
        //         success: function (response) {
        //             $('#pay_services_append').html(response.services_option);
        //              $('#modaldemo7').modal('show');
        //              $('.select2').select2();
        //         }
        //     });
        //     // $('#pay_quote_detail_id').val(quote_detail_id);
        //     // $('#quote_pay_id').val(quote_id);
        //     // $('#pay_services_type').val(services_type);
        //     // $('#service_amount').val(service_amount);

        // }



        function convert(quo_id, key) {
            // alert('sds')
            // var inq_id="{{ \Crypt::encrypt($dec_inq_id) }}"
            // var quo_id="{{ \Crypt::encrypt('+quo_id+') }}"
            // alert(quo_id);
            var val_of_conversion = $('#conversion' + key).val();
            // alert(val_of_conversion);
            if (val_of_conversion == "service_level") {
                $('#service_level_btn' + key)[0].click();
            } else if (val_of_conversion == "no_of_person") {
                $('#no_of_person_btn' + key)[0].click();
            } else {
                $('#lum_sum_btn' + key)[0].click();
            }

        }

        function send_for_issuance(quo_id, key) {
            // alert('sds')
            // var inq_id="{{ \Crypt::encrypt($dec_inq_id) }}"
            // var quo_id="{{ \Crypt::encrypt('+quo_id+') }}"
            // alert(quo_id);
            var val_of_conversion = $('#conversion' + key).val();
            // alert(val_of_conversion);
            if (val_of_conversion == "service_level") {
                $('#service_level_btn' + key)[0].click();
            } else if (val_of_conversion == "no_of_person") {
                $('#no_of_person_btn' + key)[0].click();
            } else {
                $('#lum_sum_btn' + key)[0].click();
            }

        }


        function get_visa_rates(append_count) {
            var value = $('#visa_service' + append_count).val();
            var get_no_of_adults = parseInt("{{ $get_inquiry->no_of_adults }}")
            var get_no_of_children = parseInt("{{ $get_inquiry->no_of_children }}")
            var get_no_of_infant = parseInt("{{ $get_inquiry->no_of_infants }}")
            // alert('ssd')
            $.ajax({
                url: "{{ url('get_visa_rates') }}/" + value,
                type: "GET",
                success: function(data) {
                    var service_type = $('#service_type').val();
                    if (service_type == "service_level") {
                        // $('#adult_visa_selling_price' + append_count).val(data.adult_s);
                        if (get_no_of_adults > 0) {
                            $('#adult_visa_cost_price' + append_count).val(data.adult_s);
                        }
                        if (get_no_of_children > 0) {
                            $('#children_visa_cost_price' + append_count).val(data.child_s);
                        }
                        if (get_no_of_infant > 0) {
                            $('#infant_visa_cost_price' + append_count).val(data.infant_s);
                        }
                        // $('#children_visa_selling_price' + append_count).val(data.child_s);
                        // $('#infant_visa_selling_price' + append_count).val(data.infant_s);
                    } else {
                        if (get_no_of_adults > 0) {
                            $('#visa_adult_cost_price' + append_count).val(data.adult_s);
                        }
                        if (get_no_of_children > 0) {

                            $('#visa_children_cost_price' + append_count).val(data.child_s);
                        }
                        if (get_no_of_infant > 0) {

                            $('#visa_infant_cost_price' + append_count).val(data.infant_s);
                        }
                    }


                    visa_calculate(append_count);
                }
            });
        }

        function room_type_on_change(append_count) {

            var hotel_id = $('#hotels' + append_count).val();
            // alert(hotel_id);
            var hotel_room_type = $('#hotel_room_type' + append_count).val();
            if (hotel_id.length > 0) {
                Swal.fire({
                    title: 'Do you want to get Hotel Rates?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: `No`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('get_hotel_rates') }}/" + hotel_id + '/' +
                                append_count + '/' + hotel_room_type,
                            success: function(response) {
                                $('#hotel_rates_title').html("Get Hotel Rates");
                                if (response.hotel_inventory_table == "") {
                                    $('#append_airline_rates_modal').html(
                                        '<span style="display: flex;justify-content: center;align-items: center;">No Records Found</span>'
                                    );
                                    $('#modaldemo6').modal('show');
                                    $('#airline_inv_count' + airline_inv_count).val(airline_inv_count);

                                } else {
                                    $('#append_airline_rates_modal').html(response
                                        .hotel_inventory_table);
                                    $('#airline_name_modal').html("Select Inventory From" + response
                                        .airline_name);
                                    $('#modaldemo6').modal('show');
                                    $('#airline_inv_count' + airline_inv_count).val(airline_inv_count);
                                }

                            }
                        });
                    } else if (result.isDenied) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('append_hotel_beds') }}/" + hotel_room_type + '/' +
                                append_count,
                            success: function(response) {

                                $('#hotel_beds' + append_count).val(response.beds);
                                $('#modaldemo3').modal('hide');


                            }
                        });

                        var room_type = $('#hotel_room_type' + append_count).val();
                        var inv_id = $('#hotel_inv_id' + append_count).val();
                        // alert(inv_id)
                        $.ajax({
                            type: "GET",
                            url: "{{ url('/get_inv_details_fill_price') }}/" + inv_id + '/' + room_type,
                            success: function(response) {
                                $('#hotel_qty' + append_count).val(response.qty);
                                $('#hotel_beds' + append_count).val(response.beds);
                                $('#hotel_cost_price' + append_count).val(response.cost_price);
                                $('#hotel_selling_price' + append_count).val(response.selling_price);
                                $('#hotel_addon' + append_count).html(response.addons_options);
                                hotel_calculate();
                            }
                        });
                    }
                })
            } else {
                var room_type = $('#hotel_room_type' + append_count).val();
                var inv_id = $('#hotel_inv_id' + append_count).val();
                alert(inv_id)
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get_inv_details_fill_price') }}/" + inv_id + '/' + room_type,
                    success: function(response) {
                        $('#hotel_qty' + append_count).val(response.qty);
                        $('#hotel_beds' + append_count).val(response.beds);
                        $('#hotel_cost_price' + append_count).val(response.cost_price);
                        $('#hotel_selling_price' + append_count).val(response.selling_price);
                        $('#hotel_addon' + append_count).html(response.addons_options);
                        hotel_calculate();
                    }
                });
            }


        }

        function add_hotel_inv(inv_id) {
            $.ajax({
                type: "GET",
                url: "{{ url('/get_inv_details') }}/" + inv_id,
                success: function(response) {
                    $('#modaldemo2').modal('hide');
                    $('#hotel_room_type').empty().html(response.room_type_options);
                    $('#hotel_check_in').val(response.from_date);
                    $('#inv_id_hidden').val(inv_id);
                    $('#hotel_check_out').val(response.to_date);
                }
            });
        }

        function send_quotation_to_approval(quote_id) {
            var inq_id = "{{ $dec_inq_id }}";
            Swal.fire({
                title: "Confirmation, Send Quotation on Approval ?",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('#quote_status_id').val(quote_id);
                    $.ajax({
                        type: "GET",
                        url: "{{ url('/send_quotation_to_approval') }}/" + quote_id + '/' + inq_id,
                        success: function(response) {
                            if (response.success == true) {
                                Swal.fire(
                                    'Quotation Shared!',
                                    'Your Quotation Shared Successfully!',
                                    'success'
                                )
                                window.location.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: "Your Quotation Can't Shared Successfully!",
                                })
                            }

                        }
                    });

                } else if (result.isDenied) {

                }
            });

        }

        function send_quotation_to_issuance(quote_id, key) {
            var val_of_issuance = $("#issuance_service" + key).val();
            // alert(val_of_issuance);
            var inq_id = "{{ $dec_inq_id }}";
            Swal.fire({
                title: "Confirmation, Send Quotation For Issuance ?",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('#quote_status_id').val(quote_id);
                    $.ajax({
                        type: "GET",
                        url: "{{ url('/send_quotation_to_issuance') }}/" + quote_id + '/' + inq_id + '/' +
                            val_of_issuance,
                        success: function(response) {
                            if (response.success == true) {
                                Swal.fire(
                                    'Quotation Issuance!',
                                    'Your Quotation Issuance Successfully!',
                                    'success'
                                )
                                window.location.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: "Your Quotation Can't Issuance Successfully!",
                                })
                            }

                        }
                    });

                } else if (result.isDenied) {

                }
            });

        }
        $('.select2').select2({});
        $(document).ready(function() {


            $('.livesearch').select2({
                placeholder: 'Select',
                dropdownParent: $("#modaldemo1"),
                ajax: {
                    url: "{{ route('autocomplete_country') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(
                                item) {
                                return {
                                    text: item
                                        .country_name +
                                        ' - ' + item
                                        .name,
                                    id: item
                                        .country_name +
                                        ' - ' + item
                                        .name,
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

            $("#reasons").hide();
            $("#quotations").hide();
            var val = $("#status").val();
            if (val == 5) {
                $("#reasons").show();
                $("#reason_input").prop("required", true);
            }
            if (val == 4) {
                $("#quotations").show();
                $("#quotations_input").prop("required", true);
            }
            if (val == 3) {
                $("#quotations").show();
                $("#quotations_input").prop("required", true);
            } else {
                $("#reasons").hide();
                $("#quotations").hide();
            }

            $("#status").on("change", function() {
                var val = $(this).val();
                // alert(val)
                if (val == 5) {
                    $("#reasons").show();
                    $("#reasons_input").prop("required", true);
                } else if (val == 3) {
                    $("#quotations").show();
                    $("#quotations_input").prop("required", true);
                } else {
                    $("#reasons").hide();
                    $("#quotations").hide();
                }
            });
            $('#campaign').on('change', function() {
                var val = $(this).val();
                $.ajax({
                    url: "{{ url('get_campaign_data') }}/" + val,
                    type: "GET",
                    success: function(data) {
                        // alert(data.);
                        // $('#sub_services').html(data);
                        $('#inquiry_type').val(data.inquiry_id);

                    }
                });
            });



            $('#services').on('change', function() {
                var val = $(this).val();
                var inq_id = "{{ $dec_inq_id }}";
                $.ajax({
                    url: "{{ url('get_sub_services_id') }}/" + val + "/" + inq_id,
                    type: "GET",
                    success: function(data) {
                        $('#sub_services_option').html(data.data);
                        $('.select2').select2();
                    }
                });
            });


        });
        var counti = 1;

        function add_more() {

            counti = counti + 1;
            $.ajax({
                url: "{{ url('add_more_services') }}/" + counti,
                type: 'GET',
                success: function(data) {
                    console.log(data.script)
                    $('#append_services').append(data.data);

                    // $('#append_js').append(data.script);
                    $('#count_id').val(counti);
                    $('.js-example-basic-multiple').select2()

                    $('#services' + counti).on('change', function() {
                        var val = $(this).val();
                        $.ajax({
                            url: "{{ url('get_sub_services') }}/" + val,
                            type: "GET",
                            success: function(data) {
                                console.log(data)
                                $('#sub_services' + counti).html(data);
                                $('.fc-datepicker').datepicker({
                                    showOtherMonths: true,
                                    selectOtherMonths: true,
                                    dateFormat: 'd/M/y',
                                });
                            }
                        });
                    });
                }
            });

        }

        $(document).ready(function() {
            var inq_id = "{{ $dec_inq_id }}";

            $.ajax({
                type: "GET",
                url: "{{ url('/append_services_edit') }}/" + inq_id,
                success: function(response) {
                    $("#append_services").html(response.services);
                    $('.js-example-basic-multiple').select2();
                }
            });

        });

        function remove(count_rmv) {

            counti = counti - 1;
            $('.rmv' + count_rmv).remove();
        }

        function remove_echo(count_rmv) {

            counti = counti - 1;
            $('.rmv' + count_rmv).remove();
        }


        // BILAL Work =====================================================
        $('form').bind('submit', function() {
            $(this).find('#service_type').prop('disabled', false);
            $('.hotel_addon').each(function(index, element) {
                $(element).val("Select Addon");
            });
            $(".dis_f").each(function(index, element) {
                // element == this
                $(element).prop('disabled', false);
            });

        });


        var append_quotation_count = 0;


        function append_quotation_details_for_conversion(sub_services_id_all) {
            // alert(sub_services_id_all);
            var sub_services = sub_services_id_all;
            var get_no_of_adults = parseInt("{{ $get_inquiry->no_of_adults }}")
            var get_no_of_children = parseInt("{{ $get_inquiry->no_of_children }}")
            var get_no_of_infant = parseInt("{{ $get_inquiry->no_of_infants }}")
            var services = $("#services").val();
            var service_type = $("#service_type").val();
            var inq_id = "{{ $dec_inq_id }}";
            $.ajax({
                type: "GET",
                url: "{{ url('/append_quotation_details') }}/" + sub_services + '/' +
                    append_quotation_count +
                    '/' + service_type + '/' + legs_count + '/' + inq_id + 'all=all',

                success: function(response) {
                    $('#append_table').prepend(response.data);
                    // alert(count_for_profit)
                    $('#append_table').append(response.lum_sum);

                    $('#service_type').prop("disabled", true);

                    $('#default_rate_of_exchange').prop("disabled", true);

                    if (get_no_of_adults == 0) {
                        $('#visa_adult_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#airline_adult_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#adult_airline_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#adult_airline_selling_price' + append_quotation_count).prop("disabled", true);
                        $('#adult_visa_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#adult_visa_selling_price' + append_quotation_count).prop("disabled", true);
                        $('#adult_land_cost_price' + append_quotation_count).prop("disabled", true);
                        $('.adult_land_services_sum_cost_price' + append_quotation_count).prop("disabled",
                            true);
                        $('#hotel_adult_cost_price' + append_quotation_count).prop("disabled", true);

                    }
                    if (get_no_of_children == 0) {
                        $('#visa_children_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#airline_children_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#land_services_children_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#hotel_children_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#children_airline_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#children_airline_selling_price' + append_quotation_count).prop("disabled", true);
                        $('#children_visa_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#children_visa_selling_price' + append_quotation_count).prop("disabled", true);
                        $('.children_land_services_sum_cost_price' + append_quotation_count).prop("disabled",
                            true);
                    }

                    if (get_no_of_infant == 0) {
                        $('#visa_infant_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#airline_infant_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#land_services_infant_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#hotel_infant_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#infant_airline_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#infant_airline_selling_price' + append_quotation_count).prop("disabled", true);
                        $('#infant_visa_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#infant_visa_selling_price' + append_quotation_count).prop("disabled", true);
                        $('.infant_land_services_sum_cost_price' + append_quotation_count).prop("disabled",
                            true);
                    }

                    var service_id = $('#services').val();
                    var sub_services_id = $('#sub_services_option').val();
                    if (response.sub_service_name == "Visa") {
                        $('#visa_service_id' + append_quotation_count).val(service_id);
                        $('#visa_sub_service_id' + append_quotation_count).val(
                            sub_services_id);
                    }
                    if (response.sub_service_name == "Hotel") {
                        $('#hotel_service_id' + append_quotation_count).val(service_id);
                        $('#hotel_sub_service_id' + append_quotation_count).val(
                            sub_services_id);
                    }
                    if (response.sub_service_name == "Air Ticket") {
                        $('#airline_services_id').val(service_id);
                        $('#airline_sub_services_id').val(sub_services_id);
                    }
                    if (response.sub_service_name == "Land Services") {
                        $('#land_services_service_id' + append_quotation_count).val(
                            service_id);
                        $('#land_services_sub_service_id' + append_quotation_count).val(
                            sub_services_id);
                        $('#service_type').val();
                    }
                    $('.js-example-basic-multiple' + append_quotation_count).select2()
                    $('.select2' + append_quotation_count).select2({});
                    $(".time_pick").clockpicker({
                        autoclose: true,
                        default: 'now',
                        donetext: "Select",
                    });
                    $('.livesearch_for_airline_destination' + append_quotation_count)
                        .select2({
                            placeholder: 'Select',
                            ajax: {
                                url: "{{ route('autocomplete_country') }}",
                                dataType: 'json',
                                delay: 250,
                                processResults: function(data) {
                                    return {
                                        results: $.map(data, function(
                                            item) {
                                            return {
                                                text: item
                                                    .country_name +
                                                    ' - ' + item
                                                    .name,
                                                id: item
                                                    .country_name +
                                                    ' - ' + item
                                                    .name,
                                            }
                                        })
                                    };
                                },
                                cache: true
                            }
                        });

                    $('.livesearch_hotel_city').select2({
                        placeholder: 'Select',
                        ajax: {
                            url: "{{ route('autocomplete_country') }}",
                            dataType: 'json',
                            delay: 250,
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(
                                        item) {
                                        return {
                                            text: item
                                                .name,
                                            id: item
                                                .name,
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                    });



                    $('.fc-datepicker' + append_quotation_count).datepicker({
                        showOtherMonths: true,
                        selectOtherMonths: true,
                        dateFormat: 'd/M/y',
                    });
                    $('.fc-datepicker_to_date' + append_quotation_count).datepicker({
                        showOtherMonths: true,
                        selectOtherMonths: true,
                        dateFormat: 'd/M/y',
                        minDate: 0 // This sets the minimum date to the current date
                    });

                    $('#submit_buttons').css('display', 'block');


                    append_quotation_count = append_quotation_count + 1;


                },
                beforeSend: function() {
                    // setting a timeout
                    $('#loading-image').removeClass('d-none');
                    $('#loading-image').addClass('block');
                },
                complete: function() {
                    $('#loading-image').removeClass('block');
                    $('#loading-image').addClass('d-none');
                }
            });
        }

        // function check_append_quotation_details() {
        //     var sub_services_val = $("#sub_services_option").val();
        //     if (sub_services_val == 'all') {
        //         let sub_services_id_all = 0;
        //         $("#sub_services_option > option").each(function(index,option,sub_services_id_all) {
        //             // alert(this.value);
        //             setTimeout(function timer() {
        //                 if (this.value != "all") {
        //                     var sub_services_id = this.value;
        //                     append_quotation_details_for_conversion(sub_services_id);
        //                 }
        //             }, index * 3000);
        //         });
        //     } else {
        //         // append_quotation_count=0;
        //         append_quotation_details();
        //     }
        // }
        function check_append_quotation_details() {
            var sub_services_val = $("#sub_services_option").val();
            if (sub_services_val === 'all') {
                $('#loading-image').removeClass('d-none');
                $('#loading-image').addClass('block');
                $("#sub_services_option > option").each(function(index, option) {

                    setTimeout(function timer() {
                        if (option.value !== "all") {
                            append_quotation_details_for_conversion(option.value);
                        }
                    }, index * 1300);
                });
                $('#loading-image').removeClass('block');
                $('#loading-image').removeClass('d-none');

            } else {

                append_quotation_details();
            }
        }

        function append_quotation_details() {
            var sub_services = $("#sub_services_option").val();
            var services = $("#services").val();
            var service_type = $("#service_type").val();
            var inq_id = "{{ $dec_inq_id }}";
            var get_no_of_adults = parseInt("{{ $get_inquiry->no_of_adults }}")
            var get_no_of_children = parseInt("{{ $get_inquiry->no_of_children }}")
            var get_no_of_infant = parseInt("{{ $get_inquiry->no_of_infants }}")

            // alert(inq_id);


            $.ajax({
                type: "GET",
                url: "{{ url('/append_quotation_details') }}/" + sub_services + '/' + append_quotation_count +
                    '/' + service_type + '/' + legs_count + '/' + inq_id,
                success: function(response) {
                    $('#append_table').prepend(response.data);
                    $('#append_table').append(response.lum_sum);
                    $('#service_type').prop("disabled", true);
                    $('#default_rate_of_exchange').prop("disabled", true);
                    if (get_no_of_adults == 0) {
                        $('#visa_adult_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#airline_adult_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#adult_airline_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#adult_airline_selling_price' + append_quotation_count).prop("disabled", true);
                        $('#adult_visa_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#adult_visa_selling_price' + append_quotation_count).prop("disabled", true);
                        $('#adult_land_cost_price' + append_quotation_count).prop("disabled", true);
                        $('.adult_land_services_sum_cost_price' + append_quotation_count).prop("disabled",
                            true);
                        $('#hotel_adult_cost_price' + append_quotation_count).prop("disabled", true);

                    }
                    if (get_no_of_children == 0) {
                        $('#visa_children_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#airline_children_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#land_services_children_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#hotel_children_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#children_airline_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#children_airline_selling_price' + append_quotation_count).prop("disabled", true);
                        $('#children_visa_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#children_visa_selling_price' + append_quotation_count).prop("disabled", true);
                        $('.children_land_services_sum_cost_price' + append_quotation_count).prop("disabled",
                            true);
                    }

                    if (get_no_of_infant == 0) {
                        $('#visa_infant_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#airline_infant_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#land_services_infant_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#hotel_infant_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#infant_airline_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#infant_airline_selling_price' + append_quotation_count).prop("disabled", true);
                        $('#infant_visa_cost_price' + append_quotation_count).prop("disabled", true);
                        $('#infant_visa_selling_price' + append_quotation_count).prop("disabled", true);
                        $('.infant_land_services_sum_cost_price' + append_quotation_count).prop("disabled",
                            true);
                    }

                    var service_id = $('#services').val();
                    var sub_services_id = $('#sub_services_option').val();
                    if (response.sub_service_name == "Visa") {
                        $('#visa_service_id' + append_quotation_count).val(service_id);
                        $('#visa_sub_service_id' + append_quotation_count).val(sub_services_id);
                    }
                    if (response.sub_service_name == "Hotel") {
                        $('#hotel_service_id' + append_quotation_count).val(service_id);
                        $('#hotel_sub_service_id' + append_quotation_count).val(sub_services_id);
                    }
                    if (response.sub_service_name == "Air Ticket") {
                        $('#airline_services_id').val(service_id);
                        $('#airline_sub_services_id').val(sub_services_id);
                    }
                    if (response.sub_service_name == "Land Services") {
                        $('#land_services_service_id' + append_quotation_count).val(service_id);
                        $('#land_services_sub_service_id' + append_quotation_count).val(sub_services_id);
                        $('#service_type').val();
                    }
                    $('.js-example-basic-multiple' + append_quotation_count).select2()
                    $('.select2' + append_quotation_count).select2({});
                    $(".time_pick").clockpicker({
                        autoclose: true,
                        default: 'now',
                        donetext: "Select",
                    });
                    $('.livesearch_for_airline_destination' + append_quotation_count).select2({
                        placeholder: 'Select',
                        ajax: {
                            url: "{{ route('autocomplete_country') }}",
                            dataType: 'json',
                            delay: 250,
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(
                                        item) {
                                        return {
                                            text: item
                                                .country_name +
                                                ' - ' + item
                                                .name,
                                            id: item
                                                .country_name +
                                                ' - ' + item
                                                .name,
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                    });
                    $('.livesearch_hotel_city').select2({
                        placeholder: 'Select',
                        ajax: {
                            url: "{{ route('autocomplete_country') }}",
                            dataType: 'json',
                            delay: 250,
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(
                                        item) {
                                        return {
                                            text: item
                                                .name,
                                            id: item
                                                .name,
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                    });
                    $('.fc-datepicker' + append_quotation_count).datepicker({
                        showOtherMonths: true,
                        dateFormat: 'd/M/y',
                        selectOtherMonths: true,
                    });

                    // $('.fc-datepicker' + append_quotation_count).datepicker({
                    //     showOtherMonths: true,
                    //     altField: ".fc-datepicker" + append_quotation_count,
                    //     selectOtherMonths: true,

                    // });

                    // $('.fc-datepicker' + append_quotation_count).each(function(index, element) {
                    //     var get_val = $(element).val();
                    //     $(element).html('sds');
                    // });

                    $('.fc-datepicker_to_date' + append_quotation_count).datepicker({
                        showOtherMonths: true,
                        dateFormat: 'd/M/y',
                        selectOtherMonths: true,
                        minDate: 0 // This sets the minimum date to the current date
                    });
                    $('#submit_buttons').css('display', 'block');

                    append_quotation_count = append_quotation_count + 1;


                },
                beforeSend: function() {
                    // setting a timeout
                    $('#loading-image').removeClass('d-none');
                    $('#loading-image').addClass('block');
                },
                complete: function() {
                    $('#loading-image').removeClass('block');
                    $('#loading-image').addClass('d-none');
                }
            });


        }

        function hotel_calculate(append_count, legs_count) {
            // alert('Please enter');
            // hotel_adult_total
            var get_no_of_adults = parseInt("{{ $get_inquiry->no_of_adults }}")
            var get_no_of_children = parseInt("{{ $get_inquiry->no_of_children }}")
            var get_no_of_infant = parseInt("{{ $get_inquiry->no_of_infants }}")

            if (legs_count) {
                var nights = $('#hotel_nights' + legs_count).val();
                var check_in_date = $('#hotel_check_in' + legs_count).val();
                var days = moment(new Date(check_in_date)).add(nights, 'day').format('M/D/Y')
                var check_out_date = $('#hotel_check_out' + legs_count).val(days);
            } else {
                var nights = $('#hotel_nights' + append_count).val();
                var check_in_date = $('#hotel_check_in' + append_count).val();
                var days = moment(new Date(check_in_date)).add(nights, 'day').format('M/D/Y')
                var check_out_date = $('#hotel_check_out' + append_count).val(days);
            }
            var service_type = $('#service_type').val();
            if (service_type == 'service_level') {

                const array_hotel_addon = [];
                var tmp_count = append_count;
                if (legs_count) {
                    var nights_count = $("#hotel_nights" + legs_count).val() || 1;
                    $('.hotel_addon' + legs_count).each(function(index, element) {
                        const selectedValues = $(element).val();

                        if (selectedValues) {
                            array_hotel_addon.push(selectedValues);
                        }
                    });
                } else {
                    var nights_count = $("#hotel_nights" + append_count).val() || 1;
                    $('.hotel_addon' + append_count).each(function(index, element) {
                        const selectedValues = $(element).val();

                        if (selectedValues) {
                            array_hotel_addon.push(selectedValues);
                        }
                    });
                }
                console.log(array_hotel_addon);
                const selectedValues = $("#hotel_addon" + append_count).val();
                var addon_selling_price = "";
                var total_sum = 0;
                if (legs_count != null) {
                    var addon_count = $('#hotel_addon' + legs_count).val();
                } else {
                    var addon_count = $('#hotel_addon' + append_count).val();
                }
                console.log(addon_count);
                console.log(array_hotel_addon);
                if (addon_count.length > 0 && array_hotel_addon) {

                    $.ajax({
                        type: "GET",
                        url: "{{ url('get_addons') }}/" + selectedValues,
                        success: function(response) {
                            addon_selling_price = response.selling_price;
                            addon_cost_price = response.cost_price;
                            console.log(addon_selling_price)
                            if (addon_selling_price || addon_cost_price) {
                                const sum = addon_selling_price.reduce((acc, val) => acc + parseInt(val), 0);
                                const cost_sum = addon_cost_price.reduce((acc, val) => acc + parseInt(val), 0);
                                console.log("Selected values:", addon_selling_price);
                                console.log("Sum:", sum);
                                total_sum = sum;
                                if (legs_count != null) {
                                    var qty = parseInt($('#hotel_qty' + legs_count).val()) || 0;
                                    var hotel_selling_price = parseFloat($('#hotel_selling_price' + legs_count)
                                            .val()) ||
                                        0;
                                    var hotel_cost_price = parseFloat($('#hotel_cost_price' + legs_count)
                                            .val()) ||
                                        0;
                                    var get_s_t = parseInt($('#hotel_sub_total' + append_count).val()) || 0;
                                    var hotel_sub_total = ((qty * hotel_selling_price) + sum) * nights_count;
                                    var hotel_cost_price = ((qty * hotel_cost_price) + cost_sum) * nights_count;
                                    var hotel_discount = parseFloat($('#hotel_discount' + append_count)
                                        .val()) || 0;
                                    var hotel_total = hotel_sub_total - hotel_discount;
                                    $('#hotel_sub_total' + append_count).val(hotel_sub_total.toFixed(2));
                                    $('#hotel_total_cost_price' + append_count).val(hotel_cost_price.toFixed(
                                        2));
                                    $('#get_sub_total_legs' + legs_count).val(hotel_sub_total);
                                    // $('#hotel_total' + append_count).val(hotel_total.toFixed(2));
                                } else {
                                    var qty = parseInt($('#hotel_qty' + append_count).val()) || 0;
                                    var hotel_selling_price = parseFloat($('#hotel_selling_price' +
                                                append_count)
                                            .val()) ||
                                        0;
                                    var get_s_t = parseInt($('#hotel_sub_total' + append_count).val()) || 0;

                                    var hotel_sub_total = ((qty * hotel_selling_price) + sum) * nights_count;
                                    var hotel_discount = parseFloat($('#hotel_discount' + append_count)
                                        .val()) || 0;
                                    var hotel_total = hotel_sub_total - hotel_discount;
                                    // $('#hotel_sub_total' + append_count).val(hotel_sub_total.toFixed(2));
                                    $('#get_sub_total_legs' + append_count).val(hotel_sub_total);
                                    // $('#hotel_total' + append_count).val(hotel_total.toFixed(2));
                                }
                                var totalSum = 0;
                                $('.get_sub_total_legs' + append_count).each(function(index, element) {
                                    let subTotal = $(element).val();
                                    totalSum += parseFloat(subTotal);
                                });

                                $('#hotel_sub_total' + append_count).val(totalSum.toFixed(2));
                                var hotel_discount = parseFloat($('#hotel_discount' + append_count).val()) || 0;
                                var hotel_total = totalSum - hotel_discount;
                                $('#hotel_total' + append_count).val(hotel_total.toFixed(2));
                                console.log(totalSum);
                            } else {
                                console.log("No values selected.");
                            }
                        }
                    });
                } else {
                    if (legs_count != null) {

                        var qty = parseInt($('#hotel_qty' + legs_count).val()) || 0;
                        var hotel_selling_price = parseFloat($('#hotel_selling_price' + legs_count)
                                .val()) ||
                            0
                        var get_s_t = parseInt($('#hotel_sub_total' + append_count).val()) || 0;
                        var hotel_sub_total = (qty * hotel_selling_price) * nights_count;
                        var hotel_discount = parseFloat($('#hotel_discount' + append_count).val()) || 0;

                        var hotel_total = hotel_sub_total - hotel_discount;
                        // $('#hotel_sub_total' + append_count).val(hotel_sub_total.toFixed(2));
                        $('#get_sub_total_legs' + legs_count).val(hotel_sub_total);
                        $('#hotel_total' + append_count).val(hotel_total.toFixed(2));
                    } else {
                        var qty = parseInt($('#hotel_qty' + append_count).val()) || 0;
                        var hotel_selling_price = parseFloat($('#hotel_selling_price' + append_count)
                                .val()) ||
                            0;
                        var get_s_t = parseInt($('#hotel_sub_total' + append_count).val()) || 0;

                        var hotel_sub_total = (qty * hotel_selling_price) * nights_count;
                        var hotel_discount = parseFloat($('#hotel_discount' + append_count).val()) || 0;
                        var hotel_total = hotel_sub_total - hotel_discount;
                        // $('#hotel_sub_total' + append_count).val(hotel_sub_total.toFixed(2));
                        $('#get_sub_total_legs' + append_count).val(hotel_sub_total);
                        $('#hotel_total' + append_count).val(hotel_total.toFixed(2));
                    }
                }
                var totalSum = 0;
                $('.get_sub_total_legs' + append_count).each(function(index, element) {
                    let subTotal = $(element).val();
                    totalSum += parseFloat(subTotal);
                });

                $('#hotel_sub_total' + append_count).val(totalSum.toFixed(2));
                var hotel_discount = parseFloat($('#hotel_discount' + append_count).val()) || 0;
                var hotel_total = totalSum - hotel_discount;
                $('#hotel_total' + append_count).val(hotel_total.toFixed(2));
                console.log(totalSum);
            } else {
                const array_hotel_addon = [];
                var tmp_count = append_count;
                if (legs_count) {
                    var nights_count = $("#hotel_nights" + legs_count).val() || 1;
                    $('.hotel_addon' + legs_count).each(function(index, element) {
                        const selectedValues = $(element).val();

                        if (selectedValues) {
                            array_hotel_addon.push(selectedValues);
                        }
                    });
                } else {
                    var nights_count = $("#hotel_nights" + append_count).val() || 1;
                    $('.hotel_addon' + append_count).each(function(index, element) {
                        const selectedValues = $(element).val();

                        if (selectedValues) {
                            array_hotel_addon.push(selectedValues);
                        }
                    });
                }
                console.log(array_hotel_addon);
                const selectedValues = $("#hotel_addon" + append_count).val();
                var addon_selling_price = "";
                var total_sum = 0;
                if (legs_count != null) {
                    var addon_count = $('#hotel_addon' + legs_count).val();
                } else {
                    var addon_count = $('#hotel_addon' + append_count).val();
                }
                console.log(addon_count);
                console.log(array_hotel_addon);
                if (addon_count.length > 0 && array_hotel_addon) {

                    $.ajax({
                        type: "GET",
                        url: "{{ url('get_addons') }}/" + selectedValues,
                        success: function(response) {
                            addon_selling_price = response.selling_price;
                            console.log(addon_selling_price)
                            if (addon_selling_price) {
                                const sum = addon_selling_price.reduce((acc, val) => acc + parseInt(val), 0);
                                console.log("Selected values:", addon_selling_price);
                                total_sum = sum;
                                if (legs_count != null) {
                                    var qty = parseInt($('#hotel_qty' + legs_count).val()) || 0;
                                    var hotel_selling_price = parseFloat($('#hotel_selling_price' + legs_count)
                                            .val()) ||
                                        0;
                                    var get_s_t = parseInt($('#hotel_sub_total' + append_count).val()) || 0;
                                    var hotel_sub_total = ((qty * hotel_selling_price) + sum) * nights_count;
                                    var hotel_discount = parseFloat($('#hotel_discount' + append_count)
                                        .val()) || 0;
                                    var hotel_total = hotel_sub_total - hotel_discount;

                                    $('#hotel_total_cost_price' + append_count).val(hotel_sub_total.toFixed(2));
                                    $('#get_sub_total_legs' + legs_count).val(hotel_sub_total);
                                    // $('#hotel_total' + append_count).val(hotel_total.toFixed(2));
                                } else {
                                    var qty = parseInt($('#hotel_qty' + append_count).val()) || 0;
                                    var hotel_selling_price = parseFloat($('#hotel_selling_price' +
                                                append_count)
                                            .val()) ||
                                        0;
                                    var get_s_t = parseInt($('#hotel_sub_total' + append_count).val()) || 0;
                                    var hotel_sub_total = ((qty * hotel_selling_price) + sum) * nights_count;
                                    var hotel_discount = parseFloat($('#hotel_discount' + append_count)
                                        .val()) || 0;
                                    var hotel_total = hotel_sub_total - hotel_discount;
                                    // $('#hotel_sub_total' + append_count).val(hotel_sub_total.toFixed(2));
                                    $('#get_sub_total_legs' + append_count).val(hotel_sub_total);
                                    // $('#hotel_total' + append_count).val(hotel_total.toFixed(2));
                                }
                                var totalSum = 0;
                                $('.get_sub_total_legs' + append_count).each(function(index, element) {
                                    let subTotal = $(element).val();
                                    totalSum += parseFloat(subTotal);
                                });


                                $('#hotel_total_cost_price' + append_count).val(totalSum.toFixed(2));
                                var hotel_discount = parseFloat($('#hotel_discount' + append_count).val()) || 0;
                                var hotel_total = totalSum - hotel_discount;
                                $('#hotel_total' + append_count).val(hotel_total.toFixed(2));
                                console.log(totalSum);
                            } else {
                                console.log("No values selected.");
                            }
                        }
                    });
                } else {
                    if (legs_count != null) {

                        var qty = parseInt($('#hotel_qty' + legs_count).val()) || 0;
                        var hotel_adult_cost_price = parseFloat($('#hotel_adult_cost_price' + legs_count)
                                .val()) ||
                            0;
                        var hotel_children_cost_price = parseFloat($('#hotel_children_cost_price' + legs_count)
                                .val()) ||
                            0;
                        var hotel_infant_cost_price = parseFloat($('#hotel_infant_cost_price' + legs_count)
                                .val()) ||
                            0;

                        var get_adult_total = (hotel_adult_cost_price * qty) * get_no_of_adults;
                        var get_children_total = (hotel_children_cost_price * qty) * get_no_of_children;
                        var get_infant_total = (hotel_infant_cost_price * qty) * get_no_of_infant;


                        var all_sum_of_cost_price = get_infant_total + get_adult_total + get_children_total;
                        var get_s_t = parseInt($('#hotel_total_cost_price' + append_count).val()) || 0;
                        var hotel_sub_total = (all_sum_of_cost_price) * nights_count;
                        var hotel_discount = parseFloat($('#hotel_discount' + append_count).val()) || 0;

                        var hotel_total = hotel_sub_total - hotel_discount;
                        $('#hotel_total_cost_price' + append_count).val(hotel_sub_total.toFixed(2));
                        $('#get_sub_total_legs' + legs_count).val(hotel_sub_total);
                        $('#hotel_total' + append_count).val(hotel_total.toFixed(2));
                    } else {
                        var qty = parseInt($('#hotel_qty' + append_count).val()) || 0;
                        var hotel_adult_cost_price = parseFloat($('#hotel_adult_cost_price' + append_count)
                                .val()) ||
                            0;
                        var hotel_children_cost_price = parseFloat($('#hotel_children_cost_price' + append_count)
                                .val()) ||
                            0;
                        var hotel_infant_cost_price = parseFloat($('#hotel_infant_cost_price' + append_count)
                                .val()) ||
                            0;


                        var get_adult_total = (hotel_adult_cost_price * qty) * get_no_of_adults;
                        var get_children_total = (hotel_children_cost_price * qty) * get_no_of_children;
                        var get_infant_total = (hotel_infant_cost_price * qty) * get_no_of_infant;

                        var all_sum_of_cost_price = get_infant_total + get_adult_total + get_children_total;
                        var get_s_t = parseInt($('#hotel_total_cost_price' + append_count).val()) || 0;

                        var hotel_sub_total = (all_sum_of_cost_price) * nights_count;
                        var hotel_discount = parseFloat($('#hotel_discount' + append_count).val()) || 0;
                        var hotel_total = hotel_sub_total - hotel_discount;
                        $('#hotel_total_cost_price' + append_count).val(hotel_sub_total.toFixed(2));
                        $('#get_sub_total_legs' + append_count).val(hotel_sub_total);
                        $('#hotel_total' + append_count).val(hotel_total.toFixed(2));
                    }
                }

                var totalSum = 0;
                $('.get_sub_total_legs' + append_count).each(function(index, element) {
                    let subTotal = $(element).val();
                    totalSum += parseFloat(subTotal);
                });

                $('#hotel_total_cost_price' + append_count).val(totalSum.toFixed(2));
                var hotel_discount = parseFloat($('#hotel_discount' + append_count).val()) || 0;
                var hotel_total = totalSum - hotel_discount;
                $('#hotel_total' + append_count).val(hotel_total.toFixed(2));
                console.log(totalSum);
            }


            if (service_type == 'service_level') {
                var hotel_total_cost_price = 0;
                $('.hotel_cost_price' + append_count).each(function(index, element) {
                    let hotel_total_cp = $(element).val();
                    hotel_total_cost_price += parseFloat(hotel_total_cp * qty);
                });
                $('#hotel_total_cost_price' + append_count).val((hotel_total_cost_price * nights_count) + total_sum);
            }

            // Calculation OF Profit
            if (service_type == 'no_of_person' || service_type == 'lum_sum') {
                if (legs_count != null) {
                    $('#hotel_adult_total_cost_price' + legs_count).val((get_adult_total * nights_count));
                    $('#hotel_children_total_cost_price' + legs_count).val((get_children_total * nights_count));
                    $('#hotel_infant_total_cost_price' + legs_count).val((get_infant_total * nights_count));
                } else {
                    $('#hotel_adult_total_cost_price' + append_count).val((get_adult_total * nights_count));
                    $('#hotel_children_total_cost_price' + append_count).val((get_children_total * nights_count));
                    $('#hotel_infant_total_cost_price' + append_count).val((get_infant_total * nights_count));
                }
                var hotel_discount = parseFloat($('#hotel_discount' + append_count).val()) || 0;
                var hotel_discount = hotel_discount / 3;
                $('.hotel_adult_total_cost_price' + append_count).each(function(index, element) {
                    var adult_c_price = $(element).val();
                    $(element).val(adult_c_price - hotel_discount)
                });
                $('.hotel_children_total_cost_price' + append_count).each(function(index, element) {
                    var children_c_price = $(element).val();
                    $(element).val(children_c_price - hotel_discount)
                });
                $('.hotel_infant_total_cost_price' + append_count).each(function(index, element) {
                    var infant_c_price = $(element).val();
                    $(element).val(infant_c_price - hotel_discount)
                });
                var profit_adult_sum = 0;
                var profit_children_sum = 0;
                var profit_infant_sum = 0;
                $('.adult_cost_price_sum').each(function(index, element) {
                    var adult_c_price = parseInt($(element).val());
                    profit_adult_sum = profit_adult_sum + adult_c_price;
                });

                $('.children_cost_price_sum').each(function(index, element) {
                    var children_c_price = parseInt($(element).val());
                    profit_children_sum = profit_children_sum + children_c_price;
                });

                $('.infant_cost_price_sum').each(function(index, element) {
                    var infant_c_price = parseInt($(element).val());
                    profit_infant_sum = profit_infant_sum + infant_c_price;
                });
                $('#adult_total_cost_price_all_sum').val(profit_adult_sum)
                $('#children_total_cost_price_all_sum').val(profit_children_sum)
                $('#infant_total_cost_price_all_sum').val(profit_infant_sum)

                get_profit_calculation()
            }
            get_profit_calculation()
        }

        function get_profit_calculation() {


            // alert('sdsd');

            var service_type = $('#service_type').val();
            if (service_type != "service_level") {
                var profit_adult_sum = 0;
                var profit_children_sum = 0;
                var profit_infant_sum = 0;

                $('.adult_cost_price_sum').each(function(index, element) {
                    var adult_c_price = parseInt($(element).val()) || 0;
                    profit_adult_sum = profit_adult_sum + adult_c_price;
                });

                $('.children_cost_price_sum').each(function(index, element) {
                    var children_c_price = parseInt($(element).val()) || 0;
                    profit_children_sum = profit_children_sum + children_c_price;
                });

                $('.infant_cost_price_sum').each(function(index, element) {
                    var infant_c_price = parseInt($(element).val()) || 0;
                    profit_infant_sum = profit_infant_sum + infant_c_price;
                });
                // alert(profit_adult_sum)
                $('#adult_total_cost_price_all_sum').val(profit_adult_sum)
                $('#children_total_cost_price_all_sum').val(profit_children_sum)
                $('#infant_total_cost_price_all_sum').val(profit_infant_sum)

            }
            // alert(service_type)
            if (service_type == 'service_level') {
                var total_cost_price_sum_sl = 0
                var total_selling_price_sum_sl = 0
                // alert(total_cost_price_sum_sl)
                var total_sum_sl = 0
                $('.total_cost_price_sum').each(function(index, element) {
                    total_cost_price_sum_sl += parseInt($(element).val()) || 0
                });
                $('.total_selling_price_sum').each(function(index, element) {
                    total_selling_price_sum_sl += parseInt($(element).val()) || 0
                });
                $('.total_sum').each(function(index, element) {
                    total_sum_sl += parseInt($(element).val()) || 0
                });

                $('#total_cost_price_sl').val(parseInt(total_cost_price_sum_sl))
                parseInt($('#total_selling_price_sl').val(parseInt(total_selling_price_sum_sl)))
                parseInt($('#grand_total').val(parseInt(total_sum_sl)))
                $('#grand_total_html').html(parseInt(total_sum_sl) + '/-')
            }
            if (service_type == 'no_of_person') {
                var get_no_of_adults = parseInt("{{ $get_inquiry->no_of_adults }}")
                var get_no_of_children = parseInt("{{ $get_inquiry->no_of_children }}")
                var get_no_of_infant = parseInt("{{ $get_inquiry->no_of_infants }}")
                var get_adult_profit = parseInt($('#adult_profit').val()) * get_no_of_adults || 0;
                var get_children_profit = parseInt($('#children_profit').val()) * get_no_of_children || 0;
                var get_infant_profit = parseInt($('#infant_profit').val()) * get_no_of_infant || 0;
                $('#adult_selling_price').val(profit_adult_sum + get_adult_profit)
                $('#children_selling_price').val(profit_children_sum + get_children_profit)
                $('#infant_selling_price').val(profit_infant_sum + get_infant_profit)
                var get_adult_total_selling_price = parseInt($('#adult_selling_price').val())
                var get_children_total_selling_price = parseInt($('#children_selling_price').val())
                var get_infant_total_selling_price = parseInt($('#infant_selling_price').val())

                var grand_total = get_adult_total_selling_price + get_children_total_selling_price +
                    get_infant_total_selling_price;

                $('#grand_total').val(grand_total)
                $('#grand_total_html').html(grand_total + '/-')
            } else if (service_type == 'lum_sum') {
                var get_lum_sum_profit = parseInt($('#lum_sum_profit').val()) || 0;
                // alert(get_lum_sum_profit)
                $('#adult_selling_price').val(profit_adult_sum + get_lum_sum_profit)
                $('#children_selling_price').val(profit_children_sum + get_lum_sum_profit)
                $('#infant_selling_price').val(profit_infant_sum + get_lum_sum_profit)
                var get_adult_total_selling_price = parseInt($('#adult_selling_price').val())
                var get_children_total_selling_price = parseInt($('#children_selling_price').val())
                var get_infant_total_selling_price = parseInt($('#infant_selling_price').val())

                var grand_total = get_adult_total_selling_price + get_children_total_selling_price +
                    get_infant_total_selling_price;

                $('#grand_total').val(grand_total)
                $('#grand_total_html').html(grand_total + '/-')
            }

        }

        function get_days_from_date(append_count) {

            const date1 = $('#visa_from_date' + append_count).val();
            const date2 = $('#visa_to_date' + append_count).val();
            if (date1.length > 0 && date2.length > 0) {
                const dateObj1 = new Date(date1);
                const dateObj2 = new Date(date2);
                const timeDifference = dateObj2.getTime() - dateObj1.getTime();
                const numberOfDays = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                $('#no_of_days' + append_count).val(numberOfDays);
            }

        }

        function visa_calculate(append_count) {
            var service_type = $('#service_type').val();

            var get_no_of_adults = parseInt("{{ $get_inquiry->no_of_adults }}")
            var get_no_of_children = parseInt("{{ $get_inquiry->no_of_children }}")
            var get_no_of_infant = parseInt("{{ $get_inquiry->no_of_infants }}")
            // alert(get_no_of_infant);
            if (service_type == "no_of_person" || service_type == "lum_sum") {

                var adult_cost_price = parseInt($('#visa_adult_cost_price' + append_count).val()) || 0;
                var children_cost_price = parseInt($('#visa_children_cost_price' + append_count).val()) || 0;
                var infant_cost_price = parseInt($('#visa_infant_cost_price' + append_count).val()) || 0;
                // alert(adult_cost_price)
                // alert(children_cost_price)
                // alert(infant_cost_price)


                var all_sum = (adult_cost_price * get_no_of_adults) + (children_cost_price * get_no_of_children) + (
                    infant_cost_price * get_no_of_infant);
                var visa_sub_total = parseInt(all_sum);
                // alert(visa_sub_total);
                var visa_discount = parseFloat($('#visa_discount' + append_count).val()) || 0;

                var visa_total = all_sum - visa_discount;
                var discount_divide = visa_discount / 3;
                $('#visa_adult_total_cost_price' + append_count).val((adult_cost_price - discount_divide)*get_no_of_adults) || 0;
                $('#visa_children_total_cost_price' + append_count).val((children_cost_price - discount_divide)*get_no_of_children) || 0;
                $('#visa_infant_total_cost_price' + append_count).val((infant_cost_price - discount_divide)*get_no_of_infant) || 0;

                $('#visa_sub_total' + append_count).val(visa_sub_total.toFixed(2));
                $('#visa_total' + append_count).val(visa_total.toFixed(2));
            } else {

                var adult_selling_price = parseInt($('#adult_visa_selling_price' + append_count).val()) || 0;
                var children_selling_price = parseInt($('#children_visa_selling_price' + append_count).val()) || 0;
                var infant_selling_price = parseInt($('#infant_visa_selling_price' + append_count).val()) || 0;

                var adult_cost_price = parseInt($('#adult_visa_cost_price' + append_count).val()) || 0;
                var children_cost_price = parseInt($('#children_visa_cost_price' + append_count).val()) || 0;
                var infant_cost_price = parseInt($('#infant_visa_cost_price' + append_count).val()) || 0;

                var visa_sub_total_selling_price = (adult_selling_price * get_no_of_adults) + (children_selling_price *
                    get_no_of_children) + (infant_selling_price * get_no_of_infant);
                var visa_sub_total_cost_price = (adult_cost_price * get_no_of_adults) + (children_cost_price *
                    get_no_of_children) + (infant_cost_price * get_no_of_infant);

                var visa_discount = parseFloat($('#visa_discount' + append_count).val()) || 0;
                var visa_total = visa_sub_total_selling_price - visa_discount;
                $('#visa_sub_total' + append_count).val(visa_sub_total_selling_price.toFixed(2));
                $('#visa_total' + append_count).val(visa_total.toFixed(2));
                $('#total_cost_price' + append_count).val(visa_sub_total_cost_price.toFixed(2));
                $('#total_selling_price' + append_count).val(visa_sub_total_selling_price.toFixed(2));
            }
            get_profit_calculation()
        }

        function transport_calculate() {
            // alert('Please enter');

            var no_of_persons = parseInt($('#transport_no_of_persons').val()) || 0;
            var transport_selling_price = parseFloat($('#transport_selling_price').val()) || 0;
            var transport_sub_total = no_of_persons * transport_selling_price;
            var transport_discount = parseFloat($('#transport_discount').val()) || 0;
            var transport_total = transport_sub_total - transport_discount;
            $('#transport_sub_total').val(transport_sub_total.toFixed(2));
            $('#transport_total').val(transport_total.toFixed(2));

        }

        function airline_calculate(airline_calculate_count) {
            // alert(airline_calculate_count);
            var get_no_of_adults = parseInt("{{ $get_inquiry->no_of_adults }}")
            var get_no_of_children = parseInt("{{ $get_inquiry->no_of_children }}")
            var get_no_of_infant = parseInt("{{ $get_inquiry->no_of_infants }}")
            var airline_service_type = $('#service_type').val();
            // alert(airline_service_type);
            if (airline_service_type == "no_of_person" || airline_service_type == "lum_sum") {
                var airline_adult_cost_price = $('#airline_adult_cost_price' + airline_calculate_count).val();
                var airline_children_cost_price = $('#airline_children_cost_price' + airline_calculate_count).val();
                var airline_infant_cost_price = $('#airline_infant_cost_price' + airline_calculate_count).val();
                var adult_cp = parseInt(airline_adult_cost_price) || 0
                var child_cp = parseInt(airline_children_cost_price) || 0
                var infant_cp = parseInt(airline_infant_cost_price) || 0
                var get_all_cost_price = (adult_cp * get_no_of_adults) + (child_cp * get_no_of_children) + (infant_cp *
                    get_no_of_infant);
                // alert(get_all_cost_price);
                var airline_discount = parseFloat($('#airline_discount' + airline_calculate_count).val()) || 0;
                var airline_total = get_all_cost_price - airline_discount;
                var discount_divide = airline_discount / 3;

                $('#airline_adult_total_cost_price' + airline_calculate_count).val((adult_cp * get_no_of_adults) -
                    discount_divide) || 0;
                $('#airline_children_total_cost_price' + airline_calculate_count).val((child_cp * get_no_of_children) -
                    discount_divide) || 0;
                $('#airline_infant_total_cost_price' + airline_calculate_count).val((infant_cp * get_no_of_infant) -
                    discount_divide) || 0;


                $('#airline_total_cost_price' + airline_calculate_count).val(get_all_cost_price.toFixed(2));
                $('#airline_total' + airline_calculate_count).val(airline_total.toFixed(2));
                $('#total_sum_legs' + airline_calculate_count).val(airline_total)
            } else {
                var adult_airline_selling_price = parseFloat($('#adult_airline_selling_price' + airline_calculate_count)
                    .val()) || 0;
                var children_airline_selling_price = parseFloat($('#children_airline_selling_price' +
                    airline_calculate_count).val()) || 0;
                var infant_airline_selling_price = parseFloat($('#infant_airline_selling_price' + airline_calculate_count)
                    .val()) || 0;

                var adult_airline_cost_price = parseFloat($('#adult_airline_cost_price' + airline_calculate_count)
                    .val()) || 0;
                var children_airline_cost_price = parseFloat($('#children_airline_cost_price' +
                    airline_calculate_count).val()) || 0;
                var infant_airline_cost_price = parseFloat($('#infant_airline_cost_price' + airline_calculate_count)
                    .val()) || 0;

                var airline_sub_total = (adult_airline_selling_price * get_no_of_adults) + (children_airline_selling_price *
                        get_no_of_children) +
                    (infant_airline_selling_price * get_no_of_infant);

                var airline_cost_total = (adult_airline_cost_price * get_no_of_adults) + (children_airline_cost_price *
                        get_no_of_children) +
                    (infant_airline_cost_price * get_no_of_infant);


                var airline_discount = parseFloat($('#airline_discount' + airline_calculate_count).val()) || 0;
                var airline_total = airline_sub_total - airline_discount;
                $('#airline_sub_total' + airline_calculate_count).val(airline_sub_total.toFixed(2));
                $('#airline_total_cost_price' + airline_calculate_count).val(airline_cost_total.toFixed(2));
                $('#airline_total' + airline_calculate_count).val(airline_total.toFixed(2));
                // $('#total_sum_legs' + airline_calculate_count).val(airline_total)
            }
            get_profit_calculation();
            // }
        }

        function land_services_calculate(land_services_calculate_count, append_count, service_type) {

            var service_type = $('#service_type').val();
            var get_no_of_adults = parseInt("{{ $get_inquiry->no_of_adults }}")
            var get_no_of_children = parseInt("{{ $get_inquiry->no_of_children }}")
            var get_no_of_infant = parseInt("{{ $get_inquiry->no_of_infants }}")
            if (service_type == 'service_level') {

                var land_services_discount = parseFloat($('#land_services_discount' + append_count).val()) ||
                    0;
                var land_services_cost_price = $('#land_services_cost_price' + append_count).val() ||
                    0;
                var land_services_selling_price = $('#land_services_selling_price' + append_count).val() ||
                    0;

                var land_services_selling_price_sum = 0;
                var land_services_cost_price_sum = 0;
                // alert(land_services_sub_total)
                $('.land_services_selling_price' + append_count).each(function(index, element) {
                    const value = parseInt($(element).val());
                    if (!isNaN(value)) {
                        land_services_selling_price_sum += value;
                    }
                });
                $('.land_services_cost_price' + append_count).each(function(index, element) {
                    const value = parseInt($(element).val());
                    if (!isNaN(value)) {
                        land_services_cost_price_sum += value;
                    }
                });
                // alert(land_services_selling_price_sum);
                var land_services_total = land_services_selling_price_sum - land_services_discount;

                $('#land_services_sub_total' + append_count).val(land_services_selling_price_sum);
                $('#land_services_total_cost_price' + append_count).val(land_services_cost_price_sum);
                $('#land_services_total' + append_count).val(land_services_total);

                // }
            } else {
                var adult_total_cost_price_sum = 0;
                var children_total_cost_price_sum = 0;
                var infant_total_cost_price_sum = 0;
                $('.adult_land_services_sum_cost_price' + append_count).each(function(index, element) {
                    var adult_cost_price_all = parseInt($(element).val()) || 0;
                    adult_total_cost_price_sum = adult_total_cost_price_sum + adult_cost_price_all;
                });
                $('.children_land_services_sum_cost_price' + append_count).each(function(index, element) {
                    var children_cost_price_all = parseInt($(element).val()) || 0;
                    children_total_cost_price_sum = children_total_cost_price_sum + children_cost_price_all;
                });
                $('.infant_land_services_sum_cost_price' + append_count).each(function(index, element) {
                    var infant_cost_price_all = parseInt($(element).val()) || 0;
                    infant_total_cost_price_sum = infant_total_cost_price_sum + infant_cost_price_all;
                });
                // alert(total_cost_price_sum);
                var total_cost_price_sum = (adult_total_cost_price_sum * get_no_of_adults) + (
                        children_total_cost_price_sum * get_no_of_children) +
                    (infant_total_cost_price_sum * get_no_of_infant);
                // // alert(sum)
                var land_services_discount = parseFloat($('#land_services_discount' + append_count).val()) ||
                    0;
                var discount_divide = land_services_discount / 3;
                if (land_services_calculate_count) {
                    var get_cp_adult = $('#adult_land_cost_price' + land_services_calculate_count).val();
                    var get_cp_children = $('#children_land_cost_price' + land_services_calculate_count).val();
                    var get_cp_infant = $('#infant_land_cost_price' + land_services_calculate_count).val();
                    $('#land_services_adult_total_cost_price' + land_services_calculate_count).val(
                        (get_cp_adult * get_no_of_adults) -
                        discount_divide) || 0;
                    $('#land_services_children_total_cost_price' + land_services_calculate_count).val(
                        (get_cp_children * get_no_of_children) -
                        discount_divide) || 0;
                    $('#land_services_infant_total_cost_price' + land_services_calculate_count).val(
                        (get_cp_infant * get_no_of_infant) -
                        discount_divide) || 0;
                } else {
                    var get_cp_adult = $('#adult_land_cost_price' + append_count).val();
                    var get_cp_children = $('#children_land_cost_price' + append_count).val();
                    var get_cp_infant = $('#infant_land_cost_price' + append_count).val();
                    $('#land_services_adult_total_cost_price' + append_count).val((get_cp_adult * get_no_of_adults) -
                        discount_divide) || 0;
                    $('#land_services_children_total_cost_price' + append_count).val((get_cp_children *
                            get_no_of_children) -
                        discount_divide) || 0;
                    $('#land_services_infant_total_cost_price' + append_count).val((get_cp_infant * get_no_of_infant) -
                        discount_divide) || 0;
                }
                var land_services_total = total_cost_price_sum - land_services_discount;
                $('#land_services_total_cost_price' + append_count).val(total_cost_price_sum.toFixed(2));
                $('#land_services_total' + append_count).val(land_services_total.toFixed(2));

                // // }
                get_profit_calculation();

            }
        }


        // Function Of Hotel Curr Exchange

        function onchange_get_curr_data(append_count) {

            var default_rate = $("#default_rate_of_exchange").val();
            var rate = $("#hotel_currency" + append_count).val();
            var name = $('#hotel_currency' + append_count).find(":selected").html();
            var hotel_total = $("#hotel_total" + append_count).val();
            var currency_name = $("#hotel_currency" + append_count).html();
            // var default_rate = hotel_total / default_rate;
            var conversion_rate = hotel_total * default_rate / rate;
            var final_conversion_rate = parseFloat(conversion_rate).toFixed(2);
            $('#hotel_exchange_head' + append_count).html("Exchange=" + final_conversion_rate + '/-');
            $("#hotel_currency_total" + append_count).val(final_conversion_rate);
            $("#hotel_currency_name" + append_count).val(name);
        }
        // Function Of Hotel Curr Exchange

        function onchange_get_curr_data_visa(append_count) {
            var default_rate = $("#default_rate_of_exchange").val();
            var rate = $("#visa_currency" + append_count).val();
            var name = $('#visa_currency' + append_count).find(":selected").html();
            //   console.log(name)
            var visa_total = $("#visa_total" + append_count).val();
            var currency_name = $("#visa_currency" + append_count).html();
            var conversion_rate = visa_total * default_rate / rate;
            var final_conversion_rate = parseFloat(conversion_rate).toFixed(2);
            $('#visa_exchange_head' + append_count).html("Exchange=" + final_conversion_rate + '/-');
            $("#visa_currency_total" + append_count).val(final_conversion_rate);
            $("#visa_currency_name" + append_count).val(name);
        }

        function onchange_get_curr_data_land_services(append_count) {
            var default_rate = $("#default_rate_of_exchange").val();
            var rate = $("#land_services_currency" + append_count).val();
            // alert(rate);
            var name = $('#land_services_currency' + append_count).find(":selected").html();
            //   console.log(name)
            var land_total = $("#land_services_total" + append_count).val();
            var currency_name = $("#transport_currency").html();
            var conversion_rate = land_total * default_rate / rate;
            var final_conversion_rate = parseFloat(conversion_rate).toFixed(2);
            $('#land_services_exchange_head' + append_count).html("Exchange=" + final_conversion_rate + '/-');
            $("#land_services_currency_total" + append_count).val(final_conversion_rate);
            $("#land_services_currency_name" + append_count).val(name);
        }

        function onchange_get_curr_data_airline(airline_curr_count) {

            // alert(airline_curr_count);
            var default_rate = $("#default_rate_of_exchange").val();
            var rate = parseInt($("#airline_currency" + airline_curr_count).val());
            var name = $('#airline_currency' + airline_curr_count).find(":selected").html();
            //   console.log(name)
            var airline_total = $("#airline_total" + airline_curr_count).val();
            var currency_name = $("#airline_currency" + airline_curr_count).html();
            var conversion_rate = airline_total * default_rate / rate;
            var final_conversion_rate = parseFloat(conversion_rate).toFixed(2);
            // alert(airline_total)
            // alert(rate)
            $('#airline_exchange_head' + airline_curr_count).html("Exchange=" + final_conversion_rate + '/-');
            $("#airline_currency_total" + airline_curr_count).val(final_conversion_rate);
            $("#airline_currency_name" + airline_curr_count).val(name);

        }

        function remove_hotel(append_count) {
            // const hotel_id_array = [];
            $('.hotel_inv_id').each(function(index, element) {
                $(element).remove();
            });
            $("#hotel_table" + append_count).remove();
        }

        function remove_hotel_legs(append_count) {
            // $("#hotel_table" + append_count).remove();
            $('.hotel_inv_id').each(function(index, element) {
                var vv = $(element).data();
                if (append_count == vv) {
                    $(element).remove()
                    $("#remove_hotel_legs" + append_count).remove();

                }
            });
            $("#remove_hotel_legs" + append_count).remove();
        }

        function remove_visa(append_count) {
            $("#visa_table" + append_count).remove();
        }

        function remove_airline(count) {
            $(".airline_table" + count).remove();

        }

        function remove_transport(count) {

            $("#transport_table").remove();

        }

        function hotel_inv() {
            Swal.fire({
                title: "You Want To Access Our Inventory's Data",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {

                    $('#modaldemo2').modal('show');

                } else if (result.isDenied) {
                    var services_id = $('#services_id').val();
                    var get_inquiry_id = $('#inquiry_id').val();
                }
            });
        }

        var legs_count = 500;

        function add_airline_destination_btn(append_count) {
            var arrival_des = $('#airline_arrival_destination').val();
            var depart_des = $('#airline_departure_destination').val();
            $.ajax({
                type: "GET",
                url: "{{ url('add_airline_destination') }}/" + append_count + '/' + legs_count,
                success: function(response) {
                    $("#add_more_airline_row" + append_count).prepend(response);
                    $("#rmv_btn").html('Remove Row');
                    $('.js-example-basic-multiple' + legs_count).select2()
                    $('.select2' + legs_count).select2({});
                    $('.fc-datepicker' + legs_count).datepicker({
                        showOtherMonths: true,
                        selectOtherMonths: true,
                        dateFormat: 'd/M/y',
                    });
                    $(".time_pick").clockpicker({
                        autoclose: true,
                        default: 'now',
                        donetext: "Select",
                    });
                    $('#airline_arrival_destination' + legs_count).select2({
                        placeholder: 'Select',
                        ajax: {
                            url: "{{ route('autocomplete_country') }}",
                            dataType: 'json',
                            delay: 250,
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(
                                        item) {
                                        return {
                                            text: item
                                                .country_name +
                                                ' - ' + item
                                                .name,
                                            id: item
                                                .country_name +
                                                ' - ' + item
                                                .name,
                                        }
                                    })
                                };
                            },
                            cache: true
                        }

                    });
                    $('#airline_departure_destination' + legs_count).select2({
                        placeholder: 'Select',
                        ajax: {
                            url: "{{ route('autocomplete_country') }}",
                            dataType: 'json',
                            delay: 250,
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(
                                        item) {
                                        return {
                                            text: item
                                                .country_name +
                                                ' - ' + item
                                                .name,
                                            id: item
                                                .country_name +
                                                ' - ' + item
                                                .name,
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                    });

                    $('#airline_livesearch' + legs_count).select2({
                        placeholder: 'Select',
                        ajax: {
                            url: "{{ route('autocomplete_country') }}",
                            dataType: 'json',
                            delay: 250,
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(
                                        item) {
                                        return {
                                            text: item
                                                .country_name +
                                                ' - ' + item
                                                .name,
                                            id: item
                                                .country_name +
                                                ' - ' + item
                                                .name,
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                    });
                    legs_count = legs_count + 1
                }
            });
        }
        var addon_count = 0;

        function add_hotel_legs(append_count, sub_services_hotel_legs) {
            var service_type = $('#service_type').val();

            $.ajax({
                type: "GET",
                url: "{{ url('add_hotel_legs') }}/" + append_count + '/' + legs_count + '/' +
                    sub_services_hotel_legs + '/' + addon_count + '/' + service_type,
                success: function(response) {
                    $("#append_hotel_legs" + append_count).append(response);
                    $("#rmv_btn").html('Remove Row');
                    $('.js-example-basic-multiple' + legs_count).select2()
                    $('.select2' + legs_count).select2({});
                    $('.fc-datepicker' + legs_count).datepicker({
                        showOtherMonths: true,
                        selectOtherMonths: true,
                        dateFormat: 'd/M/y',

                    });
                    $('.livesearch_hotel_city').select2({
                        placeholder: 'Select',
                        ajax: {
                            url: "{{ route('autocomplete_country') }}",
                            dataType: 'json',
                            delay: 250,
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(
                                        item) {
                                        return {
                                            text: item
                                                .name,
                                            id: item
                                                .name,
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                    });
                    $('#hotel_addon' + legs_count).val(null).trigger("change")
                    legs_count = legs_count + 1
                    addon_count = addon_count + 1

                }
            });
        }

        function add_land_services_legs(append_count, sub_services_hotel_legs) {
            $.ajax({
                type: "GET",
                url: "{{ url('add_land_services_legs') }}/" + append_count + '/' + legs_count + '/' +
                    sub_services_hotel_legs + '/' + addon_count,
                success: function(response) {
                    $("#append_land_services_legs" + append_count).append(response.data);
                    $("#rmv_btn").html('Remove Row');
                    $('.js-example-basic-multiple' + legs_count).select2()
                    $('.select2' + legs_count).select2({});
                    $('.fc-datepicker' + legs_count).datepicker({
                        showOtherMonths: true,
                        selectOtherMonths: true
                    });
                    legs_count = legs_count + 1
                    addon_count = addon_count + 1

                }
            });
        }

        function add_airline_inventory(inv_id) {
            $.ajax({
                type: "GET",
                url: "{{ url('add_airline_inventory') }}/" + inv_id,
                success: function(response) {
                    var airline_count_inv = $('#airline_inv_count').val();
                    if (airline_count) {
                        $('#airline_flight_class' + airline_count_inv).html(response.flight_class);
                    } else {
                        $('#airline_flight_class').html(response.flight_class);
                    }
                    $('#modaldemo3').modal('hide');
                    $('#airline_inventory_id' + airline_count_inv).val(inv_id);
                    // alert(inv_id)

                }
            });
        }

        function add_airline_rates(append_count, airline_rate_id) {
            $.ajax({
                type: "GET",
                url: "{{ url('add_airline_rates') }}/" + airline_rate_id,
                success: function(response) {
                    var service_type = $('#service_type').val();
                    if ($('#adult_put_rates').is(":checked")) {
                        $('#adult_airline_cost_price' + append_count).val(response.selling_price)
                    }
                    if ($('#children_put_rates').is(":checked")) {
                        $('#children_airline_cost_price' + append_count).val(response.selling_price)
                    }
                    if ($('#infant_put_rates').is(":checked")) {
                        $('#infant_airline_cost_price' + append_count).val(response.selling_price)
                    }

                    $('#modaldemo6').modal('hide')
                    airline_calculate(append_count);
                    // if (service_type == 'service_level') {
                    //     // $('#airline_selling_price' + append_count).val()
                    // } else {
                    //     var get_selling_price = response
                    //         .selling_price / $('#airline_no_of_adults' + append_count).val();
                    //     var get_cost_price = response
                    //         .cost_price / $('#airline_no_of_adults' + append_count).val();
                    //     $('#airline_adult_cost_price' + append_count).val(get_cost_price)
                    //     $('#airline_adult_selling_price' + append_count).val(get_selling_price)
                    //     $('#modaldemo6').modal('hide')
                    //     $('#airline_adult_selling_price' + append_count).trigger("change");

                    // }

                    // var airline_count_inv = $('#airline_inv_count').val();
                    // if (airline_count) {
                    //     $('#airline_flight_class' + airline_count_inv).html(response.flight_class);
                    // } else {
                    //     $('#airline_flight_class').html(response.flight_class);
                    // }
                    // $('#modaldemo3').modal('hide');
                    // $('#airline_inventory_id' + airline_count_inv).val(inv_id);
                    // alert(inv_id)

                }
            });
        }

        function add_hotel_rates(append_count, hotel_rate_id) {
            $.ajax({
                type: "GET",
                url: "{{ url('add_hotel_rates') }}/" + hotel_rate_id,
                success: function(response) {
                    var service_type = $('#service_type').val();
                    if ($('#adult_put_rates_hotel').is(":checked")) {
                        $('#hotel_adult_cost_price' + append_count).val(response.cost_price)
                    }
                    if ($('#children_put_rates_hotel').is(":checked")) {
                        $('#hotel_children_cost_price' + append_count).val(response.cost_price)
                    }
                    if ($('#infant_put_rates_hotel').is(":checked")) {
                        $('#hotel_infant_cost_price' + append_count).val(response.cost_price)
                    }

                    if (service_type == 'service_level') {
                        $('#hotel_beds' + append_count).val(response.no_of_beds)
                        $('#hotel_cost_price' + append_count).val(response.cost_price)
                        $('#modaldemo6').modal('hide')
                        hotel_calcualte(append_count);

                    } else {
                        // alert('sdds');
                        // var get_selling_price = response
                        //     .selling_price / $('#hotel_no_of_adult' + append_count).val();
                        // var get_cost_price = response
                        //     .cost_price / $('#hotel_no_of_adult' + append_count).val();
                        // $('#hotel_adult_cost_price' + append_count).val(get_cost_price)
                        // $('#hotel_beds' + append_count).val(response.no_of_beds)
                        // $('#hotel_adult_selling_price' + append_count).val(get_selling_price)
                        // $('#hotel_adult_selling_price' + append_count).trigger("change");
                        if ($('#adult_put_rates_hotel').is(":checked")) {
                            $('#hotel_adult_cost_price' + append_count).val(response.cost_price)
                        }
                        if ($('#children_put_rates_hotel').is(":checked")) {
                            $('#hotel_children_cost_price' + append_count).val(response.cost_price)
                        }
                        if ($('#infant_put_rates_hotel').is(":checked")) {
                            $('#hotel_infant_cost_price' + append_count).val(response.cost_price)
                        }
                        $('#modaldemo6').modal('hide')

                    }

                    // var airline_count_inv = $('#airline_inv_count').val();
                    // if (airline_count) {
                    //     $('#airline_flight_class' + airline_count_inv).html(response.flight_class);
                    // } else {
                    //     $('#airline_flight_class').html(response.flight_class);
                    // }
                    // $('#modaldemo3').modal('hide');
                    // $('#airline_inventory_id' + airline_count_inv).val(inv_id);
                    // alert(inv_id)

                }
            });
        }

        function on_change_on_flight_class(airline_flight_count) {
            // if (airline_flight_count) {
            var get_airline_flight_class = $('#airline_flight_class' + airline_flight_count).val();
            // } else {
            //     var get_airline_flight_class = $('#airline_flight_class').val();
            // }
            var airline_inventory_id = $('#airline_inventory_id' + airline_flight_count).val();
            // alert(airline_inventory_id);
            $.ajax({
                type: "GET",
                url: "{{ url('get_airline_flight_class') }}/" +
                    airline_inventory_id + '/' + get_airline_flight_class,
                success: function(response) {
                    $('#airline_no_of_persons' + airline_flight_count).val(response.qty);

                    $('#airline_children_cost_price' + airline_flight_count).val(response.cost_price);
                    $('#airline_adult_cost_price' + airline_flight_count).val(response.cost_price);
                    $('#airline_infants_cost_price' + airline_flight_count).val(response.cost_price);

                    $('#airline_adult_selling_price' + airline_flight_count).val(response.selling_price);
                    $('#airline_children_selling_price' + airline_flight_count).val(response.selling_price);
                    $('#airline_infants_selling_price' + airline_flight_count).val(response.selling_price);
                    $('#airline_selling_price' + airline_flight_count).val(response.selling_price);
                    var sum = $('#airline_total' + airline_flight_count).val();
                    airline_calculate(airline_flight_count)
                }
            });
        }
        // BILAL Work =====================================================

        // New Works
        function modal_parsing_airline(append_count) {
            // parsing

            $('#modaldemo5').modal('show');
            $('#parsing_details').val("");
            $('#append_count_modal_parse').val(append_count);

        }
        var line_counts_for_parsing = 0;
        $(document).ready(function() {
            $('#btn_parse').on('click', function(e) {
                var get_append_count_modal = $('#append_count_modal_parse').val();
                var lines = $('#parsing_details').val().split('\n');
                var parse_data = new Array();
                // for (var j = 0; j < lines.length; j++) {
                // //    var cleanedString=lines.replace(/\s+/g, ' ')
                //     parse_data[j] = lines[j];
                // }
                for (var j = 0; j < lines.length; j++) {
                    // Get the current string from the parse_data array
                    var currentString = lines[j];

                    // Clean up the string by replacing consecutive whitespace with a single space
                    var cleanedString = currentString.replace(/\s+/g, ' ');

                    // Update the parse_data array with the cleaned string
                    parse_data[j] = cleanedString;
                }
                console.log(parse_data);
                $.ajax({
                    type: "GET",
                    url: "{{ url('/parsing_details') }}/" + get_append_count_modal,
                    data: {
                        "data": parse_data
                    },
                    success: function(response) {
                        $('#modaldemo5').modal('hide');
                        $('#remove_for_parsing' + get_append_count_modal).empty();
                        $('#remove_for_parsing' + get_append_count_modal).empty();
                        $('#append_airline_destination' + get_append_count_modal).html(response
                            .parsing_legs);
                        $('.select2' + get_append_count_modal).select2({});
                        $('.fc-datepicker' + get_append_count_modal).datepicker({
                            showOtherMonths: true,
                            selectOtherMonths: true,
                            dateFormat: 'd/M/y',
                        });
                        $('#add_parsing').prop('disabled', true);
                        $('.livesearch_for_airline_destination' + get_append_count_modal)
                            .select2({
                                placeholder: 'Select',
                                ajax: {
                                    url: "{{ route('autocomplete_country') }}",
                                    dataType: 'json',
                                    delay: 250,
                                    processResults: function(data) {
                                        return {
                                            results: $.map(data, function(
                                                item) {
                                                return {
                                                    text: item
                                                        .country_name +
                                                        ' - ' + item
                                                        .name,
                                                    id: item
                                                        .country_name +
                                                        ' - ' + item
                                                        .name,
                                                }
                                            })
                                        };
                                    },
                                    cache: true
                                }

                            });
                        // $('.add_more_clk').css('display', 'none');
                    }
                });
            });
        });

        function modal_inventory_airline(append_count, vlu) {
            // From _inventory
            // Swal.fire({
            //     title: 'Do you want to get data from inventory?',
            //     showDenyButton: true,
            //     confirmButtonText: 'Yes',
            //     denyButtonText: `No`,
            // }).then((result) => {
            //     /* Read more about isConfirmed, isDenied below */
            //     if (result.isConfirmed) {
            //         var airline_id = vlu.value;
            //         // var airline_id = $('#airline_name' + append_count).val();
            //         // alert(airline_id);
            //         var inq_id = "{{ $dec_inq_id }}";
            //         $.ajax({
            //             type: "GET",
            //             url: "{{ url('get_inventory_details_airline') }}/" + airline_id + '/' +
            //                 append_count +
            //                 '/' + inq_id,
            //             success: function(response) {
            //                 if (response.airline_inventory_table == "") {
            //                     $('#append_airline_inv').html(
            //                         '<span style="display: flex;justify-content: center;align-items: center;">No Records Found</span>'
            //                     );
            //                     $('#modaldemo3').modal('show');
            //                 } else {
            //                     $('#append_airline_inv').html(response.airline_inventory_table);
            //                     $('#airline_name_modal').html("Select Inventory From " + response
            //                         .airline_name);
            //                     $('#modaldemo3').modal('show');
            //                     $('#airline_inv_count' + airline_inv_count).val(airline_inv_count);
            //                 }

            //             }
            //         });
            //     } else if (result.isDenied) {
            //         $('#modaldemo3').modal('hide');
            //     }
            // })

        }

        function modal_inventory_hotel(append_count, vlu) {
            // From _inventory
            // Swal.fire({
            //     title: 'Do you want to get data from inventory?',
            //     showDenyButton: true,
            //     confirmButtonText: 'Yes',
            //     denyButtonText: `No`,
            // }).then((result) => {
            //     /* Read more about isConfirmed, isDenied below */
            //     if (result.isConfirmed) {
            //         var hotel_id = vlu.value;
            //         // var airline_id = $('#airline_name' + append_count).val();
            //         // alert(airline_id);
            //         var inq_id = "{{ $dec_inq_id }}";
            //         $.ajax({
            //             type: "GET",
            //             url: "{{ url('get_inventory_details_hotel') }}/" + hotel_id + '/' + append_count +
            //                 '/' + inq_id,
            //             success: function(response) {
            //                 if (response.airline_inventory_table == "") {
            //                     $('#append_hotel_modal_table').html(
            //                         '<span style="display: flex;justify-content: center;align-items: center;">No Records Found</span>'
            //                     );
            //                     $('#modaldemo2').modal('show');
            //                 } else {
            //                     $('#append_hotel_modal_table').html(response.airline_inventory_table);
            //                     $('#modaldemo2').modal('show');
            //                     $('#airline_inv_count').val(airline_inv_count);
            //                 }

            //             }
            //         });
            //     } else if (result.isDenied) {
            var hotel_id = vlu.value;
            var inq_id = "{{ $dec_inq_id }}";
            $.ajax({
                type: "GET",
                url: "{{ url('get_hotel_available_rooms') }}/" + hotel_id + '/' + append_count +
                    '/' + inq_id,
                success: function(response) {
                    $('#modaldemo2').modal('hide');
                    $('#append_hotel_modal_table').html(response.airline_inventory_table);
                    $('#hotel_room_type' + append_count).html(response.room_type);
                    $('#airline_inv_count').val(airline_inv_count);
                }
            });
            // }
            // })

        }

        function modal_manual_airline() {
            // manual
            var services_id = $('#services_id').val();
            var get_inquiry_id = $('#inquiry_id').val();
            $('#airline_name').focus();
        }


        // Add From Inventory
        function add_airlrine_inventory(append_count, inv_id) {
            $.ajax({
                type: "GET",
                url: "{{ url('add_airline_inv_details') }}/" + inv_id + '/' + append_count,
                success: function(response) {
                    $('#modaldemo3').modal('hide');
                    $('#airline_name' + append_count).val(response.airline_id);
                    $('#flight_number' + append_count).val(response.flight_no);
                    $('#airline_arrival_date' + append_count).val(response.arrival_date);
                    $('#airline_arrival_destination' + append_count).html(response.departure_destination);
                    $('#airline_departure_destination' + append_count).html(response.departure_destination);
                    $('#arival_time' + append_count).val(response.arrival_time);
                    $('#departure_time' + append_count).val(response.departure_time);
                    $('#airline_inv_id' + append_count).val(inv_id)
                }
            });
        }

        function add_hotel_inventory(append_count, inv_id) {

            $.ajax({
                type: "GET",
                url: "{{ url('add_hotel_inv_details') }}/" + inv_id + '/' + append_count,
                success: function(response) {
                    $('#modaldemo2').modal('hide');
                    $('#hotels' + append_count).val(response.hotel_id);
                    $('#hotel_room_type' + append_count).html(response.room_type);
                    $('#hotel_check_in' + append_count).val(response.check_in);
                    $('#hotel_check_out' + append_count).val(response.check_out);
                    // $('#hotel_inv_ids').append(response.append_inv_input);
                    // alert(append_count);
                    // alert(inv_id);
                    $('#hotel_inv_id' + append_count).val(inv_id);
                    // alert($('#hotel_inv_id' + append_count).val())
                    // $('#airline_departure_destination' + append_count).html(response.departure_destination);
                    // $('#arival_time' + append_count).val(response.arrival_time);
                    // $('#departure_time' + append_count).val(response.departure_time);
                }
            });
        }



        // Add a common class to the addon select elements for easy selection
        var addonSelects = document.querySelectorAll(".addon-select");

        function calculate_addon(index) {
            // Calculate the sum of addon prices
            var addonSum = 0;

            addonSelects.forEach(function(select) {
                addonSum += parseFloat(select.value);
            });

            // Get other values from the form
            var costPrice = parseFloat(document.getElementById("hotel_cost_price" + index).value);
            var sellingPrice = parseFloat(document.getElementById("hotel_selling_price" + index).value);
            var qty = parseFloat(document.getElementById("hotel_qty" + index).value);
            var beds = parseFloat(document.getElementById("hotel_beds" + index).value);

            // Calculate the subtotal
            var subTotal = (costPrice + addonSum) * qty * beds;

            // Update the "Sub Total" input field
            document.getElementById("hotel_sub_total" + index).value = subTotal;

            // Calculate and update the total and other fields if needed
            // ... (rest of the existing code for total calculation)
        }



        // Land Services Work
        function get_land_services_route(append_count) {
            var val = $("#land_service" + append_count).val();
            $.ajax({
                type: "GET",
                url: "{{ url('get_land_service_routes') }}/" + val,
                success: function(response) {
                    $("#land_services_route" + append_count).html(response.land_services);
                    $("#transport" + append_count).html(response.get_transport_options);
                }
            });

        }
        var land_sl_count_new = 6000;

        function get_route_details(land_sl_count, append_count, add_more) {
            // if (legs_count == 0) {
            //     var val = $("#land_services_route" + append_count).val();
            //     var l_id = $("#land_service" + append_count).val();
            //     var service_type_id = $("#service_type_id" + append_count).val();
            //     // alert(service_type);
            //     $.ajax({
            //         type: "GET",
            //         url: "{{ url('get_route_details') }}/" + l_id + '/' + val + '/' + service_type_id,
            //         success: function(response) {
            //             if (response.service_type == 'no_of_person') {
            //                 $("#land_services_no_of_adult" + append_count).val(1);
            //                 $("#land_services_no_of_children" + append_count).val(1);
            //                 $("#land_services_no_of_infant" + append_count).val(1);
            //                 $("#land_services_adult_cost_price" + append_count).val(response.adult_cost_price);
            //                 $("#land_services_children_cost_price" + append_count).val(response
            //                     .children_cost_price);
            //                 $("#land_services_infant_cost_price" + append_count).val(response
            //                     .infant_cost_price);
            //                 $("#land_services_adult_selling_price" + append_count).val(response
            //                     .adult_selling_price);
            //                 $("#land_services_children_selling_price" + append_count).val(response
            //                     .children_selling_price);
            //                 $("#land_services_infant_selling_price" + append_count).val(response
            //                     .infant_selling_price);
            //                 land_services_calculate(legs_count, append_count, 0)
            //             } else {
            //                 $("#land_services_no_of_adult" + append_count).val(1);
            //                 $("#land_services_no_of_children" + append_count).val(1);
            //                 $("#land_services_no_of_infant" + append_count).val(1);
            //                 $("#land_services_cost_price" + append_count).val(response.service_cost_price);
            //                 $("#land_services_selling_price" + append_count).val(response
            //                     .service_selling_price);
            //                 land_services_calculate(legs_count, append_count, 1)
            //             }

            //         }
            //     });
            // } else {
            //     var val = $("#land_services_route" + legs_count).val();
            //     var l_id = $("#land_service" + legs_count).val();
            //     $.ajax({
            //         type: "GET",
            //         url: "{{ url('get_route_details') }}/" + l_id + '/' + val,
            //         success: function(response) {
            //             $("#land_services_no_of_adult" + legs_count).val(response.no_of_adults);
            //             $("#land_services_no_of_children" + legs_count).val(response.no_of_children);
            //             $("#land_services_no_of_infant" + legs_count).val(response.no_of_infants);
            //             $("#land_services_adult_cost_price" + legs_count).val(response.adult_cost_price);
            //             $("#land_services_children_cost_price" + legs_count).val(response.children_cost_price);
            //             $("#land_services_infant_cost_price" + legs_count).val(response.infant_cost_price);
            //             $("#land_services_adult_selling_price" + legs_count).val(response.adult_selling_price);
            //             $("#land_services_children_selling_price" + legs_count).val(response
            //                 .children_selling_price);
            //             $("#land_services_infant_selling_price" + legs_count).val(response
            //                 .infant_selling_price);
            //             // land_services_calculate(legs_count, append_count)
            //         }
            //     });
            // alert(add_more);
            // }
            // alert(append_count);
            // alert(land_sl_count);
            if (add_more == 0) {
                var addmore = 0;
            } else {
                var addmore = 1;
            }

            var get_route = $('#land_services_route' + append_count).val() || null;
            var get_transport = $('#transport' + append_count).val() || null;
            var land_service = $('#land_service' + append_count).val() || null;
            var service_type_id = $('#service_type').val() || null;
            var inq_id = "{{ $dec_inq_id }}";
            // alert(service_type_id);
            $.ajax({
                type: "GET",
                url: "{{ url('add_land_services_routes_legs') }}/" + get_route + '/' + get_transport + '/' +
                    land_service + '/' + append_count + '/' + land_sl_count_new + '?service_type_id=' +
                    service_type_id + '&addmore=' + addmore + '&inq_id=' + inq_id,
                success: function(response) {
                    if (addmore == 1) {
                        // alert('sdsddd')
                        $('#append_land_services_legs' + append_count).html(response.get_legs)
                    } else {
                        // alert('sdsd')
                        $('#append_land_services_legs' + append_count).append(response.get_legs)
                    }
                    $('.select2' + land_sl_count_new).select2({});
                    $('.fc-datepicker' + land_sl_count_new).datepicker({
                        showOtherMonths: true,
                        selectOtherMonths: true,
                        dateFormat: 'd/M/y',
                    });
                    $('#fc-datepicker' + land_sl_count_new).datepicker({
                        showOtherMonths: true,
                        selectOtherMonths: true,
                        dateFormat: 'd/M/y',
                    });
                    land_sl_count_new = land_sl_count_new + 1

                    // land_sl_count_new = parseInt(response.land_sl_count) + 1
                }
            });
        }

        function remove_land_services(append_count) {
            $('#land_services_table' + append_count).remove();
        }

        function add_land_services_legs(append_count) {

        }

        function remove_land_legs(legs_count) {
            $('.remove_land_legs' + legs_count).remove();
        }

        function reset_all() {
            $('#append_table').html("");
            append_quotation_count = 0;
            count_for_profit = -1;
            $('#service_type').prop("disabled", false);
            $('#default_rate_of_exchange').prop("disabled", false);
        }


        function remove_land_services_legs(rmv_land_count) {
            $('.rmv_land' + rmv_land_count).remove();
        }

        function onchange_ticket_type_airline(append_count) {
            // From _inventory
            // var airline_id = $('#airline_name' + append_count).val();
            // alert(airline_id)
            var flight_class = $('#airline_flight_class' + append_count).val();

            Swal.fire({
                title: 'Do you want to get Airline Rates?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('get_airline_rates') }}/" +
                            append_count,
                        success: function(response) {
                            $('#append_airline_rates_modal').html(response.airline_inventory_table);
                            $('#airline_name_modal').html("Select Inventory From" + response
                                .airline_name);
                            $('#modaldemo6').modal('show');
                            $(function() {
                                oTable = $('#example2').DataTable({
                                    responsive: !0
                                });
                            });
                            $('#airline_inv_count' + airline_inv_count).val(airline_inv_count);
                        }
                    });
                } else if (result.isDenied) {
                    $('#modaldemo3').modal('hide');
                }
            })



        }

        function hotel_date_night(append_count) {
            hotel_calculate(append_count, legs_count)

        }

        function get_hotel_city_category(append_count) {

            var get_cat = $('#hotel_category' + append_count).val();
            var get_city = $('#hotel_city' + append_count).val();
            $.ajax({
                type: "get",
                url: "{{ url('get_hotel_city_category') }}/" + get_city + '/' + get_cat,
                success: function(response) {
                    $('#hotels' + append_count).empty().append(response.hotel_options);
                }
            });

        }
    </script>
@endpush
