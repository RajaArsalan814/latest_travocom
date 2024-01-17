@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Countries</span>
    </div>
    <h2 class="az-content-title" style="display: inline"> Countries List <span></span></h2>
            {{-- <a href="{{ url('countries/create') }}" class="btn btn-az-primary" style="float: right">Add Country</a> --}}
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            {{-- <div class="card card-body pd-40"> --}}

            <div>
                <table id="example2" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Country Name</th>
                            <th class="wd-20p">Short Form</th>
                            <th class="wd-20p">Capital</th>
                            <th class="wd-20p">Currency</th>
                            <th class="wd-20p">Currency Name</th>
                            <th class="wd-20p">region</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($countries as $key => $country)
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td>{{ $country['country_name'] }}</td>
                                <td>{{ $country['iso3'] }}</td>
                                <td>{{ $country['capital'] }}</td>
                                <td>{{ $country['currency_symbol'] }}</td>
                                <td>{{ $country['currency_name'] }}</td>
                                <td>{{ $country['region'] }}</td>


                            </tr>
                        @endforeach
                    </tbody>
                     <tfoot>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Country Name</th>
                            <th class="wd-20p">Short Form</th>
                            <th class="wd-20p">Capital</th>
                            <th class="wd-20p">Currency</th>
                            <th class="wd-20p">Currency Name</th>
                            <th class="wd-20p">region</th>
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

    $(function(){



        oTable = $('#example2').DataTable({

            responsive: !0
        });



   });

</script>
@endpush

