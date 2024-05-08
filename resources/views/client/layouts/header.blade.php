<header class="site-navbar js-sticky-header site-navbar-target" role="banner">

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
                            <a href="admissions.html" class="nav-link text-left">Listening</a>
                        </li>
                        <li>
                            <a href="courses.html" class="nav-link text-left">Reading</a>
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
                    </ul>
                    </ul>
                </nav>
            </div>
            <div class="ml-auto">
                <div class="align-items-center">
                    @guest
                    @if (Route::has('login'))
                    <a class="mr-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                    @endif

                    @if (Route::has('register'))
                    <a class="mr-3" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest

                    <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a>
                </div>
            </div>
        </div>
    </div>
</header>