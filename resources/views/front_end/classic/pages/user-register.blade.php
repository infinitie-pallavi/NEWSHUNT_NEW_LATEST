<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ 'Register | News Hunt' }}</title>
    <link rel="icon" href="{{ $favicon ?? asset('assets/images/logo/favicon.png') }}" type="image/x-icon" />
    <meta name="description"
        content="News5 a clean, modern and pixel-perfect multipurpose blogging HTML5 website template.">
    <meta name="theme-color" content="#2757fd">

    <!-- Open Graph Tags -->
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="News5">
    <meta property="og:description"
        content="Full-featured, professional-looking news, editorial and magazine website template.">
    <meta property="og:url" content="https://unistudio.co/html/news5/">
    <meta property="og:site_name" content="News5">
    <meta property="og:image" content="https://unistudio.co/html/news5/assets/images/common/seo-image.jpg">
    <meta property="og:image:width" content="1180">
    <meta property="og:image:height" content="600">
    <meta property="og:image:type" content="image/png">

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="News5">
    <meta name="twitter:description"
        content="Full-featured, professional-looking news, editorial and magazine website template.">
    <meta name="twitter:image" content="https://unistudio.co/html/news5/assets/images/common/seo-image.jpg">

    <link rel="canonical" href="https://unistudio.co/html/news5/">

    @include('front_end.'.$theme.'.layout.style')
</head>

<body class="uni-body panel bg-white text-gray-900 dark:bg-black dark:text-gray-200 overflow-x-hidden">
    <!--  Bottom Actions Sticky -->
    <div class="backtotop-wrap position-fixed bottom-0 end-0 z-99 m-2 vstack">
        <div class="darkmode-trigger cstack w-40px h-40px rounded-circle text-none bg-gray-100 dark:bg-gray-700 dark:text-white"
            data-darkmode-toggle="">
            <label class="switch">
                <span class="sr-only">Dark mode toggle</span>
                <input type="checkbox">
                <span class="slider fs-5"></span>
            </label>
        </div>
        <a class="btn btn-sm btn-news-hunt text-white w-40px h-40px rounded-circle" href="to_top" data-uc-backtotop>
            <i class="icon-2 unicon-chevron-up"></i>
        </a>
    </div>

    <!-- Wrapper start -->
    <div id="wrapper" class="wrap overflow-x-hidden">

        <!-- Section start -->
        <div id="sign-in" class="sign-in section panel overflow-hidden">
            <div class="section-outer panel">
                <div class="section-inner panel">
                    <div class="row child-cols-12 lg:child-cols-12 g-0" data-uc-grid>
                        <div>
                            <div class="panel vstack md:items-center justify-center h-screen overflow-hidden">
                                <div
                                    data-anime="targets: >*; translateY: [-24, 0]; opacity: [0, 1]; easing: easeInOutCubic; duration: 750; delay: anime.stagger(100);">
                                    <div class="uc-logo cstack mx-auto mb-6 lg:mb-8">
                                        <a href="{{url('home')}}">
                                            <img class="w-100px lg:w-128px text-dark dark:text-white hover:text-primary transition-color duration-150 d-none dark:d-block" src="{{ asset('front_end/classic/images/custom/LoginLight.png') }}" alt="Sign in">
                                            <img class="w-100px lg:w-128px text-dark dark:text-white hover:text-primary transition-color duration-150 d-block dark:d-none" src="{{ asset('front_end/classic/images/custom/LoginDark.png') }}" alt="Sign in">
                                        </a>
                                    </div>
                                </div>
                                <div class="panel py-4 px-2">
                                    <div class="panel vstack gap-3 w-100 sm:w-350px mx-auto text-center" data-anime="targets: >*; translateY: [24, 0]; opacity: [0, 1]; easing: easeInOutExpo; duration: 750; delay: anime.stagger(100);">
                                        <h1 class="h4 sm:h3">Create an account</h1>
                                        <div class="panel h-24px">
                                            <hr class="position-absolute top-50 start-50 translate-middle hr m-0 w-100 dark:opacity-30">
                                            <span
                                                class="position-absolute top-50 start-50 translate-middle px-1 fs-7 fw-medium text-uppercase bg-white dark:bg-black">Or</span>
                                        </div>
                                        <form method="POST" action="{{ route('register') }}" class="vstack gap-2">
                                            @csrf
                                            <!-- Name Input -->
                                            <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30"
                                                   type="text" name="name" placeholder="Your Name" required value="{{ old('name') }}">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        
                                            <!-- Email Input -->
                                            <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30"
                                                   type="email" name="email" placeholder="Your Email" required value="{{ old('email') }}">
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        
                                            <!-- Password Input -->
                                            <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30"
                                                   type="password" name="password" placeholder="Password" autocomplete="new-password" required>
                                            @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        
                                            <!-- Password Confirmation Input -->
                                            <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30"
                                                   type="password" name="password_confirmation" placeholder="Confirm Password" autocomplete="new-password" required>
                                            @error('password_confirmation')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        
                                            <!-- Remember Me Checkbox -->
                                            <div class="hstack justify-between text-start">
                                                <div class="form-check text-start">
                                                    <input id="form_accept_terms" class="form-check-input rounded bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30"
                                                           type="checkbox" name="accept_terms" required>
                                                    <label for="form_accept_terms" class="hstack justify-between form-check-label fs-6">I read and accept the <a href="{{ url('/terms-and-condition') }}" class="uc-link ms-narrow">terms of use</a>.</label>
                                                </div>
                                            </div>
                                        
                                            <!-- Submit Button -->
                                            <button class="btn btn-primary btn-sm mt-1" type="submit">Register</button>
                                        </form>
                                        <p>Already have an account? <a class="uc-link" href="{{route('login')}}">Login</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section end -->
    </div>

    <!-- Wrapper end -->

    @include('front_end.'.$theme.'.layout.script')
</body>
</html>