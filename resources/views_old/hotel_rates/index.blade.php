@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Hotel Room Rates</span>
    </div>
    <h2 class="az-content-title" style="display: inline">Room Rates Of {{ $hotel->hotel_name }} <span>
            <a href="{{ url('hotel_rates/create/' . \Crypt::encrypt($hotel->id_hotels)) }}" class="btn btn-az-primary"
                style="float: right">Add Room Rates
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
                            <th class="wd-20p">From Date</th>
                            <th class="wd-10p">To Date</th>
                            <th class="wd-10p">Room Name</th>
                            <th class="wd-10p">Vendor Name</th>
                            <th class="wd-10p">Cost Price</th>
                            <th class="wd-10p">Selling Price</th>
                            <th class="wd-10p">Created At</th>
                            <!--<th class="wd-10p">Operations</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hotel_rates as $key => $rate)
                            <tr>

                                <td>{{ $key = $key + 1 }}</td>
                                <td><badge class="badge badge-success" style="font-size:14px;font-weight:bold;">{{ $rate->from_date }}</badge></td>
                                <td><badge class="badge badge-success" style="font-size:14px;font-weight:bold;">{{ $rate->to_date }}</badge></td>
                                <td><badge class="badge badge-info" style="font-size:14px;font-weight:bold;">{{ App\hotel_rate::getRoomName($rate->room_type_id) }}</badge></td>
                                <td><badge class="badge badge-warning" style="font-size:14px;font-weight:bold;">
                                    @php
                                        $service_vendor = App\service_vendor::where('id_service_vendors', $rate->vendor_id)->first();
                                    @endphp
                                    @if ($service_vendor != null)
                                        {{ $service_vendor->vendor_name }}
                                    @endif
                                </badge>
                                </td>
                                <td><badge class="badge badge-success" style="font-size:14px;font-weight:bold;">{{ $rate->cost_price }}</badge></td>
    <td><badge class="badge badge-success" style="font-size:14px;font-weight:bold;">{{ $rate->selling_price }}</badge></td>
                                <td><?= date('d-m-Y', strtotime($rate['created_at'])) ?></td>

<!--                                <td>
                                    <a class="btn btn-rounded btn-primary"
                                        href="{{ url('/hotel_rates/edit/' . \Crypt::encrypt($rate->id_hotel_rates)) }}">
                                        Edit
                                    </a>

                                    <a class="btn btn-rounded btn-danger "
                                        href="{{ url('/hotel_rates/delete/' . \Crypt::encrypt($rate->id_hotel_rates)) }}">
                                        Delete
                                    </a>
                                </td>-->
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">From Date</th>
                            <th class="wd-10p">To Date</th>
                            <th class="wd-10p">Room Name</th>
                            <th class="wd-10p">Vendor Name</th>
                            <th class="wd-10p">Cost Price</th>
                            <th class="wd-10p">Selling Price</th>
                            <th class="wd-10p">Created At</th>
                            <!--<th class="wd-10p">Operations</th>-->
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
