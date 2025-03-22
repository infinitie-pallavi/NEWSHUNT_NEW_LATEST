@extends('front_end.' . $theme . '.layout.main')
@section('body')
    <!-- Wrapper start -->
    <div id="wrapper" class="wrap overflow-hidden-x">
        <div class="breadcrumbs panel z-1 py-2 bg-gray-25 dark:bg-gray-100 dark:bg-opacity-5 dark:text-white">
            <div class="container max-w-xl">
                <ul class="breadcrumb nav-x justify-center gap-1 fs-7 sm:fs-6 m-0">
                    <li><a href="{{ url('/home') }}" title="Go back to home">Home</a></li>
                    <li><i class="unicon-chevron-right opacity-50"></i></li>
                    <li><a href="{{ url('my-account') }}" title="My account">My Account</a></li>
                    <li><i class="unicon-chevron-right opacity-50"></i></li>
                    <li><span class="opacity-50">Followings</span></li>
                </ul>
            </div>
        </div>
        <div class="section py-3 sm:py-6 lg:py-9">
            <div class="container max-w-xl">
                <div class="panel vstack gap-3 sm:gap-6 lg:gap-3">
                {{-- Mobile view sidebar --}}
                    <div id="mobile-view-sidbar" data-uc-offcanvas="overlay: true;">
                        <div class="uc-offcanvas-bar bg-white text-dark dark:bg-gray-900 dark:text-white">
                            <header
                                class="uc-offcanvas-header hstack justify-between items-center pb-4 bg-white dark:bg-gray-900">
                                <div class="uc-logo">
                                    <a href="{{ url('home') }}" class="h5 text-none text-gray-900 dark:text-white">
                                        <img class="w-32px"
                                            src="{{ asset('front_end/classic/images/custom/LoginLight.png') }}"
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
                                <div class="dashboard-tab">
                                    <div class="block-content panel row sep-x gx-4 gy-3 lg:gy-2">
                                        <div>
                                            <article class="post type-post panel d-flex gap-2">
                                                <h6 class="fs-4 lg:fs-5 xl:fs-5 fw-medium opacity-60">
                                                    <a class="text-none text-dark dark:text-white hover:text-primary duration-150" href="{{url('my-account')}}" title="Account Info">
                                                        <i class="bi bi-person-circle fs-3"> </i> Account Info
                                                    </a>
                                                </h6>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel d-flex gap-2">
                                                <h6 class="fs-4 lg:fs-5 xl:fs-5 fw-medium">
                                                    <a class="text-none text-dark dark:text-white hover:text-primary duration-150" href="#" title="Followings">
                                                        <i class="bi bi-youtube fs-3"> </i> Followings
                                                    </a>
                                                </h6>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel d-flex gap-2">
                                                <h6 class="fs-4 lg:fs-5 xl:fs-5 fw-medium opacity-60">
                                                    <a class="text-none text-dark dark:text-white hover:text-primary duration-150" href="{{url('my-account/bookmarks')}}" title="Bookmarks">
                                                        <i class="bi bi-bookmark fs-3"> </i> Bookmarks
                                                    </a>
                                                </h6>
                                            </article>
                                        </div>
                                        @if(auth()->user()->id !== 1)
                                        <div>
                                            <article class="post type-post panel d-flex gap-2">
                                                <h6 class="fs-4 lg:fs-5 xl:fs-5 fw-medium opacity-60">
                                                    <a class="text-none text-dark dark:text-white hover:text-primary duration-150" title="Remove Account" id="user-delete-account">
                                                        <i class="bi bi-person-fill-slash fs-3"> </i>Remove Account
                                                    </a>
                                                </h6>
                                            </article>
                                        </div>
                                        @endif
                                        <div>
                                            <article class="post type-post panel d-flex gap-2">
                                                <h6 class="fs-4 lg:fs-5 xl:fs-5 fw-medium opacity-60">
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                    <a class="text-none text-dark dark:text-white hover:text-primary duration-150" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        <i class="bi bi-box-arrow-right fs-3"> </i> Logout
                                                    </a>
                                                </h6>
                                            </article>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="d-flex align-items-stretch gap-1">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 mt-2 mb-2 d-none d-lg-block">
                                <!-- Dashboard sidebar -->
                                <div class="dashboard-sidebar bg-block rounded-lg mb-2 p-3 h-100">
                                    <div class="profile-top text-center mb-4">
                                        <div class="mb-3 mt-2">
                                            <img class="profile-image rounded-circle blur-up lazyloaded w-100px h-100px user-sidebar-img" data-src="{{ auth()->user()->profile ?? asset('front_end/classic/images/avatars/04.png') }}" src="{{ auth()->user()->profile ?? asset('front_end/classic/images/avatars/04.png') }}" alt="user" data-uc-tooltip="Profile">
                                        </div>
                                        <div class="profile-detail dark:text-white">
                                            <h3>{{ auth()->user()->name }}</h3>
                                            <span>{{ auth()->user()->email }}</span>
                                        </div>
                                    </div>
                                    <div class="dashboard-tab">
                                        <div class="block-content panel row sep-x gx-4 gy-3 lg:gy-2">
                                            <div>
                                                <a class="text-none hover:text-primary duration-150" href="{{url('my-account')}}" title="Account Info">
                                                    <article class="post type-post panel d-flex gap-2">
                                                        <h4 class="fs-4 lg:fs-6 xl:fs-4 fw-medium"><i class="bi bi-person-circle fs-3"></i> Account Info</h4>
                                                    </article>
                                                </a>
                                            </div>
                                            <div>
                                                <a class="text-none text-dark hover:text-primary duration-150" href="#" title="Followings">
                                                    <article class="post type-post panel d-flex gap-2">
                                                        <h4 class="fs-4 lg:fs-6 xl:fs-4 fw-medium dark:text-white"><i class="bi bi-youtube fs-3"></i> Followings</h4>
                                                    </article>
                                                </a>
                                            </div>
                                            <div>
                                                <a class="text-none hover:text-primary duration-150" href="{{url('my-account/bookmarks')}}" title="Bookmarks">
                                                    <article class="post type-post panel d-flex gap-2">
                                                        <h4 class="fs-4 lg:fs-6 xl:fs-4 fw-medium"><i class="bi bi-bookmark fs-3"></i> Bookmarks</h4>
                                                    </article>
                                                </a>
                                            </div>
                                            @if(auth()->user()->id !== 1)
                                            <div>
                                                <a class="text-none hover:text-primary duration-150" title="Remove Account" id="user-delete-account">
                                                    <article class="post type-post panel d-flex gap-2">
                                                        <h4 class="fs-4 lg:fs-6 xl:fs-4 fw-medium">
                                                            <i class="bi bi-person-fill-slash fs-3"></i> Remove Account
                                                        </h4>
                                                    </article>
                                                </a>
                                            </div>
                                            @endif
                                             <div>
                                                <div>
                                                    <a class="text-none hover:text-primary duration-150" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Logout">
                                                        <article class="post type-post panel d-flex gap-2">
                                                            <h4 class="fs-4 lg:fs-5 xl:fs-4 fw-medium">
                                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                                    @csrf
                                                                </form>
                                                                <i class="bi bi-box-arrow-right fs-3"></i> Logout
                                                            </h4>
                                                        </article>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-12 col-lg-9 mt-2 mb-2 h-100">
                                <div class="d-flex d-lg-none justify-end">
                                    <a class="btn btn-primary btn-sm" href="#mobile-view-sidbar" data-uc-toggle>Accounts Info</a>
                                </div>
                                <div id="content-area" class="rounded-lg p-4 h-100">
                                    <div id="followings">
                                        <h4 class="mb-3"><strong class="text-black dark:text-white">Channels Followings</strong></h4>
                                        <div class="panel text-center">
                                            @if(!empty($channelData[0]))
                                                <div class="row child-cols-12 sm:child-cols-6 lg:child-cols-4 col-match gy-4 xl:gy-6 gx-2 sm:gx-4" id="hide-div">
                                                    @foreach ($channelData as $channel)
                                                        <div id="postRender">
                                                            <article class="post type-post panel vstack gap-2">
                                                                <div class="post-image panel overflow-hidden">
                                                                    <figure class="featured-image m-0 ratio ratio-16x9 rounded uc-transition-toggle overflow-hidden bg-gray-25 dark:bg-gray-800">
                                                                        <a href="{{ url('channels/' . $channel->slug) }}" class="position-cover">
                                                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ url('storage/images/' . $channel->logo) }}" data-src="{{ url('storage/images/' . $channel->logo) }}" alt="{{ $channel->title }}" data-uc-img="loading: lazy">
                                                                        </a>
                                                                    </figure>
                                                                    <div class="position-absolute top-0 end-0 w-150px h-150px rounded-top-end bg-gradient-45 from-transparent via-transparent to-black opacity-50"></div>
                                                                </div>
                                                                <div class="post-header panel vstack gap-1 lg:gap-1">
                                                                    <h3 class="post-title h6 sm:h3 xl:h6 m-0 text-truncate-2 m-0 text-start">
                                                                        <a class="text-none" href="{{ url('channels/' . $channel->slug) }}">{{ $channel->name }}</a>
                                                                    </h3>
                                                                    <div>
                                                                        <div class="post-meta panel hstack fw-medium dark:text-white text-opacity-60 d-flex justify-content-between md:d-flex  justify-between">
                                                                            <div class="">
                                                                                <div class="hstack gap-1">
                                                                                    <i class="bi bi-person-plus fs-4"></i>
                                                                                    <span>{{ $channel->follow_count }}</span>
                                                                                </div>
                                                                            </div>
                                                                            <div>
                                                                                <button class="btn btn-primary custom-btn-xs channel-unfollow" data-channel-id="{{ $channel->id }}">
                                                                                    Unfollow
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </article>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="nav-pagination pt-3 mt-6 lg:mt-9">
                                                    <ul class="nav-x uc-pagination hstack gap-1 justify-center ft-secondary" data-uc-margin="">
                                                        {{ $channelData->links('vendor.custom-pagination') }}
                                                    </ul>
                                                </div>

                                                <div class="mt-7 d-none" id="empty-state">
                                                    <img class="w-100 h-450px object-contain image uc-transition-opaque" src="{{asset('front_end/classic/images/place-holser/no-data.png')}}" data-src="" alt="No Data Found" data-uc-img="loading: lazy">
                                                </div>
                                            @else
                                               <div>
                                                    <img class="w-100 h-450px object-contain image uc-transition-opaque" src="{{asset('front_end/classic/images/place-holser/no-data.png')}}" data-src="" alt="No Data Found" data-uc-img="loading: lazy">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script defer src="{{asset('front_end/'.$theme.'/js/custom/my-account.js')}}"></script>
@endsection