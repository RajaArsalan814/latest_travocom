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

        table.nospacing {
            border-spacing: 0;
        }

        table.nospacing th,
        td {
            padding: 0;
        }
    </style>
    <div class="az-content-breadcrumb">
        <span>Inquiry</span>
        {{-- <span>Add Airline</span> --}}
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline;text-decoration: none;color:gray; font-size:28px;">
        INQUIRY#{{ $dec_inq_id }}
        |
        <a href="{{ url('customers') }}" style="text-decoration: none;color:gray; font-size:28px;">
            {{ $get_customer->customer_name }}</a>
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
                        // dd($get_inquiry);
                        $get_sales_reference = App\sales_reference::where('type_id', $get_inquiry->sales_reference)->first();
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
                                <li><a href="#"
                                        style="text-decoration: none;color:grey;text-decoration: underline;">{{ $get_customer->customer_name }}</a>
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
                                {{-- {{dd($get_sales_reference)}} --}}
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
                                    // dd($service_name);
                                }

                            @endphp
                            @php
                                $decode_sub_services = json_decode($get_inquiry->services_sub_services);
                                foreach ($decode_sub_services as $key_main => $value) {
                                    $explode = explode('/', $value);
                                    $explode_sub = explode(',', $explode[1]);
                                    $get_m_service = $service_name[$key_main];
                                    $get_s_name = App\other_service::where('id_other_services', $explode[0])
                                        ->select('service_name')
                                        ->first();
                                    // dd($explode[0]);
                                    // dd($explode_sub);
                                    // dd($decode_sub_services);
                                    $final_array[] = [
                                        'service' => $get_s_name->service_name,
                                        'sub_service' => $explode_sub,
                                    ];
                                }
                                // dd($final_array);
                            @endphp
                            <h6 class="fs-5">Services :</h6>
                            @foreach ($final_array as $key_p => $final_val)
                                <li class="mt-2">
                                    {{-- {{dd($final_val)}} --}}
                                    <span class="fs-5">{{ $final_val['service'] }}</span> :<br>

                                    @foreach ($final_val['sub_service'] as $key => $sub_name)
                                        @php
                                            $get_sub_name = App\other_service::where('id_other_services', $sub_name)
                                                ->select('service_name')
                                                ->first();
                                        @endphp

                                        <span class="badge badge-round badge-success"
                                            style="font-size:16px;">{{ $get_sub_name->service_name }}</span>
                                    @endforeach
                                </li>
                            @endforeach


                        </div>
                        <div class="col-md-3" style="border-left:1px solid lightgray;">
                            <h6 class="fs-5">Quotation Approval Status :</h6>
                            @if (isset($get_quotation_status->remarks_status) && $get_quotation_status->remarks_status == 'Quotation Approved')
                                <button class="btn btn-rounded btn-success  mb-3" style="color:#fff;" disabled>
                                    <span style="color:white">{{ $get_quotation_status?->remarks_status }}</span>
                                </button>
                            @elseif(isset($get_quotation_status->remarks_status))
                                <button class="btn btn-rounded btn-danger  mb-3" style="color:#fff;" disabled>
                                    <span style="color:white">{{ $get_quotation_status?->remarks_status }}</span>
                                </button>
                            @elseif($get_reject_status?->remarks_status == 'Quotation Rejected')
                                <button class="btn btn-rounded btn-danger  mb-3" style="color:#fff;" disabled>
                                    <span style="color:white">{{ $get_reject_status?->remarks_status }}</span>
                                </button>
                                <h6><b>Reason:</b> {{ $get_reject_status?->cancel_reason }}</h6>
                            @endif
                            @if (!isset($get_quotation_status->remarks_status) && !isset($get_reject_status))
                                <button class="btn btn-rounded btn-danger  mb-3" style="color:#fff;" disabled>
                                    <span style="color:white">N/A</span>
                                </button>
                            @endif
                        </div>
                        <div class="col-md-3" style="border-left:1px solid lightgray;">
                            <h6 class="fs-5">Quotation Issuance Status :</h6>

                            @if (isset($get_issuance_status->status))
                                <button class="btn btn-rounded btn-success  mb-3" style="color:#fff;" disabled>
                                    <span style="color:white">{{ $get_issuance_status?->status }}</span>
                                </button>
                            @else
                                <button class="btn btn-rounded btn-danger  mb-3" style="color:#fff;" disabled>
                                    <span style="color:white">N/A</span>
                                </button>
                            @endif


                        </div>
                        <div class="col-md-3" style="border-left:1px solid lightgray;" style="position:relative;">
                            <div style="height:100px;overflow:auto;z-index:2;">
                                <h6 class="fs-5">Payment / Accounts Status :</h6>
                                @if (isset($payment_invoice_list))
                                    <table class="table table-striped nospacing">
                                        <thead>
                                            <tr>
                                                <th>S.NO</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        @foreach ($payment_invoice_list as $key23 => $payment_status_top)
                                            <tbody>
                                                <tr>
                                                    <td>{{ $key23 + 1 }}</td>
                                                    <td>{{ $payment_status_top->payment_type }}</td>
                                                    <td>
                                                        @if ($payment_status_top->status == 0)
                                                            <span class="badge badge-warning">Pending</span>
                                                        @elseif($payment_status_top->status == 1)
                                                            <span class="badge badge-info">PAYMENT NOT VERIFIED</span>
                                                        @elseif($payment_status_top->status == 2)
                                                            <span class="badge badge-success">PAYMENT VERIFIED</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @endforeach
                                    </table>
                                @else
                                    <button class="btn btn-rounded btn-danger  mb-3" style="color:#fff;" disabled>
                                        <span style="color:white">N/A</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12 mt-2"><span class="text-success"><span
                                    style="font-weight:bold;color:#000;">INQUIRY INITIAL REMARKS: <span
                                        style="color:green;">{{ strtoupper($get_inquiry->remarks) }}</span></span></span>
                            <p><span class="badge badge-danger"
                                    style="font-size:12px;">{{ $get_inquiry->created_at }}</span></p>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--    <div class="progress mg-b-20">
                                            <div class="progress-bar progress-bar-striped bg-warning wd-10p" role="progressbar" aria-valuenow="35"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>-->
    <div class="card bd-0">
        <div class="card-header bg-gray-400 bd-b-0-f pd-b-0">
            <nav class="nav nav-tabs">
                <a class="nav-link active" data-bs-toggle="tab" href="#tabCont1">INQUIRY REMARKS @if ($all_remarks !== null)
                        <badge class='badge badge-success'><?= $remarks_count ?></badge>
                    @else
                        <badge class='badge badge-warning'>0</badge>
                    @endif
                </a>
                <a class="nav-link" data-bs-toggle="tab" href="#tabCont2" id="#followups_path">FOLLOW-UPS /
                    REMINDERS

                </a>
                <a class="nav-link" data-bs-toggle="tab" href="#tabCont6">ACCOUNTS RECEIVABLES</a>
                <a class="nav-link" data-bs-toggle="tab" href="#tabCont7">DOCUMENTATION & CUSTOMER REGISTRATION</a>
                <a class="nav-link" data-bs-toggle="tab" href="#tabCont3">QUOTATION REMARKS</a>
                <a class="nav-link" data-bs-toggle="tab" href="#tabCont5">ISSUANCE STATUS</a>

                <!--<a class="nav-link" data-bs-toggle="tab" href="#tabCont8">ESCALATIONS</a>-->
            </nav>
        </div><!-- card-header -->
        <div class="card-body bd bd-t-0 tab-content">
            <!--Inquiry Remarks-->
            <div id="tabCont1" class="tab-pane show active">
                <div class="row">

                    <div class="col-md-9" style="height: 500px !important;">
                        <div class="card bg-white" style="height: 498px;">
                            <div class="card-body" style="    height: 498px;
                            overflow: auto;">
                                <h4 class="card-title "><u>INQUIRY REMARKS</u></h4>
                                <p class="card-text"></p>
                                <div class="row ">
                                    @if ($all_remarks != null)
                                        @forelse ($all_remarks as $key => $remark)
                                            <div class="card rounded-10 bg-light text-dark">
                                                <div class="card-body">
                                                    <div class="col-md-12 mt-2">
                                                        <h6 class="text-dark" style="font-weight: 600">PROGRESS REMARKS
                                                        </h6>
                                                    </div>

                                                    <div class="col-md-12 mt-2"><span class="text-success "
                                                            style="font-weight: bold;font-size:14px;">{{ strtoupper($remark->remarks) }}</span>
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        @php
                                                            $user_name = App\User::where('id', $remark->created_by)
                                                                ->select('name')
                                                                ->first();
                                                        @endphp
                                                        <?php if ($remark->remarks_status == 0) {
                                                            $prog_status = '<span
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        class="badge badge-warning" style="font-size:14px !important;color:#000;">Open</span>';
                                                        } elseif ($remark->remarks_status == 1) {
                                                            $prog_status = '<span
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        class="badge badge-warning" style="font-size:14px !important;color:#000;">In-Progress</span>';
                                                        } elseif ($remark->remarks_status == 2) {
                                                            $prog_status = '<span
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        class="badge badge-Info" style="font-size:14px !important;">Quotation Shared</span>';
                                                        } elseif ($remark->remarks_status == 3) {
                                                            $prog_status = '<span
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        class="badge badge-success" style="font-size:14px !important;">Confirmed</span>';
                                                        } elseif ($remark->remarks_status == 4) {
                                                            $prog_status = '<span
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        class="badge badge-success" style="font-size:14px !important;">Completed</span>';
                                                        } elseif ($remark->remarks_status == 5) {
                                                            $prog_status = '<span
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        class="badge badge-danger" style="font-size:14px !important;">Canceled</span>';
                                                        } elseif ($remark->remarks_status == 5) {
                                                            $prog_status =
                                                                '<span class="badge badge-danger" style="font-size:14px !important;"><span class="">Cancel Reason :
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ' .
                                                                $remark->cancel_reason .
                                                                '</span>';
                                                        } elseif ($remark->remarks_status == 10) {
                                                            $prog_status = '<span class="badge badge-danger" style="font-size:14px !important;">Hold</span>';
                                                        }
                                                        ?>


                                                        <span class="text-secondary" style="font-size:14px !important;">
                                                            ~{{ $user_name->name }} <span class="badge badge-success mt-2"
                                                                style="font-size:14px !important;">{{ $remark->created_at }}</span>
                                                            <?= $prog_status ?>
                                                        </span> <br>


                                                    </div>
                                                </div>
                                            </div>

                                            <br>
                                            <div class="clearfix"></div>
                                            <br>
                                        @empty
                                        @endforelse
                                    @endif
                                    <div class="card rounded-10 bg-light text-dark">
                                        <div class="card-body">
                                            <div class="col-md-12 mt-2">
                                                <h6 class="text-dark" style="font-weight: 600">INITIAL REMARKS</h6>
                                            </div>

                                            <div class="col-md-12 mt-2"><span class="text-success"
                                                    style="font-weight: bold;font-size:14px !important">{{ strtoupper($get_inquiry->remarks) }}</span>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                @php
                                                    $user_name = App\User::where('id', $get_inquiry->created_by)
                                                        ->select('name')
                                                        ->first();
                                                    // dd($user_name);
                                                @endphp
                                                <span class="text-secondary" style="font-size:14px !important;">
                                                    ~{{ $user_name->name }} <span style="font-size:14px !important;"
                                                        class="badge badge-success mt-2">{{ $get_inquiry->created_at }}</span>
                                                    <span style="font-size:14px !important;color:#000;"
                                                        class="badge badge-warning mt-2">Open</span></span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 inline-flex" style="display: inline-block;height: 500px !important;border:none;">
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
                                                    <option
                                                        @if ($get_latest_remarks != null) @if ($get_latest_remarks->remarks_status == 10) selected @endif
                                                        @endif value="10">
                                                        Hold
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="hold_date">
                                                <label for="" class="mt-2">Hold till Date<span
                                                        style="color: red">*</span></label>
                                                <input class="form-control" type="text" name="hold_date"
                                                    id="datetimepicker23" readonly />
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
                                                <textarea required="required" name="remarks" class="form-control" id="" cols="50" rows="50"></textarea>
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

                    <div class="col-md-9" style="height: auto !important;overflow: auto;">
                        <div class="card bg-white rounded-10" style="height: auto;overflow: auto;border:none;">
                            <!--                            <div class="card-body">-->
                            <h4 class="card-title "><u>FOLLOW-UPS / REMINDERS</u></h4>
                            <!--<div class="card bd-0">-->
                            <div class="card-header bg-gray-400 bd-b-0-f pd-b-0">
                                <nav class="nav nav-tabs">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#tabCont11">ALL</a>
                                    <a class="nav-link" data-bs-toggle="tab" href="#tabCont22">ACTIVE</a>
                                    <a class="nav-link" data-bs-toggle="tab" href="#tabCont33">CLOSED</a>
                                </nav>
                            </div><!-- card-header -->
                            <div class="card-body bd bd-t-0 tab-content">
                                <div id="tabCont11" class="tab-pane active show">
                                    <table id="example2" class="table table-bordered" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th class="wd-05">S.NO</th>
                                                <th class="wd-05">Type</th>
                                                <th>Date</th>
                                                <th class="wd-10">Remarks</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                                <th>Assigned To</th>
                                                <th class="wd-05">Action</th>
                                                <th class="none">Details</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($need_further_follow_ups !== null)
                                                @foreach ($need_further_follow_ups as $key => $primary_followup)
                                                    <?php
                                                    $followup_type = \App\follow_up_type::where('id_follow_up_types', $primary_followup->followup_type)->first();

                                                    ?>
                                                    @if ($primary_followup->followup_id == null)
                                                        @php
                                                            $created_by_user = App\User::where('id', $primary_followup->created_by)
                                                                ->select('name')
                                                                ->first();
                                                            $assigned_to_user = App\User::where('id', $primary_followup->user_id)
                                                                ->select('name')
                                                                ->first();
                                                        @endphp
                                                        <tr>

                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $followup_type->type_name }}</td>
                                                            <td>{{ $primary_followup->followup_date }}</td>
                                                            <td>{{ $primary_followup->remarks }}</td>
                                                            <td>{{ $primary_followup->followup_status }}</td>
                                                            <td>{{ $created_by_user->name }}</td>
                                                            <td>{{ $assigned_to_user->name }}</td>
                                                            <td><span style="font-size:12px;color:grey;"><b
                                                                        style="color:#000;">C:
                                                                    </b>{{ date('d-m-Y', strtotime($primary_followup->created_at)) }}</span><br><span
                                                                    style="font-size:12px;color:grey;"><b
                                                                        style="color:#000;">U: </b>
                                                                    {{ date('d-m-Y', strtotime($primary_followup->updated_at)) }}</span><br><button
                                                                    style="margin: 0px" type="button"
                                                                    onclick="edit_followup({{ $primary_followup->id_followup_remarks }})"
                                                                    class="btn btn-sm  btn-warning">Renew</button></td>


                                                            <td>
                                                                <table id="example2" class="table table-bordered"
                                                                    style="width:100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Type</th>
                                                                            <th>Date & Time</th>
                                                                            <th>Remarks</th>
                                                                            <th>Status</th>
                                                                            <th>Created By</th>
                                                                            <th>Assigned To</th>
                                                                            <th>Created At</th>
                                                                            <th>Updated At</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @if ($need_further_follow_ups !== null)
                                                                            @foreach ($need_further_follow_ups as $key2 => $secondary_followup)
                                                                                <?php
                                                                                $sec_followup_type = \App\follow_up_type::where('id_follow_up_types', $secondary_followup->followup_type)->first();

                                                                                ?>
                                                                                @if ($secondary_followup->followup_id == $primary_followup->id_followup_remarks)
                                                                                    @php
                                                                                        $created_by_user2 = App\User::where('id', $secondary_followup->created_by)
                                                                                            ->select('name')
                                                                                            ->first();
                                                                                        $assigned_to_user2 = App\User::where('id', $secondary_followup->user_id)
                                                                                            ->select('name')
                                                                                            ->first();
                                                                                    @endphp
                                                                                    <tr>

                                                                                        <td>{{ $sec_followup_type->type_name }}
                                                                                        </td>
                                                                                        <td>{{ $secondary_followup->followup_date }}
                                                                                        </td>
                                                                                        <td>{{ $secondary_followup->remarks }}
                                                                                        </td>
                                                                                        <td>{{ $secondary_followup->followup_status }}
                                                                                        </td>
                                                                                        <td>{{ $created_by_user2->name }}
                                                                                        </td>
                                                                                        <td>{{ $assigned_to_user2->name }}
                                                                                        </td>
                                                                                        <td>{{ date('d-m-Y', strtotime($secondary_followup->created_at)) }}
                                                                                        </td>
                                                                                        <td>{{ date('d-m-Y', strtotime($secondary_followup->updated_at)) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                                {{-- {{dd($need_further_follow_ups)}} --}}
                                <div id="tabCont22" class="tab-pane  show">
                                    <table id="example3" class="table table-bordered" style="width:100%;">
                                        <thead>
                                            <tr>

                                                <th>Type</th>
                                                <th>Date</th>
                                                <th>Remarks</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                                <th>Assigned To</th>
                                                <th>Action</th>
                                                <th class="none">Details</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($open_follow_ups !== null)
                                                @foreach ($open_follow_ups as $key => $primary_followup)
                                                    <?php
                                                    $followup_type = \App\follow_up_type::where('id_follow_up_types', $primary_followup->followup_type)->first();

                                                    ?>
                                                    @if ($primary_followup->followup_id == null)
                                                        @php
                                                            $created_by_user = App\User::where('id', $primary_followup->created_by)
                                                                ->select('name')
                                                                ->first();
                                                            $assigned_to_user = App\User::where('id', $primary_followup->user_id)
                                                                ->select('name')
                                                                ->first();
                                                        @endphp
                                                        <tr>

                                                            <td>{{ $followup_type->type_name }}</td>
                                                            <td>{{ $primary_followup->followup_date }}</td>
                                                            <td>{{ $primary_followup->remarks }}</td>
                                                            <td>{{ $primary_followup->followup_status }}</td>
                                                            <td>{{ $created_by_user->name }}</td>
                                                            <td>{{ $assigned_to_user->name }}</td>
                                                            <td><span style="font-size:12px;color:grey;"><b
                                                                        style="color:#000;">C:
                                                                    </b>{{ date('d-m-Y', strtotime($primary_followup->created_at)) }}</span><br><span
                                                                    style="font-size:12px;color:grey;"><b
                                                                        style="color:#000;">U: </b>
                                                                    {{ date('d-m-Y', strtotime($primary_followup->updated_at)) }}</span><br><button
                                                                    style="margin: 0px" type="button"
                                                                    onclick="edit_followup({{ $primary_followup->id_followup_remarks }})"
                                                                    class="btn btn-sm  btn-warning">Renew</button></td>

                                                            <td>
                                                                <table id="example2" class="table table-bordered"
                                                                    style="width:100%;">
                                                                    <thead>
                                                                        <tr>

                                                                            <th>Type</th>
                                                                            <th>Date & Time</th>
                                                                            <th>Remarks</th>
                                                                            <th>Status</th>
                                                                            <th>Created By</th>
                                                                            <th>Assigned To</th>
                                                                            <th>Created At</th>
                                                                            <th>Updated At</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @if ($open_follow_ups !== null)
                                                                            @foreach ($open_follow_ups as $key2 => $secondary_followup)
                                                                                <?php
                                                                                $sec_followup_type = \App\follow_up_type::where('id_follow_up_types', $secondary_followup->followup_type)->first();

                                                                                ?>
                                                                                @if ($secondary_followup->followup_id == $primary_followup->id_followup_remarks)
                                                                                    @php
                                                                                        $created_by_user2 = App\User::where('id', $secondary_followup->created_by)
                                                                                            ->select('name')
                                                                                            ->first();
                                                                                        $assigned_to_user2 = App\User::where('id', $secondary_followup->user_id)
                                                                                            ->select('name')
                                                                                            ->first();
                                                                                    @endphp
                                                                                    <tr>

                                                                                        <td>{{ $sec_followup_type->type_name }}
                                                                                        </td>
                                                                                        <td>{{ $secondary_followup->followup_date }}
                                                                                        </td>
                                                                                        <td>{{ $secondary_followup->remarks }}
                                                                                        </td>
                                                                                        <td>{{ $secondary_followup->followup_status }}
                                                                                        </td>
                                                                                        <td>{{ $created_by_user2->name }}
                                                                                        </td>
                                                                                        <td>{{ $assigned_to_user2->name }}
                                                                                        </td>
                                                                                        <td>{{ date('d-m-Y', strtotime($secondary_followup->created_at)) }}
                                                                                        </td>
                                                                                        <td>{{ date('d-m-Y', strtotime($secondary_followup->updated_at)) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                </div>

                                <div id="tabCont33" class="tab-pane  show">
                                    <table id="example4" class="table table-bordered" style="width:100%;">
                                        <thead>
                                            <tr>

                                                <th>Type</th>
                                                <th>Date</th>
                                                <th>Remarks</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                                <th>Assigned To</th>
                                                <th>Action</th>
                                                <th class="none">Details</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($closed_follow_ups !== null)
                                                @foreach ($closed_follow_ups as $key => $primary_followup)
                                                    <?php
                                                    $followup_type = \App\follow_up_type::where('id_follow_up_types', $primary_followup->followup_type)->first();

                                                    ?>
                                                    @if ($primary_followup->followup_id == null)
                                                        @php
                                                            $created_by_user = App\User::where('id', $primary_followup->created_by)
                                                                ->select('name')
                                                                ->first();
                                                            $assigned_to_user = App\User::where('id', $primary_followup->user_id)
                                                                ->select('name')
                                                                ->first();
                                                        @endphp
                                                        <tr>

                                                            <td>{{ $followup_type->type_name }}</td>
                                                            <td>{{ $primary_followup->followup_date }}</td>
                                                            <td>{{ $primary_followup->remarks }}</td>
                                                            <td>{{ $primary_followup->followup_status }}</td>
                                                            <td>{{ $created_by_user->name }}</td>
                                                            <td>{{ $assigned_to_user->name }}</td>
                                                            <td><span style="font-size:12px;color:grey;"><b
                                                                        style="color:#000;">C:
                                                                    </b>{{ date('d-m-Y', strtotime($primary_followup->created_at)) }}</span><br><span
                                                                    style="font-size:12px;color:grey;"><b
                                                                        style="color:#000;">U: </b>
                                                                    {{ date('d-m-Y', strtotime($primary_followup->updated_at)) }}</span><br><button
                                                                    style="margin: 0px" type="button"
                                                                    onclick="edit_followup({{ $primary_followup->id_followup_remarks }})"
                                                                    class="btn btn-sm  btn-warning">Renew</button></td>
                                                            <td>
                                                                <table id="example2" class="table table-bordered"
                                                                    style="width:100%;">
                                                                    <thead>
                                                                        <tr>

                                                                            <th>Type</th>
                                                                            <th>Date & Time</th>
                                                                            <th>Remarks</th>
                                                                            <th>Status</th>
                                                                            <th>Created By</th>
                                                                            <th>Assigned To</th>
                                                                            <th>Created At</th>
                                                                            <th>Updated At</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @if ($closed_follow_ups !== null)
                                                                            @foreach ($closed_follow_ups as $key2 => $secondary_followup)
                                                                                <?php
                                                                                $sec_followup_type = \App\follow_up_type::where('id_follow_up_types', $secondary_followup->followup_type)->first();

                                                                                ?>
                                                                                @if ($secondary_followup->followup_id == $primary_followup->id_followup_remarks)
                                                                                    @php
                                                                                        $created_by_user2 = App\User::where('id', $secondary_followup->created_by)
                                                                                            ->select('name')
                                                                                            ->first();
                                                                                        $assigned_to_user2 = App\User::where('id', $secondary_followup->user_id)
                                                                                            ->select('name')
                                                                                            ->first();
                                                                                    @endphp
                                                                                    <tr>

                                                                                        <td>{{ $sec_followup_type->type_name }}
                                                                                        </td>
                                                                                        <td>{{ $secondary_followup->followup_date }}
                                                                                        </td>
                                                                                        <td>{{ $secondary_followup->remarks }}
                                                                                        </td>
                                                                                        <td>{{ $secondary_followup->followup_status }}
                                                                                        </td>
                                                                                        <td>{{ $created_by_user2->name }}
                                                                                        </td>
                                                                                        <td>{{ $assigned_to_user2->name }}
                                                                                        </td>
                                                                                        <td>{{ date('d-m-Y', strtotime($secondary_followup->created_at)) }}
                                                                                        </td>
                                                                                        <td>{{ date('d-m-Y', strtotime($secondary_followup->updated_at)) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                </div><!-- tab-pane -->
                            </div><!-- card-body -->
                            <!--</div>-->


                            <!--</div>-->
                        </div>
                    </div>
                    <div class="col-md-3 inline-flex" style="display: inline-block;">
                        <div class="card bg-white" style="border:none;">
                            <div class="card-body">
                                <h4 class="card-title"><u>ADD / RENEW FOLLOW-UP REMARKS</u>
                                    <badge style='display:none;' id='renew_existing_followup'
                                        class='badge badge-success badge-round'>RENEW EXISTING FOLLOW-UP</badge>
                                </h4>
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
                                                    required="required" class="form-control" readonly>
                                            </div>
                                            <input type="hidden" name="id_follow_up_remarks" id="id_follow_up_remarks">
                                            <input type="hidden" name="follow_up_id" id="follow_up_id">
                                            <div class="form-group">
                                                @csrf
                                                <label class="mt-2">STATUS <span style="color: red">*</span></label>
                                                <select class="form-control" name="followup_status" id="followup_status"
                                                    required="required">
                                                    <option value="Open">Open</option>
                                                    <option hidden value="Need Further Follow up">Need Further Follow up
                                                    </option>
                                                    <option hidden value="Closed">Closed</option>
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
                                                    class="btn btn-success btn-block text-white w-50">Add
                                                    Follow-up</button>
                                                <button type="reset" onclick="reset_followup_form();" id="btn_sub"
                                                    class="btn btn-danger btn-block text-white w-30">Reset</button>
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

                                    <h4><u>ACCOUNTS RECEIVABLES</u></h4>

                                    <button class="btn btn-az-primary" onclick="pay_quotation({{ $dec_inq_id }})">Add
                                        Payments</button>

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

                                    <table id="example6" style="width: 100%;" class="table table-bordered rounded-10">
                                        <thead>
                                            <tr>
                                                <th class="wd-5p">S.No</th>
                                                <th class="wd-5p">Payment Type</th>
                                                <th class="wd-10p">RV Number</th>
                                                <th class="wd-30p">Remarks</th>
                                                <th class="wd-10p">Received Amount</th>
                                                <th class="wd-10p">Remaining Amount</th>
                                                <th class="wd-10p">Status</th>
                                                <th class="wd-10p">Created At</th>
                                                <th class="wd-10p">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($payment_invoice_list as $key => $pay_ac)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $pay_ac->payment_type }}</td>
                                                    <td>{{ $pay_ac->recieving_number }}</td>
                                                    <td>{{ $pay_ac->payment_remarks }}</td>
                                                    <td>{{ $pay_ac->paid_amount }}</td>
                                                    <td>0</td>
                                                    <td>
                                                        @if ($pay_ac->status == 0)
                                                            <span class="badge badge-warning">Pending</span>
                                                        @elseif($pay_ac->status == 1)
                                                            <span class="badge badge-info">PAYMENT NOT VERIFIED</span>
                                                        @elseif($pay_ac->status == 2)
                                                            <span class="badge badge-success">PAYMENT VERIFIED</span>
                                                        @endif
                                                    </td>
                                                    {{-- <td>{{ get_total_quotation_received_amount($pay->quotation_id) }}</td> --}}
                                                    <td>{{ $pay_ac->created_at }}</td>
                                                    <td><button style="color:white;" class="btn btn-gray-500 rounded-10"
                                                            onclick="get_details({{ $pay_ac->id_account_payments }},'{{ $pay_ac->payment_type }}')">View
                                                            Details</button>
                                                    </td>

                                                </tr>
                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="wd-5p">S.No</th>
                                                <th class="wd-5p">Payment Type</th>
                                                <th class="wd-10p">RV Number</th>
                                                <th class="wd-30p">Remarks</th>
                                                <th class="wd-10p">Received Amount</th>
                                                <th class="wd-10p">Remaining Amount</th>
                                                <th class="wd-10p">Status</th>
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
                                    <h4><u>DOCUMENTATION & CUSTOMER REGISTRATION</u></h4>
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
                                                <div class="card bg-light rounded-10">
                                                    <div class="card-body">

                                                        <h4>{{ $document_data[$i]->person }} No {{ $i + 1 }}</h4>

                                                        <div class="form-group">
                                                            <label for="">Upload Passport</label>
                                                            <input type="file" name="" id=""
                                                                class="form-control" placeholder=""
                                                                aria-describedby="helpId">

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
                                                                            class="form-check-input is_head"
                                                                            type="radio"
                                                                            @if ($document_data[$i]->is_head == 1) checked @endif
                                                                            name="is_head[{{ $i }}]"
                                                                            id="is_head" value="checkedValue"> Is Head
                                                                    </label>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="" class="mt-2">Given Name<span
                                                                            style="color: red">*</span></label>
                                                                    {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                    <input type="text"
                                                                        value="{{ $document_data[$i]->given_name }}"
                                                                        class="form-control" name="given_name[]"
                                                                        id="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="" class="mt-2">Sur Name<span
                                                                            style="color: red">*</span></label>
                                                                    {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                    <input type="text"
                                                                        value="{{ $document_data[$i]->sur_name }}"
                                                                        class="form-control" name="sur_name[]"
                                                                        id="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="" class="mt-2">Passport
                                                                        Number<span style="color: red">*</span></label>
                                                                    {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                    <input type="text"
                                                                        value="{{ $document_data[$i]->passport_no }}"
                                                                        class="form-control" name="passport_no[]"
                                                                        id="">
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
                                                                        value="{{ $document_data[$i]->validity }}"
                                                                        min="1" class="form-control"
                                                                        name="validity[]" id="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="" class="mt-2">Expiry<span
                                                                            style="color: red">*</span></label>
                                                                    {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                    <input type="text"
                                                                        value="{{ $document_data[$i]->expiry }}"
                                                                        placeholder="15/Sep/23"
                                                                        class="form-control fc-datepicker" name="expiry[]"
                                                                        id="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="" class="mt-2">Gender<span
                                                                            style="color: red">*</span></label>
                                                                    {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                    <select name="gender[]" class="form-control"
                                                                        id="gender">
                                                                        <option
                                                                            @if ($document_data[$i]->gender == 'Male') selected @endif
                                                                            value="Male">Male</option>
                                                                        <option
                                                                            @if ($document_data[$i]->gender == 'Female') selected @endif
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
                                                    </div>
                                                </div>
                                                <br>
                                            @endfor
                                        @else
                                            @for ($i = 0; $i < $get_inquiry->no_of_adults; $i++)
                                                <div class="card bg-light rounded-10">
                                                    <div class="card-body">
                                                        <h4>Adult No {{ $i + 1 }}</h4>
                                                        <div class="form-group">
                                                            <label for="">Upload Passport</label>
                                                            <input type="file" name="" id=""
                                                                class="form-control" placeholder=""
                                                                aria-describedby="helpId">

                                                        </div>
                                                        <input type="hidden" name="person[]" value="Adult">
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-check form-check-inline float-end">
                                                                    <label class="form-check-label">
                                                                        <input onclick="onlyOne(this)"
                                                                            class="form-check-input is_head"
                                                                            type="radio"
                                                                            name="is_head[{{ $i }}]"
                                                                            id="is_head" value="checkedValue"> Is Head
                                                                    </label>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="" class="mt-2">Given Name<span
                                                                            style="color: red">*</span></label>
                                                                    {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                    <input type="text" value=""
                                                                        class="form-control" name="given_name[]"
                                                                        id="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="" class="mt-2">Sur Name<span
                                                                            style="color: red">*</span></label>
                                                                    {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                    <input type="text" value=""
                                                                        class="form-control" name="sur_name[]"
                                                                        id="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="" class="mt-2">Passport
                                                                        Number<span style="color: red">*</span></label>
                                                                    {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                    <input type="text" value=""
                                                                        class="form-control" name="passport_no[]"
                                                                        id="">
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
                                                                        class="form-control" name="validity[]"
                                                                        id="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="" class="mt-2">Expiry<span
                                                                            style="color: red">*</span></label>
                                                                    {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                    <input type="text" value=""
                                                                        placeholder="15/Sep/23"
                                                                        class="form-control fc-datepicker" name="expiry[]"
                                                                        id="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="" class="mt-2">Gender<span
                                                                            style="color: red">*</span></label>
                                                                    {{-- <small id="helpId" class="text-muted">Help text</small> --}}
                                                                    <select name="gender[]" class="form-control"
                                                                        id="gender">
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
                                                    </div>
                                                </div><br>
                                            @endfor
                                            @for ($i = 0; $i < $get_inquiry->no_of_children; $i++)
                                                <div class="card bg-light rounded-10">
                                                    <div class="card-body">
                                                        <h4>Child No {{ $i + 1 }}</h4>
                                                        <div class="form-group">
                                                            <label for="">Upload Passport</label>
                                                            <input type="file" name="" id=""
                                                                class="form-control" placeholder=""
                                                                aria-describedby="helpId">
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
                                                                    <input type="text" class="form-control"
                                                                        name="sur_name[]" id="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="" class="mt-2">Passport
                                                                        Number<span style="color: red">*</span></label>
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
                                                                    <input type="number" min="1"
                                                                        class="form-control" name="validity[]"
                                                                        id="">
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
                                                                    <select name="gender[]" class="form-control"
                                                                        id="gender">
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
                                                    </div>
                                                </div><br>
                                            @endfor
                                            @for ($i = 0; $i < $get_inquiry->no_of_infants; $i++)
                                                <div class="card bg-light rounded-10">
                                                    <div class="card-body">
                                                        <h4>Infant No {{ $i + 1 }}</h4>
                                                        <div class="form-group">
                                                            <label for="">Upload Passport</label>
                                                            <input type="file" name="" id=""
                                                                class="form-control" placeholder=""
                                                                aria-describedby="helpId">
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
                                                                    <input type="text" class="form-control"
                                                                        name="sur_name[]" id="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="" class="mt-2">Passport
                                                                        Number<span style="color: red">*</span></label>
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
                                                                    <input type="number" min="1"
                                                                        class="form-control" name="validity[]"
                                                                        id="">
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
                                                                    <select name="gender[]" class="form-control"
                                                                        id="gender">
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
                                                    </div>
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
                        <h4><u>QUOTATIONS LIST</u><a class="btn btn-az-primary" style="float: right;margin: 0"
                                href="#services">Create New Quotation</a></h4>
                    </div><br>
                    <p class="card-text"></p>

                    <div class="row" style="height: auto;">
                        {{-- {{dd($quotations)}} --}}
                        <?php
                        $get_approved_quotations = '';
                        ?>
                        @foreach ($quotations as $key_main => $quote)
                            <div class="card bg-light rounded-10">
                                <div class="card-body">
                                    <?php

                                    // echo $c_cou;
                                    if ($quote->quotation_type == 'service_level') {
                                        $get_total = App\quotations_detail::where('uniq_id', $quote->quotations_details_id)
                                            ->select('total', 'services_type', 'default_rate_of_exchange_amt')
                                            ->get();

                                        $hotel_exchange_total = null;
                                        $visa_exchange_total = null;
                                        $land_exchange_total = null;
                                        $ticket_exchange_total = null;
                                        $quote_grand_total = null;

                                        if (isset($get_total)) {
                                            foreach ($get_total as $quote_total) {
                                                if ($quote_total->services_type == 'Hotel') {
                                                    $hotel_exchange_total = $quote_total->total * $quote_total->default_rate_of_exchange_amt;
                                                }
                                                if ($quote_total->services_type == 'Visa') {
                                                    $visa_exchange_total = $quote_total->total * $quote_total->default_rate_of_exchange_amt;
                                                }
                                                if ($quote_total->services_type == 'Land Services') {
                                                    $land_exchange_total = $quote_total->total * $quote_total->default_rate_of_exchange_amt;
                                                }
                                                if ($quote_total->services_type == 'Air Ticket') {
                                                    $ticket_exchange_total = $quote_total->total;
                                                }
                                            }
                                            $quote_grand_total = $hotel_exchange_total + $visa_exchange_total + $land_exchange_total + $ticket_exchange_total;
                                            //                                        dd($hotel_exchange_total);
                                        }
                                    } else {
                                        $get_total = App\quotations_detail::where('uniq_id', $quote->quotations_details_id)
                                            ->select('total')
                                            ->first();
                                        $get_total = $get_total?->total;
                                    }
                                    $issuance_status = App\quotation_issuance::where('quotation_id', $quote->id_quotations)
                                        ->orderBy('quotation_id', 'desc')
                                        ->get();
                                    $get_rejected_issuance = App\issuance_rejection::where('quotation_id', $quote->id_quotations)
                                        ->orderBy('quotation_id', 'desc')
                                        ->get();
                                    $get_quotation_details = \App\quotations_detail::where('quotation_id', $quote->id_quotations)->get();
                                    //                                    dd($get_quotation_details);
                                    $service_type_count = null;
                                    if (isset($get_quotation_details)) {
                                        foreach ($get_quotation_details as $quotation_details) {
                                            //                                            dd($quotation_details);

                                            if ($quotation_details->services_type) {
                                                $service_type_count .= $quotation_details->services_type;
                                            }
                                        }
                                    }
                                    //                                    dd($service_type_count);
                                    ?>
                                    <div>
                                        <a class="d-none" id="service_level_btn{{ $key_main }}"
                                            class="btn btn-az-primary"
                                            href="{{ url('edit_quotation/' . \Crypt::encrypt($dec_inq_id) . '/' . \Crypt::encrypt($quote->id_quotations) . '/service_level') }}">Convert(S.L)</a>
                                        <a class="d-none" id="lum_sum_btn{{ $key_main }}"
                                            class="btn btn-az-primary"
                                            href="{{ url('edit_quotation/' . \Crypt::encrypt($dec_inq_id) . '/' . \Crypt::encrypt($quote->id_quotations) . '/lum_sum') }}">Convert(L.S)</a>
                                        <a class="d-none" id="no_of_person_btn{{ $key_main }}"
                                            class="btn btn-az-primary"
                                            href="{{ url('edit_quotation/' . \Crypt::encrypt($dec_inq_id) . '/' . \Crypt::encrypt($quote->id_quotations) . '/no_of_person') }}">Convert(N.P)</a>
                                    </div>
                                    <a class="tickets-card row">
                                        <div class="tickets-details col-lg-3 col-12">

                                            <div class="wrapper">

                                                <h5>{{ $quote->quotation_no }}<br>
                                                    @if ($quote->quotation_type == 'service_level')
                                                        Type: Service Level
                                                    @elseif ($quote->quotation_type == 'no_of_person')
                                                        Type: Per Person
                                                    @else
                                                        Type: Lum Sum
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
                                                        Status : <span>Rejected</span>
                                                    </div>
                                                @elseif ($quote->status == 2)
                                                    Status : <span>Cancelled</span>
                                                @endif



                                            </div>


                                            <div class="wrapper text-muted d-none d-md-block">

                                                <span>Total </span>
                                                <span
                                                    class="text-success"><strong>{{ $quote_grand_total }}/-</strong></span>
                                                <span><i
                                                        class="typcn icon typcn-time"></i>{{ $quote->created_at->format('d-M-Y H:i') }}</span>

                                            </div>
                                            <div class="wrapper text-muted d-none d-md-block">
                                                <span>
                                                    @if ($issuance_status !== null)
                                                        @foreach ($issuance_status as $issuance_stat)
                                                            @if ($issuance_stat->status == 'Un-Assign')
                                                                <div class="badge badge-primary">
                                                                    <span>(<?= $issuance_stat->services_type ?>) Sent for
                                                                        Issuance</span>
                                                                </div>
                                                            @elseif($issuance_stat->status == 'Assign')
                                                                <div class="badge badge-primary">
                                                                    <span>(<?= $issuance_stat->services_type ?>) Issuance
                                                                        Assigned</span>
                                                                </div>
                                                            @elseif($issuance_stat->send_for_verification == '1' && $issuance_stat->status !== 'Rejected')
                                                                <div class="badge badge-success">
                                                                    <span>(<?= $issuance_stat->services_type ?>) Sent for
                                                                        Verification</span>
                                                                </div>
                                                            @elseif($issuance_stat->status == 'Rejected')
                                                                @foreach ($get_rejected_issuance as $rejected_service)
                                                                    <div class="badge badge-danger">
                                                                        <span>(<?= $issuance_stat->services_type ?>)
                                                                            Issuance Rejected</span>
                                                                    </div>
                                                                @endforeach
                                                                <!--                                            <button style="color:#fff;" title="EDIT REJECTED ISSUANCE QUOTATION" class="btn btn-rounded btn-warning mb-3" onclick="edit_quotation('{{ Crypt::encrypt($dec_inq_id) }}')">
                                                                                <b>Edit</b>
                                                                                </button>-->
                                                            @elseif(
                                                                $issuance_stat->status == 'Service Issued' &&
                                                                    $issuance_stat->status !== 'Rejected' &&
                                                                    $issuance_stat->send_for_verification == '1')
                                                                <div class="badge badge-success">
                                                                    <span>(<?= $issuance_stat->services_type ?>) Service
                                                                        Issued</span>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </span>
                                            </div>
                                        </div>

                                        <div class="ticket-float col-lg-3 col-sm-6 d-none d-md-block"
                                            style="border-left:1px solid lightgray;">
                                            {{-- <select name="" id="conversion{{ $key_main }}" class="form-control">
                                        <option value="">Select</option>
                                        <option @if ($quote->quotation_type == 'service_level') class="d-none" @endif
                                            value="service_level">Convert Quotation To Service Level</option>
                                        <option @if ($quote->quotation_type == 'no_of_person') class="d-none" @endif
                                            value="no_of_person">Convert Quotation To No Of Person</option>
                                        <option @if ($quote->quotation_type == 'lum_sum') class="d-none" @endif value="lum_sum">
                                            Convert Quotation To Lum Sum</option>
                                    </select> --}}
                                            {{-- {{get_issuance_services($quote->id_quotations,$sub_name)}} --}}
                                            {{-- {{dd($quote->Issuancedata[0])}} --}}
                                            {{-- {{dd(check_payment($quote->quotation_id))}} --}}
                                            {{-- {{check_payment($quote->id_quotations,$get_total)}} --}}
                                            @if ($quote->status == 3 && check_doc($dec_inq_id) && $quote->customer_verified == 1)
                                                <br>
                                                <br>
                                                <label>Select Issuance Services</label>
                                                <select name="" multiple id="issuance_service{{ $key_main }}"
                                                    class="form-control select2 ">
                                                    <?php $get_quotation_details = \App\quotations_detail::where('quotation_id', $quote->id_quotations)->get(); ?>

                                                    @foreach ($get_quotation_details as $key => $sub_name)
                                                        <option value="{{ $sub_name->services_type }}">
                                                            {{ $sub_name->services_type }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            @endif
                                        </div>
                                        <div class="ticket-float col-lg-3 col-sm-6 d-none d-md-block">
                                            <!--                                            <button class="btn btn-az-primary mb-3"
                                                        onclick="convert({{ $quote->id_quotations }},{{ $key_main }})">
                                                        Convert
                                                    </button>-->
                                            @if ($quote->status == 3 && check_doc($dec_inq_id) && $quote->customer_verified == 1)
                                                <br>
                                                <button class="btn btn-rounded btn-az-primary mb-3"
                                                    onclick="send_quotation_to_issuance({{ $quote->id_quotations }},{{ $key_main }})">
                                                    Send for Issuance
                                                </button>
                                            @endif

                                        </div>
                                        <div class="ticket-float col-lg-2 col-sm-6 d-none d-md-block "
                                            style="border-left:1px solid lightgray;">
                                            @php
                                                $get_quotations = app\remarks::where('quotation_id', $quote->id_quotations)
                                                    ->where('remarks_status', 'Quotation Send For Approval')
                                                    ->count();
                                                $get_approved_quotations = app\remarks::where('quotation_id', $quote->id_quotations)
                                                    ->where('remarks_status', 'Quotation Approved')
                                                    ->count();
                                                $get_approved_quotations2 = app\remarks::where('inquiry_id', $quote->inquiry_id)
                                                    ->where('remarks_status', 'Customer Verified')
                                                    ->count();
                                                $get_rejected_reason = app\remarks::where('quotation_id', $quote->id_quotations)
                                                    ->where('type', 'quotation')
                                                    ->latest()
                                                    ->where('remarks_status', 'Quotation Rejected')
                                                    ->first();
                                                //dd($get_rejected_reason);
                                            @endphp
                                            @if ($get_quotations < 1)
                                                <button class="btn btn-warning btn-rounded mb-3" style="color:#fff;"
                                                    onclick="send_quotation_to_approval({{ $quote->id_quotations }})">
                                                    <b>Manager Approval</b>
                                                </button>
                                            @else
                                                @if ($get_approved_quotations !== 1 && $get_rejected_reason == null)
                                                    <badge class="badge badge-warning">Quotation sent for Manager Approval
                                                    </badge>
                                                @elseif(isset($get_rejected_reason))
                                                    <badge class="badge badge-danger"
                                                        title="Reason: <?= $get_rejected_reason->cancel_reason ?>">
                                                        Quotation Rejected</badge>
                                                    <!--                                                    <button style="color:#fff;" title="EDIT REJECTED QUOTATION"
                                                                class="btn btn-rounded btn-warning mb-3"
                                                                onclick="convert({{ $quote->id_quotations }}, {{ 1 }})">
                                                                <b>Edit</b>
                                                            </button>-->
                                                @else
                                                    <badge class="badge badge-success">Quotation Approved From Manager
                                                    </badge>
                                                @endif
                                            @endif
                                            <div class="ticket-float col-lg-2 col-sm-6 d-none d-md-block ">
                                                @if ($get_approved_quotations == 1)
                                                    @if ($quote->customer_verified == 1)
                                                        <badge class="badge badge-success">Quotation Approved From Customer
                                                        </badge>
                                                    @else
                                                        @if ($get_approved_quotations2 !== 1)
                                                            <button style="color:#fff;"
                                                                title="CONFIRMATION OF QUOTATION FROM CUSTOMER"
                                                                class="btn btn-rounded btn-warning mb-3"
                                                                onclick="customer_verification('{{ Crypt::encrypt($quote->id_quotations) }}')">
                                                                <b>Send for Customer Approval</b>
                                                            </button>
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ticket-float col-lg-1 col-sm-6 d-none d-md-block ">
                                            <button class="btn btn-rounded btn-az-primary mb-3" target="_blank"
                                                onclick="window.location.href='{{ url('/view_quotation/' . \Crypt::encrypt($quote->id_quotations) . '/' . \Crypt::encrypt($quote->inquiry_id)) }}'">
                                                View
                                            </button>
                                        </div>

                                    </a>

                                </div>
                            </div>
                            <div class="clearfix"></div><br>
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
                                    <select name="services" class="form-control select2" id="services" required>
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
                                    <select name="sub_services" class="select2 form-control " id="sub_services_option"
                                        required>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Select Service Type</label>
                                    <select name="service_type" class="select2 form-control " id="service_type"
                                        required>
                                        <!--<option value="">Select</option>-->
                                        <option value="service_level">Service Level (S.L)</option>
                                        <!--                                        <option value="no_of_person">No Of Person</option>
                                                <option value="lum_sum">Lum Sum</option>-->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Select Default ROE</label>
                                    <select name="default_rate_of_exchange_amt" onchange="change_roe_amt()"
                                        class="select2 form-control" id="default_rate_of_exchange">
                                        <option value="">Select</option>
                                        @foreach ($currency_rates as $roe)
                                            <option @if ($roe->currency_name == 'Saudi Riyal') selected @endif
                                                value="{{ $roe->currency_rate }}">{{ $roe->currency_name }} |
                                                {{ $roe->currency_rate }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="default_rate_of_exchange"
                                        class="default_rate_of_exchange_amt_val" id="default_rate_of_exchange_amt_val">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Quotation Expiry</label>
                                    <select name="" class="select2 form-control" required>
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
        change_roe_amt();

        function change_roe_amt() {
            let get_roe_val = $('#default_rate_of_exchange :selected').text();
            let get_text = get_roe_val.replace("\n", "");
            let final_text = get_text.split("|")[0];
            $('.default_rate_of_exchange_amt_val').val(final_text);


        }


        $(".cnic").inputmask();
        $(document).ready(function() {
            $('#datetimepicker22').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                minDate: 0
            });
            $('#datetimepicker23').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                minDate: 0
            });

            //Button holder script on submit
            const fewSeconds = 10

            document.querySelector('#btn_sub').addEventListener('click', (e) => {
                e.target.disabled = true
                setTimeout(() => {
                    e.target.disabled = false
                }, fewSeconds * 1000)
            })

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
                    $('#ac_payment_type').html(response.payment_type)
                    //                    alert(response.payment_type);
                    $('#ac_bank_name').html(response.bank_name)
                    $('#ac_account_number').html(response.account_number)
                    $('#ac_cheque_no').html(response.cheque_number)
                    $('#ac_amount').html(response.amount)
                    $('#payment_number').html(response.payment_number)

                    if (response.payment_status == 0) {
                        var payment_status_detail = 'Pending';
                    }
                    if (response.payment_verification == 0) {
                        var payment_verification_detail = 'Un-verified';
                    }
                    $('#payment_status').html(payment_status_detail)
                    $('#ac_customer_bank').html(response.customer_bank)
                    $('#ac_our_bank').html(response.bank_name)
                    $('#ac_cheque_date').html(response.cheque_date)
                    $('#ac_deposit_date').html(response.deposit_date)
                    $('#ac_clearing_date').html(response.clearing_date)
                    $('#ac_payment_remarks').html(response.payment_remarks)
                    $('#ac_payment_verification').html(payment_verification_detail)
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
                        $('#our_bank').css('display', 'none');
                        $('#d_bank_name').css('display', 'none');
                        $('#d_account_number_ac').css('display', 'none');
                        $('#d_attachment').css('display', 'none');
                        $('#cheque_date').css('display', 'none');
                        $('#deposit_date').css('display', 'none');
                        $('#customer_bank').css('display', 'none');
                        $('#our_bank').css('display', 'none');
                        $('#deposit_date').css('display', 'none');
                        $('#clearing_date').css('display', 'none');

                    } else if (p_type == "Cheque") {
                        $('#d_cheque_number').css('display', 'none');
                        $('#our_bank').css('display', 'none');
                        $('#customer_bank').css('display', 'block');
                        $('#my_cheque_date').css('display', 'block');
                        $('#d_account_number_ac').css('display', 'none');
                        $('#d_attachment').css('display', 'block');
                        $('#deposit_date').css('display', 'none');
                        $('#cheque_date').css('display', 'block');
                        $('#my_bank').css('display', 'none');
                        $('#d_deposit_date').css('display', 'none');
                        $('#clearing_date').css('display', 'none');

                    } else if (p_type == "Online_transfer") {
                        $('#d_cheque_number').css('display', 'none');
                        $('#customer_bank').css('display', 'block');
                        $('#our_bank').css('display', 'block');
                        $('#my_bank').css('display', 'block');
                        $('#cheque_date').css('display', 'none');
                        $('#deposit_date').css('display', 'block');
                        $('#d_account_number_ac').css('display', 'none');
                        $('#d_attachment').css('display', 'block');
                        $('#clearing_date').css('display', 'none');

                    } else if (p_type == "Clearing") {
                        $('#d_cheque_number').css('display', 'none');
                        $('#customer_bank').css('display', 'block');
                        $('#our_bank').css('display', 'block');
                        $('#cheque_date').css('display', 'none');
                        $('#deposit_date').css('display', 'block');
                        $('#clearing_date').css('display', 'block');
                        $('#d_account_number_ac').css('display', 'none');
                        $('#d_attachment').css('display', 'block');
                        $('#deposit_date').css('display', 'block');
                        $('#clearing_date').css('display', 'block');
                    } else {
                        $('#d_cheque_number').css('display', 'none');
                        $('#d_bank_name').css('display', 'none');
                        $('#d_account_number_ac').css('display', 'none');
                        $('#d_cheque_no').css('display', 'none');
                        $('#our_bank').css('display', 'block');
                        $('#d_bank').css('display', 'none');
                        $('#image_file').css('display', 'none');
                        $('#image_file_label').css('display', 'none');
                        $('#cheque_date').css('display', 'none');
                        $('#customer_bank').css('display', 'none');
                        $('#deposit_date').css('display', 'none');
                        $('#clearing_date').css('display', 'block');
                    }

                    if (p_type == 'Online') {
                        $('#d_cheque_no').css('display', 'none');
                    }
                    $('#pay_id').val(pay_id)

                    $('#modaldemo8').modal('show');
                }

            });
        }

        function reset_followup_form() {
            $('#followup_status').append($('<option>', {
                value: 'Open',
                text: 'Open'
            }));
            //                    $("#followup_status option[value='Open']").removeAttr("hidden");
            $("#followup_status option[value='Need Further Follow up']").remove();
            $("#followup_status option[value='Closed']").remove();
            $('#renew_existing_followup').css("display", "none");
        }

        function edit_followup(id_remarks) {
            $.ajax({
                type: "get",
                url: "{{ url('/get_followup_details') }}/" + id_remarks,
                success: function(response) {
                    $("#followup_status option[value='Open']").remove();
                    $('#followup_status').append($('<option>', {
                        value: 'Need Further Follow up',
                        text: 'Need Further Follow up'
                    }));
                    $('#followup_status').append($('<option>', {
                        value: 'Closed',
                        text: 'Closed'
                    }));

                    //                    $('#followup_type').val(response.followup_type);
                    $('#followup_type')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="' + response.followup_type + '">' + response
                            .followup_type_name + '</option>')
                        .val(response.followup_type);

                    $('#id_follow_up_remarks').val(id_remarks);
                    $('#followup_id').val(response.followup_id);
                    //                    $('#datetimepicker22').val(response.followup_date);
                    //                    $('#followup_status').val(response.followup_status);
                    //                    $('#followup_remarks').val(response.remarks);
                    $('#follow_up_id').val(response.followup_id);
                    var follow_user = $('#followup_user').val(response.user_id);
                    var follow_type = $('#followup_type').val(response.followup_type);
                    $('#renew_existing_followup').css("display", "block");
                    if (response.followup_type == follow_type) {
                        $('#followup_type').prop('checked', true);

                    } else {
                        $('#followup_type').prop('checked', true);
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
                "ordering": false,
                "dom": 'Blfrtip',
                "buttons": [
                    'excel', 'pdf', 'print'
                ],
                responsive: !0,
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: 0,
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

            $('#example3 tfoot th').each(function() {
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
            });

            $('#example3').DataTable({
                "ordering": false,
                "dom": 'Blfrtip',
                "buttons": [
                    'excel', 'pdf', 'print'
                ],
                responsive: !0,
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: 0,
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

            $('#example4 tfoot th').each(function() {
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
            });

            $('#example4').DataTable({
                "ordering": false,
                "dom": 'Blfrtip',
                "buttons": [
                    'excel', 'pdf', 'print'
                ],
                responsive: !0,
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: 0,
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

            $('#example5 tfoot th').each(function() {
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
            });

            $('#example5').DataTable({
                "ordering": false,
                "dom": 'Blfrtip',
                "buttons": [
                    'excel', 'pdf', 'print'
                ],
                responsive: !0,
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: 0,
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

            $('#example6 tfoot th').each(function() {
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
            });

            $('#example6').DataTable({
                "ordering": false,
                "dom": 'Blfrtip',
                "buttons": [
                    'excel', 'pdf', 'print'
                ],
                responsive: !0,
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: 0,
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
                    if (response.quotation_status == 1) {
                        //                        alert(response.quotation_details);
                        $('.select2').select2();
                        $('#pay_services_append').html(response.services_option);
                        $('#modaldemo7').modal('show');
                        $('#total_amount').val(response.total_amount);
                        $('#pay_inq_id').val(inq_id);
                        $('#my_quotation_id').html(response.quotation_details);
                        $("#pay_services_append").select2({
                            dropdownParent: $("#modaldemo7")
                        });
                    }
                    if (response.quotation_status == 0) {
                        $('.select2').select2();
                        $('#pay_services_append').html(response.services_option);
                        $('#modaldemo7').modal('show');
                        $('#total_amount').val(response.total_amount);
                        $('#pay_inq_id').val(inq_id);
                        $('#my_quotation_id').html(response.quotation_details);
                        $("#pay_services_append").select2({
                            dropdownParent: $("#modaldemo7")
                        });
                    }

                }
            });
            // $('#pay_quote_detail_id').val(quote_detail_id);
            // $('#quote_pay_id').val(quote_id);
            // $('#pay_services_type').val(services_type);

        }

        function onchange_amount_val() {
            // alert("lsds")
            var inq_id = $('#pay_inq_id').val();
            $.ajax({
                type: "get",
                url: "{{ url('onchange_amount_val') }}/" + inq_id,
                success: function(response) {
                    //                    var t_amt = $('#enter_amount').val();
                    if (t_amt > response.total_amount || t_amt == 0) {
                        //                        $('#enter_amount').val(response.total_amount);
                        $('#pay_btn').prop('disabled', false);
                    } else {
                        $('#pay_btn').prop('disabled', false);
                    }
                }
            });
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
                                    'Quotation Sent!',
                                    'Quotation Successfully Sent For Approval!',
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
            //             alert(val_of_issuance);
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
            $("#hold_date").hide();
            $("#quotations").hide();
            var val = $("#status").val();
            if (val == 5) {
                $("#reasons").show();
                $("#hold_date").hide();
                $("#reason_input").prop("required", true);
            }
            if (val == 10) {
                $("#hold_date").show();
                $("#hold_date_input").prop("required", true);
            }
            if (val == 4) {
                $("#quotations").show();
                $("#hold_date").hide();
                $("#quotations_input").prop("required", true);
            }
            if (val == 3) {
                $("#quotations").show();
                $("#hold_date").hide();
                $("#quotations_input").prop("required", true);
            } else {
                $("#reasons").hide();
                $("#hold_date").hide();
                $("#quotations").hide();
            }

            $("#status").on("change", function() {
                var val = $(this).val();
                // alert(val)
                if (val == 5) {
                    $("#reasons").show();
                    $("#hold_date").hide();
                    $("#reasons_input").prop("required", true);
                } else if (val == 10) {
                    $("#hold_date").show();
                    $("#hold_date_input").prop("required", true);
                } else if (val == 3) {
                    $("#quotations").show();
                    $("#hold_date").hide();
                    $("#quotations_input").prop("required", true);
                } else {
                    $("#reasons").hide();
                    $("#hold_date").hide();
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
                                    minDate: 0,
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

            $('#default_rate_of_exchange').prop('disabled', false);

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
                            url: "{{ route('autocomplete_city') }}",
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
                        minDate: 0,
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
                        $('#children_profit').prop("disabled", true);
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
                        $('#infant_profit').prop("disabled", true);
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
                            url: "{{ route('autocomplete_city') }}",
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
                        minDate: 0,
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

            var get_no_of_adults = parseInt("{{ $get_inquiry->no_of_adults }}")
            var get_no_of_children = parseInt("{{ $get_inquiry->no_of_children }}")
            var get_no_of_infant = parseInt("{{ $get_inquiry->no_of_infants }}")

            if (legs_count) {
                var nights = $('#hotel_nights' + legs_count).val();
                var hotel_qty = $('#hotel_qty' + legs_count).val();
                var hotel_cost_price = $('#hotel_cost_price' + legs_count).val();
                var hotel_selling_price = $('#hotel_selling_price' + legs_count).val();
                var check_in_date = $('#hotel_check_in' + legs_count).val();
                var days = moment(new Date(check_in_date)).add(nights, 'day').format('DD/MMM/Y')
                var check_out_date = $('#hotel_check_out' + legs_count).val(days);
            } else {
                var nights = $('#hotel_nights' + append_count).val();
                var hotel_qty = $('#hotel_qty' + append_count).val();
                var hotel_cost_price = $('#hotel_cost_price' + append_count).val();
                var hotel_selling_price = $('#hotel_selling_price' + append_count).val();
                var check_in_date = $('#hotel_check_in' + append_count).val();
                var days = moment(new Date(check_in_date)).add(nights, 'day').format('DD/MMM/Y')
                // alert(days);
                var check_out_date = $('#hotel_check_out' + append_count).val(days);
            }
            var service_type = $('#service_type').val();

            if (service_type == 'service_level') {

                if (legs_count) {
                    var cal_of_hotel_cp = ((nights * hotel_qty) * hotel_cost_price)
                    var cal_of_hotel_sp = ((nights * hotel_qty) * hotel_selling_price)
                    const hotel_addons_array = $("#hotel_addon" + legs_count).val();
                    if (hotel_addons_array!="") {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('get_addons') }}/" + hotel_addons_array,
                            success: function(response) {
                                var addon_selling_price =  (response.selling_price*nights)*hotel_qty
                                var addon_cost_price =  (response.cost_price*nights)*hotel_qty
                                var final_total_cp = cal_of_hotel_cp + addon_cost_price;
                                var final_total_sp = cal_of_hotel_sp + addon_selling_price;
                                $("#get_sub_total_legs_cp" + legs_count).val(final_total_cp)
                                $("#get_sub_total_legs_sp" + legs_count).val(final_total_sp)
                                // End put single value in total cp and sp
                                get_hotel_final_calculation(append_count);
                            }
                        });
                    } else {
                        var final_total_cp = cal_of_hotel_cp;
                        var final_total_sp = cal_of_hotel_sp;
                        $("#get_sub_total_legs_cp" + legs_count).val(final_total_cp)
                        $("#get_sub_total_legs_sp" + legs_count).val(final_total_sp)
                        // End put single value in total cp and sp
                        get_hotel_final_calculation(append_count);
                    }

                } else {
                    var cal_of_hotel_cp = ((nights * hotel_qty) * hotel_cost_price)
                    var cal_of_hotel_sp = ((nights * hotel_qty) * hotel_selling_price)
                    // var addon_selling_price = 0
                    // var addon_cost_price = 0
                    // start calculation of addons
                    var hotel_addons_array = $("#hotel_addon" + append_count).val();

                    if (hotel_addons_array!="") {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('get_addons') }}/" + hotel_addons_array,
                            success: function(response) {
                                var addon_selling_price = (response.selling_price*nights)*hotel_qty
                                var addon_cost_price = (response.cost_price*nights)*hotel_qty
                                var final_total_cp = cal_of_hotel_cp + addon_cost_price;
                                var final_total_sp = cal_of_hotel_sp + addon_selling_price;
                                // alert(final_total_cp+'final_total_cp')
                                // alert(final_total_sp+'final_total_sp')
                                $("#get_sub_total_legs_cp" + append_count).val(final_total_cp)
                                $("#get_sub_total_legs_sp" + append_count).val(final_total_sp)
                                 // calling Final Calculation Function
                                 get_hotel_final_calculation(append_count);
                            }
                        });
                    } else {
                        var final_total_cp = cal_of_hotel_cp;
                        var final_total_sp = cal_of_hotel_sp;
                        // alert(final_total_sp);
                        // start put single value in total cp and sp
                        $("#get_sub_total_legs_cp" + append_count).val(final_total_cp)
                        $("#get_sub_total_legs_sp" + append_count).val(final_total_sp)
                        // End put single value in total cp and sp


                        // calling Final Calculation Function
                        get_hotel_final_calculation(append_count);
                    }

                }


                // calling Final Calculation Function
                get_hotel_final_calculation(append_count);


            }
            get_profit_calculation();
        }

        function get_hotel_final_calculation(append_count) {
                // start final Calculation of putting all value in Total Cp And Total SP
                 var total_sum_of_all_legs_sp = 0;
                var total_sum_of_all_legs_cp = 0;
                $('.get_sub_total_legs_cp' + append_count).each(function(index, element) {
                    let subTotal = $(element).val();
                    total_sum_of_all_legs_cp += parseFloat(subTotal);
                });

                $('.get_sub_total_legs_sp' + append_count).each(function(index, element) {
                    let subTotal = $(element).val();
                    total_sum_of_all_legs_sp += parseFloat(subTotal);
                });
                // alert(total_sum_of_all_legs_cp+'total_sum_of_all_legs_cp');
                // alert(total_sum_of_all_legs_sp+'total_sum_of_all_legs_sp');
                $("#hotel_total_cost_price" + append_count).val(total_sum_of_all_legs_cp)
                $("#hotel_sub_total" + append_count).val(total_sum_of_all_legs_sp)
                var hotel_discount = $("#hotel_discount" + append_count).val() || 0;
                var after_dicount = total_sum_of_all_legs_sp - hotel_discount;
                $("#hotel_total" + append_count).val(after_dicount)
                // End final Calculation of putting all value in Total Cp And Total SP
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
                //Selected rate of exchange
                var rate = $("#default_rate_of_exchange").val();

                var total_cost_price_sum_sl = 0
                var total_selling_price_sum_sl = 0
                //                 alert(total_cost_price_sum_sl);
                var total_sum_sl = 0;

                //Hotel total sum cost for service level
                var hotel_total_cost_price_sl = parseInt($('.hotel_total_cost_price_sum').val()) || 0;
                var hotel_total_selling_price_sl = parseInt($('.hotel_total_selling_price_sum').val()) || 0;
                var hotel_total_sum = parseInt($('.hotel_total_sum').val()) || 0;

                //Hotel total exchanged cost
                var hotel_exchanged_total_cost_sl = hotel_total_cost_price_sl * rate;
                var hotel_exchanged_total_selling_sl = hotel_total_sum * rate;

                //Visa total sum cost for service level
                var visa_total_cost_price_sl = parseInt($('.visa_total_cost_price_sum').val()) || 0;
                var visa_total_selling_price_sl = parseInt($('.visa_total_selling_price_sum').val()) || 0;
                var visa_total_sum = parseInt($('.visa_total_sum').val()) || 0;

                //Visa total exchanged cost
                var visa_exchanged_total_cost_sl = visa_total_cost_price_sl * rate;
                var visa_exchanged_total_selling_sl = visa_total_sum * rate;

                //Air Ticket total sum cost for service level
                var airline_total_cost_price_sl = parseInt($('.airline_total_cost_price_sum').val()) || 0;
                var airline_total_selling_price_sl = parseInt($('.airline_total_selling_price_sum').val()) || 0;
                var airline_total_sum = parseInt($('.airline_total_sum').val()) || 0;

                //Land Services total sum cost for service level
                var land_total_cost_price_sl = parseInt($('.land_total_cost_price_sum').val()) || 0;
                var land_total_selling_price_sl = parseInt($('.land_total_selling_price_sum').val()) || 0;
                var land_total_sum = parseInt($('.land_total_sum').val()) || 0;

                //Visa total exchanged cost
                var land_exchanged_total_cost_sl = land_total_cost_price_sl * rate;
                var land_exchanged_total_selling_sl = land_total_sum * rate;

                total_cost_price_sum_sl = (hotel_exchanged_total_cost_sl + visa_exchanged_total_cost_sl +
                    airline_total_cost_price_sl + land_exchanged_total_cost_sl);
                total_selling_price_sum_sl = (hotel_exchanged_total_selling_sl + visa_exchanged_total_selling_sl +
                    airline_total_sum + land_exchanged_total_selling_sl);

                //                alert(land_total_selling_price_sl);
                //                $('.total_cost_price_sum').each(function(index, element) {
                //                    total_cost_price_sum_sl += parseInt($(element).val()) || 0
                //                });
                //                $('.total_selling_price_sum').each(function(index, element) {
                //                    total_selling_price_sum_sl += parseInt($(element).val()) || 0
                //                });
                total_sum_sl = total_selling_price_sum_sl;

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
                $('#visa_adult_total_cost_price' + append_count).val((adult_cost_price - discount_divide) *
                    get_no_of_adults) || 0;
                $('#visa_children_total_cost_price' + append_count).val((children_cost_price - discount_divide) *
                    get_no_of_children) || 0;
                $('#visa_infant_total_cost_price' + append_count).val((infant_cost_price - discount_divide) *
                    get_no_of_infant) || 0;

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
                var infant_airline_selling_price = parseFloat($('#infant_airline_selling_price' +
                        airline_calculate_count)
                    .val()) || 0;

                var adult_airline_cost_price = parseFloat($('#adult_airline_cost_price' + airline_calculate_count)
                    .val()) || 0;
                var children_airline_cost_price = parseFloat($('#children_airline_cost_price' +
                    airline_calculate_count).val()) || 0;
                var infant_airline_cost_price = parseFloat($('#infant_airline_cost_price' + airline_calculate_count)
                    .val()) || 0;

                var airline_sub_total = (adult_airline_selling_price * get_no_of_adults) + (
                        children_airline_selling_price *
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
                get_profit_calculation();
                // }
            } else {
                var adult_total_cost_price_sum = 0;
                var children_total_cost_price_sum = 0;
                var infant_total_cost_price_sum = 0;
                $('.adult_land_services_sum_cost_price' + append_count).each(function(index, element) {
                    var adult_cost_price_all = parseInt($(element).val()) || 0;
                    adult_total_cost_price_sum = adult_total_cost_price_sum + adult_cost_price_all;
                });
                //                $('.children_land_services_sum_cost_price' + append_count).each(function(index, element) {
                //                    var children_cost_price_all = parseInt($(element).val()) || 0;
                //                    children_total_cost_price_sum = children_total_cost_price_sum + children_cost_price_all;
                //                });
                //                $('.infant_land_services_sum_cost_price' + append_count).each(function(index, element) {
                //                    var infant_cost_price_all = parseInt($(element).val()) || 0;
                //                    infant_total_cost_price_sum = infant_total_cost_price_sum + infant_cost_price_all;
                //                });
                // alert(total_cost_price_sum);
                var total_cost_price_sum = (adult_total_cost_price_sum);
                // // alert(sum)
                var land_services_discount = parseFloat($('#land_services_discount' + append_count).val()) ||
                    0;
                var discount_divide = land_services_discount / 3;
                if (land_services_calculate_count) {
                    var get_cp_adult = $('#adult_land_cost_price' + land_services_calculate_count).val();
                    //                    var get_cp_children = $('#children_land_cost_price' + land_services_calculate_count).val();
                    //                    var get_cp_infant = $('#infant_land_cost_price' + land_services_calculate_count).val();
                    $('#land_services_adult_total_cost_price' + land_services_calculate_count).val(
                        (get_cp_adult) -
                        discount_divide) || 0;
                    //                    $('#land_services_children_total_cost_price' + land_services_calculate_count).val(
                    //                        (get_cp_children * get_no_of_children) -
                    //                        discount_divide) || 0;
                    //                    $('#land_services_infant_total_cost_price' + land_services_calculate_count).val(
                    //                        (get_cp_infant * get_no_of_infant) -
                    //                        discount_divide) || 0;
                } else {
                    var get_cp_adult = $('#adult_land_cost_price' + append_count).val();
                    //                    var get_cp_children = $('#children_land_cost_price' + append_count).val();
                    //                    var get_cp_infant = $('#infant_land_cost_price' + append_count).val();
                    $('#land_services_adult_total_cost_price' + append_count).val((get_cp_adult) -
                        discount_divide) || 0;
                    //                    $('#land_services_children_total_cost_price' + append_count).val((get_cp_children *
                    //                            get_no_of_children) -
                    //                        discount_divide) || 0;
                    //                    $('#land_services_infant_total_cost_price' + append_count).val((get_cp_infant * get_no_of_infant) -
                    //                        discount_divide) || 0;
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
                        minDate: 0,
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
                        minDate: 0,

                    });
                    $('.livesearch_hotel_city').select2({
                        placeholder: 'Select',
                        ajax: {
                            url: "{{ route('autocomplete_city') }}",
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
                    console.log(response.data);
                    $("#rmv_btn").html('Remove Row');
                    $('.js-example-basic-multiple' + legs_count).select2()
                    $('.select2' + legs_count).select2({});
                    $('.fc-datepicker' + legs_count).datepicker({
                        showOtherMonths: true,
                        selectOtherMonths: true,
                        dateFormat: 'd/M/y',
                        minDate: 0,
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
                        $('#append_airline_destination' + get_append_count_modal).html(
                            response
                            .parsing_legs);
                        $('.select2' + get_append_count_modal).select2({});
                        $('.fc-datepicker' + get_append_count_modal).datepicker({
                            showOtherMonths: true,
                            selectOtherMonths: true,
                            dateFormat: 'd/M/y',
                            minDate: 0,
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
                    //                    alert(response.room_type);
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
                    //                    alert(response);
                    //    console.log(response);
                    $("#land_services_route" + append_count).html(response.land_services);
                    $("#transport" + append_count).html(response.get_transport_options);
                    $("#land_services_cost_price" + append_count).val(response.cost_price);

                }
            });
            get_profit_calculation()
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
                        minDate: 0,
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

        function customer_verification(q_id) {
            Swal.fire({
                title: 'Mark quotation as approved from customer?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.location.href = '{{ url('customer_verification') }}/' + q_id;
                } else if (result.isDenied) {

                }
            })

        }

        function edit_quotation(inq_id, q_id) {
            Swal.fire({
                title: 'Edit Quotation',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.location.href = '{{ url('edit_quotation_original') }}/' + inq_id + '/' + q_id;
                } else if (result.isDenied) {

                }
            })

        }
    </script>
@endpush
