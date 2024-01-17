@extends('layouts.master')
@section('content')
    <div class="card card-body pd-10">
        <div class="az-content-breadcrumb">
            <span>Quotation Approvals</span>
        </div>
        <h2 class="az-content-title" style="display: inline">Quotation Approvals
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
                            <a class="nav-link active" data-bs-toggle="tab" href="#tabCont1">All Quotation Approvals</a>
                            <a class="nav-link " data-bs-toggle="tab" href="#tabCont2">My Quotation Approvals</a>
                            <a class="nav-link " data-bs-toggle="tab" href="#tabCont3">All Quotation Issuance</a>
                            <a class="nav-link " data-bs-toggle="tab" href="#tabCont4">My Quotation Issuance</a>
                        </nav>
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 tab-content">
                        <div id="tabCont1" class="tab-pane active show">
                            <div>
                                <table id="example2" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="wd-10p">S.No</th>
                                            <th class="wd-10p">Quotation No</th>
                                            <th class="wd-20p">Inquiry #</th>
                                            <th class="wd-20p">Status</th>
                                            <th class="wd-20p">Created By</th>
                                            <th class="wd-20p">Created At</th>
                                            <th class="wd-20p">View Quotation</th>
                                            <!--<th class="wd-20p">Operations</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($get_quotations_approval_data as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item['quotation_no'] }}</td>
                                                <td>{{ $item['inquiry_id'] }}</td>
                                                <td>{{ $item['status'] }}</td>
                                                <td>{{ $item['user_name'] }}</td>
                                                <td>{{ $item['created_at'] }}</td>
                                                <td><a href="{{ url('view_quotation/' . Crypt::encrypt($item['quotation_id'])) . '/' . Crypt::encrypt($item['inquiry_id']) }} "
                                                        class="btn btn-success btn-rounded text-white">View Quotation</a></td>
