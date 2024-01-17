@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>My Bank Account list</span>
        <span>Edit My Bank Account</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Edit My Bank Account <span><a href="{{ url('my_bank_accounts') }}"
                class="btn btn-az-primary" style="float: right">My Bank Account List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Edit My Bank Account Details</h5>
                <form method="POST" action="{{url('my_bank_accounts/update/'.\Crypt::encrypt($my_bank->id_bank_accounts))}}">
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
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Bank Name  <span class="text-danger">*</span></label>
                                        <input type="text" name="bank_name"  class="form-control" value="{{ $my_bank->bank_name }}" required />
                                    </div>
                                </div>

                            </div>
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Account Number <span class="text-danger">*</span></label>
                                        <input type="text" name="account_number" class="form-control" value="{{ $my_bank->account_number }}" required  />
                                    </div>
                                </div>

                            </div>
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Branch Address</label>
                                        <input type="text" name="branch_address" class="form-control" value="{{ $my_bank->branch_address }}" >
                                    </div>
                                </div>

                            </div>


                        </div>

                    <a type="button" href="{{ url('my_bank_accounts') }}"  class="btn btn-danger btn-block mt-2">
                        Back
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
