@extends('admin.layouts.main')

@section('title')
    {{ $title }}
@endsection
@section('pre-title')
    {{ $pre_title }}
@endsection

@section('page-title')
    <div class="row g-2 align-items-center">
        <div class="col">
            <div class="page-pretitle">
            <a href="{{url('admin/dashboard')}}">{{ __('HOME') }}/</a>
            <a href="{{url('admin/roles')}}">{{ __('ROLE_MANAGEMENTS') }}/</a>
                @yield('pre-title')
            </div>
            <h2 class="page-title">
                @yield('title')
            </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <a class="btn btn-primary" href="{{ route('roles.index') }}"> {{ __('BACK') }}</a>
        </div>
    </div>
@endsection


@section('content')
    <div class="content-wrapper">
        <div class="row grid-margin">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            {!! Form::open([ 'route' => 'roles.store', 'method' => 'POST', 'class' => 'create-form', 'data-success-function' => 'roleSuccessFunction']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('NAME') }} <span class="text-danger">*</span></label>
                                        {!! Form::text('name', null, ['placeholder' => __('Name'), 'id'=>'name' ,'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div id="permission-list" class="mt-3">
                                </div>
                                <div class="permission-tree">
                                    <ul>
                                        @foreach ($groupedPermissions as $groupName => $groupData)
                                            <li data-jstree='{"opened":true}'>{{ ucwords(str_replace('-', ' ', $groupName)) }}
                                                @foreach ($groupData as $key => $permission)
                                                    <ul>
                                                        <li id="{{ $permission->id }}" data-name="{{ $permission->name }}"
                                                            data-jstree='{"icon":"fa fa-user-cog"}'>
                                                            {{ ucfirst($permission->short_name) }}</li>
                                                    </ul>
                                                @endforeach
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                                    <button type="submit" class="btn btn-primary">{{ __('SUBMIT') }}</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
