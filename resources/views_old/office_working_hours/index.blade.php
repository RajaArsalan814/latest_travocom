@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Office Working hours</span>
    </div>
    <h2 class="az-content-title" style="display: inline"> Office Working hours List <span>
            <a href="{{ url('office_working_hours/create') }}" class="btn btn-az-primary" style="float: right">Add Office Working hours
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
                            <th class="wd-20p">Day Of Week Name</th>
                            <th class="wd-10p">Start Time </th>
                            <th class="wd-10p">End Time</th>
                            <th class="wd-10p">Created At</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($office_working_hours as $key => $office_hour)
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td>{{ $office_hour->day_of_week }}</td>
                                <td><?= date('h:i a', strtotime($office_hour['start_time'])) ?></td>
                                <td><?= date('h:i a', strtotime($office_hour['end_time'])) ?></td>
                                <td><?= date('d-m-Y', strtotime($office_hour['created_at'])) ?></td>

                                <td><a class="btn btn-rounded btn-primary" href="{{url('/office_working_hours/edit/'.\Crypt::encrypt($office_hour->id_office_working_hour))}}">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Day Of Week Name</th>
                            <th class="wd-10p">Start Time </th>
                            <th class="wd-10p">End Time</th>
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
