@extends('layouts.master')
@section('content')
    <style>
        .error {
            color: red;
        }
    </style>
    <div class="az-content-breadcrumb">
        <span>Inventory</span>
        <span>Add Inventory</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Add New Inventory to <span
            style='text-decoration: underline;'><?= $airline->hotel_name ?></span> <span><a
                href="{{ url('airlines/inventory/' . Crypt::encrypt($airline->id_airlines)) }}" class="btn btn-az-primary"
                style="float: right">Inventory List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Add Inventory Details</h5>
                <form method="post" id="submit_form" enctype="multipart/form-data"
                    action="{{ url('airlines/inventory/store/' . Crypt::encrypt($airline->id_airlines)) }}">
                    @csrf
                    @if (count($errors) > 0)
                        <div class="p-1">
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-warning alert-danger fade show" role="alert">{{ $error }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <input type="hidden" name="h_id" value="{{ \Crypt::encrypt($airline->id_airlines) }}">
                    <div class="row row-sm mg-b-20">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Batch#</label>
                                <input type="text" name="batch_number" readonly class="form-control"
                                    value="<?= $airline->id_airlines . '-' . date('d-m-y', strtotime(now())) ?>" required />
                            </div>
                        </div>
                        <!-- form-group -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Arrival Date</label>
                                <input type="text" readonly name="arival_date" id="datetimepicker2" class="form-control "
                                    placeholder="MM/DD/YYYY" />
                            </div>

                        </div>
                        <!-- form-group -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Departure Date</label>
                                <input type="text" id="datetimepicker_depart" name="departure_date" class="form-control "
                                    placeholder="MM/DD/YYYY" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Arrival Destination</label>
                                <select name="arrival_destination" id="country-dropdown1" class="form-control livesearch ">
                                    {{-- @forelse ($countries as $con)
                                        <option value="{{ $con->name }}">{{ $con->name }}</option>
                                    @empty
                                        No Results Found
                                    @endforelse --}}
                                </select>
                                {{-- <input class="typeahead form-control" type="text"> --}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Connecting From</label>
                                <select name="mid_destination" id="country-dropdown3" class="form-control livesearch">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Departure Destination</label>
                                <select name="departure_destination" id="country-dropdown2" class="form-control livesearch">
                                    {{-- @forelse ($countries as $con)
                                        <option value="{{ $con->name }}">{{ $con->name }}</option>
                                    @empty
                                        No Results Found
                                    @endforelse --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Enter Flight Number</label>
                                <input type="text" name="flight_no" id="flight_no" class="form-control">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Vendor</label>
                                <select class="form-control js-example-basic-single" name="vendor">
                                    <option value="">Select</option>
                                    @forelse($vendors as $vendor)
                                        <option value="{{ $vendor->id_service_vendors }}">{{ $vendor->vendor_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Mid Destination</label>
                                <select name="mid_destination_city" id="city-dropdown3" class="form-control">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div> --}}

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Flight Class</label>
                            <select name="room_type" id="flight_class" class="form-control js-example-basic-single">
                                <option value="">Select</option>
                                @foreach ($get_flight_class as $item)
                                    <option value="{{ $item->flight_class }}">{{ $item->flight_class }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row row-sm mg-b-20" id="room_type_list">

                    </div>
            </div>
            <div class="form-group">
                {{-- <div class="form-group">
                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Upload Attachments</label>
                    <input type="file" id="attachments" class="form-control" name="attachments" />
                </div> --}}
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-12">
                    {{-- <div class="card card-body pd-40"> --}}

                    <div>
                        <table id="example2" class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="wd-5-f">S.No</th>
                                    <th class="wd-15p">Flight Class </th>
                                    <th class="wd-15p">No Of Tickets </th>
                                    <th class="wd-15p">Cost Price </th>
                                    <th class="wd-15p">Sale Price </th>
                                    <th class="wd-10p">Created By</th>
                                    <th class="wd-10p">Created</th>
                                    <th class="wd-10f">Operations</th>
                                </tr>
                            </thead>
                            <tbody id="all_data">
                                @foreach ($airlrine_inventory as $key => $airline_inv)
                                    <tr id="rmv{{ $airline_inv->id_airline_inventory_temp }}">

                                        <td>{{ $key = $key + 1 }}</td>


                                        <td>

                                            {{ $airline_inv->flight_class }}
                                        </td>
                                        <td>
                                            {{ $airline_inv->qty }}
                                        </td>
                                        <td>
                                            {{ $airline_inv->cost_price }}
                                        </td>
                                        <input type="hidden" name="flight_class[]"
                                            value="{{ $airline_inv->flight_class }}">
                                        <input type="hidden" name="qty[]" value="{{ $airline_inv->qty }}">
                                        <input type="hidden" name="cost_price[]"
                                            value="{{ $airline_inv->cost_price }}">
                                        <input type="hidden" name="selling_price[]"
                                            value="{{ $airline_inv->selling_price }}">


                                        <td>
                                            {{ $airline_inv->selling_price }}
                                        </td>
                                        <td>
                                            Super Admin
                                        </td>
                                        <td><?= date('d-m-Y', strtotime($airline_inv->created_at)) ?></td>

                                        <td><button type="button"
                                                onClick="delete_btn({{ $airline_inv->id_airline_inventory_temp }},{{ $airline->id_airlines }})"
                                                class="btn btn-rounded btn-danger" href="#">
                                                Delete
                                            </button>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="wd-5-f">S.No</th>
                                    <th class="wd-15p">Flight Class </th>
                                    <th class="wd-15p">No Of Tickets </th>
                                    <th class="wd-15p">Cost Price </th>
                                    <th class="wd-15p">Sale Price </th>
                                    <th class="wd-10p">Created By</th>
                                    <th class="wd-10p">Created</th>
                                    <th class="wd-10f">Operations</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    {{-- </div> --}}
                    <!-- card -->
                </div>
                <!-- col -->
            </div>

            <!-- form-group -->



            <button type="submit" onclick="history.back()" class="btn btn-danger btn-block mt-2">
                Cancel
            </button>
            <button type="submit" class="btn btn-az-primary btn-block mt-2" style="float: right">
                Submit
            </button>
            </form>
        </div>
        <!-- card -->
    </div>
    <!-- col -->
    </div>


@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script>
        $("#flight_class").on("change", function(e) {
            let val = $(this).val();


            $.ajax({
                url: "{{ url('airlines/get_room_type') }}/" + val,
                type: "GET",
                success: function(result) {
                    $('#room_type_list').empty().html(result.data);
                    $("#room_type_val").val(val);
                    // $("select").attr("disabled", "disabled");

                }
            });
        })

        // save data inqventory

        function delete_btn(inv_id, hotel_id) {
            $.ajax({
                url: "{{ url('airlines/inventory/delete') }}/" + inv_id + "/" + hotel_id,
                type: "GET",
                success: function(result) {
                    $('#all_data').find('#rmv' + inv_id).remove()

                    $.ajax({
                        url: "{{ url('airlines/inventory/create') }}/" + hotel_id,
                        type: "GET",
                        success: function(result) {
                            $('#flight_class').empty().html(result.data);

                        }
                    });

                }
            });

        }
        $(document).ready(function() {
            $('.js-example-basic-single').select2();


        });

        function save_btn() {
            // $(document).ready(function($) {

            //     $("#submit_form").validate({

            //         messages: {
            //             name: "Please enter your Name",
            //             password: {
            //                 required: "Please provide a password",
            //                 minlength: "Your password must be at least 6 characters long"
            //             },
            //             city: "Please enter your city",
            //             gender: "This field is required"
            //         },
            //         errorPlacement: function(error, element) {
            //             if (element.is(":radio")) {
            //                 error.appendTo(element.parents('.form-group'));
            //             } else { // This is the default behavior
            //                 error.insertAfter(element);
            //             }
            //         },
            //         submitHandler: function(form) {
            //             form.submit();
            //         }

            //     });
            // });
            // $("#submit_form").submit();
            var qty = $('[name=qty]').val()
            var cPrice = $('[name=cost]').val()
            var sellingPrice = $('[name=s_price]').val()
            var h_id = $('[name=h_id]').val()
            let room_type = $("#flight_class").val();

            if (qty.length > 0 && cPrice.length > 0 && sellingPrice.length > 0) {

                $.ajax({
                    url: "{{ url('airlines/save_inventory') }}/",
                    type: "GET",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'qty': qty,
                        'h_id': h_id,
                        'flight_class': room_type,
                        'c_price': cPrice,
                        's_price': sellingPrice,

                    },
                    // data: $("#submit_form").serialize(),
                    success: function(result) {
                        $('#room_type_list').empty();
                        $('#flight_class option:selected').remove();
                        $("#room_type_val").val("");
                        $("select").removeAttr("disabled", "disabled");
                        $.ajax({
                            url: "{{ url('airlines/get_all_data_ajax') }}/{{ request()->id }}",
                            type: "GET",
                            success: function(result) {
                                $('#all_data').empty().html(result.data);



                            }
                        });

                        $.ajax({
                            url: "{{ url('airlines/inventory/create') }}/{{ request()->id }}",
                            type: "GET",
                            success: function(result) {
                                $('#flight_class').empty().html(result.data);

                            }
                        });
                    }
                });
            } else {
                alert('Please Fill All Details')
            }

        }
        // $(document).ready(function(e) {

        //     // alert("{{ request()->id }}")
        //     $('#submit_form').on('submit', (function(e) {
        //         e.preventDefault();
        //         $('#submit_form').validate();
        //         var formData = new FormData(this);
        //         $.ajax({
        //             type: 'POST',
        //             url: $(this).attr('action'),
        //             data: formData,
        //             cache: false,
        //             contentType: false,
        //             processData: false,
        //             success: function(result) {

        //                 $('#room_type_list').empty();
        //                 $('#room_type option:selected').remove();
        //                 $("#room_type_val").val("");
        //                 $("select").removeAttr("disabled", "disabled");

        //                 $.ajax({
        //                     url: "{{ url('get_all_data') }}/{{ request()->id }}",
        //                     type: "GET",
        //                     success: function(result) {
        //                         $('#all_data').empty().html(result.data);


        //                     }
        //                 });

        //             },
        //             error: function(data) {
        //                 console.log("error");
        //                 console.log(data);
        //             }
        //         });
        //     }));

        //     $("#ImageBrowse").on("click", function() {
        //         $("#imageUploadForm").submit();
        //     });
        // });


        $(document).ready(function() {


            // var path = "{{ route('autocomplete_country') }}";
            // $('input.typeahead').typeahead({
            //     source: function(query, process) {
            //         return $.get(path, {
            //             query: query
            //         }, function(data) {
            //             return process(data);
            //         });
            //     }
            // });

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

            $('#country-dropdown1').on('change', function() {
                var country_id = this.value;

                $("#city-dropdown").html('');
                $.ajax({
                    url: "{{ url('get-cities-by-country') }}",
                    type: "POST",
                    data: {
                        country_id: country_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#city-dropdown1').html(
                            '<option value="">Select</option>');
                        $.each(result.cities, function(key, value) {
                            $("#city-dropdown1").append('<option value="' +
                                value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            });
            $('#country-dropdown2').on('change', function() {
                var country_id = this.value;

                $("#city-dropdown2").html('');
                $.ajax({
                    url: "{{ url('get-cities-by-country') }}",
                    type: "POST",
                    data: {
                        country_id: country_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#city-dropdown2').html(
                            '<option value="">Select</option>');
                        $.each(result.cities, function(key, value) {
                            $("#city-dropdown2").append('<option value="' +
                                value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            });
            $('#country-dropdown3').on('change', function() {
                var country_id = this.value;

                $("#city-dropdown3").html('');
                $.ajax({
                    url: "{{ url('get-cities-by-country') }}",
                    type: "POST",
                    data: {
                        country_id: country_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#city-dropdown3').html(
                            '<option value="">Select</option>');
                        $.each(result.cities, function(key, value) {
                            $("#city-dropdown3").append('<option value="' +
                                value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            });


            $('#datetimepicker_depart').appendDtpicker({
                closeOnSelected: true,
                onInit: function(handler) {
                    var picker = handler.getPicker();
                    $(picker).addClass('az-datetimepicker');
                }
            });
        });
    </script>
@endpush
