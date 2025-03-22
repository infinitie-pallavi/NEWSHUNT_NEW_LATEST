@extends('front_end.' . $theme . '.layout.main')
<title>{{ 'Webstories | News Hunt' }}</title>
<link rel="icon" href="{{ $favicon ?? asset('assets/images/logo/favicon.png') }}" type="image/x-icon" />
@section('body')
    <link rel="stylesheet" href="path/to/swiper-bundle.min.css">
    <script src="path/to/swiper-bundle.min.js"></script>
    <div id="wrapper" class="wrap overflow-hidden-x">
        <div class="breadcrumbs panel z-1 py-2 bg-gray-25 dark:bg-gray-100 dark:bg-opacity-5 dark:text-white">
            <div class="container max-w-xl">
                <ul class="breadcrumb nav-x justify-center gap-1 fs-7 sm:fs-6 m-0">
                    <li><a href="{{ url('home') }}">Home</a></li>
                    <li><i class="unicon-chevron-right opacity-50"></i></li>
                    <li><span class="opacity-70">Webstories</span></li>
                </ul>
            </div>
        </div>
        <div class="section py-3 sm:py-6 lg:py-9 ">
            <div class="container max-w-xl">
                <div class="panel vstack gap-1 sm:gap-6 lg:gap-9">
                    <header class="page-header panel vstack text-center">
                        <h1 class="headingtag h3 lg:h1">Web Stories</h1>
                    </header>
                    @foreach ($filteredTopics as $topic)   
                        <div class="block-header panel pt-1 border-top">
                            <h2 class="story-title h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white border-none p-0"
                                >{{ $topic->name }}
                                <div class="block-header panel pt-1">
                                    <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                        <a class="hstack d-inline-flex gap-0 text-none hover:text-primary duration-150" href="{{ route('webstories.by.topic', ['topic' => $topic]) }}">
                                            <span>Read All</span>
                                            <i class="icon-1 fw-bold unicon-chevron-right"></i>
                                        </a>
                                    </h2>
                                </div>
                                </h2>       
                            </div>         
                        
                        <div class="slider-panel panel overflow-visible swiper-parent position-relative">
                            <div class="swiper swiper-main swiper-active-visibility h-100 swiper-initialized swiper-horizontal swiper-watch-progress"
                                data-uc-swiper="items: 1.25; active: 2; gap: 2; center: true; center-bounds: true; disable-class: d-none;"
                                data-uc-swiper-s="items: 4;" data-uc-swiper-l="items: 5; ">
                                <div class="swiper-wrapper" id="swiper-wrapper-6965708eea67ffe5" aria-live="polite">
                                    @foreach ($stories->where('topic_id', $topic->id)->filter(fn($story) => $story->story_slides->isNotEmpty()) as $story)
                                        <div class="swiper-slide px-1">
                                            <div class="card bg-white dark:bg-gray-800 d-flex flex-column" id="card_style">
                                                <a href="{{ url('webstories/' . $topic->slug . '/' . $story->slug) }}"
                                                    target="_blank" class="position-relative d-block">
                                                    <img src="{{ asset('storage/' . $story->story_slides->first()->image) }}"
                                                        class="card-img-top" alt="{{ $story->title }}">
                                                        <div class="story-progress-container position-absolute bottom-0 start-0 w-100 px-1 pb-2">
                                                            <div class="progress-segments d-flex gap-1">
                                                                @foreach ($story->story_slides as $index => $slide)
                                                                    <div class="progress-segment flex-grow-1 h-1 bg-white bg-opacity-50"
                                                                        style="border-top: 2px dashed rgb(255, 255, 255);"></div>
                                                                @endforeach
                                                            </div>
                                                        </div>    
                                                    <span
                                                        class="visual-stories-icon position-absolute top-2 end-1 p-1 rounded-circle dark:text-white text-white bg-gray-800">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M7 20V4h10v16zm-4-2V6h2v12zm16 0V6h2v12z" />
                                                        </svg>
                                                    </span>
                                                </a>
                                                <div id="card_title"
                                                    class="card-footer text-gray-900 dark:text-white d-flex flex-column h-100">
                                                    <h3 class="post-title h6 m-0 text-truncate-2 hover:text-primary">
                                                        <a class="text-none duration-150" href="{{ url('webstories/' . $topic->slug . '/' . $story->slug) }}" title="{{ $story->title ?? '' }}">{{ $story->title ?? '' }}</a>
                                                    </h3>
                                                    <div class=" mt-2 text-muted fs-7">
                                                        {{ $story->created_at->diffForHumans() }}
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div
                                    class="swiper-nav  swiper-next btn btn-xs md:btn-sm p-0 btn btn-alt-primary  w-24px md:w-32px xl:w-40px h-24px md:h-32px xl:h-40px bg-white dark:bg-gray-900 text-dark dark:text-white rounded-circle shadow-sm position-absolute top-50 end-0 translate-middle-y z-1">
                                    <i class="unicon-chevron-right icon-xs md:icon-1"></i>
                                </div>
                                <div
                                    class="swiper-nav swiper-prev btn btn-xs md:btn-sm p-0 btn btn-alt-primary  w-24px md:w-32px xl:w-40px h-24px md:h-32px xl:h-40px bg-white dark:bg-gray-900 text-dark dark:text-white rounded-circle shadow-sm position-absolute top-50 start-0 translate-middle-y z-1">
                                    <i class="unicon-chevron-left icon-xs md:icon-1"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @include('front_end.classic.layout.style')
    @endsection
    