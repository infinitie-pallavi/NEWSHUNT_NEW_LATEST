@extends('admin.layouts.main')

@section('title')
{{__("Firebase Settings")}}
@endsection
@section('pre-title')
{{__("Firebase Settings")}}
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
        </div>
    </div>
@endsection
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Details') }}</h3>
            </div>
            <form class="create-form-without-reset" action="{{ route('settings.firebase.update') }}" method="POST">
                <div class="card-body">
                    <div class="row row-cards">
                        
                        <div class="col-sm-6 col-md-6">
                            <label for="role" class="form-label col-12 ">{{__("Api Key")}}</label>
                            <input name="apiKey" type="text" class="form-control" placeholder="{{__("Api Key")}}" id="apiKey" value="{{ $settings['apiKey'] ?? '' }}" required="">
                        </div>

                        <div class="col-md-6">
                            <label for="name" class="form-label col-12 ">{{__("Auth Domain")}}</label>
                            <input type="text" required name="authDomain" class="form-control col-12" placeholder="{{__("Auth Domain")}}" id="authDomain" value="{{ $settings['authDomain'] ?? '' }}">
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <label for="projectId" class="form-label col-12 ">{{__("Project Id")}}</label>
                            <input type="text" id="projectId" class="form-control col-12" placeholder="{{__("Project Id")}}" name="projectId" value="{{ $settings['projectId'] ?? '' }}" data-parsley-required="true">
                        </div>
                        <div class="col-md-6">
                            <label for="storageBucket" class="form-label col-12 ">{{__("Storage Bucket")}}</label>
                            <input type="text" id="storageBucket" class="form-control col-12" placeholder="{{__("Storage Buckets")}}" name="storageBucket" value="{{ $settings['storageBucket'] ?? '' }}" data-parsley-required="true">
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <label for="messagingSenderId" class="form-label col-12 ">{{__("Messaging Sender Id")}}</label>
                            <input type="text" id="messagingSenderId" class="form-control col-12" placeholder="{{__("Project Id")}}" name="messagingSenderId" value="{{ $settings['messagingSenderId'] ?? '' }}" data-parsley-required="true">
                        </div>
                        <div class="col-md-6">
                            <label for="appId" class="form-label col-12 ">{{__("App Id")}}</label>
                            <input type="text" id="appId" class="form-control col-12" placeholder="{{__("App Id")}}" name="appId" value="{{ $settings['appId'] ?? '' }}" data-parsley-required="true">
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <label for="measurementId" class="form-label col-12 ">{{__("Measurement Id")}}</label>
                            <input type="text" id="measurementId" class="form-control col-12" placeholder="{{__("Measurement Id")}}" name="measurementId" value="{{ $settings['measurementId'] ?? '' }}" data-parsley-required="true">
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label for="" class="form-label col-12">{{ __('Service account file ') }}</label>
                            <input name="firebase_json_file" class="form-control col-12" type="file" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('SAVE') }}</button>
                </div>
            </form>
        </div>
    </section>
@endsection
