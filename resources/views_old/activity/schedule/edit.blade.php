@extends('layouts.master')

@push('css')
@endpush

@section('content')
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">

                    <h3 class="box-title pull-left">Edit Training</h3>
                    <a class="btn btn-success pull-right" href="{{url('trainings')}}"><i class="icon-eye"></i>
                        &nbsp; View Trainings</a>
                    <div class="clearfix"></div>
                    <hr>
                    <form class="form-horizontal" method="post" action="{{url('update_trainings/'.$trainings->id_trainings)}}" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="training_type" class="col-sm-3 control-label">Training Type<strong class="text-danger"> *</strong></label>
                                    <div class="col-sm-7">
                                        <select name="training_type" id="training_type" class="form-control">
                                            @if($training_type)
                                            @foreach($training_type as $row)
                                            <option {{ $trainings->training_type == $row['id_training_type'] ? "selected" : "" }} value="{{ $row['id_training_type'] }}">{{ $row['title'] }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('training_type'))
                                        <span class="invalid-feedback">
                                            <strong class="text-danger">{{ $errors->first('training_type') }}</strong>
                                        </span>
                                        @endif 
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="description" class="col-sm-3 control-label">Description<strong class="text-danger"> *</strong></label>
                                    <div class="col-sm-7">
                                        <input type="text"
                                               class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                               name="description" value="{{ $trainings->description && $trainings->description !== '' ? $trainings->description : old('description') }}" placeholder="Description" autofocus>
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback">
                                                <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif 
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="duration" class="col-sm-3 control-label">Duration</label>
                                    <div class="col-sm-7">
                                        <input type="text"
                                               class="form-control{{ $errors->has('duration') ? ' is-invalid' : '' }}"
                                               name="duration" value="{{ $trainings->duration && $trainings->duration !== '' ? $trainings->duration : old('duration') }}" placeholder="e.g: 60 Minutes" autofocus>
                                        @if ($errors->has('duration'))
                                            <span class="invalid-feedback">
                                                <strong class="text-danger">{{ $errors->first('duration') }}</strong>
                                            </span>
                                        @endif 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="active" class="col-sm-3 control-label">Active</label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="active" id="active">
                                            <option {{  $trainings->active == "Y" ? 'selected' : '' }} value="Y">Yes</option>
                                            <option  {{  $trainings->active == "N" ? 'selected' : '' }} value="N">No</option>
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
    $(document).ready(function(){
        $('#active').select2();
    });
</script>
@endsection

