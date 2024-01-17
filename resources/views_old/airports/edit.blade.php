@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Airports list</span>
        <span>Edit Airports</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Edit Airports <span><a href="{{ url('airports') }}"
                class="btn btn-az-primary" style="float: right">Airports List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Edit Airports Details</h5>
                <form method="POST" action="{{url('airports/update/'.\Crypt::encrypt($airports->id_airports))}}" enctype="multipart/form-data">
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
@csrf
                    <!-- form-group -->
                    <input type="hidden" name="a_id" value="{{ \Crypt::encrypt($airports->id_airports) }}">

                    <!-- form-group -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Airport Name</label>
                                <input type="text" value="{{$airports->name}}" name="airport_name" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Short Code</label>
                                <input type="text" value="{{$airports->code}}" name="airport_short_code" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <!-- form-group -->

                   <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Airport Country</label>

                                <select class="form-control select2 livesearch_country" id="country-dropdown" name="airport_country">
                                    <option value="{{$airports->countryName}}">{{$airports->countryName}}</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Airport City</label>

                                <select class="form-control select2 livesearch_city" name="airport_city" id="city-dropdown">
                                    <option value="{{$airports->cityName}}">{{$airports->cityName}}</option>

                                </select>
                            </div>
                        </div>
                    </div>
                   </div>


                    <button type="submit" onclick="history.back()" class="btn btn-danger btn-block mt-2">
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
     $('.livesearch_city').select2({
            placeholder: 'Select',
            ajax: {
                url: "{{ route('autocomplete_country') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.name,
                            }
                        })
                    };
                },
                cache: true
            }
        });
        $('.livesearch_country').select2({
            placeholder: 'Select',
            ajax: {
                url: "{{ route('autocomplete_country') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.country_name,
                                id: item.country_name,
                            }
                        })
                    };
                },
                cache: true
            }
        });
</script>
@endpush
