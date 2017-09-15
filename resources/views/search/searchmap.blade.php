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
            <button id="locate-me-button" class="btn btn-default">
                <i class="fa fa-location-arrow" aria-hidden="true"></i>
                Find my location
            </button>

            <div id="search-map">
            </div>

            <div class="mt-5 mb-5 container">
                <div class="row">
                    <div class="col-md-6"><span class="mb-5">Select distance(in Km)</span>
                        <div id="map-distance-range" class="mt-5">
                            <div id="custom-handle" class="ui-slider-handle">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <select class="mt-3 mb-4 form-control" name="category" id="nearby-search-category">
                            @foreach(App\Category::all() as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        <div class="mt-3">
                            <input class="form-control" id="submit-nearby-search-button" type="submit" value="Search within this distance">
                        </div>
                    </div>
                </div>
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