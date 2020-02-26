<nav class="navbar fixed-top navbar-expand-md navbar-light bg-white shadow-sm ">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            {{ config('app.name') }}
        </a>
        <button class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            @if(Auth::check())
                <ul class="navbar-nav  ">

                    <form class="row navbar-form ml-auto navbar-left" role="search"
                          action="{{ route('search.results') }}">
                        <div class="form-group my-auto">
                            <input type="text" name="query" class="form-control" placeholder="Look for...">
                        </div>
                        <button type="submit" class="btn btn-outline-info ml-sm-1">Search</button>
                    </form>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @if(Auth::check())

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.index', [
                                Auth::user()->id, Auth::user()->username
                                ]) }}">
                                {{ Auth::user()->name }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @endif
                </ul>
        </div>
    </div>
</nav>
