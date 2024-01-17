@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Job list</span>
        <span>Edit Job</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Edit Job <span><a href="{{ url('jobs') }}"
                class="btn btn-az-primary" style="float: right">Job List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Edit Job Details</h5>
                <form method="post" action="{{url('jobs/update/'.\Crypt::encrypt($jobs->id_jobs))}}">
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
                    @csrf
                    <div class="row row-sm mg-b-20">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Job Name</label>
                                    <input type="text" name="job_name" class="form-control" value="{{ $jobs->job_name }}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Inquiry Type</label>
                                    <select name="inquiry_type" class="form-control" id="country-dropdown">
                                    <option>Select</option>
                                    <option <?= $jobs->inquiry_type == 1 ? 'selected' : ''?> value="1">Air Ticket</option>
                                    <option <?= $jobs->inquiry_type == 2 ? 'selected' : ''?> value="2">Inquiry Status Open</option>
                                    <option <?= $jobs->inquiry_type == 3 ? 'selected' : ''?> value="3">Inquiry Status In-Progress</option>
                                    <option <?= $jobs->inquiry_type == 4 ? 'selected' : ''?> value="4">Followup</option>
                                   
                                </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Job Description</label>
                                    <input type="text" name="job_description" class="form-control" value="{{ $jobs->job_description }}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Job Duration (Hours)</label>
                                    <input type="number" name="duration_hours" class="form-control" value="{{ $jobs->job_duration_hours }}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Job Duration (Minutes)</label>
                                    <input type="number" name="duration_minutes" class="form-control" value="{{ $jobs->job_duration_minutes }}"/>
                                </div>
                            </div>
                           
                        </div>
                    
                    <input type="hidden" name="h_id" value="{{ \Crypt::encrypt($jobs->id_jobs) }}">
                    <div class="row row-sm mg-b-20">
                        <div class="form-group">
                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Job Status</label>
                        <select class="form-control select2" name="status">
                            <option <?= $jobs->status == 1 ? "selected" : "" ?> value="1">Active</option>
                            <option <?= $jobs->status == 0 ? "selected" : "" ?> value="0">Deactive</option>
                            
                        </select>
                    </div>

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
