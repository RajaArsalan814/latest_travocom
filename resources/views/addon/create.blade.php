@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Addon</span>
        <span>Add Addon</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Add New Addon <span><a href="{{ url('addons') }}"
                class="btn btn-az-primary" style="float: right">Addon
                List</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">ADD ADDONS</h5>
                <form method="post" action="{{ url('addons/store') }}">
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
                        <div class="col-md-12">
                            <div class="row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Name <span
                                                class="text-danger"><b>*</b></span></label>
                                        <input type="text" name="addon_name" class="form-control" required />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                        <div class="row-sm mg-b-20">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Cost Price <span
                                            class="text-danger"><b>*</b></span></label>
                                    <input class="form-control" type="text" name="cost_price" required />
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                        <div class="row-sm mg-b-20">
                                <div class="form-group">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Sell Price <span
                                            class="text-danger"><b>*</b></span></label>
                                    <input class="form-control" type="text" name="sell_price" required />
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
        var itemCount = 1; // To keep track of the number of item fields

        function append_addons() {

            $.ajax({
                url: "{{ url('/append_addons') }}/" + itemCount, //the page containing php script
                type: "GET", //request type,
                success: function(result) {
                    $('#append_addons').append(result);
                    itemCount = itemCount + 1
                }
            });
        }

        function rmv_addons(itemCount) {
            $('.rmv_' + itemCount).remove();
        }

        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
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
