@extends('layouts.app' ,['hidesearchform'=>true ])

@section('content')

<div class="row">
    <div id="map-box" class="col-md-12">
        <div id="search-map">


            <div class="col-md-12 map-container mb-5">
                <div class="row">
                    <div id="map-distance-range"></div>


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

            @include('business.section.businesscard3col',['businesses'=> $recents])

        </div>

    </div>

</div>
@push('footerscripts')
@include('business.section.mapscripts',['businesses'=>$promotedBusinesses->merge($recents)])
@include('business.section.rate-scripts')
@endpush
@endsection