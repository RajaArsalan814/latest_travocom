@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Hotel list</span>
        <span>Edit Hotel</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Edit Hotel <span><a href="{{ url('hotels') }}"
                class="btn btn-az-primary" style="float: right">Hotel List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Edit Hotel Details</h5>
                <form method="POST" action="{{ url('hotels/update/' . \Crypt::encrypt($edit_hotel->id_hotels)) }}"
                    enctype="multipart/form-data">
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
                    <div class="row row-sm mg-b-20">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Hotel Name</label>
                                <input type="text" name="hotel_name" class="form-control"
                                    value="{{ $edit_hotel->hotel_name }}" required />
                            </div>
                        </div>
                        <!-- form-group -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Hotel type</label>

                                <select class="form-control select2" name="hotel_type" required>
                                    <option>Select Hotel Type</option>

                                    <option <?= $edit_hotel->hotel_type == 'Umrah' ? 'selected' : '' ?> value="Umrah">Umrah
                                    </option>
                                    <option <?= $edit_hotel->hotel_type == 'D-Tour' ? 'selected' : '' ?> value="D-Tour">
                                        D-Tour</option>
                                    <option <?= $edit_hotel->hotel_type == 'I-Tour' ? 'selected' : '' ?> value="I-Tour">
                                        I-Tour</option>


                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Hotel Category</label>

                                <select class="form-control select2" name="hotel_category" required>
                                    <option>Select Hotel Type</option>
                                    <option <?= $edit_hotel->hotel_category == 'Economy' ? 'selected' : '' ?>
                                        value="Economy">
                                        Economy</option>
                                    <option <?= $edit_hotel->hotel_category == 'Standard' ? 'selected' : '' ?>
                                        value="Standard">
                                        Standard</option>
                                    <option <?= $edit_hotel->hotel_category == '2-Star' ? 'selected' : '' ?> value="2-Star">
                                        2-Star</option>
                                    <option <?= $edit_hotel->hotel_category == '3-Star' ? 'selected' : '' ?> value="3-Star">
                                        3-Star</option>
                                    <option <?= $edit_hotel->hotel_category == '4-Star' ? 'selected' : '' ?> value="4-Star">
                                        4-Star</option>
                                    <option <?= $edit_hotel->hotel_category == '5-Star' ? 'selected' : '' ?> value="5-Star">
                                        5-Star</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row row-sm mg-b-20">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Hotel Address</label>
                                <input type="text" name="hotel_address" class="form-control"
                                    value="{{ $edit_hotel->hotel_address }}" required />
                            </div>
                        </div>
                    </div>


                    <!-- form-group -->
                    <div class="row row-sm mg-b-20">
                        <div class="col-md-12">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Room Availablity</label>

                            <select class="js-example-basic-multiple form-control" name="room_availablity[]"
                                multiple="multiple" required>
                                @forelse ($room_types as $key => $room)
                                    @if ($edit_hotel['room_availablity'] != null)
                                        @php
                                            $decode = json_decode($edit_hotel['room_availablity']);
                                            // print_r($decode);
                                            $size = sizeof($decode);
                                            // echo $size;
                                            // echo $key+1;
                                            // exit();
                                        @endphp
                                    @endif

                                    <option @if ($key < $size && $decode[$key] == $room->id_room_types) selected @endif
                                        value="{{ $room->id_room_types }}">
                                        {{ $room->name }}</option>
                                @empty
                                @endforelse

                            </select>
                        </div>
                    </div>
                    <!-- form-group -->

                    <div class="row row-sm mg-b-20">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Country/City</label>
                                <select name="country_city" id="country-dropdown" class="form-control livesearch" required>
                                    <option value="{{ $edit_hotel->country }}">{{ $edit_hotel->country }}</option>
                                    {{-- @forelse ($countries as $con)
                                    <option value="{{ $con->name }}">{{ $con->name }}</option>
                                @empty
                                    No Results Found
                                @endforelse --}}
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    @csrf
                    <?php
                    if (!empty($edit_hotel->hotel_image)) {
                        $image = url('/uploads/hotels_images/' . $edit_hotel->hotel_image);
                    } else {
                        $image = url('/uploads/hotels_images/hotel_default.png');
                    }
                    ?>
                    <!-- form-group -->
                    <input type="hidden" name="h_id" value="{{ \Crypt::encrypt($edit_hotel->id_hotels) }}">
                    <div class="row row-sm mg-b-20">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600 mt-2">Hotel Image</label>
                                <div>
                                    <div class="col-md-12  mb-4">
                                        <img src="<?= $image ?>" style="border-radius: 50%;height:100px;width:100px;"
                                            alt="" srcset="">
                                    </div>
                                </div>
                                <input type="file" class="form-control" name="hotel_image" />
                            </div>
                        </div>
                    </div>
                    <!-- form-group -->
                    <div class="row row-sm mg-b-20">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Hotel Status</label>
                                <select class="form-control select2" name="hotel_status">
                                    <option <?= $edit_hotel->hotel_status == 1 ? 'selected' : '' ?> value="1">Active
                                    </option>
                                    <option <?= $edit_hotel->hotel_status == 0 ? 'selected' : '' ?> value="0">Deactive
                                    </option>

                                </select>
                            </div>
                        </div>
                    </div>


                    <button type="button" onclick="history.back()" class="btn btn-danger btn-block mt-2">
                        Back
                    </button>
                    <button type="submit" class="btn btn-az-primary btn-block mt-2" style="float: right">
                        Update
                    </button>
                </form>
            </div>
            <!-- card -->
        </div>
        <!-- col -->
    </div>






    {{-- </div><!-- az-content-body --> --}}
@endsection
@push('scripts')
    <script>
        $('.livesearch').select2({
            placeholder: 'Select',
            ajax: {
                url: "{{ route('autocomplete_country') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.country_name + ' - ' + item.name,
                                id: item.country_name item.name,
                            }
                        })
                    };
                },
                cache: true
            }
        });
    </script>
@endpush
