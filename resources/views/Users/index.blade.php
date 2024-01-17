@extends('layouts.master')
@section('content')
<div class="card card-body pd-10">
    <div class="az-content-breadcrumb">
        <span>Users</span>
    </div>
    <h2 class="az-content-title" style="display: inline"> Users List <span>
            <a href="{{ url('users/create') }}" class="btn btn-az-primary" style="float: right">Add User</a></span></h2>
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
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">User Name</th>
                            <th class="wd-15p">User Role</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created</th>
                            <th class="wd-10p">Updated</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $my_user)
                        
                            <tr>

                                <td>{{ $my_user['id'] }}</td>
                                <td>{{ $my_user['name'] }}</td>
                                <td>{{ $my_user['role_name'] }}</td>
                                <td>
                                    @if ($my_user['status'] == 1)
                                    <button class="btn btn-rounded btn-success" style="color:#fff;">
                                            Active <span class="badge badge-primary"></span>
                                        </button>
                                    @else
                                    <button class="btn btn-rounded btn-danger" style="color:#fff;">
                                            In-Active <span class="badge badge-primary"></span>
                                        </button>
                                    @endif
                                </td>
                                <td><?= date('d-m-Y', strtotime($my_user['created_at']))?></td>
                                <td><?= date('d-m-Y', strtotime($my_user['updated_at']))?></td>
                                <td><a class="btn btn-rounded btn-primary" href="{{ url('users/edit/' . Crypt::encrypt($my_user['id'])) }}">
                                Edit
                                </a> 
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                     <tfoot>
                         <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">User Name</th>
                            <th class="wd-15p">User Role</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created</th>
                            <th class="wd-10p">Updated</th>
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






    {{-- </div><!-- az-content-body --> --}}
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            $('#example2 tfoot th').each(function () {
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
            initComplete: function () {
            // Apply the search
            this.api()
                .columns()
                .every(function () {
                    var that = this;

                    $('input', this.footer()).on('keyup change clear', function () {
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
