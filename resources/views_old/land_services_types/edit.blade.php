@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Land And Services Types</span>
        <span>Edit Land And Services Types</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Edit Land And Services Types <span><a href="{{ url('land_services_types') }}"
                class="btn btn-az-primary" style="float: right">Land And Services Types</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Edit Land And Services Types Details</h5>
                <form method="POST" action="{{url('land_services_types/update/'.\Crypt::encrypt($edit->id_land_services_types))}}">
                @csrf
                    <div class="row">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        @endif
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Service</label>
                                <input type="text" class="form-control" value="{{ $edit->service_name }}" name="service_name" id=""
                                    aria-describedby="helpId" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Service Type</label>
                                @php
                                $decode_service_type = json_decode($edit->service_type)
                                @endphp

                                <select class="form-control js-example-tokenizer" name="service_type[]"
                                style="width: 100%" multiple="multiple">
                                @foreach($decode_service_type as $key=> $decode_service )
                                <option value="{{ $decode_service }}" selected>{{$decode_service}}</option>
                                @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row row-sm mg-b-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Select Status</label>
                                        <select name="status" id="" class="form-control" required>

                                            <option <?= $edit->status==1 ? 'selected' : '' ?> value="1">Active</option>
                                            <option <?= $edit->status==0 ? 'selected' : '' ?> value="0">Deactive</option>

                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-indigo btn-block mt-2" style="float: right">Upadte</button>
                    <a type="submit" href="{{ url('land_services_types') }}" class="btn btn-danger btn-block mt-2">
                        Cancel
                    </a>

            </div>
                </form>
            <!-- card -->
        </div>
        <!-- col -->
    </div>
    @include('land_services_types.add_service_type_modal')


    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    {{-- <script type="text/javascript">

    $(function(){



        oTable = $('#example2').DataTable({

            responsive: !0
        });



   });

</script> --}}
    <script>


        $(document).ready(function() {
            $(".js-example-tokenizer").select2({
                tags: true,
                tokenSeparators: [','],
                dropdownParent: $("#modaldemo2")

            })

            });


    </script>
@endpush
@endsection
    