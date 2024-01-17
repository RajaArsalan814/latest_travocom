@extends('layouts.master')
@section('content')
<div class="card card-body pd-10">
    <div class="az-content-breadcrumb">
        <span>Notifications</span>
    </div>
    <h2 class="az-content-title" style="display: inline">Escalation Preferences <span>
            </span></h2>
</div>
<div class="clearfix"></div>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
             <div class="card card-body pd-40"> 

            <div>
                <table id="example2" class="table table-bordered" style="background-color: #fff;">
                    <thead>
                        <tr>
                            <th class="wd-5p">S.No</th>
                            <th class="wd-10p">Escalation</th>
                            <th class="wd-10p">Services</th>
                            <th class="wd-10p">Priority</th>
                            <th class="wd-10p">Escalation Timer</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($escalations as $key => $type)
                        <?php $notification_type = ''; 
                        if($type->type == 'self_inquiry'){
                            $notification_type = 'My Inquiry';
                        }?>
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td>{{ $type->escalation_name }}</td>
                                <td>-</td>
                                <td><input type="number" class="form-control" value="{{ $type->priority }}"/></td>
                                <td><input type="number" class="form-control" value="{{ $type->timer }}" placeholder="Minutes"/></td>
                                <td>-</td>
                                <td><?= date('d-m-Y', strtotime($type['created_at'])) ?></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-5p">S.No</th>
                            <th class="wd-10p">Escalation</th>
                            <th class="wd-10p">Services</th>
                            <th class="wd-10p">Priority</th>
                            <th class="wd-10p">Escalation Timer</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created At</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
             </div> 
            <!-- card -->
        </div>
        <!-- col -->
    </div>
    {{-- </div><!-- az-content-body --> --}}
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            $('#example2 tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
    });

            $('#example2').DataTable({
                "ordering": true,
                "dom": 'Blfrtip',
                "buttons": [
                    'excel', 'pdf', 'print'
                ],
                responsive: !0,
                columnDefs: [{
                    className: 'control'
                }],
            initComplete: function () {
            // Apply the search
            this.api()
                .columns()
                .every(function () {
                    var that = this;

                    $('input', this.footer()).on('keyup change clear', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
        }
            });
        });
    </script>
@endpush
