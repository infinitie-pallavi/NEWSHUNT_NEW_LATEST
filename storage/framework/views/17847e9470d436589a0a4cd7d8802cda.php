<!-- Add Rss Feed Modal -->
<div id="addRssFeedModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addRssFeedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" class="form-horizontal" enctype="multipart/form-data" id="addRssFeedForm" method="POST" data-parsley-validate>
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRssFeedModalLabel"><?php echo e(__('ADD_RSS_FEED')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="form-label"><?php echo e(__('FEED_URL')); ?></label>
                        <input type="text" name="rss_feed_url" class="form-control" placeholder="<?php echo e(__('PLEASE_ENTER_RSS_FEED_URL')); ?>" required>
                        <?php $__errorArgs = ['rss_feed_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="help-block text-danger">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group mt-3">
                        <label for="channels_id" class="form-label"><?php echo e(__('SELECT_CHANNEL')); ?></label>
                        <select id="mySelect" class="form-control form-select select2" id="channels_id" name="channel_id">
                            <option value="" disabled selected><?php echo e(__('SELECT_CHANNEL')); ?></option>
                            <?php $__currentLoopData = $channels_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($channel->id); ?>"><?php echo e($channel->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['channel_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="help-block text-danger">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group mt-3">
                        <label for="topics_id" class="form-label"><?php echo e(__('SELECT_TOPIC')); ?></label>
                        <select class="form-control form-select select2" id="" name="topic_id">
                            <option value="" disabled selected><?php echo e(__('SELECT_TOPIC')); ?></option>
                            <?php $__currentLoopData = $topics_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($topic->id); ?>"><?php echo e($topic->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['topic_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="help-block text-danger">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label"><?php echo e(__('SYNC_INTERVAL')); ?> <small>(Please insert time in minuts)</small></label>
                        <input type="number" min="0" oninput="this.value = Math.abs(this.value)" name="sync_interval" class="form-control" placeholder="<?php echo e(__('PLEASE_ENTER_IN_MINUTES')); ?>" required>
                        <?php $__errorArgs = ['sync_interval'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="help-block text-danger">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label"><?php echo e(__('DATA_FORMAT')); ?></label>
                        <select class="form-control form-select" name="data_formate">
                            <option value="" disabled selected><?php echo e(__('SELECT_FORMAT')); ?></option>
                            <option value="XML">XML</option>
                            <option value="JSON">JSON</option>
                        </select>
                        <?php $__errorArgs = ['data_formate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        Topic      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label"><?php echo e(__('STATUS')); ?></label>
                        <select class="form-control form-select" name="status">
                            <option value="" disabled selected><?php echo e(__('SELECT_STATUS')); ?></option>
                            <option value="active"><?php echo e(__('ACTIVE')); ?></option>
                            <option value="inactive"><?php echo e(__('INACTIVE')); ?></option>
                        </select>
                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="help-block text-danger">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('CLOSE')); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('SAVE')); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Rss Feed Modal -->
<div id="editRssFeedModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editRssFeedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo e(route('rss-feeds.update', 0)); ?>" class="form-horizontal" enctype="multipart/form-data"
            id="editRssFeedForm" method="POST" data-parsley-validate>
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="id" id="rss-feed-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRssFeedModalLabel"><?php echo e(__('EDIT_RSS_FEED')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="form-label"><?php echo e(__('FEED_URL')); ?></label>
                        <input type="text" name="rss_feed_url" class="form-control" id="edit_feed_url" placeholder="<?php echo e(__('PLEASE_ENTER_RSS_FEED_URL')); ?>" required>
                        <?php $__errorArgs = ['rss_feed_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="help-block text-danger">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label"><?php echo e(__('SELECT_CHANNEL')); ?></label>
                        <select class="form-control form-select" name="channel_id" id="edit_channel_name">
                            <option value="" disabled selected><?php echo e(__('SELECT_CHANNEL')); ?></option>
                            <?php $__currentLoopData = $channels_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($channel->id); ?>"><?php echo e($channel->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['channel_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="help-block text-danger">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label"><?php echo e(__('SELECT_TOPIC')); ?></label>
                        <select class="form-control form-select" name="topic_id" id="edit_topic_name">
                            <option value="" disabled selected><?php echo e(__('SELECT_TOPIC')); ?></option>
                            <?php $__currentLoopData = $topics_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($topic->id); ?>"><?php echo e($topic->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['topic_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="help-block text-danger">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label"><?php echo e(__('SYNC_INTERVAL')); ?>  <small>(Please insert time in minuts)</small></label>
                        <input type="number" min="0" oninput="this.value = Math.abs(this.value)" name="sync_interval" id="edit_sync_interval" class="form-control" placeholder="<?php echo e(__('PLEASE_ENTER_IN_MINUTES')); ?>" required>
                        <?php $__errorArgs = ['sync_interval'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="help-block text-danger">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label"><?php echo e(__('DATA_FORMAT')); ?></label>
                        <select class="form-control form-select" name="data_formate" id="edit_data_formate">
                            <option value="" disabled selected><?php echo e(__('SELECT_FORMAT')); ?></option>
                            <option value="XML">XML</option>
                            <option value="JSON">JSON</option>
                        </select>
                        <?php $__errorArgs = ['data_formate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        Topic      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label"><?php echo e(__('STATUS')); ?></label>
                        <select class="form-control form-select" name="status" id="edit_status">
                            <option value="" disabled selected><?php echo e(__('SELECT_STATUS')); ?></option>
                            <option value="active"><?php echo e(__('ACTIVE')); ?></option>
                            <option value="inactive"><?php echo e(__('INACTIVE')); ?></option>
                        </select>
                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="help-block text-danger">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal"><?php echo e(__('CLOSE')); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('SAVE')); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH /home/infinitie-raj/Code v1.2.0/resources/views/admin/models/rss-feed-model.blade.php ENDPATH**/ ?>