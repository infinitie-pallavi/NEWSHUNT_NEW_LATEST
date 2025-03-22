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
            <!-- Page pre-title -->
            <div class="page-pretitle">
            <a href="{{url('admin/dashboard')}}">{{ __('HOME') }}/</a>
                @yield('pre-title')
            </div>
            <h2 class="page-title">
                @yield('title')
            </h2>
        </div>
        <!-- Page title actions -->

        <div class="col-auto ms-auto d-print-none">

            <a class="btn btn-primary" href="{{ route('roles.create') }}">{{ __('CREATE_NEW_ROLE') }}</a>
        </div>
    </div>
@endsection
@section('content')

<div class="card">
    @can('role-list')
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered text-nowrap border-bottom" id="roal-list" data-url="{{ route('roles.show',1) }}">
                    <thead>
                        <tr>
                            <th class="wd-15p border-bottom-0">{{__('ID')}}</th>
                            <th class="wd-20p border-bottom-0">{{__('NO') }}</th>
                            <th class="wd-15p border-bottom-0">{{__('NAME')}}</th>
                            <th class="wd-15p border-bottom-0">{{__('ACTION')}}</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <label for="name" id="Channel_id" value="Channel_list"></label>
        </div>
    </div>
    @endcan
</div>
@endsection