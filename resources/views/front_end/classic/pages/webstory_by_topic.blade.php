@extends('front_end.' . $theme . '.layout.main')
<title>{{ 'Webstories | ' . $topic->name . ' | News Hunt' }}</title>

@section('body')
    <div id="wrapper" class="wrap overflow-hidden-x">
        <div class="breadcrumbs panel z-1 py-2 bg-gray-25 dark:bg-gray-100 dark:bg-opacity-5 dark:text-white">
            <div class="container max-w-xl">
                <ul class="breadcrumb nav-x justify-center gap-1 fs-7 sm:fs-6 m-0">
                    <li><a href="{{ url('home') }}">Home</a></li>
                    <li><i class="unicon-chevron-right opacity-50"></i></li>
                    <li><a href="{{ route('webstories.index') }}">Webstories</a></li>
                    <li><i class="unicon-chevron-right opacity-50"></i></li>
                    <li><span class="opacity-70">{{ $topic->name }}</span></li>
                </ul>
            </div>
        </div>
        <div class="section py-3 sm:py-6 lg:py-9">
            <div class="container max-w-xl">
                <div class="panel vstack gap-1 sm:gap-6 lg:gap-9">
                    <header class="page-header panel vstack text-center">
                        <h1 class="h3 lg:h1 mb-4">{{ $topic->name }} Stories</h1>
                    </header>
                    <!-- Responsive Stories Display -->
                    <div class="hidden lg:block"> <!-- Grid view for larger screens (>=1288px) -->
                        <div class="row child-cols-6 lg:child-cols-3 col-match gy-4 lg:gy-8 gx-2 lg:gx-4">
                            @foreach ($stories as $story)
                                <div>
                                    <div class="card bg-white dark:bg-gray-800 d-flex flex-column">
                                        <a href="{{ url('webstories/' . $topic->slug . '/' . $story->slug) }}"
                                            target="_blank" class="position-relative d-block">
                                            <img src="{{ asset('storage/' . $story->story_slides->first()->image) }}"
                                                class="card-img-top" alt="{{ $story->title }}">

                                            <div
                                                class="story-progress-container position-absolute bottom-0 start-0 w-100 px-1 pb-2">
                                                <div class="progress-segments d-flex gap-1">
                                                    @foreach ($story->story_slides as $index => $slide)
                                                        <div class="progress-segment flex-grow-1 h-1 bg-white bg-opacity-50"
                                                            style="border-top: 2px dashed rgb(255, 255, 255);"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <span
                                                class="visual-stories-icon position-absolute top-2 end-1 p-1 rounded-circle dark:text-white text-white bg-gray-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M7 20V4h10v16zm-4-2V6h2v12zm16 0V6h2v12z" />
                                                </svg>
                                            </span>
                                        </a>
                                        <div id="card_title"
                                            class="card-footer text-gray-900 dark:text-white d-flex flex-column h-100">
                                            <h3 class="post-title h6 m-0 text-truncate-2 hover:text-primary">
                                                <a class="text-none duration-150"
                                                    href="{{ url('webstories/' . $topic->slug . '/' . $story->slug) }}"
                                                    title="{{ $story->title ?? '' }}">{{ $story->title ?? '' }}</a>
                                            </h3>
                                            <div class=" mt-2 text-muted fs-7">
                                                {{ $story->created_at->diffForHumans() }}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Pagination (only shown in grid view) -->
                    @if ($stories->hasPages())
                        <div class="nav-pagination pt-3 mt-6 lg:mt-9">
                            <ul class="nav-x uc-pagination hstack gap-1 justify-center ft-secondary" data-uc-margin="">
                                {{ $stories->links('vendor.custom-pagination') }}
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-wrap bg-gray-50 dark:bg-gray-900 py-6">
        <div class="container">
            <div class="text-center">
                <h2 class="h4 mb-4">Explore More Stories</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Discover more amazing stories across different topics
                </p>
                <a href="{{ route('webstories.index') }}" class="btn btn-primary">
                    Browse All Stories
                </a>
            </div>
        </div>
    </div>
@endsection
