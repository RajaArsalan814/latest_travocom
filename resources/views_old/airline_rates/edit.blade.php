@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Airline Rates</span>
        <span>Edit Airline Rates</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Edit New Airline Rates <span><a
                href="{{ url('airline/airline_rates/' . \Crypt::encrypt($room_rates->airline_id)) }}"
                class="btn btn-az-primary" style="float: right">Airline Rates
                List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Edit Airline Rates</h5>
                <form method="post"
                    action="{{ url('airline_rates/update/' . \Crypt::encrypt($room_rates->id_airline_rates)) }}">
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
                                        <input type="date" name="from_date" value="{{ $room_rates->from_date }}"
                                            class="form-control" required />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">To Date</label>
                                        <input type="date" name="to_date" value="{{ $room_rates->to_date }}"
                                            class="form-control" required />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">From Location</label>
                                        <input type="text" value="{{ $room_rates->from_location }}" name="from_location"
                                            class="form-control" required />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">To Location</label>
                                        <input type="text" value="{{ $room_rates->to_location }}" name="to_location"
                                            class="form-control" required />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Room</label>
                                        <select name="flight_class" id="" class="form-control" required>
                                            <option value="">Select</option>
                                            <option @if ($room_rates->flight_class == 'Economy') selected @endif value="Economy">
                                                Economy</option>
                                            <option @if ($room_rates->flight_class == 'Premium Economy') selected @endif
                                                value="Premium Economy">Premium Economy</option>
                                            <option @if ($room_rates->flight_class == 'Buisness') selected @endif value="Buisness">
                                                Buisness</option>
                                            <option @if ($room_rates->flight_class == 'First Class') selected @endif value="First Class">
                                                First Class</option>

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
                                    <input type="text" value="{{ $room_rates->cost_price }}" name="cost_price"
                                        class="form-control" required="required">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div><!-- input-group -->

                            </div>
                        </div>
                        <input type="hidden" name="a_id" value="{{ \Crypt::encrypt($room_rates->airline_id) }}">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Selling Price</label>
                                <input type="hidden" name="r_id"
                                    value="{{ \Crypt::encrypt($room_rates->id_room_rates) }}">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">AMOUNT</span>
                                    </div>
                                    <input type="text" name="selling_price" value="{{ $room_rates->selling_price }}"
                                        class="form-control" required="required">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div><!-- input-group -->

                            </div>
                        </div>


                    </div>

                    <button type="button" onclick="history.back()" class="btn btn-danger btn-block mt-2">
                        Cancel
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


@endsection
