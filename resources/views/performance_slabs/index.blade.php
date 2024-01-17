@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Performance Slabs</span>
    </div>
    <h2 class="az-content-title" style="display: inline"> Performance Slabs List <span>
            <a href="{{ url('performance_slabs/create') }}" class="btn btn-az-primary" style="float: right">Add Performance Slabs
                </a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            {{-- <div class="card card-body pd-40"> --}}

            <div>
                <table id="example2" class="table table-responsive">
                    <thead>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Slab Code</th>
                            <th class="wd-10p">Start Date</th>
                            <th class="wd-10p">End Date</th>
                            <th class="wd-10p">Slab Amount</th>
                            <th class="wd-10p">No Of Persons</th>
                            <th class="wd-10p">Month</th>
                            <th class="wd-10p">Target Amount</th>
                            <th class="wd-10p">Employee Name</th>
                            <th class="wd-10p">Created At</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($performance_slabs as $key => $type)
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td>{{ $type->slab_code }}</td>
                                <td><?= date('d-m-Y', strtotime($type['start_date'])) ?></td>
                                <td><?= date('d-m-Y', strtotime($type['end_date'])) ?></td>
                                <td>{{ $type->slab_amount }}</td>
                                <td>{{ $type->no_of_persons }}</td>
                                <td>{{ $type->month }}</td>
                                <td>{{ $type->target_amount }}</td>
                                <td>{{ $type->employee_name }}</td>
                                <td><?= date('d-m-Y', strtotime($type['created_at'])) ?></td>
                                <td><a class="btn btn-rounded btn-primary" href="{{url('/performance_slabs/edit/'.\Crypt::encrypt($type->id_performance_slabs))}}">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Slab Code</th>
                            <th class="wd-10p">Start Date</th>
                            <th class="wd-10p">End Date</th>
                            <th class="wd-10p">Slab Amount</th>
                            <th class="wd-10p">No Of Persons</th>
                            <th class="wd-10p">Month</th>
                            <th class="wd-10p">Target Amount</th>
                            <th class="wd-10p">Employee Name</th>
                            <th class="wd-10p">Created At</th>
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
<script>
    $(document).ready(function () {
    $('#example2').DataTable();
});
</script>
@endpush
