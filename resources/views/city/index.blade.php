@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Cities</span>
    </div>
    <h2 class="az-content-title" style="display: inline"> City List <span></span></h2>
            <!--<a href="{{ url('inquiry_types/create') }}" class="btn btn-az-primary" style="float: right">Add Inquiry Type</a></span></h2>-->
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
                            <th class="wd-20p">City</th>
                            <th class="wd-20p">State Code</th>
                            <th class="wd-20p">Country Code</th>
                            <th class="wd-20p">Country</th>
                        </tr>
                    </thead>
                    <tbody id="data-body"> <!-- Empty tbody element for data to be loaded via AJAX -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">City</th>
                            <th class="wd-20p">State Code</th>
                            <th class="wd-20p">Country Code</th>
                            <th class="wd-20p">Country</th>

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

        $('#example2').DataTable({

            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("get_cities_data") }}',
                type: 'GET',
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'state_id', name: 'state_id' },
                { data: 'state_code', name: 'state_code' },
                { data: 'country_name', name: 'country_name' },


            ],
        });
    });


</script>

@endpush
