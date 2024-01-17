@extends('layouts.master')
@section('content')
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

    /* Styles for the element with the 'grow' class */
    .grow {
        padding: 5px;
        border-radius: 10px;
        height: 49px;
        width: 100%;
        margin: 5px 1%;
        float: left;
        position: relative;
        /* margin-left: -110px; */
        text-align: center;
        overflow: hidden;
        /* Set the transition effect for height to last 5.5 seconds */
        transition: height 5.5s;
        /* Set the transition effect for height specifically for webkit-based browsers */
        -webkit-transition: height 0.5s;
    }

    /* Styles applied when the element with 'grow' class is hovered over */
    .grow:hover {
        /* Allow the element to grow to fit its content height */
        height: 100px !important;
        overflow: auto;
        /* width: 50vw; */
        /* Optionally, you can set the width to 50vw when the element is hovered over */
    }

    .li {
        margin-left: -15px;
    }
</style>
<div class="az-content-breadcrumb">
    <span>Land And Services</span>
</div>
<h2 class="az-content-title" style="display: inline"> Land And Services List <span>
        <a href="{{ url('land_services/create') }}" class="btn btn-az-primary ms-2" style="float: right">Add Land And
            Services</a>


    </span></h2>

{{-- <h2 style="float: right" class="az-content-title"></h2> --}}


{{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12">
        {{-- <div class="card card-body pd-40"> --}}

        <div>
            <table id="example2" class="table table-striped">
                <thead>
                    <tr>
                        <th class="wd-10p">View</th>
                        <th class="wd-10p"></th>
                        <th class="wd-10p">Name</th>
                        <th class="wd-10p">Service Type</th>

                        <th class="wd-10p">Created At</th>
                        <th class="wd-10p">Updated At</th>
                        <th class="wd-10p">Operation</th>


                    </tr>
                </thead>
                <tbody>
                    @foreach ($landservicestypes as $key => $land)
                    @php
                    $get_service_name = App\land_services_type::where('id_land_services_types', $land->name)->first();
                    @endphp
                    <tr>
                    <tr class="cell-1" data-toggle="collapse" data-target="#demo{{ $land->id_land_and_services_types }}">
                        <td class="table-elipse" data-toggle="collapse" data-target="#demo"><i class="fa fa-ellipsis-h text-black-50"></i></td>

                        <td></td>
                        <td>{{ $get_service_name->service_name }}</td>
                        <td>{{ $land->service_type }}</td>
                        <td><?= date('d-m-Y', strtotime($land->created_at)) ?></td>
                        <td><?= date('d-m-Y', strtotime($land->updated_at)) ?></td>
                        <td><a class="btn btn-rounded btn-indigo" href="{{ url('land_services/edit/'.\Crypt::encrypt($land['id_land_and_services_types'])) }}">
                                Edit
                            </a></td>
                    </tr>

                    @php
                    $decode = json_decode($land->total_entries);
                    // dd($decode);
                    @endphp
                    <tr id="demo{{ $land->id_land_and_services_types }}" class="collapse cell-1 row-child">
                        <td  style="font-weight:bold;">Transport &nbsp;</td>
                        <td  style="font-weight:bold;">Transport Type &nbsp;</td>
                        <td  style="font-weight:bold;">Adult Details &nbsp;</td>
                        <td  style="font-weight:bold;">Children Details &nbsp;</td>
                        <td  style="font-weight:bold;">Infants Details &nbsp;</td>
                        <td  style="font-weight:bold;">Cost Price&nbsp;</td>
                        <td  style="font-weight:bold;">Selling Price&nbsp;</td>
                        {{-- <td></td> --}}

                    </tr>
                    @foreach ($decode as $key => $value)
                    {{-- {{dd($value->adult_cost_price)}} --}}
                    <tr id="demo{{ $land->id_land_and_services_types }}" class="collapse cell-1 row-child">
                        <td >{{ $value->transport }}</td>
                        <td >{{ $value->transport_type }}</td>
                        @if($value->transport_type == 'no_of_person')
                        <td >
                            <ul>
                                <li>{{ $value->adult_cost_price }}</li>
                                <li>{{ $value->adult_selling_price }}</li>
                            </ul>
                        </td>
                        <td >
                            <ul>
                                <li>{{ $value->children_cost_price }}</li>
                                <li>{{ $value->children_selling_price }}</li>
                            </ul>
                        </td>
                        <td >
                            <ul>
                                <li>{{ $value->infant_cost_price }}</li>
                                <li>{{ $value->infant_selling_price }}</li>
                            </ul>
                        </td>
                        <td ></td>
                        <td ></td>

                        @elseif($value->transport_type == 'service_level')
                        <td ></td>
                        <td ></td>
                        <td ></td>
                        <td >{{ $value->cost_price }}</td>
                        <td >{{ $value->selling_price }}</td>

                        @endif


                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="wd-10p">View</th>
                        <th class="wd-10p">Name</th>
                        <th class="wd-10p"></th>
                        {{-- <td style="font-weight:bold;">Services</td> --}}
                        {{-- <td style="font-weight:bold;">Sub Services</td> --}}
                        <th class="wd-10p">Service Type</th>

                        <th class="wd-10p">Created At</th>
                        <th class="wd-10p">Updated At</th>
                        <th class="wd-10p">Operation</th>


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
{{-- <script type="text/javascript">

    $(function(){



        oTable = $('#example2').DataTable({

            responsive: !0
        });



   });

</script> --}}
<script>
    function service_type_modal_show() {
        $('#modaldemo2').modal('show');
    }

    $(document).ready(function() {
        $(".js-example-tokenizer").select2({
            tags: true,
            tokenSeparators: [','],
            dropdownParent: $("#modaldemo2")

        })
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
