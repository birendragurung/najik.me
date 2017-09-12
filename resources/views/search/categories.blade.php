@extends('layouts.app')

@section('content')
    <div class="container">


        <div class="row">
            <div class="col-md-3 col-sm-5 col-xs-12">
                @include('search.section.livesearch')
                @include('search.section.categoriestab')
            </div>
            <div class="col-md-9">
                <div class="categories-wrapper">
                    <h2 class="text-center">Popular businesses</h2>
                    <div class="dock">
                        @include('business.section.businesscard',['businesses'=>$popularBusinesses ])
                    </div>
                </div>
            </div>

        </div>

    </div>

    @push('footerscripts')
    @include('business.section.rate-scripts')
    @endpush
@endsection