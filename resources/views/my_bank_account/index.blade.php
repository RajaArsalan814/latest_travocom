@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>My Bank Account</span>
    </div>
    <h2 class="az-content-title" style="display: inline"> My Bank Account List <span>
            <a href="{{ url('my_bank_accounts/create') }}" class="btn btn-az-primary" style="float: right">Add My Bank Account</a></span></h2>
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
                            <th class="wd-20p">Bank Name</th>
                            <th class="wd-10p">Account Number</th>
                            <th class="wd-10p">Location</th>
                            <th class="wd-10p">Created</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($my_bank as $key => $bank)
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td>{{ $bank['bank_name'] }}</td>
                                <td>{{ $bank['account_number'] }}</td>
                                <td>{{ $bank['branch_address'] }}</td>
                                <td><?= date('d-m-Y', strtotime($bank['created_at']))?></td>
                                <td><a class="btn btn-rounded btn-primary" href="{{ url('my_bank_accounts/edit/'.\Crypt::encrypt($bank['id_bank_accounts'])) }}">
                                Edit
                                </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                     <tfoot>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Bank Name</th>
                            <th class="wd-10p">Account Number</th>
                            <th class="wd-10p">Location</th>
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
