@extends('layouts.app',['hideform'=>true ])
<?php
use App\Category;
use Illuminate\Support\Str;
$categories = Category::all();
?>
@section('categoriesSidebar')
        <!-- Sidebar Column -->
<div class="col-lg-3 mb-4">
    <div class="list-group">
        @foreach($categories as $category)
            <a href="{!!url('/categories/' . $category->id . '/' . Str::slug($category->name,'-') )!!}" class="list-group-item">{{$category->name}}</a>
        @endforeach
    </div>
</div>
@endsection
@section('content')
@push('header-scripts')
        <!-- Easy Responsive Tabs -->
<link rel="stylesheet" href="css/easy-responsive-tabs.css">

@endpush
<div class="container">
    <div class="row">
        <div class="col-lg-9">

            <div class="card mt-4">
                <div class="profile-image-wrapper">
                    <img class="card-img-top img-fluid" src="{{$business->profilePic }}" alt="{{$business->name}}" />
                    @if($business->isVerified)
                        <div class="verified-box">Verified</div>
                    @endif
                </div>
                <div class="card-body">
                    <h3 class="card-title">{{$business->name}}</h3>
                    <h4>{{$business->categoryName}}</h4>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                <pre class="card-text" style="white-space: pre-wrap; word-break: keep-all;    font-family: inherit;border: none; background-color: inherit;font-size: 1.1em;">{{$business->description }}</pre>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                <p class="card-text">
                                    <i class="fa fa-1x fa-clock-o"></i> Open from {{$business->openFromTime}} to {{$business->openUptoTime}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-lg-3 mb-3">
                                <p><i class="fa fa-mobile-phone "></i> {{$business->mobile_number }}</p>
                                <p><i class="fa fa-phone-square "></i> {{$business->phone_number }}</p>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-lg-3 mb-3">
                                <p><i class="fa fa-at "></i> {{$business->email }}</p>
                                <p><i class="fa fa-globe "></i> <a href="{{$business->website }}">{{$business->website }}</a></p>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-lg-3 mb-3">
                            <span class="rating rate-as">{{$business->avgRating?$business->avgRating . "/5":"0"}}</span>
                            <h6>{{$business->rateCounts?($business->rateCounts<2)?$business->rateCounts .' user':$business->rateCounts.' users' : '0 user'}} </h6>
                        </div>
                        @if(Auth::user() && Auth::id() != $business->user->id)
                            <form class="col-sm-8 col-md-8 col-lg-9 mb-3 rating-form">
                                <input id="input-{{$business->id}}" value="{{$business->myRating}}" role="rating-input" type="text" class="rating rating-input" data-min=0 data-max=5 data-step=1 data-size="xs" data-show-catption=false required title="">
                            </form>
                        @elseif(Auth::user() && (Auth::id() == $business->user->id ))
                            <div class="col-sm-8 col-md-8 col-lg-9 mb-3">
                                <a href="/business/edit/{{$business->id}}" id="edit-business-button" type="submit" value="Edit my business" class="btn btn-default">Edit my business</a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
            <!-- /.card -->

            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    Product Reviews
                </div>
                <div class="card-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
                    <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                    <hr>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
                    <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                    <hr>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
                    <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                    <hr>
                    <form action="/post/review" method="post">
                        <input type="text" class="" name="review_comment" />
                        <button type="submit" href="#" class="btn btn-success">Leave a Review</button>
                    </form>
                </div>
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col-lg-9 -->
        <div class="col-lg-3">
            @include("search.section.search-sidebar")
            @include("search.section.categoriestab")
        </div>

    </div>
</div>
@include('business.section.mapmodal')

@push('footerscripts')
        <!-- Easy Responsive Tabs -->
@endpush
@endsection