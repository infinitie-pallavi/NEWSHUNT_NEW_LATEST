@extends('admin.layouts.main')

@section('title')
    {{ __('SYSTEM_SETTINGS') }}
@endsection
@section('page-pretitle')
    {{ __('System Settings') }}
@endsection

@section('page-title')
    <div class="row g-2 align-items-center">
        <div class="col">
            <div class="page-pretitle">
                <a href="{{url('admin/dashboard')}}">{{__('HOME')}}/</a>
                <a href="{{url('admin/settings')}}">{{__('SETTINGS')}}/</a>
                @yield('title')
            </div>
            <h4 class="page-title">@yield('title')</h4>
        </div>
        <div class="col-auto ms-auto d-print-none">
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <form class="create-form-without-reset" action="{{ route('settings.store') }}" method="post"
            enctype="multipart/form-data" data-success-function="SystemSuccessFunction" data-parsley-validate>
            @csrf
            <div class="row d-flex mb-3">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('COMPANY_DETAILS') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 form-group mandatory">
                                    <label for="company_name"
                                        class="col-sm-6 col-md-6 form-label">{{ __('COMPANY_NAME') }}</label>
                                    <input name="company_name" type="text" class="form-control" id="company_name"
                                        placeholder="{{ __('Company Name') }}" value="{{ $settings['company_name'] ?? '' }}"
                                        required />
                                </div>
                                <div class="col-sm-12 form-group mandatory mt-3">
                                    <label for="company_email"
                                        class="col-sm-12 col-md-6 form-label mt-1">{{ __('EMAIL') }}</label>
                                    <input id="company_email" name="company_email" type="email" class="form-control"
                                        placeholder="{{ __('ENTER_EMAIL') }}" value="{{ $settings['company_email'] ?? '' }}"
                                        required />
                                </div>

                                <div class="col-sm-12 form-group mandatory mt-3">
                                    <label for="company_tel1"
                                        class="col-sm-12 col-md-6 form-label mt-1">{{ __('CONTACT_NUMBER') . ' 1' }}</label>
                                    <input id="company_tel1" name="company_tel1" type="text" class="form-control"
                                        placeholder="{{ __('CONTACT_NUMBER') . ' 1' }}" maxlength="16"
                                        onKeyDown="if(this.value.length==16 && event.keyCode!=8) return false;"
                                        value="{{ $settings['company_tel1'] ?? '' }}" required>
                                </div>

                                <div class="col-sm-12">
                                    <label for="company_tel2"
                                        class="col-sm-12 col-md-6 form-label mt-3">{{ __('CONTACT_NUMBER') . ' 2' }}</label>
                                    <input id="company_tel2" name="company_tel2" type="text" class="form-control"
                                        placeholder="{{ __('CONTACT_NUMBER') . ' 2' }}" maxlength="16"
                                        onKeyDown="if(this.value.length==16 && event.keyCode!=8) return false;"
                                        value="{{ $settings['company_tel2'] ?? '' }}">
                                </div>

                                <div class="col-sm-12">
                                    <label for="company_address"
                                        class="col-sm-12 col-md-6 form-label mt-3">{{ __('ADDRESS') }}</label>
                                    <textarea id="company_address" name="company_address" type="text" class="form-control"
                                        placeholder="{{ __('ENTER_ADDRESS') }}">{{ $settings['company_address'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('FCM_NOTIFICATION_SETTINGS') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 form-group mandatory">
                                    <label for="firebase_project_id"
                                        class="form-label">{{ __('FIREBASE_PROJECT_ID') }}</label>
                                    <input type="text" id="firebase_project_id" name="firebase_project_id"
                                        class="form-control" placeholder="{{ __('ENTER_FIREBASE_PROJECT_ID') }}"
                                        value="{{ $settings['firebase_project_id'] ?? '' }}" />
                                </div>
                                <div class="col-sm-12 form-group mandatory mt-3">
                                    <label for="service_file" class="form-label">{{ __('SERVICE_JSON_FILE') }}</label>
                                    <input id="service_file" name="service_file" type="file" class="form-control" />
                                    <span>{{__('ACCEPT_ONLY_JSON_FILE')}}</span>
                                    <p id="img_error_msg" class="badge rounded-pill bg-danger d-none"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('SCRIPTS') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 form-group mandatory">
                                    <label for="firebase_project_id"
                                        class="form-label">{{ __('Header Script') }}</label>
                                    <textarea id="header_script" name="header_script" type="text" class="form-control"
                                        placeholder="{{ __('INSERT_HEADER_SCRIPT') }}">{{ $settings['header_script'] ?? '' }}</textarea>
                                </div>
                                <div class="col-sm-12 form-group mandatory mt-3">
                                    <label for="service_file" class="form-label">{{ __('Footer Script') }}</label>
                                    <textarea id="footer_script" name="footer_script" type="text" class="form-control"
                                        placeholder="{{ __('INSERT_FOOTER_SCRIPT') }}">{{ $settings['footer_script'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('SOCIAL_MEDIA_LINKS') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 form-group mandatory">
                                    <label for="instagram_link" class="form-label ">{{ __('INSTAGRAM_LINK') }}</label>
                                    <input id="instagram_link" name="instagram_link" type="url" class="form-control"
                                        placeholder="{{ __('ENTER_INSTAGRAM_LINK') }}"
                                        value="{{ $settings['instagram_link'] ?? '' }}">
                                </div>
                                <div class="col-sm-6 form-group mandatory">
                                    <label for="x_link" class="form-label ">{{ __('X_LINK') }}</label>
                                    <input id="x_link" name="x_link" type="url" class="form-control"
                                        placeholder="{{ __('ENTER_X_LINK') }}" value="{{ $settings['x_link'] ?? '' }}">
                                </div>
                                <div class="col-sm-6 form-group mandatory mt-3">
                                    <label for="facebook_link" class="form-label ">{{ __('FACEBOOK_LINK') }}</label>
                                    <input id="facebook_link" name="facebook_link" type="url" class="form-control"
                                        placeholder="{{ __('ENTER_FACEBOOK_LINK') }}"
                                        value="{{ $settings['facebook_link'] ?? '' }}">
                                </div>
                                 <div class="col-sm-6 form-group mandatory mt-3">
                                   <label for="linkedin_link" class="form-label ">{{ __('LINKEDIN_LINK') }}</label>
                                    <input id="linkedin_link" name="linkedin_link" type="url" class="form-control"
                                        placeholder="{{ __('ENTER_LINKEDIN_LINK') }}"
                                        value="{{ $settings['linkedin_link'] ?? '' }}">
                                </div>
                                <div class="col-sm-6 form-group mandatory mt-3">
                                    <label for="pinterest_link" class="form-label ">{{ __('PINTEREST_LINK') }}</label>
                                    <input id="pinterest_link" name="pinterest_link" type="url" class="form-control"
                                        placeholder="{{ __('ENTER_PINTEREST_LINK') }}"
                                        value="{{ $settings['pinterest_link'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- AWS settings --}}
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('AWS_S3_BUCKET') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 form-group mandatory">
                                    <label for="s3_bucket_name" class="form-label ">{{ __('S3_BUCKET_NAME') }}</label>
                                    <input id="s3_bucket_name" name="s3_bucket_name" type="text" class="form-control" placeholder="{{ __('ENTER_S3_BUCKET_NAME') }}" value="{{ $settings['s3_bucket_name'] ?? '' }}">
                                </div>
                                <div class="col-sm-6 form-group mandatory">
                                    <label for="s3_bucket_url" class="form-label ">{{ __('S3_BUCKET_URL') }}</label>
                                    <input id="s3_bucket_url" name="s3_bucket_url" type="url" class="form-control" placeholder="{{ __('ENTER_S3_BUCKET_URL') }}" value="{{ $settings['s3_bucket_url'] ?? '' }}">
                                </div>
                                <div class="col-sm-6 form-group mandatory">
                                    <label for="aws_access_key_id" class="form-label mt-3">{{ __('AWS_ACCESS_KEY_ID') }}</label>
                                    <input id="aws_access_key_id" name="aws_access_key_id" type="text" class="form-control" placeholder="{{ __('AWS_ACCESS_KEY_ID') }}" value="{{ $settings['aws_access_key_id'] ?? '' }}">
                                </div>
                                <div class="col-sm-6 form-group mandatory">
                                    <label for="aws_secret_access_key" class="form-label mt-3">{{ __('AWS_SECRET_ACCESS_KEY') }}</label>
                                    <input id="aws_secret_access_key" name="aws_secret_access_key" type="text" class="form-control" placeholder="{{ __('ENTER_AWS_SECRET_ACCESS_KEY') }}" value="{{ $settings['aws_secret_access_key'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('OTHER_SETTINGS') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 form-group mandatory">
                                   <label for="play_store_link" class="form-label ">{{ __('PLAY_STORE_LINK') }}</label>
                                    <input id="play_store_link" name="play_store_link" type="url" class="form-control" placeholder="{{ __('EMTER_PLAY_STORE_LINK') }}" value="{{ $settings['play_store_link'] ?? '' }}">
                                </div>
                                <div class="col-sm-6 form-group mandatory">
                                    <label for="app_store_link" class="form-label ">{{ __('APP_STORE_LINK') }}</label>
                                    <input id="app_store_link" name="app_store_link" type="url" class="form-control" placeholder="{{ __('EMTER_APP_STORE_LINK') }}" value="{{ $settings['app_store_link'] ?? '' }}">
                                </div>
                                <div class="col-sm-6 form-group mandatory mt-3">
                                   <label for="android_shceme" class="form-label ">{{ __('ANDROID_SCHEME') }}</label>
                                    <input id="android_shceme" name="android_shceme" type="text" class="form-control" placeholder="{{ __('EMTER_ANDROID_SCHEME') }}" value="{{ $settings['android_shceme'] ?? '' }}">
                                </div>
                                <div class="col-sm-6 form-group mandatory mt-3">
                                    <label for="ios_shceme" class="form-label ">{{ __('IOS_SCHEME') }}</label>
                                    <input id="ios_shceme" name="ios_shceme" type="text" class="form-control" placeholder="{{ __('EMTER_IOS_SCHEME') }}" value="{{ $settings['ios_shceme'] ?? '' }}">
                                </div>
                                
                                <div class="col-sm-6 form-group mandatory mt-3">
                                    <label for="keep_old_posts" class="form-label ">{{ __('HOW_MANY_DAYS_OLD_POSTS_SHOULD_BE_KEPT') }}</label>
                                    <input id="keep_old_posts" name="keep_old_posts" type="number" class="form-control" placeholder="{{ __('ENTER_IN_DAYS') }}" value="{{ $settings['keep_old_posts'] ?? '' }}" oninput="this.value = Math.abs(this.value)" min="0" required>
                                    <span class="fs-5">({{__('PLEASE_ENTER_MORE_THAN_10_DAYS')}})</span>
                                </div>
                                
                                <div class="col-sm-6 form-group mandatory mt-3">
                                    <label for="keep_old_notification" class="form-label ">{{ __('HOW_MANY_DAYS_OLD_NOTIFICATIONS_SHOULD_BE_KEPT') }}</label>
                                    <input id="keep_old_notification" name="keep_old_notification" type="number" class="form-control" placeholder="{{ __('ENTER_IN_DAYS') }}" value="{{ $settings['keep_old_notification'] ?? '' }}" oninput="this.value = Math.abs(this.value)" min="0" required>
                                </div>
                                
                                <div class="form-group col-sm-6 col-md-6 mt-3">
                                    <label for="app_name" class="form-label">{{ __('APP_NAME') }}</label>
                                    <input id="app_name" name="app_name" type="text" class="form-control" placeholder="{{ __('ENTER_APP_NAME') }}" value="{{ $settings['app_name'] ?? '' }}" required>
                                </div>

                                 <div class="col-sm-6 form-group mandatory mt-3">
                                    <label for="" class="form-label">{{ __('MAINTENANCE_MODE') }}</label>
                                    <div class="form-check form-switch">
                                       <input type="hidden" name="maintenance_mode" id="maintenance_mode" class="checkbox-toggle-switch-input" value="{{ $settings['maintenance_mode'] ?? 0 }}">
                                    <input class="form-check-input checkbox-toggle-switch" type="checkbox" role="switch" aria-checked="{{ $settings['maintenance_mode'] == 1 ? 'true' : 'false' }}" id="switch_maintenance_mode" {{ $settings['maintenance_mode'] == 1 ? 'checked' : '' }}>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('SUBSCRIBE_MODEL') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 form-group mandatory">
                                   <label for="subscribe_model_title" class="form-label ">{{ __('MODEL_TITLE') }}</label>
                                    <textarea id="subscribe_model_title" name="subscribe_model_title" class="form-control" placeholder={{ __('subscribe_model_title') }} required>{{ $settings['subscribe_model_title'] ?? '' }}</textarea>
                                </div>
                                <div class="col-sm-6 form-group mandatory">
                                    <label for="subscribe_model_sub_title" class="form-label ">{{ __('MODEL_SUB_TITLE') }}</label>
                                    <textarea id="subscribe_model_sub_title" name="subscribe_model_sub_title" class="form-control" placeholder={{ __('subscribe_model_sub_title') }} required>{{ $settings['subscribe_model_sub_title'] ?? '' }}</textarea>
                                </div>

                                <div class="col-sm-6 form-group mandatory mt-3">
                                    <label for="" class="form-label">{{ __('MODEL_STATUS') }}</label>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="subscribe_model_status" id="subscribe_model_status" class="checkbox-toggle-switch-input" value="{{ $settings['subscribe_model_status'] ?? 0 }}">
                                        <input class="form-check-input checkbox-toggle-switch" type="checkbox" role="switch" {{ !empty($settings['subscribe_model_status']) && $settings['subscribe_model_status'] == '1' ? 'checked' : '' }} id="switch_maintenance_mode" aria-checked="{{ !empty($settings['subscribe_model_status']) && $settings['subscribe_model_status'] == '1' ? 'true' : 'false' }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 form-group mandatory">
                                    <label for="" class=" col-form-label ">{{ __('MODEL_IMAGE') }}</label>
                                    <input class="filepond" type="file" name="subscribe_model_image" id="subscribe_model_image">
                                    <img src="{{ $settings['subscribe_model_image'] ?? '' }}"
                                        data-custom-image="{{ asset('assets/images/logo/favicon.png') }}"
                                        class="img-privew mt-2 favicon_icon" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('LOGO_IMAGES') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 form-group mandatory">
                                    <label for="" class=" col-form-label ">{{ __('Favicon') }}</label>
                                    <input class="filepond" type="file" name="favicon_icon" id="favicon_icon">
                                    <img src="{{ $settings['favicon_icon'] ?? '' }}"
                                        data-custom-image="{{ asset('assets/images/logo/favicon.png') }}"
                                        class="img-privew mt-2 favicon_icon" alt="">
                                </div>

                                <div class="col-sm-6 form-group mandatory mt-2">
                                    <label for="" class="form-label ">{{ __('Sidebar Logo') }}</label>
                                    <input class="filepond" type="file" name="company_logo" id="company_logo">
                                    <img src="{{ $settings['company_logo'] ?? '' }}"
                                        data-custom-image="{{ asset('assets/images/logo/logo.png') }}"
                                        class="img-privew mt-2 company_logo" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('WEB_SETTINGS') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 form-group mandatory mt-3">
                                    <label for="" class="form-label ">{{ __('News Label') }}</label>
                                    <input class="form-control" type="text" name="news_label_place_holder" value="{{ $settings['news_label_place_holder'] ?? '' }}" id="news_label_place_holder">
                                </div>

                                 <div class="col-sm-6 form-group mandatory mt-3">
                                    <label for="weather_api_key" class="form-label ">{{ __('WEATHER_API_KEY') }}</label>
                                    <input class="form-control" type="text" name="weather_api_key" placeholder={{ __('ENTER_WEATHER_API_KEY') }} value="{{ $settings['weather_api_key'] ?? '' }}" id="weather_api_key">
                                </div>

                                <div class="col-sm-6 form-group mandatory mt-3">
                                    <label for="light_logo" class="form-label ">{{ __('LIGHT_LOGO') }}</label>
                                    <input class="filepond" type="file" name="light_logo" id="light_logo">
                                    <img src="{{ $settings['light_logo'] ?? '' }}" data-custom-image="{{ asset('assets/images/logo/sidebar_logo.png') }}" class="img-privew" alt="">
                                </div>

                                <div class="col-sm-6 form-group mandatory mt-3">
                                    <label for="dark_logo" class="form-label ">{{ __('DARK_LOGO') }}</label>
                                    <input class="filepond" type="file" name="dark_logo" id="dark_logo">
                                    <img src="{{ $settings['dark_logo'] ?? '' }}" data-custom-image="{{ asset('assets/images/logo/sidebar_logo.png') }}" class="img-privew" alt="">
                                </div>

                                <div class="col-sm-12 d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" value="btnAdd" class="btn btn-primary me-1 mb-3">{{ __('SAVE') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </section>
@endsection
