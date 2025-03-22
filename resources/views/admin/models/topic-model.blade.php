<!-- Add Topic Modal -->
<div id="addTopicModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addTopicModalLabel"aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('topics.store') }}" class="form-horizontal" enctype="multipart/form-data" id="addTopicForm"
            method="POST" data-parsley-validate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTopicModalLabel">{{ __('ADD_TOPIC') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">{{ __('TOPIC_NAME') }}</label>
                        <input type="text" name="name" class="form-control col-sm-6 col-md-6" placeholder="{{ __('PLEASE_ENTER_CHANNEL_NAME') }}" value="" required>
                        @if ($errors->has('name'))
                            <span class="help-block text-danger">
                                <strong id="name-error-message"></strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">{{ __('STATUS') }}</label>
                        <select class="form-control form-select" name="status">
                            <option value="">{{ __('SELECT_STATUS') }}</option>
                            <option value="active">{{ __('ACTIVE') }}</option>
                            <option value="inactive">{{ __('INACTIVE') }}</option>
                        </select>
                        <span class="help-block text-danger">
                            <strong id="status-error-message"></strong>
                        </span>
                    </div>
                   <div class="form-group mt-3">
                        <label for="topic-logo-input" class="form-label">{{ __('Logo') }}</label>
                        <input type="file" name="logo" id="topic-logo-input" class="form-control" accept="image/*">
                        <span class="text-danger">
                            <strong id="logo-error-message"></strong>
                        </span>
                        <div class="mt-3">
                            <img id="topic-logo-privew" src="{{ asset('assets/images/no_image_available.png') }}" alt="Logo Preview" class="img-privew">
                        </div>
                    
                        <!-- Hidden container for cropping (initially hidden) -->
                        <div id="cropper-container" class="d-none">
                            <img id="cropper-image" src="" alt="Crop Image" />
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('CLOSE') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('SAVE') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>



<!-- Edit Topic Modal -->
<div id="editTopicModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editTopicModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('topics.update', 0) }}" class="form-horizontal" enctype="multipart/form-data" id="edit-Topic-Form" method="POST" data-parsley-validate>
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="topic-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTopicModalLabel">{{ __('EDIT_TOPIC') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">{{ __('TOPIC_NAME') }}</label>
                        <input type="text" id="edit-topic-name" name="name" class="form-control col-sm-6 col-md-6" placeholder="{{ __('PLEASE_ENTER_TOPIC_NAME') }}" required>
                        @if ($errors->has('name'))
                            <span class="help-block text-danger">
                                <strong id="edit-name-error-message"></strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">{{ __('STATUS') }}</label>
                        <select id="edit-topic-status" class="form-control form-select" name="status">
                            <option value="">{{ __('SELECT_STATUS') }}</option>
                            <option value="active">{{ __('ACTIVE') }}</option>
                            <option value="inactive">{{ __('INACTIVE') }}</option>
                        </select>
                         <span class="help-block text-danger">
                            <strong id="edit-status-error-message"></strong>
                        </span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label">{{ __('Logo') }}</label>
                        <input type="file" name="logo" id="edit-topic-logo-input" class="form-control" accept="image/*">
                        <span class="text-danger">
                            <strong id="logo-error-message"></strong>
                        </span>
                        <div class="mt-3">
                            <img id="edit-topic-logo-privew" src="{{ asset('assets/images/no_image_available.png') }}"
                                alt="Logo Preview" class="img-privew">
                        </div>

                        <!-- Hidden container for cropping (initially hidden) -->
                        <div id="edit-cropper-container" class="d-none">
                            <img id="edit-cropper-image" src="" alt="Crop img" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('CLOSE') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('SAVE') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
