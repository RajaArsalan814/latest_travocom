@extends('layouts.master')
@section('content')
    <style>
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
    <div class="card card-body pd-10">
    <div class="az-content-breadcrumb">
        <span>Inquiry</span>
        {{-- <span>Add Airline</span> --}}
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline"> Inquiry List <span>
            <a href="{{ url('inquiry/create') }}" class="btn btn-az-primary" style="float: right">Add Inquiry</a></span>
    </h2>
    </div>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-20">

            <div>
                <h5>Add Filters</h5>
                <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-control-label">Customer</label>
                                <input type="text" class="form-control" placeholder="Search by Customer"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-control-label">Customer Cell</label>
                                <input type="text" class="form-control" placeholder="Search by Customer Cell"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-control-label">Inquiry Type</label>
                                <input type="text" class="form-control" placeholder="Search by Inquiry Type"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-control-label">Status</label>
                                <input type="text" class="form-control" placeholder="Search by Status"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-control-label">Sales Person</label>
                                <input type="text" class="form-control" placeholder="Search by Sales Person"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-control-label">Travel Date</label>
                                <input type="text" class="form-control" placeholder="Search by Travel Date"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-control-label mt-2">From Date</label>
                                <input type="text" class="form-control" placeholder="Select From Date"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-control-label mt-2">To Date</label>
                                <input type="text" class="form-control" placeholder="Select To Date"/>
                            </div>
                        </div>
                </div>
                <hr>

                <table id="example2" class="table table-bordered">
                    <thead>
                        <tr>
                            <th data-label="Column 1">View</th>
                            <th data-label="Column 1">ID #</th>
                            <th data-label="Column 2">Customer Name</th>
                            <th data-label="Column 3">Inquiry Type</th>
                            <th data-label="Column 4">Inquiry For</th>
                            <th data-label="Column 6">Status</th>
                            <th class="wd-10f">Created By</th>
                            <th data-label="Column 8">Created At</th>

                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($inquiry as $key => $inq)
                            <tr>
                            <tr class="cell-1" data-toggle="collapse" data-target="#demo{{ $inq->id_inquiry }}">
                                <td class="table-elipse" data-toggle="collapse" data-target="#demo"><i
                                        class="fa fa-ellipsis-h text-black-50"></i></td>
                                <td>{{ $key + 1 }}</td>

                                <td>{{ $inq->customer_name }}</td>
                                
                                <td>{{ $inq->inquiry_type_name }}</td>
                                <td>{{ $inq->customer_phone2 }}</td>
                                <td>
                                    @php
                                        $remark = App\remarks::where('inquiry_id', $inq->id_inquiry)
                                            ->orderBy('id_remarks', 'desc')
                                            ->first();
                                    @endphp
                                    @if ($remark?->remarks_status == 0)
                                        <span class="badge badge-warning"><span class=""></span>Open</span>
                                    @elseif($remark?->remarks_status == 1)
                                        <span class="badge badge-primary"><span
                                                class="">Status:</span>In-Progress</span>
                                    @elseif($remark?->remarks_status == 2)
                                        <span class="badge badge-Info"><span class=""></span>Quotation
                                            Shared</span>
                                    @elseif($remark?->remarks_status == 3)
                                        <span class="badge badge-success"><span
                                                class="">Status:</span>Confirmed</span>
                                    @elseif($remark?->remarks_status == 4)
                                        <span class="badge badge-success"><span
                                                class="">Status:</span>Completed</span>
                                    @elseif($remark?->remarks_status == 5)
                                        <span class="badge badge-danger"><span class=""></span>Cancelled</span>
                                    @endif
                                </td>

                                <td>{{ $inq->created_by_name }}</td>
                                 
                                <td><?= date('d-m-Y', strtotime($inq->created_at_date)) ?></td>
                            </tr>


                            <tr id="demo{{ $inq->id_inquiry }}" class="collapse cell-1 row-child">
                                {{-- <td colspan="1"><i class="fa fa-angle-up"></i></td> --}}
                                {{-- <td colspan="2" style="font-weight:bold;">User Name&nbsp;</td>
                                <td></td>
                                <td colspan="1" style="font-weight:bold;">Services&nbsp;</td>
                                <td colspan="1" style="font-weight:bold;">Sub Services&nbsp;</td> --}}


                            </tr>
                            {{-- @foreach ($decode as $key => $value) --}}
                            <tr id="demo{{ $inq->id_inquiry }}" class="collapse cell-1 row-child">
                                <td colspan="2" style="font-weight:bold;">Customer Cell&nbsp;</td>
                                <td colspan="" style="font-weight:bold;">{{ $inq->customer_cell }}&nbsp;</td>
                            </tr>
                            <tr id="demo{{ $inq->id_inquiry }}" class="collapse cell-1 row-child">
                                <td colspan="2" style="font-weight:bold;">Sale Person&nbsp;</td>
                                <td colspan="" style="font-weight:bold;">
                                    <?=$inq->sales_man?>
                                </td>
                            </tr>
                            <tr id="demo{{ $inq->id_inquiry }}" class="collapse cell-1 row-child">
                                <td colspan="2" style="font-weight:bold;">Sale Reference&nbsp;</td>
                                <td colspan="" style="font-weight:bold;">
                                    {{ $inq->sales_ref }}&nbsp;
                                </td>
                            </tr>
                            <tr id="demo{{ $inq->id_inquiry }}" class="collapse cell-1 row-child">
                                <td colspan="2" style="font-weight:bold;">Remarks&nbsp;</td>
                                <td colspan="" style="font-weight:bold;">
                                    {{ $inq->remarks }}&nbsp;
                                </td>
                            </tr>
                            <tr id="demo{{ $inq->id_inquiry }}" class="collapse cell-1 row-child">
                                <td colspan="2" style="font-weight:bold;">Cancel Reason&nbsp;</td>
                                <td colspan="" style="font-weight:bold;">
                                    {{ $inq->customer_address }}&nbsp;
                                </td>
                            </tr>
                            <tr id="demo{{ $inq->id_inquiry }}" class="collapse cell-1 row-child">
                                <td colspan="2" style="font-weight:bold;">Confirmed&nbsp;</td>
                                <td colspan="" style="font-weight:bold;">
                                    {{ $inq->customer_address }}&nbsp;
                                </td>
                            </tr>
                            <tr id="demo{{ $inq->id_inquiry }}" class="collapse cell-1 row-child">
                                <td colspan="2" style="font-weight:bold;">Customer Email&nbsp;</td>
                                <td colspan="" style="font-weight:bold;">
                                    {{ $inq->customer_email }}&nbsp;
                                </td>
                            </tr>
                            <tr id="demo{{ $inq->id_inquiry }}" class="collapse cell-1 row-child">
                                <td colspan="2" style="font-weight:bold;">Customer Cell 2&nbsp;</td>
                                <td colspan="" style="font-weight:bold;">
                                    {{ $inq->customer_phone1 }}&nbsp;
                                </td>
                            </tr>
                            <tr id="demo{{ $inq->id_inquiry }}" class="collapse cell-1 row-child">
                                <td colspan="2" style="font-weight:bold;">Updated At&nbsp;</td>
                                <td colspan="" style="font-weight:bold;">
                                    <?= date('d-m-Y', strtotime($inq->updated_at)) ?>&nbsp;
                                </td>
                            </tr>
                            <tr id="demo{{ $inq->id_inquiry }}" class="collapse cell-1 row-child">
                                <td colspan="2" style="font-weight:bold;">Edit&nbsp;</td>
                                <td colspan="" style="font-weight:bold;">
                                    <a href="{{ url('/inquiry_edit/' . \Crypt::encrypt($inq->id_inquiry)) }}"
                                        class="btn btn-rounded btn-warning">Edit</a>
                                        <a href="{{ url('create_quotation/' . \Crypt::encrypt($inq->id_inquiry)) }}" style="color:#fff;"
                                        class="btn btn-rounded btn-success">View Details</a>
                                </td>
                            </tr>
                            <tr id="demo2{{ $inq->id_inquiry }}" class="collapse cell-1 row-child">
                                <td colspan="2" style="font-weight:bold;">Edit&nbsp;</td>
                                <td colspan="" style="font-weight:bold;">
                                    <a href="{{ url('/inquiry_edit/' . \Crypt::encrypt($inq->id_inquiry)) }}"
                                        class="btn btn-warning">Edit</a>
                                        
                                        
                                </td>
                            </tr>
                            {{-- @endforeach --}}
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th data-label="Column 1">View</th>
                            <th data-label="Column 1">ID #</th>
                            <th data-label="Column 2">Customer Name</th>
                            <th data-label="Column 3">Inquiry Type</th>
                            <th data-label="Column 4">Inquiry For</th>
                            <th data-label="Column 6">Status</th>
                            <th class="wd-10f">Created By</th>
                            <th data-label="Column 8">Created At</th>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
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
