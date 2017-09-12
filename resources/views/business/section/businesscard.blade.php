<?php
use Illuminate\Support\Str;

?>
<div class="col-md-12">
    @if(count($businesses)>0)
        @foreach($businesses as $business)
            <div class="col-md-6 mb-5 business-wrapper" business-id={{$business->id}} lat="{{$business->address->latitude }}" long="{{$business->address->longitude }}">
                <div class="card-deck">
                    <div class="card">
                        <a href="{{url('/business/'.$business->id)}}">
                            <div class="profile-image-wrapper">
                                <img class="card-img-top" src="{{$business->profilePic }}" alt="Card image cap"/>
                                @if($business->isVerified)
                                    <div class="verified-box">Verified</div>
                                @endif
                            </div>
                            <div class="card-body col-xs-12 col-sm-12 col-md-12">
                                <h4 class="card-title">{{$business->name }}</h4>
                                <h6><a href="/categories/{{$business->category->id}}">{{$business->categoryName }}</a></h6>
                                <p class="card-text">{{Str::limit($business->description, 100) }}</p>
                                <p class="card-text">Open from {{$business->openFromTime}} to {{$business->openUptoTime}}</p>
                            </div>
                        </a>

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
                </div>
            </div>
        @endforeach
    @endif
</div>