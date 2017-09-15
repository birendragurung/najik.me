@extends('layouts.app',['hideform'=>true ])
<?php
use App\Category;
use Illuminate\Support\Str;
$categories = Category::all();
?>
@section('categoriesSidebar')
    <!-- Sidebar Column -->
    <div class="col-lg-3 mb-4" xmlns="http://www.w3.org/1999/html">
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
        <link rel="stylesheet" href="/css/easy-responsive-tabs.css">

    @endpush
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="business-profile-wrapper" business-id={{$business->id}} lat="{{$business->address->latitude }}" long="{{$business->address->longitude }}">
                    <div class="card mt-4">
                        <div class="profile-image-wrapper">
                            <img class="card-img-top img-fluid" src="{{$business->profilePic }}" alt="{{$business->name}}" />
                            @if($business->isVerified)
                                <div class="verified-box">Verified</div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h3 class="card-title"><a href="/business/profile/{{$business->id}}">{{$business->name}}</a>
                            </h3>
                            <h4><a href="/category/{{$business->category->id}}">{{$business->categoryName}}</a></h4>

                            <button id="show-map" type="button" class="btn btn-lg" data-state = 'initial' onclick="slideMap()">Show map</button>

                            <div id="map"></div>
                            
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
                                    <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                        <p><i class="fa fa-mobile-phone "></i> {{$business->mobile_number }}</p>
                                        <p><i class="fa fa-phone-square "></i> {{$business->phone_number }}</p>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                        <p><i class="fa fa-at "></i> {{$business->email }}</p>
                                        <p><i class="fa fa-globe "></i>
                                            <a href="{{$business->website }}">{{$business->website }}</a></p>

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
                                    <div class="col-sm-12 col-md-12 col-lg-12 promote-business-form">
                                        <hr />

                                        <h3>Promote business</h3>
                                        @if($business->promotion && $business->promotion->status == 'requested')
                                            <h4>This business has been requested for promotion.</h4>
                                        @elseif($business->promotion && $business->promotion->status == 'active')
                                            <h4>This business has been promoted currently.</h4>
                                        @else
                                            <a href="#request-for-promotion" class="btn btn-default" id="request-for-promotion">Request for promotion</a>
                                            <div class="mt-2 col-sm-3 col-md-3 col-lg-3">
                                                <input class="form-control " id="promotion-period-days" type="number" value="10"> days
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                    <!-- /.card -->

                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">
                            Business reviews
                        </div>
                        <div class="card-body">
                            <div id="business-reviews">
                                @if(count($business->reviews)<1)
                                    <h4 class="no-reviews">No reviews</h4>
                                @endif
                                @foreach($business->reviews as $review )
                                    <div class="user-review" user-id={{$review->user->id}}>
                                        <p>{{$review->comment}}</p>
                                        <small class="text-muted">Posted by {{$review->user->name }} on {{$review->created_at->formatLocalized('%A %d, %B %Y') }}</small>
                                        @if($review->user->id == Auth::id()  )
                                            <i class="fa fa-minus-circle delete-review"></i>
                                            <i class="fa fa-edit edit-review"></i>
                                            <form id="business-review-edit-form" class="form-horizontal" action="/review/{{$business->id}}" method="post">
                                                {{csrf_field()}}
                                                <div class="form-group user-review-form-group">
                                                    <label for="user-review-box" class="col-md-4 control-label"></label>

                                                    <div class="col-md-6">
                                                        <textarea type="text" id="user-review-box" name="review_comment" class="form-control mb-3" required></textarea>
                                                    </div>
                                                    <div class="col-md-6 col-md-offset-4">
                                                        <button type="submit" href="#" class="btn btn-success">Edit Review</button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                        <hr>
                                    </div>
                                @endforeach
                            </div>
                            @if(Auth::user() && Auth::id() != $business->user->id )
                                <form id="business-review-form" class="form-horizontal" action="/review/{{$business->id}}" method="post">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <label for="user-review-box" class="col-md-4 control-label">Your review on this</label>

                                        <div class="col-md-6">
                                            <textarea type="text" id="user-review-box" name="review_comment" class="form-control mb-3" required></textarea>
                                        </div>
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" href="#" class="btn btn-success">Leave a Review</button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                            {{--is authenticated user | user is owner of business  |   business has reviews       | user has already reviewed business--}}
                            @if(Auth::user() && Auth::id() != $business->user->id && (count($business->reviews)>0 && $business->currentUserHasReview))
                                @push('footerscripts')
                                    <script>
                                        $(document).ready(function () {
                                            $('#business-review-form').hide();
                                        });
                                    </script>
                                @endpush
                            @endif
                        </div>
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
        @include('business.section.mapscripts',['address' => $business->address])
        @include('business.section.profile-rate-scripts')
        <script>
            $('#map').css({position:'absolute', top: '-1000px'});
            function slideMap() {
                var map = $('#map');
                if ($('#show-map').attr('data-state') === 'initial') {
                    $('#show-map').attr('data-state', "");
                    map.show();
                    map.css({position:'relative' , top:'0'});
                    scroll_to('#show-map', 1);

                }else if (map.is(':visible')) {
                    map.hide();
                    map.css({position:'absolute', top: '-1000px'});

                }
                else{
                    map.show();
                    map.css({position:'relative' , top:'0'});
                    scroll_to(map, 1);
                }
            }
        </script>
    @endpush
@endsection