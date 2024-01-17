@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Currency Types list</span>
        <span>Edit Currency Types</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Edit Currency Types <span><a href="{{ url('currency_exchange') }}"
                class="btn btn-az-primary" style="float: right">Currency Types List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Edit Currency Types Details</h5>
                <form method="POST" action="{{url('currency_exchange/update/'.\Crypt::encrypt($edit->id_currency_exchange_rates))}}">
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Currency Name</label>
                                    <input type="text" value="{{ $edit->currency_name }}" name="currency_name" class="form-control" required />
                                </div>
                            </div>

                        </div>
                        <div class="row row-sm mg-b-20">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Currency Rate</label>
                                    <input type="text" value="{{ $edit->currency_rate }}" name="currency_rate" class="form-control" required />
                                </div>
                            </div>

                        </div>
                        <div class="row row-sm mg-b-20">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Currency Symbols</label>
                                    <input type="text" value="{{ $edit->currency_symbols }}" name="currency_symbols" class="form-control" required />
                                </div>
                            </div>

                        </div>

                    <a type="button" href="{{ url('/currency_exchange') }}" class="btn btn-danger btn-block mt-2">
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
