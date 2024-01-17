@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Office Working Hours</span>
        <span>Edit Office Working Hours</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Edit New Office Working Hours <span><a
                href="{{ url('office_working_hours') }}" class="btn btn-az-primary" style="float: right">Office Working Hours
                List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Edit Office Working Hours</h5>
                <form method="post" action="{{ url('office_working_hours/update/'.\Crypt::encrypt($office_working_hour->id_office_working_hour)) }}">
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
                        <div class="col-md-12">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Day Of
                                            Week</label>
                                        <Select class="form-control" name="day_of_week">
                                            <option @if($office_working_hour->day_of_week=="Monday") selected @endif value="Monday">Monday</option>
                                            <option @if($office_working_hour->day_of_week=="Monday-Saturday") selected @endif value="Monday-Saturday">Monday-Saturday</option>
                                            <option @if($office_working_hour->day_of_week=="Tuesday") selected @endif value="Tuesday">Tuesday</option>
                                            <option @if($office_working_hour->day_of_week=="Wednesday") selected @endif value="Wednesday">Wednesday</option>
                                            <option @if($office_working_hour->day_of_week=="Thursday") selected @endif value="Thursday">Thursday</option>
                                            <option @if($office_working_hour->day_of_week=="Friday") selected @endif value="Friday">Friday</option>
                                            <option @if($office_working_hour->day_of_week=="Saturday") selected @endif value="Saturday">Saturday</option>
                                            <option @if($office_working_hour->day_of_week=="Sunday") selected @endif value="Sunday">Sunday</option>
                                        </Select>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Start
                                            Time</label>
                                        <input type="time" name="start_time" value="{{$office_working_hour->start_time}}" class="form-control" required />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Select End Time</label>
                                        <input type="time" value="{{$office_working_hour->end_time}}" name="end_time" class="form-control" required />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <button type="submit" onclick="history.back()" class="btn btn-danger btn-block mt-2">
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
