@extends('layouts.master')
@section('content')
<div class="card card-body pd-10">
    <div class="az-content-breadcrumb">
        <span>Campaigns</span>
    </div>
    <h2 class="az-content-title" style="display: inline"> Campaigns List <span>
            <a href="{{ url('campaigns/create') }}" class="btn btn-az-primary" style="float: right">Add Campaign
            </a></span></h2>
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
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Campaign Name</th>
                            <th class="wd-10p">Start Date</th>
                            <th class="wd-10p">End Date</th>
                            {{-- <th class="wd-10p">Services Name</th> --}}
                            <th class="wd-10p">Description</th>
                            <th class="wd-10p">status</th>
                            <th class="wd-15p none">Services</th>
                            <th class="wd-10p">Created At</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($campaigns as $key => $type)
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td>{{ $type->campaign_name }}</td>
                                <td><?= date('d-m-Y', strtotime($type['start_date'])) ?></td>
                                <td><?= date('d-m-Y', strtotime($type['end_date'])) ?></td>
                                @php
                                    $get_service = App\other_service::where('id_other_services', $type->services_id)->first();
                                    $get_sub_service = App\other_service::where('parent_id', $type->services_id)->get();
                                @endphp
                                {{-- <td>{{ $get_service->service_name }}</td> --}}

                                <td>{{ $type->description }}</td>
                                <td>@if ($type->status == 'Active')
                                    <span class="badge badge-success">{{ $type->status }}</span>
                                    @else
                                    <span class="badge badge-danger">{{ $type->status }}</span>
                                @endif</td>
                                <td><br><b><?= $get_service->service_name?></b>: 
                                    @foreach($get_sub_service as $sub_services)
                                    <span><?=$sub_services->service_name?>, </span>
                                    @endforeach
                                </td>
                                <td><?= date('d-m-Y', strtotime($type['created_at'])) ?></td>
                                <td>
                                    <a class="btn btn-rounded btn-primary"
                                        href="{{ url('/campaigns/edit/' . \Crypt::encrypt($type->id_campaigns)) }}">
                                        Edit
                                    </a>
                                    <a class="btn btn-rounded btn-danger"
                                        href="{{ url('/campaigns/delete/' . \Crypt::encrypt($type->id_campaigns)) }}">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Campaign Name</th>
                            <th class="wd-10p">Start Date</th>
                            <th class="wd-10p">End Date</th>
                            {{-- <th class="wd-10p">Services Name</th> --}}
                            <th class="wd-10p">Description</th>
                            <th class="wd-10p">status</th>
                            <th class="wd-15p none">Services</th>
                            <th class="wd-10p">Created At</th>
                            <th class="wd-10p">Operations</th>
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
                    className: 'control',
                    orderable: false,
                    targets: 0
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
