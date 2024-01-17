@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Package list</span>
        <span>Edit Package</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Edit Package <span><a href="{{ url('packages') }}"
                class="btn btn-az-primary" style="float: right">Package List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Edit Package Details</h5>
                <form method="POST" action="{{ url('packages/update/' . \Crypt::encrypt($edit_package->id_packages)) }}"
                    enctype="multipart/form-data">
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
                                <input type="text" name="package_name" class="form-control"
                                    value="{{ $edit_package->package_name }}" required />
                            </div>
                        </div>
                        <!-- form-group -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Package type</label>

                                <select class="form-control select2" name="package_type" required>
                                    <option>Select Package Type</option>
                                    @foreach ($packages_types as $package_type)
                                        <option
                                            <?= $package_type->id_packages_types == $edit_package->package_type ? 'selected' : '' ?>
                                            value="{{ $package_type->id_packages_types }}">{{ $package_type->type_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row row-sm mg-b-20">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">From Date</label>
                                <input type="text" name="from_date" class="form-control fc-datepicker"
                                    value="{{ $edit_package->from_date }}" placeholder="MM/DD/YYYY" required />
                            </div>
                        </div>
                        <!-- form-group -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">To Date</label>
                                <input type="text" name="to_date" class="form-control fc-datepicker"
                                    value="{{ $edit_package->to_date }}" placeholder="MM/DD/YYYY" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">No Of Persons</label>
                                <input type="number" value="{{ $edit_package->no_of_persons }}" class="form-control"
                                    name="no_of_persons">
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
                                        <option @if ($service->id_other_services == $service->id_other_services) selected @endif
                                            value="{{ $service->id_other_services }}">
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
                                <select style="width: 100%" name="sub_services[]" id="sub_services"
                                    class="js-example-basic-multiple" multiple="multiple" required>
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
                                    <input type="text" name="package_cost" class="form-control"
                                        value="{{ $edit_package->package_cost }}" >
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
                                    <input type="text" name="package_price"
                                        value="{{ $edit_package->package_price }}" class="form-control" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div><!-- input-group -->

                            </div>
                        </div>
                    </div>

                    <!-- form-group -->
                    @csrf
                    <?php
                    if (!empty($edit_package->package_image)) {
                        $image = url('/uploads/package_images/' . $edit_package->package_image);
                    } else {
                        $image = url('/uploads/package_images/package_default.png');
                    }
                    ?>
                    <!-- form-group -->
                    <input type="hidden" name="h_id" value="{{ \Crypt::encrypt($edit_package->id_packages) }}">
                    <div class="form-group">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600 mt-2">Package Image</label>
                            <div>
                                <div class="col-md-12  mb-4">
                                    <img src="<?= $image ?>" style="border-radius: 50%;height:100px;width:100px;"
                                        alt="" srcset="">
                                </div>
                            </div>
                            <input type="file" class="form-control" name="package_image" />
                        </div>
                    </div>
                    <!-- form-group -->
                    <div class="form-group">
                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Package Status</label>
                        <select class="form-control select2" name="package_status">
                            <option <?= $edit_package->package_status == 1 ? 'selected' : '' ?> value="1">Active
                            </option>
                            <option <?= $edit_package->package_status == 0 ? 'selected' : '' ?> value="0">Deactive
                            </option>

                        </select>
                    </div>


                    <button type="button" onclick="history.back()" class="btn btn-danger btn-block mt-2">
                        Back
                    </button>
                    <button type="submit" class="btn btn-az-primary btn-block mt-2" style="float: right">
                        Update
                    </button>
                </form>
            </div>
            <!-- card -->
        </div>
        <!-- col -->
    </div>






    {{-- </div><!-- az-content-body --> --}}
@endsection

@push('scripts')
    <script>
        // Additional code for adding placeholder in search box of select2


        $(document).ready(function() {
            $('.select2').select2({});
            var val = $('#services').val();
            $.ajax({
                url: "{{ url('get_sub_services') }}/" + val,
                type: "GET",
                success: function(data) {
                    $('#sub_services').html(data);
                }
            });
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
