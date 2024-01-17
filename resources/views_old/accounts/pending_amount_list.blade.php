@extends('layouts.master')
@section('content')
    <div class="card card-body pd-10">
        <div class="az-content-breadcrumb">
            <span>Pending Payment</span>
        </div>
        <h2 class="az-content-title" style="display: inline">Pending Payment List
        </h2>
    </div>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <div>
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="wd-10p">S.No</th>
                                <th class="wd-10p">Inquiry #</th>
                                <th class="wd-20p">Quotation #</th>

                                <th class="wd-20p">Total Quotation Amount</th>
                                <th class="wd-20p">Total Quotation Received Amount</th>
                                <th class="wd-10p">Created At</th>
                                <th class="wd-10p none">Details</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($payments as $key => $pay)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $pay->get_quotation->inquiry_id }}</td>
                                    <td>{{ $pay->get_quotation->quotation_no }}</td>
                                    <td>{{ $pay->total_quotation_amount }}</td>
                                    <td>{{ get_payment_details($pay->payment_id) }}</td>
                                    {{-- <td>{{ get_total_quotation_received_amount($pay->quotation_id) }}</td> --}}
                                    <td>{{ $pay->created_at }}</td>
                                    <td>
                                        <table id="example2" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="wd-10p">S.No</th>
                                                    <th class="wd-10p">Pay #</th>
                                                    <th class="wd-10p">RV Number</th>
                                                    <th class="wd-20p">Service</th>
                                                    <th class="wd-20p">Paid Amount</th>
                                                    <th class="wd-20p">Remaining Amount</th>
                                                    <th class="wd-20p">Status</th>
                                                    <th class="wd-10p">Created At</th>
                                                    <th class="wd-10p">Action</th>


                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($pending_payment_list as $key => $pay_ac)
                                                    @if ($pay_ac->quotation_id == $pay->quotation_id)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $pay_ac->pay_no }}</td>
                                                            <td>{{ $pay_ac->recieving_number }}</td>
                                                            <td>{{ get_services_name_array($pay_ac->services_type) }}</td>
                                                            <td>{{ $pay_ac->paid_amount }}</td>
                                                            <td>{{ $pay_ac->total_quotation_remaining_amount }}</td>
                                                            <td>
                                                                @if ($pay_ac->status == 0)
                                                                    <span class="badge badge-warning">Pending</span>
                                                                @elseif($pay_ac->status == 1)
                                                                    <span class="badge badge-success">Completed</span>
                                                                @endif
                                                            </td>
                                                            {{-- <td>{{ get_total_quotation_received_amount($pay->quotation_id) }}</td> --}}
                                                            <td>{{ $pay_ac->created_at }}</td>
                                                            <td><button class="btn btn-primary"
                                                                    onclick="get_details({{ $pay_ac->id_account_payments }},'{{ $pay_ac->payment_type }}')">View
                                                                    Details</button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th class="wd-10p">S.No</th>
                                                    <th class="wd-10p">Pay #</th>
                                                    <th class="wd-10p">RV Number</th>
                                                    <th class="wd-20p">Service</th>
                                                    <th class="wd-20p">Paid Amount</th>
                                                    <th class="wd-20p">Remaining Amount</th>
                                                    <th class="wd-20p">Status</th>
                                                    <th class="wd-10p">Created At</th>
                                                    <th class="wd-10p">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="wd-10p">S.No</th>
                                <th class="wd-10p">Inquiry #</th>
                                <th class="wd-20p">Quotation #</th>
                                <th class="wd-20p">Total Quotation Amount</th>
                                <th class="wd-20p">Total Quotation Received Amount</th>
                                <th class="wd-10p">Created At</th>
                                <th class="wd-10p none">Details</th>
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

    {{-- All Quotes Start Modal  --}}
    @include('quotations.modals.modals')
    {{-- All Quotes End Modal  --}}
@endsection
@push('scripts')
    <script>
        function get_details(pay_id, p_type) {
            $.ajax({
                type: "get",
                url: "{{ url('/view_invoice_payment_details') }}/" + pay_id,
                success: function(response) {
                    $('#ac_payment_type').val(response.payment_type)
                    $('#ac_bank_name').val(response.bank_name)
                    $('#ac_account_number').val(response.account_number)
                    $('#ac_cheque_no').val(response.cheque_number)
                    $('#ac_amount').val(response.amount)
                    // alert(response.attachment)
                    $("#attachment").attr("src", "{{ url('/') }}/" + response.attachment);

                    if (response.recieving_number != null) {
                        $('#ac_recieving_number').val(response.recieving_number)
                        $('#ac_recieving_number').prop('disabled', true);
                        $('#view_pay_details_btn').prop('disabled', true);
                    }
                    if (p_type == "Cash") {
                        $('#d_cheque_number').css('display', 'none');
                        $('#d_bank_name').css('display', 'none');
                        $('#d_account_number_ac').css('display', 'none');
                    } else {
                        $('#d_cheque_number').css('display', 'block');
                        $('#d_bank_name').css('display', 'block');
                        $('#d_account_number_ac').css('display', 'block');
                    }

                    if (p_type == 'Online') {
                        $('#d_cheque_no').css('display', 'none');
                    }
                    $('#pay_id').val(pay_id)

                    $('#modaldemo8').modal('show');
                }

            });
        }
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
                    className: 'control',
                    orderable: false,
                    targets: 0
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
@endpush
