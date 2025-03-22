@extends('admin.layouts.main')

@section('title')
{{  __('SEND_NOTIFICATION') }}
@endsection
@section('pre-title')
{{ __('SEND_NOTIFICATION') }}
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
    <div class="row">
        <section class="section">
         {{--    @can('notification-create')
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <form action="{{ route('notification.store') }}" class="create-form needs-validation" method="post" data-parsley-validate enctype="multipart/form-data">
                                <div class="card-body">
                                    <textarea id="user_id" name="user_id" class="d-none position-absolute" aria-label="user_id"></textarea>
                                    <textarea id="fcm_id" name="fcm_id" class="d-none position-absolute" aria-label="fcm_id_id"></textarea>
                                    
                                    <div class="form-group row">
                                        <div class="col-md-12 col-sm-12">
                                            <label for="send_to" class="form-label">{{ __('SELECT_USER') }} <span class="badge text-bg-info">For Selected only Please Select users From the right side table</span></label>
                                            <select id="send_to" name="send_to" class="form-control form-select" required>
                                                <option value="all">{{ __('ALL') }}</option>
                                                <option value="selected">{{ __('SELECTED_ONLY') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row mt-3">
                                        <div class="col-md-12 col-sm-12">
                                            <label for="title" class="form-label">{{ __('TITLE') }} <span class="text-danger">*</span></label>
                                            <input name="title" id="title" type="text" class="form-control" placeholder={{ __('TITLE') }} required>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-md-12">
                                            <label for="message" class="form-label">{{ __('MESSAGE') }} <span class="text-danger">*</span></label>
                                            <textarea id="message" name="message" class="form-control" placeholder={{ __('MESSAGE') }} required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3" id="show_image">
                                        <div class="col-md-12 col-sm-12">
                                            <label for="image" class="form-label">{{ __('IMAGE') }}</label>
                                            <input id="Notification_img" name="file" type="file" id="image" accept="image/*" class="form-control">
                                            <p id="img_error_msg" class="d-none badge rounded-pill bg-danger"></p>
                                            <div class="mt-3">
                                                <img id="Notification_preview" src="{{ asset('assets/images/no_image_available.png') }}" class="img-privew img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-end mt-3">
                                        <button class="btn btn-primary" type="submit" name="submit">{{ __('SUBMIT') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">

                                        <table class="table table-bordered text-nowrap border-bottom" id="user_list_data" data-url="{{ route('userList') }}">
                                        <thead>
                                            <tr>
                                                <th class="wd-1p border-bottom-0">
                                                    <input type="checkbox" id="select_all">
                                                </th>
                                                <th class="wd-15p border-bottom-0">{{ __('ID') }}</th>
                                                <th class="wd-20p border-bottom-0">{{ __('NAME') }}</th>
                                                <th class="wd-15p border-bottom-0">{{ __('NUMBER') }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan --}}

            <div class="card mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                          {{--  <div id="toolbar" class="mb-2">
                                @can('notification-delete')
                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm btn-icon text-white" id="delete_multiple" title="Delete Notification"><em class='fa fa-trash'></em></a>
                                @endcan
                            </div> --}}
                            <table class="table table-bordered text-nowrap border-bottom mt-3" id="notificationTable" data-url="{{ route('notification.show', 1) }}">
                                <thead>
                                    <tr>
                                       {{--  @can('notification-delete')
                                            <th class="wd-1p border-bottom-0">
                                                <input type="checkbox" id="select_all_notification">
                                            </th>
                                        @endcan --}}
                                        <th class="wd-10p border-bottom-0">{{ __('ID') }}</th>
                                        <th class="wd-20p border-bottom-0">{{ __('TITLE') }}</th>
                                        <th class="wd-15p border-bottom-0">{{ __('SLUG') }}</th>
                                        <th class="wd-20p border-bottom-0">{{ __('SEND TO') }}</th>
                                        <th class="wd-15p border-bottom-0">{{ __('ACTION') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
