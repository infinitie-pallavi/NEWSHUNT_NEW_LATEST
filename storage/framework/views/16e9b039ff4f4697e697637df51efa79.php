<?php $__env->startSection('title'); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('pre-title'); ?>
    <?php echo e($title); ?>

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
        <div class="col-auto ms-auto d-print-none">
            <a class="btn btn-primary" href="<?php echo e(route('posts.create')); ?>"><?php echo e(__('CREATE')); ?></a>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="section">
        <div class="col-12 mt-0">
            <div class="card">
                <div class="card-body">
                    <div class="page-header d-print-none">
                        <div class="container-xl">
                            <div class="row g-2 align-items-center">
                                <div class="col">
                                    <div id="total-posts" class="text-secondary mt-1"><?php echo e(__('LOADING')); ?></div>
                                </div>
                                <div class="col-auto ms-auto d-print-none">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <div class="input-icon">
                                                <div class="col-auto d-print-none">
                                                    <div class="nav-item dropdown">
                                                        <select id="select-filter" class="form-select mb-2">
                                                            <option value="" disabled selected>
                                                                <?php echo e(__('SELECT_FILTER')); ?></option>
                                                            <option value="recent"><?php echo e(__('MOST_RECENT')); ?></option>
                                                            <option value="viewd"><?php echo e(__('MOST_READ')); ?></option>
                                                            <option value="liked"><?php echo e(__('MOST_LIKED')); ?></option>
                                                            <option value="video_posts"><?php echo e(__('VIDEO_POSTS')); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="me-3">
                                            <div class="input-icon">
                                                <div class="col-auto d-print-none">
                                                    <div class="nav-item dropdown">
                                                        <select id="select-channel" class="form-select mb-2">
                                                            <option value="" disabled selected>
                                                                <?php echo e(__('SELECT_CHANNEL')); ?></option>
                                                            <option value="*"><?php echo e(__('ALL')); ?></option>
                                                            <?php $__currentLoopData = $channel_filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($channel->id); ?>"><?php echo e($channel->name); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="me-3">
                                            <div class="input-icon">
                                                <div class="col-auto d-print-none">
                                                    <div class="nav-item dropdown">
                                                        <select id="select-topic" class="form-select mb-2">
                                                            <option value="" disabled selected>
                                                                <?php echo e(__('SELECT_TOPIC')); ?></option>
                                                            <option value="*"><?php echo e(__('ALL')); ?></option>
                                                            <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($topic->id); ?>"><?php echo e($topic->name); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="me-3">
                                            <div class="input-icon">
                                                <input id="search-input" type="text" class="form-control"
                                                    placeholder="<?php echo e(__('SEARCH')); ?>" onkeyup="fetchPosts()">
                                                <span class="input-icon-addon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                        <path d="M21 21l-6 -6" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-body">
                        <div class="container-xl" id=post_card_hover>
                            <div id="posts-container" class="row row-cards" data-url="<?php echo e(route('posts.show', 1)); ?>">
                                <div id="posts-skeleton-loader" class="row row-cards">
                                    <?php for($i = 0; $i < 12; $i++): ?>
                                        <div class="col-sm-4 col-lg-3">
                                            <div class="card card-sm">
                                                <div class="skeleton-loader skeleton-loader-height"></div>
                                                <div class="card-body">
                                                    <span class="card-title skeleton-loader"></span>
                                                    <div class="d-flex align-items-center mt-2">
                                                        <div class="skeleton-loader channel-post-icone"></div>
                                                        <div>
                                                            <div class="skeleton-loader"></div>
                                                            <div class="skeleton-loader text-secondary"></div>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <b
                                                                class="text-secondary skeleton-loader skeleton-custom-width"></b>
                                                            <b
                                                                class="ms-3 text-secondary skeleton-loader skeleton-custom-width"></b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="mt-3 d-flex">
                                <ul class="pagination ms-auto" id="pagination-container"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Post Description Modal -->
    <div class="modal modal-blur fade" id="post-description" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(__('POST_DESCRIPTION')); ?>

                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card card-sm">
                        <div id="post-media">
                            <img id="post-image" src="<?php echo e(asset('assets/images/no_image_available.png')); ?>"
                                class="w-100 h-100" alt="Post-Img">
                            <video id="video-preview" class="w-100 h-100 d-none" controls="controls">
                                <source src="" type="video/mp4">
                                <track src="descriptions_en.vtt" kind="descriptions" srclang="en"
                                    label="English Descriptions">
                            </video>
                        </div>
                        <div class="card-body">
                            <h5 id="post-title" class="card-title">Title</h5>
                            <div class="d-flex align-items-center mt-2">
                                <img id="channel-logo" src="<?php echo e(asset('assets/images/no_image_available.png')); ?>"
                                    class="channel-post-icone" alt="Channel Logo">
                                <div>
                                    <div id="channel-name"></div>
                                    <div id="post-date" class="text-secondary"></div>
                                </div>
                                <div class="d-flex justify-content-between ms-auto gap-1">
                                    
                                    <b id="view-comments" class="text-secondary">
                                        <i class="bi bi-chat-left-text-fill"></i>
                                    </b>
                                    <b id="favorite-count" class="ms-3 text-secondary">
                                        <i class="bi bi-heart-fill"></i>
                                    </b>
                                    <b id="reaction-count" class="ms-3 text-secondary ">
                                        
                                    </b>

                                </div>
                            </div>
                            <hr class="mt-0 mb-2">
                            <b><?php echo e(__('DESCRIPTION')); ?>:</b>
                            <p id="post-description-text"></p>
                            <div class="d-flex justify-content-between">
                                <span class="text-end text-dark dark:text-white">To read more <a href=""
                                        target="_blank" id="source_url">Click here</a>
                                </span>
                                <div>
                                    <a class="btn btn-primary btn-sm rounded" href="#" id="comments_url"
                                        data-base-url="<?php echo e(route('comments.index')); ?>">View commetns</a>
                                    <a class="btn btn-primary btn-sm rounded" href="#"
                                        id="edit-post-btn"><?php echo e(__('EDIT')); ?></a>
                                    <a class="btn btn-danger btn-sm delete-form delete-form-reload rounded"
                                        id="post_delete_url" href=""><?php echo e(__('DELETE')); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary" data-bs-dismiss="modal"><?php echo e(__('CLOSE')); ?></a>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" value="<?php echo e(route('posts.store')); ?>" id="customPostStore">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/infinitie-raj/Code v1.2.0/resources/views/admin/post/index.blade.php ENDPATH**/ ?>