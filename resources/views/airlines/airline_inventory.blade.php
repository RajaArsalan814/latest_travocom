@extends('layouts.master')
@section('content')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> --}}
    <style>
        @import url('https://fonts.googleapis.com/css?family=Assistant');

        body {

            font-family: Assistant, sans-serif
        }

        .cell-1 {
            border-collapse: separate;
            border-spacing: 0 4em;

            border-bottom: 5px solid transparent;
            background-clip: padding-box;
            cursor: pointer
        }



        .table-elipse {
            cursor: pointer
        }

        #demo {
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            -o-transition: all 0.3s 0.1s ease-in-out;
            transition: all 0.3s ease-in-out
        }


        .table td.collapse.in {
            display: table-cell;
        }
    </style>
    <div class="az-content-breadcrumb">
        <span>Inventory List</span>
        {{-- <span>Add Hotel</span> --}}
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline"> <span style="text-decoration: underline;"><a
                href="{{ url('airlines') }}"><?= $airline->Airline ?></a></span> Inventory <span>
            <a href="{{ url('airlines/inventory/create/' . Crypt::encrypt($airline->id_airlines)) }}"
                class="btn btn-az-primary" style="float: right">Add Inventory</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            {{-- <div class="card card-body pd-40"> --}}

            <div>
                <table id="example2" class="table table-striped border">
                    <thead>
                        <tr>
                            <th class="wd-5-f">View</th>
                            <th class="wd-5-f">S.No</th>
                            <th class="wd-10-p">Batch#</th>
                            <th class="wd-10-p">Arrival Date</th>
                            <th class="wd-15p">Departure Date</th>
                            <th class="wd-15p">Arrival Destination</th>
                            <th class="wd-15p">Departure Destination</th>
                            <th class="wd-15p">Connecting From </th>
                            <th class="wd-10p">Created By</th>
                            <th class="wd-10p">Created At</th>
                            <th class="wd-10f">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($airline_inventory as $airline_inv)
                            <tr class="cell-1" data-toggle="collapse"
                                data-target="#demo{{ $airline_inv->id_airline_inventory }}">
                                <td class="table-elipse" data-toggle="collapse" data-target="#demo"><i
                                        class="fa fa-ellipsis-h text-black-50"></i></td>
                                <td>{{ $airline_inv->id_airline_inventory }}</td>
                                <td>#{{ $airline_inv->batch_no }}</td>
                                <td><span class="badge badge-success"
                                        style="font-size:14px !important;">{{ $airline_inv->arrival_date }}</span></td>
                                <td><span class="badge badge-success"
                                        style="font-size:14px !important;">{{ $airline_inv->departure_date }}</span></td>


                                <td>{{ $airline_inv->arrival_destination }}</td>
                                {{-- <td>{{ App\cities::getCityName($airline_inv->arrival_from_city) }}</td> --}}
                                <td>{{ $airline_inv->departure_destination }}</td>
                                {{-- <td>{{ App\cities::getCityName($airline_inv->departure_to_city) }}</td> --}}
                                <td>{{ $airline_inv->mid_destination }}</td>
                                {{-- <td>{{ App\cities::getCityName($airline_inv->mid_destination_city) }}</td> --}}

                                <td>
                                    Super Admin
                                </td>
                                <td><?= date('d-m-Y', strtotime($airline_inv->created_at)) ?></td>

                                {{-- <td><a class="btn btn-rounded btn-primary"
                                        href="{{ url('hotels/inventory/edit/' . $airline_inv->id_hotel_inventory . '/' . $airline->id_hotels) }}">
                                        Edit
                                    </a>
                                </td> --}}
                                <td><a class="btn btn-rounded btn-danger"
                                        href="{{ url('airlines/inventory/destroy/' . \Crypt::encrypt($airline_inv->id_airline_inventory) . '/' . \Crypt::encrypt($airline_inv->airline_id)) }}">
                                        Delete
                                    </a>
                                </td>
                            </tr>

                            @php
                                $decode = json_decode($airline_inv->all_entries);
                                // dd($decode);
                            @endphp
                            <tr id="demo{{ $airline_inv->id_airline_inventory }}" class="collapse cell-1 row-child">
                                <td class="text-center" colspan="1"><i class="fa fa-angle-up"></i></td>
                                <th colspan="6">Flight Class&nbsp;</th>
                                <th>Qty</th>
                                <th>Cost Price</th>
                                <th>Selling Price</th>
                                <th>Profit</th>
                            </tr>
                            @foreach ($decode as $key => $value)
                                <tr id="demo{{ $airline_inv->id_airline_inventory }}" class="collapse cell-1 row-child">
                                    <td class="text-center" colspan="1"></td>
                                    <th colspan="6">{{ $value->flight_class }}&nbsp;</th>
                                    <th>{{ $value->qty }}</th>
                                    <th>{{ $value->cost_price }} Rs</th>
                                    <th>{{ $value->selling_price }} Rs</th>
                                    <th>{{ ($value->selling_price*$value->qty)-($value->cost_price*$value->qty) }} Rs</th>

                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-5-f">View</th>
                            <th class="wd-5-f">S.No</th>
                            <th class="wd-10-p">Batch#</th>
                            <th class="wd-10-p">Arrival Date</th>
                            <th class="wd-15p">Departure Date</th>
                            <th class="wd-15p">Arrival Destination</th>
                            <th class="wd-15p">Departure Destination</th>
                            <th class="wd-15p">Mid Destination </th>
                            <th class="wd-10p">Created By</th>
                            <th class="wd-10p">Created At</th>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script>
        var table = $('#example2').DataTable();

        // $('#example2 tbody').on('click', 'td:first-child', function() {
        //     var tr = $(this).closest('tr');
        //     var row = table.row(tr);

        //     if (row.child.isShown()) {
        //         // This row is already open - close it
        //         row.child.hide();
        //         tr.removeClass('shown');
        //     } else {
        //         // Open this row
        //         row.child(format(row.data())).show();
        //         tr.addClass('shown');
        //     }
        // });
    </script>
@endpush