<!--                                                <td class="text-center"><a
                                                        href="{{ url('quotation_approved/' . Crypt::encrypt($item['id_quotation_approvals'])) }}"
                                                        class="btn btn-success"><i class="fa fa-check text-white"></i></a>
                                                    <br>

                                                    <button
                                                        onclick="disapproved('{{ Crypt::encrypt($item['id_quotation_approvals']) }}')"
                                                        class="btn btn-danger mt-2"><i
                                                            class="fa fa-ban text-white"></i></button>
                                                </td>-->
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="wd-10p">S.No</th>
                                            <th class="wd-10p">Quotation No</th>
                                            <th class="wd-20p">Inquiry #</th>
                                            <th class="wd-20p">Status</th>
                                            <th class="wd-20p">Created By</th>
                                            <th class="wd-20p">Created At</th>
                                            <th class="wd-20p">View Quotation</th>
                                            <!--<th class="wd-20p">Operations</th>-->
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div><!-- tab-pane -->
                        <div id="tabCont2" class="tab-pane  show">
                            <div>
                                <table id="example21" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="wd-10p">S.No</th>
                                            <th class="wd-10p">Quotation No</th>
                                            <th class="wd-20p">Inquiry #</th>
                                            <th class="wd-20p">Status</th>
                                            <th class="wd-20p">Created At</th>
                                            <th class="wd-20p">View Quotation</th>
                                            {{-- <th class="wd-20p">Operations</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($get_my_quotations_approval_data as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->get_quotation->quotation_no }}</td>
                                                <td>{{ $item['inquiry_id'] }}</td>
                                                <td>{{ $item['status'] }}</td>
                                                <td>{{ $item['created_at'] }}</td>
                                                <td><a href="{{ url('view_quotation/' . Crypt::encrypt($item['quotation_id'])) . '/' . Crypt::encrypt($item['inquiry_id']) }}"
                                                        class="btn btn-success text-white">View Quotation</a></td>
                                                {{-- <td class="text-center"><a
                                                        href="{{ url('quotation_approved/' . Crypt::encrypt($item['id_quotation_approvals'])) }}"
                                                        class="btn btn-success"><i class="fa fa-check text-white"></i></a>
                                                    <br>

                                                    <button
                                                        onclick="disapproved('{{ Crypt::encrypt($item['id_quotation_approvals']) }}')"
                                                        class="btn btn-danger mt-2"><i
                                                            class="fa fa-ban text-white"></i></button>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="wd-10p">S.No</th>
                                            <th class="wd-10p">Quotation No</th>
                                            <th class="wd-20p">Inquiry #</th>
                                            <th class="wd-20p">Status</th>
                                            <th class="wd-20p">Created At</th>
                                            <th class="wd-20p">View Quotation</th>
                                            {{-- <th class="wd-20p">Operations</th> --}}
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div><!-- tab-pane -->
                        <div id="tabCont3" class="tab-pane  show">
                            <div>
                                <table id="example22" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="wd-10p">S.No</th>
                                            <th class="wd-10p">Quotation No</th>
                                            <th class="wd-20p">Inquiry #</th>
                                            <th class="wd-20p">Services</th>
                                            <th class="wd-20p">Status</th>
                                            <th class="wd-20p">Created By</th>
                                            <th class="wd-20p">Created At</th>
                                            <th class="wd-20p">Take</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($get_all_quotations_issuance_data as $key => $main_item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $main_item->get_quotation->quotation_no }}</td>
                                                <td>{{ $main_item['inquiry_id'] }}</td>
                                                <td>
                                                    @php
                                                        $get_count_of_service = count($access_services);
                                                    @endphp
                                                    {{-- @foreach ($access_services[$main_item->quotation_id] as $allow_services)
                                                        {{ dd($access_services[$main_item->quotation_id]['service_name']) }} --}}
                                                        {{-- {{dd(count($access_services[$main_item->quotation_id]['service_name']))}} --}}
                                                    @for ($i = 0; $i < count($access_services[$main_item->quotation_id]['service_name']); $i++)
                                                        <span
                                                        {{-- {{dd($access_services[$main_item->quotation_id])}} --}}
                                                            class="badge @if ($access_services[$main_item->quotation_id]['service_name'][$i]) badge-success @else badge-warning @endif ">{{ $access_services[$main_item->quotation_id]['service_name'][$i] }}
                                                            |
                                                            {{ $access_services[$main_item->quotation_id]['user_name'][$i] ? $access_services[$main_item->quotation_id]['user_name'][$i] : 'NA' }}  </span>
                                                    @endfor
                                                    {{-- @endforeach --}}
                                                    {{-- {{dd($unaccess_services)}} --}}


                                                </td>
                                                <td>{{ $main_item['status'] }}</td>
                                                <td>{{ $main_item->get_user?->name }}</td>
                                                <td>{{ $main_item['created_at'] }}</td>
                                                <td><a href="{{ url('take_quotation_issuance/' . Crypt::encrypt($main_item['quotation_id'])) . '/' . Crypt::encrypt($main_item['id_quotation_issuance']) }}"
                                                        class="btn btn-success text-white">ASSIGN TO MYSELF</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="wd-10p">S.No</th>
                                            <th class="wd-10p">Quotation No</th>
                                            <th class="wd-20p">Inquiry #</th>
                                            <th class="wd-20p">Services</th>
                                            <th class="wd-20p">Status</th>
                                            <th class="wd-20p">Created By</th>
                                            <th class="wd-20p">Created At</th>
                                            <th class="wd-20p">Take</th>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div><!-- tab-pane -->
                        <div id="tabCont4" class="tab-pane  show">
                            <div>
                                <table id="example22" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="wd-10p">S.No</th>
                                            <th class="wd-10p">Quotation No</th>
                                            <th class="wd-20p">Inquiry #</th>

                                            <th class="wd-20p">Status</th>
                                            <th class="wd-20p">Created By</th>
                                            <th class="wd-20p">Created At</th>
                                            <th class="wd-20p" colspan="2">Operations</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($get_my_quotations_issuance_data as $key => $main_item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $main_item->get_quotation->quotation_no }}</td>
                                                <td>{{ $main_item['inquiry_id'] }}</td>
                                                {{-- <td>
                                                    @foreach ($access_services as $allow_services)
                                                        @foreach ($allow_services as $item)
                                                            <span
                                                                class="badge badge-success">{{ isset($item) ? $item : '' }}</span>
                                                        @endforeach
                                                    @endforeach

                                                    @foreach ($unaccess_services as $allow_services)
                                                        @foreach ($allow_services as $item)
                                                            <span
                                                                class="badge badge-danger">{{ isset($item) ? $item : '' }}</span>
                                                        @endforeach
                                                    @endforeach

                                                </td> --}}
                                                <td>{{ $main_item['status'] }}</td>
                                                <td>{{ $main_item->get_user?->name }}</td>
                                                <td>{{ $main_item['created_at'] }}</td>
                                                <td><a href="{{ url('issuance_verification/' . Crypt::encrypt($main_item['inquiry_id']) . '/' . Crypt::encrypt($main_item['quotation_id'])) }}"
                                                        class="btn btn-success text-white">View</a>
                                                </td>
                                                {{-- <td><a style="font-size:12px;"
                                                        href="{{ url('view_voucher/' . Crypt::encrypt($main_item['inquiry_id']) . '/' . Crypt::encrypt($main_item['quotation_id'])) }}"
                                                        class="btn btn-warning text-white">Service Voucher</a></td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="wd-10p">S.No</th>
                                            <th class="wd-10p">Quotation No</th>
                                            <th class="wd-20p">Inquiry #</th>
                                            <th class="wd-20p">Status</th>
                                            <th class="wd-20p">Created By</th>
                                            <th class="wd-20p">Created At</th>
                                            <th class="wd-20p" colspan="2">Operations</th>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div><!-- tab-pane -->

                    </div><!-- card-body -->
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
        function disapproved(q_approval_id) {

            Swal.fire({
                title: '<strong class="">Enter Cancel Reason</strong>',
                icon: 'info',
                html: '<textarea id="cancel_reason" class="form-control" style="height:80px;" ></textarea>',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: '<strong>Submit</strong>',
                cancelButtonText: '<strong>Cancel</strong>',
            }).then((result) => {


                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {

                    var get_cancel_reason = $('#cancel_reason').val();

                    if (get_cancel_reason.length > 0) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('quotation_disapproved/') }}/" + q_approval_id,
                            data: {
                                cancel_reason: get_cancel_reason
                            },
                            success: function(response) {
                                Swal.fire('Quotation DisApproved Successfully!', '', 'success');
                            }
                        });
                    } else {
                        Swal.fire('Please Enter Valid Cancel Reason!', '', 'error');
                    }
                } else if (result.isDenied) {}
            })
        }
        $(document).ready(function() {
            $('#example2').DataTable();
            $('#example21').DataTable();
            $('#example22').DataTable();
            $('#example23').DataTable();
        });
    </script>
@endpush
