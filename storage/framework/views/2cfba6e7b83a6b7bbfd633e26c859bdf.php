<!-- include jquery & bootstrap js -->
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/libs/jquery.min.js')); ?>"></script>
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/libs/bootstrap.min.js')); ?>"></script>

  <!-- include scripts -->
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/libs/anime.min.js')); ?>"></script>
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/libs/swiper-bundle.min.js')); ?>"></script>
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/libs/scrollmagic.min.js')); ?>"></script>
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/helpers/data-attr-helper.js')); ?>"></script>
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/helpers/swiper-helper.js')); ?>"></script>
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/helpers/anime-helper.js')); ?>"></script>
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/helpers/anime-helper-defined-timelines.js')); ?>"></script>
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/uikit-components-bs.js')); ?>"></script>

  <!-- include app script -->
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/app.js')); ?>"></script>
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/sweetalert2.js')); ?>"></script>
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/front-custom.js')); ?>"></script>
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/custom/weather-custom.js')); ?>"></script>
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/custom/share.js')); ?>"></script>
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/custom/custom.js')); ?>"></script>
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/custom/custom-reactions.js')); ?>"></script>
  
   
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/custom/custom-jquery.js')); ?>"></script>

  
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/izitoast/dist/js/iziToast.js')); ?>"></script>
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/izitoast/dist/js/iziToast.min.js')); ?>"></script>


  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/sweeteralert/sweetalert2.all.min.js')); ?>"></script>
  <script defer src="<?php echo e(asset('front_end/'.$theme.'/js/custom/my-account.js')); ?>"></script>

   <script>
      // Schema toggle via URL
      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      const getSchema = urlParams.get("schema");
      if (getSchema === "dark") {
          setDarkMode(1);
      } else if (getSchema === "light") {
          setDarkMode(0);
      }
  </script>
    <?php /**PATH /home/infinitie-raj/Code v1.2.0/resources/views/front_end/classic/layout/script.blade.php ENDPATH**/ ?>