@extends('layouts.master')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">
    <style>
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
    <h2 class="az-content-title" style="display: inline"> Inquiry Details & Quotation View <span
            class="badge badge-success fs-2">{{ $dec_inq_id }} </span> <span class="badge badge-info fs-5"><a
                href="{{ url('customers') }}"
                style="text-decoration: none;color: white;font-size:28px;">{{ $get_customer->customer_name }}</a></span><span>
            <a href="{{ url('inquiry/create') }}" class="btn btn-az-primary" style="float: right">Add Inquiry</a></span>
    </h2>
    <div class="row">
        <div class="col-md-12">
            <div class="card  bg-white">
                <img class="card-img-top" src="holder.js/100px180/" alt="">
                <div class="card-body">
                    <h4 class="card-title">Inquiry Details</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="fs-5">INQUIRY # <span class="badge badge-success fs-5">{{ $dec_inq_id }}</span>
                            </h6>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fs-5">CUSTOMER : <span class="badge badge-info fs-5"><a
                                        href="{{ url('customers') }}"
                                        style="text-decoration: none;color: white">{{ $get_customer->customer_name }}</a></span>
                            </h6>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fs-5">CONTACT : <span
                                    class="badge badge-info fs-5">{{ $get_customer->customer_cell }}</span></h6>
                        </div>
                        <div class="col-md-4">
                            @php
                                $get_inq_type = App\inquirytypes::where('type_id', $get_inquiry->inquiry_type)->first();
                            @endphp
                            <h6 class="fs-5">INQUIRY TYPE : <span
                                    class="badge badge-info fs-5">{{ $get_inq_type->type_name }}</span></h6>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fs-5">Requirement Date : <span
                                    class="badge badge-info fs-5">{{ $get_inquiry->travel_date }}</span></h6>
                        </div>
                        {{-- <div class="col-md-4">
                            <h6 class="fs-5">City : <span class="badge badge-info fs-5">{{ $get_inquiry->city }}</span>
                            </h6>
                        </div> --}}
                        {{-- <div class="col-md-4">
                            <h6 class="fs-5">Sale Reference : <span
                                    class="badge badge-info fs-5">{{ $get_inquiry->sales_reference }}</span></h6>
                        </div> --}}
                        <div class="col-md-4">
                            @php
                                $get_inq_type = App\inquirytypes::where('type_id', $get_inquiry->inquiry_type)->first();
                            @endphp
                            {{-- {{dd($get_latest_remarks)}} --}}
                            <h6 class="fs-5">Follow Up Date : <span class="badge badge-info fs-5">
                                    @if ($get_latest_remarks != null)
                                        {{ $get_latest_remarks->followup_date }}
                                    @else
                                        -
                                    @endif
                                </span></h6>
                        </div>
                        <div class="col-md-4">
                            @php
                                $get_campaign = App\campaign::where('id_campaigns', $get_inquiry->campaign_id)->first();
                                // dd($get_inquiry);
                            @endphp
                            <h6 class="fs-5">Campaign : <span
                                    class="badge badge-info fs-5">{{ $get_campaign?->campaign_name }}</span></h6>
                        </div>

                        <div class="col-md-12">

                            <h6 class="fs-5">No Of Persons : <span
                                    class="badge badge-info fs-5">Adults::{{ $get_inquiry->no_of_adults }}</span>

                                <span class="badge badge-info fs-5">Childrens::{{ $get_inquiry->no_of_children }}</span>
                                <span class="badge badge-info fs-5">Infants::{{ $get_inquiry->no_of_infants }}</span>
                            </h6>
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
                            <h6 class="fs-5">Services :
                                @foreach ($service_name as $name)
                                    <li class="mt-2">
                                        <span class="fs-5" style="font-weight: 500;">{{ $name }}</span> ::
                                        @foreach ($sub_service_name as $key => $sub_name)
                                            @if ($key > $key - 1)
                                                |
                                            @endif
                                            <span class="fs-5 text-secondary">{{ $sub_name }}</span>
                                        @endforeach
                                    </li>
                                @endforeach

                            </h6>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-12" style="">
            <div class="card bg-white">
                <input type="hidden" id="inv_id_hidden">
                <img class="card-img-top" src="holder.js/100px180/" alt="">
                <div class="card-body">
                    <h4 class="card-title "><u>Quotation Conversion</u></h4>
                    <p class="card-text"></p>
                    <form action="{{ url('create_quotation/conversion/' . \Crypt::encrypt($dec_inq_id)) }}" method="POST">
                        <div class="row d-none">
                            <div class="col-md-3">
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
                            <div class="col-md-3">
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
                                        <option @if(request()->type=="service_level") selected @endif value="service_level">Service Level (S.L)</option>
                                        <option @if(request()->type=="no_of_person") selected @endif value="no_of_person">No Of Person</option>
                                        <option @if(request()->type=="lum_sum") selected @endif value="lum_sum">Lum Sum</option>
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
                                    <button type="button" onclick="append_quotation_details()"
                                        class="btn btn-sm btn-success text-white">Add</button>
                                    <button type="button" onclick="reset_all()"
                                        class="btn btn-sm btn-danger text-white">Reset</button>
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
@endsection
@push('scripts')
    <script>
        function get_visa_rates(append_count) {
            var value = $('#visa_service' + append_count).val();
            // alert('ssd')
            $.ajax({
                url: "{{ url('get_visa_rates') }}/" + value,
                type: "GET",
                success: function(data) {
                    var service_type = $('#service_type').val();
                    if (service_type == "service_level") {
                        // $('#adult_visa_selling_price' + append_count).val(data.adult_s);
                        $('#adult_visa_cost_price' + append_count).val(data.adult_s);
                        $('#children_visa_cost_price' + append_count).val(data.child_s);
                        // $('#children_visa_selling_price' + append_count).val(data.child_s);
                        $('#infant_visa_cost_price' + append_count).val(data.infant_s);
                        // $('#infant_visa_selling_price' + append_count).val(data.infant_s);
                    } else {
                        $('#visa_adult_cost_price' + append_count).val(data.adult_s);
                        $('#visa_children_cost_price' + append_count).val(data.child_s);
                        $('#visa_infant_cost_price' + append_count).val(data.infant_s);
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

        function open_quote_status_modal(quote_id) {
            $('#modaldemo4').modal('show');
            $('#quote_status_id').val(quote_id)
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
                                    selectOtherMonths: true
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
        var append_quotation_count = 0;
        $('form').bind('submit', function() {
            $(this).find('#service_type').prop('disabled', false);
            $('.hotel_addon').each(function(index, element) {
                $(element).val("Select Addon");
            });
            $('.form-control').each(function(index, element) {
                $(element).prop("disabled", false);
            });

        });

        function append_quotation_details() {
            var sub_services = "{{ request()->type }}";
            var services = $("#services").val();
            var service_type = "{{ request()->type }}";
            var inq_id = "{{ $dec_inq_id }}";
            var q_id = "{{ request()->q_id }}";
            // alert(inq_id);
            $.ajax({
                type: "GET",
                url: "{{ url('/append_quotation_details_for_edit') }}/" + sub_services + '/' +
                    append_quotation_count +
                    '/' + service_type + '/' + legs_count + '/' + inq_id + '/' + q_id,
                success: function(response) {
                    $('#append_table').prepend(response.data);
                    $('#append_table').append(response.lum_sum);
                    $('#service_type').prop("disabled", true);
                    $('#default_rate_of_exchange').prop("disabled", true);
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
                    $('.fc-datepicker' + append_quotation_count).datepicker({
                        showOtherMonths: true,
                        selectOtherMonths: true
                    });
                    $('.fc-datepicker_to_date' + append_quotation_count).datepicker({
                        showOtherMonths: true,
                        selectOtherMonths: true,
                        minDate: 0 // This sets the minimum date to the current date
                    });
                    $('#submit_buttons').css('display', 'block');
                    append_quotation_count = append_quotation_count + 1;


                }
            });
        }

        append_quotation_details();

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
                            console.log(addon_selling_price)
                            if (addon_selling_price) {
                                const sum = addon_selling_price.reduce((acc, val) => acc + parseInt(val), 0);
                                console.log("Selected values:", addon_selling_price);
                                console.log("Sum:", sum);
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
                                    $('#hotel_sub_total' + append_count).val(hotel_sub_total.toFixed(2));
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
                                console.log("Sum:", sum);
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
                $('#hotel_total_cost_price' + append_count).val(hotel_total_cost_price * nights_count);
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

        }

        function get_profit_calculation() {
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


            var service_type = $('#service_type').val();
            if (service_type == 'no_of_person') {
                var get_adult_profit = parseInt($('#adult_profit').val()) || 0;
                var get_children_profit = parseInt($('#children_profit').val()) || 0;
                var get_infant_profit = parseInt($('#infant_profit').val()) || 0;
                $('#adult_selling_price').val(profit_adult_sum + get_adult_profit);
                $('#children_selling_price').val(profit_children_sum + get_children_profit);
                $('#infant_selling_price').val(profit_infant_sum + get_infant_profit);
                var get_adult_total_selling_price = parseInt($('#adult_selling_price').val());
                var get_children_total_selling_price = parseInt($('#children_selling_price').val());
                var get_infant_total_selling_price = parseInt($('#infant_selling_price').val());

                var grand_total = get_adult_total_selling_price + get_children_total_selling_price +
                    get_infant_total_selling_price;

                $('#grand_total').val(grand_total)
                $('#grand_total_html').html(grand_total + '/-')
            } else if (service_type == 'lum_sum') {
                var get_lum_sum_profit = parseInt($('#lum_sum_profit').val()) || 0;
                // alert(get_lum_sum_profit)
                $('#adult_selling_price').val(profit_adult_sum + get_lum_sum_profit);
                $('#children_selling_price').val(profit_children_sum + get_lum_sum_profit);
                $('#infant_selling_price').val(profit_infant_sum + get_lum_sum_profit);
                var get_adult_total_selling_price = parseInt($('#adult_selling_price').val());
                var get_children_total_selling_price = parseInt($('#children_selling_price').val());
                var get_infant_total_selling_price = parseInt($('#infant_selling_price').val());

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
                $('#visa_adult_total_cost_price' + append_count).val(adult_cost_price - discount_divide) || 0;
                $('#visa_children_total_cost_price' + append_count).val(children_cost_price - discount_divide) || 0;
                $('#visa_infant_total_cost_price' + append_count).val(infant_cost_price - discount_divide) || 0;

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
                        selectOtherMonths: true
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
                        selectOtherMonths: true
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
                    if (service_type == 'service_level') {
                        $('#airline_cost_price' + append_count).val(response.cost_price)
                        $('#airline_selling_price' + append_count).val(response.selling_price)
                        $('#modaldemo6').modal('hide')
                        airline_calculate(append_count);

                    } else {
                        var get_selling_price = response
                            .selling_price / $('#airline_no_of_adults' + append_count).val();
                        var get_cost_price = response
                            .cost_price / $('#airline_no_of_adults' + append_count).val();
                        $('#airline_adult_cost_price' + append_count).val(get_cost_price)
                        $('#airline_adult_selling_price' + append_count).val(get_selling_price)
                        $('#modaldemo6').modal('hide')
                        $('#airline_adult_selling_price' + append_count).trigger("change");

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

        function add_hotel_rates(append_count, hotel_rate_id) {
            $.ajax({
                type: "GET",
                url: "{{ url('add_hotel_rates') }}/" + hotel_rate_id,
                success: function(response) {
                    var service_type = $('#service_type').val();
                    if (service_type == 'service_level') {
                        $('#hotel_cost_price' + append_count).val(response.cost_price)
                        $('#hotel_selling_price' + append_count).val(response.selling_price)
                        $('#hotel_beds' + append_count).val(response.no_of_beds)
                        $('#modaldemo6').modal('hide')
                        hotel_calcualte(append_count);

                    } else {
                        // alert('sdds');
                        var get_selling_price = response
                            .selling_price / $('#hotel_no_of_adult' + append_count).val();
                        var get_cost_price = response
                            .cost_price / $('#hotel_no_of_adult' + append_count).val();
                        $('#hotel_adult_cost_price' + append_count).val(get_cost_price)
                        $('#hotel_beds' + append_count).val(response.no_of_beds)
                        $('#hotel_adult_selling_price' + append_count).val(get_selling_price)
                        $('#modaldemo6').modal('hide')
                        $('#hotel_adult_selling_price' + append_count).trigger("change");

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
                        $('#append_airline_destination' + get_append_count_modal).html(response
                            .parsing_legs);
                        $('.select2' + get_append_count_modal).select2({});
                        $('.fc-datepicker' + get_append_count_modal).datepicker({
                            showOtherMonths: true,
                            selectOtherMonths: true
                        });
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
                        selectOtherMonths: true
                    });
                    $('#fc-datepicker' + land_sl_count_new).datepicker({
                        showOtherMonths: true,
                        selectOtherMonths: true
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
            $('#service_type').prop("disabled", false);
            $('#default_rate_of_exchange').prop("disabled", false);
        }

        function remove_land_services_legs(rmv_land_count) {
            $('.rmv_land' + rmv_land_count).remove();
        }

        function onchange_ticket_type_airline(append_count) {
            // From _inventory
            var airline_id = $('#airline_name' + append_count).val();
            // alert(airline_id)
            var flight_class = $('#airline_flight_class' + append_count).val();
            if (airline_id.length > 0) {
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
                            url: "{{ url('get_airline_rates') }}/" + airline_id + '/' +
                                append_count + '/' + flight_class,
                            success: function(response) {
                                $('#append_airline_rates_modal').html(response.airline_inventory_table);
                                $('#airline_name_modal').html("Select Inventory From" + response
                                    .airline_name);
                                $('#modaldemo6').modal('show');
                                $('#airline_inv_count' + airline_inv_count).val(airline_inv_count);
                            }
                        });
                    } else if (result.isDenied) {
                        $('#modaldemo3').modal('hide');
                    }
                })
            }


        }


        function hotel_date_night(append_count) {
            hotel_calculate(append_count, legs_count)

        }
    </script>
@endpush
@push('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <!-- Include ClockPicker CSS and JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".time_picker").clockpicker({
                placement: 'bottom',
                align: 'left',
                autoclose: true,
                default: 'now',
                donetext: "Select",
                init: function() {

                },
                // ... other callback functions ...
            });
        });
    </script>
@endpush
