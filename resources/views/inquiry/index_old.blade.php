@extends('layouts.master')
@section('content')
    <link href="{{ asset('/css/customstyle.css') }}" rel="stylesheet">
    <div class="az-content az-content-mail">
        <div class="container">
            <div class="content-wrapper w-100">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex pb-4 mb-4 border-bottom">
                                    <div class="d-flex align-items-center">
                                        {{-- <h5 class="page-title mb-n2">Open Tickets</h5> --}}
                                        {{-- <p class="mt-2 mb-n1 ms-3 text-muted">230 Tickets</p> --}}
                                    </div>
                                    <form class="ml-lg-auto d-flex pt-2 pt-md-0 align-items-stretch justify-content-end">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group" style="margin-right: 2px">
                                                    <label for="email">City</label>
                                                    {{-- <select name="city" id="">
                <option value=""></option>
                @forelse ($data[cities] as $city)
                <option value="{{$city->name}}">{{$city->name}}</option>
                @empty
                @endforelse
            </select> --}}
                                                    <input type="text" name="search" class="form-control "
                                                        id="city" placeholder="Search">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    {{-- {{dd($data["inquiry_type"])}} --}}
                                                    <label for="email">Inquiry Type</label>
                                                    {{-- <input type="text" name="search" class="form-control w-50" id="search" placeholder="Search"> --}}
                                                    <select name="inquiry_type" class="form-control" id="inquiry_type">
                                                        <option value="">Select</option>
                                                        @forelse ($data["inquiry_type"] as $inc_type)
                                                            <option value="{{ $inc_type->type_name }}">
                                                                {{ $inc_type->type_name }}
                                                            </option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group" style="margin-right: 2px">

                                                    <label for="email">Search</label>
                                                    {{-- <input type="text" name="search" class="form-control w-50" id="search" placeholder="Search"> --}}
                                                    <input type="text" name="search" class="form-control "
                                                        id="search" placeholder="Search">

                                                </div>
                                            </div>

                                        </div>


                                        {{-- <button type="submit" class="btn btn-success no-wrap ms-4">Search Ticket</button> --}}
                                    </form>
                                </div>
                                <div class="nav-scroller">
                                    <ul class="nav nav-tabs tickets-tab-switch" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link rounded active inquiry" id="all_inquiry" data-id=""
                                                data-bs-toggle="tab" href="#open-tickets" role="tab"
                                                aria-controls="open-tickets" aria-selected="true">All
                                                {{-- <div class="badge"></div> --}}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link rounded inquiry" id="active_inquiry" data-id="In-Progress"
                                                data-bs-toggle="tab" href="#pending-tickets" role="tab"
                                                aria-controls="pending-tickets" aria-selected="false">Process
                                                {{-- <div class="badge"></div> --}}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link rounded inquiry" data-id="Open" data-bs-toggle="tab"
                                                href="#onhold-tickets" role="tab" aria-controls="onhold-tickets"
                                                aria-selected="false">Pending
                                                {{-- <div class="badge"></div> --}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content border-0 tab-content-basic">
                                    <div class="tab-pane fade show active" id="open-tickets" role="tabpanel"
                                        aria-labelledby="open-tickets">
                                        @include('inquiry.pagination')





                                    </div>
                                    {{-- <div class="tab-pane fade" id="pending-tickets" role="tabpanel"
                                        aria-labelledby="pending-tickets">
                                        <div class="tickets-date-group"><i
                                                class="typcn icon typcn-calendar-outline"></i>Tuesday, 21 May 2019 </div>
                                        <a href="#" class="tickets-card row">
                                            <div class="tickets-details col-lg-8">
                                                <div class="wrapper">
                                                    <h5>#39045 - Design Admin Dashboard</h5>
                                                </div>
                                                <div class="wrapper text-muted d-none d-md-block">
                                                    <span>Assigned to</span>
                                                    <img class="assignee-avatar" src="../img/faces/face18.jpg"
                                                        alt="profile image">
                                                    <span>Luella Sparks</span>
                                                    <span><i class="typcn icon typcn-time"></i>12:54PM</span>
                                                </div>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <img class="img-xs rounded-circle" src="../img/faces/face6.jpg"
                                                    alt="profile image">
                                                <span class="text-muted">Hunter Garza</span>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <i class="category-icon typcn icon typcn-folder"></i>
                                                <span class="text-muted">Concept</span>
                                            </div>
                                        </a>
                                        <a href="#" class="tickets-card row">
                                            <div class="tickets-details col-lg-8">
                                                <div class="wrapper">
                                                    <h5>#39033 - Design Admin Dashboard</h5>
                                                    <div class="badge badge-success">New</div>
                                                </div>
                                                <div class="wrapper text-muted d-none d-md-block">
                                                    <span>Assigned to</span>
                                                    <img class="assignee-avatar" src="../img/faces/face13.jpg"
                                                        alt="profile image">
                                                    <span>Brett Gonzales</span>
                                                    <span><i class="typcn icon typcn-time"></i>03:34AM</span>
                                                </div>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <img class="img-xs rounded-circle" src="../img/faces/face16.jpg"
                                                    alt="profile image">
                                                <span class="text-muted">Frank Briggs</span>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <i class="category-icon typcn icon typcn-folder"></i>
                                                <span class="text-muted">Wireframe</span>
                                            </div>
                                        </a>
                                        <a href="#" class="tickets-card row">
                                            <div class="tickets-details col-lg-8">
                                                <div class="wrapper">
                                                    <h5>#29033 - Compose newsletter for the big launch</h5>
                                                    <div class="badge badge-success">New</div>
                                                </div>
                                                <div class="wrapper text-muted d-none d-md-block">
                                                    <span>Assigned to</span>
                                                    <img class="assignee-avatar" src="../img/faces/face17.jpg"
                                                        alt="profile image">
                                                    <span>Alta Little</span>
                                                    <span><i class="typcn icon typcn-time"></i>06:16PM</span>
                                                </div>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <img class="img-xs rounded-circle" src="../img/faces/face20.jpg"
                                                    alt="profile image">
                                                <span class="text-muted">Juan Little</span>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <i class="category-icon typcn icon typcn-folder"></i>
                                                <span class="text-muted">Concept</span>
                                            </div>
                                        </a>
                                        <a href="#" class="tickets-card row">
                                            <div class="tickets-details col-lg-8">
                                                <div class="wrapper">
                                                    <h5>#39040 - Website Redesign</h5>
                                                    <div class="badge badge-info">Pro</div>
                                                </div>
                                                <div class="wrapper text-muted d-none d-md-block">
                                                    <span>Assigned to</span>
                                                    <img class="assignee-avatar" src="../img/faces/face18.jpg"
                                                        alt="profile image">
                                                    <span>Olivia Cross</span>
                                                    <span><i class="typcn icon typcn-time"></i>04:23AM</span>
                                                </div>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <img class="img-xs rounded-circle" src="../img/faces/face14.jpg"
                                                    alt="profile image">
                                                <span class="text-muted">Frank Briggs</span>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <i class="category-icon typcn icon typcn-folder"></i>
                                                <span class="text-muted">Wireframe</span>
                                            </div>
                                        </a>
                                        <div class="tickets-date-group"><i
                                                class="typcn icon typcn-calendar-outline"></i>Tuesday, 20 Apr,2019 </div>
                                        <a href="#" class="tickets-card row">
                                            <div class="tickets-details col-lg-8">
                                                <div class="wrapper">
                                                    <h5>#29033 - Set up the marketplace strategy </h5>
                                                </div>
                                                <div class="wrapper text-muted d-none d-md-block">
                                                    <span>Assigned to</span>
                                                    <img class="assignee-avatar" src="../img/faces/face15.jpg"
                                                        alt="profile image">
                                                    <span>Mitchell Barber</span>
                                                    <span><i class="typcn icon typcn-time"></i>4:19AM</span>
                                                </div>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <img class="img-xs rounded-circle" src="../img/faces/face7.jpg"
                                                    alt="profile image">
                                                <span class="text-muted">Michael Campbell</span>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <i class="category-icon typcn icon typcn-folder"></i>
                                                <span class="text-muted">Wireframe</span>
                                            </div>
                                        </a>
                                        <a href="#" class="tickets-card row">
                                            <div class="tickets-details col-lg-8">
                                                <div class="wrapper">
                                                    <h5>#39041 - Bootstrap Framework not working</h5>
                                                    <div class="badge badge-info">Pro</div>
                                                </div>
                                                <div class="wrapper text-muted d-none d-md-block">
                                                    <span>Assigned to</span>
                                                    <img class="assignee-avatar" src="../img/faces/face11.jpg"
                                                        alt="profile image">
                                                    <span>Leah Frank</span>
                                                    <span><i class="typcn icon typcn-time"></i>04:24AM</span>
                                                </div>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <img class="img-xs rounded-circle" src="../img/faces/face10.jpg"
                                                    alt="profile image">
                                                <span class="text-muted">Emilie Barnett</span>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <i class="category-icon typcn icon typcn-folder"></i>
                                                <span class="text-muted">Deployed</span>
                                            </div>
                                        </a>
                                        <a href="#" class="tickets-card row">
                                            <div class="tickets-details col-lg-8">
                                                <div class="wrapper">
                                                    <h5>#29033 - Design Admin Dashboard</h5>
                                                    <div class="badge badge-success">New</div>
                                                </div>
                                                <div class="wrapper text-muted d-none d-md-block">
                                                    <span>Assigned to</span>
                                                    <img class="assignee-avatar" src="../img/faces/face13.jpg"
                                                        alt="profile image">
                                                    <span>Rhoda Jimenez</span>
                                                    <span><i class="typcn icon typcn-time"></i>01:27PM</span>
                                                </div>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <img class="img-xs rounded-circle" src="../img/faces/face10.jpg"
                                                    alt="profile image">
                                                <span class="text-muted">Maria Cook</span>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <i class="category-icon typcn icon typcn-folder"></i>
                                                <span class="text-muted">Deployed</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="tab-pane fade" id="onhold-tickets" role="tabpanel"
                                        aria-labelledby="onhold-tickets">
                                        <div class="tickets-date-group"><i
                                                class="typcn icon typcn-calendar-outline"></i>Tuesday, 21 May 2019 </div>
                                        <a href="#" class="tickets-card row">
                                            <div class="tickets-details col-lg-8">
                                                <div class="wrapper">
                                                    <h5>#39040 - Website Redesign</h5>
                                                </div>
                                                <div class="wrapper text-muted d-none d-md-block">
                                                    <span>Assigned to</span>
                                                    <img class="assignee-avatar" src="../img/faces/face18.jpg"
                                                        alt="profile image">
                                                    <span>Olivia Cross</span>
                                                    <span><i class="typcn icon typcn-time"></i>04:23AM</span>
                                                </div>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <img class="img-xs rounded-circle" src="../img/faces/face14.jpg"
                                                    alt="profile image">
                                                <span class="text-muted">Frank Briggs</span>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <i class="category-icon typcn icon typcn-folder"></i>
                                                <span class="text-muted">Wireframe</span>
                                            </div>
                                        </a>
                                        <a href="#" class="tickets-card row">
                                            <div class="tickets-details col-lg-8">
                                                <div class="wrapper">
                                                    <h5>#29033 - Design Admin Dashboard</h5>
                                                    <div class="badge badge-success">New</div>
                                                </div>
                                                <div class="wrapper text-muted d-none d-md-block">
                                                    <span>Assigned to</span>
                                                    <img class="assignee-avatar" src="../img/faces/face13.jpg"
                                                        alt="profile image">
                                                    <span>Rhoda Jimenez</span>
                                                    <span><i class="typcn icon typcn-time"></i>01:27PM</span>
                                                </div>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <img class="img-xs rounded-circle" src="../img/faces/face10.jpg"
                                                    alt="profile image">
                                                <span class="text-muted">Maria Cook</span>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <i class="category-icon typcn icon typcn-folder"></i>
                                                <span class="text-muted">Deployed</span>
                                            </div>
                                        </a>
                                        <a href="#" class="tickets-card row">
                                            <div class="tickets-details col-lg-8">
                                                <div class="wrapper">
                                                    <h5>#29033 - Compose newsletter for the big launch</h5>
                                                </div>
                                                <div class="wrapper text-muted d-none d-md-block">
                                                    <span>Assigned to</span>
                                                    <img class="assignee-avatar" src="../img/faces/face17.jpg"
                                                        alt="profile image">
                                                    <span>Alta Little</span>
                                                    <span><i class="typcn icon typcn-time"></i>06:16PM</span>
                                                </div>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <img class="img-xs rounded-circle" src="../img/faces/face20.jpg"
                                                    alt="profile image">
                                                <span class="text-muted">Juan Little</span>
                                            </div>
                                            <div class="ticket-float col-lg-2 col-sm-6">
                                                <i class="category-icon typcn icon typcn-folder"></i>
                                                <span class="text-muted">Concept</span>
                                            </div>
                                        </a>
                                    </div> --}}
                                </div>
                                {{-- <nav class="mt-4">
                                    <ul class="pagination">
                                        <li class="page-item">
                                            <a class="page-link" href="#">
                                                <i class="typcn icon typcn-chevron-left-outline"></i>
                                            </a>
                                        </li>
                                        <li class="page-item active">
                                            <a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">4</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">
                                                <i class="typcn icon typcn-chevron-right-outline"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- az-content -->

    <div class="az-mail-compose">
        <div>
            <div class="container">
                <div class="az-mail-compose-box">
                    <div class="az-mail-compose-header">
                        <span>New Message</span>
                        <nav class="nav">
                            <a href="" class="nav-link"><i class="fas fa-minus"></i></a>
                            <a href="" class="nav-link"><i class="fas fa-compress"></i></a>
                            <a href="" class="nav-link"><i class="fas fa-times"></i></a>
                        </nav>
                    </div><!-- az-mail-compose-header -->
                    <div class="az-mail-compose-body">
                        <div class="form-group">
                            <label class="form-label">To</label>
                            <div><input type="text" class="form-control" placeholder="Enter recipient's email address">
                            </div>
                        </div><!-- form-group -->
                        <div class="form-group">
                            <label class="form-label">Subject</label>
                            <div><input type="text" class="form-control"></div>
                        </div><!-- form-group -->
                        <div class="form-group">
                            <textarea class="form-control" rows="8" placeholder="Write your message here..."></textarea>
                        </div><!-- form-group -->
                        <div class="form-group mg-b-0">
                            <nav class="nav">
                                <a href="" class="nav-link" data-toggle="tooltip" title="Add attachment"><i
                                        class="fas fa-paperclip"></i></a>
                                <a href="" class="nav-link" data-toggle="tooltip" title="Add photo"><i
                                        class="far fa-image"></i></a>
                                <a href="" class="nav-link" data-toggle="tooltip" title="Add link"><i
                                        class="fas fa-link"></i></a>
                                <a href="" class="nav-link" data-toggle="tooltip" title="Emoticons"><i
                                        class="far fa-smile"></i></a>
                                <a href="" class="nav-link" data-toggle="tooltip" title="Discard"><i
                                        class="far fa-trash-alt"></i></a>
                            </nav>
                            <button class="btn btn-primary">Send</button>
                        </div><!-- form-group -->
                    </div><!-- az-mail-compose-body -->
                </div><!-- az-mail-compose-box -->
            </div><!-- container -->
        </div>
    </div><!-- az-mail-compose -->

    {{-- Modal  --}}
    <div class="modal fade hca-modal--clinical-quick-view" tabindex="-1" role="dialog"
        aria-labelledby="clinicalQuickViewModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="show_remarks_detail">

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {




            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).html();
                // alert(page)
                fetch_data(page, status);
            });


            var status = 0;
            $(".inquiry").on('click', function(event) {
                event.preventDefault();
                status = $(this).data('id');
                // fetch_data(1, status);

                let val = $("#search").val();
                let city = $("#city").val();
                let inquiry_type = $("#inquiry_type").find(":selected").val();
                // alert(city);
                $("#open-tickets").empty();

                // alert(val)
                $.ajax({
                    url: "{{ url('fetch_data') }}?q=" + val + "&city=" + city + "&status=" +
                        status + "&inquiry_type=" + inquiry_type,
                    type: "GET",
                    success: function(result) {
                        // if (result.length == 0) {
                        //     alert("No results found");
                        // }
                        $('#open-tickets').html(result);
                    }
                });



                // alert(status)
            });


            function fetch_data(page, status) {

                $.ajax({
                    url: "{{ 'fetch_data' }}/?page=" + page,
                    success: function(data) {
                        $('#open-tickets').html(data);
                    }
                });
            }

            // Search Work
            $("#search").keyup(function(e) {
                let val = $(this).val();
                let city = $("#city").val();
                let inquiry_type = $("#inquiry_type").find(":selected").val();

                // alert(inquiry_type);
                $("#open-tickets").empty();

                // alert(val)
                $.ajax({
                    url: "{{ url('fetch_data') }}?q=" + val + "&city=" + city + "&status=" +
                        status + "&inquiry_type=" + inquiry_type,
                    type: "GET",
                    success: function(result) {
                        // if (result.length == 0) {
                        //     alert("No results found");
                        // }
                        $('#open-tickets').html(result);
                    }
                });

            });


        });

        // Remarks Work
        function getListData(id) {


            $.ajax({
                type: "GET",
                url: "{{ url('/get_inquiry_remarks') }}/" + id,
                data: id,
                success: function(response) {
                    $('#show_remarks_detail').html(response);

                    $('.modal').modal('show');


                }
            });
        }

        function closeModal() {
            $('.modal').modal('hide');
        }
    </script>
@endpush
