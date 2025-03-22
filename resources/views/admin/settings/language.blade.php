@extends('admin.layouts.main')
@section('title')
    {{ __('LANGUAGES') }}
@endsection
@section('pre-title')
    {{ __('LANGUAGES') }}
@endsection
@section('page-title')
    <div class="row g-2 align-items-center">
        <div class="col">
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
            <button class="btn btn-primary add_btn" data-bs-target='#addModal' data-bs-toggle='modal' title='Create'>{{ __('CREATE') }}</button>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="row">
            
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered text-nowrap border-bottom" id="language_list"
                                    data-url="{{ route('language.show', 1) }}">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">{{ __('ID') }}</th>
                                            <th class="wd-20p border-bottom-0">{{ __('NAME') }}</th>
                                            <th class="wd-15p border-bottom-0">
                                                {{ __('Name') . ' (' . __('in English') . ')' }}
                                            </th>
                                            <th class="wd-15p border-bottom-0">{{ __('Language Code') }}</th>
                                            <th class="wd-15p border-bottom-0">{{ __('RTL') }}</th>
                                            <th class="wd-15p border-bottom-0">{{ __('Image') }}</th>
                                            <th class="wd-15p border-bottom-0">{{ __('ACTION') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.models.language-add-edit')
@endsection
