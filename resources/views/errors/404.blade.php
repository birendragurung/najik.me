@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="main-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel error-panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-puzzle-piece"></i> Page Not Found</h3>
                        </div>
                        <div class="panel-body">
                            @if(isset($message))
                                <p>{{$message}}</p>
                            @else
                            <p>The page you are looking for does not exist.</p>
                            @endif
                            <p>You may have mistyped the address or the page may have moved.</p>
                            <p>
                                <a href="javascript: history.back()">Go back to the previous page</a> /
                                <a href="/">Go to the Home page</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection