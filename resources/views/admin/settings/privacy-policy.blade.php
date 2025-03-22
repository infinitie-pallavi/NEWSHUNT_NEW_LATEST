@extends('admin.layouts.main')
@section('title')
{{ __('PRIVACY_POLICY') }}
@endsection
@section('pre-title')
{{ __('PRIVACY_POLICY') }}
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
            <form action="{{ route('settings.store')}}" method="post" id="Privacy_and_policy" class="create-form-without-reset">
                @csrf
                <div class="card-body">
                    <div class="row form-group">
                        <div class="d-flex justify-content-end">
                      
                             <div>
                            <a href="{{ route('public.privacy-policy') }}" target="_blank" class="btn btn-primary btn-sm col-sm-12 col-md-12 d-fluid rounded-pill gap-1">
                                <i class="bi bi-eye-fill"></i>Privew
                            </a>
                            </div>
                        </div>
                            <span class="help-block text-danger d-none" id="privacy_policy_error">
                                <strong>Please enter Privacies and ploicies</strong>
                            </span>
                        <div class="col-md-12 mt-2">
                            <textarea id="tinymce_editor" name="privacy_policy" class="form-control col-md-7 col-xs-12" aria-label="tinymce_editor">{{ $settings['privacy_policy'] }}</textarea>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button class="btn btn-primary me-1 mb-3" id="submit_button" type="submit" name="submit">{{ __('SAVE') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
