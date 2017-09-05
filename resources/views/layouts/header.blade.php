<nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 10px">
    <div class="container">
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav navbar-left">
                {{--<li ><a href="{{url('categories')}}">Discover</a></li>--}}
                @if (Auth::guest())
                    {{--<li ><a href="#">Pricing</a></li>--}}
                @else
                    {{--<li ><a href="#">Publish</a></li>--}}
                @endif
                {{--<li class="menu-item menu-search">--}}
                {{--<div class="search-wrapper">--}}
                {{--<form class="form-horizontal" role="form" method="POST" action="{{ url('/search') }}">--}}
                {{--{{ csrf_field() }}--}}
                {{--<div class="input-wrapper">--}}
                {{--<input name="q" type="text" placeholder="Search books..." required oninvalid="try{this.setCustomValidity('Enter Some Name')}" id="search_input" value="{{  $query or '' }}">--}}
                {{--</div>--}}
                {{--<input type="submit" class="button fa fa-search" value="&#xf002;">--}}
                {{--</form>--}}
                {{--</div>--}}
                {{--</li>--}}
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                <!-- Trigger the modal with a button -->

                @else
                    <li>
                        <a href="/search">Search</a>
                    </li>
                    <li>
                        <a href="/search/map">Nearby businesses</a>
                    </li>
                    <li>
                        <a href="{{url('/categories')}}"><i class="fa fa-list"></i> Categories</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="/myprofile">My profile</a>
                            </li>
                            <li>
                                <a href="/mybusinesses">My businesses</a>
                            </li>

                            <li>
                                <a href="/business/add">Add my business</a>
                            </li>

                            <li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
