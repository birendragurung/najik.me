<nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 10px">
    <div class="container">

        <div class="navbar-header">
            @if(Auth::user() && Auth::user()->isAdmin )
                <li class="visible-xs">
                    <a href="#" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
        @endif
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
                @if(Auth::user() && Auth::user()->isAdmin)
                    <li>
                        <a href="/admin/dashboard">Admin dashboard</a>
                    </li>
                @endif
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
                        {{--<a href="/search">Search</a>--}}
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
                            {{--<li>--}}
                            {{--<a href="/myprofile">My profile</a>--}}
                            {{--</li>--}}

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
