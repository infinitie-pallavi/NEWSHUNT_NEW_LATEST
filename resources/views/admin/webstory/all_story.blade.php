@extends('admin.layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('pre-title')
    {{ $title }}
@endsection

@section('page-title')
    <div class="row g-2 align-items-center">
        <div class="col">
            <div class="page-pretitle">
                <a href="{{url('admin/dashboard')}}">{{ __('HOME') }}/</a>
                @yield('pre-title')
            </div>
            <h2 class="page-title">
                @yield('title')
            </h2>
        </div>
         <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <a class="btn btn-primary" href="{{ route('create.story') }}">{{ __('CREATE') }}</a>
        </div>
    </div>
@endsection

@section('content')
<section class="section">
    <div class="col-12 mt-0">
        <div class="card">
            <div class="card-body">
    @if ($stories->isEmpty())
        <p class="text-center">{{ __('No stories found. Please create a story.') }}</p>
    @else
        <div class="row">
            @foreach ($stories as $story)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        @if ($story->story_slides->isNotEmpty())
                            <img src="{{ asset('storage/' . $story->story_slides->first()->image) }}"
                                class="card-img-top img-fixed" alt="{{ $story->title }}">
                        @else
                            <img src="{{ asset('assets/images/no_image_available.png') }}" alt="img Preview"
                                class="card-img-top img-fixed">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title custom-title">{{ $story->title }}</h5>
                                
                                <div class="dropdown">
                                    <button class="btn btn-icon btn-link p-1" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="icon">
                                            <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                            <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                            <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item d-flex justify-content-between align-items-center"
                                                href="{{ route('stories.edit', $story) }}">
                                                {{ __('Edit Story') }}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                    <path
                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                    <path d="M16 5l3 3" />
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <form id="delete-form-{{ $story->id }}" action="{{ route('stories.destroy', $story) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="text-danger delete-btn dropdown-item d-flex justify-content-between align-items-center" data-id="{{ $story->id }}">
                                                    {{ __('Delete') }}
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon" >
                                                        <path
                                                            d="M20 6a1 1 0 01.117 1.993L20 8h-.081l-.919 11a3 3 0 01-2.824 2.995L16 22H8c-1.598 0-2.904-1.249-2.992-2.75L5 19.083 4.08 8H4a1 1 0 01-.117-1.993L4 6h16zm-6-4a2 2 0 012 2 1 1 0 01-1.993.117L14 4h-4l-.007.117A1 1 0 018 4a2 2 0 011.85-1.995L10 2h4z"
                                                            fill="currentColor" />
                                                        <path d="M0 0h24v24H0z" fill="none" />
                                                    </svg>
                                                </button>
                                            </form>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <p class="card-text"><strong>Topic:</strong> {{ $story->topic->name ?? 'Uncategorized' }}</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#storyDetailsModal-{{ $story->id }}">
                                {{ __('VIEW STORY') }}
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
            </div>
        </div>
    </div>
</section>
    @include('admin.models.story')
@endsection

