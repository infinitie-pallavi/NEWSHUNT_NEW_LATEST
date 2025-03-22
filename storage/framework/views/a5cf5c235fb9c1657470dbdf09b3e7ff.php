
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e($app_name ?? config('app.name')); ?></title>
    <meta name="msapplication-TileColor" content="#0054a6" />
    <meta name="theme-color" content="#0054a6" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="MobileOptimized" content="320" />
    <link rel="icon" href="<?php echo e($favicon ?? asset('assets/images/logo/favicon.png')); ?>" type="image/x-icon" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description" content="Desc"/>
    <meta name="canonical" content="https://jsp.io/demo/layout-combo.html">
    <meta name="twitter:image:src" content="https://jsp.io/demo/static/og.png">
    <meta name="twitter:site" content="@jsp_ui">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title"
        content="jsp: Premium and Open Source dashboard template with responsive and high quality UI.">
    <meta name="twitter:description"
        content="jsp comes with tons of well-designed components and features. Start your adventure with jsp and make your dashboard great again. For free!">
    <meta property="og:image" content="https://jsp.io/demo/static/og.png">
    <meta property="og:image:width" content="1280">
    <meta property="og:image:height" content="640">
    <meta property="og:site_name" content="<?php echo $__env->yieldContent('title'); ?> || <?php echo e(config('app.name')); ?>">
    <meta property="og:type" content="object">
    <meta property="og:title" content="title">

    <meta property="og:description" content="Desc">
    
    <!-- CSS files -->
    <?php echo $__env->make('admin.layouts.include', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('css'); ?>
</head>

<body data-bs-theme="dark" class="layout-fluid">
    <script src="<?php echo e(asset('assets/dist/js/demo-theme.min.js')); ?>"></script>
    <div class="page">
        <?php echo $__env->make('admin.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- Sidebar -->
        <?php echo $__env->make('admin.layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <div class="page-wrapper">
            <div class="container-xl">
                <div class="page-header d-print-none" id="page_header">
                    <?php echo $__env->yieldContent('page-title'); ?>
                </div>
                <div class="page-body">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
            <?php echo $__env->make('admin.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <?php echo $__env->make('admin.layouts.footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('js'); ?>
    <?php echo $__env->yieldContent('script'); ?>
</body>

</html>
<?php /**PATH /home/infinitie-raj/Code v1.2.0/resources/views/admin/layouts/main.blade.php ENDPATH**/ ?>