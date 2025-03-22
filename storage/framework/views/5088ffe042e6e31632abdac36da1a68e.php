<!DOCTYPE html>
<html lang="zxx" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title ?? ''); ?> | <?php echo e($webTitle->value ?? ''); ?></title>
    <link rel="icon" href="<?php echo e($favicon ?? asset('assets/images/logo/favicon.png')); ?>" type="image/x-icon" />
    <meta name="description" content="A clean, modern News providing website.">
    <meta name="keywords" content="news, website design, digital product, marketing, agency">
    <link rel="canonical" href="https://news-app.keshwaniexim.com">
    <meta name="theme-color" content="#2757fd">

    <!-- Open Graph Tags -->
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo e($post_title ?? 'Stay Informed: Your Daily Source for Breaking News and In-Depth Analysis'); ?>">
    <meta property="og:description" content="<?php echo e($description ?? 'Explore the latest news and insights from around the world. Our dedicated team provides timely updates, investigative journalism, and diverse perspectives to keep you informed and engaged every day.'); ?>">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:site_name" content="<?php echo e($webTitle->value ?? ''); ?>">
    <meta property="og:image" content="<?php echo e($image ?? ''); ?>">
    <meta property="og:image:width" content="1180">
    <meta property="og:image:height" content="600">
    <meta property="og:image:type" content="image/png">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo e(url('')); ?>">
    <meta name="twitter:title" content="<?php echo e($post_title ?? 'Stay Informed: Your Daily Source for Breaking News and In-Depth Analysis'); ?>">
    <meta name="twitter:description" content="<?php echo e($description ?? 'Explore the latest news and insights from around the world. Our dedicated team provides timely updates, investigative journalism, and diverse perspectives to keep you informed and engaged every day.'); ?>">
    <meta name="twitter:image" content="<?php echo e(isset($dark_logo) ? url('storage/'.$dark_logo->value) : ""); ?>">
    
    <link rel="canonical" href="https://news-app.keshwaniexim.com">

    <?php echo $__env->make('front_end.'.$theme.'.layout.style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('style'); ?>
</head>

<body class="uni-body panel bg-white text-gray-900 dark:bg-black dark:text-white text-opacity-50 overflow-x-hidden">
    <?php echo $__env->make('front_end.'.$theme.'.layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <div id="android-scheme" class="d-none">
      <?php echo e($app_scheme->value ?? ''); ?>

    </div>
    <div id="ios-scheme" class="d-none">
      <?php echo e($ios_shceme->value ?? ''); ?>

    </div>
    <div id="android-link" class="d-none">
      <?php echo e($app_store_link->value ?? ''); ?>

    </div>
    <div id="ios-link" class="d-none">
      <?php echo e($play_store_link->value ?? ''); ?>

    </div>

    <?php echo $__env->yieldContent('body'); ?>

    <?php echo $__env->make('front_end.'.$theme.'.layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('front_end.'.$theme.'.layout.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldContent('script'); ?>
    
</body>
<?php /**PATH /home/infinitie-raj/Code v1.2.0/resources/views/front_end/classic/layout/main.blade.php ENDPATH**/ ?>