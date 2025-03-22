@extends('admin.layouts.main')
@section('title')
{{$title}}
@endsection
@section('pre-title')
{{$pre_title}}
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
        <div class="col-auto ms-auto d-print-none gap-1">
            <a class="btn btn-primary sync-btn fetch_all_feed" href="#" id="fetch_rssfeed">{{__('SYNC_FEEDS')}}</a>

            <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#addRssFeedModal">{{ __('CREATE') }}</a>
        </div>
    </div>
@endsection
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="input-icon">
                            <div class="col-auto d-print-none">
                                <div class="nav-item dropdown">
                                    <select id="feed_status" class="form-select mb-1">
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
                       <table class="table table-bordered text-nowrap border-bottom" id="rss-feed-list" data-url="{{ route('rss-feeds.show',1) }}">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">{{__('ID')}}</th>
                                    <th class="wd-15p border-bottom-0">{{__('CHANNELS')}}</th>
                                    <th class="wd-20p border-bottom-0">{{__('TOPICS')}}</th>
                                    <th class="wd-15p border-bottom-0">{{__('FEED_URL')}}</th>
                                    <th class="wd-15p border-bottom-0">{{__('DATA_FORMAT')}}</th>
                                    <th class="wd-15p border-bottom-0">{{__('SYNC_INTERVAL')}}</th>
                                    <th class="wd-15p border-bottom-0">{{__('STATUS')}}</th>
                                    <th class="wd-15p border-bottom-0">{{__('SYNC')}}</th>
                                    <th class="wd-15p border-bottom-0">{{__('ACTION')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" value="{{route('rss-feeds.store')}}" id="rssfeedstore">
        <input type="hidden" value="{{route('rsfeed.single-fetch')}}" id="rssfeedFetchSingle">
        <input type="hidden" id="channel_status_url" value="{{route('rsfeed.update.status')}}">
    </section>
@include('admin.models.rss-feed-model')

@endsection
