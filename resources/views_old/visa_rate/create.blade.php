@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Visa Rates</span>
        <span>Add Visa Rates</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Add New Visa Rates <span><a href="{{ url('visa_rates') }}"
                class="btn btn-az-primary" style="float: right">Visa Rates
                List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Add Visa Rates</h5>
                <form method="post" action="{{ url('visa_rate/store') }}">
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

                   <div class="row">

                        <div class="col-md-4" style="">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Service Name</label>
                                        <input type="text" name="service_name" class="form-control" required />
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="col-md-4 ">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Visa Type</label>
                                        {{-- <input class="form-control" type="text" name="children_cost_price"/> --}}
                                        {{-- <select class="form-control" name="transport_type" id=""> --}}
                                        <select name="visa_type" required class="form-control" onchange="change_transport_type(0,this)"
                                            id="transport_type[]">

                                            <option value="">Select</option>
                                            <option value="umrah">Umrah </option>
                                            <option value="international">International </option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="col-md-4" id="international" style="display: none">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Country</label>
                                       <select name="country" class="livesearch form-control" style="width:100%;" id=""></select>
                                    </div>
                                </div>

                            </div>
                        </div>

                   </div>


                  <div class="row">
                    <div class="col-md-6" >
                        <div class="row row-sm mg-b-20">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Adult Cost Price</label>
                                    <input class="form-control" type="text" name="adult_cost_price" />
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6" >
                        <div class="row row-sm mg-b-20">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Adult Selling Price</label>
                                    <input class="form-control" type="text" name="adult_selling_price" />
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="col-md-6 " >
                        <div class="row row-sm mg-b-20">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Child Cost Price</label>
                                    <input class="form-control" type="text" name="child_cost_price" />
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6 " >
                        <div class="row row-sm mg-b-20">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Child Selling Price</label>
                                    <input class="form-control" type="text" name="child_selling_price" />
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6 " >
                        <div class="row row-sm mg-b-20">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Infant Cost Price</label>
                                    <input class="form-control" type="text" name="infant_cost_price" />
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6 " >
                        <div class="row row-sm mg-b-20">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Infant Selling Price</label>
                                    <input class="form-control" type="text" name="infant_selling_price" />
                                </div>
                            </div>

                        </div>
                    </div>
                  </div>
                    <h5 class="card-title mg-b-20">Vendors Detail</h5>

                    <hr>

                    <div class="col-md-12 " >
                        <div class="row row-sm mg-b-20">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Vendor Name</label>
                                    <select class="form-control" name="vendor_name">
                                        <option value="">Select</option>
                                        @foreach ($vendor as $vendors)
                                            <option value="{{ $vendors->id_service_vendors }}">{{ $vendors->vendor_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>








            </div>
            <a type="submit" href="{{ url('visa_rate') }}" class="btn btn-danger btn-block mt-2">
                Cancel
            </a>
            <button type="submit" class="btn btn-az-primary btn-block mt-2" style="float: right">
                Submit
            </button>
            <!-- card -->
        </div>
        <!-- col -->

    </div>

    </form>


@endsection
@push('scripts')
    <script>
        // function change_transport_type(count , e) {
        //     var val = $(e).val();
        //     if (count == 0) {
        //         if (val == 'international') {
        //             $('#umrah').css('display' , 'none')
        //             $('#international').css('display' , 'block')
        //         }
        //         else {
        //             $('#international').css('display' , 'none')
        //             $('umrah').css('display' , 'block')
        //         }
        //     }
        //     else {
        //         if (val == 'international') {
        //             $('#umrah' + count).css('display' , 'none')
        //             $('#international' + count).css('display' , 'block')
        //         }
        //         else{
        //             $('#international' + count).css('display' , 'none')
        //             $('#umrah' + count).css('display' , 'block')
        //         }
        //     }
        // }
        $('.livesearch').select2({
            placeholder: 'Select',
            dropdownParent: $("#modaldemo1"),
            ajax: {
                url: "{{ route('autocomplete_country') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(
                            item) {
                            return {
                                text: item
                                    .country_name +
                                    ' - ' + item
                                    .name,
                                id: item
                                    .country_name +
                                    ' - ' + item
                                    .name,
                            }
                        })
                    };
                },
                cache: true
            }
        });

        function change_transport_type(count, e) {
            var val = $(e).val();
            if (count == 0) {
                if (val == 'international') {
                    $('#umrah').css('display', 'none')
                    $('#international').css('display', 'block')
                } else {
                    $('#international').css('display', 'none')
                    $('#umrah').css('display', 'block')
                }
            } else {
                if (val == 'international') {
                    $('#umrah' + count).css('display', 'none')
                    $('#international' + count).css('display', 'block')
                } else {
                    $('#international' + count).css('display', 'none')
                    $('#umrah' + count).css('display', 'block')
                }
            }
        }
    </script>
@endpush
<style>
    .add-more-container {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 10px;
        /* Optional: Add some spacing between the button and other elements */
    }
</style>
