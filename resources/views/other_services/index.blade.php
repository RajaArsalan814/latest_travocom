@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Other Services</span>
    </div>
    <h2 class="az-content-title" style="display: inline"> Other Services List <span>
            <a href="{{ url('other_services/create') }}" class="btn btn-az-primary" style="float: right">Add Other Services
            </a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            {{-- <div class="card card-body pd-40"> --}}

            <div>
                <table id="example2" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="wd-5p">View</th>
                            <th class="wd-5p">S.No</th>
                            <th class="wd-20p">Service</th>
                            <th class="wd-20p">Description</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created At</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($other_services as $key => $type)
                            <tr class="cell-1" data-toggle="collapse" data-target="#demo{{ $type->id_other_services }}">
                                <td class="table-elipse" data-toggle="collapse" data-target="#demo"><i
                                        class="fa fa-ellipsis-h text-black-50"></i></td>

                                <td>{{ $key + 1 }}</td>
                                <td>{{ $type->service_name }}</td>
                                <td>{{ $type->description }}</td>
                                <td>{{ $type->status }}</td>
                                <td><?= date('d-m-Y', strtotime($type['created_at'])) ?></td>
                                <td><a class="btn btn-rounded btn-primary"
                                        href="{{ url('/other_services/edit/' . \Crypt::encrypt($type->id_other_services)) }}">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                            <tr id="demo{{ $type->id_other_services }}" class="collapse cell-1 row-child">
                                <td class="text-center"><i class="fa fa-angle-up"></i></td>
                                <th colspan="2">Service Name</th>
                                <th>Sub Service</th>
                            </tr>
                            @php
                                $decode = App\other_service::where('parent_id',$type->id_other_services)->whereNotNull('parent_id')->get();
                                // dd($decode);
                                $size = sizeof($decode);
                            @endphp
                            @foreach ($decode as $key => $value)
                                <tr id="demo{{ $type->id_other_services }}" class="collapse cell-1 row-child">
                                    <td class="text-center"></td>
                                    @php
                                        $service_name = App\other_service::where('id_other_services', $value->parent_id)->first();
                                        // dd($service_name);
                                    @endphp
                                    <td colspan="2">{{ $service_name->service_name }}</td>
                                    <td colspan="2">{{ $value->service_name }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-5p">View</th>
                            <th class="wd-5p">S.No</th>
                            <th class="wd-20p">Service</th>
                            <th class="wd-20p">Description</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created At</th>
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
                    className: 'control',
                    orderable: false,
                    targets: 7
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
