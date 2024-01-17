@extends('layouts.master')
@section('content')
    <div class="az-content-breadcrumb">
        <span>Customers</span>
        {{-- <span>Add Airline</span> --}}
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline"> Customers List <span>
            <a href="{{ url('customers/create') }}" class="btn btn-az-primary" style="float: right">Add Customers</a></span>
    </h2>
    {{-- <h2 style="float: right" class="az-content-title"></h2> --}}


    {{-- <div class="az-content-body pd-lg-l-40 d-flex flex-column"> --}}
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            {{-- <div class="card card-body pd-40"> --}}

            <div>
                <table id="example2" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="wd-5-f">S.No</th>
                            <th class="wd-5-f">IM</th>
                            <th class="wd-20p">Customer Name</th>
                            <th class="wd-15p">Customer Type </th>
                            <th class="wd-15p">Sales person </th>
                            <th class="wd-15p">Customer Mobile</th>
                            <th class="wd-15p">Customer Whatsapp</th>
                            <th class="wd-15p">Customer Other / PTCL</th>
                            <th class="wd-15p">Customer Email</th>
                            <th class="wd-15p none">Customer Address </th>
                            <th class="wd-15p none">Country </th>
                            <th class="wd-15p none">City </th>
                            <th class="wd-10p none">Created</th>
                            <th class="wd-10p none">Updated</th>
                            <th class="wd-10f none">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $key => $cus)
                        <?php
                            if (!empty($hotel['customer_image'])) {
                                $image = url('/uploads/customer_images/' . $hotel['customer_image']);
                            } else {
                                $image = url('/img/default_user.png');
                            }
                            $sale_person = \App\User::select('users.name')->where('id', '=', $cus->sale_person)->first();
                            $whatsapp_enabled = '';
                            if($cus->whatsapp_check == 1){
                                $whatsapp_enabled = '<img src="img/whatsapp.png" style="height:20px;width:20px;border-radius: 50%"
                                        alt="" srcset="">';
                            }
                            ?>
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td><img src="<?= $image ?>" style="height:20px;width:20px;border-radius: 50%"
                                        alt="" srcset=""></td>
                                <td>{{ $cus->customer_name }}</td>
                                <td>{{ $cus->customer_type }}</td>
                                <td><span style="text-decoration: underline;">{{ $sale_person?->name }}</span></td>
                                <td>{{ $cus->customer_cell }}<?= ' '.$whatsapp_enabled?></td>
                                <td>{{ $cus->customer_phone1 }}</td>
                                <td>{{ $cus->customer_phone2 }}</td>
                                <td>{{ $cus->customer_email }}</td>
                                <td>{{ $cus->customer_address }}</td>
                                <td>{{ $cus->country }}</td>
                                @php
                                    $get_city = App\cities::where('id', $cus->city_id)->first();

                                @endphp
                                <td>
                                    @if ($get_city != null)
                                        {{ $get_city->name }}
                                    @else
                                    @endif
                                </td>


                                <td><?= date('d-m-Y', strtotime($cus->created_at)) ?></td>
                                <td><?= date('d-m-Y', strtotime($cus->updated_at)) ?></td>
                                <td><a class="btn btn-rounded btn-primary"
                                        href="{{ url('customers/edit/' . Crypt::encrypt($cus->id_customers)) }}">
                                        Edit
                                    </a>
                                    <a class="btn btn-rounded btn-danger"
                                        href="{{ url('customers/destroy/' . Crypt::encrypt($cus->id_customers)) }}">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="wd-5-f">S.No</th>
                            <th class="wd-5-f">IM</th>
                            <th class="wd-20p">Customer Name</th>
                            <th class="wd-15p">Customer Type </th>
                            <th class="wd-15p">Sales person </th>
                            <th class="wd-15p">Customer Mobile</th>
                            <th class="wd-15p">Customer Whatsapp</th>
                            <th class="wd-15p">Customer Other / PTCL</th>
                            <th class="wd-15p">Customer Email</th>
                            <th class="wd-15p">Customer Address </th>
                            <th class="wd-15p">Country </th>
                            <th class="wd-15p">City </th>
                            <th class="wd-10p">Created</th>
                            <th class="wd-10p">Updated</th>
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
                    orderable: false,
                    targets: 0
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
