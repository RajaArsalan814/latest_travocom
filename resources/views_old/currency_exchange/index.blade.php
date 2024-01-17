@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>RATE OF EXCHANGE</span>
    </div>
    <h2 class="az-content-title" style="display: inline"> Currency List <span>
            <a href="{{ url('currency_exchange/create') }}" class="btn btn-az-primary" style="float: right">Add Currency</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            {{-- <div class="card card-body pd-40"> --}}

            <div>
                <table id="example2" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Currency Name</th>
                            <th class="wd-20p">Currency Rate</th>
                            <th class="wd-20p">Currency Symbols</th>
                            <th class="wd-10p">Created</th>
                            <th class="wd-10p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($currency as $key => $curr)
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td>{{ $curr['currency_name'] }}</td>
                                <td>{{ $curr['currency_rate'] }}</td>
                                <td>{{ $curr['currency_symbols'] }}</td>
                                <td><?= date('d-m-Y', strtotime($curr['created_at']))?></td>

                                <td><a class="btn btn-rounded btn-primary" href="{{ url('currency_exchange/edit/'.\Crypt::encrypt($curr['id_currency_exchange_rates'])) }}">
                                Edit
                                </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                     <tfoot>
                        <tr>
                            <th class="wd-10p">S.No</th>
                            <th class="wd-20p">Currency Name</th>
                            <th class="wd-20p">Currency Rate</th>
                            <th class="wd-20p">Currency Symbols</th>
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
