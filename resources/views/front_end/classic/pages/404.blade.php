@extends('front_end.'.$theme.'.layout.main')

@section('body')
    
    <body class="uni-body panel bg-white text-gray-900 dark:bg-black dark:text-gray-200 overflow-x-hidden">

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

        <!-- Wrapper start -->
        <div id="wrapper" class="wrap overflow-x-hidden">
            <div class="section py-6 lg:py-8 xl:py-10">
                <div class="container max-w-xl">
                    <div class="panel vstack justify-center items-center gap-2 sm:gap-4 text-center">
                        <h2 class="display-5 sm:display-3 lg:display-2 xl:display-1 text-primary">404</h2>
                        <h1 class="h3 sm:h1 m-0">Page not found</h1>
                        <p class="fs-6 md:fs-5">
                            Sorry, the page you seems looking for, <br>
                            has been moved, redirected or removed permanently.
                        </p>
                        <a href="{{url('home')}}" class="animate-btn btn btn-md btn-primary text-none gap-0">
                            <span>Go back home</span>
                            <i class="icon icon-narrow unicon-arrow-left fw-bold"></i>
                        </a>
                        {{-- <p>Why Not try to search again? <a class="uc-link" href="#uc-search-modal" data-uc-toggle>Search now</a></p> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Wrapper end -->

        @include('front_end.'.$theme.'.layout.script')
    </body>

    <!-- Wrapper end -->
@endsection
