<aside class="navbar navbar-vertical navbar-expand-lg sidebar-overflow" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <span class="navbar-brand navbar-brand-autodark">
            <a href="<?php echo e(url('/admin/dashboard')); ?>">
               <img src="<?php echo e(!empty($company_logo) ? $company_logo : url('assets/images/logo/sidebarlogo.png')); ?>" alt="<?php echo e(config('app.name')); ?>" class="navbar-brand-image">
            </a>
        </span>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <?php $__currentLoopData = config('adminNav'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!isset($value['children']) || count($value['children']) == 0): ?>
                        <li class="nav-item <?php echo e(url()->current() == route($value['route']) ? 'active' : ''); ?>">
                            <a class="nav-link" href="<?php echo e(route($value['route'])); ?>">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <?php echo $value['svg']; ?>

                                </span>
                                <span class="nav-link-title">
                                    <?php echo e(__($value['name'])); ?>

                                </span>
                            </a>
                        </li>
                    <?php else: ?>
                        <?php
                            $isActive = false;
                            foreach ($value['children'] as $child) {
                                if (url()->current() == route($child['route'])) {
                                    $isActive = true;
                                    break;
                                }
                            }
                        ?>
                        <li class="nav-item dropdown <?php echo e($isActive ? 'active' : ''); ?>">
                            <a href="#navbar-layout" class="nav-link dropdown-toggle"  data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="true">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <?php echo $value['svg']; ?>

                                </span>
                                <span class="nav-link-title">
                                    <?php echo e(__($value['name'])); ?>

                                </span>
                            </a>
                            <div class="dropdown-menu <?php echo e($isActive ? 'show' : ''); ?>">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <?php $__currentLoopData = $value['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a class="dropdown-item <?php echo e(url()->current() == route($child['route']) ? 'active' : ''); ?>"
                                                href="<?php echo e(route($child['route'])); ?>">
                                                <?php echo e(__($child['name'])); ?>

                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
</aside>
<?php /**PATH /home/infinitie-raj/Code v1.2.0/resources/views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>