@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Airlines</span>
        {{-- <span>Add Airline</span> --}}
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline"> Airlines List <span>
            <a href="{{ url('airlines/create') }}" class="btn btn-az-primary" style="float: right">Add Airline</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            {{-- <div class="card card-body pd-40"> --}}

            <div>
                <table id="example2" class="table table-responsive">
                    <thead>
                        <tr>
                            <th class="wd-5-f">S.No</th>
                            <th class="wd-5-f">IM</th>
                            <th class="wd-20p">Airline Name</th>
                            <th class="wd-15p">Short Code</th>
                            <th class="wd-15p">Airline Country</th>
                            <th class="wd-10p">Inventory</th>
                            <th class="wd-10p">Rates</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created</th>
                            <th class="wd-10p">Updated</th>
                            <th class="wd-10f">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($airlines as $key => $airline)
                            <?php
                            if (!empty($airline->airline_image)) {
                                $image = url('/uploads/airlines_images/' . $airline->airline_image);
                            } else {
                                $image = url('/uploads/airlines_images/airline_default.png');
                            }
                            ?>
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td><img src="<?= $image ?>" style="height:40px;width:40px;border-radius: 50%"
                                        alt="" srcset=""></td>
                                <td>{{ $airline->Airline }}</td>
                                <td>{{ $airline->ICAO }}</td>
                                <td>{{ $airline->Country }}</td>
                                <td><a class="btn btn-block btn-warning"
                                        href="{{ url('airlines/inventory/' . Crypt::encrypt($airline['id_airlines'])) }}">
                                        View
                                    </a>
                                </td>
                                <td><a class="btn btn-block btn-warning"
                                        href="{{ url('airline/airline_rates/' . Crypt::encrypt($airline['id_airlines'])) }}">
                                        View
                                    </a>
                                </td>
                                <td>
                                    @if ($airline->airline_status == 1)
                                        <button class="btn btn-rounded btn-success" style="color:#fff;">
                                            Active <span class="badge badge-primary"></span>
                                        </button>
                                    @else
                                        <button class="btn btn-rounded btn-danger" style="color:#fff;">
                                            Deactive <span class="badge badge-primary"></span>
                                        </button>
                                    @endif
                                </td>
                                <td><?= date('d-m-Y', strtotime($airline->created_at)) ?></td>
                                <td><?= date('d-m-Y', strtotime($airline->updated_at)) ?></td>

                                <td><a class="btn btn-rounded btn-primary"
                                        href="{{ url('airlines/edit/' . Crypt::encrypt($airline->id_airlines)) }}">
                                        Edit
                                    </a>
                                    <!--                                    <a class="btn btn-rounded btn-danger" href="{{ url('airlines/destroy/' . Crypt::encrypt($airline->id_service_airlines)) }}">
                                        Delete
                                        </a>-->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-5-f">S.No</th>
                            <th class="wd-5-f">IM</th>
                            <th class="wd-20p">Airline Name</th>
                            <th class="wd-15p">Short Code</th>
                            <th class="wd-15p">Airline Country</th>
                            <th class="wd-10p">Inventory</th>
                            <th class="wd-10p">Rates</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created</th>
                            <th class="wd-10p">Updated</th>
                            <th class="wd-10f">Operations</th>
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
                    orderable: false
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
