@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Inquiry</span>
        {{-- <span>Add Airline</span> --}}
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline"> Inquiry List <span>
            <a href="{{ url('inquiry/create') }}" class="btn btn-az-primary" style="float: right">Add Inquiry</a></span>
    </h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            {{-- <div class="card card-body pd-40"> --}}

            <div>
                <table id="example2" class="table table-striped">
                    <thead>
                        <tr>

                            <th data-label="Column 1">ID #</th>
                            <th data-label="Column 2">Customer Name</th>
                            <th data-label="Column 3">Inquiry Type</th>
                            <th data-label="Column 4">Inquiry For</th>
                            <th data-label="Column 6">Status</th>
                            <th class="wd-10f">Created By</th>
                            <th data-label="Column 8">Created At</th>
                            <th class="wd-10f none">Customer Cell</th>
                            <th class="wd-10f none">Sale Person</th>

                            <th class="wd-10f none">Sales Reference</th>

                            <th class="wd-10f none">Remarks</th>
                            <th class="wd-10f none">Cancel Reason</th>
                            <th class="wd-10f none">Confirmed</th>
                            <th class="wd-10f none">Customer Email</th>
                            <th class="wd-10f none">Customer Cell 2</th>
                            <th class="wd-10f none">Updated At</th>
                            {{-- <th class="wd-10f none">Action</th> --}}
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($inquiry as $key => $inq)
                            <tr>
                                <td class="table-elipse" data-toggle="collapse" data-target="#demo"><i
                                    class="fa fa-ellipsis-h text-black-50"></i></td>
                                <td>{{ $key + 1 }}</td>

                                <td>{{ $inq->customer_name }}</td>
                                @php
                                    $inquiry_type = App\inquirytypes::where('type_id', $inq->inquiry_type)->first();
                                    $customer = App\Customer::where('id_customers', $inq->customer_id)->first();
                                    $user = App\User::where('id', $inq->saleperson)->first();
                                @endphp
                                <td>{{ $inquiry_type->type_name }}</td>
                                <td>{{ $inq->customer_phone2 }}</td>
                                <td>
                                    @if ($inq->status == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">De-Active</span>
                                    @endif
                                </td>

                                <td>{{ $inq->created_by }}</td>
                                <td><?= date('d-m-Y', strtotime($inq->created_at)) ?></td>
                                <td>{{ $customer->customer_cell }}</td>
                                {{-- {{dd($user)}} --}}
                                <td>@if($user!=null) {{$user->name}}   @endif</td>
                                <td>{{ $inq->sales_reference }}</td>
                                <td>{{ $inq->remarks }}</td>
                                <td>{{ $inq->customer_address }}</td>
                                <td>{{ $inq->customer_address }}</td>

                                <td>{{ $customer->customer_email }}</td>
                                <td>{{ $customer->customer_phone1 }}</td>

                                {{-- @php
                                    $get_city = App\cities::where('id', $cus->city_id)->first();

                                @endphp --}}
                                {{-- <td>
                                    @if ($get_city != null)
                                        {{ $get_city->name }}
                                    @else
                                    @endif
                                </td> --}}
                                <td><?= date('d-m-Y', strtotime($inq->updated_at)) ?></td>

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th data-label="Column 1">ID #</th>
                            <th data-label="Column 2">Customer Name</th>
                            <th data-label="Column 3">Inquiry Type</th>
                            <th data-label="Column 4">Inquiry For</th>
                            <th data-label="Column 6">Status</th>
                            <th class="wd-10f">Created By</th>
                            <th data-label="Column 8">Created At</th>
                            <th class="wd-10f none">Customer Cell</th>
                            <th class="wd-10f none">Sale Person</th>

                            <th class="wd-10f none">Sales Reference</th>

                            <th class="wd-10f none">Remarks</th>
                            <th class="wd-10f none">Cancel Reason</th>
                            <th class="wd-10f none">Confirmed</th>
                            <th class="wd-10f none">Customer Email</th>
                            <th class="wd-10f none">Customer Cell 2</th>

                            <th class="wd-10f none">Updated At</th>
                            {{-- <th class="wd-10f none">Action</th> --}}
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
                    className: 'control',
                    orderable: false,
                    targets: 0
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
