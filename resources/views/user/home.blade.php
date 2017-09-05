@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        @foreach($businesses as $business)
            <div class="col-md-6 mb-5">
                <div class="card-deck">
                    <div class="card">
                        <a href="{{url('/business/'.$business->id)}}">

                            <div class="profile-image-wrapper">
                                <img class="card-img-top" src="{{$business->profilePic }}" alt="Card image cap">

                            </div>
                            <div class="card-body">
                                <h4 class="card-title">{{$business->name }}</h4>
                                <p class="card-text">{{Str::limit($business->description, 140) }}</p>
                                <p class="card-text">Open from {{$business->openFromTime}} to {{$business->openUptoTime}}</p>

                            </div>
                        </a>

                        <div class="card-body">
                            <form>
                                <span>Rate this:</span>
                                <input id="input-{{$business->id}}" value="4" type="text" class="rating rating-input" data-min=0 data-max=5 data-step=0.5 data-size="xs" data-show-catption=false
                                       required title="">

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @push('scripts')
        <!-- Toastr -->
        <script src="js/plugins/toastr/toastr.min.js"></script>
    @endpush
@endsection