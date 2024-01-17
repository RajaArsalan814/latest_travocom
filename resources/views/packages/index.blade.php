@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Packages</span>
        {{-- <span>Add Package</span> --}}
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline"> Packages List <span>
            <a href="{{ url('packages/create') }}" class="btn btn-az-primary" style="float: right">Add Package</a></span></h2>
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
                            <th class="wd-20p">Package Name</th>
                            <th class="wd-15p">Package Type</th>
                            <th class="wd-15p">From Date</th>
                            <th class="wd-15p">To Date</th>
                            <th class="wd-15p">Package Cost</th>
                            <th class="wd-15p">Package Price</th>
                            <th class="wd-15p">No Of Persons</th>
                            <th class="wd-15p">Total Package Cost</th>
                            <th class="wd-15p">Total Package Price</th>
                            <th class="wd-15p">Profit/Loss</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created</th>
                            <th class="wd-10f">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($packages as $key => $package)

                        <?php
                        if(!empty($package['package_image'])){
                            $image = url('/uploads/package_images/'. $package['package_image']);
                        }else{
                            $image = url('/uploads/package_images/package_default.png');
                        }

                        $country = \App\countries::select('name')->where('id_countries', $package['country'])->first();

                        $package_name = App\packagestypes::select('type_name')->where('status', 1)->where('id_packages_types', $package['package_type'])->first();
                        ?>
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td><img src="<?= $image;?>" style="height:40px;width:40px;border-radius: 50%" alt="" srcset=""></td>
                                <td>{{ $package['package_name'] }}</td>
                                <td>{{ $package_name->type_name }}</td>
                                <td><span style="font-size:16px;" class="badge badge-success">{{ $package['from_date'] }}</span></td>
                                <td><span style="font-size:16px;" class="badge badge-success">{{ $package['to_date'] }}</span></td>
                                <td><span style="font-size:16px;" class="badge badge-warning">{{ $package['package_cost'] }}/=</span></td>
                                <td><span style="font-size:16px;" class="badge badge-warning">{{ $package['package_price'] }}/=</span></td>
                                <td><span style="font-size:16px;" class="badge badge-warning">{{ $package['no_of_persons'] }}</span></td>
                                <td><span style="font-size:16px;" class="badge badge-warning">{{ $package['no_of_persons']*$package['package_cost']  }}</span></td>
                                <td><span style="font-size:16px;" class="badge badge-warning">{{ $package['no_of_persons']*$package['package_price']  }}</span></td>
                                <td><span style="font-size:16px;" class="badge badge-warning">{{ ($package['no_of_persons']*$package['package_price'])-($package['no_of_persons']*$package['package_cost'])}}</span></td>
                                <td>
                                    @if ($package['package_status'] == 1)
                                    <button class="btn btn-rounded btn-success" style="color:#fff;">
                                            Active <span class="badge badge-primary"></span>
                                        </button>
                                    @else
                                    <button class="btn btn-rounded btn-danger" style="color:#fff;">
                                            Deactive <span class="badge badge-primary"></span>
                                        </button>
                                    @endif
                                </td>

                                <td><?= date('d-m-Y', strtotime($package['created_at']))?></td>

                                <td><a class="btn btn-rounded btn-primary" href="{{ url('packages/edit/' . Crypt::encrypt($package['id_packages'])) }}">
                                Edit
                                </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                     <tfoot>
                        <tr>
                            <th class="wd-5-f">S.No</th>
                            <th class="wd-5-f">IM</th>
                            <th class="wd-20p">Package Name</th>
                            <th class="wd-15p">Package Type</th>
                            <th class="wd-15p">From Date</th>
                            <th class="wd-15p">To Date</th>
                            <th class="wd-15p">Package Cost</th>
                            <th class="wd-15p">Package Price</th>
                            <th class="wd-15p">No Of Persons</th>
                            <th class="wd-15p">Total Package Cost</th>
                            <th class="wd-15p">Total Package Price</th>
                            <th class="wd-15p">Profit/Loss</th>
                            <th class="wd-10p">Status</th>
                            <th class="wd-10p">Created</th>
                            <th class="wd-10f">Operations</th>

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
