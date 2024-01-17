@extends('layouts.master')
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
@section('content')
    <div class="card card-body pd-10">
    <div class="az-content-breadcrumb">
        <span>Hotels</span>
    </div>
    <h2 class="az-content-title" style="display: inline"> Hotels List <span>
            <a href="{{ url('hotels/create') }}" class="btn btn-az-primary" style="float: right">Add Hotel</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}
    </div>

    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
           <div class="card card-body pd-40"> 

            <div>
                <table id="example2" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="wd-5-f">S.No</th>
                            <th class="wd-5-f">IM</th>
                            <th class="wd-20p">Hotel Name</th>
                            <th class="wd-15p">Hotel Category</th>
                            <th class="wd-15p">Country / City</th>
                            <th class="wd-15p">Hotel Address</th>
                            <th class="wd-15p">Availability</th>
                            <th class="wd-15p">Inventory</th>
                            <th class="wd-20p">Rates</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created</th>

                            <th class="wd-10f">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hotels as $key => $hotel)
                            <?php
                            if (!empty($hotel['hotel_image'])) {
                                $image = url('/uploads/hotels_images/' . $hotel['hotel_image']);
                            } else {
                                $image = url('/uploads/hotels_images/hotel_default.png');
                            }

                            $country = \App\countries::select('name')
                                ->where('country_name', $hotel['country'])
                                ->first();
                            $inventory_count = App\hotel_inventory::where('hotel_id', '=', $hotel['id_hotels'])->whereDate('from_date', '>=', strtotime(now()))->get()->count();
//                            dd($inventory_count);exit;
                            $rates_count = App\hotel_rate::where('hotel_id', '=', $hotel['id_hotels'])->whereDate('from_date', '>=', strtotime(now()))->get()->count();
                            ?>
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td><img src="<?= $image ?>" style="height:40px;width:40px;border-radius: 50%"
                                        alt="" srcset=""></td>
                                <td>{{ $hotel['hotel_name'] }}</td>
                                <td>{{ $hotel['hotel_type'] }}</td>
                                <td>{{ $hotel['country'] }}</td>
                                <td>{{ $hotel['hotel_address'] }}</td>

                                <td>
                                    @php
                                        $details = App\hotel_details::where('hotel_id', '=', $hotel['id_hotels'])->first();
                                        $decode = json_decode($details['room_availablity']);

                                    @endphp
                                    @if ($decode != null)
                                        <span class="badge badge-secondary grow" style="font-size:14px">
                                            @foreach ($decode as $key => $item)
                                                @php
                                                    $room = App\room_type::where('id_room_types', '=', $item)->first();
                                                @endphp
                                                {{-- @if ($key < 3) --}}
                                                <li style="text-align: left;"> {{ $room?->name }} </li>
                                                {{-- @else --}}
                                                {{-- <li style="text-align: left;">... </li> --}}
                                                {{-- @break --}}
                                                {{-- @endif --}}
                                            @endforeach
                                        </span>
                                    @endif

                                </td>
                                <td><a class="btn btn-block btn-warning"
                                        href="{{ url('hotels/inventory/' . Crypt::encrypt($hotel['id_hotels'])) }}">
                                        View
                                    </a>
                                        @if($inventory_count !== null)
                                    <span><i class="fa fa-check-circle"></i></span>
                                        @endif
                                </td>
                                <td><a class="btn btn-block btn-warning"
                                        href="{{ url('hotels/hotel_rates/' . Crypt::encrypt($hotel['id_hotels'])) }}">
                                        View
                                    </a>
                                    
                                </td>
                                <td>
                                    @if ($hotel['hotel_status'] == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">In-Active</span>
                                    @endif
                                </td>
                                <td><?= date('d-m-Y', strtotime($hotel['created_at'])) ?></td>

                                <td><a class="btn btn-rounded btn-primary"
                                        href="{{ url('hotels/edit/' . Crypt::encrypt($hotel['id_hotels'])) }}">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-5-f">S.No</th>
                            <th class="wd-5-f">IM</th>
                            <th class="wd-20p">Hotel Name</th>
                            <th class="wd-15p">Hotel Type</th>
                            <th class="wd-15p">Country</th>
                            <th class="wd-15p">Hotel Address</th>
                            <th class="wd-15p">Availability</th>
                            <th class="wd-15p">Inventory</th>
                            <th class="wd-20p">Rates</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created</th>

                            <th class="wd-10f">Operations</th>
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
                    orderable: false
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
