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
        <div id="map-distance-range"></div>


    </div>
</div>

<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">{{ old('search_key') != null ?'Search results for : ' . old('search_key'):""}}
        <small>Search results ( {{$metaSearchData['count']<=1?$metaSearchData['count'] . ' item found':$metaSearchData['count'] . ' items found'}} )</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/home">Home</a>
        </li>
        <li class="breadcrumb-item active">Search</li>
    </ol>
    <div class="row">
        @if(!isset($promotedBusinesses))
        <div class="col-md-9 col-lg-9 mb-4">
            @include("business.section.businesscard" , ['businesses' =>$businesses ])
        </div>
        @else
            <div class="col-md-9 col-lg-9 mb-4">

                <h2>Featured businesses</h2>

                @include('business.section.businesscard',['businesses'=> $promotedBusinesses])

            </div>
        @endif
        <div class="col-sm-12 col-md-12 col-lg-3">
            @include('search.section.livesearch')
            @include("search.section.categoriestab")
        </div>

    </div>
</div>
@push('footerscripts')

@include('search.section.mapscripts')
@include('business.section.rate-scripts')
<script src="/js/plugins/rickshaw/rickshaw.min.js"></script>
<script>
    $( "#map-distance-range" ).slider();
</script>
@endpush
@endsection