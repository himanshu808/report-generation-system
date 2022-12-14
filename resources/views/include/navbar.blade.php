<nav class="navbar navbar-expand-md navbar-dark navbar-laravel bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @if(Auth::check())
                    @if(Auth::user()->type == 3)
                        <li class="nav-item active">
                            <a class="nav-link" href="/classes">Classes <span class="sr-only">(current)</span></a>
                        </li>
                    @endif
                    
                    <li class="nav-item active">
                            <a class="nav-link" href="/subjects">Subjects <span class="sr-only">(current)</span></a>
                    </li>
                    
                    <li class="nav-item active">
                            <a class="nav-link" href="/topics">Topics <span class="sr-only">(current)</span></a>
                    </li>

                    <li class="nav-item active">
                        <a class="nav-link" href="/leaves">Leaves <span class="sr-only">(current)</span></a>
                    </li>

                    @if(Auth::user()->type == 1 || Auth::user()->type == 2)
                        <li class="nav-item active">
                            <a class="nav-link" href="/lectures">Lectures <span class="sr-only">(current)</span></a>
                        </li>
                    @endif

                    @if(Auth::user()->type == 2 || Auth::user()->type == 3)
                        {{-- <li class="nav-item active">
                            <a class="nav-link" href="/reports">Reports <span class="sr-only">(current)</span></a>
                        </li> --}}
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown01">
                              <a class="dropdown-item" href="/reports">Monthly Report</a>
                              <a class="dropdown-item" href="/midterm">Midterm Report</a>
                            </div>
                        </li>
                    @endif

                @endif
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        @if (Route::has('register'))
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>