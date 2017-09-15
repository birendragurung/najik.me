@extends('layouts.app' ,['hidesearchform'=>true ])

@section('content')

    <div class="row">
        <div id="map-box" class="map-container col-md-12">
            <button id="locate-me-button" class="btn btn-default">
                <i class="fa fa-location-arrow" aria-hidden="true"></i>
                Find my location
            </button>
            <div id="search-map"></div>

            <div class="mt-5 mb-5 container">
                <div class="row">
                    <div class="col-md-6"><span class="mb-5">Select distance(in Km)</span>
                        <div id="map-distance-range" class="mt-5">
                            <div id="custom-handle" class="ui-slider-handle">
                            </div>
                        </div></div>
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
                <form id="map-search-form">
                    {{--<label for="business-address">Business address</label>--}}
                    {{--<input type="text" name="business_address_name" id="business-address"--}}
                    {{--placeholder="Maitripath, Butwal">--}}
                    <input hidden type="text" name="map_radius" id="map-radius" />
                    <input hidden type="text" name="business_latitude" id="business-lat" />
                    <input hidden type="text" name="business_longitude" id="business-lon" />
                    <input hidden type="text" name="property_address" id="property-address" />
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12 map-container mb-5">
        <div class="row">

        </div>


    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-12">
                @include('search.section.livesearch')

                {{--            @include('search.section.search-sidebar')--}}
                @include('search.section.categoriestab')
            </div>
            <div class="col-md-9 col-lg-9 mb-4">
                <h2>Featured businesses</h2>
                @include('business.section.businesscard',['businesses'=> $promotedBusinesses])
            </div>

            <div class="col-md-12 col-lg-12 mb-4">

                <h2>Recent businesses</h2>

                {{--                @include('business.section.businesscard3col',['businesses'=> $recents])--}}

            </div>

        </div>

    </div>
    @push('footerscripts')
        @include('search.section.mapscripts',['businesses'=>$promotedBusinesses->merge($recents)])
        @include('business.section.rate-scripts')
    @endpush
@endsection