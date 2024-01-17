@extends('layouts.master')
@section('content')
<div class="az-content-breadcrumb">
    <span>User Management</span>
    <span>Add User</span>
    {{-- <span>Forms</span> --}}
    {{-- <span>Form Layouts</span> --}}
</div>
<h2 class="az-content-title" style="display: inline">Add New User <span><a href="{{ url('users') }}"
                                                                           class="btn btn-az-primary" style="float: right">Users List</a></span></h2>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="card card-body pd-40">
            <h5 class="card-title mg-b-20">Add User Details</h5>
            @if(Session('alert'))
            <div class="alert alert-card alert-<?php echo Session('alert-class'); ?>" role="alert">
                <?php echo Session('alert'); ?>
                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            @endif



            <form action="{{ url('users/store') }}" method="post" enctype="multipart/form-data">
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
                    {{-- <div class="col-md-6">

                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">User Image</label>
                            <input type="file" class="form-control" name="airline_image" />
                        </div>
                    </div> --}}
                    <div class="col-md-4">

                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">User Name</label>
                            <input name="name" id="name" class="form-control" value="{{ old('name') }}" />
                            @error('name')
                            <span class="form-text text-muted" >
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600" for="email">Email</label>
                            <input name="email" id="email" class="form-control" value="{{ old('email') }}" />
                            @error('email')
                            <span class="form-text text-muted" >
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="az-content-label tx-11 tx-medium tx-gray-600" for="role_id">Role</label>
                        <select id="role_id" name="role_id" class="form-control" >
                            <option value="0">Select</optoin>
                                @foreach($roles as $role)
                            <option {{ old('role_id') == $role['id_roles'] ? 'selected' : '' }} value="{{ $role['id_roles'] }}">{{ $role['name']}}</option>

                            @endforeach
                        </select>

                        @error('role_id')
                        <span class="form-text text-muted" >
                            <strong>{{ $role_id }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="az-content-label tx-11 tx-medium tx-gray-600" for="password">Password </label>
                    <input type="password" name="password" id="password" class="form-control" value="" />
                    @error('password')
                    <span class="form-text text-muted" >
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>

                    <div class="col-md-6">
                         <label class="az-content-label tx-11 tx-medium tx-gray-600" for="confirm_password">Confirm Password </label>
                    <input type="password" name="password_confirmation" id="confirm_password" class="form-control" value="" />
                    @error('password_confirmation')
                    <span class="form-text text-muted" >
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
                </div>

                {{-- <hr><!-- comment --> --}}

                {{-- <div class="row row-sm mg-b-20">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Attachments</label>
                            <input type="file" class="form-control" name="attachments" />
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Reference</label>
                            <input name="username" id="username" class="form-control" value="{{ old('username') }}" />
                            @error('username')
                            <span class="form-text text-muted" >
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Bio</label>
                            <input name="username" id="username" class="form-control" value="{{ old('username') }}" />
                            @error('username')
                            <span class="form-text text-muted" >
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Gender</label>
                            <select class="form-control">
                                <option>Select</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Address</label>
                            <input name="username" id="username" class="form-control" value="{{ old('username') }}" />
                            @error('username')
                            <span class="form-text text-muted" >
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div> --}}

               <button type="submit" onclick="history.back()" class="btn btn-danger btn-block mt-2">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-az-primary btn-block mt-2" style="float: right">
                        Submit
                    </button>
            </form>


        </div>
    </div>
</div><!-- end of main-content -->
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>

</script>
@endsection
