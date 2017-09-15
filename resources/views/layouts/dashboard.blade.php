<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NajikMe') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">


    <!-- CSS -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" type="text/css" />
    <link href="/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/ark/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" />
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="/ark/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <link href="/ark/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css" />
    <link href="/ark/select2/select2.css" rel="stylesheet" type="text/css" />
    <link href="/ark/select2/select2-bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="/ark/jquery.uniform/themes/default/css/uniform.default.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/ark/prettify.css" rel="stylesheet" type="text/css" />
    <link href="/ark/fullcalendar/dist/fullcalendar.css" rel="stylesheet" />
    <link href="/css/plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" media="print" />
    <link href="/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="/css/ark/ark.css" rel="stylesheet" type="text/css" />


    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    @stack('header-scripts')
</head>
<body class="cover">
    <div class="wrapper">
        {{--Include the header--}}
        @include('layouts.header')

        <!-- BODY -->
        <div class="body">

            @include('dashboard.sidebar')

            @yield('content')
        </div>
        <!-- END: BODY -->

        {{--Include the footer--}}
        @include('dashboard.footer')
    </div>
    <!-- Scripts -->
    {{--<script src="/js/app.js"></script>--}}
    {{--<script src="/js/moment.js"></script>--}}
    <script src="/js/jquery.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    {{--<script src="/js/bootstrap-material-datetimepicker.js"></script>--}}
    <script src="/js/locationpicker.jquery.js"></script>


    <!-- JS -->
    <script src="/js/moment.min.js"></script>
    {{--<script src="/ark/jquery-ui/js/jquery-ui.min.js"></script>--}}
    <script src="/ark/jquery.uniform/jquery.uniform.min.js"></script>
    <script src="/ark/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/ark/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
    <script src="/ark/jquery-autosize/jquery.autosize.min.js"></script>
    {{--<script src="/ark/momentjs/min/moment.min.js"></script>--}}
    <script src="/ark/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="/ark/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="/ark/dropzone/dist/min/dropzone.min.js"></script>
    <script src="/ark/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
    <script src="/ark/jquery-flot/jquery.flot.js"></script>
    <script src="/ark/jquery-flot/jquery.flot.pie.js"></script>
    <script src="/ark/jquery-flot/jquery.flot.stack.js"></script>
    <script src="/ark/jquery-flot/jquery.flot.resize.js"></script>
    <script src="/ark/jquery-flot/jquery.flot.time.js"></script>
    <script src="/ark/jquery-flot/jquery.flot.navigate.js"></script>
    <script src="/ark/select2/select2.min.js"></script>
    <script src="/ark/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="/ark/nestable/jquery.nestable.js"></script>
    <script src="/ark/ckeditor/ckeditor.js"></script>
    {{--<script src="/css/ark/prettify.js"></script>--}}
    {{--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABa3_QsifCyHhVppeEPPElKetaSh9Wkhs&callback=initMap"></script>--}}
    <script src="/js/plugins/dataTables/jquery.dataTables.min.js"></script>
    <script src="/js/ark.min.js"></script>
    {{--<script src="/js/ark.js"></script>--}}

    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src   = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-972204-19', 'around25.com');
        ga('send', 'pageview');

    </script>
    @stack("footerscripts")
</body>
</html>
