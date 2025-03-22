@extends('admin.layouts.main')

@section('title')
    {{__('SETTINGS')}}
@endsection
@section('pre-title')
{{__('SETTINGS')}}
@endsection

@section('page-title')
    <div class="row g-2 align-items-center">
        <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">
                <a href="{{url('admin/dashboard')}}">{{__('HOME')}}/</a>
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
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <a href="{{ route('settings.system') }}" class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-gear-wide-connected" viewBox="0 0 16 16">
                                        <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5m0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78zM5.048 3.967l-.087.065zm-.431.355A4.98 4.98 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8zm.344 7.646.087.065z"/>
                                      </svg>
                                    <div class="h3 ms-3 mb-0">{{ __('SYSTEM_SETTINGS') }}</div>
                                </div>
                                <div class="d-flex flex-column ms-auto text-end">
                                    <div class="h5 mb-0">{{ __('GO_TO_SETTING') }}
                                    <i class="fas fa-arrow-right mt-2 arrow_icon"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <a href="{{ route('settings.about-us.index') }}" class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                      </svg>
                                    <div class="h3 ms-3 mb-0">{{ __('ABOUT_US') }}</div>
                                </div>
                                <div class="d-flex flex-column ms-auto text-end">
                                    <div class="h5 mb-0">{{ __('GO_TO_SETTING') }}&nbsp; <i
                                            class="fas fa-arrow-right mt-2 arrow_icon"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <a href="{{ route('settings.terms-conditions.index') }}" class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center me-3">
                                    <i class=" fas fa-file-contract icon_font_size"></i> &nbsp;&nbsp;&nbsp;
                                    <div class="h3 mb-0">{{ __('TERMS_CONDITIONS') }}</div>
                                </div>
                                <div class="d-flex flex-column ms-auto text-end">
                                    <div class="h5 mb-0">{{ __('GO_TO_SETTING') }}&nbsp; <i
                                            class="fas fa-arrow-right mt-2 arrow_icon"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <a href="{{ route('settings.privacy-policy.index') }}" class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-shield-shaded" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 14.933a1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
                                      </svg>
                                    <div class="h3 ms-3 mb-0">{{ __('PRIVACY_POLICY') }}</div>
                                </div>
                                <div class="d-flex flex-column ms-auto text-end">
                                    <div class="h5 mb-0">{{ __('GO_TO_SETTING') }}&nbsp; <i
                                            class="fas fa-arrow-right mt-2 arrow_icon"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mt-3">
                <div class="card">
                    <a href="{{ route('language.index') }}" class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-translate" viewBox="0 0 16 16">
                                        <path d="M4.545 6.714 4.11 8H3l1.862-5h1.284L8 8H6.833l-.435-1.286zm1.634-.736L5.5 3.956h-.049l-.679 2.022z"/>
                                        <path d="M0 2a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v3h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zm7.138 9.995q.289.451.63.846c-.748.575-1.673 1.001-2.768 1.292.178.217.451.635.555.867 1.125-.359 2.08-.844 2.886-1.494.777.665 1.739 1.165 2.93 1.472.133-.254.414-.673.629-.89-1.125-.253-2.057-.694-2.82-1.284.681-.747 1.222-1.651 1.621-2.757H14V8h-3v1.047h.765c-.318.844-.74 1.546-1.272 2.13a6 6 0 0 1-.415-.492 2 2 0 0 1-.94.31"/>
                                      </svg>
                                    <div class="h3 ms-3 mb-0">{{ __('LANGUAGES') }}</div>
                                </div>
                                <div class="d-flex flex-column ms-auto text-end">
                                    <div class="h5 mb-0">{{ __('GO_TO_SETTING') }}&nbsp; <i
                                            class="fas fa-arrow-right mt-2 arrow_icon"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @hasrole('Admin')
                <div class="col-sm-6 col-lg-3 mt-3">
                    <div class="card">
                        <a href="{{ route('settings.error-logs.index') }}" class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center me-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-file-earmark-ruled" viewBox="0 0 16 16">
                                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5zM3 12v-2h2v2zm0 1h2v2H4a1 1 0 0 1-1-1zm3 2v-2h7v1a1 1 0 0 1-1 1zm7-3H6v-2h7z"/>
                                          </svg>
                                        <div class="h3 ms-3 mb-0">{{ __('LOG_VIEWER') }}</div>
                                    </div>
                                    <div class="d-flex flex-column ms-auto text-end">
                                        <div class="h5 mb-0">{{ __('GO_TO_SETTING') }}&nbsp; <i class="fas fa-arrow-right mt-2 arrow_icon"></i></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3 mt-3">
                    <div class="card">
                        <a href="{{ route('web_theme.index') }}" class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center me-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-images" viewBox="0 0 16 16">
                                            <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                                            <path d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2M14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1M2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1z"/>
                                          </svg>
                                        <div class="h3 ms-3 mb-0">{{ __('WEB_THEME') }}</div>
                                    </div>
                                    <div class="d-flex flex-column ms-auto text-end">
                                        <div class="h5 mb-0">{{ __('GO_TO_SETTING') }}&nbsp;
                                        <i class="fas fa-arrow-right mt-2 arrow_icon"></i></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endhasrole

            <div class="col-sm-6 col-lg-3 mt-3">
                <div class="card">
                    <a href="{{ route('system-update.index') }}" class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="fas fa-sync-alt icon_font_size"></i>
                                    <div class="h3 mb-0">{{ __('SYSTEM_UPDATE') }}</div>
                                </div>
                                <div class="d-flex flex-column ms-auto text-end">
                                    <div class="h5 mb-0">{{ __('GO_TO_SETTING') }}&nbsp; <i class="fas fa-arrow-right mt-2 arrow_icon"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            
            <div class="col-sm-6 col-lg-3 mt-3">
                <div class="card">
                    <a href="{{ route('settings.firebase.index') }}" class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-fire" viewBox="0 0 16 16">
                                    <path d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16m0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15"/>
                                    </svg>
                                    <div class="h3 mb-0">{{ __('Firebase') }}</div>
                                </div>
                                <div class="d-flex flex-column ms-auto text-end">
                                    <div class="h5 mb-0">{{ __('GO_TO_SETTING') }}&nbsp; <i class="fas fa-arrow-right mt-2 arrow_icon"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 mt-3">
                <div class="card">
                    <a href="{{ route('settings.cronjob.info') }}" class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-clock-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                                </svg>
                                    <div class="h3 mb-0">{{ __('Cronjob Info') }}</div>
                                </div>
                                <div class="d-flex flex-column ms-auto text-end">
                                    <div class="h5 mb-0">{{ __('GO_TO_SETTING') }}&nbsp; <i class="fas fa-arrow-right mt-2 arrow_icon"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
