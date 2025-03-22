@extends('admin.layouts.main')

@section('title')
    {{__('CREATE_ADMIN')}}
@endsection
@section('pre-title')
    {{__('ADMIN_MANAGMENT')}}
@endsection

@section('page-title')
    <div class="row g-2 align-items-center">
        <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">
            <a href="{{url('admin/dashboard')}}">{{ __('HOME') }}/</a>
            <a href="{{url('admin/admin-users')}}">{{ __('ADMIN') }}/</a>
                @yield('pre-title')
            </div>
            <h2 class="page-title">
                @yield('title')
            </h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <a class="btn btn-primary" href="{{ route('admin-users.index') }}"> {{ __('BACK') }}</a>
        </div>
    </div>
@endsection

@section('page-title')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h4>@yield('title')</h4>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first"></div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin-users.store') }}" class="form-horizontal create-form" method="POST" data-parsley-validate>
                    <div class="card-body">
                        <h3 class="card-title">{{ __('Admin Details') }}</h3>
                        <div class="row row-cards">
                            <div class="col-sm-6 col-md-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label col-12 ">{{ __('ROLE') }}</label>
                                    <select name="role" id="role" class="form-control" data-parsley-required="true">
                                        <option value="">--{{ __('SELECT_ROLE') }}--</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="name" class="form-label col-12 ">{{ __('NAME') }}</label>
                                    <input type="text" id="name" class="form-control col-12" placeholder="{{ __('ENTER_NAME') }}"
                                        name="name" data-parsley-required="true">
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label col-12 ">{{ __('EMAIL') }}</label>
                                    <input type="email" id="email" class="form-control col-12" placeholder="{{__('ENTER_EMAIL')}}"
                                        name="email" data-parsley-required="true">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="password" class="form-label col-12 ">{{ __('PASSWORD') }}</label>
                                    <input type="password" id="password" class="form-control col-12" placeholder="{{__('ENTER_PASSWORD')}}"
                                        name="password" data-parsley-minlength="8" data-parsley-uppercase="1"
                                        data-parsley-lowercase="1" data-parsley-number="1" data-parsley-special="1"
                                        data-parsley-required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit"
                            class="btn btn-primary waves-effect waves-light">{{ __('SAVE') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
