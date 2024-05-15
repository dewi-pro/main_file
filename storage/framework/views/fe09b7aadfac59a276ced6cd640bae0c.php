<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-dashboardwidget')): ?>
    <a class="btn btn-primary  btn-sm" href="javascript:void(0);" id="edit-dashboard"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Edit')); ?>"
        data-url="edit-dashboard/<?php echo e($dashboard->id); ?>/edit"><i class="ti ti-edit"></i></a>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-dashboardwidget')): ?>
    <?php echo Form::open([
        'method' => 'DELETE',
        'route' => ['delete.dashboard', $dashboard->id],
        'id' => 'delete-form-' . $dashboard->id,
        'class' => 'd-inline',
    ]); ?>

    <a href="#" class="btn btn-danger btn-sm  show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="<?php echo e(__('Delete')); ?>" id="delete-form-<?php echo e($dashboard->id); ?>"><i
            class="ti ti-trash mr-0"></i></a>
    <?php echo Form::close(); ?>

<?php endif; ?>
<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/dashboard/action.blade.php ENDPATH**/ ?>