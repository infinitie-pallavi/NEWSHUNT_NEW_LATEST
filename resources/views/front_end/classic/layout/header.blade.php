@php
$title = ''
@endphp

    <!--  Search modal -->
    <div id="uc-search-modal" class="uc-modal-full uc-modal" data-uc-modal="overlay: true" data-autocomplete-url="{{ url('api/v1/posts/autocomplete') }}">
        <div class="uc-modal-dialog d-flex justify-center bg-white text-dark dark:bg-gray-900 dark:text-white" data-uc-height-viewport="">
            <button class="uc-modal-close-default p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all" type="button">
                <i class="unicon-close"></i>
            </button>
            <div class="panel w-100 sm:w-500px px-2 py-10">
                <h3 class="h1 text-center">{{__('SEARCH')}}</h3>
                <form class="hstack gap-1 mt-4 border-bottom p-narrow dark:border-gray-700" method="GET" id="search-form-data" action="{{ route('posts.search') }}" onsubmit="return modifyQuery(this)">
                    <span class="d-inline-flex justify-center items-center w-24px sm:w-40 h-24px sm:h-40px opacity-50">
                        <i class="unicon-search icon-3"></i>
                    </span>
                    <input type="search" name="search" id="globle_search" class="form-control-plaintext ms-1 fs-6 sm:fs-5 w-full dark:text-white"placeholder="Type your keyword.." aria-label="Search" autofocus>
                </form>
                <ul id="suggestions" class="suggestions-list"></ul>
            </div>
        </div>
    </div>
    <!--  Menu panel -->
<div id="uc-menu-panel" data-uc-offcanvas="overlay: true;">
    <div class="uc-offcanvas-bar bg-white text-dark dark:bg-gray-900 dark:text-white">
        <header class="uc-offcanvas-header hstack justify-between items-center pb-4 bg-white dark:bg-gray-900">
            <div class="uc-logo">
                <a href="{{ url('home') }}" class="h5 text-none text-gray-900 dark:text-white">
                    <img class="w-32px" src="{{ asset('front_end/classic/images/custom/LoginLight.png') }}"
                        alt="News Hunt" data-uc-svg>
                </a>
            </div>
            <button
                class="uc-offcanvas-close p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all"
                type="button">
                <i class="unicon-close"></i>
            </button>
        </header>

        <div class="panel">
            <form method="GET" action="{{ route('posts.search') }}" onsubmit="return modifyQuery(this)" class="form-icon-group vstack gap-1 mb-3">
                <input type="search" name="search" id="globle_search" class="form-control form-control-md fs-6" placeholder="Search..">
                <span class="form-icon text-gray">
                    <i class="unicon-search icon-1"></i>
                </span>
            </form>
            <ul class="nav-y gap-narrow fw-bold fs-5" data-uc-nav>
                <li class="uc-parent">
                    <a href="#">Channels</a>
                    <ul class="uc-nav-sub" data-uc-nav="">
                        @if (!empty($channels))
                            @foreach ($channels as $channel)
                                <li class="d-flex" title="{{ $channel->name ?? ''}}"><a href="{{url('channels/'.$channel->slug) }}" >{{ $channel->name ?? ''}}</a></li>
                            @endforeach
                        @endif
                        <li title="All Channels"><a href="{{url('channels')}}">All Channels</a></li>
                    </ul>
                </li>
                <li class="uc-parent">
                    <a href="#">Topics</a>
                    <ul class="uc-nav-sub" data-uc-nav="">
                        @if(!empty($topics))
                            @foreach ($topics as $topic)
                                <li title="{{ $topic->name ?? ''}}"><a href="{{url('topics/'.$topic->slug)}}">{{ $topic->name ?? ''}}</a></li>
                            @endforeach
                        @endif
                        <li title="All Topics"><a href="{{url('topics')}}">All Topics</a></li>
                    </ul>
                </li>
              
                <li title="Web Stories"><a href="{{url('webstories')}}">Web Stories</a></li>
                <li class="hr opacity-10 my-1"></li>
                <li title="All Posts"><a href="{{url('posts')}}">All Posts</a></li>
                <li title="Terms and conditions"><a href="{{url('terms-and-condition')}}">Terms and conditions</a></li>
                <li title="Privacy policy"><a href="{{url('privacy-policies')}}">Privacy policies</a></li>
                <li title="Contact us"><a href="{{url('contact-us')}}">Contact us</a></li>
                <li title="About us"><a href="{{url('about-us')}}">About us</a></li>
                @if (auth()->check())
                    <li title="Logout"><a href="{{ url('my-account') }}">My Account</a>
                    <li title="Logout"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                @else
                <li title="Login"><a class="uc-account-trigger position-relative btn btn-sm border-0 p-0 gap-narrow duration-0 dark:text-white" href="#uc-account-modal" data-uc-toggle>Login</a></li>
                <li title="Register"><a href="#uc-account-modal" class="open-signup-modal-mobile" data-uc-toggle>Register</a></li>

                @endif
            </ul>
            <ul class="social-icons nav-x mt-4">
                <li>
                    <a href="{{$socialMedia[27]['value'] ?? ''}}"><i class="unicon-logo-facebook icon-2"></i></a>
                    <a href="{{$socialMedia[26]['value'] ?? ''}}"><i class="unicon-logo-x-filled icon-2"></i></a>
                    <a href="{{$socialMedia[25]['value'] ?? ''}}"><i class="unicon-logo-instagram icon-2"></i></a>
                    <a href="{{$socialMedia[29]['value'] ?? ''}}"><i class="unicon-logo-youtube icon-2"></i></a>
                </li>
            </ul>
        </div>
    </div>
