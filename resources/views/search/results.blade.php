<?php
use Illuminate\Support\Str;
?>

@extends('layouts.app' ,['hidesearchform' => true] )

@section('content')
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


            <div class="col-sm-12 col-md-9 col-lg-9 mb-4">
                @if(count($businesses)>0)
                    <div class="row">
                        @foreach($businesses as $business)

                        <div class="col-xxs-12 col-xs-6 col-md-4 col-lg-3 mb-4">
                            <div class="card h-100 text-center">
                                <img src="{{$business->profilePic }}" alt="" class="card-img-top">
                                <div class="card-body"><h4 class="card-title">Team Member</h4>
                                    <h6 class="card-subtitle mb-2 text-muted">Position</h6>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus aut mollitia eum ipsum fugiat odio officiis odit.</p>
                                </div>
                                <div class="card-footer"><a href="#">name@example.com</a></div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <hr>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
                @include('search.section.search-sidebar')
                @include("search.section.categoriestab")
            </div>
            @endif

        </div>
    </div>

@endsection