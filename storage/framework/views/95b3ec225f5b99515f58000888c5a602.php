<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-announcement')): ?>
    <a class="btn btn-sm small btn btn-primary" href="<?php echo e(route('announcement.edit', $announcement->id)); ?>"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Edit')); ?>">
        <i class="ti ti-edit text-white"></i>
    </a>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-announcement')): ?>
    <?php echo Form::open([
        'method' => 'DELETE',
        'class' => 'd-inline',
        'route' => ['announcement.destroy', $announcement->id],
        'id' => 'delete-form-' . $announcement->id,
    ]); ?>

    <a href="javascript:void(0);" class="btn btn-sm small btn btn-danger show_confirm" data-bs-toggle="tooltip"
        data-bs-placement="bottom" id="delete-form-1" data-bs-original-title="<?php echo e(__('Delete')); ?>">
        <i class="ti ti-trash text-white"></i>
    </a>
    <?php echo Form::close(); ?>

<?php endif; ?>
<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/announcement/action.blade.php ENDPATH**/ ?>