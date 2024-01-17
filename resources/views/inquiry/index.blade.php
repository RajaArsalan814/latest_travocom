@extends('layouts.master')
@section('content')
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


    <div class="az-content-body d-flex flex-column">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-20">

            <div>
                <h5>Filter Pane</h5>
<!--                <div class="row">
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
                </div>-->
                <hr>
<div class="table-responsive">
                            <table id="example23" class="display nowrap" cellspacing="1" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID #</th>
                                        <th>Customer</th>
                                        <th>Inquiry Type</th>
                                        <th>Ph#</th>
                                        <th>Inquiry Remarks</th>
                                        <th>SP</th>
                                        <th>Status</th>
                                        <th class="none">Services</th>
                                        <th class="none">SR</th>
                                        <th class="none">City</th>
                                        <th class="none">TD</th>
                                        <th class="none">FUD</th>
                                        <th class="none">Created At</th>
                                        <th class="none">Remarks</th>
                                        <th class="none">Customer Email</th>
                                        <th class="none">Customer Cell 2</th>
                                        <th class="none">Created By</th>
                                        <th class="none">Updated At</th>
                                        <th style="width:20%;">Action</th>
                                    </tr>
                                </thead>
                               
                                <tbody>
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID #</th>
                                        <th>Customer</th>
                                        <th>Inquiry Type</th>
                                        <th>Ph#</th>
                                        <th>Inquiry Remarks</th>
                                        <th>SP</th>
                                        <th>Status</th>
                                        <th class="none">Services</th>
                                        <th class="none">SR</th>
                                        <th class="none">City</th>
                                        <th class="none">TD</th>
                                        <th class="none">FUD</th>
                                        <th class="none">Created At</th>
                                        <th class="none">Remarks</th>
                                        <th class="none">Customer Email</th>
                                        <th class="none">Customer Cell 2</th>
                                        <th class="none">Created By</th>
                                        <th class="none">Updated At</th>
                                        <th style="width:20%;">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
            </div>
            </div>
            <!-- card -->
        </div>
        <!-- col -->
    </div>
     </div>
@endsection
@push('scripts')
    <script type="text/javascript">

    $(function(){
        
        $('#example23 tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
    });

        oTable = $('#example23').DataTable({
            "stateSave": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": "{{ url('inquiry_ajax_list') }}",
             columnDefs: [
            {
                orderable: false,
                className: 'select-checkbox',
                searchPanes: {
                    show: true,
                    options: [
                        {
                            label: 'Checked',
                            value: function(rowData,rowIdx) {
                                return this.row(rowIdx, {selected: true}).any();
                            }
                        },
                        {
                            label: 'Un-Checked',
                            value: function(rowData, rowIdx) {
                                return this.row(rowIdx, {selected: true}).any() === false;
                            }
                        }
                    ]
                },
                targets: [0]
            },
            {
                searchPanes: {
                    options: [
                        {
                            label: 'Under 20',
                            value: function(rowData, rowIdx) {
                                return rowData[4] < 20;
                            }
                        },
                        {
                            label: '20 to 30',
                            value: function(rowData, rowIdx) {
                                return rowData[4] <= 30 && rowData[4] >=20;
                            }
                        },
                         {
                            label: '30 to 40',
                            value: function(rowData, rowIdx) {
                                return rowData[4] <= 40 && rowData[4] >=30;
                            }
                        },
                         {
                            label: '40 to 50',
                            value: function(rowData, rowIdx) {
                                return rowData[4] <= 50 && rowData[4] >=40;
                            }
                        },
                         {
                            label: '50 to 60',
                            value: function(rowData, rowIdx) {
                                return rowData[4] <= 60 && rowData[4] >=50;
                            }
                        },
                         {
                            label: 'Over 60',
                            value: function(rowData, rowIdx) {
                                return rowData[4] > 60;
                            }
                        }
                    ]
                },
                targets: [4]
            },
            {
                searchPanes: {
                    options: [
                        {
                            label: 'Not Edinburgh',
                            value: function(rowData, rowIdx) {
                                return rowData[3] !== 'Edinburgh';
                            }
                        },
                        {
                            label: 'Not London',
                            value: function(rowData, rowIdx) {
                                return rowData[3] !== 'London';
                            }
                        }
                    ],
                    combiner: 'and'
                },
                targets: [3]
            }
        ],
            "columns": [
                {data: 'id_inquiry', name: 'id_inquiry', searchable: true, orderable: true},
                {data: 'customer', name: 'customer', searchable: true, orderable: true},
                {data: 'inquiry_type', name: 'inquiry_type', searchable: true, orderable: true},
                {data: 'contact_1', name: 'contact_1', searchable: true, orderable: true},
                {data: 'initial_remarks', name: 'initial_remarks', searchable: true, orderable: true},
                {data: 'saleperson', name: 'saleperson', searchable: true, orderable: true},
                {data: 'status', name: 'status', searchable: true, orderable: true},
                {data: 'services', name: 'services', searchable: true, orderable: true},
                {data: 'sales_reference', name: 'sales_reference', searchable: true, orderable: true},
                {data: 'city', name: 'city', searchable: true, orderable: true},
                {data: 'travel_date', name: 'travel_date', searchable: true, orderable: true},
                {data: 'followup_date', name: 'followup_date', searchable: true, orderable: true},
                {data: 'created_at', name: 'created_at', searchable: true, orderable: true},
                {data: 'remarks', name: 'remarks', searchable: true, orderable: true},
                {data: 'email', name: 'email', searchable: true, orderable: true},
                {data: 'contact_2', name: 'contact_2', searchable: true, orderable: true},
                {data: 'created_by', name: 'created_by', searchable: true, orderable: true},
                {data: 'updated_at', name: 'updated_at', searchable: true, orderable: true},
                {data: 'action', name: 'action'}
                
            ],
            //             lengthMenu: [
            // [ 10, 25, 50, -1 ],
            // [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            // ],

//            Then
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ordering": true,
            "dom": 'Blfrtip',
            "buttons": [
            'excel', 'pdf', 'print'
            ],  
            responsive: !0,
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
    $(document).on('click', '.delete', function () {
        if (confirm('Are you sure want to delete?')) {
        }
        else {
            return false;
        }
    });



</script>
@endpush

