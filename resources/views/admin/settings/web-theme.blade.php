@extends('admin.layouts.main')
@section('title')
{{ __('WEB_THEME') }}
@endsection
@section('pre-title')
{{ __('WEB_THEME') }}
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
            <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#addWebTheme">{{ __('CREATE') }}</a>
        </div>
    </div>
@endsection
@section('content')
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered text-nowrap border-bottom" id="theme_table" data-url="{{ route('web_theme.show',1) }}">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">{{ __('ID') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('IMAGE') }}</th>
                                <th class="wd-20p border-bottom-0">{{ __('NAME') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('SLUG') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('IS_DEFAULT') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('ACTION') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="theme_status_url" value="{{route('web_theme.update.status')}}">
</section>
@include('admin.models.web-theme-model')
@endsection
