@extends('admin.layouts.main')
@section('title')
{{ __('ABOUT_US') }}
@endsection
@section('pre-title')
{{ __('ABOUT_US') }}
@endsection
@section('page-title')
    <div class="row g-2 align-items-center">
        <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">
                <a href="{{url('admin/dashboard')}}">{{__('HOME')}}/</a>
                <a href="{{url('admin/settings')}}">{{__('SETTINGS')}}/</a>
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
            <form action="{{ route('settings.store') }}" method="post" id="about_us_form" class="create-form-without-reset">
                @csrf
                <div class="card-body">
                    <div class="row">
                            <span class="help-block text-danger d-none" id="about_us_error">
                                <strong>Please enter aboute us</strong>
                            </span>
                        <div class="col-md-12 mt-2">
                            <textarea id="tinymce_editor" name="about_us" class="form-control col-md-7 col-xs-12" aria-label="tinymce_editor">{{ $settings["about_us"] ??'' }}</textarea>
                        </div>
                    </div>
                    <div class="col-12 mt-3 d-flex justify-content-end">
                        <button class="btn btn-primary me-1 mb-1" id="about_us_submit" type="submit" name="submit">{{ __('SAVE') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
