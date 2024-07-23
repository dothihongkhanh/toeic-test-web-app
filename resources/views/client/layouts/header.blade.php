<header class="site-navbar bg-white" style="position: sticky; top: 0px; max-width: 100%; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);" role="banner">
    <div class="container">
        <div class="d-flex align-items-center m-auto">
            <div class="site-logo">
                <a href="/" class="d-block">
                    <h2 class="text-primary"><b>Toeic</b>Study</h2>
                </a>
            </div>
            <div class="m-auto">
                <nav class="site-navigation position-relative text-right" role="navigation">
                    <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                        <li class="">
                            <a href="/" class="nav-link text-left">Trang chủ</a>
                        </li>
                        <li class="">
                            <a href="{{ route('client.listening.list') }}" class="nav-link text-left">Listening</a>
                        </li>
                        <li class="">
                            <a href="{{ route('client.reading.list') }}" class="nav-link text-left">Reading</a>
                        </li>
                        <li class="has-children ">
                            <a href="" class="nav-link text-left">Thông tin</a>
                            <ul class="dropdown">
                                <li><a href="/part">Part</a></li>
                                <li><a href="https://iigvietnam.com/vi/" target="_blank">IIG</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="ml-auto d-flex align-items-center">
                @guest
                @if (Route::has('login'))
                <a class="btn btn-primary mr-3 text-white font-weight-bold" href="{{ route('login') }}">{{ __('Đăng nhập') }}</a>
                @endif

                @if (Route::has('register'))
                <a class="btn btn-outline-primary font-weight-bold" href="{{ route('register') }}">{{ __('Đăng ký') }}</a>
                @endif
                @else
                <nav class="site-navigation position-relative text-right" role="navigation">
                    <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                        <li class="has-children">
                            <a id="navbarDropdown" class="nav-link text-left text-primary text-uppercase ml-3 font-weight-bold" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <ul class="dropdown" aria-labelledby="navbarDropdown">
                                <!-- <li><a href="{{ route('client.profile') }}">Thông tin cá nhân</a></li> -->
                                <li><a href="{{ route('client.statistical') }}">Thống kê kết quả luyện tập</a></li>
                                <li><a href="{{ route('client.showTimeNotify') }}">Đặt giờ nhắc nhở luyện tập</a></li>

                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Đăng xuất') }}
                                    </a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        </li>
                    </ul>
                </nav>
                @endguest
            </div>
            <div class="ml-auto d-lg-none">
                <div class="align-items-center">
                    <a href="#" class="d-inline-block  site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a>
                </div>
            </div>
        </div>
    </div>

</header>