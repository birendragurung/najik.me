@extends('layouts.app')

@section('content')
    <div class="container">


        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-3">
                @include('search.section.search-sidebar')
                @include('search.section.categoriestab')
            </div>
            <div class="col-md-9">
                <div class="categories-wrapper">
                    <h2 class="text-center">Popular businesses</h2>
                    <div class="dock">

                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection