@extends('layouts.master')
@section('content')  
<!-- ===== Page-Content ===== -->
<div class="az-content-breadcrumb">
        <span>Activity Manager</span>
    </div>
    <h2 class="az-content-title" style="display: inline"> Activity List <span>
            <a href="{{ url('users/create') }}" class="btn btn-az-primary" style="float: right">Add Activity</a></span></h2>

    <div class="row">
        <div class="col-md-12">
            @if(Session('alert'))
            <div class="alert alert-card alert-<?php echo Session('alert-class'); ?>" role="alert">
                <?php echo Session('alert'); ?>
                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            @endif
        </div>
    </div>

    <!-- .row -->
    
                    
                <div class="separator-breadcrumb border-top"></div>
              
                <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
                <table id="example2" class="table table-responsive">
                            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID #</th>
                                        <th>Description</th>
                                        <th>Active</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($activity as $row)   
                                    <tr>
                                        <td>{{ $row->id_activities }}</td>
                                        <td>{{ $row->activity }}</td>
                                        <td>{!! $row->active == 'Y' ? '<span class="label label-primary">Yes</span>' : '<span class="label label-danger">No</span>' !!}</td>
                                        <td><span class="label label-info">{{ date('M d, Y', strtotime($row->created_at)) }}</span></td>
                                        <td>
                                            <a class="btn btn-success btn-xs hidden" href="{{url('activity/schedule/'.$row->id_activities)}}"><i class="icon-calender"></i> Schedule</a> 
                                            <a class="btn btn-warning btn-xs" href="{{url('edit_activity/'.$row->id_activities)}}"><i class="icon-pencil"></i> Edit</a> &nbsp;&nbsp;
                                        </td>

                                    </tr>
                                    @endforeach    
                                </tbody>
                            </table>
                        </div>
                    </div>
                
    
</div>
<!-- ===== Page-Content-End ===== -->

<script type="text/javascript">

    $(function(){

    $('#example2').DataTable({
    stateSave: true,
            dom: 'Bfrtip',
            buttons: [
            {
            extend: 'csv',
                    text: 'CSV',
                    title: 'Activity List',
                    className: 'btn btn-default',
                    exportOptions: {
                    columns: 'th:not(:last-child)'
                    }
            },
            {
            extend: 'excel',
                    text: 'Excel',
                    title: 'Activity List',
                    className: 'btn btn-default',
                    exportOptions: {
                    columns: 'th:not(:last-child)'
                    }
            },
            {
            extend: 'pdf',
                    text: 'PDF',
                    title: 'Activity List',
                    className: 'btn btn-default',
                    exportOptions: {
                    columns: 'th:not(:last-child)'
                    }
            },
            {
            extend: 'print',
                    text: 'Print',
                    title: 'Activity List',
                    className: 'btn btn-default',
                    exportOptions: {
                    columns: 'th:not(:last-child)'
                    }
            }
            ]
    });
    });

    @if (\Session::has('message'))
        $.toast({
        heading: 'Success!',
        position: 'top-center',
        text: '{{session()->get('message')}}',
        loaderBg: '#ff6849',
        icon: 'success',
        hideAfter: 3000,
        stack: 6
        });
    @endif

    function deletebrand(brand_id){
        swal({
        title: "Are you sure?",
        text: "Once delete, you will create brand again!",
        type: "warning",
        //buttons: true,
        //dangerMode: true,
        showCancelButton: true,
        //confirmButtonClass: "btn-danger",
        })
            .then((changeurl) => {
            if (changeurl) {
            window.location.href = "<?php echo url('delete_activity'); ?>" + "/" + brand_id;
            } else {
            swal("Your imaginary work is safe!");
            }
            }).catch(swal.noop); ;
    }
</script>

@endsection

