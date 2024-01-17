<style>
    .image-link {
        cursor: -webkit-zoom-in;
        cursor: -moz-zoom-in;
        cursor: zoom-in;
    }


    /* This block of CSS adds opacity transition to background */
    .mfp-with-zoom .mfp-container,
    .mfp-with-zoom.mfp-bg {
        opacity: 0;
        -webkit-backface-visibility: hidden;
        -webkit-transition: all 0.3s ease-out;
        -moz-transition: all 0.3s ease-out;
        -o-transition: all 0.3s ease-out;
        transition: all 0.3s ease-out;
    }

    .mfp-with-zoom.mfp-ready .mfp-container {
        opacity: 1;
    }

    .mfp-with-zoom.mfp-ready.mfp-bg {
        opacity: 0.8;
    }

    .mfp-with-zoom.mfp-removing .mfp-container,
    .mfp-with-zoom.mfp-removing.mfp-bg {
        opacity: 0;
    }



    /* padding-bottom and top for image */
    .mfp-no-margins img.mfp-img {
        padding: 0;
    }

    /* position of shadow behind the image */
    .mfp-no-margins .mfp-figure:after {
        top: 0;
        bottom: 0;
    }

    /* padding for main container */
    .mfp-no-margins .mfp-container {
        padding: 0;
    }



    /* aligns caption to center */
    .mfp-title {
        text-align: center;
        padding: 6px 0;
    }

    .image-source-link {
        color: #DDD;
    }


    body {
        -webkit-backface-visibility: hidden;
        padding: 10px 30px;
        font-family: "Calibri", "Trebuchet MS", "Helvetica", sans-serif;
    }
</style>

