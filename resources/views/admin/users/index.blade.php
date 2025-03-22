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
                <a href="{{ url('admin/dashboard') }}">Home/</a>
                @yield('pre-title')
            </div>
            <h2 class="page-title">{{ __('USERS') }}</h2>
        </div>
        <div class="col-auto ms-auto d-print-none"></div>
        <div class="col-auto ms-auto d-print-none">
            <a class="btn btn-primary" href="#"data-bs-toggle="modal"
                data-bs-target="#userCreateModal">{{ __('CREATE') }}</a>
        </div>
    </div>
    {{-- Add User Model --}}
@endsection
{{-- What is this? --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
@section('content')
    <section class="section">
        <div class="card">
            <div class="page-wrapper">
                <div class="page-header d-print-none">
                    <div class="container-xl">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <div id="userCount" class="text-secondary mt-1">{{ __('LOADING') }}</div>
                            </div>
                            <div class="col-auto ms-auto d-print-none">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <div class="input-icon">
                                            <div class="col-auto d-print-none">
                                                <div class="nav-item dropdown">
                                                    <select id="user_status" class="form-select mb-2">
                                                        <option value="all_users">{{ __('All users') }}</option>
                                                        <option value="active">{{ __('ACTIVE') }}</option>
                                                        <option value="inactive">{{ __('INACTIVE') }}</option>
                                                        <option value="deleted_user">{{ __('DELETED') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="me-3">
                                        <div class="input-icon">
                                            <input type="search" id="searchUser"
                                                class="form-control d-inline-block w-100 w-lg-9 me-3"
                                                placeholder="{{ __('SEARCH') }}" />
                                            <span class="input-icon-addon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                    <path d="M21 21l-6 -6" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-body">
                        <div class="container-xl">
                            <!-- Card Rendering -->
                            <div id="userCards" class="row row-cards" data-url="{{ route('users.show', '') }}">
                                <div id="skeleton-loader" class="row row-cards">
                                    @for ($i = 0; $i < 8; $i++)
                                        <div class="col-sm-4 col-lg-3">
                                            <div class="card card-sm">
                                                <div class="skeleton-loader skeleton-loader-height"></div>
                                                <div class="card-body">
                                                    <span class="card-title skeleton-loader"></span>
                                                    <div class="d-flex align-items-center mt-2">
                                                        <div class="skeleton-loader skeleton-icone"></div>
                                                        <div>
                                                            <div class="skeleton-loader"></div>
                                                            <div class="skeleton-loader text-secondary"></div>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <b
                                                                class="text-secondary skeleton-loader skeleton-custom-width"></b>
                                                            <b
                                                                class="ms-3 text-secondary skeleton-loader skeleton-custom-width"></b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="d-flex mt-4">
                                <!-- Pagination Rendering -->
                                <ul class="pagination ms-auto" id="pagination">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="isDemoModel" value="{{config('app.demo_mode') ? 'demo_on' : 'demo_off'}}">
                </div>
            </div>
    </section>
    @include('admin.models.user-model')
@endsection
@section('script')
    <script src="{{ asset('assets/js/custom/user-data-update.js') }}"></script>
@endsection
