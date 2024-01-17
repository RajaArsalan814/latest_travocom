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
                href="{{ url('hotels') }}"><?= $hotel->hotel_name ?></a></span> Inventory <span>
            <a href="{{ url('hotels/inventory/create/' . Crypt::encrypt($hotel->id_hotels)) }}" class="btn btn-az-primary"
                style="float: right">Add Inventory</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            {{-- <div class="card card-body pd-40"> --}}

            <div>
                <table id="example2" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="wd-5-f">View</th>
                            <th class="wd-5-f">S.No</th>
                            <th class="wd-10-p">Batch#</th>
                            <th class="wd-10-p">Vendor</th>
                            <th class="wd-20p">From Date</th>
                            <th class="wd-15p">To Date</th>
                            <th class="wd-10p">Created By</th>
                            <th class="wd-10p">Created</th>
                            <!--<th class="wd-10f">Operations</th>-->
                            <!--<th class="wd-10f"></th>-->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hotel_inventory as $hotel_inv)

                        <?php
                        $vendors = App\service_vendor::where('id_service_vendors', $hotel_inv->vendor_id)->first();
                        ?>
                            <tr class="cell-1" data-toggle="collapse"
                                data-target="#demo{{ $hotel_inv->id_hotel_inventory }}">
                                <td class="table-elipse" data-toggle="collapse" data-target="#demo"><i
                                        class="fa fa-ellipsis-h text-black-50"></i></td>
                                <td>{{ $hotel_inv->id_hotel_inventory }}</td>
                                <td>#{{ $hotel_inv->batch_number }}</td>
                                <td><badge class="badge badge-warning" style="font-size:14px;font-weight:bold;"><?= $vendors?->vendor_name?></badge></td>
                                <td><span class="badge badge-success"
                                        style="font-size:14px !important;">{{ $hotel_inv->from_date }}</span></td>
                                <td><span class="badge badge-success"
                                        style="font-size:14px !important;">{{ $hotel_inv->to_date }}</span></td>

                                <td>
                                    Super Admin
                                </td>
                                <td><?= date('d-m-Y', strtotime($hotel_inv->created_at)) ?></td>

                                {{-- <td><a class="btn btn-rounded btn-primary"
                                        href="{{ url('hotels/inventory/edit/' . $hotel_inv->id_hotel_inventory . '/' . $hotel->id_hotels) }}">
                                        Edit
                                    </a>
                                </td> --}}
<!--                                <td><a class="btn btn-rounded btn-danger"
                                        href="{{ url('hotels/inventory/destroy/' . \Crypt::encrypt($hotel_inv->id_hotel_inventory) . '/' . \Crypt::encrypt($hotel->id_hotels)) }}">
                                        Delete
                                    </a>
                                </td>-->
                                <!--<td></td>-->
                            </tr>
                            @php
                                $decode = json_decode($hotel_inv->total_entries);
                                $size = sizeof($decode);
                                // dd($size);
                                foreach ($decode as $key => $value) {
                                    $room = App\room_type::where('id_room_types', $value->room_type)->first();
                                    // dd($room);
                                    $room_name = '';
                                    $qty = '';
                                    $cost_price = '';
                                    $selling_price = '';
                                    $beds = '';
                                    $all_records = '';
                                    // $room_name .= '<ul><li>' . $room->name . '</li></ul>';
                                    // dd($room_name);

                                    $all_records .= '<tr>' . '+' . '<th>Room Name:</th>' . '+' . '<th>Qty:</th>' . '+' . '<th>Cost Price:</th>' . '+' . '<th>Selling Price:</th>' . '+' . '<th>{{ $size }}No Of Beds:</th>' . '+' . '</tr>' . '+';
                                    // dd($all_records);
                                    // $qty .= '<ul><li>' . $value->qty . '</li></ul>';
                                    // $cost_price .= '<ul><li>' . $value->cost_price . '</li></ul>';
                                    // $selling_price .= '<ul><li>' . $value->selling_price . '</li></ul>';
                                    // $beds .= '<ul><li>' . $value->beds . '</li></ul>';
                                }

                            @endphp
                            @php
                                $decode = json_decode($hotel_inv->total_entries);
                                $size = sizeof($decode);
                            @endphp
                            <tr id="demo{{ $hotel_inv->id_hotel_inventory }}" class="collapse cell-1 row-child">
                                <td class="text-center" ><i class="fa fa-angle-up"></i></td>
                                <th colspan="1">Room Type&nbsp;</th>
                                <th>Qty</th>
                                <th>No Of Beds</th>
                                <th>Cost Price</th>
                                <th>Selling Price</th>
                            </tr>
                            @foreach ($decode as $key => $value)
                                @php
                                    $room = App\room_type::where('id_room_types', $value->room_type)->first();
                                @endphp
                                <tr id="demo{{ $hotel_inv->id_hotel_inventory }}" class="collapse cell-1 row-child">
                                    <td class="text-center"></td>
                                    <th colspan="1"><badge class="badge badge-info" style="font-size:14px;font-weight:bold;">{{ $room->name }}&nbsp;</badge></th>
                                    <th><badge class="badge badge-warning" style="font-size:14px;font-weight:bold;">{{ $value->qty }}</badge></th>
                                    <th><badge class="badge badge-warning" style="font-size:14px;font-weight:bold;">{{ $value->beds }}</badge></th>
                                    <th><badge class="badge badge-warning" style="font-size:14px;font-weight:bold;">{{ $value->cost_price }}</badge></th>
                                    <th><badge class="badge badge-warning" style="font-size:14px;font-weight:bold;">{{ $value->selling_price }}</badge></th>

                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-5-f">View</th>
                            <th class="wd-5-f">S.No</th>
                            <th class="wd-10-p">Batch#</th>
                            <th class="wd-10-p">Vendor</th>
                            <th class="wd-20p">From Date</th>
                            <th class="wd-15p">To Date</th>
                            <th class="wd-10p">Created By</th>
                            <th class="wd-10p">Created</th>
                            <!--<th class="wd-10f">Operations</th>-->
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
