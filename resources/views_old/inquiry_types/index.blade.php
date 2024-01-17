@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Inquiry Types</span>
    </div>
    <h2 class="az-content-title" style="display: inline"> Inquiry Types List <span>
            <a href="{{ url('inquiry_types/create') }}" class="btn btn-az-primary" style="float: right">Add Inquiry Type</a></span></h2>
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
                            <th class="wd-20p">Inquiry Type Name</th>
                            <th class="wd-10p">Created</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inquiry_types as $key => $package)
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td>{{ $package['type_name'] }}</td>
                                <td><?= date('d-m-Y', strtotime($package['created_at']))?></td>

                                <td><a class="btn btn-rounded btn-primary" href="{{ url('inquiry_types/edit/'.\Crypt::encrypt($package['type_id'])) }}">
                                Edit
                                </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                     <tfoot>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Inquiry Type Name</th>
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

<script type="text/javascript">

    $(function(){



        oTable = $('#example2').DataTable({

            responsive: !0
        });



   });

</script>
@endpush
