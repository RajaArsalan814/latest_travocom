<div id="modaldemo2" class="modal fade bd-example-modal-lg " role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Add Land Service Types</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                @php
                    $services = App\other_service::where('parent_id', null)->get();
                    $hotels = App\hotel_inventory::all();
                @endphp
                {{-- <label for="">Assign Services And Sub Services</label> --}}
                <form method="POST" action="{{ url('add_land_service_type') }}">
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
                                <input type="text" class="form-control" name="land_service" id=""
                                    aria-describedby="helpId" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Service Type</label>
                                <select class="form-control js-example-tokenizer" name="service_type[]"
                                    style="width: 100%" multiple="multiple">

                                </select>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-indigo">Create</button>
                </form>
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
