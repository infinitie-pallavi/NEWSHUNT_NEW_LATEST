@extends('front_end.' . $theme . '.layout.main')
@section('body')
<!-- Wrapper start -->
<div id="wrapper" class="wrap overflow-hidden-x">

    <!-- Top Posts Section start -->
    <div class="section panel overflow-hidden swiper-parent border-top">
        <div class="section-outer panel py-2 lg:py-4 dark:text-white">
            <div class="container max-w-xl">
                <div class="section-inner panel vstack gap-2">
                    <div class="block-layout carousel-layout vstack gap-2 lg:gap-3 panel">
                        <div class="block-content panel">
                            <div class="swiper" data-uc-swiper="items: 1; gap: 16; dots: .dot-nav; next: .nav-next; prev: .nav-prev; disable-class: d-none;" data-uc-swiper-s="items: 3; gap: 24;" data-uc-swiper-l="items: 4; gap: 24;">
                                <div class="swiper-wrapper">
                                    @foreach ($top_posts as $top_post)
                                        <div class="swiper-slide">
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle gap-2">
                                                    <div class="row child-cols g-2" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div class="post-media panel overflow-hidden max-w-64px min-w-64px">
                                                                <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                    <a href="{{ url('posts/' . $top_post->slug) }}" class="position-cover">
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ $top_post->image }}" data-src="{{ $top_post->image }}" alt="Hidden Gems: Underrated Travel Destinations Around the World" data-uc-img="loading: lazy">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack gap-1">
                                                                <h3 class="post-title h6 hover:text-primary m-0 text-truncate-2">
                                                                    <a class="text-none duration-150" href="{{ url('posts/' . $top_post->slug) }}" title="{{ $top_post->title ?? '' }}">{{ $top_post->title }}</a>
                                                                </h3>
                                                            </div>
                                                            @if ($top_post->channel != null)
                                                                <a href="{{ url('channels/' . $top_post->channel->slug) }}" class="post-comments text-none hstack gap-narrow">
                                                                    <img src="{{ url('storage/images/' . $top_post->channel->logo) }}" alt="channel logo" title="{{ $top_post->channel->name ?? '' }}" class="rounded-pill h-20px">
                                                                    <span title="{{ $top_post->channel->name ?? '' }}">{{ $top_post->channel->name }}</span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="swiper-nav nav-prev position-absolute top-50 start-0 translate-middle btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px h-32px z-1">
                                <i class="icon-1 unicon-chevron-left"></i>
                            </div>
                            <div class="swiper-nav nav-next position-absolute top-50 start-100 translate-middle btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px h-32px z-1">
                                <i class="icon-1 unicon-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top Posts Section end -->

    <!-- Banner Section start -->
    <div class="section panel mb-4 lg:mb-6">
        <div class="section-outer panel">
            <div class="container max-w-xl">
                <div class="section-inner panel vstack gap-4">
                    <div class="section-content">
                        <div class="row child-col-12 lg:child-cols g-4 lg:g-6 col-match">
                            <div class="lg:col-9">
                                <div class="block-layout slider-layout swiper-parent uc-dark">
                                    <div class="block-content panel uc-visible-toggle">
                                        <div class="swiper" data-uc-swiper="items: 1; active: 1; gap: 4; prev: .nav-prev; next: .nav-next; autoplay: 6000; parallax: true; fade: true; effect: fade; disable-class: d-none;">
                                            <div class="swiper-wrapper">
                                                @foreach ($postBanners as $banner)
                                                    <div class="swiper-slide">
                                                        <article class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 h-100 overflow-hidden uc-dark">
                                                            <div class="post-media panel overflow-hidden h-100">
                                                                <div class="featured-image bg-gray-25 dark:bg-gray-800 h-100 d-none md:d-block">
                                                                    <canvas class="h-100 w-100"></canvas>
                                                                    <a href="{{ url('posts/' . $banner->slug) }}" class="position-cover">
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ $banner->image }}" data-src="{{ $banner->image }}" alt="No img" data-uc-img="loading: lazy">
                                                                    </a>
                                                                </div>
                                                                <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9 d-block md:d-none">
                                                                    <a href="{{ url('posts/' . $banner->slug) }}" class="position-cover">
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ $banner->image }}" data-src="{{ $banner->image }}" alt="Solo Travel: Some Tips and Destinations for the Adventurous Explorer" data-uc-img="loading: lazy">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="position-cover bg-gradient-to-t from-black to-transparent opacity-90">
                                                            </div>
                                                            <a href="{{ url('posts/' . $banner->slug) }}" class="position-cover">
                                                                <div class="post-header panel vstack justify-end items-start gap-1 p-2 sm:p-4 position-cover text-white" data-swiper-parallax-y="-24">
                                                                    <h3 class="post-title h5 lg:h4 xl:h3 m-0 max-w-600px text-white text-truncate-2">
                                                                        <a class="text-none text-white" href="{{ url('posts/' . $banner->slug) }}">{{ $banner->title ?? '' }}</a>
                                                                    </h3>
                                                                    <div>
                                                                        <div class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60">
                                                                            <div class="meta">
                                                                                <div class="d-flex gap-2">
                                                                                    <div>
                                                                                        <div class="justify-content-end">
                                                                                            <span>{{ $banner->publish_date }}</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="d-flex mt-1 gap-2">
                                                                                    <div>
                                                                                        <div class="gap-1">
                                                                                            @if ($banner->channel != null)
                                                                                                <a href="{{ url('channels/' . $banner->channel->slug) }}" class="post-comments text-none hstack gap-narrow" title="{{ $banner->channel->name ?? '' }}">
                                                                                                    <img src="{{ url('storage/images/' . $banner->channel->logo ?? '') }}" alt="chanel logo" class="rounded h-20px">
                                                                                                    {{ $banner->channel->name ?? '' }}
                                                                                                </a>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                    <div>
                                                                                        <a href="#post_comment" class="post-comments text-none hstack gap-narrow">
                                                                                            <i class="icon-narrow unicon-chat"></i>
                                                                                            <span>{{ $banner->comment }}</span>
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="justify-content-end">
                                                                                        <i class="bi bi-eye fs-5"></i>
                                                                                        <span>{{ $banner->view_count }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="actions">
                                                                                <div class="hstack gap-1"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </article>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="swiper-nav nav-prev position-absolute top-50 start-0 translate-middle-y btn btn-alt-primary text-black rounded-circle p-0 mx-2 border-0 shadow-xs w-32px h-32px z-1 uc-hidden-hover">
                                            <i class="icon-1 unicon-chevron-left"></i>
                                        </div>
                                        <div class="swiper-nav nav-next position-absolute top-50 end-0 translate-middle-y btn btn-alt-primary text-black rounded-circle p-0 mx-2 border-0 shadow-xs w-32px h-32px z-1 uc-hidden-hover">
                                            <i class="icon-1 unicon-chevron-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Weather Card --}}
                            <div class="lg:col-3 order-1">
                                <div class="card text-body dark:bg-black dark:text-white" style=" border-radius: 10px;">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-between">
                                            <h6 id="current-time">15:07</h6>
                                            <svg id="geo-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" onClick="getLocation()" fill="currentColor" class="bi bi-crosshair2 hover:text-primary pointer-cursor" viewBox="0 0 16 16">
                                                <path d="M8 0a.5.5 0 0 1 .5.5v.518A7 7 0 0 1 14.982 7.5h.518a.5.5 0 0 1 0 1h-.518A7 7 0 0 1 8.5 14.982v.518a.5.5 0 0 1-1 0v-.518A7 7 0 0 1 1.018 8.5H.5a.5.5 0 0 1 0-1h.518A7 7 0 0 1 7.5 1.018V.5A.5.5 0 0 1 8 0m-.5 2.02A6 6 0 0 0 2.02 7.5h1.005A5 5 0 0 1 7.5 3.025zm1 1.005A5 5 0 0 1 12.975 7.5h1.005A6 6 0 0 0 8.5 2.02zM12.975 8.5A5 5 0 0 1 8.5 12.975v1.005a6 6 0 0 0 5.48-5.48zM7.5 12.975A5 5 0 0 1 3.025 8.5H2.02a6 6 0 0 0 5.48 5.48zM10 8a2 2 0 1 0-4 0 2 2 0 0 0 4 0"/>
                                            </svg>
                                        </div>
                                        <h6 class="flex-grow-1 text-center" id="weather-city">Long Island City</h6>
    
                                        <div class="d-flex flex-column text-center mt-2 mb-2">
                                            <h6 class="display-4 mb-0 font-weight-bold" id=current-weather style="font-size: 50px !important;">-0.79°C</h6>
                                            <span class="small opacity-50" id="current-atmosphere">Stormy</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1" style="font-size: 1rem;">
                                                <div>
                                                    <i class="fas fa-wind fa-fw"></i><i class="bi bi-wind"></i><span class="ms-1" id="wind-speed">4.12 km/h </span>
                                                </div>
                                                <div>
                                                    <i class="fas fa-tint fa-fw"></i><i class="bi bi-droplet-half"></i><span class="ms-1" id="humidity">60%</span>
                                                </div>
                                                <div>
                                                    <i class="fas fa-sun fa-fw"></i><i class="bi bi-eye"></i><span class="ms-1" id="visibility">0.2h</span>
                                                </div>
                                            </div>
                                            <div>
                                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-weather/ilu1.webp" id="weather-icon" width="100px" alt="">
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
    <!-- Banner Section end -->

    <!-- Second Section start -->
    <div class="section panel overflow-hidden">
        <div class="section-outer panel">
            <div class="container max-w-xl">
                <div class="section-inner">
                    <div class="row child-cols-12 lg:child-cols g-4 lg:g-6 col-match" data-uc-grid>
                        {{-- News by topic --}}
                        @foreach ($frontTopics as $index => $topic)
                            @if ($index < 0 || $index > 2 || $topic->posts->isEmpty())
                                @continue
                            @endif
                            <div class="lg:col-4">
                                <div class="block-layout grid-layout vstack gap-2 lg:gap-3 panel overflow-hidden">
                                    <div class="block-header panel pt-1 border-top">
                                        <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                            <a class="hstack d-inline-flex gap-0 text-none hover:text-primary duration-150" href="{{ url('topics/' . $topic->slug ?? '') }}" title="{{ $topic->name ?? '' }}">
                                                <span>{{ $topic->name }}</span>
                                                <i class="icon-1 fw-bold unicon-chevron-right"></i>
                                            </a>
                                        </h2>
                                    </div>
                                    <div class="block-content">
                                        <div class="row child-cols-12 g-2 lg:g-4 sep-x" data-uc-grid>
                                            @foreach ($topic->posts as $post)
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h6 m-0 text-truncate-2 hover:text-primary">
                                                                    <a class="text-none duration-150" href="{{ url('posts/' . $post->slug) }}" title="{{ $post->title }}">{{ $post->title ?? '' }}</a>
                                                                </h3>
                                                                <div class="post-date d-flex gap-narrow fs-7 mb-0 text-gray-900 dark:text-white text-opacity-60 justify-between">
                                                                    <span title="{{ $post->publish_date_news }}">{{ $post->publish_date }}</span>
                                                                    <a href="{{ url('channels/' . $post->channel_slug) }}" class="post-comments text-none hstack gap-narrow" title="{{ $post->name }}">
                                                                        <span class="ms-auto">{{ $post->name }}</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                                <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                    <a href="{{ url('posts/' . $post->slug) }}" class="position-cover">
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ $post->image }}" data-src="{{ $post->image }}" alt="{{ $post->title ?? '' }}" title="{{ $post->title ?? '' }}" data-uc-img="loading: lazy">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Second  Section end -->

    <!-- Most Read Section start -->
    <div class="section panel overflow-hidden swiper-parent">
        <div class="section-outer panel py-4 lg:py-6 dark:text-white">
            <div class="container max-w-xl">
                <div class="section-inner panel vstack gap-2">
                    <div class="block-layout carousel-layout vstack gap-2 lg:gap-3 panel">
                        <div class="block-header panel pt-1 border-top">
                            <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">Most Read</h2>
                        </div>
                        <div class="block-content panel">
                            <div class="swiper" data-uc-swiper="items: 2; gap: 16; dots: .dot-nav; next: .nav-next; prev: .nav-prev; disable-class: d-none;" data-uc-swiper-s="items: 3; gap: 24;" data-uc-swiper-l="items: 5; gap: 24;">
                                <div class="swiper-wrapper">
                                    @if (!empty($mostReads))
                                        @foreach ($mostReads as $mostRead)
                                            <div class="swiper-slide">
                                                <div>
                                                    <article class="post type-post panel uc-transition-toggle vstack gap-2">
                                                        <div class="post-media panel overflow-hidden">
                                                            <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                <a href="{{ url('posts/' . $mostRead->slug) }}"
                                                                    class="position-cover">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ $mostRead->image }}" data-src="{{ $mostRead->image }}" alt="{{ $mostRead->title ?? '' }}" title="{{ $mostRead->title ?? '' }}" data-uc-img="loading: lazy">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="post-header panel vstack gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2 hover:text-primary">
                                                                <a class="text-none duration-150" href="{{ url('posts/' . $mostRead->slug) }}" title="{{ $mostRead->title ?? '' }}">{{ $mostRead->title ?? '' }}</a>
                                                            </h3>
                                                            <div class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1 d-none md:d-block">
                                                                <div>
                                                                    <div class="post-date hstack gap-narrow">
                                                                        <a href="{{ url('channels/' . $mostRead->channel->slug) }}" class="post-comments text-none hstack gap-narrow channel-button" title="{{ $mostRead->channel->name ?? '' }}">
                                                                            <span>{{ $mostRead->channel->name ?? '' }}</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="post-meta panel hstack justify-between gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1 d-none md:d-block">
                                                                <div>
                                                                    <div class="post-date hstack gap-narrow">
                                                                        <span title="{{ $mostRead->publish_date_news }}">{{ $mostRead->publish_date }}</span>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <a href="{{ url('posts/' . $mostRead->slug) }}#comment-form" class="post-comments text-none hstack gap-narrow" title="Comments">
                                                                        <i class="icon-narrow unicon-chat" title="Commetns"></i>
                                                                        <span title="Comments">{{ $mostRead->comment }}</span>
                                                                    </a>
                                                                </div>
                                                                <div title="Views">
                                                                    <i class="bi bi-eye fs-5"></i>
                                                                    <span>{{ $mostRead->view_count }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="swiper-nav nav-prev position-absolute top-50 start-0 translate-middle btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px lg:w-40px h-32px lg:h-40px z-1">
                                <i class="icon-1 unicon-chevron-left"></i>
                            </div>
                            <div class="swiper-nav nav-next position-absolute top-50 start-100 translate-middle btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px lg:w-40px h-32px lg:h-40px z-1">
                                <i class="icon-1 unicon-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Most Read Section Ends -->

    <!-- WebStory Section Starts -->

        <div class="section panel overflow-hidden swiper-parent">
            <div class="section-outer panel py-4 lg:py-6 dark:text-white">
                <div class="container max-w-xl">
                    <div class="section-inner panel vstack gap-2">  
                        <div class="block-header panel pt-1 border-top">
                            <h2 class="story-title h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white border-none p-0"
                                >Web Stories
                                
                                <div class="block-header panel pt-1">
                                    <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                        <a class="hstack d-inline-flex gap-0 text-none hover:text-primary duration-150" href="{{ url('webstories') }}">
                                            <span>Read All</span>
                                            <i class="icon-1 fw-bold unicon-chevron-right"></i>
                                        </a>
                                    </h2>
                                </div>
                                </h2>       
                            </div>                      
                        <div class="block-content panel">
                            <div class="swiper swiper-main swiper-active-visibility h-100 swiper-initialized swiper-horizontal swiper-watch-progress"
                                data-uc-swiper="items: 1.25; active: 2; gap: 2; center: true; center-bounds: true; disable-class: d-none;"
                                data-uc-swiper-s="items: 4;" data-uc-swiper-l="items: 5;">
                                <div class="swiper-wrapper">
                                    @if (!empty($stories))
                                        @foreach ($stories as $story)
                                            <div class="swiper-slide px-1">
                                                <div class="card bg-white dark:bg-gray-800 d-flex flex-column" id="card_style">
                                                    <a href="{{ url('webstories/' . $story->topic->slug . '/' . $story->slug) }}"
                                                        target="_blank" class="position-relative d-block">
                                                        <img src="{{ asset('storage/' . $story->story_slides->first()->image) }}"
                                                        target="_blank"  class="card-img-top" alt="{{ $story->title }}">
                                                        <div class="story-progress-container position-absolute bottom-0 start-0 w-100 px-1 pb-2">
                                                            <div class="progress-segments d-flex gap-1">
                                                                @foreach ($story->story_slides as $slide)
                                                                    <div class="progress-segment flex-grow-1 h-1 bg-white bg-opacity-50"
                                                                        style="border-top: 2px dashed rgb(255, 255, 255);"></div>
                                                                @endforeach
                                                            </div>
                                                        </div>    
                                                        <span class="visual-stories-icon position-absolute top-2 end-1 p-1 rounded-circle dark:text-white text-white bg-gray-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                <path fill="currentColor" d="M7 20V4h10v16zm-4-2V6h2v12zm16 0V6h2v12z" />
                                                            </svg>
                                                        </span>
                                                    </a>
                                                    <div id="card_title" class="card-footer text-gray-900 dark:text-white d-flex flex-column h-100">
                                                        <h3 class="post-title h6 m-0 text-truncate-2 hover:text-primary">
                                                            <a class="text-none duration-150" target="_blank" href="{{ url('webstories/' . $story->topic->slug . '/' . $story->slug) }}" title="{{ $story->title ?? '' }}">
                                                                {{ $story->title ?? '' }}
                                                            </a>
                                                        </h3>
                                                        <div class="mt-2 text-muted fs-7">
                                                            {{ $story->created_at->diffForHumans() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="swiper-nav swiper-prev btn btn-xs md:btn-sm p-0 btn btn-alt-primary w-24px md:w-32px xl:w-40px h-24px md:h-32px xl:h-40px bg-white dark:bg-gray-900 text-dark dark:text-white rounded-circle shadow-sm position-absolute top-50 start-0 translate-middle-y z-1">
                                    <i class="unicon-chevron-left icon-xs md:icon-1"></i>
                                </div>
                                <div class="swiper-nav swiper-next btn btn-xs md:btn-sm p-0 btn btn-alt-primary w-24px md:w-32px xl:w-40px h-24px md:h-32px xl:h-40px bg-white dark:bg-gray-900 text-dark dark:text-white rounded-circle shadow-sm position-absolute top-50 end-0 translate-middle-y z-1">
                                    <i class="unicon-chevron-right icon-xs md:icon-1"></i>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        
    {{-- WebStory Section Ends  --}}
    
    <!-- Section start -->
    <div class="section panel overflow-hidden">
        <div class="section-outer panel">
            <div class="container max-w-xl">
                <div class="section-inner">
                    <div class="row child-cols-12 lg:child-cols g-4 lg:g-4 col-match" data-uc-grid>
                        @foreach ($frontTopics as $index => $topic)
                            @if ($index < 3 || $index > 5 || $topic->posts->isEmpty())
                                @continue
                            @endif
                            <div class="lg:col-4 order-1">
                                <div class="block-layout grid-layout vstack gap-2 lg:gap-3 panel overflow-hidden">
                                    <div class="block-header panel pt-1 border-top">
                                        <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white hover:text-primary">
                                            <a class="hstack d-inline-flex gap-0 text-none duration-150" href="{{ url('topics/' . $topic->slug ?? '') }}" title="{{ $topic->name ?? '' }}">
                                                <span>{{ $topic->name ?? '' }}</span>
                                                <i class="icon-1 fw-bold unicon-chevron-right"></i>
                                            </a>
                                        </h2>
                                    </div>
                                    <div class="block-content">
                                        <div class="row child-cols-12 g-2 lg:g-4 sep-x" data-uc-grid>
                                            @foreach ($topic->posts as $post)
                                                <div>
                                                    <article class="post type-post panel uc-transition-toggle">
                                                        <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                            <div>
                                                                <div class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0 text-truncate-2 hover:text-primary">
                                                                        <a class="text-none duration-150" href="{{ url('posts/' . $post->slug) }}" title="{{ $post->title ?? '' }}"> {{ $post->title ?? '' }}
                                                                        </a>
                                                                    </h3>
                                                                    <div class="post-date d-flex gap-narrow fs-7 mb-0 text-gray-900 dark:text-white text-opacity-60 justify-between">
                                                                        <span title="{{ $post->publish_date_news }}">{{ $post->publish_date }}</span>
                                                                        <a href="{{ url('channels/' . $post->channel_slug) }}" class="post-comments text-none hstack gap-narrow channel-button" title="{{ $post->name ?? '' }}">
                                                                            <span class="ms-auto">{{ $post->name ?? '' }}</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                                    <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                        <a href="{{ url('posts/' . $post->slug) }}" class="position-cover">
                                                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ $post->image }}" data-src="{{ $post->image }}" alt="{{ $post->title ?? '' }}" title="{{ $post->title ?? '' }}" data-uc-img="loading: lazy">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Section end -->

    <!-- Topic  Section start -->
    <div class="section panel overflow-hidden">
        <div class="section-outer panel dark:text-white">
            <div class="container max-w-xl">
                <div class="section-inner">
                    <div class="row child-cols-12 lg:child-cols g-4 lg:g-6 col-match" data-uc-grid>
                        @if ($frontTopics->isNotEmpty())
                            @foreach ($frontTopics as $index => $topic)
                                @if ($index < 6 || $index > 8 || $topic->posts->isEmpty())
                                    @continue
                                @endif
                                <div class="lg:col-4">
                                    <div class="block-layout list-layout vstack gap-2 lg:gap-3 panel overflow-hidden">
                                        <div class="block-header panel pt-1 border-top">
                                            <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                                <a class="hstack d-inline-flex gap-0 text-none hover:text-primary duration-150" href="{{ url('topics/' . $topic->slug ?? '') }}">
                                                    <span>{{ $topic->name ?? '' }}</span>
                                                    <i class="icon-1 fw-bold unicon-chevron-right"></i>
                                                </a>
                                            </h2>
                                        </div>
                                        <div class="block-content">
                                            <div class="row child-cols-12 g-2 lg:g-4 sep-x" data-uc-grid>
                                                <div>
                                                    @foreach ($topic->posts as $index => $post)
                                                        @if ($index == 1)
                                                        @break
                                                        @endif
                                                        <article class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 overflow-hidden uc-dark">
                                                            <div class="post-media panel overflow-hidden">
                                                                <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-4x3">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque" title="{{ $post->title }}" src="{{ $post->image }}" data-src="{{ $post->image }}" alt="{{ $post->title }}">
                                                                </div>
                                                            </div>
                                                            <div class="position-cover bg-gradient-to-t from-black to-transparent opacity-90">
                                                            </div>
                                                            <div class="post-header panel vstack justify-start items-start flex-column-reverse gap-1 p-2 position-cover text-white">
                                                                <div class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60 mt-1">
                                                                    <div class="meta">
                                                                        <div class="hstack gap-2">
                                                                            <div>
                                                                                <a href="{{ url('channels/' . $post->channel_slug) }}" class="post-comments text-none hstack gap-narrow channel-button" title="{{ $post->name }}">
                                                                                    <span>{{ $post->name }}</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="actions">
                                                                        <div class="hstack gap-1">
                                                                            <a href="{{ url('posts/' . $post->slug) }}#post_comment" class="post-comments text-none hstack gap-narrow">
                                                                                <i class="icon-narrow unicon-chat" title="Comments"></i>
                                                                                <span title="Comments">{{ $post->comment }}</span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <h3 class="post-title h6 lg:h5 m-0 m-0 max-w-600px text-white text-truncate-2">
                                                                    <a class="text-none text-white" href="{{ url('posts/' . $post->slug) }}" title="{{ $post->title }}">{{ $post->title }}</a>
                                                                </h3>
                                                                <div class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                    <span title="{{ $post->publish_date_news }}">{{ $post->publish_date }}</span>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    @endforeach
                                                </div>
                                                @foreach ($topic->posts as $index => $post)
                                                    @if ($index < 1 || $index > 3)
                                                        @continue
                                                    @endif
                                                    <div>
                                                        <article class="post type-post panel uc-transition-toggle">
                                                            <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                                <div>
                                                                    <div class="post-header panel vstack justify-between gap-1">
                                                                        <h3 class="post-title h6 m-0 text-truncate-2 hover:text-primary">
                                                                            <a class="text-none duration-150" href="{{ url('posts/' . $post->slug) }}" title="{{ $post->title }}">{{ $post->title }}</a>
                                                                        </h3>
                                                                        <div class="post-date d-flex gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 justify-between">
                                                                            <span title="{{ $post->publish_date_news }}">{{ $post->publish_date }}</span>
                                                                            <a href="{{ url('channels/' . $post->channel_slug) }}" class="post-comments text-none hstack gap-narrow channel-button" title="{{ $post->name }}">
                                                                                <span class="ms-auto">{{ $post->name }}</span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <div class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                                        <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                            <a href="{{ url('posts/' . $post->slug) }}" class="position-cover">
                                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ $post->image }}" data-src="{{ $post->image }}" alt="Tech Innovations Reshaping the Retail Landscape: AI Payments" data-uc-img="loading: lazy" title="{{ $post->title }}">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topic Section end -->
    
    <!-- User Followed Channels News -->
    @if($channelFollowed)
        <div class="section panel overflow-hidden swiper-parent">
            <div class="section-outer panel py-4 lg:py-6 dark:text-white">
                <div class="container max-w-xl">
                    <div class="section-inner panel vstack gap-2">
                        <div class="block-layout carousel-layout vstack gap-2 lg:gap-3 panel">
                            <div class="d-flex justify-between">
                                <div class="block-header panel pt-1 border-top">
                                    <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">From the Channels You may followed</h2>
                                </div>
                                <div class="block-header panel pt-1">
                                    <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                        <a class="hstack d-inline-flex gap-0 text-none hover:text-primary duration-150" href="{{ url('posts') }}">
                                            <span>Read All</span>
                                            <i class="icon-1 fw-bold unicon-chevron-right"></i>
                                        </a>
                                    </h2>
                                </div>
                            </div>
                            <div class="block-content panel">
                                <div class="swiper" data-uc-swiper="items: 2; gap: 16; dots: .dot-nav; next: .nav-next; prev: .nav-prev; disable-class: d-none;" data-uc-swiper-s="items: 3; gap: 24;" data-uc-swiper-l="items: 5; gap: 24;">
                                    <div class="swiper-wrapper">
                                        @if (!empty($channelFollowed))
                                            @foreach ($channelFollowed as $mostRead)
                                                <div class="swiper-slide">
                                                    <div>
                                                        <article class="post type-post panel uc-transition-toggle vstack gap-2">
                                                            <div class="post-media panel overflow-hidden">
                                                                <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <a href="{{ url('posts/' . $mostRead->slug) }}" class="position-cover">
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ $mostRead->image }}" data-src="{{ $mostRead->image }}" alt="{{ $mostRead->title ?? '' }}" title="{{ $mostRead->title ?? '' }}" data-uc-img="loading: lazy">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="post-header panel vstack gap-1">
                                                                <h3 class="post-title h6 m-0 text-truncate-2 hover:text-primary">
                                                                    <a class="text-none duration-150" href="{{ url('posts/' . $mostRead->slug) }}" title="{{ $mostRead->title ?? '' }}">{{ $mostRead->title ?? '' }}</a>
                                                                </h3>
                                                                <div class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1 d-none md:d-block">
                                                                    <div>
                                                                        <div class="post-date hstack gap-narrow">
                                                                            <a href="{{ url('channels/' . $mostRead->channel->slug) }}" class="post-comments text-none hstack gap-narrow channel-button" title="{{ $mostRead->channel->name ?? '' }}">
                                                                                <span>{{ $mostRead->channel->name ?? '' }}</span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="post-meta panel hstack justify-between gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1 d-none md:d-block">
                                                                    <div>
                                                                        <div class="post-date hstack gap-narrow">
                                                                            <span title="{{ $mostRead->publish_date_news }}">{{ $mostRead->publish_date }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <a href="{{ url('posts/' . $mostRead->slug) }}#comment-form" class="post-comments text-none hstack gap-narrow" title="Comments">
                                                                            <i class="icon-narrow unicon-chat" title="Commetns"></i>
                                                                            <span title="Comments">{{ $mostRead->comment }}</span>
                                                                        </a>
                                                                    </div>
                                                                    <div title="Views">
                                                                        <i class="bi bi-eye fs-5"></i>
                                                                        <span>{{ $mostRead->view_count }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="swiper-nav nav-prev position-absolute top-50 start-0 translate-middle btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px lg:w-40px h-32px lg:h-40px z-1">
                                    <i class="icon-1 unicon-chevron-left"></i>
                                </div>
                                <div class="swiper-nav nav-next position-absolute top-50 start-100 translate-middle btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px lg:w-40px h-32px lg:h-40px z-1">
                                    <i class="icon-1 unicon-chevron-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
        <!-- User Followed Channels Ends -->

    <!-- Video Section start -->
    @if(!$videoPosts->isEmpty())
        <div id="live_now" class="live_now section panel uc-dark swiper-parent">
            <div class="section-outer panel py-4 lg:py-6 bg-gray-900 text-white">
                <div class="container max-w-xl">
                    <div class="block-layout slider-thumbs-layout slider-thumbs panel vstack gap-2 lg:gap-3 panel overflow-hidden">
                        <div class="block-content">
                            <div class="row child-cols-12 g-2" data-uc-grid>
                                <div class="md:col-8 lg:col-9">
                                    <div class="panel overflow-hidden rounded">
                                        <div class="swiper swiper-main" data-uc-swiper="connect: .swiper-thumbs; items: 1; gap: 8; autoplay: 7000; parallax: true; fade: true; effect: fade; dots: .swiper-pagination; disable-class: last-slide;">
                                            <div class="swiper-wrapper">
                                                @foreach($videoPosts as $videoPost)
                                                    <div class="swiper-slide">
                                                        <article class="post type-post h-250px md:h-350px lg:h-500px bg-black uc-dark">
                                                            <div class="post-media panel overflow-hidden position-cover">
                                                                <div class="featured-video bg-gray-700 ratio ratio-3x2">
                                                                    <video class="video-cover video-lazyload min-h-100px" preload="none" loop playsinline>
                                                                        <source src="{{$videoPost->video}}" data-src="{{$videoPost->video ?? ''}}" type="video/mp4">
                                                                        <source src="{{$videoPost->video}}" data-src="{{$videoPost->video ?? ''}}" type="video/webm">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                </div>
                                                            </div>
                                                            <div class="position-cover bg-gradient-to-t from-black to-transparent z-1 opacity-80"></div>
                                                            <div class="post-header panel position-absolute bottom-0 vstack justify-between gap-2 xl:gap-4 max-300px lg:max-w-600px p-2 md:p-4 xl:p-6 z-1">
                                                                <h3 class="post-title h4 lg:h3 xl:h2 m-0 text-truncate-2" data-swiper-parallax-x="-8">
                                                                    <a class="text-none" href="{{ url('posts/' . $videoPost->slug) }}">{{$videoPost->title}}</a>
                                                                </h3>
                                                                <div data-swiper-parallax-x="8">
                                                                    <div class="post-meta panel hstack justify-between fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <div class="meta">
                                                                            <div class="hstack gap-2">
                                                                                <div>
                                                                                    <div class="post-author hstack gap-1">
                                                                                        <a href="page-author.html" class="text-black dark:text-white text-none fw-bold">{{$videoPost->name}}</a>
                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <div class="post-date hstack gap-narrow">
                                                                                        <span>{{$videoPost->publish_date}}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#post_comment" class="post-comments text-none hstack gap-narrow">
                                                                                        <i class="icon-narrow unicon-chat"></i>
                                                                                        <span>{{$videoPost->comment ?? "0"}}</span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="actions">
                                                                            <div class="hstack gap-1"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <!-- Add Pagination -->
                                            <div class="swiper-pagination top-auto start-auto bottom-0 end-0 m-2 md:m-4 xl:m-6 text-white d-none md:d-inline-flex justify-end w-auto"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="md:col-4 lg:col-3">
                                    <div class="panel md:vstack gap-1 h-100">
                                        <!-- Slides thumbs -->
                                        <div class="swiper swiper-thumbs swiper-thumbs-progress rounded order-2" data-uc-swiper="items: 2;gap: 4;disable-class: last-slide;" data-uc-swiper-s="items: auto;direction: vertical;autoHeight: true;mousewheel: true;freeMode: false;watchSlidesVisibility: true;watchSlidesProgress: true;watchOverflow: true">
                                            <div class="swiper-wrapper md:flex-1">
                                                @foreach($videoPosts as $videoPost)
                                                    <div class="swiper-slide overflow-hidden rounded min-h-64px lg:min-h-100px">
                                                        <div class="swiper-slide-progress position-cover z-0">
                                                            <span></span>
                                                        </div>
                                                        <article class="post type-post panel uc-transition-toggle p-1 z-1">
                                                            <div class="row gx-1">
                                                                <div class="col-auto post-media-wrap">
                                                                    <div class="post-media panel overflow-hidden w-40px lg:w-64px rounded">
                                                                        <div class="featured-video bg-gray-700 ratio ratio-3x4">
                                                                            <img class="video-cover min-h-100px" src="{{$videoPost->video_thumb}}" data-src="{{$videoPost->video_thumb ?? ''}}" />
                                                                        </div>
                                                                        <div class="has-video-overlay position-absolute top-0 end-0 w-40px h-40px lg:w-64px lg:h-64px bg-gradient-45 from-transparent via-transparent to-black opacity-50"></div>
                                                                        <span class="cstack has-video-icon position-absolute top-50 start-50 translate-middle fs-6 w-40px h-40px text-white">
                                                                            <i class="icon-narrow unicon-play-filled-alt"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <p class="fs-6 m-0 text-truncate-2 text-gray-900 dark:text-white">{{$videoPost->title}}</p>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <!-- Tablet, Desktop and big screens nav -->
                                        <div class="swiper-prev btn btn-2xs lg:btn-xs btn-primary w-100 d-none md:d-flex order-1">Prev</div>
                                        <div class="swiper-next btn btn-2xs lg:btn-xs btn-primary w-100 d-none md:d-flex order-3">Next</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Video Section end -->


    <!-- Latest Section start -->
    <div id="latest_news" class="latest-news section panel">
        <div class="section-outer panel py-4 lg:py-6">
            <div class="container max-w-xl">
                <div class="section-inner">
                    <div class="content-wrap row child-cols-12 g-4 lg:g-6" data-uc-grid>
                        <div class="md:col-9">
                            <div class="main-wrap panel vstack gap-3 lg:gap-6">
                                <div class="block-layout grid-layout vstack gap-2 panel overflow-hidden">
                                    <div class="block-header panel pt-1 border-top">
                                        <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">Latest</h2>
                                    </div>
                                    <div class="block-content">
                                        <div class="row child-cols-12 g-2 lg:g-4 sep-x">
                                            @foreach ($latesNews as $latest)
                                                <div>
                                                    <article class="post type-post panel uc-transition-toggle">
                                                        <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                            <div class="col-auto">
                                                                <div class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                    <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                        <a href="{{ url('posts/' . $latest->slug) }}" class="position-cover">
                                                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ asset('front_end/' . $theme . '/images/common/img-fallback.png') }}" data-src="{{ $latest->image }}" alt="The Rise of AI-Powered Personal Assistants: How They Manage" data-uc-img="loading: lazy">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h5 lg:h4 m-0 text-truncate-2 hover:text-primary">
                                                                        <a class="text-none duration-150" href="{{ url('posts/' . $latest->slug) }}" title="{{ $latest->title ?? '' }}">{{ $latest->title ?? '' }}</a>
                                                                    </h3>
                                                                </div>
                                                                <p class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">{!! substr(strip_tags($latest->description), 0, 310).'...' !!}
                                                                </p>
                                                                <div class="d-flex justify-between">
                                                                    <div class="mt-3">
                                                                        <a href="{{ $latest->channel ? url('channels/' . $latest->channel->slug) : '#' }}" class="post-comments text-none hstack gap-narrow" title="{{ $latest->channel->name ?? '' }}">
                                                                            @if ($latest->channel)
                                                                                <img src="{{ url('storage/images/' . $latest->channel->logo) }}" alt="channel logo" class="rounded h-20px">
                                                                            @else
                                                                                <img src="{{ url('storage/images/default-logo.png') }}" alt="default logo" class="rounded h-20px">
                                                                            @endif
                                                                            {{ $latest->channel->name ?? 'Default Channel Name' }}
                                                                        </a>
                                                                    </div>
                                                                    <div class="mt-3 d-flex">
                                                                        <a href="{{ url('posts/' . $latest->slug) }}#comment-form" class="post-comments text-none hstack gap-narrow" title="Commetns">
                                                                            <i class="icon-narrow unicon-chat"></i>
                                                                            <span class="comment-right-margin">{{ $latest->comment }}</span>
                                                                        </a>
                                                                        <i class="bi bi-eye fs-5" title="Views"></i>
                                                                        <span title="Views">{{ $latest->view_count }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="block-footer cstack lg:mt-2">
                                        <a href="{{ url('posts') }}" class="animate-btn gap-0 btn btn-sm btn-alt-primary bg-transparent text-black dark:text-white border w-100">
                                            <span>Read More {{ $post_label->value ?? '' }}</span>
                                            <i class="icon icon-1 unicon-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md:col-3">
                            <div class="sidebar-wrap panel vstack gap-2 pb-2" data-uc-sticky="end: .content-wrap; offset: 150; media: @m;">
                                <div class="widget popular-widget vstack gap-2 p-2 border">
                                    <div class="widget-title text-center">
                                        <h5 class="fs-7 ft-tertiary text-uppercase m-0">Popular now</h5>
                                    </div>
                                    <div class="widget-content">
                                        <div class="row child-cols-12 gx-4 gy-3 sep-x" data-uc-grid>
                                            @php $counter = 1; @endphp
                                            @foreach ($popularPosts as $popularPost)
                                                <div>
                                                    <article class="post type-post panel uc-transition-toggle">
                                                        <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                            <div>
                                                                <div class="hstack items-start gap-3">
                                                                    <span class="h3 lg:h2 ft-tertiary fst-italic text-center text-primary m-0 min-w-24px">{{ $counter }}</span>
                                                                    <div class="post-header panel vstack justify-between gap-1">
                                                                        <h3 class="post-title h6 m-0">
                                                                            <a class="text-none hover:text-primary duration-150"
                                                                                href="{{ url('posts/' . $popularPost->slug) }}">
                                                                                {{ $popularPost->title }}
                                                                            </a>
                                                                        </h3>
                                                                        <div class="post-meta panel fs-7 text-gray-900 dark:text-white text-opacity-60">
                                                                            <div class="meta">
                                                                                <div class="d-flex justify-between gap-2">
                                                                                    <div class="post-date gap-narrow">
                                                                                        <span title="{{ $popularPost->publish_date_news }}">{{ $popularPost->publish_date }}</span>
                                                                                    </div>
                                                                                    <div>
                                                                                        <i class="bi bi-eye fs-5"></i>
                                                                                        <span>{{ $popularPost->view_count }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="actions">
                                                                                <div class="hstack gap-1"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                                @php $counter++; @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="widget social-widget vstack gap-2 text-center p-2 border">
                                    <div class="widgt-title">
                                        <h4 class="fs-7 ft-tertiary text-uppercase m-0">Follow @NewsHunt</h4>
                                    </div>
                                    <div class="widgt-content">
                                        <form class="vstack gap-1" method="post"
                                            action="{{ route('subscribe.store') }}">
                                            @csrf
                                            <input class="form-control form-control-sm fs-6 fw-medium h-40px w-full bg-white dark:bg-gray-800 dark:border-white dark:border-opacity-15" type="email" name="email" placeholder="Your email" required="">
                                            <button class="btn btn-sm btn-primary" type="submit">Sign up</button>
                                        </form>
                                        <ul class="nav-x justify-center gap-1 mt-3">
                                            <li>
                                                <a href="{{ $socialMedia[27]['value'] ?? '' }}" class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150">
                                                    <i class="icon icon-1 unicon-logo-facebook"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ $socialMedia[26]['value'] ?? '' }}" class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150">
                                                    <i class="icon icon-1 unicon-logo-x-filled"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ $socialMedia[25]['value'] ?? '' }}" class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150">
                                                    <i class="icon icon-1 unicon-logo-instagram"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ $socialMedia[29]['value'] ?? '' }}" class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150">
                                                    <i class="icon icon-1 unicon-logo-youtube"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Latest Section end -->
</div>
<!-- Wrapper end -->
@endsection

