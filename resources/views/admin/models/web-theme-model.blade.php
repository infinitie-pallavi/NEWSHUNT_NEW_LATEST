<!-- Add Theme Modal -->
<div id="addWebTheme" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addWebThemeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('web_theme.store') }}" class="form-horizontal" enctype="multipart/form-data" id="addWebThemeForm" method="POST" data-parsley-validate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="webThemeModalLabel">{{ __('ADD_THEME') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="add-theme-name" class="form-label">{{ __('THEME_NAME') }}</label>
                        <input type="text" name="name" class="form-control" placeholder="{{__('PLEASE_ENTER_THEME_NAME')}}" id="add-theme-name" required>
                        <span class="text-danger" id="name-error-message"></span>
                    </div>
                    <div class="mb-3">
                        <label for="add-theme-status" class="form-label">{{ __('STATUS') }}</label>
                        <select class="form-select" name="status" id="add-theme-status" required>
                            <option value="" disabled selected>{{ __('SELECT_STATUS') }}</option>
                            <option value="1">{{ __('ACTIVE') }}</option>
                            <option value="0">{{ __('INACTIVE') }}</option>
                        </select>
                        <span class="text-danger" id="status-error-message"></span>
                    </div>
                    <div class="mb-3">
                        <label for="theme-logo-input" class="form-label">{{ __('LOGO') }}</label>
                        <input type="file" name="image" id="theme-logo-input" class="form-control" accept="image/*">
                        <span class="text-danger" id="logo-error-message"></span>
                        <div class="mt-2">
                            <img id="theme-logo-preview" src="{{ asset('assets/images/no_image_available.png') }}" alt="Logo Preview" class="img-privew img-fluid">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('CLOSE') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('SAVE') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Edit Theme Modal -->
<div id="editWebTheme" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editWebThemeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('web_theme.update', 0) }}" class="form-horizontal" method="POST" enctype="multipart/form-data" id="editWebThemeForm" data-parsley-validate data-update-url="{{ route('web_theme.update', '') }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="webThemeModalLabel">{{ __('EDIT_THEME') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="id" id="theme-id">
                        <label for="edit-theme-name" class="form-label">{{ __('THEME_NAME') }}</label>
                        <input type="text" name="name" class="form-control" placeholder="{{__('PLEASE_ENTER_THEME_NAME')}}" id="edit-theme-name" required>
                        <span class="text-danger" id="name-error-message"></span>
                    </div>
                    <div class="mb-3">
                        <label for="edit-theme-status" class="form-label">{{ __('STATUS') }}</label>
                        <select class="form-select" name="status" id="edit-theme-status" required>
                            <option value="" disabled selected>{{ __('SELECT_STATUS') }}</option>
                            <option value="1">{{__('ACTIVE') }}</option>
                            <option value="0">{{__('INACTIVE') }}</option>
                        </select>
                        <span class="text-danger" id="status-error-message"></span>
                    </div>
                    <div class="mb-3">
                        <label for="theme-logo-input" class="form-label">{{ __('LOGO') }}</label>
                        <input type="file" name="image" id="edit-theme-logo-input" class="form-control" accept="image/*">
                        <span class="text-danger" id="logo-error-message"></span>
                        <div class="mt-2">
                            <img id="edit-theme-logo-preview" src="{{ asset('assets/images/no_image_available.png') }}" alt="Logo Preview" class="img-privew img-fluid">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('CLOSE') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('SAVE') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
