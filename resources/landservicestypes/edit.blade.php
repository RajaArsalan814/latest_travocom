@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Inquiry Types list</span>
        <span>Edit Inquiry Types</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Edit Land Services <span><a href="{{ url('land_services') }}"
                class="btn btn-az-primary" style="float: right">Land Services List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Edit Inquiry Types Details</h5>
                <form method="POST" action="{{url('land_services/update/'.\Crypt::encrypt($landservicestypes->id_land_and_services_types))}}">
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
                        <div class="col-md-6 ">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Name</label>
                                <input type="text" value="{{ $landservicestypes->name }}" name="name" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Select
                                    Service Type</label>
                                <select name="service_type" class="form-control" id="country-dropdown">
                                    <option>Select</option>
                                    <option @if($landservicestypes->service_type == 'i-tour') selected @endif value="i-tour">I-tour</option>
                                    <option @if($landservicestypes->service_type == 'd-tour') selected @endif value="d-tour">D-tour</option>
                                    <option @if($landservicestypes->service_type == 'umrah') selected @endif value="umrah">Umrah</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title mg-b-20">Add Details</h4>
                    <hr>
                    @php
                        $decodedallentries = json_decode($landservicestypes->total_entries);
                        // dd($decodedallentries);
                    @endphp

                   @foreach ($decodedallentries as $dc )
                   <div class="row row-sm mg-b-20 ">
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">No Of Adults</label>

                            <input type="number" value="{{ $dc->no_of_adults }}" name="no_of_adults[]" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Adults Cost Price</label>
                            <input type="number" value="{{ $dc->adult_cost_price }}" name="adult_cost_price[]" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Adults Selling Price</label>
                            <input type="number" value="{{ $dc->adult_selling_price }}" name="adult_selling_price[]" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="row row-sm mg-b-20 ">
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">No Of Children</label>
                            <input type="number" value="{{ $dc->no_of_children }}" name="no_of_children[]" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Children Cost Price</label>
                            <input type="number" value="{{ $dc->children_cost_price }}" name="children_cost_price[]" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Children Selling Price</label>
                            <input type="number" value="{{ $dc->children_selling_price }}" name="children_selling_price[]" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="row row-sm mg-b-20 ">
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">No Of Infants</label>
                            <input type="number" value="{{ $dc->no_of_infants }}" name="no_of_infants[]" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Infant Cost Price</label>
                            <input type="number" value="{{ $dc->infant_selling_price }}" name="infant_selling_price[]" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Infant Selling Price</label>
                            <input type="number" value="{{ $dc->infant_cost_price }}" name="infant_cost_price[]" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="row row-sm mg-b-20 ">
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">From Location</label>
                            <input type="text" value="{{ $dc->from_loc }}" name="from_loc[]" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">To Location</label>
                            <input type="text" value="{{ $dc->to_loc }}" name="to_loc[]" class="form-control" required />
                        </div>

                        <button style="float: right;" type="button" onclick="add_more_details()"
                            class="btn btn-primary mt-3">Add More</button>
                    </div>

                </div>
                   @endforeach
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






    {{-- </div><!-- az-content-body --> --}}
@endsection
