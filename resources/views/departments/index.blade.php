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
    </style>
    <div class="card card-body pd-10">
        <div class="az-content-breadcrumb">
            <span>Departments</span>
        </div>
        <h2 class="az-content-title" style="display: inline"> Departments List <span>
                {{-- <a href="{{ url('departments/create') }}" class="btn btn-az-primary" style="float: right">Add
                    Department</a></span> --}}
        </h2>
        {{-- <h2 style="float: right" class="az-content-title"></h2> --}}
    </div>

    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">

                <div>
                    <table id="example2" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="wd-10p">View</th>
                                <th class="wd-20p">Department Name</th>
                                {{-- <td style="font-weight:bold;">Services</td> --}}
                                {{-- <td style="font-weight:bold;">Sub Services</td> --}}
                                <th class="wd-15p">User Count</th>
                                <th class="wd-15p">Department Head</th>
                                <th class="wd-10p">Status</th>
                                <th class="wd-10p">Created</th>
                                <th class="wd-10p">Updated</th>
                                <th class="wd-10p">Assign Users</th>
                                <th class="wd-10p">Add Teams</th>
                                {{-- <th class="wd-10p">Assign Services</th> --}}
                                <th class="wd-10p">Operations</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $key => $department)
                                @php
                                    $counter = App\assign_department_user::where('department_id', $department->id_departments)
                                        ->get()
                                        ->count();
                                    $get_department_head = App\assign_department_user::where('department_id', $department->id_departments)
                                        ->where('is_head', 1)
                                        ->select('user_name')
                                        ->first();
                                    // dd($get_department_head);
                                @endphp
                                <tr>
                                <tr class="cell-1" data-toggle="collapse"
                                    data-target="#demo{{ $department->id_departments }}">
                                    <td class="table-elipse" data-toggle="collapse" data-target="#demo"><i
                                            class="fa fa-ellipsis-h text-black-50"></i></td>
                                    <td>{{ $department->department_name }}</td>
                                    {{-- <th>{{ get_services_name($department->services) }}</th> --}}
                                    {{-- <th>{{ get_sub_services_name($department->services, $department->sub_services) }}</th> --}}
                                    <td>{{ $counter }}</td>
                                    <td>{{ $get_department_head?->user_name }}</td>
                                    <td>
                                        @if ($department->status == 1)
                                            <button class="btn btn-rounded btn-success" style="color:#fff;">
                                                Active <span class="badge badge-primary"></span>
                                            </button>
                                        @else
                                            <button class="btn btn-rounded btn-danger" style="color:#fff;">
                                                Deactive <span class="badge badge-primary"></span>
                                            </button>
                                        @endif
                                    </td>
                                    <td><?= date('d-m-Y', strtotime($department->created_at)) ?></td>
                                    <td><?= date('d-m-Y', strtotime($department->updated_at)) ?></td>
                                    <td>
                                        <button class="btn btn-rounded  btn-primary"
                                            onclick="assignUser({{ $department->id_departments }})">Assign User</button>

                                    </td>
                                    <td>
                                        <button class="btn btn-rounded  btn-primary"
                                            onclick="assignUserservices({{ $department->id_departments }})">Add
                                            Teams</button>

                                    </td>
                                    {{-- <td>
                                        <button class="btn btn-rounded  btn-primary"
                                            onclick="assignServices({{ $department->id_departments }})">Assign
                                            Services</button>

                                    </td> --}}
                                    <td>
                                        <a class="btn btn-rounded btn-primary"
                                            href="{{ url('departments/edit/' . Crypt::encrypt($department->id_departments)) }}">
                                            Edit
                                        </a>
                                        <!--                                    <a class="btn btn-rounded btn-danger" href="{{ url('departments/destroy/' . Crypt::encrypt($department->id_service_departments)) }}">
                                                                                                                                                                                                                                                        Delete
                                                                                                                                                                                                                                                        </a>-->
                                    </td>
                                </tr>

                                @php
                                    $decode = App\department_team::where('department_id', $department->id_departments)->get();
                                    // dd($decode);
                                @endphp
                                <tr id="demo{{ $department->id_departments }}" class="collapse cell-1 row-child">
                                    <td colspan="1"><i class="fa fa-angle-up"></i></td>
                                    <td colspan="1" style="font-weight:bold;">Team Name&nbsp;</td>
                                    {{-- <td colspan="1" style="font-weight:bold;">Services&nbsp;</td>
                                    <td colspan="1" style="font-weight:bold;">Sub Services&nbsp;</td> --}}
                                    <td colspan="2" style="font-weight:bold;">Users&nbsp;</td>


                                </tr>
                                @isset($decode)
                                @foreach ($decode as $key => $value)
                                    <tr id="demo{{ $department->id_departments }}" class="collapse cell-1 row-child">
                                        <td colspan="1"></td>
                                        <th><label>{{ $value->team_name }}</label>
                                        </th>
                                        {{-- <th></th>
                                        <th></th> --}}
                                        <th colspan="2">
                                            @isset($value->user_id)
                                                @foreach (json_decode($value->user_id) as $user_value_dec)
                                                    <span
                                                        class="@if ($user_value_dec == $value->head_id) badge badge-success @else badge badge-warning @endif">
                                                        {{ get_user_name($user_value_dec) }}</span>
                                                    <a onclick="remove_user('{{ \Crypt::encrypt($user_value_dec) }}','{{ \Crypt::encrypt($value->id_department_teams) }}')"> <label
                                                            class="badge badge-danger">X</label></button>
                                                        <br>
                                                @endforeach
                                            @endisset
                                        </th>

                                    </tr>
                                @endforeach
                            @endisset

                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="wd-10p">View</th>
                                <th class="wd-20p">Department Name</th>
                                {{-- <td style="font-weight:bold;">Services</td> --}}
                                {{-- <td style="font-weight:bold;">Sub Services</td> --}}
                                <th class="wd-15p">User Count</th>
                                <th class="wd-15p">Department Head</th>
                                <th class="wd-10p">Status</th>
                                <th class="wd-10p">Created</th>
                                <th class="wd-10p">Updated</th>
                                <th class="wd-10p">Assign Users</th>
                                <th class="wd-10p">Assign Users Services</th>
                                {{-- <th class="wd-10p">Assign Services</th> --}}
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
                    <label for="">Assign Team</label>
                    <form method="POST" action="{{ url('assign_user_teams') }}">
                        @csrf

                        <select style="width: 100%;" class="form-control select1" name="team_id" required>
                            <option value="">Select</option>
                            @forelse ($department_teams as $item)
                                <option value="{{ $item->id_department_teams }}">{{ $item->team_name }}</option>
                            @empty
                            @endforelse
                        </select>
                        <label for="">Assign User</label>
                        <select style="width: 100%;" class="form-control" name="user_id" required>
                            <option value="">Select</option>
                            @forelse ($users as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        <label for="">Department Head</label>
                        <input type="checkbox" name="is_head" class="mt-2">
                        <input type="hidden" value="" id="d_id" name="d_id">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-indigo">Assign</button>
                    </form>
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div><!-- modal-dialog -->
    </div>


    <div id="modaldemo2" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Assign Services And Sub Services</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <label for="">Assign Services And Sub Services</label> --}}
                    <form method="POST" action="{{ url('assign_services_department') }}">

                        <div class="row">
                            <div class="col-lg-5 mg-t-20 mg-lg-t-0">
                                <div class="form-group">

                                    <label class="form-control-label">Services: <span style="color:red;">*</span></label>
                                    <select name="services[]" id="services" class="form-control" required="required">
                                        <option>Select Services </option>
                                        @forelse ($services as $service)
                                            <option value="{{ $service->id_other_services }}">
                                                {{ $service->service_name }}
                                            </option>
                                        @empty
                                            No Results Found
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            @csrf
                            <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                                <div class="form-group">

                                    <label class="form-control-label">Sub Services:</label>
                                    <select style="width: 100%" name="sub_services[]" id="sub_services"
                                        class="js-example-basic-multiple" multiple="multiple">
                                        <option>Select Sub Service</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1 mg-t-20 mg-md-t-0">
                                {{-- <label class="form-control-label">Add More</label> --}}
                                <button onclick="add_more()" class="btn btn-az-primary mt-4" type="button">Add
                                    More</button>
                            </div>
                            <input type="hidden" id="d_id2" name="d_id">
                        </div>
                        <div class="row" id="append_services">

                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-indigo">Assign</button>
                    </form>
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modaldemo3" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Add Teams</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <label for="">Assign Services And Sub Services</label> --}}
                    <form method="POST" action="{{ url('add_department_teams') }}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Select Team</label>
                                    <select style="width: 100%;" class="form-control js-example-tags"
                                        name="department_teams" id="department_teams" required>
                                        <option value="">Select</option>
                                        @forelse ($department_teams as $item)
                                            <option value="{{ $item->id_department_teams }}">{{ $item->team_name }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5 mg-t-20 mg-lg-t-0">
                                <div class="form-group">

                                    <label class="form-control-label">Services: <span style="color:red;">*</span></label>
                                    <select name="services[]" id="services_users" class="form-control"
                                        required="required">
                                        <option>Select Services </option>
                                        @forelse ($services as $service)
                                            <option value="{{ $service->id_other_services }}">
                                                {{ $service->service_name }}
                                            </option>
                                        @empty
                                            No Results Found
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            @csrf
                            <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                                <div class="form-group">

                                    <label class="form-control-label">Sub Services:</label>
                                    <select style="width: 100%" name="sub_services[]" id="sub_services_users"
                                        class="js-example-basic-multiple_new" multiple="multiple">
                                        <option>Select Sub Service</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1 mg-t-20 mg-md-t-0">
                                {{-- <label class="form-control-label">Add More</label> --}}
                                <button onclick="add_more_users()" class="btn btn-az-primary mt-4" type="button">Add
                                    More</button>
                            </div>
                            <input type="hidden" id="d_id3" name="d_id">
                        </div>
                        <div class="row" id="append_services_users">

                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-indigo">Assign</button>
                    </form>
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- </div><!-- az-content-body --> --}}
@endsection
@push('scripts')
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
                    className: 'control'
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
    <script>
        // alert('sdsds')
        var counti = 0;
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                dropdownParent: $("#modaldemo2")
            });
            $('.select2').select2({
                dropdownParent: $("#modaldemo2")
            });
            $('.select1').select2({
                dropdownParent: $("#modaldemo1")
            });
            $(".js-example-tags").select2({
                tags: true,
                dropdownParent: $("#modaldemo3")
            });

        });

        function remove_user(id, d_id) {
            Swal.fire({
                title: "Do you want to Delete This User?",
                showDenyButton: true,

                confirmButtonText: "Yes",
                denyButtonText: `No`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {

                    location.href = "{{ url('remove_department_user/') }}/" + id + "/" + d_id
                } else if (result.isDenied) {

                }
            });
        }

        function add_more() {
            // alert('sdsd')
            counti = counti + 1;
            $.ajax({
                url: "{{ url('add_more_services') }}/" + counti,
                type: 'GET',
                success: function(data) {
                    console.log(data.script)
                    $('#append_services').append(data.data);
                    // $('#append_js').append(data.script);
                    $('#count_id').val(counti);
                    $('.js-example-basic-multiple').select2()
                    $('#services' + counti).on('change', function() {
                        var val = $(this).val();
                        $.ajax({
                            url: "{{ url('get_sub_services') }}/" + val,
                            type: "GET",
                            success: function(data) {
                                console.log(data)
                                $('#sub_services' + counti).html(data);
                            }
                        });
                    });
                }
            });

        }

        var counti_users = 0;

        function add_more_users() {
            // alert('sdsd')
            counti_users = counti_users + 1;
            $.ajax({
                url: "{{ url('add_more_services') }}/" + counti_users,
                type: 'GET',
                success: function(data) {
                    console.log(data.script)
                    $('#append_services_users').append(data.data);
                    // $('#append_js').append(data.script);
                    $('#count_id').val(counti_users);
                    $('.js-example-basic-multiple').select2()
                    $('#services_users' + counti_users).on('change', function() {
                        var val = $(this).val();
                        $.ajax({
                            url: "{{ url('get_sub_services') }}/" + val,
                            type: "GET",
                            success: function(data) {
                                console.log(data)
                                $('#sub_services_users' + counti_users).html(data);
                            }
                        });
                    });
                }
            });

        }

        function remove(count_rmv) {
            // alert(counti)
            counti = counti - 1;
            $('.rmv' + count_rmv).remove();
        }
        $(document).ready(function() {
            // $('.select2').select2();
            $(".js-example-basic-multiple_new").select2({
                dropdownParent: $("#modaldemo2")
            });
            $(".js-example-basic-multiple").select2({
                dropdownParent: $("#modaldemo3")
            });
            $('#services').on('change', function() {
                var val = $(this).val();
                $.ajax({
                    url: "{{ url('get_sub_services') }}/" + val,
                    type: "GET",
                    success: function(data) {
                        $('#sub_services').html(data);
                        $(".js-example-basic-multiple").select2({
                            dropdownParent: $("#modaldemo2")
                        });
                        $(".js-example-basic-multiple").select2({
                            dropdownParent: $("#modaldemo3")
                        });
                    }
                });
            });
        });
        $(document).ready(function() {
            $('#services_users').on('change', function() {
                var val = $(this).val();
                $.ajax({
                    url: "{{ url('get_sub_services') }}/" + val,
                    type: "GET",
                    success: function(data) {
                        $('#sub_services_users').html(data);
                        $(".js-example-basic-multiple").select2({
                            dropdownParent: $("#modaldemo2")
                        });
                        $(".js-example-basic-multiple").select2({
                            dropdownParent: $("#modaldemo3")
                        });
                    }
                });
            });
        });
        $(document).ready(function() {
            // $('.select2').select2();
            $(".js-example-basic-multiple").select2({
                dropdownParent: $("#modaldemo2")
            });
            $(".js-example-basic-multiple").select2({
                dropdownParent: $("#modaldemo3")
            });
            $('#services_users').on('change', function() {
                var val = $(this).val();
                $.ajax({
                    url: "{{ url('get_sub_services') }}/" + val,
                    type: "GET",
                    success: function(data) {
                        $('#sub_services_users').html(data);
                        $(".js-example-basic-multiple").select2({
                            dropdownParent: $("#modaldemo2")
                        });
                        $(".js-example-basic-multiple").select2({
                            dropdownParent: $("#modaldemo3")
                        });
                    }
                });
            });


        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script>
        function assignUser(user_id) {
            $('#d_id').val(user_id);
            $('#modaldemo1').modal('show');
            $(".js-example-basic-multiple").select2({
                dropdownParent: $("#modaldemo2")
            });
            $(".js-example-basic-multiple").select2({
                dropdownParent: $("#modaldemo3")
            });
        }

        function assignUserservices(dep_id) {
            $('#d_id3').val(dep_id);
            $('#modaldemo3').modal('show');

            $(".js-example-basic-multiple").select2({
                dropdownParent: $("#modaldemo2")
            });
            $(".js-example-basic-multiple").select2({
                dropdownParent: $("#modaldemo3")
            });
            $.ajax({
                type: "GET",
                url: "{{ url('get_department_users') }}/" + dep_id,
                success: function(response) {
                    // user_id_dep
                    $('#user_id_dep').html(response.dep_users);
                }
            });
        }

        function assignServices(d_id) {
            $('#d_id2').val(d_id);
            // alert(d_id)
            $('#modaldemo2').modal('show');
            $(".js-example-basic-multiple").select2({
                dropdownParent: $("#modaldemo2")
            });
            $(".js-example-basic-multiple").select2({
                dropdownParent: $("#modaldemo3")
            });
        }
    </script>
@endpush
