<?php
$title = ''
?>

    <!--  Search modal -->
    <div id="uc-search-modal" class="uc-modal-full uc-modal" data-uc-modal="overlay: true" data-autocomplete-url="<?php echo e(url('api/v1/posts/autocomplete')); ?>">
        <div class="uc-modal-dialog d-flex justify-center bg-white text-dark dark:bg-gray-900 dark:text-white" data-uc-height-viewport="">
            <button class="uc-modal-close-default p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all" type="button">
                <i class="unicon-close"></i>
            </button>
            <div class="panel w-100 sm:w-500px px-2 py-10">
                <h3 class="h1 text-center"><?php echo e(__('SEARCH')); ?></h3>
                <form class="hstack gap-1 mt-4 border-bottom p-narrow dark:border-gray-700" method="GET" id="search-form-data" action="<?php echo e(route('posts.search')); ?>" onsubmit="return modifyQuery(this)">
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
                <a href="<?php echo e(url('home')); ?>" class="h5 text-none text-gray-900 dark:text-white">
                    <img class="w-32px" src="<?php echo e(asset('front_end/classic/images/custom/LoginLight.png')); ?>"
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
            <form method="GET" action="<?php echo e(route('posts.search')); ?>" onsubmit="return modifyQuery(this)" class="form-icon-group vstack gap-1 mb-3">
                <input type="search" name="search" id="globle_search" class="form-control form-control-md fs-6" placeholder="Search..">
                <span class="form-icon text-gray">
                    <i class="unicon-search icon-1"></i>
                </span>
            </form>
            <ul class="nav-y gap-narrow fw-bold fs-5" data-uc-nav>
                <li class="uc-parent">
                    <a href="#">Channels</a>
                    <ul class="uc-nav-sub" data-uc-nav="">
                        <?php if(!empty($channels)): ?>
                            <?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="d-flex" title="<?php echo e($channel->name ?? ''); ?>"><a href="<?php echo e(url('channels/'.$channel->slug)); ?>" ><?php echo e($channel->name ?? ''); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <li title="All Channels"><a href="<?php echo e(url('channels')); ?>">All Channels</a></li>
                    </ul>
                </li>
                <li class="uc-parent">
                    <a href="#">Topics</a>
                    <ul class="uc-nav-sub" data-uc-nav="">
                        <?php if(!empty($topics)): ?>
                            <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li title="<?php echo e($topic->name ?? ''); ?>"><a href="<?php echo e(url('topics/'.$topic->slug)); ?>"><?php echo e($topic->name ?? ''); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <li title="All Topics"><a href="<?php echo e(url('topics')); ?>">All Topics</a></li>
                    </ul>
                </li>
              
                <li title="Web Stories"><a href="<?php echo e(url('webstories')); ?>">Web Stories</a></li>
                <li class="hr opacity-10 my-1"></li>
                <li title="All Posts"><a href="<?php echo e(url('posts')); ?>">All Posts</a></li>
                <li title="Terms and conditions"><a href="<?php echo e(url('terms-and-condition')); ?>">Terms and conditions</a></li>
                <li title="Privacy policy"><a href="<?php echo e(url('privacy-policies')); ?>">Privacy policies</a></li>
                <li title="Contact us"><a href="<?php echo e(url('contact-us')); ?>">Contact us</a></li>
                <li title="About us"><a href="<?php echo e(url('about-us')); ?>">About us</a></li>
                <?php if(auth()->check()): ?>
                    <li title="Logout"><a href="<?php echo e(url('my-account')); ?>">My Account</a>
                    <li title="Logout"><a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                    </form>
                <?php else: ?>
                <li title="Login"><a class="uc-account-trigger position-relative btn btn-sm border-0 p-0 gap-narrow duration-0 dark:text-white" href="#uc-account-modal" data-uc-toggle>Login</a></li>
                <li title="Register"><a href="#uc-account-modal" class="open-signup-modal-mobile" data-uc-toggle>Register</a></li>

                <?php endif; ?>
            </ul>
            <ul class="social-icons nav-x mt-4">
                <li>
                    <a href="<?php echo e($socialMedia[27]['value'] ?? ''); ?>"><i class="unicon-logo-facebook icon-2"></i></a>
                    <a href="<?php echo e($socialMedia[26]['value'] ?? ''); ?>"><i class="unicon-logo-x-filled icon-2"></i></a>
                    <a href="<?php echo e($socialMedia[25]['value'] ?? ''); ?>"><i class="unicon-logo-instagram icon-2"></i></a>
                    <a href="<?php echo e($socialMedia[29]['value'] ?? ''); ?>"><i class="unicon-logo-youtube icon-2"></i></a>
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
    <?php if($modelDatas['subscribe_model_status'] == '1'): ?>
        <?php if($news_hunt_letter !== null): ?>
        <div id="uc-newsletter-modal" data-uc-modal="overlay: true">
            <div class="uc-modal-dialog w-800px bg-white text-dark dark:bg-gray-900 dark:text-white rounded overflow-hidden">
                <button class="uc-modal-close-default p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all" type="button">
                    <i class="unicon-close"></i>
                </button>
                <div class="row md:child-cols-6 col-match g-0">
                    <?php if($modelDatas['subscribe_model_image']): ?>
                    <div class="d-none md:d-flex">
                        <div class="position-relative w-100 ratio-1x1">
                            <img class="media-cover" src="<?php echo e(url('storage/'.$modelDatas['subscribe_model_image'] ?? '' )); ?>" alt="Newsletter img">
                        </div>
                    </div>
                    <?php endif; ?>
                        <div class="panel vstack self-center p-4 md:py-8 text-center">
                            <h3 class="h3 md:h2"><?php echo e($modelDatas['subscribe_model_title'] ?? ''); ?></h3>
                            <p class="ft-tertiary"><?php echo e($modelDatas['subscribe_model_sub_title'] ?? ''); ?></p>
                            <div class="panel mt-2 lg:mt-4">
                                <form class="vstack gap-1" method="post" action="<?php echo e(route('subscribe.store')); ?>">
                                 <?php echo csrf_field(); ?>
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
        <?php endif; ?>
    <?php endif; ?>




    <?php if(session('first_login')): ?>
        <div id="channels-follow-model" data-uc-modal="overlay: true">
            <div class="uc-modal-dialog w-800px bg-white text-dark dark:bg-gray-900 dark:text-white rounded overflow-hidden">
                <button class="uc-modal-close-default p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all" type="button">
                    <i class="unicon-close"></i>
                </button>
                <div class="row md:child-cols-6 col-match g-0">
                    <div class="panel vstack self-center p-4 text-center">
                        <h3 class="h3 md:h2"><?php echo e(session('first_login')); ?></h3>
                        <div class="panel mt-2 lg:mt-4">
                            <div class="mb-3">
                                <div class="form-selectgroup form-selectgroup-pills d-flex">
                                    <?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($index < 1 ): ?>
                                            <?php continue; ?>
                                        <?php endif; ?>
                                        <label for="" class="row form-selectgroup-item">
                                            <div class="mx-h-72px mx-w-150px">
                                                <img id="profile-image-preview" src="<?php echo e(isset($channel->logo) ? url('storage/images/' . $channel->logo) : asset('front_end/classic/images/avatars/04.png')); ?>" alt="Profile Preview" class="h-72px img-fluid mx-auto rounded-1-5 w-150px">
                                            </div>
                                            <div>
                                                <button class="btn btn-primary mt-2 custom-btn-xs channel-follow" data-channel-id="<?php echo e($channel->id); ?>">
                                                    Follow
                                                </button>
                                            </div>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    <?php endif; ?>
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
                            <form method="POST" action="<?php echo e(route('user.login')); ?>" id="login-modle-form" class="vstack gap-2">
                                <?php echo csrf_field(); ?>
                                <div>
                                    <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-gray-800 dark:border-white dark:border-opacity-15" type="email" name="email" id="login-email" placeholder="Your email" required value="<?php echo e(old('email')); ?>">
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
                                    <a href="<?php echo e(route('password.request')); ?>" class="uc-link fs-6">Forgot
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
                            <form class="vstack gap-2" action="<?php echo e(route('user.register')); ?>" id="register-user-form" method="POST">
                                <?php echo csrf_field(); ?>
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
                            <?php echo $termsOfCondition->value ?? ''; ?></div>
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
            <a id="uc-close-gdpr-notification" class="uc-notification-close" data-uc-close><?php echo e(""); ?></a>
            <h2 class="h5 ft-primary fw-bold -ls-1 m-0">GDPR Compliance</h2>
            <p class="fs-7 mt-1 mb-2">We use cookies to ensure you get the best experience on our website. By continuing to
                use our site, you accept our use of cookies, <a href="<?php echo e(url('/privacy-policies')); ?>"
                    class="uc-link text-underline">Privacy Policies</a>, and <a href="<?php echo e(url('/terms-and-condition')); ?>"
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
                            <?php $__currentLoopData = $headerPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $headerpost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide text-white">
                                    <div class="type-post post panel">
                                        <a href="<?php echo e(url('posts/' . $headerpost->slug)); ?>"
                                            class="fs-7 fw-normal text-none text-inherit"><?php echo e($headerpost->title); ?></a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                                <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($index < 0 || $index > 4): ?>
                                                        <?php continue; ?>
                                                    <?php endif; ?>
                                                    <li><a href="<?php echo e(url('topics/'.$topic->slug)); ?>"><?php echo e($topic->name); ?></a></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                        <div class="col-2">
                                            <ul class="uc-nav uc-navbar-dropdown-nav">
                                                <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($index < 5 || $index > 9): ?>
                                                        <?php continue; ?>
                                                    <?php endif; ?>
                                                    <li><a href="<?php echo e(url('topics/'.$topic->slug)); ?>"><?php echo e($topic->name); ?></a></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                                <form class="hstack gap-1 bg-gray-300 bg-opacity-10"  method="post" action="<?php echo e(route('subscribe.store')); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="email"
                                                        class="form-control-plaintext form-control-xs fs-6 dark:text-white"
                                                        placeholder="Your email address..">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-primary fs-6 rounded-0">Subscribe</button>
                                                </form>
                                                <p class="fs-7 mt-1">Do not worry, we don't spam!</p>
                                                <ul class="nav-x gap-2 mt-3">
                                                    <li><a href="<?php echo e($socialMedia[27]['value'] ?? ''); ?>"><i class="icon icon-2 unicon-logo-facebook"></i></a></li>
                                                    <li><a href="<?php echo e($socialMedia[26]['value'] ?? ''); ?>"><i class="icon icon-2 unicon-logo-x-filled"></i></a></li>
                                                    <li><a href="<?php echo e($socialMedia[25]['value'] ?? ''); ?>"><i class="icon icon-2 unicon-logo-instagram"></i></a></li>
                                                    <li><a href="<?php echo e($socialMedia[29]['value'] ?? ''); ?>"><i class="icon icon-2 unicon-logo-youtube"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#"><?php echo e(__('CHANNELS')); ?> <span data-uc-navbar-parent-icon></span></a>
                                <div class="uc-navbar-dropdown ft-primary text-unset p-3 pb-4 rounded-0 hide-scrollbar"
                                    data-uc-drop=" offset: 0; boundary: !.navbar-container; stretch: x; animation: uc-animation-slide-top-small; duration: 150;">
                                    <div class="row col-match g-2">
                                        <div class="w-1/5">
                                            <div class="uc-navbar-switcher-nav border-end">
                                                <ul class="uc-tab-left fs-6" data-uc-tab="connect: #uc-navbar-switcher-tending; animation: uc-animation-slide-right-small, uc-animation-slide-left-small">
                                                    <?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                         <li class="d-flex justify-between align-items-center">
                                                            <a class="text-start" href="#"><?php echo e($channel->name); ?></a>
                                                            <a href="<?php echo e(url('channels/'.$channel->slug)); ?>"><i class="bi bi-chevron-right"></i></a>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="w-4/5">
                                            <div id="uc-navbar-switcher-tending" class="uc-navbar-switcher uc-switcher">
                                                <?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div>
                                                        <div class="row child-cols col-match g-2">
                                                            <?php $__currentLoopData = $channel->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fistChannelPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div>
                                                                    <article class="post type-post panel uc-transition-toggle vstack gap-1">
                                                                        <div class="post-media panel overflow-hidden">
                                                                            <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9">
                                                                                <a href="<?php echo e(url('posts/' . $fistChannelPost->slug)); ?>" class="position-cover">
                                                                                     <?php if($fistChannelPost->type != "video"): ?>
                                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="<?php echo e($fistChannelPost->image ?? ''); ?>" data-src="<?php echo e($fistChannelPost->image ?? ''); ?>" alt="<?php echo e($fistChannelPost->title ?? ''); ?>" title="<?php echo e($fistChannelPost->title ?? ''); ?>" data-uc-img="loading: lazy">
                                                                                    <?php else: ?>
                                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="<?php echo e($fistChannelPost->video_thumb ?? ''); ?>" data-src="<?php echo e($fistChannelPost->video_thumb ?? ''); ?>" alt="<?php echo e($fistChannelPost->title ?? ''); ?>" title="<?php echo e($fistChannelPost->title ?? ''); ?>" data-uc-img="loading: lazy">
                                                                                        <div class="post-category hstack gap-narrow justify-center align-items-center text-white">
                                                                                            <a class="text-none" href="<?php echo e(url('posts/'.$fistChannelPost->slug)); ?>" title="<?php echo e($fistChannelPost->title); ?>"><i class="bi bi-play-circle font-size-45"></i></a>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="post-header panel vstack gap-narrow">
                                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                                <a class="text-none hover:text-primary duration-150"
                                                                                   href="<?php echo e(url('posts/' . $fistChannelPost->slug)); ?>" title="<?php echo e($fistChannelPost->title ?? ''); ?>"><?php echo e($fistChannelPost->title ?? ''); ?></a>
                                                                            </h3>
                                                                            <div class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1 d-none md:d-block">
                                                                                <div>
                                                                                    <div class="post-date hstack gap-narrow">
                                                                                        <span title="<?php echo e($fistChannelPost->publish_date_news ?? ''); ?>"><?php echo e($fistChannelPost->publish_date ?? ''); ?></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div>·</div>
                                                                                <div>
                                                                                    <a href="<?php echo e(url('posts/' . $fistChannelPost->slug)); ?>#comment-form" class="post-comments text-none hstack gap-narrow" title="commets">
                                                                                        <i class="icon-narrow unicon-chat"></i>
                                                                                        <span><?php echo e($fistChannelPost->comment ?? ''); ?></span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </article>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                        <div class="text-end mt-1">
                                                            <a href="<?php echo e(url('channels/'.$channel->slug)); ?>" class="text-black dark:text-white text-none fw-bold" title="See more">See more <i class="bi bi-chevron-right"></i></a>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="<?php echo e(url('webstories')); ?>">Web Stories</a>
                            </li>
                            <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="#"><?php echo e($topic->name); ?><span data-uc-navbar-parent-icon></span></a>
                                <div class="uc-navbar-dropdown ft-primary text-unset p-3 pb-4 rounded-0 hide-scrollbar" data-uc-drop="offset: 0; boundary: !.navbar-container; stretch: x; animation: uc-animation-slide-top-small; duration: 150;">
                                    <div>
                                        <div class="row child-cols col-match g-2">
                                            <?php if($topic->posts->isNotEmpty()): ?>
                                                <?php $__currentLoopData = $topic->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lifestylePosts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <div>
                                                        <article class="post type-post panel uc-transition-toggle vstack gap-1">
                                                            <div class="post-media panel overflow-hidden">
                                                                <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9">
                                                                    <a href="<?php echo e(url('posts/' . $lifestylePosts->slug)); ?>" class="position-cover">
                                                                    <?php if($lifestylePosts->type != "video"): ?>
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="<?php echo e($lifestylePosts->image ?? ''); ?>" data-src="<?php echo e($lifestylePosts->image ?? ''); ?>" alt="<?php echo e($lifestylePosts->title ?? ''); ?>" title="<?php echo e($lifestylePosts->title ?? ''); ?>" data-uc-img="loading: lazy">
                                                                    <?php else: ?>
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="<?php echo e($lifestylePosts->video_thumb ?? ''); ?>" data-src="<?php echo e($lifestylePosts->video_thumb ?? ''); ?>" alt="<?php echo e($lifestylePosts->title ?? ''); ?>" title="<?php echo e($lifestylePosts->title ?? ''); ?>" data-uc-img="loading: lazy">
                                                                        <div class="post-category hstack gap-narrow justify-center align-items-center text-white">
                                                                            <a class="text-none" href="<?php echo e(url('posts/'.$lifestylePosts->slug)); ?>" title="<?php echo e($lifestylePosts->title); ?>"><i class="bi bi-play-circle font-size-45"></i></a>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="post-header panel vstack gap-narrow">
                                                                <h3 class="post-title h6 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150" href="<?php echo e(url('posts/' . $lifestylePosts->slug)); ?>" title="<?php echo e($lifestylePosts->title ?? ''); ?>"><?php echo e($lifestylePosts->title ?? ''); ?></a>
                                                                </h3>
                                                                <div class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1 d-none md:d-block">
                                                                    <div>
                                                                        <div class="post-date hstack gap-narrow">
                                                                            <span title="<?php echo e($lifestylePosts->publish_date_news ?? ''); ?>"><?php echo e($lifestylePosts->publish_date ?? ''); ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div>·</div>
                                                                    <div>
                                                                        <a href="<?php echo e(url('posts/'.$lifestylePosts->slug)); ?>#comment-form" class="post-comments text-none hstack gap-narrow" title="Commetns">
                                                                            <i class="icon-narrow unicon-chat"></i>
                                                                            <span><?php echo e($lifestylePosts->comment ?? ''); ?></span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="text-end mt-1">
                                        <a href="<?php echo e(url('topics/'.$topic->slug)); ?>" class="text-black dark:text-white text-none fw-bold">See more <i class="bi bi-chevron-right"></i></a>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
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
                                                        <?php if(!empty($channels)): ?>
                                                            <?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($index < 1 || $index > 3): ?>
                                                                <?php continue; ?>
                                                            <?php endif; ?>
                                                                <li class="d-flex" title="<?php echo e($channel->name ?? ''); ?>"><a href="<?php echo e(url('channels/'.$channel->slug)); ?>" ><?php echo e($channel->name ?? ''); ?></a></li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                        <li class="d-flex" title="All Channels"><a href="<?php echo e(url('channels')); ?>" >All Channels</a></li>
                                                    </ul>
                                                </div>
                                                <div>
                                                    <ul class="uc-nav uc-navbar-dropdown-nav">
                                                        <li class="uc-nav-header fs-6 ft-tertiary fw-medium mb-1">Topics</li>
                                                        <?php if(!empty($topics)): ?>
                                                            <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li title="<?php echo e($topic->name ?? ''); ?>"><a href="<?php echo e(url('topics/'.$topic->slug)); ?>"><?php echo e($topic->name ?? ''); ?></a></li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                        <li class="d-flex" title="All Topics"><a href="<?php echo e(url('topics')); ?>" >All Topics</a></li>
                                                    </ul>
                                                </div>
                                                <div>
                                                    <ul class="uc-nav uc-navbar-dropdown-nav">
                                                        <li class="uc-nav-header fs-6 ft-tertiary fw-medium mb-1"> Quick Links</li>
                                                        <li title="Posts"><a href="<?php echo e(url('posts')); ?>">All Posts</a></li>
                                                        <li title="About us"><a href="<?php echo e(url('terms-and-condition')); ?>">Terms and conditions</a></li>
                                                        <li title="About us"><a href="<?php echo e(url('privacy-policies')); ?>">Privacy policies</a></li>
                                                        <li title="Contact us"><a href="<?php echo e(url('contact-us')); ?>">Contact us</a></li>
                                                        <li title="About us"><a href="<?php echo e(url('about-us')); ?>">About us</a></li>
                                                        <?php if(auth()->check()): ?>
                                                            <li>
                                                            <li title="My Account"><a href="<?php echo e(url('my-account')); ?>">My Account</a></li>
                                                                <form action="<?php echo e(url('logout')); ?>" method="POST" class="d-inline">
                                                                    <?php echo csrf_field(); ?>
                                                                    <button type="submit" class="bg-transparent border-0 cursor-pointer text-gray-800 dark:text-white dark:text-opacity-50" title="Logout">Logout</button>
                                                                </form>
                                                            </li>
                                                        <?php else: ?>
                                                            <li title="Login"><a class="uc-account-trigger position-relative btn btn-sm border-0 p-0 gap-narrow duration-0 dark:text-white" href="#uc-account-modal" data-uc-toggle>Login</a></li>
                                                            <li title="Register"><a href="#uc-account-modal" class="open-signup-modal" data-uc-toggle>Register</a></li>
                                                        <?php endif; ?>
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
                            <a class="uc-menu-trigger icon-2 d-lg-none" href="#uc-menu-panel" data-uc-toggle><?php echo e(""); ?></a>
                        </div>
                        <div class="uc-logo d-block d-lg-none">
                           <div class="d-flex align-items-center">
                            <div class="uc-navbar-center">
                            <a href="<?php echo e(url('home')); ?>">
                                
                                <img class="img-fluid w-auto text-dark dark:text-white hover:text-primary transition-color duration-150 d-block dark:d-none header-img-max-height" src="<?php echo e($dark_logo != null ? url('storage/'.$dark_logo->value) : asset('assets/images/logo/DarkLogo.png')); ?>" alt="Light">
                                
                                <img class="img-fluid w-auto text-dark dark:text-white hover:text-primary transition-color duration-150 d-none dark:d-block header-img-max-height" src="<?php echo e($light_logo != null ? url('storage/'.$light_logo->value) : asset('assets/images/logo/LightLogo.png')); ?>" alt="Dark">
                            </a>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="uc-navbar-center">
                        <div class="uc-logo d-none  d-none d-lg-block">
                            <a href="<?php echo e(url('home')); ?>">
                                
                                <img class="w-400px text-dark dark:text-white hover:text-primary transition-color duration-150 d-block dark:d-none" src="<?php echo e($dark_logo != null ? url('storage/'.$dark_logo->value) : asset('assets/images/logo/DarkLogo.png')); ?>" alt="Light">
                                
                                <img class="w-400px text-dark dark:text-white hover:text-primary transition-color duration-150 d-none dark:d-block" src="<?php echo e($light_logo != null ? url('storage/'.$light_logo->value)  : asset('assets/images/logo/LightLogo.png')); ?>" alt="Dark">
                            </a>
                        </div>
                    </div>
                    <div class="uc-navbar-right gap-2 lg:gap-3">
                        <div class="uc-navbar-item d-none lg:d-inline-flex">
                            <?php if(auth()->check()): ?>
                                <div class="profile-container mt-1">
                                    <img class="w-32px h-32px rounded-circle object-fit-cover pointer-cursor" src="<?php echo e(auth()->user()->profile ?? asset('front_end/classic/images/avatars/04.png')); ?>" alt="User Profile" id="profileImage">
                                    <div class="dropdown-content dark:bg-black" id="dropdownMenu">
                                        <a href="<?php echo e(url('my-account')); ?>" class="dark:bg-gray-100 dark:bg-opacity-5 hover:text-primary dark:text-white"><i class="bi bi-person-circle"></i> My Acount</a>
                                        <a href="<?php echo e(url('my-account/followings')); ?>" class="dark:bg-gray-100 dark:bg-opacity-5 hover:text-primary dark:text-white"><i class="bi bi-youtube"></i> Followings</a>
                                        <a href="<?php echo e(url('my-account/bookmarks')); ?>" class="dark:bg-gray-100 dark:bg-opacity-5 hover:text-primary dark:text-white"><i class="bi bi-bookmark"></i> Bookmarks</a>
                                       <a href="#" class="dark:bg-gray-100 dark:bg-opacity-5 dark:text-white" id="logout-link"><form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none"><?php echo csrf_field(); ?></form>
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </a>
                                    </div>
                                </div>
                            
                            <?php else: ?>
                                <a class="uc-account-trigger position-relative btn btn-sm border-0 p-0 gap-narrow duration-0 dark:text-white" href="#uc-account-modal" data-uc-toggle>
                                    <i class="icon icon-2 fw-medium unicon-user-avatar"></i>
                                </a>
                            <?php endif; ?>
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
        <input type="hidden" id="weather_api_key" value="<?php echo e(isset($weather_api_key->value) ?  $weather_api_key->value : ""); ?>">
    </nav>
     <?php if(isset($header_script)): ?>
        <?php echo $header_script->value; ?>

    <?php endif; ?>
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

<?php /**PATH /home/infinitie-raj/Code v1.2.0/resources/views/front_end/classic/layout/header.blade.php ENDPATH**/ ?>