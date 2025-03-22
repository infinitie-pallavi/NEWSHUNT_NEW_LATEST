<?php $__env->startSection('title'); ?>
<?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('pre-title'); ?>
<?php echo e($pre_title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <div class="row g-2 align-items-center">
        <div class="col">
            <div class="page-pretitle">
                <a href="<?php echo e(url('admin/dashboard')); ?>"><?php echo e(__('HOME')); ?>/</a>
                <?php echo $__env->yieldContent('pre-title'); ?>
            </div>
            <h2 class="page-title">
                <?php echo $__env->yieldContent('title'); ?>
            </h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none gap-1">
            <a class="btn btn-primary sync-btn fetch_all_feed" href="#" id="fetch_rssfeed"><?php echo e(__('SYNC_FEEDS')); ?></a>

            <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#addRssFeedModal"><?php echo e(__('CREATE')); ?></a>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="input-icon">
                            <div class="col-auto d-print-none">
                                <div class="nav-item dropdown">
                                    <select id="feed_status" class="form-select mb-1">
                                        <option value="*" disabled selected>
                                            <?php echo e(__('SELECT_STATUS')); ?></option>
                                        <option value="*"><?php echo e(__('ALL')); ?></option>
                                        <option value="active"><?php echo e(__('ACTIVE')); ?></option>
                                        <option value="inactive"><?php echo e(__('INACTIVE')); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                       <table class="table table-bordered text-nowrap border-bottom" id="rss-feed-list" data-url="<?php echo e(route('rss-feeds.show',1)); ?>">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0"><?php echo e(__('ID')); ?></th>
                                    <th class="wd-15p border-bottom-0"><?php echo e(__('CHANNELS')); ?></th>
                                    <th class="wd-20p border-bottom-0"><?php echo e(__('TOPICS')); ?></th>
                                    <th class="wd-15p border-bottom-0"><?php echo e(__('FEED_URL')); ?></th>
                                    <th class="wd-15p border-bottom-0"><?php echo e(__('DATA_FORMAT')); ?></th>
                                    <th class="wd-15p border-bottom-0"><?php echo e(__('SYNC_INTERVAL')); ?></th>
                                    <th class="wd-15p border-bottom-0"><?php echo e(__('STATUS')); ?></th>
                                    <th class="wd-15p border-bottom-0"><?php echo e(__('SYNC')); ?></th>
                                    <th class="wd-15p border-bottom-0"><?php echo e(__('ACTION')); ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" value="<?php echo e(route('rss-feeds.store')); ?>" id="rssfeedstore">
        <input type="hidden" value="<?php echo e(route('rsfeed.single-fetch')); ?>" id="rssfeedFetchSingle">
        <input type="hidden" id="channel_status_url" value="<?php echo e(route('rsfeed.update.status')); ?>">
    </section>
<?php echo $__env->make('admin.models.rss-feed-model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/infinitie-raj/Code v1.2.0/resources/views/admin/rss_feed/index.blade.php ENDPATH**/ ?>