@extends('layouts.master')
@section('content')
    <div class="card card-body pd-10">
        <div class="az-content-breadcrumb">
            <span>My Jobs</span>
        </div>
        <h2 class="az-content-title" style="display: inline">My Jobs<span>
        </h2>
    </div>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">

                <div>
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="wd-10p">S.No</th>
                                <th class="wd-10p">Inquiry</th>
                                <th class="wd-20p">Customer</th>
                                <th class="wd-20p">Services</th>
                                <th>Department</th>
                                <th class="wd-20p">Assign By Status</th>
                                <th class="wd-20p">Assign By</th>
                                <th class="wd-20p">Team</th>
                                <th class="wd-20p">Inquiry Details</th>

                                {{-- <th class="wd-20p">Department</th> --}}
                                {{-- <th class="wd-10p">Status</th> --}}
                                <th class="wd-10p">Created At</th>
                                <th class="wd-10p">Updated At</th>
                                {{-- <th class="wd-10p">Operations</th> --}}
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($my_jobs as $key => $type)
                                <?php
                                $services_decode = json_decode($type->services_sub_services);
                                $primary_service_id = explode('/', $services_decode[0]);

                                $service_detail = App\other_service::where('id_other_services', $primary_service_id[0])->first();
                                ?>
                                <tr>

                                    <td>{{ $key + 1 }}</td>
                                    <td><span style="font-size:16px;">INQ#<b>{{ $type->inquiry_id }}</b></span> </td>
                                    <td><span style="font-size:16px;"><?= $type->customer_name ?></span></td>
                                    <td><?= $service_detail->service_name ?></td>
                                    <td><?= $type->type_name ?></td>


                                    <?php if ($type->assign_by == auth()->user()->id){?>
                                    <td> <span class="badge badge-success" style="font-size:14x;">Self Inquiry</span></td>
                                    <?php }else{

                                        $user_name = App\User::find($type->assign_by);
                                   ?>

                                    <td> <span class=" badge badge-info"
                                            style="font-size:18px;">{{ $user_name?->name }}</span></td>
                                    <?php }?>
                                    @if ($type->assign_by == auth()->user()->id)
                                        <td>My Self</td>
                                    @else
                                        <td>{{ get_user_name($type->assign_by) }}</td>
                                    @endif
                                    {{-- {{dd($type)}} --}}
                                    <td>{{ get_team_name($type->team_id) }}</td>
                                    <td>
                                        <a href="{{ url('create_quotation/' . \Crypt::encrypt($type->inquiry_id)) }}"
                                            style="color:#fff;" class="btn btn-rounded btn-success">View Details</a>
                                    </td>

                                    <td><?= date('d-m-Y', strtotime($type['created_at'])) ?></td>
                                    <td><?= date('d-m-Y', strtotime($type['updated_at'])) ?></td>


                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="wd-10p">S.No</th>
                                <th class="wd-10p">Inquiry</th>
                                <th class="wd-20p">Customer</th>
                                <th class="wd-20p">Services</th>
                                <th>Department</th>
                                <th class="wd-20p">Assign By Status</th>
                                <th class="wd-20p">Assign By</th>
                                <th class="wd-20p">Team</th>
                                <th class="wd-20p">Inquiry Details</th>

                                {{-- <th class="wd-20p">Department</th> --}}
                                {{-- <th class="wd-10p">Status</th> --}}
                                <th class="wd-10p">Created At</th>
                                <th class="wd-10p">Updated At</th>
                                {{-- <th class="wd-10p">Operations</th> --}}
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- card -->
        </div>
        <!-- col -->
    </div>
    {{-- </div><!-- az-content-body --> --}}

    {{-- All Quotes Start Modal  --}}
    @include('quotations.modals.modals')
    {{-- All Quotes End Modal  --}}
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#example2').DataTable();
        });

        // Search COde
        $('.livesearch').select2({
            placeholder: 'Select',
            ajax: {
                url: "{{ route('autocomplete_country') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.country_name + ' - ' + item.name,
                                id: item.country_name + ' - ' + item.name,
                            }
                        })
                    };
                },
                cache: true
            }
        });

        // Open Quote Modal
        function open_quote(inq_id) {
            $('#inquiry_id').val(inq_id);

            $.ajax({
                url: "{{ url('/get_inquiry_from_id') }}/" + inq_id,
                type: 'GET',
                success: function(data) {
                    $('#customer_name').html('<span class="badge badge-pill badge-success">' + data.customer
                        .customer_name + '</span>');
                    $('#customer_cell').html('<span class="badge badge-pill badge-success">' + data.customer
                        .customer_cell + '</span>');
                    $('#customer_inquiry_id').html('<span class="badge badge-pill badge-success">#' + data
                        .inquiry.id_inquiry + '</span>');
                    $('#travel_date').html('<span class="badge badge-pill badge-success">' + data.inquiry
                        .travel_date + '</span>');
                    $('#no_of_persons').html('<span class="badge badge-pill badge-success">Infants:' + data
                        .inquiry.no_of_infants +
                        '</span><span class="badge badge-pill badge-success">Children:' + data.inquiry
                        .no_of_children + '</span><span class="badge badge-pill badge-success">Adults:' +
                        data.inquiry.no_of_adults + '</span>');
                    $('#services_name').html(data.services_name);
                    $('#services_id').val(data.services_id);
                    $('#modal_title_inq_no').html(inq_id);
                    // console.log(data.services_id);
                    $('#sub_services').empty().append(data.sub_services);


                }
            });
            $('#modaldemo1').modal('show');
            $('#append_table').empty();
            var count = 0;
            $('.fc-datepicker').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true
            });

            $('#sub_services').on('change', function name(params) {
                var sub_services_id = $(this).val()
                // $('#append_table').empty()
                var services_id = $('#services_id').val();
                var get_inquiry_id = $('#inquiry_id').val();


                $.ajax({
                    // alert(count)
                    url: "{{ url('get_quotations_sub_services') }}/" + sub_services_id +
                        '/' + services_id + '/' + get_inquiry_id + '/' + count,
                    type: 'GET',
                    success: function(data) {
                        // alert(count);

                        if (data.services_name == "VISA") {
                            $('#feild_1').html("No Of Adults");
                            $('#feild_2').html("No Of Children");
                            $('#feild_3').html("No Of Infants");
                            $('#feild_4').html("Cost Price");
                            $('#feild_5').html("Selling Price");
                            // $('#feild_6').html("No Of Infants");
                            $('#feild_6').html("Sub Total");
                            $('#feild_7').html("Discount");
                            $('#feild_8').html("Total");
                            $('#feild_9').html('<i class="fa fa-trash"></i>');
                            $('#feild_10').html('<i class="fa fa-plus"></i>');
                            $('#input_feild_1').html(
                                '<input style="width:100px" type="number" onchange="calculate(' +
                                count +
                                ')" name="no_of_adults" id="no_of_adults" class="form-control">'
                            );
                            $('#input_feild_2').html(
                                '<input style="width:100px" type="number" name="no_of_children" id="no_of_children" onchange="calculate(' +
                                count + ')" class="form-control">'
                            );
                            $('#input_feild_3').html(
                                '<input style="width:100px" type="number" name="no_of_infants" id="no_of_infants" onchange="calculate(' +
                                count + ')" class="form-control">'
                            );
                            $('#input_feild_4').html(
                                '<input style="width:100px" type="number" name="cost_price" onchange="calculate(' +
                                count + ')" id="cost_price" class="form-control">'
                            );
                            $('#input_feild_5').html(
                                '<input style="width:100px" type="number" name="selling_price" onchange="calculate(' +
                                count + ')" id="selling_price" class="form-control">'
                            );
                            $('#input_feild_6').html(
                                '<input style="width:100px" type="number" id="sub_total" name="sub_total" onchange="calculate(' +
                                count + ')" class="form-control">'
                            );
                            $('#input_feild_7').html(
                                '<input style="width:100px" type="number" name="discount" id="discount" onchange="calculate(' +
                                count + ')" class="form-control">'
                            );
                            $('#input_feild_8').html(
                                '<input style="width:100px" type="number" id="total" name="total" onchange="calculate(' +
                                count + ')" class="form-control">'
                            );
                            $('#input_feild_9').html(
                                '<button type="button" class="btn btn-danger" onclick="remove_row(' +
                                count + ')">X</button>');
                            $('#input_feild_10').html(
                                '<button type="button" class="btn btn-success" onclick="add_row(' +
                                count + ',' + get_inquiry_id + ')">Add</button>');

                            $('#input_feild_11').hide();
                            $('#feild_11').hide();
                            $('#input_feild_12').hide();
                            $('#input_feild_13').hide();
                            $('#feild_12').hide();
                            $('#feild_13').hide();

                        }

                        if (data.services_name == "Hotel") {

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

                                    $.ajax({
                                        // alert(count)
                                        url: "{{ url('get_all_currency') }}",
                                        type: 'GET',
                                        success: function(data) {

                                            $('#input_feild_11').show();
                                            $('#feild_11').show();
                                            $('#input_feild_15').hide();
                                            $('#feild_15').hide();
                                            $('#input_feild_12').show();
                                            $('#feild_12').show();
                                            $('#input_feild_13').show();
                                            $('#feild_13').show();
                                            $('#input_feild_14').show();
                                            $('#feild_14').show();
                                            $('#feild_1').html("Hotel Name");
                                            $('#feild_2').html("Check In");
                                            $('#feild_3').html("Check Out");
                                            $('#feild_4').html("Select Room Type");
                                            $('#feild_5').html("Qty");
                                            $('#feild_6').html("Beds");
                                            $('#feild_7').html("Cost Price");
                                            $('#feild_8').html("Selling Price");
                                            // $('#feild_6').html("No Of Infants");
                                            $('#feild_9').html("Sub Total");
                                            $('#feild_10').html("Discount");
                                            $('#feild_11').html("Total");
                                            $('#feild_12').html("Exchange");
                                            $('#feild_13').html(
                                                '<i class="fa fa-trash"></i>');
                                            $('#feild_14').html(
                                                '<i class="fa fa-plus"></i>');
                                            $('#input_feild_1').html(
                                                '<input style="width:100px" type="text" id="hotel_name_static" onchange="hotel_calculate()" name="hotel_name" class="form-control">'
                                            );
                                            $('#input_feild_2').html(
                                                '<input style="width:100px" type="date" id="check_in" onchange="calculate()" name="check_in" class="form-control fc-datepicker">'
                                            );
                                            $('#input_feild_3').html(
                                                '<input style="width:100px" type="date" id="check_out" onchange="calculate()" name="check_out" class="form-control fc-datepicker">'
                                            );
                                            $('#input_feild_4').html(
                                                '<input style="width:100px" type="text" id="room_type_static" onchange="hotel_calculate()" name="room_type" class="form-control">'
                                            );
                                            $('#input_feild_5').html(
                                                '<input style="width:100px" type="number" id="qty" onchange="hotel_calculate()" name="qty" class="form-control">'
                                            );
                                            $('#input_feild_6').html(
                                                '<input style="width:100px" type="number" id="beds" onchange="calculate()" name="no_of_beds" class="form-control">'
                                            );

                                            $('#input_feild_7').html(
                                                '<input style="width:100px" type="number" id="cost_price" onchange="calculate()" name="cost_price" class="form-control">'
                                            );
                                            $('#input_feild_8').html(
                                                '<input style="width:100px" type="number" id="hotel_selling_price" onchange="hotel_calculate()" name="hotel_selling_price" class="form-control">'
                                            );
                                            $('#input_feild_9').html(
                                                '<input style="width:100px" type="number" id="hotel_sub_total" onchange="hotel_calculate()" name="sub_total" class="form-control">'
                                            );
                                            $('#input_feild_10').html(
                                                '<input style="width:100px" type="number" id="hotel_discount" onchange="hotel_calculate()" name="discount" class="form-control">'
                                            );
                                            $('#input_feild_11').html(
                                                '<input style="width:100px" type="number" id="hotel_total" onchange="hotel_calculate()" name="total" class="form-control">'
                                            );
                                            $('#input_feild_12').html(
                                                ' <select name="hotel_currency"  style="width:100px" onchange="onchange_get_curr_data()" id="hotel_currency" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' +
                                                data.currency + ' </select>'
                                            );
                                            $('#input_feild_13').html(
                                                '<button type="button" class="btn btn-danger" onclick="remove_row(' +
                                                count + ')">X</button>');

                                            $('#input_feild_14').html(
                                                '<button type="button" class="btn btn-success" onclick="add_row(' +
                                                count + ',' + get_inquiry_id +
                                                ')">Add</button>');
                                        }
                                    });
                                };
                            })


                            $('#feild_1').html("Hotel Name");
                            $('#feild_2').html("Beds");
                            $('#feild_3').html("Check In");
                            $('#feild_4').html("Check Out");
                            $('#feild_5').html("Cost Price");
                            $('#feild_6').html("Selling Price");
                            // $('#feild_6').html("No Of Infants");
                            $('#feild_7').html("Sub Total");
                            $('#feild_8').html("Discount");
                            $('#feild_9').html("Total");
                            $('#feild_10').html('<i class="fa fa-trash"></i>');
                            $('#feild_11').html('<i class="fa fa-plus"></i>');
                            $('#input_feild_1').html(
                                '<input style="width:100px" type="number" id="no_of_adults" onchange="calculate()" name="no_of_adults" class="form-control">'
                            );
                            $('#input_feild_2').html(
                                '<input style="width:100px" type="number" id="no_of_children" onchange="calculate()" name="no_of_children" class="form-control">'
                            );
                            $('#input_feild_3').html(
                                '<input style="width:100px" type="number" id="no_of_infants" onchange="calculate()" name="no_of_infants" class="form-control">'
                            );
                            $('#input_feild_4').html(
                                '<input style="width:100px" type="number" id="cost_price" onchange="calculate()" name="cost_price" class="form-control">'
                            );
                            $('#input_feild_5').html(
                                '<input style="width:100px" type="number" id="selling_price" onchange="calculate()" name="selling_price" class="form-control">'
                            );
                            $('#input_feild_6').html(
                                '<input style="width:100px" type="number" id="sub_total" onchange="calculate()" name="sub_total" class="form-control">'
                            );
                            $('#input_feild_7').html(
                                '<button type="button" class="btn btn-danger" onclick="remove_row(' +
                                count + ')">X</button>');

                        }


                        if (data.services_name == "Air-Ticket") {

                            Swal.fire({
                                title: "You Want To Access Our Inventory's Data",
                                showDenyButton: true,
                                showCancelButton: false,
                                confirmButtonText: 'Yes',
                                denyButtonText: `No`,
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {

                                    $('#modaldemo3').modal('show');

                                } else if (result.isDenied) {
                                    var services_id = $('#services_id').val();
                                    var get_inquiry_id = $('#inquiry_id').val();

                                    $('#input_feild_11').show();
                                    $('#feild_11').show();
                                    $('#input_feild_12').show();
                                    $('#feild_12').show();
                                    $('#input_feild_13').show();
                                    $('#feild_13').show();
                                    $('#feild_1').html("Airline Name");
                                    $('#feild_2').html("Arrival Date");
                                    $('#feild_3').html("Departure Date");
                                    $('#feild_4').html("Arrival Destination");
                                    $('#feild_5').html("Connecting From");
                                    $('#feild_6').html("Departure Destination");
                                    $('#feild_7').html("Flight Class");
                                    $('#feild_8').html("Qty");
                                    $('#feild_9').html("Cost Price");
                                    $('#feild_10').html("Selling Price");
                                    // $('#feild_6').html("No Of Infants");
                                    $('#feild_11').html("Sub Total");
                                    $('#feild_12').html("Discount");
                                    $('#feild_13').html("Total");
                                    $('#feild_14').html('<i class="fa fa-trash"></i>');
                                    $('#feild_15').html('<i class="fa fa-plus"></i>');
                                    $('#input_feild_1').html(
                                        '<input style="width:100px" type="text" id="airline_name" onchange="airline_calculate()" name="airline_name" class="form-control">'
                                    );
                                    $('#input_feild_2').html(
                                        '<input style="width:100px" type="date" id="arrival_date" onchange="airline_calculate()" name="arrival_date" class="form-control fc-datepicker">'
                                    );
                                    $('#input_feild_3').html(
                                        '<input style="width:100px" type="date" id="departure_date" onchange="airline_calculate()" name="departure_date" class="form-control">'
                                    );
                                    $('#input_feild_4').html(
                                        '<select name="arrival_destination" id="arrival_destination" class="form-control  livesearch"> </select>'
                                    );
                                    $('#input_feild_5').html(
                                        '<select name="mid_destination" id="mid_destination" class="form-control  livesearch"> </select>'
                                    );
                                    $('#input_feild_6').html(
                                        '<select name="departure_destination" id="departure_destination" class="form-control  livesearch"> </select>'
                                    );

                                    $('#input_feild_7').html(
                                        '<select name="flight_class" style="width:100px" class="form-control  js-example-basic-single "><option value="Economy">Economy</option><option value="Premium Economy">Premium Economy</option><option value="Buisness">Buisness</option><option value="First Class">First Class</option></select>'
                                    );
                                    $('#input_feild_8').html(
                                        '<input style="width:100px" type="number" id="airline_qty" onchange="airline_calculate()" name="airline_qty" class="form-control">'
                                    );
                                    $('#input_feild_9').html(
                                        '<input style="width:100px" type="number" id="airline_cost_price" onchange="airline_calculate()" name="airline_cost_price" class="form-control">'
                                    );
                                    $('#input_feild_10').html(
                                        '<input style="width:100px" type="number" id="airline_selling_price" onchange="airline_calculate()" name="airline_selling_price" class="form-control">'
                                    );
                                    $('#input_feild_11').html(
                                        '<input style="width:100px" type="number" id="airline_sub_total" onchange="airline_calculate()" name="sub_total" class="form-control">'
                                    );
                                    $('#input_feild_12').html(
                                        '<input style="width:100px" type="number" id="airline_discount" onchange="airline_calculate()" name="discount" class="form-control">'
                                    );
                                    $('#input_feild_13').html(
                                        '<input style="width:100px" type="number" id="airline_total" onchange="airline_calculate()" name="total" class="form-control">'
                                    );
                                    $('#input_feild_14').html(
                                        '<button type="button" class="btn btn-danger" onclick="remove_row(' +
                                        count + ')">X</button>');

                                    $('#input_feild_15').html(
                                        '<button type="button" class="btn btn-success" onclick="add_row(' +
                                        count + ',' + get_inquiry_id + ')">Add</button>');


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
                                }

                            })


                            // $('#feild_1').html("Hotel Name");
                            // $('#feild_2').html("Beds");
                            // $('#feild_3').html("Check In");
                            // $('#feild_4').html("Check Out");
                            // $('#feild_5').html("Cost Price");
                            // $('#feild_6').html("Selling Price");
                            // // $('#feild_6').html("No Of Infants");
                            // $('#feild_7').html("Sub Total");
                            // $('#feild_8').html("Discount");
                            // $('#feild_9').html("Total");
                            // $('#feild_10').html('<i class="fa fa-trash"></i>');
                            // $('#feild_11').html('<i class="fa fa-plus"></i>');
                            // $('#input_feild_1').html(
                            //     '<input style="width:100px" type="number" id="no_of_adults" onchange="calculate()" name="no_of_adults" class="form-control">'
                            // );
                            // $('#input_feild_2').html(
                            //     '<input style="width:100px" type="number" id="no_of_children" onchange="calculate()" name="no_of_children" class="form-control">'
                            // );
                            // $('#input_feild_3').html(
                            //     '<input style="width:100px" type="number" id="no_of_infants" onchange="calculate()" name="no_of_infants" class="form-control">'
                            // );
                            // $('#input_feild_4').html(
                            //     '<input style="width:100px" type="number" id="cost_price" onchange="calculate()" name="cost_price" class="form-control">'
                            // );
                            // $('#input_feild_5').html(
                            //     '<input style="width:100px" type="number" id="selling_price" onchange="calculate()" name="selling_price" class="form-control">'
                            // );
                            // $('#input_feild_6').html(
                            //     '<input style="width:100px" type="number" id="sub_total" onchange="calculate()" name="sub_total" class="form-control">'
                            // );
                            // $('#input_feild_7').html(
                            //     '<button type="button" class="btn btn-danger" onclick="remove_row(' +
                            //     count + ')">X</button>');

                        }
                        count = count + 1;
                        $('#append_table').append(data.table_details);
                    }
                });
            });
        }



        function remove_row(count) {
            // alert(count)
            if (count == 0) {
                for (let index = 0; index <= 15; index++) {
                    $('#input_feild_' + index).html(" ");
                }
                $('#remove_row' + count).hide();
            } else {
                for (let index = 0; index <= 15; index++) {
                    $('#input_feild_' + index + count).html(" ");
                }
                $('#remove_row' + count).hide();
            }
        }

        function remove_hotel_row(count) {
            for (let index = 0; index <= 10; index++) {
                $('#input_feild_' + index + count).html(" ");

            }
        }

        function add_row(count, inq_id) {
            // alert(count)
            count = count + 1;
            $("#card_body_append").append(
                ' <div class="table-responsive" id="table-responsive_append"> <table class="table table-striped"> <thead id=""> <tr> <th>#</th> <th>Description</th> <th id="feild_1' +
                count + '"></th> <th id="feild_2' + count + '"></th> <th id="feild_3' + count +
                '"></th> <th id="feild_4' + count + '"></th> <th id="feild_5' + count + '"></th> <th id="feild_6' +
                count + '"></th> <th id="feild_7' + count + '"></th> <th id="feild_8' + count +
                '"></th> <th id="feild_9' + count + '"></th> <th id="feild_10' + count +
                '"></th> {{-- <th><i class="fa fa-trash"></i></th> --}} </tr> </thead> <tbody id="body_row"> <tr> <td></td> <td> <select name="sub_services" id="sub_services' +
                count +
                '" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> </select> <td id="input_feild_1' +
                count + '"></td> <td id="input_feild_2' + count + '"></td> <td id="input_feild_3' + count +
                '"></td> <td id="input_feild_4' + count + '"></td> <td id="input_feild_5' + count +
                '"></td> <td id="input_feild_6' + count + '"></td> <td id="input_feild_7' + count +
                '"></td> <td id="input_feild_8' + count + '"></td> <td id="input_feild_9' + count +
                '"></td> <td id="input_feild_10' + count + '"></td> </td> </tr> </tbody> </table> </div> '
            );
            $(".livesearch").select2({
                dropdownParent: $("#modaldemo1")
            });
            $(".js-example-basic-single").select2({
                dropdownParent: $("#modaldemo1")
            });

            $.ajax({
                url: "{{ url('/get_inquiry_from_id') }}/" + inq_id,
                type: 'GET',
                success: function(data) {
                    // console.log(data.services_id);
                    $('#sub_services' + count).empty().append(data.sub_services);
                    $('#sub_services' + count).on('change', function name(params) {
                        var sub_services_id = $(this).val()
                        // $('#append_table').empty()

                        var services_id = $('#services_id').val();
                        var get_inquiry_id = $('#inquiry_id').val();
                        $.ajax({
                            // alert(count)
                            url: "{{ url('get_quotations_sub_services') }}/" +
                                sub_services_id +
                                '/' + services_id + '/' + get_inquiry_id + '/' +
                                count,
                            type: 'GET',
                            success: function(data) {

                                if (data.services_name == "VISA") {
                                    $('#feild_1' + count).html(
                                        "No Of Adults");
                                    $('#feild_2' + count).html(
                                        "No Of Children");
                                    $('#feild_3' + count).html(
                                        "No Of Infants");
                                    $('#feild_4' + count).html(
                                        "Cost Price");
                                    $('#feild_5' + count).html(
                                        "Selling Price");
                                    // $('#feild_6').html("No Of Infants");
                                    $('#feild_6' + count).html("Sub Total");
                                    $('#feild_7' + count).html("Discount");
                                    $('#feild_8' + count).html("Total");
                                    $('#feild_9' + count).html(
                                        '<i class="fa fa-trash"></i>');
                                    $('#feild_10' + count).html(
                                        '<i class="fa fa-plus"></i>');
                                    $('#input_feild_1' + count).html(
                                        '<input style="width:100px" type="number" onchange="calculate(' +
                                        count +
                                        ')" name="no_of_adults' +
                                        count +
                                        '" id="no_of_adults" class="form-control">'
                                    );
                                    $('#input_feild_2' + count).html(
                                        '<input style="width:100px" type="number" name="no_of_children" id="no_of_children' +
                                        count +
                                        '" onchange="calculate(' +
                                        count +
                                        ')" class="form-control">'
                                    );
                                    $('#input_feild_3' + count).html(
                                        '<input style="width:100px" type="number" name="no_of_infants" id="no_of_infants' +
                                        count +
                                        '" onchange="calculate(' +
                                        count +
                                        ')" class="form-control">'
                                    );
                                    $('#input_feild_4' + count).html(
                                        '<input style="width:100px" type="number" name="cost_price" onchange="calculate(' +
                                        count + ')" id="cost_price' +
                                        count +
                                        '" class="form-control">'
                                    );
                                    $('#input_feild_5' + count).html(
                                        '<input style="width:100px" type="number" name="selling_price" onchange="calculate(' +
                                        count + ')" id="selling_price' +
                                        count +
                                        '" class="form-control">'
                                    );
                                    $('#input_feild_6' + count).html(
                                        '<input style="width:100px" type="number" id="sub_total' +
                                        count +
                                        '" name="sub_total" onchange="calculate(' +
                                        count +
                                        ')" class="form-control">'
                                    );
                                    $('#input_feild_7' + count).html(
                                        '<input style="width:100px" type="number" name="discount" id="discount' +
                                        count +
                                        '" onchange="calculate(' +
                                        count +
                                        ')" class="form-control">'
                                    );
                                    $('#input_feild_8' + count).html(
                                        '<input style="width:100px" type="number" id="total' +
                                        count +
                                        '" name="total" onchange="calculate(' +
                                        count +
                                        ')" class="form-control">'
                                    );
                                    $('#input_feild_9' + count).html(
                                        '<button type="button" class="btn btn-danger" onclick="remove_row(' +
                                        count + ')">X</button>');
                                    $('#input_feild_10' + count).html(
                                        '<button type="button" class="btn btn-success" onclick="add_row(' +
                                        count + ',' + get_inquiry_id +
                                        ')">Add</button>');
                                    $('#input_feild_11').hide();
                                    $('#feild_11').hide();
                                    $('#input_feild_12').hide();
                                    $('#input_feild_13').hide();
                                    $('#feild_12').hide();
                                    $('#feild_13').hide();

                                }
                                if (data.services_name == "Hotel") {
                                    $('#input_feild_11').show();
                                    $('#feild_11').show();
                                    $('#input_feild_12').show();
                                    $('#feild_12').show();
                                    $('#input_feild_13').show();
                                    $('#feild_13').show();
                                    $('#feild_1').html("Hotel Name");
                                    $('#feild_2').html("Check In");
                                    $('#feild_3').html("Check Out");
                                    $('#feild_4').html("Select Room Type");
                                    $('#feild_5').html("Qty");
                                    $('#feild_6').html("Beds");
                                    $('#feild_7').html("Cost Price");
                                    $('#feild_8').html("Selling Price");
                                    // $('#feild_6').html("No Of Infants");
                                    $('#feild_9').html("Sub Total");
                                    $('#feild_10').html("Discount");
                                    $('#feild_11').html("Total");
                                    $('#feild_12').html('<i class="fa fa-trash"></i>');
                                    $('#feild_13').html('<i class="fa fa-plus"></i>');
                                    $('#input_feild_1').html(hotelname);
                                    $('#input_feild_2').html(
                                        '<input style="width:100px" type="date" value="' +
                                        from_date +
                                        '" id="check_in" onchange="calculate()" name="check_in" class="form-control fc-datepicker">'
                                    );
                                    $('#input_feild_3').html(
                                        '<input style="width:100px" type="date"  value="' +
                                        to_date +
                                        '" id="check_out" onchange="calculate()" name="check_out" class="form-control fc-datepicker">'
                                    );
                                    $('#input_feild_4').html(
                                        ' <select name="room_type" onchange="change_room_type(' +
                                        hotel_inv_id +
                                        ')" id="room_types" class="form-control js-example-basic-single" style="width: 150px"> <option value="">Select</option> ' +
                                        data.room_type + ' </select>'
                                    );
                                    $('#input_feild_5').html(
                                        '<input style="width:100px" type="number" id="qty" onchange="hotel_calculate()" name="qty" class="form-control">'
                                    );
                                    $('#input_feild_6').html(
                                        '<input style="width:100px" type="number" id="beds" onchange="calculate()" name="no_of_beds" class="form-control">'
                                    );

                                    $('#input_feild_7').html(
                                        '<input style="width:100px" type="number" id="cost_price" onchange="calculate()" name="cost_price" class="form-control">'
                                    );
                                    $('#input_feild_8').html(
                                        '<input style="width:100px" type="number" id="hotel_selling_price" onchange="hotel_calculate()" name="hotel_selling_price" class="form-control">'
                                    );
                                    $('#input_feild_9').html(
                                        '<input style="width:100px" type="number" id="hotel_sub_total" onchange="hotel_calculate()" name="sub_total" class="form-control">'
                                    );
                                    $('#input_feild_10').html(
                                        '<input style="width:100px" type="number" id="hotel_discount" onchange="hotel_calculate()" name="discount" class="form-control">'
                                    );
                                    $('#input_feild_11').html(
                                        '<input style="width:100px" type="number" id="hotel_total" onchange="hotel_calculate()" name="total" class="form-control">'
                                    );
                                    $('#input_feild_12').html(
                                        '<button type="button" class="btn btn-danger" onclick="remove_row(' +
                                        count + ')">X</button>');

                                    $('#input_feild_13').html(
                                        '<button type="button" class="btn btn-success" onclick="add_row(' +
                                        count + ',' + get_inquiry_id + ')">Add</button>'
                                    );
                                }
                                count = count + 1;
                                $('#append_table').append(data
                                    .table_details);
                            }
                        });
                        // Swal.fire('Changes are not saved', '', 'info')


                    });
                }
            });

        }
        $('#no_of_persons0').keydown(function() {
            alert('sdsd')
        })


        // Function to calculate and update the subtotal, total, and discount
        function calculate(count) {
            // alert('sdsd')
            if (count == 0) {
                var no_of_adults = parseInt($('#no_of_adults').val()) || 0;
                var no_of_children = parseInt($('#no_of_children').val()) || 0;
                var no_of_infants = parseInt($('#no_of_infants').val()) || 0;
                var selling_price = parseFloat($('#selling_price').val()) || 0;

                var sum = no_of_adults + no_of_children + no_of_infants;
                var sub_total = sum * selling_price;
                var discount = parseFloat($('#discount').val()) || 0;
                var total = sub_total - discount;

                $('#sub_total').val(sub_total.toFixed(2));
                $('#total').val(total.toFixed(2));
            } else {
                var no_of_adults = parseInt($('#no_of_adults' + count).val()) || 0;
                var no_of_children = parseInt($('#no_of_children' + count).val()) || 0;
                var no_of_infants = parseInt($('#no_of_infants' + count).val()) || 0;
                var selling_price = parseFloat($('#selling_price' + count).val()) || 0;

                var sum = no_of_adults + no_of_children + no_of_infants;
                var sub_total = sum * selling_price;
                var discount = parseFloat($('#discount' + count).val()) || 0;
                var total = sub_total - discount;

                $('#sub_total' + count).val(sub_total.toFixed(2));
                $('#total' + count).val(total.toFixed(2));
            }

        }


        // var hotel_inv_id = "";


        function add_hotel_inventory(key, hotelname, from_date, to_date, hotel_inv_id) {
            hotel_inv_id = hotel_inv_id;

            $.ajax({
                // alert(count)
                url: "{{ url('get_room_types_hotel_inv') }}/" + hotel_inv_id,
                type: 'GET',
                success: function(data) {
                    $('#modaldemo2').modal('hide');
                    $('#input_feild_11').show();
                    $('#feild_11').show();
                    $('#input_feild_14').hide();
                    $('#feild_14').hide();
                    $('#input_feild_15').hide();
                    $('#feild_15').hide();
                    $('#input_feild_12').show();
                    $('#feild_12').show();
                    $('#input_feild_13').show();
                    $('#feild_13').show();
                    $('#feild_1').html("Hotel Name");
                    $('#feild_2').html("Check In");
                    $('#feild_3').html("Check Out");
                    $('#feild_4').html("Select Room Type");
                    $('#feild_5').html("Qty");
                    $('#feild_6').html("Beds");
                    $('#feild_7').html("Cost Price");
                    $('#feild_8').html("Selling Price");
                    // $('#feild_6').html("No Of Infants");
                    $('#feild_9').html("Sub Total");
                    $('#feild_10').html("Discount");
                    $('#feild_11').html("Total");
                    $('#feild_12').html("Exchange");
                    $('#feild_13').html('<i class="fa fa-trash"></i>');
                    $('#feild_14').html('<i class="fa fa-plus"></i>');
                    $('#input_feild_1').html(hotelname);
                    $('#input_feild_2').html(
                        '<input style="width:100px" type="date" value="' + from_date +
                        '" id="check_in" onchange="calculate()" name="check_in" class="form-control fc-datepicker">'
                    );
                    $('#input_feild_3').html(
                        '<input style="width:100px" type="date"  value="' + to_date +
                        '" id="check_out" onchange="calculate()" name="check_out" class="form-control fc-datepicker">'
                    );
                    $('#input_feild_4').html(
                        ' <select name="room_type" onchange="change_room_type(' + hotel_inv_id +
                        ')" id="room_types" class="form-control js-example-basic-single" style="width: 150px"> <option value="">Select</option> ' +
                        data.room_type + ' </select>'
                    );
                    $('#input_feild_5').html(
                        '<input style="width:100px" type="number" id="qty" onchange="hotel_calculate()" name="qty" class="form-control">'
                    );
                    $('#input_feild_6').html(
                        '<input style="width:100px" type="number" id="beds" onchange="calculate()" name="no_of_beds" class="form-control">'
                    );

                    $('#input_feild_7').html(
                        '<input style="width:100px" type="number" id="cost_price" onchange="calculate()" name="cost_price" class="form-control">'
                    );
                    $('#input_feild_8').html(
                        '<input style="width:100px" type="number" id="hotel_selling_price" onchange="hotel_calculate()" name="hotel_selling_price" class="form-control">'
                    );
                    $('#input_feild_9').html(
                        '<input style="width:100px" type="number" id="hotel_sub_total" onchange="hotel_calculate()" name="sub_total" class="form-control">'
                    );
                    $('#input_feild_10').html(
                        '<input style="width:100px" type="number" id="hotel_discount" onchange="hotel_calculate()" name="discount" class="form-control">'
                    );
                    $('#input_feild_11').html(
                        '<input style="width:100px" type="number" id="hotel_total" onchange="hotel_calculate()" name="total" class="form-control">'
                    );
                    $('#input_feild_12').html(
                        ' <select name="hotel_currency"  style="width:100px" onchange="onchange_get_curr_data()" id="hotel_currency" class="form-control js-example-basic-single" style="width: 100%"> <option value="">Select</option> ' +
                        data.currency + ' </select>'
                    );
                    $('#input_feild_13').html(
                        '<button type="button" class="btn btn-danger" onclick="remove_row(' +
                        count + ')">X</button>');

                    $('#input_feild_14').html(
                        '<button type="button" class="btn btn-success" onclick="add_row(' +
                        count + ',' + get_inquiry_id + ')">Add</button>');
                }
            });
        }

        function add_airline_inventory(airline_name, arrival_date, departure_date, arrival_destination, connecting_from,
            departure_destination) {
            $('#modaldemo3').modal('hide');
            $('#input_feild_11').show();
            $('#feild_11').show();
            $('#input_feild_12').show();
            $('#feild_12').show();
            $('#input_feild_13').show();
            $('#feild_13').show();
            $('#feild_1').html("Airline Name");
            $('#feild_2').html("Arrival Date");
            $('#feild_3').html("Departure Date");
            $('#feild_4').html("Arrival Destination");
            $('#feild_5').html("Connecting From");
            $('#feild_6').html("Departure Destination");
            $('#feild_7').html("Flight Class");
            $('#feild_8').html("Qty");
            $('#feild_9').html("Cost Price");
            $('#feild_10').html("Selling Price");
            // $('#feild_6').html("No Of Infants");
            $('#feild_11').html("Sub Total");
            $('#feild_12').html("Discount");
            $('#feild_13').html("Total");
            $('#feild_14').html('<i class="fa fa-trash"></i>');
            $('#feild_15').html('<i class="fa fa-plus"></i>');
            $('#input_feild_1').html(
                '<input style="width:100px" type="text" value="' + airline_name +
                '" id="airline_name" onchange="airline_calculate()" name="airline_name" class="form-control">'
            );
            $('#input_feild_2').html(
                '<input style="width:100px" type="date" id="arrival_date" value="' + arrival_date +
                '" onchange="airline_calculate()" name="arrival_date" class="form-control fc-datepicker">'
            );
            $('#input_feild_3').html(
                '<input style="width:100px" type="date" id="departure_date" value="' + departure_date +
                '" onchange="airline_calculate()" name="departure_date" class="form-control">'
            );
            $('#input_feild_4').html(
                '<select value="' + arrival_destination +
                '" name="arrival_destination" id="arrival_destination" class="form-control  livesearch"> </select>'
            );
            $('#input_feild_5').html(
                '<select name="mid_destination" value="' + connecting_from +
                '" id="mid_destination" class="form-control  livesearch"> </select>'
            );
            $('#input_feild_6').html(
                '<select name="departure_destination" value="' + departure_destination +
                '" id="departure_destination" class="form-control  livesearch"> </select>'
            );

            $('#input_feild_7').html(
                ' <select name="flight_class" style="width:100px" class="form-control  js-example-basic-single "><option value="Economy">Economy</option><option value="Premium Economy">Premium Economy</option><option value="Buisness">Buisness</option><option value="First Class">First Class</option></select>'
            );
            $('#input_feild_8').html(
                '<input style="width:100px" type="number" id="airline_qty" onchange="airline_calculate()" name="airline_qty" class="form-control">'
            );
            $('#input_feild_9').html(
                '<input style="width:100px" type="number" id="airline_cost_price" onchange="airline_calculate()" name="airline_cost_price" class="form-control">'
            );
            $('#input_feild_10').html(
                '<input style="width:100px" type="number" id="airline_selling_price" onchange="airline_calculate()" name="airline_selling_price" class="form-control">'
            );
            $('#input_feild_11').html(
                '<input style="width:100px" type="number" id="airline_sub_total" onchange="airline_calculate()" name="sub_total" class="form-control">'
            );
            $('#input_feild_12').html(
                '<input style="width:100px" type="number" id="airline_discount" onchange="airline_calculate()" name="discount" class="form-control">'
            );
            $('#input_feild_13').html(
                '<input style="width:100px" type="number" id="airline_total" onchange="airline_calculate()" name="total" class="form-control">'
            );
            $('#input_feild_14').html(
                '<button type="button" class="btn btn-danger" onclick="remove_row(' +
                count + ')">X</button>');

            $('#input_feild_15').html(
                '<button type="button" class="btn btn-success" onclick="add_row(' +
                count + ',' + get_inquiry_id + ')">Add</button>');

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

        }

        function hotel_calculate() {
            var qty = parseInt($('#qty').val()) || 0;
            var hotel_selling_price = parseFloat($('#hotel_selling_price').val()) || 0;
            var hotel_sub_total = qty * hotel_selling_price;

            var hotel_discount = parseFloat($('#hotel_discount').val()) || 0;
            var hotel_total = hotel_sub_total - hotel_discount;

            $('#hotel_sub_total').val(hotel_sub_total.toFixed(2));
            $('#hotel_total').val(hotel_total.toFixed(2));

        }

        function airline_calculate() {


            var qty = parseInt($('#airline_qty').val()) || 0;
            var airline_selling_price = parseFloat($('#airline_selling_price').val()) || 0;
            var airline_sub_total = qty * airline_selling_price;

            var airline_discount = parseFloat($('#airline_discount').val()) || 0;
            var airline_total = airline_sub_total - airline_discount;

            $('#airline_sub_total').val(airline_sub_total.toFixed(2));
            $('#airline_total').val(airline_total.toFixed(2));

        }

        function change_room_type(hotel_inv_id) {
            var room_type = $("#room_types").val();
            $.ajax({
                // alert(count)
                url: "{{ url('get_hotel_inv_details') }}/" + hotel_inv_id + '/' + room_type,
                type: 'GET',
                success: function(data) {
                    $('#beds').val(data.room_type.beds);
                    $('#hotel_selling_price').val(data.room_type.selling_price);
                    $('#cost_price').val(data.room_type.cost_price);
                    $('#qty').val(data.room_type.qty);
                    hotel_calculate();

                }
            });


        }

        function onchange_get_curr_data() {
            var rate = $("#hotel_currency").val();
            var hotel_total = $("#hotel_total").val();
            var currency_name = $("#hotel_currency").html();
            var conversion_rate = hotel_total / rate;
            var final_conversion_rate = parseFloat(conversion_rate).toFixed(2);
            $('#feild_12').html("Exchange=" + final_conversion_rate + '/-');
        }

        // function generateInputFields(count) {
        //     var html = '';

        //     html +=
        //         '<input style="width:100px" type="number" name="no_of_adults" class="form-control" id="no_of_adults" onchange="calculate()">';
        //     html +=
        //         '<input style="width:100px" type="number" name="no_of_children" class="form-control" id="no_of_children" onchange="calculate()">';
        //     html +=
        //         '<input style="width:100px" type="number" name="no_of_infants" class="form-control" id="no_of_infants" onchange="calculate()">';
        //     html +=
        //         '<input style="width:100px" type="number" name="selling_price" class="form-control" id="selling_price" onchange="calculate()">';
        //     html +=
        //         '<input style="width:100px" type="number" name="sub_total" class="form-control" id="sub_total" readonly>';
        //     html +=
        //         '<input style="width:100px" type="number" name="discount" class="form-control" id="discount" onchange="calculate()">';
        //     html += '<input style="width:100px" type="number" name="total" class="form-control" id="total" readonly>';
        //     html += '<button type="button" class="btn btn-danger" onclick="remove_row(' + count + ')">X</button>';

        //     $('#input_field_1').html(html);
        //     // $('#input_field').html(html);
        //     calculate();
        // }
    </script>
@endpush
