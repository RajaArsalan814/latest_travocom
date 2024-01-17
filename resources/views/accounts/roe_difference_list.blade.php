@extends('layouts.master')
@section('content')
    <div class="card card-body pd-10">
        <div class="az-content-breadcrumb">
            <span>ROE DIFFERENCE</span>
        </div>
        <h2 class="az-content-title" style="display: inline">ROE DIFFERENCE LIST
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
                                                    <th class="wd-20p">Quotation#</th>
                                                    <th class="wd-10p">Issuance Service</th>
                                                    <th class="wd-10p">Quotation ROE</th>
                                                    <th class="wd-20p">Issuance ROE</th>
                                                    <th class="wd-20p">Difference</th>
                                                    <th class="wd-20p">Status</th>
                                                    <th class="wd-10p">Created At</th>
                                                    <th class="wd-10p">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                

                                            </tbody>
                                            <tfoot>
                                                 <tr>
                                                    <th class="wd-05p">S.No</th>
                                                    <th class="wd-20p">Quotation#</th>
                                                    <th class="wd-10p">Issuance Service</th>
                                                    <th class="wd-10p">Quotation ROE</th>
                                                    <th class="wd-20p">Issuance ROE</th>
                                                    <th class="wd-20p">Difference</th>
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
