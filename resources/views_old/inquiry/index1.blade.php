@extends('layouts.master')
@section('content')
    <style>
        /* Base table styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        /* Responsive styles */
        @media screen and (max-width: 600px) {

            /* Hide table headers on small screens */
            th {
                display: none;
            }

            /* Stack rows on small screens */
            tr {
                display: block;
                border: 1px solid #ddd;
                margin-bottom: 12px;
            }

            td {
                display: block;
                text-align: right;

                /* Add some spacing and border */
                padding-left: 50%;
                position: relative;
            }

            td::before {
                /* Show labels for each cell */
                content: attr(data-label);
                position: absolute;
                left: 6px;
                top: 50%;
                transform: translateY(-50%);
                font-weight: bold;
            }
        }
        .az-content{
            overflow: auto;
        }
    </style>



    <div class="az-content-breadcrumb">
        <span>Customers</span>
        {{-- <span>Add Airline</span> --}}
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline"> Customers List <span>
            <a href="{{ url('customers/create') }}" class="btn btn-az-primary" style="float: right">Add Customers</a></span>
    </h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            {{-- <div class="card card-body pd-40"> --}}


            <div>
                <table id="example23" class="display nowrap" cellspacing="1">
                    <thead>
                        <tr>
                            <th data-label="Column 1">ID #</th>
                            <th data-label="Column 2">Customer Name</th>
                            <th data-label="Column 3">Inquiry Type</th>
                            <th data-label="Column 4">Customer Cell</th>
                            <th data-label="Column 5">Sale Person</th>
                            <th data-label="Column 6">Status</th>
                            <th data-label="Column 7">Sales Reference</th>
                            <th data-label="Column 8">Created At</th>
                            <th data-label="Column 9">Remarks</th>
                            <th data-label="Column 10">Cancel Reason</th>
                            <th data-label="Column 11">Confirmed</th>
                            <th data-label="Column 12">Customer Email</th>
                            <th data-label="Column 13">Customer Cell 2</th>
                            <th data-label="Column 14">Created By</th>
                            <th data-label="Column 15">Updated At</th>
                            <th data-label="Column 16" style="width:20%;">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID #</th>
                            <th>Customer Name</th>
                            <th>Inquiry Type</th>
                            <th>Customer Cell</th>
                            <th>Sale Person</th>
                            <th>Status</th>
                            <th>Sales Reference</th>
                            <th>Created At</th>
                            <th>Remarks</th>
                            <th>Cancel Reason</th>
                            <th>Confirmed</th>
                            <th>Customer Email</th>
                            <th>Customer Cell 2</th>
                            <th>Created By</th>
                            <th>Updated At</th>
                            <th>Action</th>
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
    <script type="text/javascript">
        $(function() {



            $('#example23 tfoot th').each(function() {
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
            });

            oTable = $('#example23').DataTable({
                "stateSave": true,
                "processing": true,
                "responsive": true,
                "serverSide": true,
                "ajax": "{{ url('inquiry_ajax_list') }}",

                "columns": [{
                        data: 'id_inquiry',
                        name: 'id_inquiry',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'customer_id',
                        name: 'customer_name',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'inquiry_type',
                        name: 'inquiry_type',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'contact_1',
                        name: 'contact_1',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'saleperson',
                        name: 'saleperson',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'sales_reference',
                        name: 'sales_reference',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'remarks',
                        name: 'remarks',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'cancel_reason',
                        name: 'cancel_reason',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'confirmed_amount',
                        name: 'confirmed_amount',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'email',
                        name: 'email',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'contact_2',
                        name: 'contact_2',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'created_by',
                        name: 'created_by',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        searchable: true,
                        orderable: true
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }

                ],
                //             lengthMenu: [
                // [ 10, 25, 50, -1 ],
                // [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                // ],

                //            Then
                "lengthMenu": [
                    [10, 25, 50],
                    [10, 25, 50]
                ],
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
                order: [1, 'asc'],
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
        $(document).on('click', '.delete', function() {
            if (confirm('Are you sure want to delete?')) {} else {
                return false;
            }
        });
    </script>
@endpush
