@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Airlines</span>
        <span>Add Airline</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Add New Airline <span><a href="{{ url('airlines') }}"
                class="btn btn-az-primary" style="float: right">Airline List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Add Airline Details</h5>
                <form method="post" enctype="multipart/form-data" action="{{ url('airlines/store') }}">
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
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Airline Name</label>
                                <input type="text" name="airline_name" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Short Code</label>
                                <input type="text" name="airline_short_code" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <!-- form-group -->
                    <div class="row row-sm mg-b-20">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Airline Country</label>

                                    <select class="form-control select2" name="airline_country" required>
                                        <option>Select Country</option>
                                        @if ($countries)
                                            @foreach ($countries as $my_country)
                                                <option value="<?= $my_country->name ?>"><?= $my_country->name ?></option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- form-group -->

                    <!-- form-group -->

                    <div class="row row-sm mg-b-20">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Airline Image</label>
                                    <input type="file" class="form-control" name="airline_image" />
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






    {{-- </div><!-- az-content-body --> --}}
@endsection