<div id="modaldemo1" data-bs-backdrop='static' class="modal fade bd-example-modal-xl" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Generate Quotation For Inquiry# <span id="modal_title_inq_no"
                        class="badge-success" style="padding: 5px;border-radius: 10px"></span></h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 1200px">
                @php
                    $services = App\other_service::where('parent_id', null)->get();
                @endphp
                {{-- <label for="">Assign Services And Sub Services</label> --}}
                <form method="POST" action="{{ url('assign_services_department') }}">

                    <div class="card text-left">
                        <img class="card-img-top" src="holder.js/100px180/" alt="">
                        <div class="card-body">
                            <h4 class="card-title">Basic Information</h4>
                            <div class="row">
                                <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                    <div class="form-group">
                                        <label class="form-control-label">Customer Name:</label>
                                        <label class="form-control-label"><b id="customer_name"></b></label>
                                    </div>
                                </div>
                                <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                    <div class="form-group">
                                        <label class="form-control-label">Customer Phone No:</label>
                                        <label class="form-control-label"><b id="customer_cell"></b></label>
                                    </div>
                                </div>
                                <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                    <div class="form-group">
                                        <label class="form-control-label">Inquiry Id:</label>
                                        <label class="form-control-label"><b id="customer_inquiry_id">-</b></label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-4">
                                <div class="col-lg-4 mg-t-20 mg-lg-t-0 ">
                                    <div class="form-group">
                                        <label class="form-control-label">Services Name:</label>
                                        <label class="form-control-label"><b id="services_name"></b></label>
                                    </div>
                                </div>
                                <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                    <div class="form-group">
                                        <label class="form-control-label">No Of Persons:</label>
                                        <label class="form-control-label"><b id="no_of_persons"></b></label>
                                    </div>
                                </div>
                                <input type="hidden" id="services_id">
                                <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                    <div class="form-group">
                                        <label class="form-control-label">Travel Date</label>
                                        <label class="form-control-label"><b id="travel_date"></b></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="inquiry_id" id="inquiry_id">
                    <hr>
                    <div class="card ">
                        <img class="card-img-top" src="holder.js/100px180/" alt="">
                        <div class="card-body" id="card_body_append">

                            <div class="table-responsive" id="table-responsive_append">
                                <table class="table table-striped">
                                    <thead id="">
                                        <tr>
                                            <th>#</th>
                                            <th>Description</th>
                                            <th id="feild_1"></th>
                                            <th id="feild_2"></th>
                                            <th id="feild_3"></th>
                                            <th id="feild_4"></th>
                                            <th id="feild_5"></th>
                                            <th id="feild_6"></th>
                                            <th id="feild_7"></th>
                                            <th id="feild_8"></th>
                                            <th id="feild_9"></th>
                                            <th id="feild_10"></th>
                                            <th id="feild_11"></th>
                                            <th id="feild_12"></th>
                                            <th id="feild_13"></th>
                                            <th id="feild_14"></th>
                                            <th id="feild_15"></th>
                                            <th id="feild_16"></th>

                                            {{-- <th><i class="fa fa-trash"></i></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody id="body_row">
                                        <tr>
                                            <td></td>
                                            <td>
                                                <select style="width: 200px" name="sub_services" id="sub_services"
                                                    class="form-control js-example-basic-single" style="width: 100%">
                                                    <option value="">Select</option>
                                                </select>
                                            <td id="input_feild_1"></td>
                                            <td id="input_feild_2"></td>
                                            <td id="input_feild_3"></td>
                                            <td id="input_feild_4"></td>
                                            <td id="input_feild_5"></td>
                                            <td id="input_feild_6"></td>
                                            <td id="input_feild_7"></td>
                                            <td id="input_feild_8"></td>
                                            <td id="input_feild_9"></td>
                                            <td id="input_feild_10"></td>
                                            <td id="input_feild_11"></td>
                                            <td id="input_feild_12"></td>
                                            <td id="input_feild_13"></td>
                                            <td id="input_feild_14"></td>
                                            <td id="input_feild_15"></td>
                                            <td id="input_feild_16"></td>

                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-indigo">Create</button>
                </form>
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="modaldemo2" class="modal fade bd-example-modal-xl " role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Select From Inventory</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                @php
                    $services = App\other_service::where('parent_id', null)->get();
                    $hotels = App\hotel_inventory::all();
                @endphp
                {{-- <label for="">Assign Services And Sub Services</label> --}}
                <form method="POST" action="{{ url('assign_services_department') }}">


                    <div class="card ">
                        <img class="card-img-top" src="holder.js/100px180/" alt="">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div id="append_hotel_modal_table">
                                    <span>No Records Found</span>
                                </div>
                            </div>
                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-indigo">Create</button>
                </form>
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Airline Modal --}}
<div id="modaldemo3" class="modal fade bd-example-modal-xl " role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-white badge badge-success" id="airline_name_modal"></h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                @php
                    $services = App\other_service::where('parent_id', null)->get();
                    $airlines = App\airline_inventory::all();
                @endphp
                {{-- <label for="">Assign Services And Sub Services</label> --}}
                <form method="POST" action="{{ url('assign_services_department') }}">
                    <div class="card ">
                        <img class="card-img-top" src="holder.js/100px180/" alt="">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div id="append_airline_inv">
                                    <span>No Records Found</span>
                                </div>
                            </div>
                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-indigo">Create</button>
                </form>
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="modaldemo4" class="modal fade bd-example-modal-lg " role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Change Quote Status</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                {{-- <label for="">Assign Services And Sub Services</label> --}}
                <form method="POST" action="{{ url('change_quote_status') }}">
                    <input type="hidden" name="quote_id" id="quote_status_id">
                    <div class="form-group">
                        @csrf
                        <label for="">Select Status</label>
                        <select class="form-control " name="status" id="">
                            <option value="">Select</option>
                            <option value="6">Send To Approval</option>
                            <option value="5">Cancelled</option>
                        </select>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-indigo">Create</button>
                </form>
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- parsing_modal --}}
<div id="modaldemo5" class="modal fade bd-example-modal-lg " role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Get Ticket Details From Parsing </h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="append_count_modal_parse">
                <input type="hidden" id="airline_inv_count">
                <div id="inv_id_append">

                </div>
                {{-- <label for="">Assign Services And Sub Services</label> --}}
                <form method="POST" action="{{ url('change_quote_status') }}">
                    <input type="hidden" name="quote_id" id="quote_status_id">
                    @csrf
                    <div class="form-group">
                        <label for="">Enter Parsing Code</label>
                        <textarea type="text" style="height: 150px;" id="parsing_details" name="parsing_details" placeholder=""
                            class="form-control"></textarea>
                    </div>

            </div>
            <div class="modal-footer">
                <button id="btn_parse" type="button" class="btn btn-indigo">Parse</button>
                </form>
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- rates_modal --}}
<div id="modaldemo6" class="modal fade bd-example-modal-lg " role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="hotel_rates_title">Get Airline Rates</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="append_count_modal_parse">
                <input type="hidden" id="airline_inv_count">
                <div id="append_airline_rates_modal">

                </div>
                {{-- <label for="">Assign Services And Sub Services</label> --}}

            </div>
            <div class="modal-footer">
                <button id="btn_parse" type="button" class="btn btn-indigo">Parse</button>

                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Pay Modal  --}}

