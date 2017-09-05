<?php
use Illuminate\Support\Str;

?>

@extends('layouts.app' ,['hidesearchform' => true] )

@section('content')

@push('header-scripts')
        <!-- Magnific Popup CSS -->
<link href="/css/magnific-popup.css" rel="stylesheet">


<!-- Main CSS -->
<link href="/css/style-112.css" rel="stylesheet">

@endpush
<div class="row">
    <div id="map-box" class="col-md-12">
        <div id="search-map">
        </div>
        <div>
            <fieldset>
                {{--<label for="business-address">Business address</label>--}}
                {{--<input type="text" name="business_address_name" id="business-address"--}}
                {{--placeholder="Maitripath, Butwal">--}}
                <input hidden type="text" name="map_radius" id="map-radius" />
                <input hidden type="text" name="business_latitude" id="business-lat" />
                <input hidden type="text" name="business_longitude" id="business-lon" />
            </fieldset>
        </div>
    </div>
</div>
<div class="col-md-12 map-container mb-5">
    <div class="row">

    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-9 col-lg-9 mb-4">
            @include("business.section.businesscard" , ['businesses' =>$businesses ])
        </div>

        <div class="col-md-3 col-lg-3  col-sm-12 col-xs-12">
            @include('search.section.search-sidebar')
            @include("search.section.categoriestab")
        </div>

    </div>
</div>
@push('footerscripts')
<script>
    jQuery(document).ready(function () {
        @foreach($businesses as $business)
            $("#input-{{$business->id }}").rating({
            starCaptions: function (val) {
                if (val < 3) {
                    return val;
                } else {
                    return 'high';
                }
            },
            starCaptionClasses: function (val) {
                if (val < 3) {
                    return 'label label-danger';
                } else {
                    return 'label label-success';
                }
            },
            hoverOnClear: false
            /* starCaptions: {
             0.5: '0.5',
             1: '1',
             1.5: '1.5',
             2: '2',
             2.5: '2.5',
             3: '3',
             3.5: '3.5',
             4: '4',
             4.5: '4.5',
             5: '5'
             }*/
        });
        $("#input-{{$business->id }}").click(function () {
            alert('clicked');
            $.post("{{url('/business/rate/'.$business->id)}}",
                    {
                        'rating': $("#rating-{{$business->id}}}").val()
                    },
                    function (data, status) {
                        alert("Data: " + data + "\nStatus: " + status);
                    }
            );
        });
        $('#input-{{$business->id}}').on('rating.change', function (event, value, caption) {
            $.ajax({
                type: "GET",
                url: '{{url('business/rate/'.$business->id )}}',
                data: {rate: $('#input-{{$business->id}}').val()},
                success: function () {
                    alert('You have rated ' + $('#input-{{$business->id}}').val() + ' stars to ' + '{{$business->name}}');
                },
//                dataType: 'json'
            });
        });
        @endforeach
    $("#input-21f").rating({
            starCaptions: function (val) {
                if (val < 3) {
                    return val;
                } else {
                    return 'high';
                }
            },
            starCaptionClasses: function (val) {
                if (val < 3) {
                    return 'label label-danger';
                } else {
                    return 'label label-success';
                }
            },
            hoverOnClear: false
        });
        var $inp = $('#rating-input');

        $inp.rating({
            min: 0,
            max: 5,
            step: 1,
            size: 'lg',
            showClear: false
        });

        $('#btn-rating-input').on('click', function () {
            $inp.rating('refresh', {
                showClear: true,
                disabled: !$inp.attr('disabled')
            });
        });


        $('.btn-danger').on('click', function () {
            $("#kartik").rating('destroy');
        });

        $('.btn-success').on('click', function () {
            $("#kartik").rating('create');
        });

        $inp.on('rating.change', function () {
            alert($('#rating-input').val());
        });


    });

</script>
@include('search.section.mapscripts')
<script>
    $(document).ready(function () {
        $('.business-wrapper form i.glyphicon.glyphicon-minus-sign').each(function (i) {
            $(this).click(function () {
                $.ajax({
                    url: 'http://najikme.dev/business/rate/delete/' + $(this).parents('.business-wrapper').attr('business-id'),
                    method: 'get',
                    success: function () {
                        alert('deleted rate');
                    }
                });
            })
        });
    });
</script>

@endpush
@endsection