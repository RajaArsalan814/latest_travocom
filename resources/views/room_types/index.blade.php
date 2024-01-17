@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Follow Up Types</span>
    </div>
    <h2 class="az-content-title" style="display: inline">Room Types List <span>
            <a href="{{ url('room_types/create') }}" class="btn btn-az-primary" style="float: right">Add Room Types
            </a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            {{-- <div class="card card-body pd-40"> --}}

            <div>
                <table id="example2" class="table table-responsive">
                    <thead>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Room Type Name</th>
                            <th class="wd-20p">No Of Beds</th>
                            <th class="wd-10p">Add on</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created At</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($room_types as $key => $type)
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td>{{ $type->name }}</td>
                                @if ($type->no_of_beds == null)
                                    <td>Sharing</td>
                                @else
                                    <td>{{ $type->no_of_beds }}</td>
                                @endif

                                @php
                                    $get_addons = json_decode($type->addons);
                                    // dd($get_addons);

                                @endphp
                                <td>
                                    @if (isset($get_addons) && $type->addons != null)
                                        @foreach ($get_addons as $addo)
                                            <span>
                                                <li>@php
                                                    $get_addon_details = App\addon::where('id_addons', $addo)->first();
                                                    echo $get_addon_details->addon_name
                                                @endphp</li>
                                            </span>
                                        @endforeach
                                    @endif
                                </td>


                                <td>{{ $type->status }}</td>
                                <td><?= date('d-m-Y', strtotime($type['created_at'])) ?></td>

                                <td><a class="btn btn-rounded btn-primary"
                                        href="{{ url('room_types/edit/' . \Crypt::encrypt($type->id_room_types)) }}">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Type Name</th>
                            <th class="wd-20p">No Of Beds</th>
                            <th class="wd-20p">addons</th>
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
