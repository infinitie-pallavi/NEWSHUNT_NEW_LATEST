<!-- Add Rss Feed Modal -->
<div id="addRssFeedModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addRssFeedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" class="form-horizontal" enctype="multipart/form-data" id="addRssFeedForm" method="POST" data-parsley-validate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRssFeedModalLabel">{{ __('ADD_RSS_FEED') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="form-label">{{ __('FEED_URL') }}</label>
                        <input type="text" name="rss_feed_url" class="form-control" placeholder="{{ __('PLEASE_ENTER_RSS_FEED_URL') }}" required>
                        @error('rss_feed_url')
                            <span class="help-block text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="channels_id" class="form-label">{{ __('SELECT_CHANNEL') }}</label>
                        <select id="mySelect" class="form-control form-select select2" id="channels_id" name="channel_id">
                            <option value="" disabled selected>{{ __('SELECT_CHANNEL') }}</option>
                            @foreach ($channels_lists as $channel)
                                <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                            @endforeach
                        </select>
                        @error('channel_id')
                            <span class="help-block text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="topics_id" class="form-label">{{ __('SELECT_TOPIC') }}</label>
                        <select class="form-control form-select select2" id="" name="topic_id">
                            <option value="" disabled selected>{{ __('SELECT_TOPIC') }}</option>
                            @foreach ($topics_lists as $topic)
                                <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                            @endforeach
                        </select>
                        @error('topic_id')
                            <span class="help-block text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label">{{ __('SYNC_INTERVAL') }} <small>(Please insert time in minuts)</small></label>
                        <input type="number" min="0" oninput="this.value = Math.abs(this.value)" name="sync_interval" class="form-control" placeholder="{{ __('PLEASE_ENTER_IN_MINUTES') }}" required>
                        @error('sync_interval')
                            <span class="help-block text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label">{{ __('DATA_FORMAT') }}</label>
                        <select class="form-control form-select" name="data_formate">
                            <option value="" disabled selected>{{ __('SELECT_FORMAT') }}</option>
                            <option value="XML">XML</option>
                            <option value="JSON">JSON</option>
                        </select>
                        @error('data_formate')
                        Topic      @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label">{{ __('STATUS') }}</label>
                        <select class="form-control form-select" name="status">
                            <option value="" disabled selected>{{ __('SELECT_STATUS') }}</option>
                            <option value="active">{{ __('ACTIVE') }}</option>
                            <option value="inactive">{{ __('INACTIVE') }}</option>
                        </select>
                        @error('status')
                            <span class="help-block text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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

<!-- Edit Rss Feed Modal -->
<div id="editRssFeedModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editRssFeedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('rss-feeds.update', 0) }}" class="form-horizontal" enctype="multipart/form-data"
            id="editRssFeedForm" method="POST" data-parsley-validate>
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="rss-feed-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRssFeedModalLabel">{{ __('EDIT_RSS_FEED') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="form-label">{{ __('FEED_URL') }}</label>
                        <input type="text" name="rss_feed_url" class="form-control" id="edit_feed_url" placeholder="{{ __('PLEASE_ENTER_RSS_FEED_URL') }}" required>
                        @error('rss_feed_url')
                            <span class="help-block text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label">{{ __('SELECT_CHANNEL') }}</label>
                        <select class="form-control form-select" name="channel_id" id="edit_channel_name">
                            <option value="" disabled selected>{{ __('SELECT_CHANNEL') }}</option>
                            @foreach ($channels_lists as $channel)
                                <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                            @endforeach
                        </select>
                        @error('channel_id')
                            <span class="help-block text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label">{{ __('SELECT_TOPIC') }}</label>
                        <select class="form-control form-select" name="topic_id" id="edit_topic_name">
                            <option value="" disabled selected>{{ __('SELECT_TOPIC') }}</option>
                            @foreach ($topics_lists as $topic)
                                <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                            @endforeach
                        </select>
                        @error('topic_id')
                            <span class="help-block text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label">{{ __('SYNC_INTERVAL') }}  <small>(Please insert time in minuts)</small></label>
                        <input type="number" min="0" oninput="this.value = Math.abs(this.value)" name="sync_interval" id="edit_sync_interval" class="form-control" placeholder="{{ __('PLEASE_ENTER_IN_MINUTES') }}" required>
                        @error('sync_interval')
                            <span class="help-block text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label">{{ __('DATA_FORMAT') }}</label>
                        <select class="form-control form-select" name="data_formate" id="edit_data_formate">
                            <option value="" disabled selected>{{ __('SELECT_FORMAT') }}</option>
                            <option value="XML">XML</option>
                            <option value="JSON">JSON</option>
                        </select>
                        @error('data_formate')
                        Topic      @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label">{{ __('STATUS') }}</label>
                        <select class="form-control form-select" name="status" id="edit_status">
                            <option value="" disabled selected>{{ __('SELECT_STATUS') }}</option>
                            <option value="active">{{ __('ACTIVE') }}</option>
                            <option value="inactive">{{ __('INACTIVE') }}</option>
                        </select>
                        @error('status')
                            <span class="help-block text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
