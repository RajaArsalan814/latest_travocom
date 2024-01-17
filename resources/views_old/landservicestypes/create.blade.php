@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Land And Services</span>
        <span>Add Land And Services</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Add New Land And Services<span><a
                href="{{ url('land_services') }}" class="btn btn-az-primary" style="float: right">Land And Services
                List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h4 class="card-title mg-b-20">Add Land And Services</h4>
                <form method="post" action="{{ url('land_services/store') }}">
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

                    <div class="row row-sm mg-b-20 ">
                        <div class="col-md-6 mt-2 ">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Service</label>
                                {{-- <input type="text" name="name" class="form-control"  /> --}}
                                <select style="width: 100%" onchange="land_service_fun()" id="land_service"
                                    class="js-example-basic-single" name="name">
                                    <option value="">Select</option>
                                    @foreach ($land_services_type as $service)
                                        <option value="{{ $service->id_land_services_types }}">{{ $service->service_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Select
                                    Service Type</label>
                                <select class="js-example-basic-single" id="append_services_types" style="width: 100%"
                                    name="service_type">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <h4 class="card-title mt-4  mg-b-20">Add Details</h4>
                        <hr>
                        <div class="col-md-6 mt-2 ">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Transport</label>
                                {{-- <input type="text" name="name" class="form-control"  /> --}}
                                <select style="width: 100%" id="select_transport" class="js-example-basic-single"
                                    name="transport[]">
                                    <option value="">Select</option>
                                    <option value="Bus">Bus</option>
                                    <option value="GMC">GMC</option>
                                    <option value="Railway">Railway</option>
                                    <option value="Car-Sedan">Car-Sedan</option>
                                    <option value="Car-SUV">Car-SUV</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mt-2">

                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Route</label>
                                {{-- <input type="text" name="name" class="form-control"  /> --}}
                                <select style="width: 100%" id="select_route" class="js-example-basic-single"
                                    name="route[]">
                                    <option value="">Select</option>
                                    @foreach ($routes as $route)
                                        <option value="{{ $route->id_route }}">
                                            {{ $route->route_location }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Vendor</label>
                                {{-- <input type="text" name="name" class="form-control"  /> --}}
                                <select style="width: 100%" id="select_vendor" class="js-example-basic-single"
                                    name="vendor[]">
                                    <option value="">Select</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id_service_vendors }}">{{ $vendor->vendor_name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Transport Type</label>
                                <select style="width: 100%" onchange="change_transport_type(0,this)" id="transport_type"
                                    class="js-example-basic-single" name="transport_type[]">
                                    <option value="">Select</option>
                                    <option selected value="no_of_person">No Of Person</option>
                                    <option value="service_level">Service Level</option>

                                </select>

                            </div>
                        </div>
                    </div>

                    <div id="no_of_person">
                        <div class="row row-sm mg-b-20 ">
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Adults Cost Price</label>
                                    <input type="number" name="adult_cost_price[]" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Adults Selling Price</label>
                                    <input type="number" name="adult_selling_price[]" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm mg-b-20 ">
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Children Cost Price</label>
                                    <input type="number" name="children_cost_price[]"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Children Selling
                                        Price</label>
                                    <input type="number" name="children_selling_price[]"
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm mg-b-20">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Infant Cost Price</label>
                                    <input type="number" name="infant_selling_price[]"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Infant Selling
                                        Price</label>
                                    <input type="number" name="infant_cost_price[]"
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display:none;" id="service_level">
                        <div class="row row-sm mg-b-20 ">
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Cost Price</label>
                                    <input type="number" name="cost_price[]" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Selling
                                        Price</label>
                                    <input type="number" name="selling_price[]" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="add_more_details()" class="btn btn-success btn-block text-white">Add
                        More</button>
                    <div id="add_more_land_service"></div>
                    <hr>
                    <a type="submit" href="{{ url('land_services') }}" class="btn btn-danger btn-block mt-2">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-az-primary btn-block mt-2" style="float: right">
                        Submit
                    </button>
                </form>
            </div>
            <!-- card -->
        </div>
        <!-- col -->
    </div>

    @push('scripts')
        <script>
            function change_transport_type(count, e) {
                var val = $(e).val();
                if (count == 0) {
                    if (val == 'service_level') {
                        $('#no_of_person').css('display', 'none')
                        $('#service_level').css('display', 'block')
                    } else {
                        $('#service_level').css('display', 'none')
                        $('#no_of_person').css('display', 'block')
                    }
                } else {
                    if (val == 'service_level') {
                        $('#no_of_person' + count).css('display', 'none')
                        $('#service_level' + count).css('display', 'block')
                    } else {
                        $('#service_level' + count).css('display', 'none')
                        $('#no_of_person' + count).css('display', 'block')
                    }
                }
            }




            function land_service_fun() {
                var v_id = $('#land_service').val();
                $.ajax({
                    type: "GET",
                    url: "{{ url('/append_land_services') }}/" + v_id,
                    success: function(response) {
                        $('#append_services_types').html(response.services);
                    }
                });
            }
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
                $('.js-example-basic-multiple').select2();
            });
        </script>
    @endpush
    <script>
        var land_services_count = 5000;



        function add_more_details() {
            $.ajax({
                url: "{{ url('add_land_services_details') }}/" + land_services_count,
                type: "GET",
                success: function(data) {
                    $('#add_more_land_service').append(data);
                    $('.js-example-basic-single').select2();
                    $('.js-example-basic-multiple').select2();
                    land_services_count = land_services_count + 1
                }
            });
        }

        function remove_land_services(count_rmv) {
            // alert(count_rmv)
            $('.rmv_land_services' + count_rmv).remove();
        }
    </script>

@endsection
