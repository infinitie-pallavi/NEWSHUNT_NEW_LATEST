<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" class="form-horizontal" id="edit-form" enctype="multipart/form-data" method="POST"
            data-parsley-validate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel3">{{ __('Edit Language') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-md-12 col-12">
                                <div class="form-group mandatory">
                                    <label for="edit_name" class="form-label col-12">{{ __('Language Name') }}</label>
                                    <input type="text" id="edit_name" class="form-control col-12"
                                        placeholder="{{ __('Name') }}" name="name" data-parsley-required="true">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="col-md-12 col-12 mt-3">
                                <div class="form-group mandatory">
                                    <label for="edit_name_in_english"
                                        class="form-label col-12">{{ __('Language Name') }}({{ __('in English') }})</label>
                                    <input type="text" id="edit_name_in_english" class="form-control col-12"
                                        placeholder="{{ __('Name') }}" name="name_in_english"
                                        data-parsley-required="true">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-md-12 col-12 mt-3">
                                <div class="form-group mandatory">
                                    <label for="edit_code" class="form-label col-12">{{ __('Language Code') }}</label>
                                    <input type="text" id="edit_code" class="form-control col-12"
                                        placeholder="{{ __('Language Code') }}" name="code"
                                        data-parsley-required="true">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 form-group">
                            <label class="col-form-label ">{{ __('Image') }}</label>
                            <div class="">
                                <input class="filepond" type="file" name="image" id="edit_image">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-md-12 col-12 mt-3">
                                <div class="form-group">
                                    <label for="edit_panel_file"
                                        class="form-label col-12">{{ __('File For Admin Panel') }}</label>
                                    <input type="file" id="edit_panel_file" class="form-control col-12"
                                        name="panel_file">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-md-12 col-12 mt-3">
                                <div class="form-group">
                                    <label for="edit_app_file"
                                        class="form-label col-12">{{ __('File For App') }}</label>
                                    <input type="file" id="edit_app_file" class="form-control col-12"
                                        name="app_file">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="col-md-12 col-12 mt-3">
                                <div class="form-group">
                                    <label for="edit_web_file"
                                        class="form-label col-12">{{ __('File For Web') }}</label>
                                    <input type="file" id="edit_web_file" class="form-control col-12"
                                        name="web_file">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-md-12 col-12 mt-3">
                                <label for="edit_rtl" class="form-label col-12">{{ __('RTL') }}</label>
                                <div class="form-group form-check form-switch">
                                    <input type="hidden" value="0" name="rtl" id="edit_rtl">
                                    <input type="checkbox" class="form-check-input status-switch" id="edit_rtl_switch"
                                        aria-label="edit_rtl">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light"
                        id="edit_page_reload">{{ __('Save') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('language.store') }}" class="form-horizontal" id="create-form"
            enctype="multipart/form-data" method="POST" data-parsley-validate>
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel4">{{ __('Create Language') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-md-12 col-12">
                                <div class="form-group mandatory">
                                    <label for="add_name" class="form-label col-12">{{ __('Language Name') }}</label>
                                    <input type="text" id="add_name" class="form-control col-12"
                                        placeholder="{{ __('Name') }}" name="name"
                                        data-parsley-required="true">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-3">
                            <div class="col-md-12 col-12">
                                <div class="form-group mandatory">
                                    <label for="add_name_in_english"
                                        class="form-label col-12">{{ __('Language Name') }}({{ __('in English') }})</label>
                                    <input type="text" id="add_name_in_english" name="name_in_english" class="form-control col-12"
                                        placeholder="{{ __('Name') }}" data-parsley-required="true">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <div class="col-md-12 col-12">
                                <div class="form-group mandatory">
                                    <label for="add_code" class="form-label col-12">{{ __('Language Code') }}</label>
                                    <input type="text" id="add_code" class="form-control col-12"
                                        placeholder="{{ __('Language Code') }}" name="code"
                                        data-parsley-required="true">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 form-group">
                            <label class="col-form-label ">{{ __('Image') }}</label>
                            <div class="">
                                <input class="filepond" type="file" name="image" id="add_image">
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="add_panel_file"
                                        class="form-label col-12">{{ __('File For Admin Panel') }}</label>
                                    <input type="file" id="add_panel_file" class="form-control col-12"
                                        name="panel_file">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="add_app_file"
                                        class="form-label col-12">{{ __('File For App') }}</label>
                                    <input type="file" id="add_app_file" class="form-control col-12"
                                        name="app_file">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-3">
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="add_web_file"
                                        class="form-label col-12">{{ __('File For Web') }}</label>
                                    <input type="file" id="add_web_file" class="form-control col-12"
                                        name="web_file">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <div class="col-md-12 col-12">
                                <label for="add_rtl" class="form-label col-12">{{ __('RTL') }}</label>
                                <div class="form-group form-check form-switch">
                                    <input type="hidden" value="0" name="rtl" id="add_rtl">
                                    <input type="checkbox" class="form-check-input status-switch" id="add_rtl_switch"
                                        aria-label="add_rtl">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit"
                        class="btn btn-primary waves-effect waves-light">{{ __('Save') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
