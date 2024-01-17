@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Addons</span>
        <span>Edit Addon <badge class="badge badge-info badge-md"><?= $edit->addon_name ?></badge></span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Edit Addon <span><a href="{{ url('addons') }}"
                class="btn btn-az-primary" style="float: right">Addons List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}

    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Edit Addon</h5>
                <form method="post" action="{{ url('addons/update/' . \Crypt::encrypt($edit->id_addons)) }}">
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
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Name <span
                                                class="text-danger"><b>*</b></span></label>
                                        <input type="text" value="{{ $edit->addon_name }}" name="addon_name"
                                            class="form-control" required />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row-sm mg-b-20">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Cost Price <span
                                            class="text-danger"><b>*</b></span></label>
                                    <input type="number" min="1" value="{{ $edit->addon_cost_price }}"
                                        name="cost_price" class="form-control" required />
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="row-sm mg-b-20">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Selling Price <span
                                            class="text-danger"><b>*</b></span></label>
                                    <input type="number" min="1" value="{{ $edit->addon_selling_price }}"
                                        name="sell_price" class="form-control" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row row-sm mg-b-20">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Status <span class="text-danger"><b>*</b></span></label>
                                    <select name="status" id="" class="form-control" required>

                                        <option <?= $edit->status == 1 ? 'selected' : '' ?> value="1">Active
                                        </option>
                                        <option <?= $edit->status == 0 ? 'selected' : '' ?> value="0">Deactive
                                        </option>

                                    </select>
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
