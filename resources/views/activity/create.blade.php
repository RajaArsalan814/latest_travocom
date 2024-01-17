@extends('layouts.master')

@push('css')
@endpush

@section('content')
<div class="container-fluid">
    <!-- .row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title pull-left">Create Activity</h3>
                <a class="btn btn-success pull-right" href="{{url('activity')}}"><i class="icon-eye"></i>
                    &nbsp; View Activity</a>
                <div class="clearfix"></div>
                <hr>
                
                <form class="form-horizontal" method="post" action="{{url('store_activity')}}" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="activity" class="col-sm-3 control-label">Description<strong class="text-danger"> *</strong></label>
                                <div class="col-sm-7">
                                    <input type="text"
                                           class="form-control{{ $errors->has('activity') ? ' is-invalid' : '' }}"
                                           name="activity" value="{{ old('activity') }}" autofocus>
                                    @if ($errors->has('activity'))
                                    <span class="invalid-feedback">
                                        <strong class="text-danger">{{ $errors->first('activity') }}</strong>
                                    </span>
                                    @endif 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="active" class="col-sm-3 control-label">Active</label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="active" id="active">
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group m-b-0">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



</div>
<script>
    $(document).ready(function () {
        $('#active').select2();
    });
</script>
@endsection
