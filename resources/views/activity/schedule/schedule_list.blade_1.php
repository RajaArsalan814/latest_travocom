@extends('layouts.master')

@section('content')  
<!-- ===== Page-Content ===== -->
<div class="container-fluid">
    <!-- .row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title pull-left">Training Schedule List</h3>
                <a  class="btn btn-success pull-right" href="{{url('trainings/schedule/create', [$training_id])}}"><i class="icon-plus"></i> Add New</a>
                <div class="clearfix"></div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID #</th>
                                        <th>Customer</th>
                                        <th>Saleman</th>
                                        <th>Schedule Date</th>
                                        <th>Schedule Time</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($schedules as $row)   
                                    <tr>
                                        <td>{{ $row->id_training_schedule }}</td>
                                        <td>{{ getCustomerById($row->customer_id)['customer_name'] }}</td>
                                        <td>{{ getSalemanById($row->saleman_id) }}</td>
                                        <td>{{ $row->schedule_date }}</td>
                                        <td>{{ $row->schedule_time }}</td>
                                        <td><span class="label label-info">{{ date('M d, Y', strtotime($row->created_at)) }}</span></td>
                                        <td>
                                            <a class="btn btn-warning btn-xs" href="{{url('edit_trainings/'.$row->id_training_schedule)}}"><i class="icon-pencil"></i> Edit</a> 
                                        </td>
                                    </tr>
                                    @endforeach    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ===== Page-Content-End ===== -->

<script type="text/javascript">

    $(function(){

    $('#example23').DataTable({
    stateSave: true,
            dom: 'Bfrtip',
            buttons: [
            {
            extend: 'csv',
                    text: 'CSV',
                    title: 'Training List',
                    className: 'btn btn-default',
                    exportOptions: {
                    columns: 'th:not(:last-child)'
                    }
            },
            {
            extend: 'excel',
                    text: 'Excel',
                    title: 'Training List',
                    className: 'btn btn-default',
                    exportOptions: {
                    columns: 'th:not(:last-child)'
                    }
            },
            {
            extend: 'pdf',
                    text: 'PDF',
                    title: 'Training List',
                    className: 'btn btn-default',
                    exportOptions: {
                    columns: 'th:not(:last-child)'
                    }
            },
            {
            extend: 'print',
                    text: 'Print',
                    title: 'Training List',
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
        text: "Once delete, you will create training again!",
        type: "warning",
        //buttons: true,
        //dangerMode: true,
        showCancelButton: true,
        //confirmButtonClass: "btn-danger",
        })
            .then((changeurl) => {
            if (changeurl) {
            window.location.href = "<?php echo url('delete_training'); ?>" + "/" + brand_id;
            } else {
            swal("Your imaginary work is safe!");
            }
            }).catch(swal.noop); ;
    }
</script>

@endsection

