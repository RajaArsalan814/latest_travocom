@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Vendors</span>
        {{-- <span>Add Vendor</span> --}}
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline"> Vendors List <span>
            <a href="{{ url('vendors/create') }}" class="btn btn-az-primary" style="float: right">Add Vendor</a></span></h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            {{-- <div class="card card-body pd-40"> --}}

            <div>
                <table id="example2" class="table table-responsive">
                    <thead>
                        <tr>
                            <th class="wd-5-f">S.No</th>
                            <th class="wd-5-f">IM</th>
                            <th class="wd-20p">Name</th>
                            <th class="wd-15p">Contact</th>
                            <th class="wd-20p">Address</th>
                            {{-- <th class="wd-20p">Country/City</th> --}}
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created</th>
                            <th class="wd-10p">Updated</th>
                            <th class="wd-40p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendors as $key => $vendor)

                        <?php
                        if(!empty($vendor->vendor_image)){
                            $image = url('/uploads/vendor_images/'. $vendor->vendor_image);
                        }else{
                            $image = url('/img/default_user.png');
                        }
                        ?>
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td><img src="<?= $image;?>" style="height:40px;width:40px;border-radius: 50%" alt="" srcset=""></td>
                                <td>{{ $vendor->vendor_name }}</td>
                                <td>{{ $vendor->primary_contact }}</td>
                                <td>{{ $vendor->vendor_address }}</td>
                                {{-- <td>{{ $vendor->country_city }}</td> --}}
                                <td>
                                    @if ($vendor->vendor_status == 1)
                                    <button class="btn btn-rounded btn-success" style="color:#fff;">
                                            Active <span class="badge badge-primary"></span>
                                        </button>
                                    @else
                                    <button class="btn btn-rounded btn-danger" style="color:#fff;">
                                            Deactive <span class="badge badge-primary"></span>
                                        </button>
                                    @endif
                                </td>
                                <td><?= date('d-m-Y', strtotime($vendor->created_at))?></td>
                                <td><?= date('d-m-Y', strtotime($vendor->updated_at))?></td>
                                <td><a class="btn btn-rounded btn-primary" href="{{ url('vendors/edit/' . Crypt::encrypt($vendor->id_service_vendors)) }}">
                                Edit
                                </a>
<!--                                    <a class="btn btn-rounded btn-danger" href="{{ url('vendors/destroy/' . Crypt::encrypt($vendor->id_service_vendors)) }}">
                                Delete
                                </a>-->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                     <tfoot>
                        <tr>
                            <th class="wd-5-f">S.No</th>
                            <th class="wd-5-f">IM</th>
                            <th class="wd-20p">Name</th>
                            <th class="wd-15p">Contact</th>
                            <th class="wd-20p">Address</th>
                            {{-- <th class="wd-20p">Country/City</th> --}}
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created</th>
                            <th class="wd-10p">Updated</th>
                            <th class="wd-40p">Operations</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            {{-- </div> --}}
            <!-- card -->
        </div>
        <!-- col -->
    </div>






    {{-- </div><!-- az-content-body --> --}}
@endsection

@push('scripts')

<script>
        $(document).ready(function() {

            $('#example2 tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
    });

            $('#example2').DataTable({
                "ordering": true,
                "dom": 'Blfrtip',
                "buttons": [
                    'excel', 'pdf', 'print'
                ],
                responsive: !0,
                columnDefs: [{
                    className: 'control',
                    orderable: false
                }],
            initComplete: function () {
            // Apply the search
            this.api()
                .columns()
                .every(function () {
                    var that = this;

                    $('input', this.footer()).on('keyup change clear', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
        }
            });
        });
    </script>
@endpush
