<header class="site-navbar bg-white" style="position: sticky; top: 0px; max-width: 100%; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);" role="banner">

    <div class="container">
        <div class="d-flex align-items-center">
            <div class="site-logo">
                <a href="/" class="d-block">
                    <h2 class="text-primary"><b>Toeic</b>Study</h2>
                </a>
            </div>
            <div class="mr-auto">
                <nav class="site-navigation position-relative text-right" role="navigation">
                    <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                        <li class="active">
                            <a href="index.html" class="nav-link text-left">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('client.listening.list') }}" class="nav-link text-left">Listening</a>
                        </li>
                        <li>
                            <a href="{{ route('client.reading.list') }}" class="nav-link text-left">Reading</a>
                        </li>
                        <li>
                            <a href="courses.html" class="nav-link text-left">Full test</a>
                        </li>
                        <li class="has-children">
                            <a href="about.html" class="nav-link text-left">Information</a>
                            <ul class="dropdown">
                                <li><a href="teachers.html">Part</a></li>
                                <li><a href="about.html">IIG</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="contact.html" class="nav-link text-left">Contact</a>
                        </li>
                        @guest
                        @if (Route::has('login'))
                        <a class="btn btn-primary mr-3 text-white font-weight-bold" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @endif

                        @if (Route::has('register'))
                        <a class="btn btn-outline-primary mr-3 font-weight-bold" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                        @else
                        <li class="has-children">
                            <a id="navbarDropdown" class="nav-link text-left text-primary text-uppercase ml-3 font-weight-bold" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <ul class="dropdown" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a></li>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        </li>
                        @endguest
                    </ul>
                </nav>
            </div>
            <div class="ml-auto">
                <div class="align-items-center">
                    <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a>
                </div>
            </div>
        </div>
    </div>
</header>