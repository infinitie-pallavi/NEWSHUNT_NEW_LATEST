@extends('front_end.' . $theme . '.layout.main')

@section('body')
    <!-- Wrapper start -->
    <div id="wrapper" class="wrap overflow-hidden-x">
        <div class="breadcrumbs panel z-1 py-2 bg-gray-25 dark:bg-gray-100 dark:bg-opacity-5 dark:text-white">
            <div class="container max-w-xl">
                <ul class="breadcrumb nav-x justify-center gap-1 fs-7 sm:fs-6 m-0">
                    <li><a href="{{ url('home') }}" title="Home">Home</a></li>
                    <li><i class="unicon-chevron-right opacity-50"></i></li>
                    @if (!empty($searchQuery))
                        <li><span class="opacity-70">Search</span></li>
                        <li><i class="unicon-chevron-right opacity-50"></i></li>
                        <li><span class="opacity-70">For {{ $title }}</span></li>
                    @else
                        <li><span class="opacity-70">{{ $title }}</span></li>
                    @endif
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
                                        <img class="w-32px" src="{{ asset('front_end/classic/images/custom/LoginLight.png') }}" alt="News Hunt" data-uc-svg>
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
                                                <h6 class="fs-4 lg:fs-5 xl:fs-5 fw-medium">
                                                    <a class="text-none text-dark dark:text-white hover:text-primary duration-150" href="{{url('my-account')}}" title="Account Info">
                                                        <i class="bi bi-person-circle fs-3"> </i> Account Info
                                                    </a>
                                                </h6>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel d-flex gap-2">
                                                <h6 class="fs-4 lg:fs-5 xl:fs-5 fw-medium opacity-60">
                                                    <a class="text-none text-dark dark:text-white hover:text-primary duration-150" href="{{url('my-account/followings')}}" title="Followings">
                                                        <i class="bi bi-youtube fs-3"> </i>Followings
                                                    </a>
                                                </h6>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel d-flex gap-2">
                                                <h6 class="fs-4 lg:fs-5 xl:fs-5 fw-medium opacity-60">
                                                    <a class="text-none text-dark dark:text-white hover:text-primary duration-150" href="{{url('my-account/bookmarks')}}" title="Bookmarks">
                                                        <i class="bi bi-bookmark fs-3"> </i>Bookmarks
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
                                                <a class="text-none text-dark hover:text-primary duration-150" href="#" title="Account Info">
                                                    <article class="post type-post panel d-flex gap-2">
                                                        <h4 class="fs-4 lg:fs-6 xl:fs-4 fw-medium dark:text-white"><i class="bi bi-person-circle fs-3"></i> Account Info</h4>
                                                    </article>
                                                </a>
                                            </div>
                                            <div>
                                                <a class="text-none hover:text-primary duration-150" href="{{url('my-account/followings')}}" title="Followings">
                                                    <article class="post type-post panel d-flex gap-2">
                                                        <h4 class="fs-4 lg:fs-6 xl:fs-4 fw-medium"><i class="bi bi-youtube fs-3"></i> Followings</h4>
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
                                                            <h4 class="fs-4 lg:fs-6 xl:fs-4 fw-medium">
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
                                    <div class="panel h-100">
                                        <div class="row child-cols-12 sm:child-cols-12 lg:child-cols-4 col-match gy-4 xl:gy-6 gx-2 sm:gx-4">
                                            <div class="box-title col-12">
                                                <form method="POST" action="{{ route('profile-update') }}" id="user-account-form" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="contact-info position-relative text-center">
                                                            <div>
                                                                <img id="profile-image-preview" src="{{ auth()->user()->profile ?? asset('front_end/classic/images/avatars/04.png') }}" alt="Profile Preview" class="img-fluid rounded-circle h-150px w-150px mx-auto">
                                                                <i class="bi bi-pencil-fill fs-6 position-absolute m-1 bg-primary text-white rounded-circle h-36px w-36px edit-icon" onclick="document.getElementById('change-profile').click();"></i>
                                                            </div>
                                                        <input type="file" id="change-profile" class="form-control py-1 w-full fs-6 dark:bg-black dark:text-dark d-none" name="profile" value="" accept="image/*">
                                                    <strong class="mt-1 text-center">{{ auth()->user()->name ?? 'N/A' }}</strong>
                                                    </div>
                                                    <div class="mt-3">
                                                        <h4 class="mb-3"><strong>Personal Information</strong></h4>
    
                                                        <div class="row mt-3">
                                                            <div class="col-md-6 mb-2">
                                                                <label for="user_name" class="form-label">Name</label>
                                                                <input class="form-control form-control-sm" type="text" id="user_name" name="name" value="{{ auth()->user()->name ?? '' }}" placeholder="Name">
                                                                <strong class="help-block text-danger" id="user_name_error"></strong>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label for="phone" class="form-label">Phone</label>
                                                                <input class="form-control form-control-sm text-muted" type="text" id="phone" name="phone" value="{{ auth()->user()->country_code . ' ' . auth()->user()->mobile }}" placeholder="Phone" disabled>
                                                                <strong class="help-block text-danger"></strong>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input class="form-control form-control-sm text-muted" type="text" id="email" name="email" value="{{ auth()->user()->email ?? '' }}" placeholder="Email" disabled>
                                                                <strong class="help-block text-danger"></strong>
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <label for="account_password" class="form-label">Password</label>
                                                                <div class="input-group">
                                                                    <input class="form-control form-control-sm" type="password" id="account_password" name="password" value="" placeholder="Please enter updated password">
                                                                    <span class="input-group-text bg-white dark:bg-black hover:text-primary" id="togglePassword" style="cursor: pointer;">
                                                                        <i class="bi bi-eye text-dark dark:text-white bg-white dark:bg-black hover:text-primary" id="eyeIcon"></i>
                                                                    </span>
                                                                </div>
                                                                <strong class="help-block text-danger" id="account_password_error"></strong>
                                                            </div>
                                                            <div class="col-12">
                                                              <button class="btn btn-primary btn-xs" type="submit">Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
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
    </div>
    {{-- Edit Profile model --}}
    <div id="update-profile" data-uc-modal="overlay: true">
        <div class="uc-modal-dialog lg:max-w-500px bg-white text-dark dark:bg-gray-800 dark:text-white rounded">
            <button class="uc-modal-close-default p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all" type="button">
                <i class="unicon-close"></i>
            </button>
            <div class="panel vstack gap-2 md:gap-4 text-center">
                <div class="px-3 lg:px-4 py-4 lg:py-4 m-0 lg:mx-auto vstack justify-center items-center">
                    <div class="w-100">
                        <div class="panel vstack justify-center items-center gap-2 sm:gap-4 text-center">
                            <h4 class="h5 lg:h4 m-0">Edit Profile</h4>
                            <div class="panel vstack gap-2 w-100 sm:w-350px mx-auto">
                                <form method="POST" action="{{ route('profile-update') }}" class="vstack gap-2 user-model-img" enctype="multipart/form-data">
                                    @csrf
                                   <img id="profile-image-preview" src="{{ auth()->user()->profile ?? '' }}" alt="Profile Preview" class="img-fluid rounded-circle text-center h-100px w-100px">
                                    <input type="file" id="change-profile" class="form-control py-1 w-full fs-6 bg-white dark:border-white dark:border-gray-700 dark:text-dark" name="profile" accept="image/*">
                                    <input type="text" class="form-control py-1 w-full fs-6 bg-white dark:border-white dark:border-gray-700 dark:text-dark" name="name" value="{{ auth()->user()->name ?? '' }}" placeholder="Enter Name" required>
                                    <input type="email" class="form-control py-1 w-full fs-6 bg-white dark:border-white dark:border-gray-700 dark:text-dark" name="email" value="{{ auth()->user()->email ?? '' }}" disabled>
                                    <input type="text" class="form-control py-1 w-full fs-6 bg-white dark:border-white dark:border-gray-700 dark:text-dark" name="mobile" value="{{ auth()->user()->country_code . ' ' . auth()->user()->mobile }}" disabled>
                                    <button class="btn btn-primary btn-sm lg:mt-1" type="submit">Update Profile</button>
                                </form>
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