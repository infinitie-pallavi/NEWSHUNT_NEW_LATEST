@extends('front_end.' . $theme . '.layout.main')
@section('body')
    <!-- Wrapper start -->
    <div id="wrapper" class="wrap overflow-hidden-x">
        <div class="breadcrumbs panel z-1 py-2 bg-gray-25 dark:bg-gray-100 dark:bg-opacity-5 dark:text-white">
            <div class="container max-w-xl">
                <ul class="breadcrumb nav-x justify-center gap-1 fs-7 sm:fs-6 m-0">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                    <li><i class="unicon-chevron-right opacity-50"></i></li>
                    <li><span class="opacity-50">Terms and conditions</span></li>
                </ul>
            </div>
        </div>


        <div class="section py-4 lg:py-6 xl:py-8">
            <div class="container max-w-lg">
                <div class="page-wrap panel vstack gap-4 lg:gap-6 xl:gap-8">
                    <header class="page-header panel vstack justify-center gap-2 lg:gap-4 text-center">
                        <div class="panel">
                            <h1 class="h3 lg:h1 m-0">Terms and conditions</h1>
                        </div>
                    </header>
                        <div class="page-content panel fs-6 md:fs-5">{!! $termsOfCondition->value !!}</div>
                    <div class="page-footer panel">
                        <b class="fs-7 opacity-60 m-0">Last updated: {{$termsOfCondition->updated_at}}</b>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wrapper end -->
@endsection
