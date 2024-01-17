@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Vendors</span>
        <span>Add Vendor</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Add New Vendor <span><a href="{{ url('vendors') }}"
                class="btn btn-az-primary" style="float: right">Vendor List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Add Vendor Details</h5>
                <form method="post" enctype="multipart/form-data" action="{{ url('vendors/store') }}">
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Vendor Name</label>
                                <input type="text" name="vendor_name" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <!-- form-group -->
                    <div class="row row-sm mg-b-20">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Primary Contact</label>
                                    <input type="text" name="primary_contact" class="form-control numeric" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Secondary
                                        Contact</label>
                                    <input type="text" name="secondory_contact" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Other Contact</label>
                                    <input type="text" name="other_contact" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>

            <!-- form-group -->

            <!-- form-group -->
            <div class="row row-sm mg-b-20">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Vendor Address</label>
                            <input type="text" name="vendor_address" class="form-control" required />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-sm mg-b-20" id="append_vendor_contact">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Country City</label>
                        <select name="country_city[]" id="country-dropdown2" class="form-control livesearch" required>
                            {{-- @forelse ($countries as $con)
                                    <option value="{{ $con->name }}">{{ $con->name }}</option>
                                @empty
                                    No Results Found
                                @endforelse --}}
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Contact Name</label>
                            <input type="text" name="contact_name[]" class="form-control numeric" required />
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Contact Phone.</label>
                            <input type="text" name="contact_phone[]" class="form-control numeric" required />
                        </div>
                    </div>
                </div>
                <div class="col-md-1 mt-4">

                    <button type="button" onclick="add_vendor_details()" class="btn btn-az-primary">Add</button>

                </div>
            </div>
            <div class="row row-sm mg-b-20">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-group">
                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Vendor Image</label>
                            <input type="file" class="form-control" name="vendor_image" />
                        </div>
                    </div>
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






    {{-- </div><!-- az-content-body --> --}}
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $(".numeric").numeric({
                decimal: ".",
                negative: false,
                scale: 3
            });
        });
        var count = 0;

        function add_vendor_details() {
            $.ajax({
                type: "GET",
                url: "{{ url('/add_vendor_contact_details') }}/" + count,
                success: function(response) {
                    $('#append_vendor_contact').append(response);
                    count = count + 1;
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
                                            id: item.country_name + ' - ' + item.name,
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                    });

                }
            });
        }

        function remove_vendor(count) {
            $(".rmv" + count).remove();
        }
    </script>
@endpush
