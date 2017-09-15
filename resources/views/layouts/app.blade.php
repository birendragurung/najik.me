<?php
use App\Category;

$categories = Category::all();
?>
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
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/jquery-ui.min.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/fonts/glyphicons-halflings-regular.woff2" />
    <link rel="stylesheet" id="listify-fonts-css" href="//fonts.googleapis.com/css?family=Karla%3Aregular%2Citalic%2C700&amp;ver=4.7.5#038;subset=latin" type="text/css" media="all">

    @stack('header-scripts')
    <link href="/css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
    <!-- optionally if you need to use a theme, then include the theme file as mentioned below -->
    <link href="/themes/krajee-svg/theme.css" media="all" rel="stylesheet" type="text/css" />

</head>
<body>
    <div id="app" class="fill">

        {{--Include the header--}}
        @include('layouts.header')


        {{--<div class="container">--}}
        {{--@include('search.section.form' , ['hideform' => isset($hidesearchform)?true:false])--}}{{--hidden parameter to determine whether to show search form or not--}}
        {{--</div>--}}


        <div class="flash-alert-container">
            @if(session()->has('flashMessage'))
                <div class='container alert alert-info fade in' id='flash-alert'>
                    {{session('flashMessage')}}
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                </div>
            @endif
        </div>

        <div class="flash-alert-container">
            @if(session()->has('message'))
                <div class='container alert alert-info fade in' id=''>
                    {{session('message')}}
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                </div>
            @endif
        </div>

        @yield('content')

        {{--Include the footer--}}
        @include('layouts.footer')

    </div>


    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script src="/js/moment.js"></script>
    <script src="/js/jquery.js"></script>
    <script src="/js/jquery-ui.js"></script>
    <script src="/js/bootstrap-material-datetimepicker.js"></script>
    <script src="/js/locationpicker.jquery.js"></script>
    <script src="/js/star-rating.js" type="text/javascript"></script>
    <script src="/js/jquery.form-validator.min.js" type="text/javascript"></script>

    <!-- optionally if you need to use a theme, then include the theme file as mentioned below -->
    <script src="/themes/krajee-svg/theme.js"></script>

    <script>
        function scroll_to(div){
            $('html, body').animate({
                scrollTop: $(div).offset().top
            },1000);
        }

        $(document).ready(function () {
            function toggleAlert() {
                $(".alert").toggleClass('in out');
                return false; // Keep close.bs.alert event from removing from DOM
            }

            {{--        @if(session()->has('flashMessage'))--}}
            {{--var messageBox = $("<div class='container alert alert-info fade in' id='flash-alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a></div>");--}}
            {{--$('#flash-alert-container').append(messageBox);--}}
            {{--var flashMsg = {{ session('flashMessage') or 'laskj' }};--}}
            {{--var element  = '<strong>Info:</strong>'.flashMsg;--}}
            {{--var alertBox = $('#flash-alert');--}}

            {{--alertBox.append(element);--}}
            {{--alertBox.removeClass('hidden');--}}
            {{--$("#btn").on("click", toggleAlert);--}}
            {{--alertBox.on('close.bs.alert', toggleAlert);--}}
            {{--@endif--}}
        })


    </script>
    @stack("footerscripts")



</body>
</html>
