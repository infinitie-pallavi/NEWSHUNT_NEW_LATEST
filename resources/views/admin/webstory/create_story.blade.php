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
                <a href="{{ url('admin/dashboard') }}">{{ __('HOME') }}/</a>
                <a href="{{ route('stories.publicIndex') }}">{{ __('STORIES') }}</a> /
                @yield('pre-title')
            </div>
            <h2 class="page-title mt-2">
                @yield('title')
            </h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="container-progress mb-4">
                <ul class="progressbar">
                    <li class="active">Select Story Topic</li>
                    <li>Add Slides & Content</li>
                    <li>Arrange Slide Order</li>
                    <li>Apply Animations</li>
                    <li>Review & Submit</li>
                </ul>
            </div>

            <form id="storyForm" action="{{ route('stories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Step 1: Story Details -->
                <div id="step1" class="step-content">
                    <h3 class="card-title mb-4">{{ __('Story Details') }}</h3>
                    <div class="mb-3">
                        <label class="form-label required">{{ __('STORY TITLE') }}</label>
                        <input type="text" name="title" class="form-control" required>
                        <div class="invalid-feedback">{{ __('Please enter a story title') }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">{{ __('SELECT_TOPIC') }}</label>
                        <select name="topic_id" class="form-select" required>
                            <option value="">{{ __('Select Topic') }}</option>
                            @foreach ($topic as $topic)
                                <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">{{ __('Please select a topic') }}</div>
                    </div>
                </div>

                <!-- Step 2: Add Slides -->
                <div id="step2" class="step-content d-none">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="card-title mb-0">{{ __('Add Slides') }}</h3>
                        <button type="button" class="btn btn-primary" id="addMoreSlides">
                            {{ __('Add New Slide') }}
                        </button>
                    </div>

                    <div id="noSlidesMessage" class="alert alert-warning text-center">
                        {{ __('No slides available. Please add at least one slide.') }}
                    </div>

                    <div class="accordion" id="accordionSlides">
                        <!-- Slides will be added here dynamically -->
                    </div>
                </div>

                <!-- Step 3: Order Slides -->
                <div id="step3" class="step-content d-none">
                    <h3 class="card-title mb-4">{{ __('Order Slides') }}</h3>
                    <div id="slides-order" class="example-list">
                        <!-- Slides will be populated here for ordering -->
                    </div>
                </div>

                <!-- Step 4: Animations -->
                <div id="step4" class="step-content d-none">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title mb-4">{{ __('Add Animations') }}</h3>
                            <div class="accordion" id="animationAccordion">
                                <!-- Title Animation -->
                                <div class="accordion-animation">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#titleAnimation">
                                            Title Animation
                                        </button>
                                    </h2>
                                    <div id="titleAnimation" class="accordion-collapse collapse show"
                                        data-bs-parent="#animationAccordion">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <label class="form-label">Animation Type</label>
                                                <select class="form-select" name="title_animation">
                                                    <option value="fade-in">Fade In</option>
                                                    <option value="slide-up">Slide Up</option>
                                                    <option value="slide-down">Slide Down</option>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Delay (seconds)</label>
                                                    <select class="form-select delay-select" data-target="title_delay">
                                                        <option value="0">No Delay</option>
                                                        <option value="1">1 Second</option>
                                                        <option value="2">2 Seconds</option>
                                                        <option value="3">3 Seconds</option>
                                                    </select>
                                                    <input type="number" name="title_delay" hidden>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Duration (seconds)</label>
                                                    <select class="form-select duration-select"
                                                        data-target="title_duration">
                                                        <option value="1">1 Second</option>
                                                        <option value="2">2 Seconds</option>
                                                        <option value="3">3 Seconds</option>
                                                    </select>
                                                    <input type="number" name="title_duration" hidden>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description Animation -->
                                <div class="accordion-animation">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#descriptionAnimation">
                                            Description Animation
                                        </button>
                                    </h2>
                                    <div id="descriptionAnimation" class="accordion-collapse collapse"
                                        data-bs-parent="#animationAccordion">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <label class="form-label">Animation Type</label>
                                                <select class="form-select" name="description_animation">
                                                    <option value="fade-in">Fade In</option>
                                                    <option value="slide-up">Slide Up</option>
                                                    <option value="slide-down">Slide Down</option>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Delay (seconds)</label>
                                                    <select class="form-select delay-select"
                                                        data-target="description_delay">
                                                        <option value="0">No Delay</option>
                                                        <option value="1">1 Second</option>
                                                        <option value="2">2 Seconds</option>
                                                        <option value="3">3 Seconds</option>
                                                    </select>
                                                    <input type="number" name="description_delay" hidden>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Duration (seconds)</label>
                                                    <select class="form-select duration-select"
                                                        data-target="description_duration">
                                                        <option value="1">1 Second</option>
                                                        <option value="2">2 Seconds</option>
                                                        <option value="3">3 Seconds</option>
                                                    </select>
                                                    <input type="number" name="description_duration" hidden>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Animation -->
                                <div class="accordion-animation">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#imageAnimation">
                                            Image Animation
                                        </button>
                                    </h2>
                                    <div id="imageAnimation" class="accordion-collapse collapse"
                                        data-bs-parent="#animationAccordion">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <label class="form-label">Animation Type</label>
                                                <select class="form-select" name="image_animation">
                                                    <option value="fade-in">Fade In</option>
                                                    <option value="zoom-in">Zoom In</option>
                                                    <option value="slide-in">Slide In</option>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Delay (seconds)</label>
                                                    <select class="form-select delay-select" data-target="image_delay">
                                                        <option value="0">No Delay</option>
                                                        <option value="1">1 Second</option>
                                                        <option value="2">2 Seconds</option>
                                                        <option value="3">3 Seconds</option>
                                                    </select>
                                                    <input type="number" name="image_delay" hidden>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Duration (seconds)</label>
                                                    <select class="form-select duration-select"
                                                        data-target="image_duration">
                                                        <option value="1">1 Second</option>
                                                        <option value="2">2 Seconds</option>
                                                        <option value="3">3 Seconds</option>
                                                    </select>
                                                    <input type="number" name="image_duration" hidden>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Preview</h4>
                                </div>
                                <div class="card-body">
                                    <div id="animation-preview" class="border rounded p-3">
                                        <div class="preview-placeholder text-center">
                                            <p class="text-muted">Animation preview will appear here</p>
                                        </div>
                                        <div id="previewContent" class="d-none">
                                            <h2 id="previewTitle"></h2>
                                            <p id="previewDescription"></p>
                                            <img id="previewImage" src="" alt="Preview Image"
                                                class="img-fluid" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 5: Submit Story -->
                <div id="step5" class="step-content d-none">
                    <h3 class="card-title mb-4">{{ __('Save Story') }}</h3>
                    <p>{{ __('Please review your story details, slides, and animations before saving.') }}</p>
                    <p>{{ __('Once saved, you will be able to edit the story.') }}</p>
                </div>

                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary" id="prevStep" style="display: none">
                        {{ __('Previous') }}
                    </button>
                    <button type="button" class="btn btn-primary" id="nextStep">
                        {{ __('Next') }}
                    </button>
                    <button type="submit" class="btn btn-success" id="submitForm" style="display: none">
                        {{ __('Save Story') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

@section('script')
    <script type="text/javascript" src="{{ asset('/assets/js/custom/create_story/story.js') }}"></script>
@endsection
@endsection
