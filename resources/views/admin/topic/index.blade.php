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
                <a href="{{url('admin/dashboard')}}">Home/</a>
                @yield('pre-title')
            </div>
            <h2 class="page-title">
                @yield('title')
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#addTopicModal">{{ __('CREATE') }}</a>
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
                                        <select id="topics_status" class="form-select mb-1">
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
                        <table class="table table-bordered text-nowrap border-bottom" id="topic-list"
                            data-url="{{ route('topics.show', 1) }}">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">{{ __('ID') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('IMAGE') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('NAME') }}</th>
                                    <th class="wd-20p border-bottom-0">{{ __('SLUG') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('STATUS') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('ACTION') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <label for="name" id="Channel_id" value="Channel_list"></label>
                </div>
            </div>
        </div>
        <input type="hidden" id="topic_status_url" value="{{route('topic.update.status')}}">
    </section>
@include('admin.models.topic-model')
@endsection
