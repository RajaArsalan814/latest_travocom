@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span> Campaigns</span>
        <span>Add Campaigns</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Add Campaigns <span><a href="{{ url('campaigns') }}"
                class="btn btn-az-primary" style="float: right">Campaigns
                List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Add Campaigns</h5>
                <form method="post" action="{{ url('campaigns/store') }}">
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
                        <div class="col-md-4">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Campaigns Name</label>
                                        <input type="text" name="campaign_name" class="form-control" required />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Start Date</label>
                                        <input type="text" readonly name="start_date" placeholder="MM/DD/YYYY"
                                            class="form-control fc-datepicker">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">End Date</label>
                                        <input type="text" readonly name="end_date" placeholder="MM/DD/YYYY"
                                            class="form-control fc-datepicker">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12">

                            <div class="row">
                                <div class="col-lg-5 mg-t-20 mg-lg-t-0">
                                    <div class="form-group">

                                        <label class="form-control-label">Services: <span
                                                style="color:red;">*</span></label>
                                        <select name="services[]" id="services" class="form-control" required="required">
                                            <option>Select Services </option>
                                            @forelse ($services as $service)
                                                <option value="{{ $service->id_other_services }}">
                                                    {{ $service->service_name }}
                                                </option>
                                            @empty
                                                No Results Found
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                @csrf
                                <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                                    <div class="form-group">

                                        <label class="form-control-label">Sub Services:</label>
                                        <select style="width: 100%" name="sub_services[]" id="sub_services"
                                            class="js-example-basic-multiple" multiple="multiple">
                                            <option>Select Sub Service</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 mg-t-20 mg-md-t-0">
                                    {{-- <label class="form-control-label">Add More</label> --}}
                                    <button onclick="add_more()" class="btn btn-az-primary mt-4" type="button">Add
                                        More</button>
                                </div>
                                <input type="hidden" id="d_id2" name="d_id">
                            </div>
                            <div class="row" id="append_services">

                            </div>
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Inquiry
                                            Type</label>
                                        <select name="inquiry_type" id="" class="form-control">
                                            <option value="">Select</option>
                                            @forelse ($inquiry_type as $item)
                                                <option value="{{ $item->type_id }}">{{ $item->type_name }}
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Description</label>
                                        <textarea name="desc" id="" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
        // alert('sdsds')
        var counti = 1;
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();

        });

        function onchange_services(o_count) {
            var val = $('#services' + o_count).val();
            $.ajax({
                url: "{{ url('get_sub_services') }}/" + val,
                type: "GET",
                success: function(data) {
                    console.log(data)
                    $('#sub_services' + o_count).html(data);
                }
            });
        }


        function add_more() {
            // alert('sdsd')

            $.ajax({
                url: "{{ url('add_more_services') }}/" + counti,
                type: 'GET',
                success: function(data) {
                    console.log(data.script)
                    $('#append_services').append(data.data);
                    // $('#append_js').append(data.script);
                    $('#count_id').val(counti);
                    counti = counti + 1;
                    // alert(counti);
                    $('.js-example-basic-multiple').select2()
                    $('#services' + counti).on('change', function() {
                        var val = $(this).val();
                        alert(val);
                        $.ajax({
                            url: "{{ url('get_sub_services') }}/" + val,
                            type: "GET",
                            success: function(data) {
                                console.log(data)
                                $('#sub_services' + counti).html(data);
                            }
                        });
                    });
                }
            });

        }

        function remove(count_rmv) {
            // alert(counti)
            counti = counti - 1;
            // alert(counti);
            $('.rmv' + count_rmv).remove();
        }
        $(document).ready(function() {
            // $('.select2').select2();

            $('#services').on('change', function() {
                var val = $(this).val();
                $.ajax({
                    url: "{{ url('get_sub_services') }}/" + val,
                    type: "GET",
                    success: function(data) {
                        $('#sub_services').html(data);
                    }
                });
            });


        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script>
        function assignUser(user_id) {
            $('#d_id').val(user_id);
            $('#modaldemo1').modal('show');
        }

        function assignServices(d_id) {
            $('#d_id2').val(d_id);
            // alert(d_id)
            $('#modaldemo2').modal('show');
        }

        $(function() {



            oTable = $('#example2').DataTable({

                responsive: !0
            });



        });
    </script>
@endpush