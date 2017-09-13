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
            <form action="/search/"></form>
            <select name="" id=""></select>
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


    <div class="container">
        <div class="row">
            <div class="col-md-9 col-lg-9 mb-4">
                @if(isset($businesses))
                    @include("business.section.businesscard" , ['businesses' =>$businesses ])
                @elseif(isset($promotedBusinesses))
                    <h2 class="mb-3">Featured businesses</h2>
                    @include("business.section.businesscard" , ['businesses' =>$promotedBusinesses ])
                    <h2 class="mb-3">Top rated businesses</h2>
                    @include('business.section.businesscard',['businesses' =>$topRatedBusinesses ])
                @endif
            </div>

            <div class="col-md-3 col-lg-3  col-sm-12 col-xs-12">
                @include('search.section.livesearch')
                @include("search.section.categoriestab")
            </div>

        </div>
    </div>

    @push('footerscripts')

        @include('search.section.mapscripts')

        @include('business.section.rate-scripts')

    @endpush
@endsection