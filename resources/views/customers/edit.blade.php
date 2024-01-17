@extends('layouts.master')
@section('content')
    <style>
        .iti.iti--allow-dropdown.iti--show-flags {
            width: 100%;
        }
    </style>
    <div class="az-content pd-y-20 pd-lg-y-30 pd-xl-y-40">
        <div class="container">
            <div class="az-content-body pd-lg-l-40 d-flex flex-column">

                <div class="az-content-breadcrumb">
                    <span>Customer list</span>
                    <span>Edit Customer</span>
                    {{-- <span>Forms</span> --}}
                    {{-- <span>Form Layouts</span> --}}
                </div>
                <h2 class="az-content-title" style="display: inline">Edit Customer <span><a href="{{ url('customers') }}"
                            class="btn btn-az-primary" style="float: right">Customer List</a></span></h2>
                {{-- <h2 style="float: right" class="az-content-title"></h2> --}}

                {{-- @php
            getCount('deactive',1)
            @endphp --}}
                {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="card card-body pd-40">
                            <h5 class="card-title mg-b-20">Edit Customer Details</h5>
                            <form method="post" enctype="multipart/form-data" action="{{url('customers/store')}}">
                                @if (count($errors) > 0)
                                    <div class="p-1">
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-warning alert-danger fade show" role="alert">
                                                {{ $error }}
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="row">
                                    <input type="hidden" name="c_id" value="{{ \Crypt::encrypt($customers->id_customers) }}">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Customer
                                                Name <span style="color:red;">*</span></label>
                                            <input type="text" value="{{$customers->customer_name}}" name="customer_name" class="form-control" required />
                                        </div>
                                        <!-- form-group -->
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Customer Cell <span style="color:red;">*</span>
                                                &nbsp;&nbsp;&nbsp;
                                            </label>
                                            <input type="tel" id="phone0" class="form-control" required="required"
                                                name="customer_cell" value="{{$customers->customer_cell}}">
                                            <div class="invalid-feedback0"></div>
                                        </div>
                                        <!-- form-group -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Customer
                                                    Address</label>
                                                <input type="text" value="{{$customers->customer_address}}" name="customer_address" class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group ml-2 mt-2">
                                            <div class="form-group">
                                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Customer
                                                    Email</label>
                                                <input value="{{$customers->customer_email}}" type="text" name="customer_email" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group ml-2 mt-2">
                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Customer Phone
                                                1</label>
                                            <input type="tel" value="{{$customers->customer_phone1}}" id="phone1" class="form-control"
                                                name="customer_phone_1">
                                            <div class="invalid-feedback1"></div>
                                        </div>
                                        <!-- form-group -->
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group ml-2 mt-2">
                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Customer Phone
                                                2</label>
                                            <input type="tel"  value="{{$customers->customer_phone2}}" id="phone2" class="form-control"
                                                name="customer_phone_2">
                                            <div class="invalid-feedback2"></div>
                                        </div>
                                        <!-- form-group -->
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ml-2 mt-2">
                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Contact
                                                Person</label>
                                            <input type="tel" id="phone" value="{{$customers->contact_person}}" class="form-control" name="contact_person">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <!-- form-group -->
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ml-2 mt-2">
                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Customer
                                                Type</label>
                                            <select name="customer_type" id="" class="form-control" required="required">
                                                <option>Select</option>
                                                <option @if($customers->customer_type=="International") selected @endif value="International">International</option>
                                                <option @if($customers->customer_type=="Domestic") selected @endif value="Domestic">Domestic</option>
                                                <option @if($customers->customer_type=="Corporate") selected @endif value="Corporate">Corporate </option>
                                                <option @if($customers->customer_type=="Other") selected @endif value="Other">Other</option>
                                            </select>

                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <!-- form-group -->
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ml-2 mt-2">
                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Country</label>
                                            <select name="country" class="form-control" id="country-dropdown">
                                                <option>Select Country</option>
                                                @forelse ($countries as $con)
                                                    <option
                                                        value="{{ $con->name }}">{{ $con->name }}</option>
                                                @empty
                                                    No Results Found
                                                @endforelse
                                                <option value=""></option>
                                            </select>

                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <!-- form-group -->
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ml-2 mt-2">
                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">City</label>
                                            <select name="city" class="form-control" id="city-dropdown">
                                                <option value=""></option>
                                            </select>

                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <!-- form-group -->
                                    </div>

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Customer
                                                Image</label>
                                            <input type="file" class="form-control" name="customer_image" />
                                        </div>
                                    </div>
                                    {{-- <h3 class="text-center mt-3">Add Care Of</h3> --}}
                                    <div class="col-md-4">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600"
                                            style="display: block;position: absolute;margin-top: 7px;
                                        }">Add
                                            Care Of</label>
                                        <button class="extra-fields-customer btn btn-az-primary mt-4 mb-4">Add
                                            More </button>
                                    </div>
                                    <div class="customer_records d-none">

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Name</label>
                                                <input name="care_of_name[]" type="text" class="form-control">

                                            </div>
                                            <div class="col-md-4">
                                                <label
                                                    class="az-content-label tx-11 tx-medium tx-gray-600">Relation</label>
                                                <input name="care_of_relation[]" type="text" class="form-control">

                                            </div>
                                            <div class="col-md-4">
                                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Cell</label>
                                                <input name="care_of_cell[]" type="tel" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Email</label>
                                                <input name="care_of_email[]" type="email" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Age</label>
                                                <input name="care_of_age[]" type="number" min="1" max="100"
                                                    class="form-control">
                                            </div>

                                            {{-- <div class="col-md-4">
                                                <label class="az-content-label tx-11 tx-medium tx-gray-600"
                                                    style="display: block;position: absolute;margin-top: 7px;
                                                }">Add
                                                    Care Of</label>
                                                <a href="#" class="extra-fields-customer btn btn-az-primary mt-4">Add More </a>
                                            </div> --}}
                                            <hr class="mt-4">

                                        </div>
                                    </div>

                                    <div class="customer_records_dynamic"></div>

                                </div>
                                @csrf

                                <!-- form-group -->


                                <!-- form-group -->



                                <button onclick="history.back()" class="btn btn-danger btn-block mt-2">
                                    Back
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
                {{-- </div><!-- az-content-body --> --}}
            </div>
        </div><!-- container -->
    </div><!-- az-content -->

