@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span> Escalation Group</span>
        <span>Edit Escalation Group</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Edit Escalation Group <span><a href="{{ url('escalation_group') }}"
                class="btn btn-az-primary" style="float: right"> Escalation Group List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Edit Escalation Group</h5>
                <form method="post" action="{{ url('escalation_group/update/' . \Crypt::encrypt($edit->id_escalation_group)) }}">
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
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Select User</label>
                                       <select name="users" id="" class="form-control" >
                                        @forelse ($users as $item)
                                        <option @if($edit->user_id==$item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
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
