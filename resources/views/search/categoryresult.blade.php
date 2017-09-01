<?php
use Illuminate\Support\Str;
?>
@extends('layouts.app')


@section('sidebarCategoryColumn')
        <!-- Sidebar Column -->
<div class="col-lg-12 mb-4">
    <div class="list-group">
        @foreach($categories as $category)
            <a href="{!!url('/categories/' . $category->id . '/' . Str::slug($category->name,'-') )!!}" class="list-group-item">{{$category->name}}</a>
        @endforeach
    </div>
</div>
@endsection

@section('content')
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <h1 class="mt-4 mb-3">{{ old('search_key') != null ?'Search results for : ' . old('search_key'):""}}
            <small>Search results ( {{$metaSearchData['count']}} item/s found)</small>
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/home">Home</a>
            </li>
            <li class="breadcrumb-item active">Search</li>
        </ol>

        <div class="row">
            <!-- Sidebar Column -->
            @yield('sidebarCategoryColumn')

            <div class="col-lg-9 mb-4">
                @if(count($businesses)>0)
                    @foreach($businesses as $business)

                    <!-- Project One -->
                    <div class="row">

                        <div class="col-md-7">
                            <a href="#">
                                <img class="img-fluid rounded mb-3 mb-md-0" src="{{url($business->profilePic )}}" alt="">
                            </a>
                        </div>
                        <div class="col-md-5">
                            <h3>{{$business->name }}</h3>
                            <p>{{$business->description }}</p>
                            <a class="btn btn-primary" href="#">View business
                                <span class="glyphicon glyphicon-chevron-right"></span></a>
                        </div>
                    </div>
                    <!-- /.row -->
                    <hr>

                    @endforeach
                    <hr>
                <!-- Pagination -->
                {{$businesses->links() }}
                @endif
            </div>


        </div>


    </div>
@endsection