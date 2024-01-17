@extends('layouts.master')
@section('content')
<div class="card card-body pd-10">
    <div class="az-content-breadcrumb">
        <span>My Teams Jobs</span>
    </div>
    <h2 class="az-content-title" style="display: inline">My Teams Jobs<span> </span>
    </h2>
</div>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">

            <div>
                <table id="example2" class="table table-responsive">
                    <thead>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Inquiry</th>
                            <th class="wd-20p">Department</th>
                            <th class="wd-20p">Services</th>
                            <th class="wd-20p">Sub Services</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created At</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($my_team_job as $key => $type)
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td>#<?=$type->inquiry_id?></td>
                                <td><?=$type->department_ids?></td>
                                <td><?=$type->services_ids?></td>
                                <td><?=$type->sub_services_id?></td>

                                @if ($type->status == 1)
                                    <td> <span class="badge badge-success">Active</span></td>
                                @else
                                    <td> <span class=" badge badge-danger">In-Active</span></td>
                                @endif

                                <td><?= date('d-m-Y', strtotime($type['created_at'])) ?></td>

                                <td><a style="color:#fff;" class="btn btn-rounded btn-success"
                                        href="{{ url('/my_jobs/create/' . \Crypt::encrypt($type->inquiry_id) . '/' . \Crypt::encrypt($type->id_my_team_jobs)) }}">
                                        Self-Assign
                                    </a>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Inquiry</th>
                            <th class="wd-20p">Department</th>
                            <th class="wd-20p">Services</th>
                            <th class="wd-20p">Sub Services</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created At</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            </div>
            <!-- card -->
        </div>
        <!-- col -->
    </div>
    <div id="modaldemo1" class="modal " aria-modal="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Assign Users</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="">Assign User</label>
                    <form method="POST" action="{{ url('assign_job') }}">
                        @csrf
                        <select style="width: 100%;" class="form-control" name="user_id" required>
                            <option value="">Select</option>
                            @forelse ($users as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        <input type="hidden" name="inq_id" id="inq_id">
                        <input type="hidden" name="t_id" id="t_id">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-indigo">Assign</button>
                    </form>
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div><!-- modal-dialog -->
    </div>
    {{-- </div><!-- az-content-body --> --}}
@endsection
@push('scripts')
    <script>
        function assignUser(inquiry_id, t_id) {
            $('#inq_id').val(inquiry_id);
            $('#t_id').val(t_id);

            $('#modaldemo1').modal('show');
        }
        $(document).ready(function() {
            $('#example2').DataTable();
        });
    </script>
@endpush
