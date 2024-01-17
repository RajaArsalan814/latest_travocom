@extends('layouts.master')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<style>
.dot {
    height: 10px;
    width: 10px;
    background-color: #ef8e8e;
    border-radius: 50%;
    display: inline-block;
}

.dot2 {
    height: 10px;
    width: 10px;
    background-color: #b69595;
    border-radius: 50%;
    display: inline-block;
}
</style>

@section('content')
    <div class="az-content-breadcrumb">
        <span>Roles Permission Management</span>
    </div>
    <h2 class="az-content-title" style="display: inline"> Roles List </h2>

    <div class="row">
        <div class="col-md-12">
            @if(Session('alert'))
            <div class="alert alert-card alert-<?php echo Session('alert-class'); ?>" role="alert">
                <?php echo Session('alert'); ?>
                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            @endif
        </div>
    </div>
    <div class="row">
                        <div class="col-md-4">
                            <label for="role">Role</label>
                            <select onchange="location.href='<?php echo url('roles/permission'); ?>/'+this.value;" class="form-control">
                                <option value="0">--Select--</option>
                                @if($roles)
                                @foreach($roles as $row)
                                <option {{ $role_id == $row->id_roles ? "selected" : "" }} value="{{ $row->id_roles }}">{{ $row->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-3">List</h4>

                    <form action="{{ url('roles/permission', [$role_id]) }}" method="post">
                        @csrf
                        <div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Pages</th>
                                        <th>Permission</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $parent = DB::table('main_menu')->where('parent_id', 0)->get()->toArray();
                                    $count1 = 1;
                                    ?>
                                    @if($parent)
                                    @foreach($parent as $row1)
                                    <tr class="odd gradeX">
                                        <td>{{ $count1 }}</td>
                                        <td>
                                            <span class="text-success"><strong>{{ $row1->title }} List</strong></span>
                                        </td>
                                        <td>
                                            <input <?php echo in_array($row1->id_main_menu, $permission) ? 'checked' : '' ?> type="checkbox" name="menu_id[]" value="{{ $row1->id_main_menu }}">
                                        </td>
                                    </tr>
                                    <?php
                                    $child = DB::table('main_menu')->where('parent_id', $row1->id_main_menu)->get()->toArray();
                                    ?>
                                    @if($child)
                                    @foreach($child as $row2)
                                    <tr class="odd gradeX">
                                        <td></td>
                                        <td style="padding-left: 3rem;">
                                            <span class="dot"></span> {{ $row2->title }}
                                        </td>
                                        <td>
                                            <input <?php echo in_array($row2->id_main_menu, $permission) ? 'checked' : '' ?> type="checkbox" name="menu_id[]" value="{{ $row2->id_main_menu }}">
                                        </td>
                                    </tr>

                                    <?php
                                    $subchild = DB::table('main_menu')->where('parent_id', $row2->id_main_menu)->get()->toArray();
                                    ?>
                                    @if($subchild)
                                    @foreach($subchild as $row3)
                                    <tr class="odd gradeX">
                                        <td></td>
                                        <td style="padding-left: 5rem;">
                                            <span class="dot2"></span> {{ $row3->title }}
                                        </td>
                                        <td>
                                            <input <?php echo in_array($row3->id_main_menu, $permission) ? 'checked' : '' ?> type="checkbox" name="menu_id[]" value="{{ $row3->id_main_menu }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                    @endforeach
                                    @endif
                                    <?php $count1++; ?>
                                    @endforeach
                                    @endif
                                    <tr>
                                    <td colspan="3" class="text-right">
                                        <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- end of row-->
    <!-- end of row-->
    <!-- end of main-content -->
@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.script.js')}}"></script>


<script>

function deletefunc(id){
    $.ajax({
        type: "POST",
        url: "{{url("roles/delete")}}",
        data: {id:id},
        beforeSend: function(xhr){
            xhr.setRequestHeader('X-CSRF-Token', "{{csrf_token()}}");
        },
        success: function(data) {
           alert("record deleted");
           location.reload();
        }
    });

}
</script>



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
                    className: 'control',
                    orderable: false,
                    targets: 7
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