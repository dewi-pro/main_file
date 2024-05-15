<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title><?php if(trim($__env->yieldContent('template_title'))): ?><?php echo $__env->yieldContent('template_title'); ?> | <?php endif; ?> <?php echo e(trans('installer_messages.title')); ?></title>
        <link rel="icon" type="image/png" href="<?php echo e(asset('installer/img/favicon/favicon-16x16.png')); ?>" sizes="16x16"/>
        <link rel="icon" type="image/png" href="<?php echo e(asset('installer/img/favicon/favicon-32x32.png')); ?>" sizes="32x32"/>
        <link rel="icon" type="image/png" href="<?php echo e(asset('installer/img/favicon/favicon-96x96.png')); ?>" sizes="96x96"/>
        <link href="<?php echo e(asset('installer/css/style.min.css')); ?>" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">

        <?php echo $__env->yieldContent('style'); ?>
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
        <style>
        i.step__icon {
            font-size: large;
        }

    </style>
    </head>
    <body>
        <div class="master">
            <div class="box">
                <div class="header">
                    <h1 class="header__title"><?php echo $__env->yieldContent('title'); ?></h1>
                </div>
                <ul class="step">
                    <li class="step__divider"></li>
                    <li class="step__item <?php echo e(isActive('LaravelInstaller::final')); ?>">
                        <i class="step__icon ti ti-server" aria-hidden="true"></i>
                    </li>
                    <li class="step__divider"></li>
                    <li class="step__item <?php echo e(isActive('LaravelInstaller::environment')); ?> <?php echo e(isActive('LaravelInstaller::environmentWizard')); ?> <?php echo e(isActive('LaravelInstaller::environmentClassic')); ?>">
                        <?php if(Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') ): ?>
                            <a href="<?php echo e(route('LaravelInstaller::environment')); ?>">
                                <i class="step__icon ti ti-world" aria-hidden="true"></i>
                            </a>
                        <?php else: ?>
                            <i class="step__icon ti ti-world" aria-hidden="true"></i>
                        <?php endif; ?>
                    </li>
                    <li class="step__divider"></li>
                    <li class="step__item <?php echo e(isActive('LaravelInstaller::permissions')); ?>">
                        <?php if(Request::is('install/permissions') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') ): ?>
                            <a href="<?php echo e(route('LaravelInstaller::permissions')); ?>">
                                <i class="step__icon ti ti-key" aria-hidden="true"></i>
                            </a>
                        <?php else: ?>
                            <i class="step__icon ti ti-key" aria-hidden="true"></i>
                        <?php endif; ?>
                    </li>
                    <li class="step__divider"></li>
                    <li class="step__item <?php echo e(isActive('LaravelInstaller::requirements')); ?>">
                        <?php if(Request::is('install') || Request::is('install/requirements') || Request::is('install/permissions') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') ): ?>
                            <a href="<?php echo e(route('LaravelInstaller::requirements')); ?>">
                                <i class="step__icon ti ti-list" aria-hidden="true"></i>
                            </a>
                        <?php else: ?>
                            <i class="step__icon ti ti-list" aria-hidden="true"></i>
                        <?php endif; ?>
                    </li>
                    <li class="step__divider"></li>
                    <li class="step__item <?php echo e(isActive('LaravelInstaller::welcome')); ?>">
                        <?php if(Request::is('install') || Request::is('install/requirements') || Request::is('install/permissions') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') ): ?>
                            <a href="<?php echo e(route('LaravelInstaller::welcome')); ?>">
                                <i class="step__icon ti ti-home" aria-hidden="true"></i>
                            </a>
                        <?php else: ?>
                            <i class="step__icon ti ti-home" aria-hidden="true"></i>
                        <?php endif; ?>
                    </li>
                    <li class="step__divider"></li>
                </ul>
                <div class="main">
                    <?php if(session('message')): ?>
                        <p class="alert text-center">
                            <strong>
                                <?php if(is_array(session('message'))): ?>
                                    <?php echo e(session('message')['message']); ?>

                                <?php else: ?>
                                    <?php echo e(session('message')); ?>

                                <?php endif; ?>
                            </strong>
                        </p>
                    <?php endif; ?>
                    <?php if(session()->has('errors')): ?>
                        <div class="alert alert-danger" id="error_alert">
                            <button type="button" class="close" id="close_alert" data-dismiss="alert" aria-hidden="true">
                                 <i class="ti ti-x" aria-hidden="true"></i>
                            </button>
                            <h4>
                                <i class="ti ti-alert-triangle" aria-hidden="true"></i>
                                <?php echo e(trans('installer_messages.forms.errorTitle')); ?>

                            </h4>
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php echo $__env->yieldContent('container'); ?>
                </div>
            </div>
        </div>
        <?php echo $__env->yieldContent('scripts'); ?>
    </body>
</html>
<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/vendor/installer/layouts/master.blade.php ENDPATH**/ ?>