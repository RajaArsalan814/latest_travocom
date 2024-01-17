@extends('layouts.master')
@section('content')
    <div class="card card-body pd-10">
        <div class="az-content-breadcrumb">
            <span>CHEQUE IN HAND</span>
        </div>
        <h2 class="az-content-title" style="display: inline">CHEQUE IN HAND LIST
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
                                                    <th class="wd-05p">S.No</th>
                                                    <th class="wd-20p">Customer Bank</th>
                                                    <th class="wd-10p">Cheque Date</th>
                                                    <th class="wd-10p">RV Number</th>
                                                    <th class="wd-20p">Cheque Number</th>
                                                    <th class="wd-20p">Cheque Amount</th>
                                                    <th class="wd-20p">Status</th>
                                                    <th class="wd-10p">Created At</th>
                                                    <th class="wd-10p">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($cheque_list as $key => $pay_ac)
                                                    
                                                    
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $pay_ac->bank_name }}</td>
                                                            <td>{{ date('d-m-Y', strtotime($pay_ac->cheque_date)) }}</td>
                                                            <td>{{ $pay_ac->recieving_number }}</td>
                                                            <td>{{ $pay_ac->cheque_number }}</td>
                                                            <td>{{ $pay_ac->paid_amount }}</td>
                                                            <td>
                                                                @if ($pay_ac->status == 0)
                                                                    <span class="badge badge-warning">Pending</span>
                                                                @elseif($pay_ac->status == 1)
                                                                    <span class="badge badge-info">PAYMENT NOT VERIFIED</span>
                                                                @elseif($pay_ac->status == 2)
                                                                    <span class="badge badge-success">PAYMENT VERIFIED</span>
                                                                @endif
                                                            </td>

                                                            {{-- <td>{{ get_total_quotation_received_amount($pay->quotation_id) }}</td> --}}
                                                            <td>{{ $pay_ac->created_at }}</td>
                                                            <td><button class="btn btn-success btn-rounded" style="color:#fff;"
                                                                    onclick="get_details({{ $pay_ac->id_account_payments }},'{{ $pay_ac->payment_type }}')">View
                                                                    Details</button>
                                                            </td>

                                                        </tr>
                                                  
                                                @endforeach

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th class="wd-05p">S.No</th>
                                                    <th class="wd-20p">Customer Bank</th>
                                                    <th class="wd-10p">Cheque Date</th>
                                                    <th class="wd-10p">RV Number</th>
                                                    <th class="wd-20p">Cheque Number</th>
                                                    <th class="wd-20p">Cheque Amount</th>
                                                    <th class="wd-20p">Status</th>
                                                    <th class="wd-10p">Created At</th>
                                                    <th class="wd-10p">Action</th>
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
//                    alert(response.recieving_number);
                    $('#ac1_payment_type').html(response.payment_type)
//                    alert(response.payment_type);
                    $('#ac1_bank_name').html(response.bank_name)
                    $('#ac1_account_number').html(response.account_number)
                    $('#ac1_cheque_no').html(response.cheque_number)
                    $('#ac1_amount').html(response.amount)
                    $('#ac1_payment_number').html(response.payment_number)
                    $('#ac1_payment_id').val(response.payment_id)
                    $('#accounts_rv_number').val(response.recieving_number)
                    
                    if(response.payment_verification == 1){
                       $( "#accounts_payment_verification" ).prop( "checked", true ); 
                       $( "#accounts_payment_verification" ).attr( "disabled", "disabled"); 
                    }else{
                        $( "#accounts_payment_verification" ).prop( "checked", false ); 
                       $( "#accounts_payment_verification" ).removeAttr( "disabled");
                    }
                    
                    if(response.payment_status == 0){
                        var payment_status_detail = 'Pending';
                    }
                    if(response.payment_verification == 0){
                        var payment_verification_detail = 'Un-verified';
                    }
                    $('#ac1_payment_status').html(payment_status_detail)
                    $('#ac1_customer_bank').html(response.customer_bank)
                    $('#ac1_our_bank').html(response.bank_name)
                    $('#ac1_cheque_date').html(response.cheque_date)
                    $('#ac1_deposit_date').html(response.deposit_date)
                    $('#ac1_clearing_date').html(response.clearing_date)
                    $('#ac1_payment_remarks').html(response.payment_remarks)
                    $('#ac1_payment_verification').html(payment_verification_detail)
//                    $('#ac2_image_url').html(response.attachment)
                    $("#ac2_image_url").attr("src", response.attachment)
                    // alert(response.attachment)
                    $("#attachment").attr("src", "{{ url('/') }}/" + response.attachment);

                    if (response.recieving_number != null) {
                        $('#ac1_recieving_number').val(response.recieving_number)
                        $('#ac1_recieving_number').prop('disabled', true);
                        $('#view_pay_details_btn').prop('disabled', true);
                    } else {
                        $('#ac1_recieving_number').prop('disabled', true);
                        $('#view_pay_details_btn').prop('disabled', true);
                    }
                    if (p_type == "Cash") {
//                        $('#d_cheque_number').css('display', 'none');
                        $('#ac2_our_bank').css('display', 'none');
//                        $('#d_bank_name').css('display', 'none');
//                        $('#d_account_number_ac').css('display', 'none');
                        $('#ac2_attachment').css('display', 'none');
                        $('#ac2_cheque_date').css('display', 'none');
                        $('#ac2_deposit_date').css('display', 'none');
                        $('#ac2_customer_bank').css('display', 'none');
                        $('#ac2_clearing_date').css('display', 'none');
                        
                    } else if(p_type == "Cheque"){
//                        $('#d_cheque_number').css('display', 'none');
                        $('#ac2_our_bank').css('display', 'none');
                        $('#ac2_customer_bank').css('display', 'block');
                        $('#ac2_my_cheque_date').css('display', 'block');
//                        $('#d_account_number_ac').css('display', 'none');
                        $('#ac2_attachment').css('display', 'block');
                        $('#ac2_deposit_date').css('display', 'none');
                        $('#ac2_cheque_date').css('display', 'block');
                            $('#ac2_my_bank').css('display', 'none');
//                            $('#d_deposit_date').css('display', 'none');
                        $('#ac2_clearing_date').css('display', 'none');
                        
                    } else if(p_type == "Online_transfer"){
//                        $('#d_cheque_number').css('display', 'none');
                        $('#ac2_customer_bank').css('display', 'block');
                        $('#ac2_our_bank').css('display', 'block');
                        $('#ac2_my_bank').css('display', 'block');
                        $('#ac2_cheque_date').css('display', 'none');
                        $('#ac2_deposit_date').css('display', 'block');
//                        $('#d_account_number_ac').css('display', 'none');
                        $('#ac2_attachment').css('display', 'block');
                        $('#ac2_clearing_date').css('display', 'none');
                        
                    }else if(p_type == "Clearing"){
//                        $('#d_cheque_number').css('display', 'none');
                        $('#ac2_customer_bank').css('display', 'block');
                        $('#ac2_our_bank').css('display', 'block');
                        $('#ac2_cheque_date').css('display', 'none');
                        $('#ac2_deposit_date').css('display', 'block');
                        $('#ac2_clearing_date').css('display', 'block');
//                        $('#d_account_number_ac').css('display', 'none');
                        $('#ac2_attachment').css('display', 'block');
                        $('#ac2_deposit_date').css('display', 'block');
                        $('#ac2_clearing_date').css('display', 'block');
                    }else {
//                        $('#d_cheque_number').css('display', 'none');
//                        $('#d_bank_name').css('display', 'none');
//                        $('#d_account_number_ac').css('display', 'none');
//                        $('#d_cheque_no').css('display', 'none');
                        $('#ac2_our_bank').css('display', 'block');
//                            $('#d_bank').css('display', 'none');
                            $('#ac2_image_file').css('display', 'none');
                            $('#ac2_image_file_label').css('display', 'none');
                            $('#ac2_cheque_date').css('display', 'none');
                            $('#ac2_customer_bank').css('display', 'none');
                            $('#ac2_deposit_date').css('display', 'none');
                            $('#ac2_clearing_date').css('display', 'block');
                    }
                    $('#pay_id').val(pay_id)

                    $('#modaldemo9').modal('show');
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
                    orderable: false
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
