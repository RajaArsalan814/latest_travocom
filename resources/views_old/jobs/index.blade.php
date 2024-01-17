@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Jobs</span>
    </div>
    <h2 class="az-content-title" style="display: inline"> Jobs List <span>
            <a href="{{ url('jobs/create') }}" class="btn btn-az-primary" style="float: right">Add Jobs</a></span></h2>
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
                            <th class="wd-20p">Job</th>
                            <th class="wd-20p">Description</th>
                            <th class="wd-20p">Inquiry Type</th>
                            <th class="wd-20p">Duration</th>
                            <th class="wd-20p">Roles</th>
                            <th class="wd-20p">Status</th>
                            <th class="wd-10p">Created</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $jobs)
                            <?php
                            $inquiry_output = null;
                            if ($jobs['inquiry_type'] == 1) {
                                $inquiry_output = 'Air Ticketing';
                            }
                            if ($jobs['inquiry_type'] == 2) {
                                $inquiry_output = 'Open Status';
                            }
                            if ($jobs['inquiry_type'] == 3) {
                                $inquiry_output = 'In-Progress Status';
                            }
                            if ($jobs['inquiry_type'] == 4) {
                                $inquiry_output = 'Follow-up';
                            }
                            ?>
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td>{{ $jobs['job_name'] }}</td>
                                <td>{{ $jobs['job_description'] }}</td>
                                <td><span style="font-size:16px;" class="badge badge-success">{{ $inquiry_output }}</span>
                                </td>
                                <td><span style="font-size:16px;" class="badge badge-warning">Hours:
                                        {{ $jobs['job_duration_hours'] }}<br>Minutes:
                                        {{ $jobs['job_duration_minutes'] }}</span></td>
                                <td><a class="btn btn-rounded btn-primary" href="#">
                                        Add
                                    </a></td>
                                <td>
                                    @if ($jobs['status'] == 1)
                                        <button class="btn btn-rounded btn-success" style="color:#fff;">
                                            Active <span class="badge badge-primary"></span>
                                        </button>
                                    @else
                                        <button class="btn btn-rounded btn-danger" style="color:#fff;">
                                            Deactive <span class="badge badge-primary"></span>
                                        </button>
                                    @endif
                                </td>
                                <td><?= date('d-m-Y', strtotime($jobs['created_at'])) ?></td>

                                <td><a class="btn btn-rounded btn-primary"
                                        href="{{ url('jobs/edit/' . \Crypt::encrypt($jobs->id_jobs)) }}">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Job</th>
                            <th class="wd-20p">Description</th>
                            <th class="wd-20p">Inquiry Type</th>
                            <th class="wd-20p">Duration</th>
                            <th class="wd-20p">Roles</th>
                            <th class="wd-20p">Status</th>
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
