<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    {{--Recaptch scripts--}}
    <script src='https://www.google.com/recaptcha/api.js'></script>

    @stack('header-scripts')
</head>
<body>
    <div id="app" class="fill">
        {{--Include the header--}}
        @include('layouts.header')

        @yield('content')

        {{--Include the footer--}}
        @include('layouts.footer')

    </div>


    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script src="/js/moment.js"></script>
    <script src="/js/jquery.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/bootstrap-material-datetimepicker.js"></script>
    <script src="/js/locationpicker.jquery.js"></script>

    @stack("footerscripts")
</body>
</html>
