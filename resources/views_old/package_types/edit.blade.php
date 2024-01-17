@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Package Types list</span>
        <span>Edit Package Types</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Edit Package Types <span><a href="{{ url('package_types') }}"
                class="btn btn-az-primary" style="float: right">Package Types List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Edit Package Types Details</h5>
                <form method="POST" action="{{url('package_types/update/'.\Crypt::encrypt($edit_packages_types->id_packages_types))}}">
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
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Package Types Name</label>
                                    <input type="text" name="type_name" class="form-control" value="{{ $edit_packages_types->type_name }}" required />
                                </div>
                            </div>
                        <div class="form-group">
                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Package Type Status</label>
                        <select class="form-control select2" name="package_status">
                            <option <?= $edit_packages_types->status == 1 ? "selected" : "" ?> value="1">Active</option>
                            <option <?= $edit_packages_types->status == 0 ? "selected" : "" ?> value="0">Deactive</option>

                        </select>
                    </div>

                        </div>

                    <a type="button" href="{{ url('package_types') }}"  class="btn btn-danger btn-block mt-2">
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
