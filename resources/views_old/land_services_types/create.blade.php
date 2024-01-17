@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Land Services Types</span>
        <span>Add Land Services Type</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">Add New Land Services Type <span><a href="{{ url('land_services_types') }}"
                class="btn btn-az-primary" style="float: right">Land Services Types </a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
                <h5 class="card-title mg-b-20">Add Land Services Type</h5>
                <form method="post" action="{{url('land_services_types/store')}}">
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
                                <input type="text" class="form-control" name="service_name" id=""
                                    aria-describedby="helpId" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Service Type <span style="font-size: 12px">( Press enter to select service type )</span></label>
                                <select class="form-control js-example-tokenizer" name="service_type[]"
                                    style="width: 100%" multiple="multiple">

                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-indigo">Create</button>
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
