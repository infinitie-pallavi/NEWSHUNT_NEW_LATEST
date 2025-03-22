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
        </div>
    </div>
@endsection
@section('content')
  <section class="section">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Details') }}</h3>
            </div>
            <form action="{{ url($url) }}" class="form-horizontal" enctype="multipart/form-data" id="{{$formID}}" method="{{$method}}" data-parsley-validate>
                @csrf
                <div class="card-body">
                    <div class="row row-cards">

                        <div class="col-sm-12 col-md-12">
                            <label for="add-post-title" class="form-label col-12">{{ __('TITLE') }}</label>
                            <input type="text" name="title" class="form-control" placeholder="Please enter post title" value="{{$post->title ?? ""}}" id="add-post-title" required>
                            <span class="text-danger gap-1">
                                <strong id="title-error-message"></strong>
                            </span>
                        </div>

                    <div class="form-group mt-3">
                        <label for="add-post-description" class="form-label">{{ __('POST_DESCRIPTION') }}</label>
                        <textarea name="description" class="form-control" placeholder="Please enter post description" id="tinymce_editor" aria-label="tinymce_editor" rows="3" required>{{$post->description ?? ""}}</textarea>
                        <span class="text-danger">
                            <strong id="description-error-message"></strong>
                        </span>
                    </div>

                    <div class="col-sm-6 col-md-6 mt-3">
                        <label for="channel_id" class="form-label">{{ __('SELECT_CHANNEL') }}</label>
                        <select id="add_channel_id" class="form-control form-select channel-custom-select" name="channel_id">
                            <option value="" disabled selected>{{ __('SELECT_CHANNEL') }}</option>
                            @foreach ($channel_filters as $channel)
                                    <option value="{{ $channel->id }}" {{ isset($post->channel_id) ? $channel->id == $post->channel_id ? 'selected': '' :''}}>{{ $channel->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">
                            <strong id="channel-error-message"></strong>
                        </span>
                    </div>

                    <div class="col-sm-6 col-md-6 mt-3">
                        <label for="topic_id" class="form-label">{{ __('SELECT_TOPIC') }}</label>
                        <select id="select-topic" class="form-control form-select" name="topic_id">
                            <option value="" disabled selected>{{ __('SELECT_TOPIC') }}</option>
                            @foreach ($news_topics as $topic)
                                    <option value="{{ $topic->id }}" {{ isset($post->topic_id) ? $topic->id == $post->topic_id ? 'selected': '' :''}}>{{ $topic->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">
                            <strong id="topic-error-message"></strong>
                        </span>
                    </div>
                    
                    <div class="col-sm-6 col-md-6 mt-3">
                        <label for="channel_id" class="form-label">{{ __('TYPE') }}</label>
                        <select id="select_type_posts" class="form-control form-select channel-custom-select" name="post_type">
                            <option value="post" {{isset($post->type) ? $post->type == 'post' ? 'selected' : "" :""}}>{{__('POST')}}</option>
                            <option value="video"{{isset($post->type) ? $post->type == 'video' ? 'selected' : "":""}}>{{__('VIDEO')}}</option>
                        </select>
                        <span class="text-danger">
                            <strong id="channel-error-message"></strong>
                        </span>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <label for="add-post-status" class="form-label">{{ __('STATUS') }}</label>
                        <select class="form-control form-select" name="status" id="add-post-status">
                            <option value="active"{{isset($post->type) ? $post->type== "active" ? 'selected' : "" : ""}}>{{ __('ACTIVE') }}</option>
                            <option value="inactive"{{isset($post->type) ? $post->type== "inactive" ? 'selected' : "" : ""}}>{{ __('INACTIVE') }}</option>
                        </select>
                        <span class="text-danger">
                            <strong id="status-error-message"></strong>
                        </span>
                    </div>

                    <div class="col-sm-6 col-md-6" id="posts_image_upload">
                        <label for="post-image-input" class="form-label">{{ __('IMAGE') }}</label>
                        <input type="file" name="image" id="post-image-input" class="form-control" accept="image/*">
                        <span class="text-danger">
                            <strong id="image-error-message"></strong>
                        </span>
                        <div class="mt-3">
                            <img id="post-image-preview" src="{{$post->image ??  asset('assets/images/no_image_available.png') }}" alt="img Preview" class="img-preview img-fluid">
                        </div>
                        <!-- Hidden post image container for cropping -->
                        <div id="cropper-container" class="d-none">
                            <img id="cropper-image" src="" alt="Crop img" />
                        </div>
                    </div>

                     <div class="col-sm-6 col-md-6 d-none" id="video_thumbnail">
                        <label for="video-thumb-input" class="form-label">{{ __('THUMBNAIL') }}</label>
                        <input type="file" name="thumb_image" id="video-thumb-input" class="form-control" accept="image/*">
                        <span class="text-danger">
                            <strong id="image-error-message"></strong>
                        </span>
                        <div class="mt-3">
                            <img id="video-thumb-preview" src="{{$post->video_thumb ??  asset('assets/images/no_image_available.png') }}" alt="img Preview" class="img-preview img-fluid">
                        </div>
                        <!-- Hidden thumb image container for cropping -->
                        <div id="thumb-cropper-container" class="d-none">
                            <img id="video-thumb-cropped" src="" alt="Crop img" />
                        </div>
                    </div>

                     <div class="col-sm-6 col-md-6 d-none" id="video_file">
                        <label for="post-image-input" class="form-label">{{ __('video') }}</label>
                        <input type="file" name="video" id="post-image-input" class="form-control" accept="video/*" onchange="readChapterVideo(this)";>
                        <span class="text-danger">
                            <strong id="image-error-message"></strong>
                        </span>
                        <div class="mt-3">
                            <video class="video-thumb preview-video" width="300" height="150" controls="controls">
                                <source src="{{$post->video ?? ''}}" id="video-preview" type="video/mp4">
                                <track src="descriptions_en.vtt" kind="descriptions" srclang="en" label="English Descriptions">
                            </video>
                        </div>
                    </div>
                </div>
                <div class="modal-footer gap-2">
                    <a href="{{url('admin/posts')}}" id="back_button" class="btn btn-secondary">{{ __('BACK') }}</a>
                    <button type="submit" id="submite_button" class="btn btn-primary waves-effect waves-light">{{ __('SAVE') }}</button>
                </div>
            </div>
        </form>
        </div>
    </section>
@endsection
