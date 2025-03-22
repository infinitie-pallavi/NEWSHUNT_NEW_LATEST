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
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered text-nowrap border-bottom" id="contact_us_table" data-url="{{ route('contact-us.show') }}">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">{{__('ID')}}</th>
                                    <th class="wd-15p border-bottom-0">{{__('NAME')}}</th>
                                    <th class="wd-20p border-bottom-0">{{__('CONTACT_NUMBER')}}</th>
                                    <th class="wd-15p border-bottom-0">{{__('EMAIL')}}</th>
                                    <th class="wd-15p border-bottom-0">{{__('MESSAGE')}}</th>
                                    <th class="wd-15p border-bottom-0">{{__('ACTION')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <input type="hidden" value="{{route('rss-feeds.store')}}" id="rssfeedstore">
                </div>
            </div>
        </div>
        <input type="hidden" id="channel_status_url" value="{{route('rsfeed.update.status')}}">
    </section>
    @include('admin.models.contact-us-model')
@endsection
