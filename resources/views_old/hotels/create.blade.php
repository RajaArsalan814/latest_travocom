@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Hotels</span>
        <span>Add Hotel</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Add New Hotel <span><a href="{{ url('hotels') }}"
                class="btn btn-az-primary" style="float: right">Hotel List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Add Hotel Details</h5>
                <form method="post" enctype="multipart/form-data" action="{{ url('hotels/store') }}">
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

                    <div class="row row-sm mg-b-20">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Hotel Name</label>
                                <input type="text" name="hotel_name" class="form-control" required />
                            </div>
                        </div>
                        <!-- form-group -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Hotel type</label>

                                <select class="form-control select2" name="hotel_type">
                                    <option>Select Hotel Type</option>
                                    <option value="Umrah">Umrah</option>
                                    <option value="D-Tour">D-Tour</option>
                                    <option value="I-Tour">I-Tour</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Hotel Category</label>

                                <select class="form-control select2" name="hotel_category">
                                    <option>Select Category </option>
                                    <option value="Economy">Economy</option>
                                    <option value="Standard">Standard</option>
                                    <option value="2-Star">2-Star</option>
                                    <option value="3-Star">3-Star</option>
                                    <option value="4-Star">4-Star</option>
                                    <option value="5-Star">5-Star</option>

                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Hotel Address</label>
                        <input type="text" name="hotel_address" class="form-control" required />
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Room Availablity</label>
                            <select class="js-example-basic-multiple form-control" name="room_availablity[]" multiple="multiple">
                                @forelse ($room_types as $room)
                                    <option value="{{ $room->id_room_types }}">{{ $room->name }}</option>
                                @empty
                                @endforelse

                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Country/City</label>
                            <select name="country_city" id="country-dropdown" class="form-control livesearch">
                                {{-- @forelse ($countries as $con)
                                    <option value="{{ $con->name }}">{{ $con->name }}</option>
                                @empty
                                    No Results Found
                                @endforelse --}}
                            </select>
                        </div>
                    </div>

                    {{-- <div class="row row-sm mg-b-20">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Quint Room Availability</label>
                                <select class="form-control select2" name="quint_status">
                                    <option>Select Status</option>
                                    <option value="1">Available</option>
                                    <option value="0">Not Available</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Quad Room Availability</label>
                                <select class="form-control select2" name="quad_status">
                                    <option>Select Status</option>
                                    <option value="1">Available</option>
                                    <option value="0">Not Available</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Triple Room Availability</label>
                                <select class="form-control select2" name="triple_status">
                                    <option>Select Status</option>
                                    <option value="1">Available</option>
                                    <option value="0">Not Available</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Double Room Availability</label>
                                <select class="form-control select2" name="double_status">
                                    <option>Select Status</option>
                                    <option value="1">Available</option>
                                    <option value="0">Not Available</option>
                                </select>
                            </div>
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Hotel Image</label>
                            <input type="file" class="form-control" name="hotel_image" />
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
        $('#country-dropdown').on('change', function() {
            var country_id = this.value;

            $("#city-dropdown").html('');
            $.ajax({
                url: "{{ url('get-cities-by-country') }}",
                type: "POST",
                data: {
                    country_id: country_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#city-dropdown1').html(
                        '<option value="">Select</option>');
                    $.each(result.cities, function(key, value) {
                        $("#city-dropdown1").append('<option value="' +
                            value.id +
                            '">' + value.name + '</option>');
                    });
                }
            });
        });

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
