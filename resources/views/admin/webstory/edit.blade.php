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
                    <li class="active">Create Story Topic</li>
                    <li>Add Slide</li>
                    <li>Ordering</li>
                    <li>Animations</li>
                    <li>Submit</li>
                </ul>
            </div>
            <form id="storyForm" action="{{ route('stories.update', $story->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Step 1: Story Details -->
                <div id="step1" class="step-content">
                    <h3 class="card-title mb-4">{{ __('Story Details') }}</h3>
                    <div class="mb-3">
                        <label class="form-label required">{{ __('STORY TITLE') }}</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $story->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="topic_id" class="form-label">{{ __('SELECT_TOPIC') }}</label>
                        <select name="topic_id" class="form-control form-select @error('topic_id') is-invalid @enderror"
                            required>
                            <option value="">{{ __('Select Topic') }}</option>
                            @foreach ($topic as $topic)
                                <option value="{{ $topic->id }}"
                                    {{ old('topic_id', $story->topic_id) == $topic->id ? 'selected' : '' }}>
                                    {{ $topic->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('topic_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Step 2: Edit Slides -->
                <div id="step2" class="step-content d-none">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title mb-0">{{ __('Edit Slides') }}</h3>
                        <button type="button" class="btn btn-primary" id="addMoreSlides">
                            {{ __('Add Another Slide') }}
                        </button>
                    </div>

                    <div class="accordion" id="accordionSlides">
                        @foreach ($story->story_slides as $index => $slide)
                            <div class="accordion-item">
                                <h2 class="accordion-header d-flex align-items-center justify-content-between">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSlide{{ $index }}" aria-expanded="false">
                                        {{ $slide->title }}
                                    </button>
                                    <button type="button" class="btn btn-link text-danger delete-slide me-2"
                                        data-slide-index="{{ $index }}"
                                        style="padding: 0; background: none; border: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="currentColor"
                                            class="icon icon-tabler icons-tabler-filled icon-tabler-trash">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z" />
                                            <path
                                                d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" />
                                        </svg>
                                    </button>
                                </h2>

                                <div id="collapseSlide{{ $index }}" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionSlides">
                                    <div class="accordion-body">
                                        <div class="slide-entry mb-4 border p-3 rounded"
                                            data-slide-index="{{ $index }}">
                                            <input type="hidden" name="slides[{{ $index }}][id]"
                                                value="{{ $slide->id }}">

                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Slide Title') }}</label>
                                                <input type="text" name="slides[{{ $index }}][title]"
                                                    class="form-control @error('slides.' . $index . '.title') is-invalid @enderror"
                                                    value="{{ old('slides.' . $index . '.title', $slide->title) }}"
                                                    required>
                                                @error('slides.' . $index . '.title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Slide Description') }}</label>
                                                <textarea name="slides[{{ $index }}][description]"
                                                    class="form-control @error('slides.' . $index . '.description') is-invalid @enderror" rows="3">{{ old('slides.' . $index . '.description', $slide->description) }}</textarea>
                                                @error('slides.' . $index . '.description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Slide Image') }}</label>
                                                <input type="file" name="slides[{{ $index }}][image]"
                                                    class="form-control @error('slides.' . $index . '.image') is-invalid @enderror"
                                                    accept="image/*" onchange="editPreviewImage(event, {{ $index }})">
                                                @error('slides.' . $index . '.image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                                <div class="mt-3">
                                                    <img id="imagePreview{{ $index }}"
                                                        src="{{ asset('storage/' . $slide->image) }}" alt="Slide Preview"
                                                        class="img-preview img-fluid"
                                                        style="width: 200px; height: 150px; object-fit: cover;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Step 3: Order Slides -->
                <div id="step3" class="step-content d-none">
                    <h3 class="card-title mb-4">{{ __('Order Slides') }}</h3>
                    <div id="slides-order" class="example-list">
                        @foreach ($story->story_slides as $index => $slide)
                            <div class="slide-preview" draggable="true" data-index="{{ $index }}">
                                <img src="{{ asset('storage/' . $slide->image) }}" alt="Slide Image Preview"
                                    id="imagePreviewThumbnail{{ $index }}"
                                    style="width: 100px; height: 60px; object-fit: cover;">
                                <span id="slideTitle{{ $index }}">{{ $slide->title }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Step 4: Animations -->
                <div id="step4" class="step-content d-none">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title mb-4">{{ __('Add Animations') }}</h3>
                            <div class="accordion" id="animationAccordion">
                                <!-- Title Animation -->
                                <div class="accordion-item">
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
                                                @php
                                                    $titleAnimation =
                                                        $animations[$story->story_slides->first()->id]['title'] ?? [];
                                                @endphp
                                                <label class="form-label">Animation Type</label>
                                                <select class="form-select" name="title_animation">
                                                    <option value="fade-in"
                                                        {{ isset($titleAnimation['type']) && $titleAnimation['type'] == 'fade-in' ? 'selected' : '' }}>
                                                        Fade In</option>
                                                    <option value="slide-up"
                                                        {{ isset($titleAnimation['type']) && $titleAnimation['type'] == 'slide-up' ? 'selected' : '' }}>
                                                        Slide Up</option>
                                                    <option value="slide-down"
                                                        {{ isset($titleAnimation['type']) && $titleAnimation['type'] == 'slide-down' ? 'selected' : '' }}>
                                                        Slide Down</option>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Delay (seconds)</label>
                                                    <select class="form-select delay-select" name="title_delay">
                                                        <option value="0" {{ old('title_delay', $titleAnimation['delay'] ?? 0) == 0 ? 'selected' : '' }}>No Delay</option>
                                                        <option value="1" {{ old('title_delay', $titleAnimation['delay'] ?? 0) == 1 ? 'selected' : '' }}>1 Second</option>
                                                        <option value="2" {{ old('title_delay', $titleAnimation['delay'] ?? 0) == 2 ? 'selected' : '' }}>2 Seconds</option>
                                                        <option value="3" {{ old('title_delay', $titleAnimation['delay'] ?? 0) == 3 ? 'selected' : '' }}>3 Seconds</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label class="form-label">Duration (seconds)</label>
                                                    <select class="form-select duration-select" name="title_duration">
                                                        <option value="1" {{ old('title_duration', $titleAnimation['duration'] ?? 1) == 1 ? 'selected' : '' }}>1 Second</option>
                                                        <option value="2" {{ old('title_duration', $titleAnimation['duration'] ?? 1) == 2 ? 'selected' : '' }}>2 Seconds</option>
                                                        <option value="3" {{ old('title_duration', $titleAnimation['duration'] ?? 1) == 3 ? 'selected' : '' }}>3 Seconds</option>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description Animation -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#descriptionAnimation">
                                            Description Animation
                                        </button>
                                    </h2>
                                    <div id="descriptionAnimation" class="accordion-collapse collapse"
                                        data-bs-parent="#animationAccordion">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                @php
                                                    $descriptionAnimation =
                                                        $animations[$story->story_slides->first()->id]['description'] ??
                                                        [];
                                                @endphp
                                                <label class="form-label">Animation Type</label>
                                                <select class="form-select" name="description_animation">
                                                    <option value="fade-in"
                                                        {{ isset($descriptionAnimation['type']) && $descriptionAnimation['type'] == 'fade-in' ? 'selected' : '' }}>
                                                        Fade In</option>
                                                    <option value="slide-up"
                                                        {{ isset($descriptionAnimation['type']) && $descriptionAnimation['type'] == 'slide-up' ? 'selected' : '' }}>
                                                        Slide Up</option>
                                                    <option value="slide-down"
                                                        {{ isset($descriptionAnimation['type']) && $descriptionAnimation['type'] == 'slide-down' ? 'selected' : '' }}>
                                                        Slide Down</option>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Delay (seconds)</label>
                                                    <select class="form-select delay-select" name="description_delay">
                                                        <option value="0" {{ old('description_delay', $descriptionAnimation['delay'] ?? 0.2) == 0 ? 'selected' : '' }}>No Delay</option>
                                                        <option value="1" {{ old('description_delay', $descriptionAnimation['delay'] ?? 0.2) == 1 ? 'selected' : '' }}>1 Second</option>
                                                        <option value="2" {{ old('description_delay', $descriptionAnimation['delay'] ?? 0.2) == 2 ? 'selected' : '' }}>2 Seconds</option>
                                                        <option value="3" {{ old('description_delay', $descriptionAnimation['delay'] ?? 0.2) == 3 ? 'selected' : '' }}>3 Seconds</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Duration (seconds)</label>
                                                    <select class="form-select duration-select" name="description_duration">
                                                        <option value="1" {{ old('description_duration', $descriptionAnimation['duration'] ?? 1) == 1 ? 'selected' : '' }}>1 Second</option>
                                                        <option value="2" {{ old('description_duration', $descriptionAnimation['duration'] ?? 1) == 2 ? 'selected' : '' }}>2 Seconds</option>
                                                        <option value="3" {{ old('description_duration', $descriptionAnimation['duration'] ?? 1) == 3 ? 'selected' : '' }}>3 Seconds</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Animation -->
                                <div class="accordion-item">
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
                                                @php
                                                    $imageAnimation =
                                                        $animations[$story->story_slides->first()->id]['image'] ?? [];
                                                @endphp
                                                <label class="form-label">Animation Type</label>
                                                <select class="form-select" name="image_animation">
                                                    <option value="fade-in"
                                                        {{ isset($imageAnimation['type']) && $imageAnimation['type'] == 'fade-in' ? 'selected' : '' }}>
                                                        Fade In</option>
                                                    <option value="zoom-in"
                                                        {{ isset($imageAnimation['type']) && $imageAnimation['type'] == 'zoom-in' ? 'selected' : '' }}>
                                                        Zoom In</option>
                                                    <option value="slide-in"
                                                        {{ isset($imageAnimation['type']) && $imageAnimation['type'] == 'slide-in' ? 'selected' : '' }}>
                                                        Slide In</option>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Delay (seconds)</label>
                                                    <select class="form-select delay-select" name="image_delay">
                                                        <option value="0" {{ old('image_delay', $imageAnimation['delay'] ?? 0.4) == 0 ? 'selected' : '' }}>No Delay</option>
                                                        <option value="1" {{ old('image_delay', $imageAnimation['delay'] ?? 0.4) == 1 ? 'selected' : '' }}>1 Second</option>
                                                        <option value="2" {{ old('image_delay', $imageAnimation['delay'] ?? 0.4) == 2 ? 'selected' : '' }}>2 Seconds</option>
                                                        <option value="3" {{ old('image_delay', $imageAnimation['delay'] ?? 0.4) == 3 ? 'selected' : '' }}>3 Seconds</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Duration (seconds)</label>
                                                    <select class="form-select duration-select" name="image_duration">
                                                        <option value="1" {{ old('image_duration', $imageAnimation['duration'] ?? 1) == 1 ? 'selected' : '' }}>1 Second</option>
                                                        <option value="2" {{ old('image_duration', $imageAnimation['duration'] ?? 1) == 2 ? 'selected' : '' }}>2 Seconds</option>
                                                        <option value="3" {{ old('image_duration', $imageAnimation['duration'] ?? 1) == 3 ? 'selected' : '' }}>3 Seconds</option>
                                                    </select>
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
                </div>
                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary" id="prevStep" style="display: none">
                        {{ __('Previous') }}
                    </button>
                    <button type="button" class="btn btn-primary" id="nextStep">
                        {{ __('Next') }}
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitForm" style="display: none">
                        {{ __('Update Story') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

@section('script')
    <script type="text/javascript" src="{{ asset('/assets/js/custom/update_story/story_edit.js') }}"></script>
@endsection
@endsection
