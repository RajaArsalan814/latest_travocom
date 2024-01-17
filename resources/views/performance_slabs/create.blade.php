@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span> Performance Slabs</span>
        <span>Add Performance Slabs</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Add Performance Slabs <span><a href="{{ url('performance_slabs') }}"
                class="btn btn-az-primary" style="float: right">Performance Slabs
                List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Add Performance Slabs</h5>
                <form method="post" action="{{ url('performance_slabs/store') }}">
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
                                        <input type="text" name="slab_code" class="form-control" required />
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">

                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Start Date <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" name="start_date" id="start_date" placeholder="DD-MM-YYYY"
                                            class="form-control fc-datepicker" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">

                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">End Date <span class="text-danger"><b>*</b></span></label>
                                        <input type="text" name="end_date" id="end_date" placeholder="DD-MM-YYYY"
                                            class="form-control fc-datepicker" required>
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
                                        <input type="number" min="0" name="slab_amount" class="form-control"
                                            required>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">

                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Months <span class="text-danger"><b>*</b></span></label>
                                        <input type="number" min="0" name="month" class="form-control" required>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">

                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">No Of Persons <span class="text-danger"><b>*</b></span></label>
                                        <input type="number" min="0" name="no_of_persons" class="form-control"
                                            required>
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
                                            @if ($users)
                                                @foreach ($users as $item)
                                                    <option @if ($item->id == auth()->user()->id) selected @endif
                                                        value="{{ $item->id }}">
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            @endif
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
                        Submit
                    </button>
                </form>
            </div>
            <!-- card -->
        </div>
        <!-- col -->
    </div>


@endsection

@push('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script>
        $(document).ready(function() {
            // Initialize the Datepicker for the "Start Date"
            $("#start_date").datepicker({
                dateFormat: 'dd-mm-yy',
                minDate: 0, // Disable backward dates (past dates)
                onSelect: function(selectedDate) {
                    // When a date is selected in the "Start Date" field, update the options for the "End Date" field
                    $("#end_date").datepicker("option", "minDate", selectedDate);
                }
            });

            // Initialize the Datepicker for the "End Date"
            $("#end_date").datepicker({
                dateFormat: 'dd-mm-yy',
                minDate: 0, // Disable backward dates (past dates)
            });
        });
    </script>
@endpush
