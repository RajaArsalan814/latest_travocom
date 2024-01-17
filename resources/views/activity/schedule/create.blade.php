@extends('layouts.master')

@push('css')
@endpush

@section('content')
<div class="container-fluid">
    <!-- .row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title pull-left">Create Training Schedule</h3>
                <a class="btn btn-success pull-right" href="{{url('trainings/schedule')}}"><i class="icon-eye"></i>
                    &nbsp; View Trainings</a>
                <div class="clearfix"></div>
                <hr>
                
                <form class="form-horizontal" method="post" action="{{url('store_trainings')}}" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            {{csrf_field()}}
                            
                            <div class="form-group">
                                <label for="saleman_id" class="col-sm-3 control-label">Saleman<strong class="text-danger"> *</strong></label>
                                <div class="col-sm-7">
                                    <select onchange="getCustomer(this.value);" name="saleman_id" id="saleman_id" class="form-control">
                                        @if($employees)
                                        @foreach($employees as $row)
                                        <option value="{{ $row['id_employee'] }}">{{ ucwords($row['employee_name']) }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('saleman_id'))
                                    <span class="invalid-feedback">
                                        <strong class="text-danger">{{ $errors->first('saleman_id') }}</strong>
                                    </span>
                                    @endif 
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="customer_id" class="col-sm-3 control-label">Customers<strong class="text-danger"> *</strong></label>
                                <div class="col-sm-7">
                                    <select name="customer_id" id="customer_id" class="form-control">
                                       <option value="0">Customer not found</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="schedule_date" class="col-sm-3 control-label">Schedule Date</label>
                                <div class="col-sm-7">
                                    <input type="text"
                                           class="form-control{{ $errors->has('schedule_date') ? ' is-invalid' : '' }} "
                                           name="schedule_date" id="schedule_date" value="{{ old('schedule_date') }}" placeholder="" autofocus>
                                    @if ($errors->has('schedule_date'))
                                    <span class="invalid-feedback">
                                        <strong class="text-danger">{{ $errors->first('schedule_date') }}</strong>
                                    </span>
                                    @endif 
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="schedule_time" class="col-sm-3 control-label">Schedule Time</label>
                                <div class="col-sm-7">
                                    <input type="time"
                                           class="form-control{{ $errors->has('schedule_time') ? ' is-invalid' : '' }}"
                                           name="schedule_time" value="{{ old('schedule_time') }}" placeholder="" autofocus>
                                    @if ($errors->has('schedule_time'))
                                    <span class="invalid-feedback">
                                        <strong class="text-danger">{{ $errors->first('schedule_time') }}</strong>
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
        $('#active, #saleman_id, #customer_id').select2();
        $('#schedule_date').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: "dd-mm-yyyy",
                orientation: "auto bottom",
        });
        getCustomer($('#saleman_id option:selected').val());
    });
    
    function getCustomer(saleman_id){
        $('#customer_id').html('');
        $.ajax({
            type: 'POST',
            url: '<?php echo url('trainings/getCustomersBySaleman'); ?>',
            data:{saleman_id: saleman_id, _token: '<?php echo csrf_token(); ?>'},
            success: function(response){
                var option = '';
                var customers = response.customers;
                if(customers.length > 0){
                    for(var i = 0; i < customers.length; i++){
                        option += '<option value='+customers[i]['id_customers']+'>'+customers[i]['customer_name']+'</option>'
                    }
                    $('#customer_id').append(option);
                }
                
            }
            
        });
    }
</script>
@endsection
