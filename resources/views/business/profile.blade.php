@extends('layouts.app')

@section('content')
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <h1 class="mt-4 mb-3">{{$business->name }}
            <small>{{$business->category->name}}</small>
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item active">About</li>
        </ol>

        <!-- Intro Content -->
        <div class="row">
            <div class="col-lg-6">
                <img class="img-fluid rounded mb-4" src="{{url($business->profilePic )}}" alt="">
            </div>
            <div class="col-lg-6">
                <h2>About: '{{$business->name}}'</h2>
                <pre style="white-space: pre-wrap; word-break: keep-all;    font-family: inherit;border: none; background-color: inherit;font-size: 1.1em;">{{$business->description }}</pre>
                <p><strong>Mobile:</strong> {{$business->mobile_number}}</p>
                <p><strong>Phone:</strong> {{$business->phone_number}}</p>
                <p><strong>Email:</strong>{{$business->email }}</p>

                <p><a href="{{$business->website }}">{{$business->website }}</a></p>
                @if(Auth::user() && (Auth::id() == $business->user->id ))
                    <a id="add-business-button" type="submit" value="Edit this business" class="btn btn-default">Edit this business</a>
                @endif
            </div>
        </div>
        <!-- /.row -->


        <div class="col-md-12 map-container">
            <div class="row">
                <div class="col-md-5"><h4>
                        Location :{{$business->address->address  }}, {{$business->address->town  }}</h4>
                </div>
            </div>
            <div class="row">
                <div id="map-box" class="col-md-12">
                    <div id="map" style="position: relative; overflow: hidden;">
                    </div>
                </div>
            </div>

        </div>

        <!-- Team Members -->
        <h2>Our Team</h2>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card h-100 text-center">
                    <img class="card-img-top" src="http://placehold.it/750x450" alt="">
                    <div class="card-body">
                        <h4 class="card-title">Team Member</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Position</h6>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus aut mollitia eum ipsum fugiat odio officiis odit.</p>
                    </div>
                    <div class="card-footer">
                        <a href="#">name@example.com</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card h-100 text-center">
                    <img class="card-img-top" src="http://placehold.it/750x450" alt="">
                    <div class="card-body">
                        <h4 class="card-title">Team Member</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Position</h6>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus aut mollitia eum ipsum fugiat odio officiis odit.</p>
                    </div>
                    <div class="card-footer">
                        <a href="#">name@example.com</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card h-100 text-center">
                    <img class="card-img-top" src="http://placehold.it/750x450" alt="">
                    <div class="card-body">
                        <h4 class="card-title">Team Member</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Position</h6>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus aut mollitia eum ipsum fugiat odio officiis odit.</p>
                    </div>
                    <div class="card-footer">
                        <a href="#">name@example.com</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <!-- Our Customers -->
        <h2>Our Customers</h2>
        <div class="row">
            <div class="col-lg-2 col-sm-4 mb-4">
                <img class="img-fluid" src="http://placehold.it/500x300" alt="">
            </div>
            <div class="col-lg-2 col-sm-4 mb-4">
                <img class="img-fluid" src="http://placehold.it/500x300" alt="">
            </div>
            <div class="col-lg-2 col-sm-4 mb-4">
                <img class="img-fluid" src="http://placehold.it/500x300" alt="">
            </div>
            <div class="col-lg-2 col-sm-4 mb-4">
                <img class="img-fluid" src="http://placehold.it/500x300" alt="">
            </div>
            <div class="col-lg-2 col-sm-4 mb-4">
                <img class="img-fluid" src="http://placehold.it/500x300" alt="">
            </div>
            <div class="col-lg-2 col-sm-4 mb-4">
                <img class="img-fluid" src="http://placehold.it/500x300" alt="">
            </div>
        </div>
        <!-- /.row -->


        @include('business.section.businessgallery')

        @include('business.section.images')
    </div>

    @push('footerscripts')
    @include('business.section.mapscripts' , ['address' =>$business->address  , 'markerDraggableDisable' => 'markerDraggable: false,    draggable: true,'  ])
    @endpush
@endsection