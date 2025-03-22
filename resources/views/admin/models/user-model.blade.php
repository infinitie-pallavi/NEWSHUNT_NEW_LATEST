{{-- Create user data Model --}}
<div id="userCreateModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('users.store') }}" class="form-horizontal" id="user-add-form" enctype="multipart/form-data"
            method="POST" data-parsley-validate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">{{ __('USER_NAME') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12mb-3">
                            <label for="add-user-name" class="form-label">{{ __('USER_NAME') }}</label>
                            <input type="text" id="add-user-name" name="name" class="form-control"
                                placeholder="Please enter user name" value="{{ $user->name ?? '' }}" required>
                            <span class="text-danger d-none" id="name-error-message"></span>

                        </div>
                        <div class="col-12 mt-3">
                            <label for="add-user-email" class="form-label">{{ __('EMAIL') }}</label>
                            <input type="email" id="add-user-email" name="email" class="form-control"
                                placeholder="Please enter email" value="" required>
                            <span class="text-danger d-none" id="email-error-message"></span>
                        </div>

                        <div class="col-12 mt-3">
                            <label for="password" class="form-label">{{ __('PASSWORD') }}</label>
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Please enter email" value="" required>
                            <strong class="text-danger d-none" id="password-error-message"></strong>
                        </div>

                        <div class="col-12 mt-3">
                            <label for="password-confirm" class="form-label">{{ __('CONFIRM_PASSWORD') }}</label>
                            <input type="password" id="password-confirm" name="password_confirmation"
                                class="form-control" placeholder="Please enter email" value="" required>
                            <strong class="text-danger d-none" id="password-confirm-error-message"></strong>
                        </div>

                        <div class="col-12 important mt-3">
                            <label for="phone" class="form-label">{{ __('PHONE') }}</label>
                            <input type="tel" id="phone" name="phone" class="form-control"
                                placeholder="Please enter phone" required inputmode="numeric" pattern="[0-9]*"
                                title="Please enter a valid phone number">
                            <span class="text-danger d-none" id="password_confirmation-error-message"></span>
                        </div>

                        <div class="form-group mt-2">
                            <label for="add-user-status" class="form-label">{{ __('STATUS') }}</label>
                            <select class="form-control form-select" name="status" id="add-user-status">
                                <option value="" disabled selected>{{ __('SELECT_STATUS') }}</option>
                                <option value="active">{{ __('ACTIVE') }}</option>
                                <option value="inactive">{{ __('INACTIVE') }}</option>
                            </select>
                            <span class="text-danger">
                                <strong id="status-error-message"></strong>
                            </span>
                        </div>
                        <div class="col-12 mt-3">
                            <label for="add-user-profile-img" class="form-label">{{ __('PROFILE') }}</label>
                            <input type="file" name="profile" id="add-user-profile-img" class="mt-3 form-control"
                                accept=".jpg, .jpeg, .png, .svg">
                            <span class="text-danger">
                                <strong id="profile-error-message"></strong>
                            </span>
                            <span class="text-danger d-none" id="add-user-profile-error-message"></span>
                            <div class="mt-3 ">
                                <img id="add-user-profile-privew"
                                    src="{{ asset('assets/images/no_image_available.png') }}" alt="Logo Preview"
                                    class="img-privew img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"
                        class="btn btn-primary waves-effect waves-light">{{ __('SAVE') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>


{{-- Edite user data Model --}}
<div id="userEditModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="users/3" class="form-horizontal" id="user-edit-form" enctype="multipart/form-data"
            method="POST" data-parsley-validate>
            @csrf
            @method('patch')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">{{ __('EDIT_USER') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12mb-3">
                            <label for="edit-user-name" class="form-label">{{ __('USER_NAME') }}</label>
                            <input type="text" id="edit-user-name" name="name" class="form-control"
                                placeholder="Please enter user name" value="{{ $user->name ?? '' }}" required>
                            <span class="text-danger d-none" id="name-error-message"></span>

                        </div>
                        <div class="col-12 mt-3">
                            <label for="user-email" class="form-label">{{ __('EMAIL') }}</label>
                            <input type="email" id="user-email" name="email" class="form-control"
                                placeholder="Please enter email" value="" required disabled>
                        </div>
                        <div class="col-12 important mt-3">
                            <label for="phone" class="form-label">{{ __('PHONE') }}</label>
                            <input type="tel" id="edit-phone" name="phone" class="form-control"
                                placeholder="Please enter phone" required inputmode="numeric" pattern="[0-9]*"
                                title="Please enter a valid phone number">
                            <span class="text-danger d-none" id="phone-error-message"></span>
                        </div>

                        <div class="form-group mt-2">
                            <label for="status" class="form-label">{{ __('STATUS') }}</label>
                            <select class="form-control form-select" name="status" id="status">
                                <option value="" disabled selected>{{ __('SELECT_STATUS') }}</option>
                                <option value="active">{{ __('ACTIVE') }}</option>
                                <option value="inactive">{{ __('INACTIVE') }}</option>
                            </select>
                            <span class="text-danger">
                                <strong id="status-error-message"></strong>
                            </span>
                        </div>
                        <div class="col-12 mt-3">
                            <label for="" class="form-label">{{ __('PROFILE') }}</label>
                            <input type="file" name="profile" id="user-profile-img" class="mt-3 form-control"
                                accept=".jpg, .jpeg, .png, .svg">
                            <span class="text-danger d-none" id="user-profile-error-message"></span>
                            <div class="mt-3 ">
                                <img id="user-profile-privew"
                                    src="{{ asset('assets/images/no_image_available.png') }}" alt="Logo Preview"
                                    class="img-privew img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"
                        class="btn btn-primary waves-effect waves-light">{{ __('SAVE') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
