@extends('layouts.master')
@section('content')
    <div class="card card-body pd-10">
        <div class="az-content-breadcrumb">
            <span>My Teams Jobs</span>
        </div>
        <h2 class="az-content-title" style="display: inline">My Teams Jobs<span></span>
        </h2>
    </div>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}


    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">

            <div class="card card-body pd-40">
                <div class="card bd-0">
                    <div class="card-header bg-gray-400 bd-b-0-f pd-b-0">
                        <nav class="nav nav-tabs">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tabCont1">All Un-Assign Team Jobs</a>
                            {{-- @if ($is_head) --}}
                            <a class="nav-link " data-bs-toggle="tab" href="#tabCont2">My Team Jobs</a>
                            {{-- @endif --}}
                        </nav>
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 tab-content">
                        <div id="tabCont1" class="tab-pane active show">
                            <div>
                                <table id="example2" class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th class="wd-10p">S.No</th>
                                            <th class="wd-20p">Inquiry</th>
                                            <th class="wd-20p">Customer</th>
                                            <th class="wd-20p">Department</th>
                                            <th class="wd-10p">Status</th>
                                            <th class="wd-10p">Created At</th>
                                            <th class="wd-10p">Operations</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($get_team as $key => $type)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>#<?= $type->get_inquiry->id_inquiry ?></td>
                                                <td><?= $type->get_inquiry->get_customer->customer_name ?></td>

                                                <td><?= $type->department_ids ?></td>
                                                @if ($type->status == 1)
                                                    <td> <span class="badge badge-warning">Un-Assigned</span></td>
                                                @else
                                                    <td> <span class=" badge badge-danger">In-Active</span></td>
                                                @endif

                                                <td><?= date('d-m-Y', strtotime($type['created_at'])) ?></td>
                                               
                                                <td>
                                                    @if ($is_head)
                                                        <a onclick="assign_job({{ $type->inquiry_id }},{{ $type->id_my_team_jobs }})"
                                                            style="color:#fff;" class="btn btn-rounded btn-warning">
                                                            Assign
                                                        </a>
                                                    @endif
                                                    <a onclick="take_team_job({{ $type->inquiry_id }},{{ $type->id_my_team_jobs }})"
                                                        style="color:#fff;" class="btn btn-rounded btn-success">
                                                        Take
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="wd-10p">S.No</th>
                                            <th class="wd-20p">Inquiry</th>
                                            <th class="wd-20p">Customer</th>
                                            <th class="wd-20p">Department</th>

                                            <th class="wd-10p">Status</th>
                                            <th class="wd-10p">Created At</th>
                                            <th class="wd-10p">Operations</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div><!-- tab-pane -->
                        {{-- @if ($is_head) --}}
                        <div id="tabCont2" class="tab-pane  show">
                            <div>
                                <table id="example2" class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th class="wd-10p">S.No</th>
                                            <th class="wd-20p">Inquiry</th>
                                            <th class="wd-20p">Department</th>
                                            <th class="wd-20p">Team</th>
                                            <th class="wd-20p">Taken By</th>
                                            <th class="wd-20p">Assign By</th>
                                            <th class="wd-10p">Status</th>
                                            <th class="wd-10p">Created At</th>

                                            {{-- <th class="wd-10p">Operations</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($my_team_jobs as $key => $type)
                                            <tr>

                                                <td>{{ $key + 1 }}</td>
                                                <td>#<?= $type->get_inquiry->id_inquiry ?></td>
                                                <td><?= $type->department_ids ?></td>
                                                <td>{{ get_team_name($type->team_id) }}</td>
                                                <td>{{ get_user_name($type->taken_by) }}</td>
                                                {{-- {{dd()}} --}}
                                                @if ($type->assign_by == auth()->user()->id)
                                                    <td> <span class="badge badge-success">My-Self</span></td>
                                                @elseif ($type->assign_by==null)
                                                    <td>No One</td>
                                                @else
                                                    <td><span
                                                            class="badge badge-warning">{{ get_user_name($type->assign_by) }}</span>
                                                    </td>
                                                @endif

                                                @if ($type->status == 1)
                                                    <td> <span class="badge badge-success">Active</span></td>
                                                @else
                                                    <td> <span class=" badge badge-danger">In-Active</span></td>
                                                @endif

                                                <td><?= date('d-m-Y', strtotime($type['created_at'])) ?></td>

                                                {{-- <td>
                                                    @if ($is_head)
                                                        <a style="color:#fff;" class="btn btn-rounded btn-success"
                                                            href="{{ url('/my_jobs/create/' . \Crypt::encrypt($type->inquiry_id) . '/' . \Crypt::encrypt($type->id_my_team_jobs)) }}">
                                                            Assign
                                                        </a>
                                                    @endif
                                                    <a onclick="take_team_job({{ $type->inquiry_id }},{{ $type->id_my_team_jobs }})" style="color:#fff;" class="btn btn-rounded btn-success"
                                                       >
                                                        Take
                                                    </a>
                                                </td> --}}
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="wd-10p">S.No</th>
                                            <th class="wd-20p">Inquiry</th>
                                            <th class="wd-20p">Department</th>
                                            <th class="wd-20p">Team</th>
                                            <th class="wd-20p">Taken By</th>
                                            <th class="wd-20p">Assign By</th>
                                            <th class="wd-10p">Status</th>
                                            <th class="wd-10p">Created At</th>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div><!-- tab-pane -->
                        {{-- @endif --}}

                    </div><!-- card-body -->
                </div>

            </div>
            <!-- card -->
        </div>
        <!-- col -->
    </div>


    <div id="modaldemo2" class="modal " aria-modal="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Take Job</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="">Team</label>
                    <form method="POST" action="{{ url('/take_my_team_job') }}">
                        @csrf
                        {{-- {{ url('/take_my_team_job/') }} --}}
                        <select style="width: 100%;" class="form-control" name="t_id" required>
                            <option value="">Select</option>
                            @isset($decode_team)
                                @forelse ($decode_team as $item)
                                    <option value="{{ $item }}">{{ get_team_name($item) }}</option>
                                @empty
                                @endforelse
                            @endisset
                        </select>
                        <input type="hidden" name="inq_id" id="inq_id">
                        <input type="hidden" name="my_t_job_id" id="my_t_job_id">


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-indigo">Assign</button>
                    </form>
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div><!-- modal-dialog -->
    </div>
    <div id="modaldemo1" class="modal " aria-modal="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Assign Job</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="">Team</label>
                    <form method="POST" action="{{ url('/assign_my_team_job') }}">
                        @csrf
                        {{-- {{ url('/take_my_team_job/') }} --}}
                        {{-- {{dd($decode_team)}} --}}
                        <select style="width: 100%;" id="team" onchange="change_team()" class="form-control"
                            name="t_id" required>
                            <option value="">Select</option>
                            @isset($decode_team)
                                @forelse ($decode_team as $item)
                                    <option value="{{ $item }}">{{ get_team_name($item) }}</option>
                                @empty
                                @endforelse
                            @endisset

                        </select>

                        <label for="">User</label>
                        <select style="width: 100%;" class="form-control" name="user_id" id="team_user" required>
                            <option value="">Select</option>
                        </select>
                        <input type="hidden" name="inq_id" id="inq_id1">
                        <input type="hidden" name="my_t_job_id" id="my_t_job_id1">


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
        function take_team_job(inq_id, my_t_job_id) {
            $('#modaldemo2').modal('show');
            $('#inq_id').val(inq_id);
            $('#my_t_job_id').val(my_t_job_id);


        }

        function change_team() {
            let team_id = $("#team").val();
            $.ajax({
                type: "GET",
                url: "{{ url('/get_team_users') }}/" + team_id,
                success: function(response) {
                    $("#team_user").html(response.data);
                }
            });

        }

        function assign_job(inq_id, my_t_job_id) {
            $('#modaldemo1').modal('show');
            $('#inq_id1').val(inq_id);
            $('#my_t_job_id1').val(my_t_job_id);
        }
        $(document).ready(function() {
            $('#example2').DataTable();

        });
    </script>
@endpush
