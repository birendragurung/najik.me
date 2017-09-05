@extends('layouts.app')

@section('content')
    <div class="container container-fluid">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            @include('business.section.mybusinesses',['myBusinesses'=>$myBusinesses] )
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            @include('search.section.search-sidebar')
            @include('search.section.categoriestab')

        </div>
    </div>
@endsection