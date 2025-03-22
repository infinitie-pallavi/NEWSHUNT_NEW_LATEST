<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Installation - <?php echo e(config('app.name', 'Laravel')); ?></title>
    <link rel="shortcut icon" href="<?php echo e(config('installer.icon')); ?>">
    <link href="<?php echo e(asset('installer_css/styles.css')); ?>" rel="stylesheet">
</head>
<body class="min-h-screen h-full w-full bg-cover bg-no-repeat bg-center flex" style="background-image: url('<?php echo e(config('installer.background')); ?>');">
<div class="py-12 sm:px-12 w-full max-w-5xl m-auto">
    <div class="w-full bg-white shadow sm:rounded-lg">
        <div class="px-4 py-8 border-b border-gray-200 sm:px-6">
            <div class="flex justify-center items-center">
                <img alt="App logo" class="h-12" src="<?php echo e(config('installer.icon')); ?>">
                <h2 class="pl-6 uppercase font-medium text-2xl text-gray-800"><?php echo e(config('app.name', 'Laravel')); ?> Installation</h2>
            </div>
        </div>
        <div class="px-4 py-5 sm:px-6 w-full">
            <?php echo $__env->yieldContent('step'); ?>
        </div>
    </div>
</div>
</body>
</html>
<?php /**PATH /home/infinitie-raj/Code v1.2.0/resources/views/vendor/installer/install.blade.php ENDPATH**/ ?>