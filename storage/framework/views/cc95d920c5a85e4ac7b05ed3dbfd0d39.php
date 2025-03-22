<!-- Add Channel Modal -->
<div id="addChannelModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addChannelModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo e(route('channels.store')); ?>" class="form-horizontal" enctype="multipart/form-data"
            id="addChannelForm" method="POST" data-parsley-validate>
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addChannelModalLabel"><?php echo e(__('ADD_CHANNEL')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add-channel-name" class="form-label"><?php echo e(__('CHANNEL_NAME')); ?></label>
                        <input type="text" name="name" class="form-control"
                            placeholder="Please enter channel name" id="add-channel-name" required>
                            <span class="text-danger">
                                <strong id="name-error-message"></strong>
                            </span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="add-channel-description" class="form-label"><?php echo e(__('CHANNEL_DESCRIPTION')); ?></label>
                        <textarea name="description" class="form-control" placeholder="Please enter channel description" id="add-channel-description" rows="3" required></textarea>
                        <span class="text-danger">
                            <strong id="description-error-message"></strong>
                        </span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="add-channel-status" class="form-label"><?php echo e(__('STATUS')); ?></label>
                        <select class="form-control form-select" name="status" id="add-channel-status">
                            <option value="" disabled selected><?php echo e(__('SELECT_STATUS')); ?></option>
                            <option value="active"><?php echo e(__('ACTIVE')); ?></option>
                            <option value="inactive"><?php echo e(__('INACTIVE')); ?></option>
                        </select>
                            <span class="text-danger">
                                <strong id="status-error-message"></strong>
                            </span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label"><?php echo e(__('LOGO')); ?></label>
                        <input type="file" name="logo" id="channel-logo-input" class="form-control" accept="image/*">
                        <span class="text-danger">
                            <strong id="logo-error-message"></strong>
                        </span>
                        <div class="mt-3">
                            <img id="channel-logo-privew" src="<?php echo e(asset('assets/images/no_image_available.png')); ?>"
                                alt="Logo Preview" class="img-privew">
                        </div>
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



<!-- Edit Channel Modal -->
<div id="editChannelModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editChannelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo e(route('channels.update', 0)); ?>" class="form-horizontal" enctype="multipart/form-data" id="editChannelForm" method="POST" data-parsley-validate>
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="id" id="channel-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editChannelModalLabel"><?php echo e(__('EDIT_CHANNEL')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="form-label"><?php echo e(__('CHANNEL_NAME')); ?></label>
                        <input type="text" name="name" class="form-control" placeholder="Please enter channel name" id="edit-channel-name" required>
                        <?php if($errors->has('name')): ?>
                            <span class="text-danger">
                                <strong><?php echo e($errors->first('name')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group mt-3">
                        <label for="edit-channel-description" class="form-label"><?php echo e(__('CHANNEL_DESCRIPTION')); ?></label>
                        <textarea name="description" class="form-control" placeholder="Please enter channel description" id="edit-channel-description" rows="3" required></textarea>
                        <?php if($errors->has('description')): ?>
                            <span class="text-danger">
                                <strong><?php echo e($errors->first('description')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group mt-3">
                        <label for="edit-channel-status" class="form-label"><?php echo e(__('STATUS')); ?></label>
                        <select class="form-control form-select" name="status" id="edit-channel-status">
                            <option value=""><?php echo e(__('SELECT_STATUS')); ?></option>
                            <option value="active"><?php echo e(__('ACTIVE')); ?></option>
                            <option value="inactive"><?php echo e(__('INACTIVE')); ?></option>
                        </select>
                        <?php if($errors->has('status')): ?>
                            <span class="text-danger">
                                <strong><?php echo e($errors->first('status')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                   
                    <div class="form-group mt-3">
                        <label for="edit-channel-logo" class="form-label"><?php echo e(__('LOGO')); ?></label>
                        <input type="file" name="logo" id="edit-channel-logo" class="form-control" accept="image/*">
                        <div class="mt-3">
                            <img id="edit-channel-privew" src="<?php echo e(asset('assets/images/no_image_available.png')); ?>" alt="Logo Preview" class="edit_chen_img">
                            <?php if($errors->has('logo')): ?>
                                <span class="text-danger">
                                    <strong><?php echo e($errors->first('logo')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                        
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
<?php /**PATH /home/infinitie-raj/Code v1.2.0/resources/views/admin/models/channel-model.blade.php ENDPATH**/ ?>