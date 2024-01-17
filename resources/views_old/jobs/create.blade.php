@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Jobs</span>
        <span>Add Jobs</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Add New Jobs <span><a href="{{ url('jobs') }}"
                class="btn btn-az-primary" style="float: right">Jobs List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Add Jobs</h5>
                <form method="post" action="{{url('jobs/store')}}">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Job Name</label>
                                    <input type="text" name="job_name" class="form-control" required />
                                </div>
                            </div>
<!--                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Role</label>
                                    <select name="role" class="form-control" id="country-dropdown" multiple="multiple">
                                    <option>Select</option>
                                    @forelse ($roles as $role)
                                    <option value="{{ $role['id_roles'] }}">{{ $role['name'] }}</option>
                                    @empty
                                    No Results Found
                                    @endforelse
                                </select>
                                </div>
                            </div>-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Inquiry Type</label>
                                    <select name="inquiry_type" class="form-control" id="country-dropdown">
                                    <option>Select</option>
                                    <option value="1">Air Ticketing</option>
                                    <option value="2">Open Status</option>
                                    <option value="3">In-Progress Status</option>
                                    <option value="4">Follow-up</option>
                                    
                                </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Job Description</label>
                                    <input type="text" name="job_description" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Job Duration (Hours)</label>
                                    <input type="number" name="duration_hours" class="form-control" value="0" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Job Duration (Minutes)</label>
                                    <input type="number" name="duration_minutes" class="form-control" value="0"/>
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