<div id="modaldemo7" class="modal fade bd-example-modal-lg " role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Pay Now</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="append_count_modal_parse">
                <input type="hidden" id="airline_inv_count">
                <div id="inv_id_append">

                </div>
                {{-- <label for="">Assign Services And Sub Services</label> --}}
                <form method="POST" enctype="multipart/form-data" action="{{ url('pay_quotation_amount') }}">
                    <input type="hidden" name="quote_pay_id" id="quote_pay_id">
                    <input type="hidden" name="pay_services_type" id="pay_services_type">
                    <input type="hidden" name="pay_quote_detail_id" id="pay_quote_detail_id">
                    <input type="hidden" name="pay_inq_id" id="pay_inq_id">
                    @csrf
                    <div class="form-group">
                        <label for="">Select Service</label>
                        <select class="form-control select2" style="width: 100%;" required multiple name="services_type[]" id="pay_services_append">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Total Amount</label>
                        <input type="text" disabled class="form-control" name="service_amount" id="total_amount">
                    </div>

                    <div class="form-group">
                        <label for="">Attachment</label>
                        <input type="file" class="form-control" name="image_file" id="image_file">
                    </div>
                    <div class="form-group">
                        <label for="">Payment Type</label>
                        <select class="form-control" onchange="onchange_payment_type()" name="payment_type"
                            id="payment_type">
                            <option value="Cash">Cash</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Online">Online</option>
                        </select>
                    </div>
                    <div class="form-group" id="d_bank">
                        <label for="">Bank Name</label>
                        <select class="form-control" name="bank_name" id="bank_name">
                            <option value="Meezan Bank">Meezan Bank</option>
                            <option value="Faysal Bank">Faysal Bank</option>
                            <option value="Habib Bank Limited">Habib Bank Limited</option>
                            <option value="Habib Metro Politan">Habib Metro Politan</option>
                        </select>
                    </div>
                    <div class="form-group" id="d_account_number">
                        <label for="">Account Number</label>
                        <input type="text" class="form-control" name="account_number" id="account_number">
                    </div>
                    <div class="form-group" id="d_cheque_no">
                        <label for="">Cheque Number</label>
                        <input type="text" class="form-control" name="cheque_no" id="cheque_no">
                    </div>
                    <div class="form-group">
                        <label for="">Enter Amount</label>
                        <input type="text" class="form-control" name="enter_amount" id="">
                    </div>

            </div>
            <div class="modal-footer">
                <button id="btn_parse" type="submit" class="btn btn-indigo">Pay</button>
                </form>
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="modaldemo8" class="modal fade bd-example-modal-lg " role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">View Details</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="append_count_modal_parse">
                <input type="hidden" id="airline_inv_count">
                <div id="inv_id_append">

                </div>
                {{-- <label for="">Assign Services And Sub Services</label> --}}
                <form method="POST" action="{{ url('update_receiving_number') }}">


                    <div class="form-group">
                        <label for="">Amount</label>
                        <input type="text" disabled class="form-control" name="ac_amount" id="ac_amount">
                    </div>
                    <div class="form-group">
                        <label for="">Payment Type</label>
                        <input type="text" disabled class="form-control" name="ac_payment_type"
                            id="ac_payment_type">
                    </div>
                    @csrf
                    <div class="form-group" id="d_bank_name">
                        <label for="">Bank Name</label>
                        <input type="text" disabled class="form-control" name="ac_bank_name" id="ac_bank_name">
                    </div>
                    <div id="d_account_number_ac" class="form-group">
                        <label for="">Account Number</label>
                        <input type="text" disabled class="form-control" name="ac_account_number"
                            id="ac_account_number">
                    </div>
                    <input type="hidden" id="pay_id" name="pay_id">
                    <div id="d_cheque_number" class="form-group">
                        <label for="">Cheque Number</label>
                        <input type="text" disabled class="form-control" name="cheque_no" id="ac_cheque_no">
                    </div>
                    <div class="form-group">
                        <label for="">Enter Receiving Number</label>
                        <input type="text" class="form-control" name="receiving_number" id="ac_recieving_number">
                        @error('receiving_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="" style="text-align: center">Attachment</label>
                        <img src="" class="without-caption image-link" style="width: 100%;height: 200px"
                            id="attachment" alt="">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" id="view_pay_details_btn" class="btn btn-indigo">Update</button>
                </form>
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@push('scripts')
    <script>
        onchange_payment_type();

        function onchange_payment_type() {
            var p_type = $('#payment_type').val();
            if (p_type == "Cash") {
                $('#d_cheque_no').css('display', 'none');
                $('#d_bank').css('display', 'none');
                $('#d_account_number').css('display', 'none');
            } else {
                $('#d_cheque_no').css('display', 'block');
                $('#d_bank').css('display', 'block');
                $('#d_account_number').css('display', 'block');
            }

            if (p_type == 'Online') {
                $('#d_cheque_no').css('display', 'none');
            }
        }
        // Additional code for adding placeholder in search box of select2
        $(document).ready(function() {
            // $('.js-example-basic-single').select2();
            $(".js-example-basic-single").select2({
                dropdownParent: $("#modaldemo1")
            });
            $("#pay_services_append").select2({
                dropdownParent: $("#modaldemo7")
            });

        });

        $(document).ready(function() {
            $('#services').on('change', function() {
                var val = $(this).val();
                $.ajax({
                    url: "{{ url('get_sub_services') }}/" + val,
                    type: "GET",
                    success: function(data) {
                        $('#sub_services').html(data);
                    }
                });
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

        });
    </script>

    <script>
        // Get Already Customer

        $(document).ready(function() {
            $(".livesearch").select2({
                dropdownParent: $("#modaldemo1")
            });
            $('.js-example-basic-multiple').select2();
            $.fn.modal.Constructor.prototype._enforceFocus = function() {};

        });

        var counti = 0;





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
                            }
                        });
                    });
                }
            });

        }

        function remove(count_rmv) {
            // alert(counti)
            counti = counti - 1;
            $('.rmv' + count_rmv).remove();
        }
    </script>
@endpush
