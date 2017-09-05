<?php
use Illuminate\Support\Str;

?>
@extends('layouts.app')


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
            <form id="map-search-form">
                {{--<label for="business-address">Business address</label>--}}
                {{--<input type="text" name="business_address_name" id="business-address"--}}
                {{--placeholder="Maitripath, Butwal">--}}
                <input hidden type="text" name="map_radius" id="map-radius" />
                <input hidden type="text" name="business_latitude" id="business-lat" />
                <input hidden type="text" name="business_longitude" id="business-lon" />
            </form>
        </div>
    </div>
</div>
<div class="col-md-12 map-container mb-5">
    <div class="row">

    </div>


</div>

<div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">{{ $metaSearchData['count'] > 0 ?'Search results for : ' . old('search_key'):""}}
        <small>Search results ( {{$metaSearchData['count']}} item/s found)</small>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/home">Home</a>
        </li>
        <li class="breadcrumb-item active">Search</li>
    </ol>

    <div class="row">
        <div class="col-md-9 col-lg-9 mb-4">
            @include("business.section.businesscard" ,['businesses' =>$businesses  ])
            <h2>Top rated businesses</h2>
            @include('business.section.businesscard',['businesses' => $popularBusinesses ])
            @if(count($businesses)>0)
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12 col-lg-offset-5">
                        <!-- Pagination -->
                        {{$businesses->links() }}
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-3 col-lg-3  col-sm-12 col-xs-12">
            @include('search.section.search-sidebar')
            @include('search.section.categoriestab')
        </div>
    </div>
</div>
@push('footerscripts')
@include('search.section.mapscripts')

@include('business.section.rate-scripts')
@endpush

@endsection