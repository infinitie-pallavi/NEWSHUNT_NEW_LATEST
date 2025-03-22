<?php $__env->startSection('content'); ?>
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <?php if(env('DEMO_MODE')): ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-warning mb-0">
                                <b>Note:</b> If you cannot login here, please close the codecanyon frame by clicking on <b>x Remove Frame</b> button from top right corner on the page or 
                                
                                    <a href="<?php echo e(route('admin.login')); ?>" target="_blank">&gt;&gt; Click here &lt;&lt;</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <a href="." class="navbar-brand navbar-brand-autodark">
                    <img src="<?php echo e($favicon != null ? $favicon : url('assets/images/logo/logo.png')); ?>" alt="Logo" class="navbar-brand-image img-custom-height">
                </a>
            </div>
            <div class="card card-md">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Admin Login</h2>
                    <form method="POST" action="<?php echo e(route('admin.login')); ?>" id="frmLogin">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" id="email" placeholder="<?php echo e(__('Email')); ?>"
                                class="form-control login-border form-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
                        </div>
                        <div class="mb-2">
                            <label for="forget-password" class="form-label">Password<span class="form-label-description">
                                    <a href="<?php echo e(route('password.request')); ?>">I forgot password</a>
                                </span>
                            </label>
                            <div class="input-group input-group-flat">
                                <input id="password" type="password" placeholder="Password"
                                    class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required
                                    autocomplete="current-password">
                                <span class="input-group-text pe-1 py-0 hover-shadow-none">
                                    <button type="button" class="btn btn-action p-0 hover-shadow-none"
                                        title="Show password" data-bs-toggle="tooltip" onClick="togglePassword()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path
                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-check">
                                <input type="checkbox" class="form-check-input" />
                                <span class="form-check-label">Remember me on this device</span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">Sign in</button>
                        </div>
                        <?php if(env('DEMO_MODE')): ?>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <button type="button" class="btn bg-warning-lt w-100" id="admin-btn"> Sign in as admin
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
            <div class="text-center text-secondary mt-3">
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/infinitie-raj/Code v1.2.0/resources/views/auth/login.blade.php ENDPATH**/ ?>