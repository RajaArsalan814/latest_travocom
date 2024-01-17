@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Land Services</span>
        <span>Add Land Services</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Edit  Land Services<span><a href="{{ url('land_services') }}"
                class="btn btn-az-primary" style="float: right">Land Services
                List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h4 class="card-title mg-b-20">Edit Land Services</h4>
                <form method="post" action="{{ url('land_services/update/'.\Crypt::encrypt($get_edit_data->id_land_and_services_types)) }}">
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
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Service <span
                                        class="text-danger"><b>*</b></span></label>
                                {{-- <input type="text" name="name" class="form-control"  /> --}}
                                <select style="width: 100%" onchange="land_service_fun()" id="land_service"
                                    class="js-example-basic-single" name="name" required>
                                    <option value="">Select</option>
                                    @foreach ($land_services_type as $service)
                                    <option @if($get_edit_data->name==$service->id_land_services_types)selected @endif value="{{ $service->id_land_services_types }}">{{ $service->service_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Select
                                    Service Type <span class="text-danger"><b>*</b></span></label>
                                <select class="js-example-basic-single" id="append_services_types" style="width: 100%"
                                    name="service_type" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        @php
                        $total_entries=json_decode($get_edit_data->total_entries);

                        @endphp
                        <h4 class="card-title mt-4  mg-b-20">Add Details</h4>
                        <hr>
                        <div class="col-md-6 mt-2 ">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Transport <span
                                        class="text-danger"><b>*</b></span></label>
                                {{-- <input type="text" name="name" class="form-control"  /> --}}
                                <select style="width: 100%" id="select_transport" class="js-example-basic-single"
                                    name="transport">
                                    <option  value="">Select</option>
                                    <option @if($total_entries[0]->transport=="Bus")selected @endif value="Bus">Bus</option>
                                    <option @if($total_entries[0]->transport=="GMC")selected @endif value="GMC">GMC</option>
                                    <option @if($total_entries[0]->transport=="Railway")selected @endif value="Railway">Railway</option>
                                    <option @if($total_entries[0]->transport=="Car-Sedan")selected @endif value="Car-Sedan">Car-Sedan</option>
                                    <option @if($total_entries[0]->transport=="Car-SUV")selected @endif value="Car-SUV">Car-SUV</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mt-2">

                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Route <span
                                        class="text-danger"><b>*</b></span></label>
                                {{-- <input type="text" name="name" class="form-control"  /> --}}
                                <select style="width: 100%" id="select_route" class="js-example-basic-single"
                                    name="route" required>
                                    <option value="">Select</option>
                                    @foreach ($routes as $route)
                                        <option  @if($total_entries[0]->route_id==$route->id_route)selected @endif value="{{ $route->id_route }}">
                                            {{ $route->route_location }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Vendor <span
                                        class="text-danger"><b>*</b></span></label>
                                {{-- <input type="text" name="name" class="form-control"  /> --}}
                                <select style="width: 100%" id="select_vendor" class="js-example-basic-single"
                                    name="vendor" required>
                                    <option value="">Select</option>
                                    @foreach ($vendors as $vendor_s)
                                   
                                        <option @if(isset($total_entries[0]->vendor) && $total_entries[0]->vendor==$vendor_s->id_service_vendors)selected @endif value="{{ $vendor_s->id_service_vendors }}">{{ $vendor_s->vendor_name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="row row-sm mg-b-20 ">
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Cost Price <span
                                            class="text-danger"><b>*</b></span></label>
                                            <input type="number" value="{{$total_entries[0]->cost_price}}" name="cost_price" class="form-control" required/>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Selling
                                        Price <span class="text-danger"><b>*</b></span></label>
                                    <input type="number" value="{{$total_entries[0]->selling_price}}" name="selling_price" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                    </div>
<!--                    <button type="button" onclick="add_more_details()" class="btn btn-success btn-block text-white">Add
                        More</button>-->
                    <div id="add_more_land_service"></div>
                    <hr>
                    <a type="submit" href="{{ url('land_services') }}" class="btn btn-danger btn-block mt-2">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-az-primary btn-block mt-2" style="float: right">
                        Update
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

land_service_fun();


            function land_service_fun() {
                var v_id = $('#land_service').val();
                $.ajax({
                    type: "GET",
                    url: "{{ url('/append_land_services') }}/" + v_id,
                    success: function(response) {
                        $('#append_services_types').html(response.services);
                        
                $("#append_services_types >option").each(function(i,obj){
                    let val_service=$(obj).html();
                    let val_edit_service="{{$get_edit_data->service_type}}";
                   
                    if(val_service == val_edit_service){
                        $(this).prop('selected',true);
                    }
              
                });
                        
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
