<?php if(Auth::user()->type == 'Admin'): ?>
    <?php if($formValue->form_edit_lock_status == 1): ?>
        <a href="<?php echo e(route('form.fill.edit.lock', $formValue->id)); ?>" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="<?php echo e(__('Unlock')); ?>" title="<?php echo e(__('Unlock Edit')); ?>" class="btn btn-danger btn-sm"
            data-toggle="tooltip"><i class="ti ti-lock"></i> </a>
    <?php else: ?>
        <a href="<?php echo e(route('form.fill.edit.lock', $formValue->id)); ?>" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="<?php echo e(__('Lock')); ?>" title="<?php echo e(__('Lock Edit')); ?>" class="btn btn-success btn-sm"
            data-toggle="tooltip"><i class="ti ti-lock-open"></i> </a>
    <?php endif; ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('download-submitted-form')): ?>
    <a href="<?php echo e(route('download.form.values.pdf', $formValue->id)); ?>" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="<?php echo e(__('Download')); ?>" class="btn btn-success btn-sm" data-toggle="tooltip"><i
            class="ti ti-file-download"></i></a>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show-submitted-form')): ?>
    <a href="<?php echo e(route('form-values.show', $formValue->id)); ?>" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="<?php echo e(__('Show')); ?>" title="<?php echo e(__('View Survey')); ?>" class="btn btn-info btn-sm"
        data-toggle="tooltip"><i class="ti ti-eye"></i></a>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-submitted-form')): ?>
    <?php if(Auth::user()->type == 'Admin'): ?>
        <a href="<?php echo e(route('form-values.edit', $formValue->id)); ?>" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="<?php echo e(__('Edit')); ?>" title="<?php echo e(__('Edit Survey')); ?>" class="btn btn-primary btn-sm"
            data-toggle="tooltip"><i class="ti ti-edit"></i> </a>
    <?php elseif($formValue->form_edit_lock_status == 0 && Auth::user()->type != 'Admin'): ?>
        <a href="<?php echo e(route('form-values.edit', $formValue->id)); ?>" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="<?php echo e(__('Edit')); ?>" title="<?php echo e(__('Edit Survey')); ?>" class="btn btn-primary btn-sm"
            data-toggle="tooltip"><i class="ti ti-edit"></i> </a>
    <?php endif; ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('change-status-form-status')): ?>
        <!-- <a class="btn btn-info btn-sm cust_btn text-white" data-share="<?php echo e(route('form-value.status.change', $formValue->id)); ?>"
            data-bs-toggle="tooltip" data-bs-placement="bottom" id="change-form-status"
            data-bs-original-title="<?php echo e(__('Change Status')); ?>"><i class="ti ti-switch-2"></i></a> -->
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-submitted-form')): ?>
    <?php echo Form::open([
        'method' => 'DELETE',
        'route' => ['form-values.destroy', $formValue->id],
        'id' => 'delete-form-' . $formValue->id,
        'class' => 'd-inline',
    ]); ?>

    <a href="#" class="btn btn-danger btn-sm show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="<?php echo e(__('Delete')); ?>" id="delete-form-<?php echo e($formValue->id); ?>"><i class="ti ti-trash"></i></a>
    <?php echo Form::close(); ?>

<?php endif; ?>
<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form-value/action.blade.php ENDPATH**/ ?>