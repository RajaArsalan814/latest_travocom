@extends('layouts.master')
@section('content')
<div class="az-content-breadcrumb">
    <span>Land And Services</span>
</div>
<h2 class="az-content-title" style="display: inline"> Land Services List <span>
        <a href="{{ url('land_services/create') }}" class="btn btn-az-primary ms-2" style="float: right">Add Land
            Services</a>


    </span></h2>

{{-- <h2 style="float: right" class="az-content-title"></h2> --}}


<div class="az-content-body d-flex flex-column"> 
<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">
         <div class="card card-body pd-40"> 

        <div>
            <table id="example2" class="table table-bordered"style="background-color: #fff;">
                <thead>
                    <tr>
                        <th class="wd-10p">Name</th>
                        <th class="wd-10p">Service Type</th>
                        <th class="wd-10p">Transport</th>
                        <th class="wd-10p">Route</th>
                        <th class="wd-10p">Vendor</th>
                        <th class="wd-10p">Cost Price</th>
                        <th class="wd-10p">Selling Price</th>
                        <th class="wd-10p">Created At</th>
                        <th class="wd-10p">Updated At</th>
                        <th class="wd-10p">Operation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($landservicestypes as $key => $land)
                    @php
                    $get_service_name = App\land_services_type::where('id_land_services_types', $land->name)->first();
                    //dd($land->total_entries);
                    @endphp
                    
                    
                    <tr>
                        
                    @php
                    $decode = json_decode($land->total_entries);
                    $get_route_name = App\Route::where('id_route', $decode[0]->route_id)->first();
                    $get_vendor_name = App\service_vendor::where('id_service_vendors', $decode[0]->vendor)->first();
                    
                    //dd($get_vendor_name->vendor_name);
                    @endphp
                        <td>{{ $get_service_name->service_name }}</td>
                        <td>{{ $land->service_type }}</td>
                        <td >{{ $decode[0]->transport }}</td>
                        <td >{{ $get_route_name->route_location }}</td>
                        <td >{{ $get_vendor_name->vendor_name }}</td>
                        <td >{{ $decode[0]->cost_price }}</td>
                        <td >{{ $decode[0]->selling_price }}</td>
                        <td><?= date('d-m-Y', strtotime($land->created_at)) ?></td>
                        <td><?= date('d-m-Y', strtotime($land->updated_at)) ?></td>
                        <td><a class="btn btn-rounded btn-indigo" href="{{ url('land_services/edit/'.\Crypt::encrypt($land['id_land_and_services_types'])) }}">
                                Edit
                            </a></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="wd-10p">Name</th>
                        <th class="wd-10p">Service Type</th>
                        <th class="wd-10p">Transport</th>
                        <th class="wd-10p">Route</th>
                        <th class="wd-10p">Vendor</th>
                        <th class="wd-10p">Cost Price</th>
                        <th class="wd-10p">Selling Price</th>
                        <th class="wd-10p">Created At</th>
                        <th class="wd-10p">Updated At</th>
                        <th class="wd-10p">Operation</th>
                    </tr>
                </tfoot>
            </table>
        </div>
         </div> 
        <!-- card -->
    </div>
    <!-- col -->
</div>
 </div>
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
