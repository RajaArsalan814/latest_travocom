@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Hotel Room Rates</span>
    </div>
    <h2 class="az-content-title" style="display: inline">Airline Rates Of {{ $airlines->Airline }} <span>
            <a href="{{ url('airline_rates/create/' . \Crypt::encrypt($airlines->id_airlines)) }}" class="btn btn-az-primary"
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
                            <th class="wd-10p">From Location</th>
                            <th class="wd-10p">To Location</th>
                            <th class="wd-10p">Flight Class</th>
                            <th class="wd-10p">Cost Price</th>
                            <th class="wd-10p">Selling Price</th>
                            <th class="wd-10p">Created At</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($airline_rates as $key => $rate)
                            <tr>

                                <td>{{ $key = $key + 1 }}</td>
                                <td>{{ $rate->from_date }}</td>
                                <td>{{ $rate->to_date }}</td>
                                <td>{{ $rate->from_location }}</td>
                                <td>{{ $rate->to_location }}</td>
                                <td>{{ $rate->flight_class }}</td>
                                <td>{{ $rate->cost_price }}</td>
                                <td>{{ $rate->selling_price }}</td>
                                <td><?= date('d-m-Y', strtotime($rate['created_at'])) ?></td>

                                <td><a class="btn btn-rounded btn-primary"
                                        href="{{ url('/airline_rates/edit/' . \Crypt::encrypt($rate->id_airline_rates)) }}">
                                        Edit
                                    </a>

                                    <a class="btn btn-rounded btn-danger mt-2"
                                        href="{{ url('/airline_rates/delete/' . \Crypt::encrypt($rate->id_airline_rates)) }}">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">From Date</th>
                            <th class="wd-10p">To Date</th>
                            <th class="wd-10p">From Location</th>
                            <th class="wd-10p">To Location</th>
                            <th class="wd-10p">Flight Class</th>
                            <th class="wd-10p">Cost Price</th>
                            <th class="wd-10p">Selling Price</th>
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
