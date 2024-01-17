@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Route</span>
        <span>Add Route/span>
            {{-- <span>Forms</span> --}}
            {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Add New Route<span><a href="{{ url('route') }}"
                class="btn btn-az-primary" style="float: right">Route List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h4 class="card-title mg-b-20">Add Route</h4>
                <form method="post" action="{{ url('route/store') }}">
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

                    <div class="row row-sm mg-b-20 ">
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Name</label>
                                <input type="text" name="route_name" class="form-control" required />
                            </div>
                        </div>

                    </div>
                    <div class="row" id="add_more_route">
                        <div class="col-md-3 ">
                            <div class="form-group">
                                <label class="az-content-label tx-11 tx-medium tx-gray-600">Location</label>
                                <input type="text" name="locations[]" class="form-control" required />
                            </div>
                            <button style="float: right;" type="button" onclick="add_more_route_fun()"
                            class="btn btn-primary mt-4 ms-2 d-flex">Add More</button>
                        </div>


                    </div>






                    <a type="submit" href="{{ url('route') }}" class="btn btn-danger btn-block mt-2">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-az-primary btn-block mt-2" style="float: right">
                        Submit
                    </button>
                </form>
            </div>
            <!-- card -->
        </div>
        <!-- col -->
    </div>
    <script>
        var route_count = 0;

        function add_more_route_fun() {
            $.ajax({
                url: "{{ url('add_route_details') }}/" + route_count,
                type: "GET",
                success: function(data) {
                    $('#add_more_route').append(data);
                    route_count = route_count + 1
                }
            });
        }

        function remove_route(count_rmv) {
            // alert(count_rmv)
            $('.rmv_route' + count_rmv).remove();
        }
    </script>

@endsection
