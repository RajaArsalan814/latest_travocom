@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Visa Rates</span>
    </div>
    <h2 class="az-content-title" style="display: inline">Visa Rates List <span>
            <a href="{{ url('visa_rate/create') }}" class="btn btn-az-primary" style="float: right">Add Visa Rates
            </a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40"> 

            <div>
            <table id="example2" class="table table-bordered"style="background-color: #fff;">
                    <thead>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Name</th>
                            <th class="wd-20p">Children Cost Price</th>
                            <th class="wd-20p">Infant Cost Price</th>
                            <th class="wd-20p">Adult Cost Price</th>
                            <th class="wd-10p">Created At</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visa as $key => $visa_rate)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $visa_rate->name }}</td>
                                <td>{{ $visa_rate->child_cost_price }}</td>
                                <td>{{ $visa_rate->infant_cost_price }}</td>
                                <td>{{ $visa_rate->adult_cost_price }}</td>
                                {{-- <td>@if ($visa_rate->status == 1)
                                        <button class="btn btn-rounded btn-success" style="color:#fff;">
                                            Active <span class="badge badge-primary"></span>
                                        </button>
                                    @else
                                        <button class="btn btn-rounded btn-danger" style="color:#fff;">
                                            Deactive <span class="badge badge-primary"></span>
                                        </button>
                                    @endif</td> --}}
                                <td><?= date('d-m-Y', strtotime($visa_rate['created_at'])) ?></td>

                                <td><a class="btn btn-rounded btn-primary"
                                        href="{{ url('/visa_rate/edit/' . \Crypt::encrypt($visa_rate->id_visa_rates)) }}">
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
                            <th class="wd-20p">Children Cost Price</th>
                            <th class="wd-20p">Infant Cost Price</th>
                            <th class="wd-20p">Adult Cost Price</th>
                            <th class="wd-10p">Created At</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            </div>
            <!-- card -->
        </div>
        <!-- col -->
    </div>
    </div><!-- az-content-body --> 
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
