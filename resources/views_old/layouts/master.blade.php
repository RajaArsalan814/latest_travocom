<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-90680653-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-90680653-2');
    </script>
    
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.png') }}">
    <!-- Twitter -->
    <!-- <meta name="twitter:site" content="@bootstrapdash">
    <meta name="twitter:creator" content="@bootstrapdash">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Azia">
    <meta name="twitter:description" content="Responsive Bootstrap 5 Dashboard Template">
    <meta name="twitter:image" content="https://www.bootstrapdash.com/azia/img/azia-social.png"> -->

    <!-- Facebook -->
    <!-- <meta property="og:url" content="https://www.bootstrapdash.com/azia">
    <meta property="og:title" content="Azia">
    <meta property="og:description" content="Responsive Bootstrap 5 Dashboard Template">

    <meta property="og:image" content="https://www.bootstrapdash.com/azia/img/azia-social.png">
    <meta property="og:image:secure_url" content="https://www.bootstrapdash.com/azia/img/azia-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600"> -->

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap 5 Dashboard Template">
    <meta name="author" content="BootstrapDash">

    <title>Travocom Lead Management CRM</title>
    @include('layouts.css')
</head>

<body onload="startTime()">
    @include('layouts.header')
    <div class="az-content pd-y-20 pd-lg-y-30 pd-xl-y-40">
        <div class="container-fluid">
            <div class="az-content-body  d-flex flex-column">
                @yield('content')
            </div>
        </div><!-- container -->
    </div><!-- az-content -->
    <!-- Container-fluid Ends-->

    <!-- footer start-->
    <audio   class="my_audio d-none" controls >
        <source src="{{asset('/noti_1.mp3')}}" >
    </audio>
    <button id="play_noti" class="d-none" onclick="play_audio('play')">Play</button>
    @include('layouts.footer')
    </div>

    <!-- latest jquery-->
    @include('layouts.script')
    {{-- @jquery
    @toastr_js
    @toastr_render --}}
    <!-- Plugin used-->

    <script type="text/javascript">
        if ($(".page-wrapper").hasClass("horizontal-wrapper")) {
            $(".according-menu.other").css("display", "none");
            $(".sidebar-submenu").css("display", "block");
        }
    </script>




    @stack('scripts')
    <script>
        $('.livesearch').select2({
            placeholder: 'Select',
            ajax: {
                url: "{{ route('autocomplete_country') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.country_name + ' - ' + item.name,
                                id: item.country_name + ' - ' + item.name,
                            }
                        })
                    };
                },
                cache: true
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();

            $('.fc-datepicker').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true
            });

            $('#datepickerNoOfMonths').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                numberOfMonths: 2
            });

            // AmazeUI Datetimepicker
            $('#datetimepicker').datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                autoclose: true
            });
            $('.datetimepickertime').datetimepicker({
                format: 'LT'
            });
            // jQuery Simple DateTimePicker
            $('#datetimepicker2').appendDtpicker({
                closeOnSelected: true,
                onInit: function(handler) {
                    var picker = handler.getPicker();
                    $(picker).addClass('az-datetimepicker');
                }
            });

            new Picker(document.querySelector('#datetimepicker3'), {
                headers: true,
                format: 'MMMM DD, YYYY HH:mm',
                text: {
                    title: 'Pick a Date and Time',
                    year: 'Year',
                    month: 'Month',
                    day: 'Day',
                    hour: 'Hour',
                    minute: 'Minute'
                },
            });
        });
    </script>
</body>

</html>
