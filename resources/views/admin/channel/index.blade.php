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
            <!-- Page pre-title -->
            <div class="page-pretitle">
                <a href="{{url('admin/dashboard')}}">Home/</a>
                @yield('pre-title')
            </div>
            <h2 class="page-title">{{ $title }}</h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <a class="btn btn-primary" href="#"data-bs-toggle="modal" data-bs-target="#addChannelModal">{{ __('CREATE') }}</a>
        </div>
    </div>
@endsection
@section('content')
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 overflow-x-scroll">
                   <div class="d-flex justify-content-end mb-3">
                        <div class="input-icon">
                            <div class="col-auto d-print-none">
                                <div class="nav-item dropdown">
                                    <select id="channel_status" class="form-select mb-1">
                                        <option value="*" disabled selected>
                                            {{ __('SELECT_STATUS') }}</option>
                                        <option value="*">{{ __('ALL') }}</option>
                                        <option value="active">{{ __('ACTIVE') }}</option>
                                        <option value="inactive">{{ __('INACTIVE') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered text-nowrap border-bottom" id="Channel_list"
                        data-url="{{ route('channels.show', 1) }}">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">{{ __('ID') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('LOGO') }}</th>
                                <th class="wd-20p border-bottom-0">{{ __('NAME') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('SLUG') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('DESCRIPTION') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('STATUS') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('FOLLOWERS') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('ACTION') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <input type=hidden id="channel_status_url" value="{{route('channel.update.status')}}">
</section>
@include('admin.models.channel-model')
@endsection
