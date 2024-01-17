@extends('layouts.master')
@section('content')
    <style>
        div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm {
            border: 0;
            border-radius: 0.25em;
            background: initial;
            background-color: #06b0c9;
            color: #fff;
            font-size: 1em;

        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered li{
            color:#000 !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('/lib/countrySelect.scss') }}">


     <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card card-body pd-40">
    <div class="az-content-breadcrumb ">
        <span>Inquiry</span>
        <span>Add Inquiry</span>
        {{-- <span>Forms</span> --}}
        {{-- <span>Form Layouts</span> --}}
    </div>
    <h2 class="az-content-title" style="display: inline">CREATE A NEW INQUIRY <span><a href="{{ url('inquiry') }}"
                class="btn btn-az-primary" style="float: right">Inquiry List</a></span></h2>

    <div class="az-content">
        <div class="container-fluid">

            <div class="az-content-body d-flex flex-column">
                <!--<div class="az-content-breadcrumb">-->
                <form action="{{ url('inquiry/store') }}" method="post" id="submit_inquiry">
                    <div id="wizard2" class="col-md-12">

                        <h3>Add Customer Details</h3>
                        <section>
                            <div class="row row-lg">
                                <div class="col-lg-4">

                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Start typing by name /
                                            contact number:</label>
                                        <input class="form-control" id="contact_search" type="search" placeholder="Search">
                                        <hr>
                                        <button class="btn btn-warning" onclick="clear_feilds()"
                                                id="clear_customer_information">Clear</button>
                                        <a href="#customer_div" class="btn btn-success d-none text-white "
                                           id="add_new_customer_btn">Add New Customer</a>

                                </div><!-- col -->
                                <div style="height:180px;overflow-y:scroll;border-left:1px solid #e3e7ed;" class='col-lg-4'
                                     id="search_result">

                                </div>

                                <div class="col-lg-3" id="customer_details" style="border-left:1px solid #e3e7ed;">
                                    <p class="az-content-label tx-11 tx-medium tx-gray-600" style="font-size:12px;">
                                        Customer: <span style="text-decoration: underline;"></span></p>
                                    <p class="az-content-label tx-11 tx-medium tx-gray-600" style="font-size:12px;">Contact#
                                        <span style="text-decoration: underline;"></span>
                                    </p>
                                    <p class="az-content-label tx-11 tx-medium tx-gray-600" style="font-size:12px;">Email:
                                        <span style="text-decoration: underline;"></span>
                                    </p>
                                    <p class="az-content-label tx-11 tx-medium tx-gray-600" style="font-size:12px;">Last Inquiry:
                                        <span style="text-decoration: underline;"></span>
                                    </p>
                                    <p class="az-content-label tx-11 tx-medium tx-gray-600" style="font-size:12px;">Status:
                                        <span style="text-decoration: underline;"></span>
                                    </p>
                                </div>
                                <div class="col-lg-1">
                                    <img src="{{ asset('img/user_icon_new.png') }}"
                                        style="height:100px;width:100px;border-radius: 50%;" />
                                </div>
                            </div><br>
                            <!--                            <p class="mg-b-20" style="color:orange">Add new customer instead ? Press Ctrl + delete to reset.
                                                                                                                                                                                                            </p>-->
                            <hr>
                            <h5>Add New Customer</h5>
                            <div class="row row-sm" id="customer_div">
                                <div class="col-lg-4 mg-t-20 mg-md-t-0">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Customer Name: <span
                                                style="color:red;">*</span></label>
                                        <input id="customer_name"
                                            onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9 ]/g, '')"
                                            class="form-control" data-parsley-id="7" required name="customer_name"
                                            placeholder="Full Name" type="text">
                                    </div><!-- col -->

                                </div>
                                <div class="col-md-4 mg-t-20 mg-md-t-0">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Customer
                                            Type</label>
                                        <select name="customer_type" id="customer_type" class="form-control">
                                            <option value="Individual">Individual</option>
                                            <option value="Group">Group</option>
                                            <option value="Corporate">Corporate </option>
                                        </select>

                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <!-- form-group -->
                                </div>

                                <div class="col-md-4 mg-t-20 mg-md-t-0">
                                    <div class="form-group">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600"><span> Customer Cell </span> <span
                                                style="color:red;">*</span> Whats-App <input
                                                type="checkbox" name="whatsapp_check">
                                        </label>


                                        <input type="tel" onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9]/g, '')"
                                            id="customer_cell" style="width: 100% !important" required
                                            class="form-control phone" style="margin-top:-10px;" name="customer_cell">
                                        <div class="invalid-feedback0"></div>
                                    </div>
                                </div>
                            </div><!-- row -->

                            <div class="row row-sm">
                                <div class="col-md-6">
                                    <div class="form-group ml-2 mt-2">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Contact -
                                            WhatsApp</label>
                                        <input type="text" id="whatsapp_number" class="form-control"
                                            name="customer_whatsapp">
                                        <div class="invalid-feedback1"></div>
                                    </div>
                                    <!-- form-group -->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ml-2 mt-2">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Contact - Other /
                                            PTCL</label>
                                        <input type="text" class="form-control" id="customer_phone_2"
                                            name="customer_phone_2">
                                        <div class="invalid-feedback2"></div>
                                    </div>
                                    <!-- form-group -->
                                </div>
                            </div><!-- row -->

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group ml-2 mt-2">
                                        <div class="form-group">
                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Customer
                                                Address</label>
                                            <input type="text" name="customer_address" id="customer_address"
                                                class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ml-2 mt-2">
                                        <div class="form-group">
                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Customer
                                                Email</label>
                                            <input type="text" name="customer_email" id="customer_email"
                                                class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <!--                                <div class="col-md-6">
                                                                <div class="form-group ml-2 mt-2">
                                                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Customer
                                                                        Reference</label>
                                                                    <input type="text" class="form-control" id="customer_reference"
                                                                        name="customer_reference">
                                                                    <div class="invalid-feedback"></div>
                                                                </div>
                                                                 form-group
                                                            </div>-->
                                <div class="col-md-12">
                                    <div class="form-group ml-2 mt-2">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Customer
                                            Details</label>
                                        <input type="text" class="form-control" id="customer_remarks"
                                            name="customer_details">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <!-- form-group -->
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group ml-2 mt-2">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Sales Person <span
                                                style="color:red;">*</span></label>
                                        <select name="sale_person" class="form-control" id="sale_person">
                                            <option>Select</option>
                                            @forelse ($sale_persons as $sp)
                                                <option value="{{ $sp['id'] }}">{{ $sp['name'] }}</option>
                                            @empty
                                                No Results Found
                                            @endforelse
                                        </select>

                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <!-- form-group -->
                                </div>
                            </div> --}}
                        </section>
                        <h3>Travel & Services Information</h3>
                        <section>
                            <div class="row row-sm">
{{--                                <div class="col-lg-12  mg-lg-t-0">
                                    <div class="form-group">

                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Campaign
                                            Reference</label>
                                        <select id="campaign" name="campaign" onchange="get_sales_reference()"
                                            class="form-control">
                                            <option>Select Campaign</option>
                                            @forelse ($campaigns as $campaign)
                                                <option value="{{ $campaign->id_campaigns }}">
                                                    {{ $campaign->campaign_name }}
                                                </option>
                                            @empty
                                                No Results Found
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
--}}
                                <div class="row mt-2">

                                    <div class=" rmv_service col-lg-5 mg-t-20 mg-lg-t-0">
                                        <div class="form-group">

                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Services: <span
                                                    style="color:red;">*</span></label>
                                            <select name="services[]" id="services" class="form-control service_dis"
                                                required>
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

                                    <div class="rmv_service col-lg-6 mg-t-20 mg-lg-t-0">
                                        <div class="form-group">

                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Sub
                                                Services:</label>
                                            <select style="width: 100%" name="sub_services[]" id="sub_services"
                                                class="js-example-basic-multiple service_dis" multiple="multiple">
                                                <option>Select Sub Service</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="rmv_service col-lg-1 mg-t-20 mg-md-t-0">
                                        {{-- <label class="az-content-label tx-11 tx-medium tx-gray-600">Add More</label> --}}
                                        <button onclick="add_more()" class="btn btn-az-primary mt-4" type="button">Add
                                            More</button>
                                    </div>

                                </div>
                                <div class="row" id="append_services">

                                </div>
                                {{-- <div class="row" id="append_services">

                                </div> --}}
                                <div class="row ">
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0 mt-2">
                                        <div class="form-group">

                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Inquiry Type: <span
                                                    style="color:red;">*</span></label>
                                            <select name="inquiry_type" id="inquiry_type" class="form-control" required>
                                                <option>Select Inquiry Type</option>
                                                @forelse ($inquiry_types as $inq_type)
                                                    <option value="{{ $inq_type->type_id }}">{{ $inq_type->type_name }}
                                                    </option>
                                                @empty
                                                    No Results Found
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mg-t-20 mg-md-t-0 mt-2">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Inquiry
                                            Category:</label>
                                        <select name="inquiry_category" class="form-control" required>
                                            <option value="">Select Inquiry Category</option>
                                            <option value="Economy">Economy</option>
                                            <option value="Standard">Standard</option>
                                            <option value="2 - Star">2 - Star</option>
                                            <option value="3 - Star">3 - Star</option>
                                            <option value="4 - Star">4 - Star</option>
                                            <option value="5 - Star">5 - Star</option>

                                        </select>
                                    </div>
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0 mt-2">
                                        <div class="form-group">

                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">Sale
                                                Reference</label>
                                            <select class="form-control" id="sale_reference" name="sale_reference"
                                                required>
                                                <option>Select</option>
                                                @forelse ($sales_reference as $sale_ref)
                                                    <option value="{{ $sale_ref->type_id }}">
                                                        {{ $sale_ref->type_name }}
                                                    </option>
                                                @empty
                                                    No Results Found
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mg-t-20 mg-md-t-0 mt-2">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Priority</label>
                                        <select name="priority" class="form-control">
                                            <option value="1">Priority 1</option>
                                            <option selected value="2">Priority 2</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-lg-4 mg-t-20 mg-lg-t-0 mt-2">
                                        <div class="form-group">
                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">No Of Adults <span
                                                    style="color:red;">*</span></label>
                                            <input type="number" min="1" minlength="1"
                                                onkeyup="if(this.value<0){this.value= this.value * -1}" required
                                                class="form-control" name="no_of_adults" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mg-t-20 mg-lg-t-0 mt-2">
                                        <div class="form-group">
                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">No Of
                                                Children</label>
                                            <input type="number" onkeyup="if(this.value<0){this.value= this.value * -1}"
                                                class="form-control" name="no_of_children">
                                        </div>

                                    </div>
                                    <div class="col-lg-4 mg-t-20 mg-lg-t-0 mt-2">
                                        <div class="form-group">

                                            <label class="az-content-label tx-11 tx-medium tx-gray-600">No Of
                                                Infants</label>
                                            <input type="number" onkeyup="if(this.value<0){this.value= this.value * -1}"
                                                class="form-control" name="no_of_infants">
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="row row-sm">
                                <div class="col-lg-6 mg-t-20 mg-md-t-0 mt-2">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Travel Date: <span
                                            style="color:red;">*</span></label>
                                    <input type="text" readonly name="travel_date" class="form-control fc-datepicker2"
                                        placeholder="MM/DD/YYYY" required  readonly/>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ml-2 mt-2">
                                        <label class="az-content-label tx-11 tx-medium tx-gray-600">Sales Person <span
                                                style="color:red;">*</span></label>
                                        @if ($get_permission_data['unassign_inquiry'] == 'true')
                                            <span class="tx-gray-600 float-end">
                                                UN ASSIGN <input class="sp_assign_check" id="sp_assign_check"
                                                    name="sp_assign_check" type="checkbox">
                                        @endif

                                        </span>
                                        @csrf
                                        @if ($get_permission_data['assign_others'] == 'true')
                                            <select name="sale_person" class="form-control" id="sale_person">
                                                <option>Select</option>
                                                @forelse ($sale_persons as $sp)
                                                    <option @if ($sp['id'] == auth()->user()->id) selected @endif
                                                        value="{{ $sp['id'] }}">{{ $sp['name'] }}</option>
                                                @empty
                                                    No Results Found
                                                @endforelse
                                            </select>
                                        @elseif($get_permission_data['assign_others'] == 'false')
                                            <select name="sale_person" class="form-control" id="sale_person">
                                                <option>Select</option>
                                                @forelse ($sale_persons as $sp)
                                                    <option @if ($sp['id'] == auth()->user()->id) selected @endif
                                                        value="{{ $sp['id'] }}">{{ $sp['name'] }}</option>
                                                @empty
                                                    No Results Found
                                                @endforelse
                                            </select>
                                        @endif
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <!-- form-group -->
                                </div>

                                <div class="col-lg-12 mg-t-20 mg-md-t-0 mt-2">
                                    <label class="az-content-label tx-11 tx-medium tx-gray-600">Remarks: <span
                                            class="text-danger">*</span></label>
                                    <input id="remarks" class="form-control" name="remarks" placeholder=""
                                        type="text" required>
                                </div>
                                <!--                            <div class="col-lg-2 mg-t-20 mg-md-t-0">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <input class="btn btn-primary" name="remarks" placeholder="" type="submit">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          </div>-->
                            </div>

                        </section>
                        <br>
                        <input type="hidden" name="" id="count_id">


                    </div>
                </form>
                <!--</div> az-content-body -->
            </div><!-- container -->
        </div><!-- az-content -->
            </div>
     </div></div>
    @endsection
    @push('scripts')
        <div id="append_js">

        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>


            mobiscroll.setOptions({
                theme: 'ios',
                themeVariant: 'light'
            });

            $(function() {
                var inst = $('#demo-country-picker').mobiscroll().select({
                    display: 'anchored',
                    filter: true,
                    itemHeight: 40,
                    renderItem: function(item) {
                        return '<div class="md-country-picker-item">' +
                            '<img class="md-country-picker-flag" src="https://img.mobiscroll.com/demos/flags/' +
                            item.data.value + '.png" />' +
                            item.display + '</div>';
                    }
                }).mobiscroll('getInst');

                $.getJSON('https://trial.mobiscroll.com/content/countries.json', function(resp) {
                    var countries = [];
                    for (var i = 0; i < resp.length; ++i) {
                        var country = resp[i];
                        countries.push({
                            text: country.text,
                            value: country.value
                        });
                    }
                    inst.setOptions({
                        data: countries
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {

                function check(input) {
                    if (input.value == 0) {
                        input.setCustomValidity('The number must not be zero.');
                    } else {
                        // input is fine -- reset the error message
                        input.setCustomValidity('');
                    }
                }

            });

            function check_validation(){
                var count_errors = 0;
                var message = ""
                var message2 = ""
                var message3 = ""
                var message4 = ""
                var message5 = ""
                var message6 = ""
                var message7 = ""
                if (!$('#customer_name').is(":disabled") && $('#customer_name').val().length < 1) {
                    message1 = "<li style='text-align:left;' class='text-danger'>Customer Name field is Empty</li>";
                    message += message1;
                    var count_errors = count_errors + 1
                }
                if (!$('#customer_cell').is(":disabled") && $('#customer_cell').val().length < 1) {
                    message2 = "<li style='text-align:left;' class='text-danger'>Customer field Cell is Empty</li>";
                    message += message2;
                    var count_errors = count_errors + 1
                }
                if ($('#inquiry_type').val() == "Select Inquiry Type") {
                    message3 = "<li style='text-align:left;' class='text-danger'>Inquiry Type field is Empty</li>";
                    var count_errors = count_errors + 1
                    message += message3;

                }
                if ($('#services').val() == "Select Services") {
                    message4 = "<li style='text-align:left;' class='text-danger'>Services field is Empty</li>";
                    message += message4;

                    var count_errors = count_errors + 1
                }
                // if ($('#sub_services').val().length < 1) {
                //     message5 = "<li style='text-align:left;' class='text-danger'>Sub Services is Empty</li>";
                //     message += message5;

                //     var count_errors = count_errors + 1
                // }
                if ($('input[name="travel_date"]').val().length < 1) {
                    message6 = "<li style='text-align:left;' class='text-danger' >Travel Date field is Empty</li>";
                    message += message6;
                    var count_errors = count_errors + 1
                }

                // alert($('input[name="no_of_adults"]').val())
                if ($('input[name="no_of_adults"]').val() < 1 || $('input[name="no_of_adults"]').val().length < 1) {
                    message9 = "<li style='text-align:left;' class='text-danger' >No. Of Adults field Cannot be 0</li>";
                    message += message9;
                    var count_errors = count_errors + 1
                }
                if ($('#sale_person').val().length < 1) {
                    message7 = "<li style='text-align:left;' class='text-danger'>Sales Person field is Empty</li>";
                    message += message7;
                    var count_errors = count_errors + 1
                }
                if ($('#remarks').val().length < 1) {
                    message8 = "<li style='text-align:left;' class='text-danger'>Remarks field is Empty</li>";
                    message += message8;
                    var count_errors = count_errors + 1
                }

                if (count_errors > 0) {
                    Swal.fire({
                        icon: 'error',
                        html: `${message}`,
                        showCloseButton: false,
                        focusConfirm: false,
                    })
                } else {
                    $('#submit_inquiry').submit();
                }


            }

            $(function() {
                // $('.fc-datepicker2').datepicker({
                //     showOtherMonths: true,
                //     selectOtherMonths: true,
                //     minDate: 0
                // });

                $('#wizard1').steps({
                    headerTag: 'h3',
                    bodyTag: 'section',
                    autoFocus: true,
                    titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>'
                });

                $('#wizard2').steps({
                    headerTag: 'h3',
                    bodyTag: 'section',
                    autoFocus: true,
                    titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>',
                    onStepChanging: function(event, currentIndex, newIndex) {
                        if (currentIndex < newIndex) {
                            // Step 1 form validation
                            if (currentIndex === 0) {
                                var fname = $('#customer_name').parsley();
                                var lname = $('#customer_cell').parsley();

                                if (fname.isValid() && lname.isValid()) {
                                    return true;
                                } else {
                                    fname.validate();
                                    lname.validate();
                                }
                            }
                            //
                            //              // Step 2 form validation
                            //              if(currentIndex === 1) {
                            //                var email = $('#email').parsley();
                            //                if(email.isValid()) {
                            //                  return true;
                            //                } else { email.validate(); }
                            //              }
                            // Always allow step back to the previous step even if the current step is not valid.
                        } else {
                            return true;
                        }
                    },
                    onFinished: function(event, currentIndex) {
                        if (currentIndex >= 1) { //if last step
                            //remove default #finish button
                            $('#wizard2').find('a[href="#finish"]').remove();
                            //append a submit type button
                            $('#wizard2 .actions li:last-child').append(
                                '<button type="button" onClick="check_validation()" id="btn_sub" class="btn btn-az-primary btn-block" style="float: right">Submit</button>'
                            );
                        }
                    },
                    onStepChanging: function(event, currentIndex, newIndex) {
                        if (currentIndex < newIndex) {
                            return true;
                            // Always allow step back to the previous step even if the current step is not valid.
                        } else {
                            return true;
                        }
                    }
                });

                $('#wizard3').steps({
                    headerTag: 'h3',
                    bodyTag: 'section',
                    autoFocus: true,
                    titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>',
                    stepsOrientation: 1
                });
            });
        </script>
        <script>
            // $('#clear_customer_information').click(function(e) {

            // });
            function clear_feilds() {
                var text1 =
                    '<p class="az-content-label tx-11 tx-medium tx-gray-600" style="font-size:12px;">Customer: <span style="text-decoration: underline;"></span></p>';
                var text2 =
                    '<p class="az-content-label tx-11 tx-medium tx-gray-600" style="font-size:12px;">Contact# <span style="text-decoration: underline;"></span></p>';
                var text3 =
                    '<p class="az-content-label tx-11 tx-medium tx-gray-600" style="font-size:12px;">Email: <span style="text-decoration: underline;"></span></p>';
                var text4 =
                    '<p class="az-content-label tx-11 tx-medium tx-gray-600" style="font-size:12px;">Last Inquiry: <span style="text-decoration: underline;"></span></p>';
                var text5 =
                    '<p class="az-content-label tx-11 tx-medium tx-gray-600" style="font-size:12px;">Status: <span style="text-decoration: underline;"></span></p>';

                $("#search_result").empty();
                $("#customer_details").empty().append(text1, text2, text3, text4, text5);
                $('#customer_name').addClass('disabled');
                $("#customer_name").prop('disabled', false);
                $('#customer_type').addClass('disabled');
                $("#customer_type").prop('disabled', false);
                $('#customer_cell').addClass('disabled');
                $("#customer_cell").prop('disabled', false);
                $('#whatsapp_number').addClass('disabled');
                $("#whatsapp_number").prop('disabled', false);
                $('#customer_phone_2').addClass('disabled');
                $("#customer_phone_2").prop('disabled', false);
                $('#customer_address').addClass('disabled');
                $("#customer_address").prop('disabled', false);
                $('#customer_email').addClass('disabled');
                $("#customer_email").prop('disabled', false);
                $('#customer_reference').addClass('disabled');
                $("#customer_reference").prop('disabled', false);
                $('#customer_remarks').addClass('disabled');
                $("#customer_remarks").prop('disabled', false);
                $('#sale_person').addClass('disabled');
                $("#sale_person").prop('disabled', false);
                $('#whatsapp_check').addClass('disabled');
                $("#whatsapp_check").prop('disabled', false);
            }
            $(document).ready(function() {

                //              $("#contact_search").keydown(function(){
                //                $("#search_result").html(' ');
                //              });

                $("#contact_search").keydown(function() { //
                    var typingTimer;
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(function() {
                        let val = $("#contact_search").val();
                        $.ajax({
                            url: "{{ url('customer_list') }}/" + val,
                            type: "GET",
                            success: function(result) {
                                if (result == " " && val.length >= 0) {
                                    $("#add_new_customer_btn").removeClass("d-none");
                                    console.log("Print");
                                } else {
                                    $("#add_new_customer_btn").addClass("d-none");
                                }
                                $("#search_result").empty().html(result);
                            }
                        });
                    }, 500);

                    // alert(val);



                });
                $("#add_new_customer_btn").click(function() {
                    let val = $("#contact_search").val();
                    if (isNaN(val)) {
                        $("#customer_name").val(val);
                    } else {
                        $("#customer_cell").val(val);
                    }

                });


                $('#search_result').on('click', '.clickable-data', function() {
                    // Handle the onclick event here
                    // You can access the clicked element using $(this)
                    var primaryId = $(this).data('id');
                    // alert(primaryId);
                    //                 alert('primaryId');
                    $.ajax({
                        url: '{{ url('get_customer_details') }}',
                        type: 'GET',
                        data: {
                            id: primaryId
                        },
                        success: function(response) {
                            $('#customer_details').empty().html(response);
                            $('#customer_name').addClass('disabled');
                            $("#customer_name").prop('disabled', true);
                            $('#customer_type').addClass('disabled');
                            $("#customer_type").prop('disabled', true);
                            $('#customer_cell').addClass('disabled');
                            $("#customer_cell").prop('disabled', true);
                            $('#whatsapp_number').addClass('disabled');
                            $("#whatsapp_number").prop('disabled', true);
                            $('#customer_phone_2').addClass('disabled');
                            $("#customer_phone_2").prop('disabled', true);
                            $('#customer_address').addClass('disabled');
                            $("#customer_address").prop('disabled', true);
                            $('#customer_email').addClass('disabled');
                            $("#customer_email").prop('disabled', true);
                            $('#customer_reference').addClass('disabled');
                            $("#customer_reference").prop('disabled', true);
                            $('#customer_remarks').addClass('disabled');
                            $("#customer_remarks").prop('disabled', true);
                            // $('#sale_person').addClass('disabled');
                            // $("#sale_person").prop('disabled', true);
                            $('#whatsapp_check').addClass('disabled');
                            $("#whatsapp_check").prop('disabled', true);

                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Existing Customer Selected",
                                showConfirmButton: false,
                                timer: 2500
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });


                });
            });
        </script>
        <script>
            // Additional code for adding placeholder in search box of select2


            $(document).ready(function() {


                $('.select2').select2({});

                $('#services').on('change', function() {
                    var val = $(this).val();
                    var val_text = $("#services option:selected").text();
                    var val_text_res = $.trim(val_text);
                    $.ajax({
                        url: "{{ url('get_sub_services') }}/" + val,
                        type: "GET",
                        success: function(data) {
                            $('#sub_services').html(data);
                            $('#inquiry_type  option').each(function(element) {
                                var get_text = $(this).text()
                                var get_text_res = $.trim($(this).text())
                                // alert(get_text_res)
                                // alert(val_text_res)
                                if (get_text_res == val_text_res) {
                                    exists = true;
                                    $(this).attr('selected', true);
                                }
                                //    alert(get_text==get_campaign)

                            });
                        }
                    });
                });




                $('#campaign').on('change', function() {
                    var val = $(this).val();


                    if (val == "Select Campaign") {
                        $('.rmv_service').css('display', 'block');
                        $('.service_dis').prop('disabled', false);
                        $('.service_dis').prop('disabled', false);
                        $('#append_services').html("");
                    } else {
                        $.ajax({
                            url: "{{ url('get_campaign_data') }}/" + val,
                            type: "GET",
                            success: function(data) {
                                // alert(data.);
                                // $('#sub_services').html(data);
                                $('#inquiry_type').val(data.inquiry_id);
                                $('#append_services').html(data.echo_services_data);
                                $('.service_dis').prop('disabled', true);
                                $('.service_dis').prop('disabled', true);
                                $('.rmv_service').css('display', 'none');
                                $('.js-example-basic-multiple').select2()

                            }
                        });
                    }
                    // alert(val);

                });

            });
        </script>

        <script>
            // Get Already Customer
            $("#phone0").on("keyup change", function(e) {
                let val = $(this).val();

                $.ajax({
                    url: "{{ url('check_customer_number') }}/" + val,
                    type: "GET",
                    data: {
                        number: val
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.getCell == true) {
                            alert('Customer already exists!');

                        }
                    }
                });

            });
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();

            });

            var counti = 0;





            function add_more() {
                counti = counti + 1;
                $.ajax({
                    url: "{{ url('add_more_services') }}/" + counti,
                    type: 'GET',
                    success: function(data) {
                        console.log(data.script)
                        $('#append_services').append(data.data);
                        // $('#append_js').append(data.script);
                        $('#count_id').val(counti);
                        $('.js-example-basic-multiple').select2()
                        $('#services' + counti).on('change', function() {
                            var val = $(this).val();
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
                counti = counti - 1;
                $('.rmv' + count_rmv).remove();
            }

            function get_sales_reference() {
                var get_campaign = $('#campaign').find(":selected").text();
                // var optionExists = $("#campaign option:contains('Bilal')");
                // var sale_reference = $('#sale_reference').find(get_campaign).selected();
                // alert(optionExists);
                $('#sale_reference  option').each(function(element) {
                    var get_text = $(this).text()
                    //    alert(get_text==get_campaign)
                    if (get_text == get_campaign) {
                        exists = true;
                        // console.log(this);
                        $(this).attr('selected', true);
                    }
                });
            }
        </script>
        <script>
            $(document).ready(function() {
                $("#sp_assign_check").click(function() {
                    if (this.checked == 1) {
                        $('#sale_person').prop('disabled', true);
                    } else {
                        $('#sale_person').prop('disabled', false);
                    }
                });
                $('.fc-datepicker2').datepicker({
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    dateFormat: 'dd-mm-yy',
                    minDate: 0,
                });
            });
        </script>

    @endpush
