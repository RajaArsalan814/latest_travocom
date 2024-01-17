@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Airline list</span>
        <span>Edit Airline</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Edit Airline <span><a href="{{ url('airlines') }}"
                class="btn btn-az-primary" style="float: right">Airline List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row row-sm mg-b-20">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Edit Airline Details</h5>
                <form method="POST" action="{{ url('airlines/update/' . \Crypt::encrypt($edit_airline->id_airlines)) }}"
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
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Airline Name</label>
                                <input type="text" value="{{ $edit_airline->Airline }}" name="airline_name"
                                    class="form-control" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Short Code</label>
                                <input type="text" value="{{ $edit_airline->ICAO }}" name="airline_short_code"
                                    class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <!-- form-group -->
                    <?php
                    $all_countries = \App\countries::all();
                    ?>

                    <div class="row row-sm mg-b-20">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Airline Contact</label>
                                <select class="form-control select2" name="airline_country">
                                    <option>Select Country</option>
                                    @if ($all_countries)
                                        @foreach ($all_countries as $my_country)
                                            <option <?= $my_country->name == $edit_airline->Country ? 'selected' : '' ?>
                                                value="<?= $my_country->name ?>"><?= $my_country->name ?></option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- form-group -->
                    @csrf
                    <?php
                    if (!empty($edit_airline->airline_image)) {
                        $image = url('/uploads/airlines_images/' . $edit_airline->airline_image);
                    } else {
                        $image = url('/uploads/airlines_images/airline_default.png');
                    }
                    ?>
                    <!-- form-group -->
                    <input type="hidden" name="a_id" value="{{ \Crypt::encrypt($edit_airline->id_airlines) }}">
                    <div class="row row-sm mg-b-20">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600 mt-2">Airline Image</label>
                                    <div>
                                        <div class="col-md-12  mb-4">
                                            <img src="<?= $image ?>" style="border-radius: 50%;height:100px;width:100px;"
                                                alt="" srcset="">
                                        </div>
                                    </div>
                                    <input type="file" class="form-control" name="airline_image" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- form-group -->
                    <div class="row row-sm mg-b-20">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Airline Status</label>
                                <select class="form-control select2" name="airline_status">
                                    <option <?= $edit_airline->airline_status == 1 ? 'selected' : '' ?> value="1">
                                        Active
                                    </option>
                                    <option <?= $edit_airline->airline_status == 0 ? 'selected' : '' ?> value="0">
                                        Deactive
                                    </option>

                                </select>
                            </div>
                        </div>
                    </div>


                    <button type="submit" onclick="history.back()" class="btn btn-danger btn-block mt-2">
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