</div>

    <!--  Favorites modal -->
    <div id="uc-favorites-modal" data-uc-modal="overlay: true">
        <div class="uc-modal-dialog lg:max-w-500px bg-white text-dark dark:bg-gray-800 dark:text-white rounded">
            <button class="uc-modal-close-default p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all" type="button">
                <i class="unicon-close"></i>
            </button>
            <div class="panel vstack justify-center items-center gap-2 text-center px-3 py-8">
                <i class="icon icon-4 unicon-bookmark mb-2 text-primary dark:text-white"></i>
                <h2 class="h4 md:h3 m-0">Saved articles</h2>
                <p class="fs-5 opacity-60">You have not yet added any article to your bookmarks!</p>
                <a href="index.html" class="btn btn-sm btn-primary mt-2 uc-modal-close">Browse articles</a>
            </div>
        </div>
    </div>

    <!--  Newsletter modal -->
    @if($modelDatas['subscribe_model_status'] == '1')
        @if($news_hunt_letter !== null)
        <div id="uc-newsletter-modal" data-uc-modal="overlay: true">
            <div class="uc-modal-dialog w-800px bg-white text-dark dark:bg-gray-900 dark:text-white rounded overflow-hidden">
                <button class="uc-modal-close-default p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all" type="button">
                    <i class="unicon-close"></i>
                </button>
                <div class="row md:child-cols-6 col-match g-0">
                    @if($modelDatas['subscribe_model_image'])
                    <div class="d-none md:d-flex">
                        <div class="position-relative w-100 ratio-1x1">
                            <img class="media-cover" src="{{url('storage/'.$modelDatas['subscribe_model_image'] ?? '' )}}" alt="Newsletter img">
                        </div>
                    </div>
                    @endif
                        <div class="panel vstack self-center p-4 md:py-8 text-center">
                            <h3 class="h3 md:h2">{{$modelDatas['subscribe_model_title'] ?? '' }}</h3>
                            <p class="ft-tertiary">{{$modelDatas['subscribe_model_sub_title'] ?? '' }}</p>
                            <div class="panel mt-2 lg:mt-4">
                                <form class="vstack gap-1" method="post" action="{{ route('subscribe.store') }}">
                                 @csrf
                                    <input type="email" class="form-control form-control-sm w-full fs-6 bg-white dark:border-white dark:border-gray-700 dark:text-dark" name="email" placeholder="Your email address.." required="">
                                    <button type="submit" class="btn btn-sm btn-primary">Sign up</button>
                                </form>
                                <p class="fs-7 mt-2">Do not worry we don't spam!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif
{{-- Topics Follow model --}}
{{-- <div id="topics-follow-model" data-uc-modal="overlay: true">
    <div class="uc-modal-dialog w-800px bg-white text-dark dark:bg-gray-900 dark:text-white rounded overflow-hidden">
        <button class="uc-modal-close-default p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all" type="button">
            <i class="unicon-close"></i>
        </button>
        <div class="row md:child-cols-6 col-match g-0">
            <div class="panel vstack self-center p-4 md:py-8 text-center">
                <h3 class="h3 md:h2">Select Topics</h3>
                <div class="panel mt-2 lg:mt-4">
                    <form class="vstack gap-1" method="post" action="{{ route('subscribe.store') }}">
                        @csrf
                       <div class="mb-3">
                            <div class="form-selectgroup form-selectgroup-pills">
                                @foreach($topics as $topic)
                                <label class="form-selectgroup-item" style="position: relative; display: inline-block;">
                                  <input type="checkbox" name="name" value="HTML" class="form-selectgroup-input" checked="" style="position: absolute; top: 10; right: 10; z-index: 1;">
                                  <img id="topic-preview" src="{{ url('storage/images/'.$topic->logo) ?? asset('front_end/classic/images/avatars/04.png') }}" alt="Profile Preview" class="img-fluid mx-auto rounded-1-5 w-150px h-128px" style="display: block;">
                                  <span class="form-selectgroup-label" style="position: absolute; bottom: 10px; left: 10px; color: white; text-shadow: 1px 1px 2px black;">{{$topic->name}}</span>
                                </label>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary mt-2">Sign up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
{{-- Follow Channels --}}

    @if(session('first_login'))
        <div id="channels-follow-model" data-uc-modal="overlay: true">
            <div class="uc-modal-dialog w-800px bg-white text-dark dark:bg-gray-900 dark:text-white rounded overflow-hidden">
                <button class="uc-modal-close-default p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all" type="button">
                    <i class="unicon-close"></i>
                </button>
                <div class="row md:child-cols-6 col-match g-0">
                    <div class="panel vstack self-center p-4 text-center">
                        <h3 class="h3 md:h2">{{session('first_login')}}</h3>
                        <div class="panel mt-2 lg:mt-4">
                            <div class="mb-3">
                                <div class="form-selectgroup form-selectgroup-pills d-flex">
                                    @foreach($channels as $index => $channel)
                                        @if ($index < 1 )
                                            @continue
                                        @endif
                                        <label for="" class="row form-selectgroup-item">
                                            <div class="mx-h-72px mx-w-150px">
                                                <img id="profile-image-preview" src="{{ isset($channel->logo) ? url('storage/images/' . $channel->logo) : asset('front_end/classic/images/avatars/04.png') }}" alt="Profile Preview" class="h-72px img-fluid mx-auto rounded-1-5 w-150px">
                                            </div>
                                            <div>
                                                <button class="btn btn-primary mt-2 custom-btn-xs channel-follow" data-channel-id="{{ $channel->id }}">
                                                    Follow
                                                </button>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                <div class="d-flex justify-end">
                                    <button type="button" class="btn btn-sm btn-primary mt-2" id="done-button">Done</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!--  Account modal -->
<div id="uc-account-modal" data-uc-modal="overlay: true">
    <div class="uc-modal-dialog lg:max-w-500px bg-white text-dark dark:bg-gray-800 dark:text-white rounded">
        <button
            class="uc-modal-close-default p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all"
            type="button">
            <i class="unicon-close"></i>
        </button>
        <div class="panel vstack gap-2 md:gap-4 text-center">
            <ul class="account-tabs-nav nav-x justify-center h6 py-2 border-bottom d-none"
                data-uc-switcher="animation: uc-animation-slide-bottom-small, uc-animation-slide-top-small">
                <li><a href="#">Sign in</a></li>
                <li><a href="#">Sign up</a></li>
                <li><a href="#">Reset password</a></li>
                <li><a href="#">Terms of use</a></li>
            </ul>
            <div class="account-tabs-content uc-switcher px-3 lg:px-4 py-4 lg:py-8 m-0 lg:mx-auto vstack justify-center items-center">
                <div class="w-100">
                    <div class="panel vstack justify-center items-center gap-2 sm:gap-4 text-center">
                        <h4 class="h5 lg:h4 m-0">Log in</h4>
                        <div class="panel vstack gap-2 w-100 sm:w-350px mx-auto">
                            <form method="POST" action="{{ route('user.login') }}" id="login-modle-form" class="vstack gap-2">
                                @csrf
                                <div>
                                    <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-gray-800 dark:border-white dark:border-opacity-15" type="email" name="email" id="login-email" placeholder="Your email" required value="{{ old('email') }}">
                                    <span id="email-login-error" class="hstack text-primary d-none"></span>
                                </div>
                                
                                <div>
                                <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-gray-800 dark:border-white dark:border-opacity-15" type="password" name="password" id="login-password" placeholder="Password" autocomplete="new-password" required>
                                <span id="password-login-error" class="hstack text-primary d-none"></span>
                                </div>
                                <div class="hstack justify-between items-start text-start">
                                    <div class="form-check text-start">
                                        <input class="form-check-input rounded-0 dark:bg-gray-800 dark:border-white dark:border-opacity-15"
                                            type="checkbox" name="remember" id="inputCheckRemember">
                                        <label class="hstack justify-between form-check-label fs-7 sm:fs-6"
                                            for="inputCheckRemember">Remember me?</label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="uc-link fs-6">Forgot
                                        password</a>
                                </div>

                                <button class="btn btn-primary btn-sm lg:mt-1" id="login-form" type="submit">Log in</button>
                            </form>

                            <div class="panel h-24px">
                                <hr class="position-absolute top-50 start-50 translate-middle hr m-0 w-100">
                                <span
                                    class="position-absolute top-50 start-50 translate-middle px-1 fs-7 text-uppercase bg-white dark:bg-gray-800">Or</span>
                            </div>
                        </div>
                        <p class="fs-7 sm:fs-6">Have no account yet? <a class="uc-link" href="#"
                                data-uc-switcher-item="1">Sign up</a></p>
                    </div>
                </div>
                <div class="w-100">
                    <div class="panel vstack justify-center items-center gap-2 sm:gap-4 text-center">
                        <h4 class="h5 lg:h4 m-0">Create an account</h4>
                        <div class="panel vstack gap-2 w-100 sm:w-350px mx-auto">
                            <form class="vstack gap-2" action="{{route('user.register')}}" id="register-user-form" method="POST">
                                @csrf
                                <div>
                                    <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-gray-800 dark:border-white dark:border-opacity-15" name="name" id="name-register" type="text" placeholder="Full name">
                                    <span class="text-danger d-none" id="name-register-error"><span>
                                </div>
                                <div>
                                    <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-gray-800 dark:border-white dark:border-opacity-15" name="email" id="email-register" type="email" placeholder="Your email">
                                    <span class="text-danger d-none" id="email-register-error"><span>
                                </div>
                                <div>
                                    <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-gray-800 dark:border-white dark:border-opacity-15" name="password" id="password-register" type="password" placeholder="Password" autocomplete="new-password">
                                    <span class="text-danger d-none" id="password-register-error"><span>
                                </div>
                                <div>
                                    <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-gray-800 dark:border-white dark:border-opacity-15" name="password_confirmation" id="confirm-password-register" type="password" placeholder="Re-enter Password" autocomplete="new-password">
                                    <span class="text-danger d-none" id="confirm-password-register-error"><span>
                                </div>
                                <p class="fs-7 sm:fs-6" style="color: #E62323;">Min 8 chars, 1 upper, 1 lower, 1 number, 1 special.</p>
                                <div class="hstack text-start">
                                    <div class="form-check text-start">
                                        <input id="input_checkbox_accept_terms" class="form-check-input rounded-0 dark:bg-gray-800 dark:border-white dark:border-opacity-15" name="accept_terms" type="checkbox" >
                                        <label for="input_checkbox_accept_terms" class="hstack justify-between form-check-label fs-7 sm:fs-6">I read and accept the <a href="#" class="uc-link ms-narrow" data-uc-switcher-item="3">Terms and conditions</a>. </label>
                                    <span class="text-danger fw-bold d-none" id="check_terms">Please check before submit</span>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-sm lg:mt-1" id="register-form-button" type="submit">Sign up</button>
                            </form>
                        </div>
                        <p class="fs-7 sm:fs-6">Already have an account? <a class="uc-link" href="#"
                                data-uc-switcher-item="0">Log in</a></p>
                    </div>
                </div>
                <div class="w-100">
                    <div class="panel vstack justify-center items-center gap-2 sm:gap-4 text-center">
                        <h4 class="h5 lg:h4 m-0">Reset password</h4>
                        <div class="panel w-100 sm:w-350px">
                            <form class="vstack gap-2">
                                <input
                                    class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-gray-800 dark:border-white dark:border-opacity-15"
                                    type="email" placeholder="Your email" required>
                                <div class="form-check text-start">
                                    <input
                                        class="form-check-input rounded-0 dark:bg-gray-800 dark:border-white dark:border-opacity-15"
                                        type="checkbox" id="inputCheckVerify" required>
                                    <label class="form-check-label fs-7 sm:fs-6" for="inputCheckVerify"> <span>I'm not
                                            a robot</span>. </label>
                                </div>
                                <button class="btn btn-primary btn-sm lg:mt-1" type="submit">Reset a
                                    password</button>
                            </form>
                        </div>
                        <p class="fs-7 sm:fs-6 mt-2 sm:m-0">Remember your password? <a class="uc-link" href="#"
                                data-uc-switcher-item="0">Log in</a></p>
                    </div>
                </div>
                <div class="w-100">
                    <div class="panel vstack justify-center items-center gap-2 sm:gap-4">
                        <h4 class="h5 lg:h4 m-0">Terms and conditions</h4>
                        <div class="page-content panel fs-6 text-start max-h-400px overflow-scroll">
                            {!! $termsOfCondition->value ?? '' !!}</div>
                        <p class="fs-7 sm:fs-6">Do you agree to our terms? <a class="uc-link" href="#"
                                data-uc-switcher-item="1">Sign up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!--  GDPR modal -->
    <div id="uc-gdpr-notification" class="uc-gdpr-notification uc-notification uc-notification-bottom-left lg:m-2">
        <div class="uc-notification-message">
            <a id="uc-close-gdpr-notification" class="uc-notification-close" data-uc-close>{{""}}</a>
            <h2 class="h5 ft-primary fw-bold -ls-1 m-0">GDPR Compliance</h2>
            <p class="fs-7 mt-1 mb-2">We use cookies to ensure you get the best experience on our website. By continuing to
                use our site, you accept our use of cookies, <a href="{{url('/privacy-policies')}}"
                    class="uc-link text-underline">Privacy Policies</a>, and <a href="{{url('/terms-and-condition')}}"
                    class="uc-link text-underline">Terms of Service</a>.</p>
            <button class="btn btn-sm btn-primary" id="uc-accept-gdpr">Accept</button>
        </div>
    </div>

    <!--  Bottom Actions Sticky -->
    <div class="backtotop-wrap position-fixed bottom-0 end-0 z-99 m-2 vstack">
        <div class="darkmode-trigger cstack w-40px h-40px rounded-circle text-none bg-gray-100 dark:bg-gray-700 dark:text-white" data-darkmode-toggle="">
            <label class="switch">
                <span class="sr-only">Dark mode toggle</span>
                <input type="checkbox">
                <span class="slider fs-5"></span>
            </label>
        </div>
        <a class="btn btn-sm bg-primary text-white w-40px h-40px rounded-circle" href="to_top" data-uc-backtotop>
            <i class="icon-2 unicon-chevron-up"></i>
        </a>
    </div>

<!-- Header start -->
<header class="uc-header header-seven uc-navbar-sticky-wrap z-999" data-uc-sticky="sel-target: .uc-navbar-container; cls-active: uc-navbar-sticky; cls-inactive: uc-navbar-transparent; end: !*;">
    <nav class="uc-navbar-container text-gray-900 dark:text-white fs-6 z-1">
        <div class="uc-top-navbar panel z-3 overflow-hidden bg-primary-600 swiper-parent" data-uc-navbar=" animation: uc-animation-slide-top-small; duration: 150;">
            <div class="container container-full">
                <div class="uc-navbar-item">
                    <div class="swiper swiper-ticker swiper-ticker-sep px-2" data-uc-swiper="items: auto; gap: 32; center: true; center-bounds: true; autoplay: 10000; speed: 10000; autoplay-delay: 0.1; loop: true; allowTouchMove: false; freeMode: true; autoplay-disableOnInteraction: true;">
                        <div class="swiper-wrapper">
                            @foreach ($headerPosts as $headerpost)
                                <div class="swiper-slide text-white">
                                    <div class="type-post post panel">
                                        <a href="{{ url('posts/' . $headerpost->slug) }}"
                                            class="fs-7 fw-normal text-none text-inherit">{{ $headerpost->title }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uc-center-navbar panel hstack z-2 min-h-48px d-none lg:d-flex" data-uc-navbar=" animation: uc-animation-slide-top-small; duration: 150;">
            <div class="container max-w-xl">
                <div class="navbar-container hstack border-bottom">
                    <div class="uc-navbar-center gap-2 lg:gap-3 flex-1">
                        <ul class="uc-navbar-nav gap-3 justify-between flex-1 fs-6 fw-bold">
                            <li>
                                <a href="#"><span class="icon-1 unicon-finance"></span></a>
                                <div class="uc-navbar-dropdown ft-primary text-unset p-3 pb-4 rounded-0 hide-scrollbar" data-uc-drop=" offset: 0; boundary: !.navbar-container; stretch: x; animation: uc-animation-slide-top-small; duration: 150;">
                                    <div class="row child-cols col-match g-2">
                                        <div class="col-2">
                                            <ul class="uc-nav uc-navbar-dropdown-nav">
                                                @foreach($topics as $index => $topic)
                                                    @if ($index < 0 || $index > 4)
                                                        @continue
                                                    @endif
                                                    <li><a href="{{ url('topics/'.$topic->slug) }}">{{$topic->name}}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="col-2">
                                            <ul class="uc-nav uc-navbar-dropdown-nav">
                                                @foreach($topics as $index => $topic)
                                                    @if ($index < 5 || $index > 9)
                                                        @continue
                                                    @endif
                                                    <li><a href="{{ url('topics/'.$topic->slug) }}">{{$topic->name}}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="col-2">
                                            <ul class="uc-nav uc-navbar-dropdown-nav">
                                              
                                            </ul>
                                        </div>
                                        <div class="col-2">
                                            <ul class="uc-nav uc-navbar-dropdown-nav">
                                               
                                            </ul>
                                        </div>
                                        <div>
                                            <div class="uc-navbar-newsletter panel vstack">
                                                <h6 class="fs-6 ft-tertiary fw-medium">News Hunt</h6>
                                                <form class="hstack gap-1 bg-gray-300 bg-opacity-10"  method="post" action="{{ route('subscribe.store') }}">
                                                    @csrf
                                                    <input type="email"
                                                        class="form-control-plaintext form-control-xs fs-6 dark:text-white"
                                                        placeholder="Your email address..">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-primary fs-6 rounded-0">Subscribe</button>
                                                </form>
                                                <p class="fs-7 mt-1">Do not worry, we don't spam!</p>
                                                <ul class="nav-x gap-2 mt-3">
                                                    <li><a href="{{$socialMedia[27]['value'] ?? ''}}"><i class="icon icon-2 unicon-logo-facebook"></i></a></li>
                                                    <li><a href="{{$socialMedia[26]['value'] ?? ''}}"><i class="icon icon-2 unicon-logo-x-filled"></i></a></li>
                                                    <li><a href="{{$socialMedia[25]['value'] ?? ''}}"><i class="icon icon-2 unicon-logo-instagram"></i></a></li>
                                                    <li><a href="{{$socialMedia[29]['value'] ?? ''}}"><i class="icon icon-2 unicon-logo-youtube"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#">{{ __('CHANNELS')  }} <span data-uc-navbar-parent-icon></span></a>
                                <div class="uc-navbar-dropdown ft-primary text-unset p-3 pb-4 rounded-0 hide-scrollbar"
                                    data-uc-drop=" offset: 0; boundary: !.navbar-container; stretch: x; animation: uc-animation-slide-top-small; duration: 150;">
                                    <div class="row col-match g-2">
                                        <div class="w-1/5">
                                            <div class="uc-navbar-switcher-nav border-end">
                                                <ul class="uc-tab-left fs-6" data-uc-tab="connect: #uc-navbar-switcher-tending; animation: uc-animation-slide-right-small, uc-animation-slide-left-small">
                                                    @foreach ($channels as $channel)
                                                         <li class="d-flex justify-between align-items-center">
                                                            <a class="text-start" href="#">{{ $channel->name }}</a>
                                                            <a href="{{url('channels/'.$channel->slug)}}"><i class="bi bi-chevron-right"></i></a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="w-4/5">
                                            <div id="uc-navbar-switcher-tending" class="uc-navbar-switcher uc-switcher">
                                                @foreach ($channels as $channel)
                                                    <div>
                                                        <div class="row child-cols col-match g-2">
                                                            @foreach ($channel->posts as $fistChannelPost)
                                                                <div>
                                                                    <article class="post type-post panel uc-transition-toggle vstack gap-1">
                                                                        <div class="post-media panel overflow-hidden">
                                                                            <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9">
                                                                                <a href="{{ url('posts/' . $fistChannelPost->slug) }}" class="position-cover">
                                                                                     @if($fistChannelPost->type != "video")
                                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ $fistChannelPost->image ?? '' }}" data-src="{{ $fistChannelPost->image ?? '' }}" alt="{{ $fistChannelPost->title ?? '' }}" title="{{ $fistChannelPost->title ?? '' }}" data-uc-img="loading: lazy">
                                                                                    @else
                                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ $fistChannelPost->video_thumb ?? '' }}" data-src="{{ $fistChannelPost->video_thumb ?? '' }}" alt="{{ $fistChannelPost->title ?? '' }}" title="{{ $fistChannelPost->title ?? '' }}" data-uc-img="loading: lazy">
                                                                                        <div class="post-category hstack gap-narrow justify-center align-items-center text-white">
                                                                                            <a class="text-none" href="{{url('posts/'.$fistChannelPost->slug)}}" title="{{ $fistChannelPost->title }}"><i class="bi bi-play-circle font-size-45"></i></a>
                                                                                        </div>
                                                                                    @endif
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="post-header panel vstack gap-narrow">
                                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                                <a class="text-none hover:text-primary duration-150"
                                                                                   href="{{ url('posts/' . $fistChannelPost->slug) }}" title="{{ $fistChannelPost->title ?? '' }}">{{ $fistChannelPost->title ?? '' }}</a>
                                                                            </h3>
                                                                            <div class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1 d-none md:d-block">
                                                                                <div>
                                                                                    <div class="post-date hstack gap-narrow">
                                                                                        <span title="{{$fistChannelPost->publish_date_news ?? ''}}">{{ $fistChannelPost->publish_date ?? '' }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div>·</div>
                                                                                <div>
                                                                                    <a href="{{ url('posts/' . $fistChannelPost->slug) }}#comment-form" class="post-comments text-none hstack gap-narrow" title="commets">
                                                                                        <i class="icon-narrow unicon-chat"></i>
                                                                                        <span>{{ $fistChannelPost->comment ?? '' }}</span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </article>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="text-end mt-1">
                                                            <a href="{{url('channels/'.$channel->slug)}}" class="text-black dark:text-white text-none fw-bold" title="See more">See more <i class="bi bi-chevron-right"></i></a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="{{ url('webstories') }}">Web Stories</a>
                            </li>
                            @foreach ($topics as $topic)
                            <li>
                                <a href="#">{{$topic->name}}<span data-uc-navbar-parent-icon></span></a>
                                <div class="uc-navbar-dropdown ft-primary text-unset p-3 pb-4 rounded-0 hide-scrollbar" data-uc-drop="offset: 0; boundary: !.navbar-container; stretch: x; animation: uc-animation-slide-top-small; duration: 150;">
                                    <div>
                                        <div class="row child-cols col-match g-2">
                                            @if ($topic->posts->isNotEmpty())
                                                @foreach ($topic->posts as $lifestylePosts)

                                                    <div>
                                                        <article class="post type-post panel uc-transition-toggle vstack gap-1">
                                                            <div class="post-media panel overflow-hidden">
                                                                <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9">
                                                                    <a href="{{ url('posts/' . $lifestylePosts->slug) }}" class="position-cover">
                                                                    @if($lifestylePosts->type != "video")
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ $lifestylePosts->image ?? '' }}" data-src="{{ $lifestylePosts->image ?? '' }}" alt="{{ $lifestylePosts->title ?? '' }}" title="{{ $lifestylePosts->title ?? '' }}" data-uc-img="loading: lazy">
                                                                    @else
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ $lifestylePosts->video_thumb ?? '' }}" data-src="{{ $lifestylePosts->video_thumb ?? '' }}" alt="{{ $lifestylePosts->title ?? '' }}" title="{{ $lifestylePosts->title ?? '' }}" data-uc-img="loading: lazy">
                                                                        <div class="post-category hstack gap-narrow justify-center align-items-center text-white">
                                                                            <a class="text-none" href="{{url('posts/'.$lifestylePosts->slug)}}" title="{{ $lifestylePosts->title }}"><i class="bi bi-play-circle font-size-45"></i></a>
                                                                        </div>
                                                                    @endif
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="post-header panel vstack gap-narrow">
                                                                <h3 class="post-title h6 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150" href="{{ url('posts/' . $lifestylePosts->slug) }}" title="{{ $lifestylePosts->title ?? '' }}">{{ $lifestylePosts->title ?? '' }}</a>
                                                                </h3>
                                                                <div class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1 d-none md:d-block">
                                                                    <div>
                                                                        <div class="post-date hstack gap-narrow">
                                                                            <span title="{{ $lifestylePosts->publish_date_news ?? '' }}">{{ $lifestylePosts->publish_date ?? '' }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div>·</div>
                                                                    <div>
                                                                        <a href="{{url('posts/'.$lifestylePosts->slug)}}#comment-form" class="post-comments text-none hstack gap-narrow" title="Commetns">
                                                                            <i class="icon-narrow unicon-chat"></i>
                                                                            <span>{{ $lifestylePosts->comment ?? '' }}</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-end mt-1">
                                        <a href="{{ url('topics/'.$topic->slug) }}" class="text-black dark:text-white text-none fw-bold">See more <i class="bi bi-chevron-right"></i></a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        
                            <li>
                                <a href="#"><i class="icon-2 fw-medium unicon-overflow-menu-horizontal"></i></a>
                                <div class="uc-navbar-dropdown ft-primary text-unset p-3 rounded-0 hide-scrollbar"
                                    data-uc-drop=" offset: 0; boundary: !.navbar-container; stretch: x; animation: uc-animation-slide-top-small; duration: 150;">
                                    <div class="row child-cols g-4">
                                        <div>
                                            <div class="row child-cols g-4">
                                                <div>
                                                    <ul class="uc-nav uc-navbar-dropdown-nav">
                                                        <li class="uc-nav-header fs-6 ft-tertiary fw-medium mb-1" title="Channels">Channels</li>
                                                        @if (!empty($channels))
                                                            @foreach ($channels as $index => $channel)
                                                            @if ($index < 1 || $index > 3)
                                                                @continue
                                                            @endif
                                                                <li class="d-flex" title="{{ $channel->name ?? ''}}"><a href="{{url('channels/'.$channel->slug) }}" >{{ $channel->name ?? ''}}</a></li>
                                                            @endforeach
                                                        @endif
                                                        <li class="d-flex" title="All Channels"><a href="{{url('channels') }}" >All Channels</a></li>
                                                    </ul>
                                                </div>
                                                <div>
                                                    <ul class="uc-nav uc-navbar-dropdown-nav">
                                                        <li class="uc-nav-header fs-6 ft-tertiary fw-medium mb-1">Topics</li>
                                                        @if(!empty($topics))
                                                            @foreach ($topics as $topic)
                                                                <li title="{{$topic->name ?? ''}}"><a href="{{url('topics/'.$topic->slug)}}">{{$topic->name ?? ''}}</a></li>
                                                            @endforeach
                                                        @endif
                                                        <li class="d-flex" title="All Topics"><a href="{{url('topics') }}" >All Topics</a></li>
                                                    </ul>
                                                </div>
                                                <div>
                                                    <ul class="uc-nav uc-navbar-dropdown-nav">
                                                        <li class="uc-nav-header fs-6 ft-tertiary fw-medium mb-1"> Quick Links</li>
                                                        <li title="Posts"><a href="{{url('posts')}}">All Posts</a></li>
                                                        <li title="About us"><a href="{{url('terms-and-condition')}}">Terms and conditions</a></li>
                                                        <li title="About us"><a href="{{url('privacy-policies')}}">Privacy policies</a></li>
                                                        <li title="Contact us"><a href="{{ url('contact-us') }}">Contact us</a></li>
                                                        <li title="About us"><a href="{{url('about-us')}}">About us</a></li>
                                                        @if (auth()->check())
                                                            <li>
                                                            <li title="My Account"><a href="{{ url('my-account') }}">My Account</a></li>
                                                                <form action="{{ url('logout') }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="bg-transparent border-0 cursor-pointer text-gray-800 dark:text-white dark:text-opacity-50" title="Logout">Logout</button>
                                                                </form>
                                                            </li>
                                                        @else
                                                            <li title="Login"><a class="uc-account-trigger position-relative btn btn-sm border-0 p-0 gap-narrow duration-0 dark:text-white" href="#uc-account-modal" data-uc-toggle>Login</a></li>
                                                            <li title="Register"><a href="#uc-account-modal" class="open-signup-modal" data-uc-toggle>Register</a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="uc-bottom-navbar panel z-1">
            <div class="container max-w-xl">
                <div class="uc-navbar min-h-72px lg:min-h-100px" data-uc-navbar=" animation: uc-animation-slide-top-small; duration: 150;">
                    <div class="uc-navbar-center">
                        <div>
                            <a class="uc-menu-trigger icon-2 d-lg-none" href="#uc-menu-panel" data-uc-toggle>{{""}}</a>
                        </div>
                        <div class="uc-logo d-block d-lg-none">
                           <div class="d-flex align-items-center">
                            <div class="uc-navbar-center">
                            <a href="{{ url('home') }}">
                                {{-- Dark --}}
                                <img class="img-fluid w-auto text-dark dark:text-white hover:text-primary transition-color duration-150 d-block dark:d-none header-img-max-height" src="{{$dark_logo != null ? url('storage/'.$dark_logo->value) : asset('assets/images/logo/DarkLogo.png')}}" alt="Light">
                                {{-- Light --}}
                                <img class="img-fluid w-auto text-dark dark:text-white hover:text-primary transition-color duration-150 d-none dark:d-block header-img-max-height" src="{{$light_logo != null ? url('storage/'.$light_logo->value) : asset('assets/images/logo/LightLogo.png')}}" alt="Dark">
                            </a>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="uc-navbar-center">
                        <div class="uc-logo d-none  d-none d-lg-block">
                            <a href="{{ url('home') }}">
                                {{-- Dark --}}
                                <img class="w-400px text-dark dark:text-white hover:text-primary transition-color duration-150 d-block dark:d-none" src="{{ $dark_logo != null ? url('storage/'.$dark_logo->value) : asset('assets/images/logo/DarkLogo.png')}}" alt="Light">
                                {{-- Light --}}
                                <img class="w-400px text-dark dark:text-white hover:text-primary transition-color duration-150 d-none dark:d-block" src="{{ $light_logo != null ? url('storage/'.$light_logo->value)  : asset('assets/images/logo/LightLogo.png')}}" alt="Dark">
                            </a>
                        </div>
                    </div>
                    <div class="uc-navbar-right gap-2 lg:gap-3">
                        <div class="uc-navbar-item d-none lg:d-inline-flex">
                            @if (auth()->check())
                                <div class="profile-container mt-1">
                                    <img class="w-32px h-32px rounded-circle object-fit-cover pointer-cursor" src="{{ auth()->user()->profile ?? asset('front_end/classic/images/avatars/04.png') }}" alt="User Profile" id="profileImage">
                                    <div class="dropdown-content dark:bg-black" id="dropdownMenu">
                                        <a href="{{url('my-account')}}" class="dark:bg-gray-100 dark:bg-opacity-5 hover:text-primary dark:text-white"><i class="bi bi-person-circle"></i> My Acount</a>
                                        <a href="{{url('my-account/followings')}}" class="dark:bg-gray-100 dark:bg-opacity-5 hover:text-primary dark:text-white"><i class="bi bi-youtube"></i> Followings</a>
                                        <a href="{{url('my-account/bookmarks')}}" class="dark:bg-gray-100 dark:bg-opacity-5 hover:text-primary dark:text-white"><i class="bi bi-bookmark"></i> Bookmarks</a>
                                       <a href="#" class="dark:bg-gray-100 dark:bg-opacity-5 dark:text-white" id="logout-link"><form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </a>
                                    </div>
                                </div>
                            
                            @else
                                <a class="uc-account-trigger position-relative btn btn-sm border-0 p-0 gap-narrow duration-0 dark:text-white" href="#uc-account-modal" data-uc-toggle>
                                    <i class="icon icon-2 fw-medium unicon-user-avatar"></i>
                                </a>
                            @endif
                        </div>
                        <div class="uc-navbar-item d-none lg:d-inline-flex">
                            <a class="uc-search-trigger cstack text-none text-dark dark:text-white" href="#uc-search-modal" data-uc-toggle>
                                <i class="icon icon-2 fw-medium unicon-search"></i>
                            </a>
                        </div>
                        <div class="uc-navbar-item d-none lg:d-inline-flex">
                            <div class="uc-modes-trigger btn btn-xs w-32px h-32px p-0 border fw-normal rounded-circle dark:text-white hover:bg-gray-25 dark:hover:bg-gray-900"
                                data-darkmode-toggle="">
                                <label class="switch">
                                    <span class="sr-only">Dark toggle</span>
                                    <input type="checkbox">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="weather_api_key" value="{{isset($weather_api_key->value) ?  $weather_api_key->value : ""}}">
    </nav>
     @if(isset($header_script))
        {!! $header_script->value !!}
    @endif
</header>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('channels-follow-model');
    const doneButton = document.getElementById('done-button');
    
    if (modal && doneButton) {
        doneButton.addEventListener('click', function(event) {
            event.preventDefault();
            modal.style.display = 'none';
        });
    }
});

</script>

