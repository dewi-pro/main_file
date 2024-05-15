<a href="<?php echo e(route('telescope', 'requests')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'requests' ? 'active' : ''); ?>">
    <?php echo e(__('Requests')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="<?php echo e(route('telescope', 'commands')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'commands' ? 'active' : ''); ?>">
    <?php echo e(__('Commands')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="<?php echo e(route('telescope', 'schedule')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'schedule' ? 'active' : ''); ?>">
    <?php echo e(__('Schedule')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="<?php echo e(route('telescope', 'jobs')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'jobs' ? 'active' : ''); ?>">
    <?php echo e(__('Jobs')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="<?php echo e(route('telescope', 'batches')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'batches' ? 'active' : ''); ?>">
    <?php echo e(__('Batches')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="<?php echo e(route('telescope', 'cache')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'cache' ? 'active' : ''); ?>">
    <?php echo e(__('Cache')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="<?php echo e(route('telescope', 'dumps')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'dumps' ? 'active' : ''); ?>">
    <?php echo e(__('Dumps')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="<?php echo e(route('telescope', 'events')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'events' ? 'active' : ''); ?>">
    <?php echo e(__('Events')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="<?php echo e(route('telescope', 'exceptions')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'exceptions' ? 'active' : ''); ?>">
    <?php echo e(__('Exceptions')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="<?php echo e(route('telescope', 'gates')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'gates' ? 'active' : ''); ?>">
    <?php echo e(__('Gates')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="<?php echo e(route('telescope', 'client-requests')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'client-requests' ? 'active' : ''); ?>">
    <?php echo e(__('HTTP Client')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="<?php echo e(route('telescope', 'logs')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'logs' ? 'active' : ''); ?>">
    <?php echo e(__('Logs')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="<?php echo e(route('telescope', 'mail')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'mail' ? 'active' : ''); ?>">
    <?php echo e(__('Mail')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="<?php echo e(route('telescope', 'models')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'models' ? 'active' : ''); ?>">
    <?php echo e(__('Models')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="<?php echo e(route('telescope', 'notifications')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'notifications' ? 'active' : ''); ?>">
    <?php echo e(__('Notifications')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="<?php echo e(route('telescope', 'queries')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'queries' ? 'active' : ''); ?>">
    <?php echo e(__('Queries')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="<?php echo e(route('telescope', 'redis')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'redis' ? 'active' : ''); ?>">
    <?php echo e(__('Redis')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>

<a href="<?php echo e(route('telescope', 'views')); ?>"
    class="list-group-item list-group-item-action border-0 <?php echo e(Request::route()->getName() == 'telescope' && Request::segment(2) == 'views' ? 'active' : ''); ?>">
    <?php echo e(__('Views')); ?>

    <div class="float-end">
        <i class="ti ti-chevron-right"></i>
    </div>
</a>
<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/vendor/telescope/telescope-sidebar.blade.php ENDPATH**/ ?>