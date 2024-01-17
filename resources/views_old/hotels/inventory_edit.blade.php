@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Inventory</span>
        <span>Edit Inventory</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Edit Inventory - <span
            style='text-decoration: underline;'><?= $hotel->hotel_name ?></span> <span><a
                href="{{ url('hotels/inventory/' . Crypt::encrypt($hotel->id_hotels)) }}" class="btn btn-az-primary"
                style="float: right">Edit Inventory</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Add Inventory Details</h5>
                <form method="post" enctype="multipart/form-data"
                    action="{{ url('hotels/inventory/update/' . Crypt::encrypt($hotel_inventory->id_hotel_inventory)) }}">
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
                    <input type="hidden" name="h_id"
                        value="{{ \Crypt::encrypt($hotel_inventory->id_hotel_inventory) }}">

                    <div class="row row-sm mg-b-20">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Batch#</label>
                                <input type="text" name="batch_number" readonly class="form-control"
                                    value="<?= $hotel_inventory->batch_number ?>" required />
                            </div>
                        </div>
                        <!-- form-group -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">From Date</label>
                                <input type="text" name="from_date" class="form-control fc-datepicker"
                                    value="<?= $hotel_inventory->from_date ?>" placeholder="MM/DD/YYYY" required />
                            </div>
                        </div>
                        <!-- form-group -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">To Date</label>
                                <input type="text" name="to_date" class="form-control fc-datepicker"
                                    value="<?= $hotel_inventory->to_date ?>" placeholder="MM/DD/YYYY" required />
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Room Type</label>
                            <select name="room_type" id="room_type" class="form-control">
                                <option value="">Select</option>
                                @forelse ($room_types as $item)
                                    <option value="{{ $item->id_room_types }}">{{ $item->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <input type="hidden" id="hot_id"
                    value="{{ \Crypt::encrypt($hotel->id_hotels) }}">
                    <div class="row row-sm mg-b-20" id="room_type_list">





                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Upload Attachments</label>
                            <input type="file" class="form-control" name="attachments" />
                        </div>
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
    <script>
        $("#room_type").on("change", function(e) {
            let val = $(this).val();
            var val2 = $("#hot_id").val();


            $.ajax({
                url: "{{ url('get_room_type') }}/" + val+"?edit=edit&h_id="+val2,
                type: "GET",
                success: function(result) {
                    $('#room_type_list').empty().html(result);
                }
            });
        })
    </script>
@endpush
