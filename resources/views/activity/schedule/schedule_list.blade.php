@extends('layouts.master')

@section('content')  
@push('css')
    <!--<link href='{{asset('plugins/components/fullcalendar/fullcalendar.css')}}' rel='stylesheet'>-->
    <link href="{{ asset('plugins/components/fullcalendar/dist/fullcalendar.css') }}"  rel="stylesheet"/>
    <link href="{{ asset('plugins/components/fullcalendar/dist/scheduler.min.css') }}" rel="stylesheet" />
    
@endpush
<!-- ===== Page-Content ===== -->
<div class="container-fluid">
    <!-- .row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-md-2">
                        <label for="saleman_id">Saleman</label>
                        <select class="form-control" name="saleman_id" id="saleman_id" onchange="activityFunction();">
                            @if($employees)
                            @foreach($employees as $row)
                            <option value="{{ $row['id_employee'] }}">{{ $row['employee_name'] }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="activities">Activities</label>
                        <select class="form-control" name="activities" id="activities" onchange="activityFunction();" >
                            @if($activities)
                            @foreach($activities as $row)
                            <option value="{{ $row['id_activities'] }}">{{ $row['activity'] }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="getstatus">Status</label>
                        <select class="form-control" name="getstatus" id="getstatus" onchange="activityFunction();" >
                            <option value="all">All</option>
                            <option value="pending">Pending</option>
                            <option value="process">Process</option>
                            <option value="complete">Complete</option>
                            <option value="canceled">Canceled</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title pull-left">Activity Scheduler</h3>
                <a  class="btn btn-success pull-right" href="#addSchedule" data-toggle="modal" data-backdrop="static"><i class="icon-plus"></i> Add New</a>
                <div class="clearfix"></div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div id="activity_schedule"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Add Modal -->
<div id="addSchedule" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <form id="addScheduleForm" action="{{ url('activitys/schedule/add') }}" method="post">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Activity Schedule</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h5 id="activityname"></h5>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="customer_id">Customers<strong class="text-danger"> *</strong></label>
                            <select onchange="tablerefresh();" name="customer_id" id="customer_id" class="form-control">
                                <option value="0">Customer not found</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="schedule_date">Schedule Date<strong class="text-danger"> *</strong></label>
                            <input type="text" class="form-control customdate" name="schedule_date" id="schedule_date" value="" placeholder="" >
                        </div>
                        <div class="col-md-6">
                            <label for="start_time">Start Time<strong class="text-danger"> *</strong></label>
                            <input type="time" class="form-control" name="start_time" id="start_time" value="" >
                        </div>
                        <div class="col-md-6">
                            <label for="end_time">End Time<strong class="text-danger"> *</strong></label>
                            <input type="time" class="form-control" name="end_time" id="end_time" value="" >
                        </div>
                        <div class="col-md-6">
                            <label for="remarks">Remarks</label>
                            <input type="text" class="form-control" name="remarks" id="remarks" value="" >
                        </div>
                        <div class="col-md-6">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="process">In Process</option>
                                <option value="complete">Complete</option>
                                <option value="canceled">Canceled</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <button onclick="add();" type="button" class="btn btn-success pull-right btn-xs" >Add</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="scheduletable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="hidden"></th>
                                            <th>Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                            <th><i class="fa fa-trash"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="activity_id" id="activity_id" value="" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button onclick="insert();" type="button" class="btn btn-primary" >Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Schedule Add Modal -->

<!-- Schedule Edit Modal -->
<div id="editSchedule" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <form id="editScheduleForm" action="{{ url('trainings/schedule/edit/status') }}" method="post">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Activity Schedule</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="schedule_date">Schedule Date<strong class="text-danger"> *</strong></label>
                            <input type="text" class="form-control customdate" name="schedule_date" id="schedule_date" value="" placeholder="" >
                        </div>
                        <div class="col-md-6">
                            <label for="start_time">Start Time<strong class="text-danger"> *</strong></label>
                            <input type="time" class="form-control" name="start_time" id="start_time" value="" >
                        </div>
                        <div class="col-md-6">
                            <label for="end_time">End Time<strong class="text-danger"> *</strong></label>
                            <input type="time" class="form-control" name="end_time" id="end_time" value="" >
                        </div>
                        <div class="col-md-6">
                            <label for="remarks">Remarks</label>
                            <input type="text" class="form-control" name="remarks" id="remarks" value="" >
                        </div>
                        <div class="col-md-6">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="process">In Process</option>
                                <option value="complete">Complete</option>
                                <option value="canceled">Canceled</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                   <input type="hidden" name="activity_id" id="activity_id" value="" />
                    <input type="hidden" id="activity_schedule_detail_id" name="activity_schedule_detail_id" value="" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button onclick="update();" type="button" class="btn btn-primary" >Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Schedule Edit Modal -->

<!-- ===== Page-Content-End ===== -->
@endsection

@push('js')
    <!--<script src='{{asset('plugins/components/calendar/jquery-ui.min.js')}}'></script>-->
    <!--<script src='{{asset('plugins/components/moment/moment.js')}}'></script>-->
    <!--<script src='{{asset('plugins/components/calendar/dist/fullcalendar.min.js')}}'></script>-->
    <!--<script src='{{asset('plugins/components/fullcalendar/fullcalendar.js')}}'></script>-->
    
    <!--<link href="assets/plugins/fullcalendar/dist/fullcalendar.css" rel="stylesheet" />-->
        
    <script src='{{ asset('plugins/components/fullcalendar/dist/fullcalendar.min.js') }}'></script>
    <script src='{{ asset('plugins/components/fullcalendar/dist/scheduler.min.js') }}'></script>
    
    <script type="text/javascript">
        $('#saleman_id, #customer_id, #activities, #getstatus').select2();
        var dateToday = new Date(); 
        $('.customdate').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: "dd-mm-yyyy",
                orientation: "auto bottom",
                minDate: dateToday
        });
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();//view.name === "agendaWeek"
        var view_style = 'agendaWeek';
        var events = [];
        
        $(document).ready(function(){
            //getCustomer($('#saleman_id option:selected').val());
            activityFunction();
            //calendar_load();
            //console.log(new Date(y, m, d, 15, 0));
        });
        
        function calendar_load(saleman_id){
            var calendar = $('#activity_schedule').fullCalendar({
                       schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
                       defaultView: view_style,
                       slotDuration: '00:15',
                       slotLabelInterval: '00:15',
                       slotMinutes: 05,
                       allDaySlot: false,
                       minTime: '10:00:00',
                       maxTime: '20:59:00',
                       height: $(window).height() - 150,
                       resourceAreaWidth: '10%',
                       resourceLabelText: 'Schedular List',
                       //slotWidth: 60,
                       header: {
                           left: 'prev, next',
                           center: 'title',
                           right: 'agendaDay,agendaWeek,month'//agendaWeek,agendaDay
                       },
                       //resources: customerList,
                       firstDay: 1,
                       handleWindowResize: true,
                       fixedWeekCount: false,
                       /*
                           editable: true allow user to edit events.
                       */
                       editable: true,
                       eventClick: function(calEvent, jsEvent, view) {
                           if(view.name == view_style){
                                if(calEvent.editable == false){
                                    swal({
                                        title: "This schedule has been completed / canceled",
                                        type: "warning",
                                        confirmButtonText: 'OK!'
                                    });
                                    return false;
                                }
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo url('activity/schedule/edit/status') ?>/'+calEvent.id,
                                    data:{activity_schedule_detail_id: calEvent.id, _token: '<?php echo csrf_token(); ?>'},
                                    dataType: 'JSON',
                                    success: function(response){
                                        var data = response.event;
                                        $('#editScheduleForm #schedule_date').val(data.schedule_date);
                                        $('#editScheduleForm #start_time').val(data.start_time);
                                        $('#editScheduleForm #end_time').val(data.end_time);
                                        $('#editScheduleForm #remarks').val(data.remarks);
                                        $('#editScheduleForm #status').val(data.status);
                                        $('#editScheduleForm #activity_schedule_detail_id').val(calEvent.id);

                                        $('#editSchedule').modal({
                                            'backdrop': 'static',
                                            'keyboard': false
                                        });
                                    }
                                });

                             }
                       },
                       dayClick: function(date, jsEvent, view, resource) {
                           if(view.name == 'month' || view.name == 'agendaDay'){
                               $('#activity_schedule').fullCalendar('changeView', view_style);
                               console.log('dayclick');
                           }
                       },
                       select: function(start, end, jsEvent, view, resource) {
                           console.log('select');
                           if(view.name == view_style){
                               console.log('sele');
                           }
                       },
                       eventResize: function(event, delta, revertFunc, jsEvent, ui, view) {
                           if(view.name == 'agendaWeek'){
                               //console.log(event.id);
                               $.ajax({
                                   type: 'POST',
                                   url: '<?php echo url('activity/schedule/update/time'); ?>',
                                   data:{
                                       'activity_schedule_detail_id': event.id,
                                       'start_time': event.start.format(),
                                       'end_time': event.end.format(),
                                       _token: '<?php echo csrf_token(); ?>'
                                   },
                                   dataType: 'json',
                                   success: function(response){
                                       if(response.message == 'success'){
                                            $.toast({
                                                heading: 'Success!',
                                                position: 'top-center',
                                                text: 'Schedule Time Update!',
                                                loaderBg: '#ff6849',
                                                icon: 'success',
                                                hideAfter: 3000,
                                                stack: 6
                                            });
                                       }
                                   }
                               });
                               $('#activity_schedule').fullCalendar('refetchEvents');
                           }
                           //console.log('resize');
                       },
                       eventDrop: function(event, delta, revertFunc, jsEvent, ui, view){
                            if(view.name == 'agendaWeek'){
                               //console.log(event.id);
                               $.ajax({
                                   type: 'POST',
                                   url: '<?php echo url('activity/schedule/update/date'); ?>',
                                   data:{
                                       'activity_schedule_detail_id': event.id,
                                       'start_time': event.start.format(),
                                       'end_time': event.end.format(),
                                       _token: '<?php echo csrf_token(); ?>'
                                   },
                                   dataType: 'json',
                                   success: function(response){
                                       if(response.message == 'success'){
                                            $.toast({
                                                heading: 'Success!',
                                                position: 'top-center',
                                                text: 'Schedule Date Update!',
                                                loaderBg: '#ff6849',
                                                icon: 'success',
                                                hideAfter: 3000,
                                                stack: 6
                                            });
                                       }
                                   }
                               });
                               $('#activity_schedule').fullCalendar('refetchEvents');
                           }
                           console.log('Event Drop');
                       },
                       eventRender: function(event, element) {
                            console.log('event render: '+event);
                       },
                       events: function(start, end, timezone, callback){
                            $.ajax({
                                 type: 'POST',
                                 url: '<?php echo url('activity/schedule/data'); ?>',
                                 data:{
                                      start: start.format('YYYY-MM-DD'),
                                      end: end.format('YYYY-MM-DD'),
                                     _token: '<?php echo csrf_token(); ?>',
                                     saleman_id: $('#saleman_id option:selected').val(),
                                     activity_id: $('#activities option:selected').val(),
                                     status: $('#getstatus option:selected').val()
                                 },
                                 dataType: 'json',
                                 success: function(response){
                                     var data = response.event;
                                     var events = [];
                                     for(var i = 0; i < data.length; i++){
                                        var bgColor = 'black';
                                        var textColor = 'white';
                                        var border = '#000';
                                        var editable = true;
                                        if(data[i]['status'] == 'process'){
                                            bgColor = '#00beda';
                                            textColor = 'white';
                                            editable = true;
                                        }else if(data[i]['status'] == 'complete'){
                                            bgColor = 'purple';
                                            textColor = 'white';
                                            editable = false;
                                        }else if(data[i]['status'] == 'canceled'){
                                            bgColor = 'red';
                                            textColor = 'white';
                                            editable = false;
                                        }
                                 
                                        events.push({
                                            id: data[i]['id'],
                                            title: data[i]['title'],
                                            start: data[i]['start'],
                                            end: data[i]['end'],
                                            backgroundColor: bgColor,
                                            textColor: textColor,
                                            borderColor: border,
                                            editable: editable
                                        });
                                     }

                                     callback(events);
                                 }
                             });
                        },
                       //eventColor: 'black'
                    });
        }
        
        function getCustomer(saleman_id){
            $('#customer_id').html('');
            $.ajax({
                type: 'POST',
                url: '<?php echo url('activity/getCustomersBySaleman'); ?>',
                data:{saleman_id: saleman_id, _token: '<?php echo csrf_token(); ?>'},
                success: function(response){
                    var option = '';
                    var customers = response.customers;
                    if(customers.length > 0){
                        
                        for(var i = 0; i < customers.length; i++){
                            option += '<option value='+customers[i]['id_customers']+'>'+customers[i]['customer_name']+'</option>'
                        }
                        $('#customer_id').append(option);
                        //calendar_load();
                        //$("#training_schedule").fullCalendar("refetchEvents");
                        //$("#training_schedule").fullCalendar("rerenderEvents");
                    }else{
                        $('#customer_id').append('<option value=0>Customer not found</option>');
                    }

                }
               

            });
            calendar_load(saleman_id);
            //refreshcalendar();
            //console.log(customerList);
            //calendar.fullCalendar('unselect');
            //return false;
            
        }
        
        function refreshcalendar(){
            //console.log("refresh: "+events);
            //$('#activity_schedule').fullCalendar('removeEventSource', events);
            //$('#activity_schedule').fullCalendar('addEventSource', events);
            $('#activity_schedule').fullCalendar('refetchEvents');
        }
        
        function activityFunction(){
            var tr = $('#activities option:selected');
            var salman = $('#saleman_id option:selected');
            
            $('#activityname').html('').html('<strong>'+tr.text()+'</strong>');
            
            getCustomer(salman.val()); 
            refreshcalendar();
            
            $('#addSchedule #activity_id').val(tr.val()); 
            calendar_load(salman.val());
        }
        
        //add date/start time/end time/status/ functions start.....
        function add() {

            if ($("#addSchedule #schedule_date").val() === "") {
                swal({
                    title: "Schedule date should not be empty!",
                    type: "info",
                    confirmButtonText: 'OK!'
                });
                return false;
            }
            if ($("#addSchedule #start_time").val() === "") {
                swal({
                    title: "start time should not be empty!",
                    type: "info",
                    confirmButtonText: 'OK!'
                });
                return false;
            }
            if ($("#addSchedule #end_time").val() === "") {
                swal({
                    title: "end time should not be empty!",
                    type: "info",
                    confirmButtonText: 'OK!'
                });
                return false;
            }

            var mhtml = "";
            var exists;
            var count = 1;
            var schedule_date =  $("#addSchedule #schedule_date").val();
            var start_time =  $("#addSchedule #start_time").val();
            var end_time =  $("#addSchedule #end_time").val();
            var remarks =  $("#addSchedule #remarks").val();
            var status =  $("#addSchedule #status").val();
            var match = schedule_date+'|'+start_time+'|'+end_time;
            var match_data = Math.random();

            //if ($("#product option:selected").val() > 0) {

            $('#scheduletable').find("td.id").each(function(index) {
                if ($(this).html() === match) {
                    exists = 1;
                }
            });

            mhtml += '<tr>';
            mhtml += '<td match-data='+match_data+' class="id hidden">' + match + '</td>';
            mhtml += '<td>' + schedule_date + '</td>';
            mhtml += '<td>' + start_time + '</td>';
            mhtml += '<td>' + end_time + '</td>';
            mhtml += '<td>' + status + '</td>';
            mhtml += '<td>' + remarks + '</td>';
            mhtml += '<td><span class="btn btn-danger btn-xs" onclick="removeschedule(' + match_data + ')" style="cursor:pointer">x</span></td>';
            mhtml += "</tr>";
            //}
            if (exists !== 1) {
                $("#scheduletable tbody").append(mhtml);
            } else {
                swal({
                    title: "Schedule already added!",
                    text: 'If you want to change this, please remove and add again.',
                    type: "info",
                    confirmButtonText: 'OK!'
                });
            }
        }

        function removeschedule(val) {
            $('#scheduletable').find("td").each(function(index) {
                if ($(this).attr('match-data') == val) {
                    $(this).closest('tr').remove();
                }
            });
        }

        function add_storeOTblValues() {
            var TableData = new Array();
            $('#addSchedule #scheduletable tbody tr').each(function(row, tr) {
                TableData[row] = {
                     "schedule_date": $(tr).find('td:eq(1)').text()
                    , "start_time": $(tr).find('td:eq(2)').text()
                    , "end_time": $(tr).find('td:eq(3)').text()
                    , "status": $(tr).find('td:eq(4)').text()
                    , "remarks": $(tr).find('td:eq(5)').text()
                }
            });
            //TableData.shift();  // first row will be empty - so remove
            return TableData;
        }
        
        function tablerefresh(){
            //$('#scheduletable tbody').html('');
        }
        
        function insert(){
            var ScheduleData;
            ScheduleData = add_storeOTblValues();
            if($('#addSchedule #customer_id option:selected').val() == '' || $('#addSchedule #customer_id option:selected').val() == 0){
                swal({
                    title: "Please select customer",
                    type: "warning",
                    confirmButtonText: 'OK!'
                });
                return false;
            }
            if(ScheduleData.length > 0){
            }else{
                swal({
                    title: "Please add schedule",
                    type: "warning",
                    confirmButtonText: 'OK!'
                });
                return false;
            }
            var customer_id = $('#addSchedule #customer_id option:selected').val();
            var saleman_id = $('#saleman_id option:selected').val();
            var activity_id = $('#addSchedule #activity_id').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo url('activity/schedule/store'); ?>',
                dataType: 'json',
                data:{
                    ScheduleData: ScheduleData, 
                    customer_id: customer_id, 
                    saleman_id: saleman_id, 
                    activity_id: activity_id,
                    _token: '<?php echo csrf_token(); ?>'
                },
                success: function(response){
                    if(response.message == 'success'){
                        $.toast({
                            heading: 'Success!',
                            position: 'top-center',
                            text: 'Activity Schedule has been added!',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3000,
                            stack: 6
                        });
                        
                        $('#addScheduleFrom #schedule_date').val('');
                        $('#addScheduleFrom #start_time').val('');
                        $('#addScheduleFrom #end_time').val('');
                        $('#addScheduleFrom #remarks').val('');
                        $('#addSchedule').modal('hide');
                        setTimeout(function(){ 
                            $('#activity_schedule').fullCalendar('refetchEvents');
                        }, 500);
                    }else{
                        $.toast({
                            heading: 'Warning!',
                            position: 'top-center',
                            text: 'Activity Schedule has not been added',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3000,
                            stack: 6
                        });
                        setTimeout(function(){ 
                            $('#activity_schedule').fullCalendar('refetchEvents');
                        }, 500);
                    }
                }
            });
        }
        
        function update(){
            if($('#editSchedule #schedule_date').val() == '' || $('#editSchedule #start_time').val() == '' || $('#editSchedule #end_time').val() == 0){
                swal({
                    title: "Please select date, start time, end time",
                    type: "warning",
                    confirmButtonText: 'OK!'
                });
                return false;
            }
            
            //var id = $('#training_schedule_detail_id').val();
            
            $.ajax({
                type: 'POST',
                url: '<?php echo url('activity/schedule/edit/status'); ?>',
                dataType: 'json',
                data:{
                    _method: 'PUT',
                    activity_schedule_detail_id: $('#activity_schedule_detail_id').val(),
                    schedule_date: $('#editSchedule #schedule_date').val(),
                    start_time: $('#editSchedule #start_time').val(),
                    end_time: $('#editSchedule #end_time').val(),
                    remarks: $('#editSchedule #remarks').val(),
                    status: $('#editSchedule #status').val(),
                    _token: '<?php echo csrf_token(); ?>'
                },
                success: function(response){
                    if(response.message == 'success'){
                        $.toast({
                            heading: 'Success!',
                            position: 'top-center',
                            text: 'Activity Schedule has been updated!',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3000,
                            stack: 6
                        });
                        
                        $('#editScheduleFrom #schedule_date').val('');
                        $('#editScheduleFrom #start_time').val('');
                        $('#editScheduleFrom #end_time').val('');
                        $('#editScheduleFrom #remarks').val('');
                        $('#editSchedule').modal('hide');
                        setTimeout(function(){ 
                            $('#activity_schedule').fullCalendar('refetchEvents');
                        }, 500);
                    }else{
                        $.toast({
                            heading: 'Warning!',
                            position: 'top-center',
                            text: 'Activity Schedule has not been updated',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3000,
                            stack: 6
                        });
                        setTimeout(function(){ 
                            $('#activity_schedule').fullCalendar('refetchEvents');
                        }, 500);
                    }
                }
            });
        }
    </script>
@endpush

