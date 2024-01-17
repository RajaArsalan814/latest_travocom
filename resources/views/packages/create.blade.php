@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Packages</span>
        <span>Add Package</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Add New Package <span><a href="{{ url('packages') }}"
                class="btn btn-az-primary" style="float: right">Package List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Add Package Details</h5>
                <form method="post" enctype="multipart/form-data" action="{{ url('packages/store') }}">
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

                    <div class="row row-sm mg-b-20">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Package Name</label>
                                <input type="text" name="package_name" class="form-control" required />
                            </div>
                        </div>
                        <!-- form-group -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Package type</label>

                                <select class="form-control select2" name="package_type" required>
                                    <option>Select Package Type</option>
                                    @foreach ($packages_types as $package_type)
                                        <option value="{{ $package_type->id_packages_types }}">
                                            {{ $package_type->type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row row-sm mg-b-20">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">From Date</label>
                                <input type="text" name="from_date" id="start_date" placeholder="DD-MM-YYYY"
                                    class="form-control fc-datepicker" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">To Date</label>
                                <input type="text" name="to_date" id="end_date" placeholder="DD-MM-YYYY"
                                    class="form-control fc-datepicker" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">No Of Persons</label>
                                <input type="number" class="form-control" name="no_of_persons" required>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm mg-b-20">
                        <div class="col-lg-5 mg-t-20 mg-lg-t-0">
                            <div class="form-group">

                                <label class="form-control-label">Services: <span style="color:red;">*</span></label>
                                <select name="services[]" id="services" class="form-control" required>
                                    <option>Select Services </option>
                                    @forelse ($services as $service)
                                        <option value="{{ $service->id_other_services }}">
                                            {{ $service->service_name }}
                                        </option>
                                    @empty
                                        No Results Found
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                            <div class="form-group">
                                <label class="form-control-label">Sub Services:</label>
                                <select style="width: 100%" name="sub_services[]" id="sub_services" required
                                    class="js-example-basic-multiple" multiple="multiple">
                                    <option>Select Sub Service</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1 mg-t-20 mg-md-t-0">
                            {{-- <label class="form-control-label">Add More</label> --}}
                            <button onclick="add_more()" class="btn btn-az-primary mt-4" type="button">Add
                                More</button>
                        </div>
                    </div>
                    <div class="row" id="append_services">

                    </div>

                    <div class="row row-sm mg-b-20">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Package Cost</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">AMOUNT</span>
                                    </div>
                                    <input type="text" name="package_cost" class="form-control" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div><!-- input-group -->

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Package Price</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">AMOUNT</span>
                                    </div>
                                    <input type="text" name="package_price" class="form-control" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div><!-- input-group -->

                            </div>
                        </div>
                    </div>
                    <div class="row row-sm mg-b-20">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Package Image</label>
                                    <input type="file" class="form-control" name="package_image" />
                                </div>
                            </div>
                        </div>
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script>
        $(document).ready(function() {
            // Initialize the Datepicker for the "Start Date"
            $("#start_date").datepicker({
                dateFormat: 'dd-mm-yy',
                minDate: 0, // Disable backward dates (past dates)
                onSelect: function(selectedDate) {
                    // When a date is selected in the "Start Date" field, update the options for the "End Date" field
                    $("#end_date").datepicker("option", "minDate", selectedDate);
                }
            });

            // Initialize the Datepicker for the "End Date"
            $("#end_date").datepicker({
                dateFormat: 'dd-mm-yy',
                minDate: 0, // Disable backward dates (past dates)
            });
        });
    </script>
    <script>
        // Additional code for adding placeholder in search box of select2


        $(document).ready(function() {
            $('.select2').select2({});

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
            $('.js-example-basic-multiple').select2();

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
