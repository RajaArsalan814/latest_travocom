@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Follow Up Types</span>
    </div>
    <h2 class="az-content-title" style="display: inline">Addons List <span>
            <a href="{{ url('addons/create') }}" class="btn btn-az-primary" style="float: right">Add Addons
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
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Name</th>
                            <th class="wd-20p">Cost Price</th>
                            <th class="wd-10p">Selling Price</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created At</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addons as $key => $addon)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $addon->addon_name }}</td>
                                <td>{{ $addon->addon_cost_price }}</td>
                                <td>{{ $addon->addon_selling_price }}</td>
                                <td>@if ($addon->status == 1)
                                        <button class="btn btn-rounded btn-success" style="color:#fff;">
                                            Active <span class="badge badge-primary"></span>
                                        </button>
                                    @else
                                        <button class="btn btn-rounded btn-danger" style="color:#fff;">
                                            Deactive <span class="badge badge-primary"></span>
                                        </button>
                                    @endif</td>
                                <td><?= date('d-m-Y', strtotime($addon['created_at'])) ?></td>

                                <td><a class="btn btn-rounded btn-primary"
                                        href="{{ url('/addons/edit/' . \Crypt::encrypt($addon->id_addons)) }}">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Name</th>
                            <th class="wd-20p">Cost Price</th>
                            <th class="wd-10p">Selling Price</th>
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
