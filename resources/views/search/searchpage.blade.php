@extends('layouts.app' ,['hidesearchform'=>true ])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
                <h2>Recommendations</h2>
                @foreach($recents as $business)
                    {{$business->name }}
                @endforeach

                <h2>Featured businesses</h2>
                @foreach($promotedBusinesses as $business)
                    {{$business->name }}<br>
                @endforeach
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
                @include('search.section.search-sidebar')
                @include('search.section.categoriestab')
            </div>
        </div>

    </div>@endsection