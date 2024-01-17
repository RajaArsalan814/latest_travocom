@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span> Performance Slabs</span>
        <span>Edit Performance Slabs</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Edit Performance Slabs <span><a href="{{ url('performance_slabs') }}"
                class="btn btn-az-primary" style="float: right"> Performance Slabs List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Edit Performance Slabs</h5>
                <form method="post"
                    action="{{ url('performance_slabs/update/' . \Crypt::encrypt($performance_slabs->id_performance_slabs)) }}">
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
                        <div class="col-md-4">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Slab Code <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" value="{{ $performance_slabs->slab_code }}" name="slab_code"
                                            class="form-control" required />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Start Date <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" readonly value="{{ $performance_slabs->start_date }}"
                                            name="start_date" class="form-control fc-datepicker" required>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">End Date <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" readonly name="end_date"
                                            value="{{ $performance_slabs->end_date }}" class="form-control fc-datepicker" required>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Slab Amount <span class="text-danger"><b>*</b></span></label>
                                        <input type="number" min="0" name="slab_amount"
                                            value="{{ $performance_slabs->slab_amount }}" class="form-control" required>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Months <span class="text-danger"><b>*</b></span></label>
                                        <input type="number" min="0" name="month"
                                            value="{{ $performance_slabs->month }}" class="form-control" required>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">No Of Persons <span class="text-danger"><b>*</b></span></label>
                                        <input type="number" min="0" value="{{ $performance_slabs->no_of_persons }}"
                                            name="no_of_persons" class="form-control" required>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Employee</label>
                                        <select name="user" id="" class="form-control">
                                            @forelse ($users as $item)
                                                <option @if ($item->id == $performance_slabs->employee_id) selected @endif
                                                    value="{{ $item->id }}">{{ $item->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
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
