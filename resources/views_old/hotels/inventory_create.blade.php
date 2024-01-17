@extends('layouts.master')
@section('content')
    <style>
        .error {
            color: red;
        }
    </style>
    <div class="az-content-breadcrumb">
        <span>Inventory</span>
        <span>Add Inventory</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Add New Inventory to <span
            style='text-decoration: underline;'><?= $hotel->hotel_name ?></span> <span><a
                href="{{ url('hotels/inventory/' . Crypt::encrypt($hotel->id_hotels)) }}" class="btn btn-az-primary"
                style="float: right">Inventory List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Add Inventory Details</h5>
                <form method="post" id="submit_form" enctype="multipart/form-data"
                    action="{{ url('hotels/inventory/store/' . Crypt::encrypt($hotel->id_hotels)) }}">
                    @csrf
                    @if (count($errors) > 0)
                        <div class="p-1">
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-warning alert-danger fade show" role="alert">{{ $error }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <input type="hidden" name="h_id" value="{{ \Crypt::encrypt($hotel->id_hotels) }}">
                    <div class="row row-sm mg-b-20">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Batch#</label>
                                <input type="text" name="batch_number" readonly class="form-control"
                                    value="<?= $hotel->id_hotels . '-' . date('d-m-y', strtotime(now())) ?>" required />
                            </div>
                        </div>
                        <!-- form-group -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">From Date</label>
                                <input type="text" readonly name="from_date" id="from_date"
                                    class="form-control fc-datepicker" placeholder="MM/DD/YYYY" />
                            </div>
                        </div>
                        <!-- form-group -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">To Date</label>
                                <input type="text" readonly id="to_date" name="to_date"
                                    class="form-control fc-datepicker" placeholder="MM/DD/YYYY" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Vendor</label>
                                <select class="form-control js-example-basic-single" name="vendor">
                                    <option value="">Select</option>
                                    @forelse($vendors as $vendor)
                                        <option value="{{ $vendor->id_service_vendors }}">{{ $vendor->vendor_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="room_type_val" name="room_type_val" value="">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Room Type</label>
                            <select name="room_type" id="room_type" class="form-control js-example-basic-single">
                                <option value="">Select</option>
                                @forelse ($room_types as $item)
                                    <option value="{{ $item->id_room_types }}">{{ $item->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="row row-sm mg-b-20" id="room_type_list">

                    </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="form-group">
                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Upload Attachments</label>
                    <input type="file" id="attachments" class="form-control" name="attachments" />
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-12">
                    {{-- <div class="card card-body pd-40"> --}}

                    <div>
                        <table id="example2" class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="wd-5-f">S.No</th>
                                    <th class="wd-15p">Room </th>
                                    <th class="wd-15p">Qty </th>
                                    <th class="wd-15p">Beds </th>
                                    <th class="wd-15p">Cost Price </th>
                                    <th class="wd-15p">Sale Price </th>
                                    <th class="wd-15p">Total Cost Price</th>
                                    <th class="wd-15p">Total Sale Price</th>
                                    <th class="wd-10p">Created By</th>
                                    <th class="wd-10p">Created</th>
                                    <th class="wd-10f">Operations</th>
                                </tr>
                            </thead>
                            <tbody id="all_data">
                                @foreach ($hotel_inventory as $key => $hotel_inv)
                                    <tr id="rmv{{ $hotel_inv->id_hotel_inventory_temp }}">

                                        <td>{{ $key = $key + 1 }}</td>


                                        <td>
                                            @php
                                                $room = App\room_type::where('id_room_types', $hotel_inv->inventory_type_id)->first();
                                                $total_cost = ($hotel_inv->qty * $hotel_inv->cost_price);
                                                $total_sell = ($hotel_inv->qty * $hotel_inv->selling_price);
                                                @endphp
                                            {{ $room->name }}
                                        </td>
                                        <td>
                                            {{ $hotel_inv->qty }}
                                        </td>
                                        <td>
                                            {{ $hotel_inv->beds }}
                                        </td>
                                        <td>
                                            {{ $hotel_inv->cost_price }}
                                        </td>
                                        <input type="hidden" name="room_type[]"
                                            value="{{ $hotel_inv->inventory_type_id }}">
                                        <input type="hidden" name="qty[]" value="{{ $hotel_inv->qty }}">
                                        <input type="hidden" name="cost_price[]" value="{{ $hotel_inv->cost_price }}">
                                        <input type="hidden" name="selling_price[]"
                                            value="{{ $hotel_inv->selling_price }}">
                                        <input type="hidden" name="beds[]" value="{{ $hotel_inv->beds }}">

                                        <td>
                                            {{ $hotel_inv->selling_price }}
                                        </td>

                                        <td>
                                        <badge class="badge badge-warning" style="font-size:14px;font-weight:bold;">{{ $total_cost }}</badge>
                                        </td>

                                        <td>
                                        <badge class="badge badge-success" style="font-size:14px;font-weight:bold;">{{ $total_sell }}</badge>
                                        </td>

                                        <td>
                                            Super Admin
                                        </td>
                                        <td><?= date('d-m-Y', strtotime($hotel_inv->created_at)) ?></td>

                                        <td><button type="button"
                                                onClick="delete_btn({{ $hotel_inv->id_hotel_inventory_temp }},{{ $hotel->id_hotels }})"
                                                class="btn btn-rounded btn-danger" href="#">
                                                Delete
                                            </button>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="wd-5-f">S.No</th>
                                    <th class="wd-15p">Room </th>
                                    <th class="wd-15p">Qty </th>
                                    <th class="wd-15p">Beds </th>
                                    <th class="wd-15p">Cost Price </th>
                                    <th class="wd-15p">Sale Price </th>
                                    <th class="wd-15p">Total Cost Price</th>
                                    <th class="wd-15p">Total Sale Price</th>
                                    <th class="wd-10p">Created By</th>
                                    <th class="wd-10p">Created</th>
                                    <th class="wd-10f">Operations</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    {{-- </div> --}}
                    <!-- card -->
                </div>
                <!-- col -->
            </div>

            <!-- form-group -->



            <button type="submit" onclick="history.back()" class="btn btn-danger btn-block mt-2">
                Cancel
            </button>
            <button type="submit" class="btn btn-az-primary btn-block mt-2" style="float: right">
                Submit
            </button>
            </form>
        </div>
        <!-- card -->
    </div>
    <!-- col -->
    </div>


@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script>
        $("#room_type").on("change", function(e) {
            let val = $(this).val();


            $.ajax({
                url: "{{ url('get_room_type') }}/" + val,
                type: "GET",
                success: function(result) {
                    $('#room_type_list').empty().html(result.data);
                    $("#room_type_val").val(val);
                    // $("select").attr("disabled", "disabled");

                }
            });
        })

        // save data inqventory

        function delete_btn(inv_id, hotel_id) {
            $.ajax({
                url: "{{ url('hotels/inventory/delete') }}/" + inv_id + "/" + hotel_id,
                type: "GET",
                success: function(result) {
                    $('#all_data').find('#rmv' + inv_id).remove()

                    $.ajax({
                        url: "{{ url('hotels/inventory/create') }}/" + hotel_id,
                        type: "GET",
                        success: function(result) {
                            $('#room_type').empty().html(result.data);

                        }
                    });

                }
            });

        }
        $(document).ready(function() {
            $('.js-example-basic-single').select2();


        });

        function save_btn() {
            // $(document).ready(function($) {

            //     $("#submit_form").validate({

            //         messages: {
            //             name: "Please enter your Name",
            //             password: {
            //                 required: "Please provide a password",
            //                 minlength: "Your password must be at least 6 characters long"
            //             },
            //             city: "Please enter your city",
            //             gender: "This field is required"
            //         },
            //         errorPlacement: function(error, element) {
            //             if (element.is(":radio")) {
            //                 error.appendTo(element.parents('.form-group'));
            //             } else { // This is the default behavior
            //                 error.insertAfter(element);
            //             }
            //         },
            //         submitHandler: function(form) {
            //             form.submit();
            //         }

            //     });
            // });
            // $("#submit_form").submit();
            var qty = $('[name=qty]').val()
            var cPrice = $('[name=cost]').val()
            var sellingPrice = $('[name=s_price]').val()
            var beds = $('[name=beds]').val()
            var h_id = $('[name=h_id]').val()
            let room_type = $("#room_type").val();

            if (qty.length > 0 && cPrice.length > 0 && sellingPrice.length > 0 && beds.length > 0) {

                $.ajax({
                    url: "{{ url('/save_inventory') }}/",
                    type: "GET",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'qty': qty,
                        'h_id': h_id,
                        'room_type': room_type,
                        'c_price': cPrice,
                        's_price': sellingPrice,
                        'beds': beds,
                    },
                    // data: $("#submit_form").serialize(),
                    success: function(result) {
                        $('#room_type_list').empty();
                        $('#room_type option:selected').remove();
                        $("#room_type_val").val("");
                        $("select").removeAttr("disabled", "disabled");

                        $.ajax({
                            url: "{{ url('get_all_data') }}/{{ request()->id }}",
                            type: "GET",
                            success: function(result) {
                                $('#all_data').empty().html(result.data);


                            }
                        });
                    }
                });
            } else {
                alert('Please Fill All Details')
            }

        }
        // $(document).ready(function(e) {

        //     // alert("{{ request()->id }}")
        //     $('#submit_form').on('submit', (function(e) {
        //         e.preventDefault();
        //         $('#submit_form').validate();
        //         var formData = new FormData(this);
        //         $.ajax({
        //             type: 'POST',
        //             url: $(this).attr('action'),
        //             data: formData,
        //             cache: false,
        //             contentType: false,
        //             processData: false,
        //             success: function(result) {

        //                 $('#room_type_list').empty();
        //                 $('#room_type option:selected').remove();
        //                 $("#room_type_val").val("");
        //                 $("select").removeAttr("disabled", "disabled");

        //                 $.ajax({
        //                     url: "{{ url('get_all_data') }}/{{ request()->id }}",
        //                     type: "GET",
        //                     success: function(result) {
        //                         $('#all_data').empty().html(result.data);


        //                     }
        //                 });

        //             },
        //             error: function(data) {
        //                 console.log("error");
        //                 console.log(data);
        //             }
        //         });
        //     }));

        //     $("#ImageBrowse").on("click", function() {
        //         $("#imageUploadForm").submit();
        //     });
        // });
    </script>
@endpush
