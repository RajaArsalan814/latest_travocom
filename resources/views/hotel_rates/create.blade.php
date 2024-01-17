@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Hotel Room Rates</span>
        <span>Add Hotel Room Rates</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Add New Hotel Room Rates <span><a
                href="{{ url('hotels/hotel_rates/' . request()->hotel_id) }}" class="btn btn-az-primary"
                style="float: right">Hotel Room Rate
                List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Add Hotel Room Rates</h5>
                <form method="post" action="{{ url('hotel_rates/store') }}">
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


                    <div class="row">
                        <div class="col-md-6">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">From Date</label>
                                        <input type="text" name="from_date" placeholder="MM/DD/YYYY" class="form-control fc-datepicker" required />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">To Date</label>
                                        <input type="text" name="to_date" placeholder="MM/DD/YYYY" class="form-control fc-datepicker" required />
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Room</label>
                                        <select name="room_type" id="" class="form-control" required>
                                            <option value="">Select</option>
                                            @foreach ($room_types as $room)
                                                <option value="{{ $room->id_room_types }}">{{ $room->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Vendor</label>
                                        <select name="vendor" id="" class="form-control" required>
                                            <option value="">Select</option>
                                            @foreach ($service_vendors as $service_vendor)
                                                <option value="{{ $service_vendor->id_service_vendors }}">{{ $service_vendor->vendor_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Cost Price</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">AMOUNT</span>
                                    </div>
                                    <input type="text" name="cost_price" class="form-control" required="required">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div><!-- input-group -->

                            </div>
                        </div>
                        <input type="hidden" name="h_id" value="{{ request()->hotel_id }}">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Selling Price</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">AMOUNT</span>
                                    </div>
                                    <input type="text" name="selling_price" class="form-control" required="required">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div><!-- input-group -->

                            </div>
                        </div>


                    </div>

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
