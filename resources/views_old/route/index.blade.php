@extends('layouts.master')
@section('content')
    <style>
        /* Styles for the element with the 'grow' class */
        .grow {
            padding: 5px;
            border-radius: 10px;
            height: 49px;
            width: 100%;
            margin: 5px 1%;
            float: left;
            position: relative;
            /* margin-left: -120px; */
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
        <span>Route</span>
    </div>
    <h2 class="az-content-title" style="display: inline"> Route List <span>
            <a href="{{ url('route/create') }}" class="btn btn-az-primary" style="float: right">Add Route</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            {{-- <div class="card card-body pd-40"> --}}

            <div>
                <table id="example2" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Name</th>
                            <th class="wd-20p">Location</th>
                            <th class="wd-10p">Created</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($routes as $key => $route)
                            <tr>
                                {{-- {{dd($route)}} --}}
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $route['route_name'] }}</td>

                                <td class="">
                                    {{ $route->route_location }}
                                </td>

                                <td><?= date('d-m-Y', strtotime($route['created_at'])) ?></td>

                                <td>
                                    {{-- <a class="btn btn-rounded btn-primary" href="{{ route('route/edit/' . \Crypt::encrypt($route['id_route'])) }}">
                                Edit
                                </a> --}}
                                    <a class="btn btn-rounded btn-primary"
                                        href="{{ url('route/edit/' . \Crypt::encrypt($route->id_route)) }}">Edit</a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Name</th>
                            <th class="wd-20p">Location</th>
                            <th class="wd-10p">Created</th>
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
    {{-- <script type="text/javascript">

    $(function(){



        oTable = $('#example2').DataTable({

            responsive: !0
        });



   });

</script> --}}
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