@endsection

@push('scripts')
    <script>
        $('.extra-fields-customer').click(function() {
            $('.customer_records').clone().appendTo('.customer_records_dynamic');
            $('.customer_records_dynamic .customer_records').addClass('single remove');
            $('.single .extra-fields-customer').remove();
            $('.single').append(
                '<a href="#" class="remove-field btn-remove-customer btn btn-danger">Remove Fields</a>');
            $('.customer_records_dynamic > .single').attr("class", "remove");

            $('.customer_records_dynamic input').each(function() {
                var count = 0;
                var fieldname = $(this).attr("name");
                $(this).attr('name', fieldname + count);
                count++;
            });

        });

        $(document).on('click', '.remove-field', function(e) {
            $(this).parent('.remove').remove();
            e.preventDefault();
        });
        // Ajax to get City
        $(document).ready(function() {



            $('#country-dropdown').on('change', function() {
                var country_id = this.value;
                // alert(country_id)
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
                        $('#city-dropdown').html(
                            '<option value="">Select City</option>');
                        $.each(result.cities, function(key, value) {
                            $("#city-dropdown").append('<option value="' +
                                value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>

    <script>
    // Get Already Customer
        $("#phone0").on("keyup change", function(e) {
            let val = $(this).val();

            $.ajax({
                url: "{{ url('check_customer_number') }}/" + val,
                type: "GET",
                data: {
                    number: val
                },
                dataType: 'json',
                success: function(result) {
                    if (result.getCell == true) {
                        alert('Customer already exists!');

                    }
                }
            });
        })
    </script>
@endpush
