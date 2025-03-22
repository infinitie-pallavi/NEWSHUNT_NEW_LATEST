@extends('admin.layouts.main')

@section('title')
    {{$title}}
@endsection
@section('pre-title')
    {{$title}}
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
            @can('role-create')

                    <a class="btn btn-primary" href="{{ route('admin-users.create') }}">{{__('CREATE_ADMIN')}}</a>

            @endcan
        </div>
    </div>
@endsection

@section('content')

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered text-nowrap border-bottom" id="admin_user_list" data-url="{{ route('admin-users.show',1) }}">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">{{__("ID")}}</th>
                                    <th class="wd-15p border-bottom-0">{{__("NAME")}}</th>
                                    <th class="wd-20p border-bottom-0">{{__("Email")}}</th>
                                    <th class="wd-15p border-bottom-0">{{__("STATUS")}}</th>
                                    <th class="wd-15p border-bottom-0">{{__('ACTION')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @can('adminuser-update')
        <!-- EDIT USER MODEL MODEL -->
        <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">{{__("Edit Staff")}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="form-horizontal edit-form" method="POST" data-parsley-validate>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group mandatory">
                                        <label for="edit_role" class="form-label col-12">{{__("Role")}}</label>
                                        <select name="role_id" id="edit_role" class="form-control" data-parsley-required="true">
                                            <option value="">--{{__("Select Role")}}--</option>
                                            @foreach ($roles as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12 mt-3">
                                    <div class="form-group mandatory">
                                        <label for="edit_name" class="form-label col-12">{{__("Name")}}</label>
                                        <input type="text" id="edit_name" class="form-control col-12" placeholder="Name" name="name" data-parsley-required="true">
                                    </div>
                                </div>

                                <div class="col-md-12 col-12 mt-3">
                                    <div class="form-group mandatory">
                                        <label for="edit_email" class="form-label col-12">{{__("Email")}}</label>
                                        <input type="email" id="edit_email" class="form-control col-12" placeholder="email" name="email" data-parsley-required="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{__("Close")}}</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">{{__("Save")}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- RESET PASSWORD MODEL -->
        <div id="resetPasswordModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">{{__("Password Reset")}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="form-horizontal edit-form" data-parsley-validate role="form" method="post">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group mandatory">
                                    <label for="new_password" class="form-label">{{__("New Password")}}</label>
                                    <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New password" data-parsley-minlength="8" data-parsley-uppercase="1" data-parsley-lowercase="1" data-parsley-number="1" data-parsley-special="1" data-parsley-required="true">
                                </div>
                                <div class="form-group mandatory">
                                    <label for="confirm_password" class="form-label">{{__("Confirm Password")}}</label>
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm password" data-parsley-equalto="#new_password" minlength="4" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{__("Close")}}</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">{{__("Save")}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection
