@extends('layouts.master')
@section('content')
<style>
    .grow {
        padding: 5px 5px 5px 5px;
        border-radius: 10px;
        height: 49px;
        width: 100%;
        margin: 5px 1% 5px 1%;
        float: left;
        position: relative;
        transition: height 0.5s;
        -webkit-transition: height 0.5s;
        text-align: center;
        overflow: hidden;
        transition: 2.5s;
    }

    .grow:hover {
        height: min-content !important;
        /* width: 50vw; */
    }
</style>
<div class="az-content-breadcrumb">
    <span>Services Types</span>
</div>
<h2 class="az-content-title" style="display: inline"> Land And Services Types  <span>
        <a href="{{ url('/land_services_types/create') }}" class="btn btn-az-primary" style="float: right">Add Land And Services Types</a></span></h2>
{{-- <h2 style="float: right" class="az-content-title"></h2> --}}


{{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">
        {{-- <div class="card card-body pd-40"> --}}

        <div>
            <table id="example2" class="table table-striped">
                <thead>
                    <tr>
                        <th class="wd-10p">S.No</th>
                        <th class="wd-20p">Service Name</th>
                        <th class="wd-20p">Service Type</th>
                        <th class="wd-10p">Created</th>
                        <th class="wd-10p">Status</th>
                        <th class="wd-10p">Operations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($land_services_types as $key => $service_types)
                    <tr>

                        <td>{{ $key + 1 }}</td>
                        <td >{{ $service_types['service_name'] }}</td>
                        @php
                        $decode = json_decode($service_types->service_type);
                        @endphp

                        <td class="text-center" >

                            <span class="badge badge-secondary grow " style="font-size:14px ; width: 200px; margin-left: -50px">
                            <ul style="margin-left: 5px">

                                @foreach($decode as $key => $dec)
                                <li style="">
                                    {{ $dec }}
                                </li>
                                @endforeach
                            </ul>
                        </span>
                        </td>

                        <td  >@if ($service_types->status == 1)
                            <button class="btn btn-rounded btn-sm btn-success" style="color:#fff;  ">
                                Active <span class="badge badge-primary"></span>
                            </button>
                        @else
                            <button class="btn btn-rounded btn-sm btn-danger" style="color:#fff; margin-left: -5px">
                                Deactive <span class="badge badge-primary"></span>
                            </button>
                        @endif</td>

                        <td><?= date('d-m-Y', strtotime($service_types['created_at'])) ?></td>

                        <td><a class="btn btn-rounded btn-primary" href="{{ url('land_services_types/edit/'.\Crypt::encrypt($service_types['id_land_services_types'])) }}">
                                Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                        <th class="wd-10p">S.No</th>
                        <th class="wd-20p">Service Name</th>
                        <th class="wd-20p">Service Type</th>
                        <th class="wd-10p">Created</th>
                        <th class="wd-10p">Status</th>
                        <th class="wd-10p">Operations</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        {{-- </div> --}}
        <!-- card -->
    </div>
    <!-- col -->
</div>






{{-- </div><!-- az-content-body --> --}}
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#example2 tfoot th').each(function() {
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
                initComplete: function() {
                    // Apply the search
                    this.api()
                        .columns()
                        .every(function() {
                            var that = this;

                            $('input', this.footer()).on('keyup change clear', function() {
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
