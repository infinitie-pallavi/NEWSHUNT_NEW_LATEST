<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo e($favicon ?? url('assets/images/logo/logo.png')); ?>" type="image/x-icon">
    <title>Login</title>
    <link href="<?php echo e(asset('assets/css/googleapis/googleapis.css')); ?>" rel="stylesheet">

    <?php echo $__env->make('admin.layouts.include', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('css'); ?>
</head>

<body>
    <script src="<?php echo e(asset('assets/dist/js/demo-theme.min.js')); ?>"></script>

    <?php echo $__env->yieldContent('content'); ?>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>

    <script type="text/javascript" src="<?php echo e(asset('public/assets/js/login/custom.js')); ?>"></script>
</body>

</html>
<?php /**PATH /home/infinitie-raj/Code v1.2.0/resources/views/auth/layout/main.blade.php ENDPATH**/ ?>