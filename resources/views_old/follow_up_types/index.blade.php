@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Follow Up Types</span>
    </div>
    <h2 class="az-content-title" style="display: inline"> Follow Up Types List <span>
            <a href="{{ url('follow_up_types/create') }}" class="btn btn-az-primary" style="float: right">Add Follow Up Types
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
                            <th class="wd-20p">Type Name</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created At</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($follow_up_types as $key => $type)
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td>{{ $type->type_name }}</td>
                                <td>{{ $type->status }}</td>
                                <td><?= date('d-m-Y', strtotime($type['created_at'])) ?></td>

                                <td><a class="btn btn-rounded btn-primary" href="{{url('/follow_up_types/edit/'.\Crypt::encrypt($type->id_follow_up_types))}}">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Type Name</th>
                            <th class="wd-10p">Status</th>
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
