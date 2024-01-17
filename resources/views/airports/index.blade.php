@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Airports</span>
        {{-- <span>Add Airline</span> --}}
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline"> Airports List <span>
            <a href="{{ url('airports/create') }}" class="btn btn-az-primary" style="float: right">Add Airports</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            {{-- <div class="card card-body pd-40"> --}}

            <div>
                <table id="example2" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="wd-5-f">S.No</th>
                            <th class="wd-20p">Airport Name</th>
                            <th class="wd-15p">Short Code</th>
                            <th class="wd-15p">Airport Country</th>
                            <th class="wd-15p">Airport City</th>
                            <th class="wd-10p">Created</th>
                            <th class="wd-10p">Updated</th>
                            <th class="wd-10f">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($airports as $key => $airports)


                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td>{{ $airports->name }}</td>
                                <td>{{ $airports->code }}</td>
                                <td>{{ $airports->countryName }}</td>

                                <td>{{ $airports->cityName }}</td>
                                <td><?= date('d-m-Y', strtotime($airports->created_at))?></td>
                                <td><?= date('d-m-Y', strtotime($airports->updated_at))?></td>
                                <td><a class="btn btn-rounded btn-primary" href="{{ url('airports/edit/' . Crypt::encrypt($airports->id_airports)) }}">
                                Edit
                                </a>
<!--                                    <a class="btn btn-rounded btn-danger" href="{{ url('airlines/destroy/' . Crypt::encrypt($airports->id_service_airlines)) }}">
                                Delete
                                </a>-->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                     <tfoot>
                        <tr>
                            <th class="wd-5-f">S.No</th>
                            <th class="wd-20p">Airport Name</th>
                            <th class="wd-15p">Short Code</th>
                            <th class="wd-15p">Airport Country</th>
                            <th class="wd-15p">Airport City</th>
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
