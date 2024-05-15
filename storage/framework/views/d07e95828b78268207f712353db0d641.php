<?php $__env->startSection('template_title'); ?>
    <?php echo e(trans('installer_messages.environment.menu.templateTitle')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <i class="ti ti-world fa-fw" aria-hidden="true"></i>
    <?php echo trans('installer_messages.environment.menu.title'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('container'); ?>

    <p class="text-center">
        <?php echo trans('installer_messages.environment.menu.desc'); ?>

    </p>
    <div class="buttons">
        <a href="<?php echo e(route('LaravelInstaller::environmentWizard')); ?>" class="button button-wizard">
            <i class="ti ti-mist" aria-hidden="true"></i> <?php echo e(trans('installer_messages.environment.menu.wizard-button')); ?>

        </a>
        
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('vendor.installer.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/vendor/installer/environment.blade.php ENDPATH**/ ?>