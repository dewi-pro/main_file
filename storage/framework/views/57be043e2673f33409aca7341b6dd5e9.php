<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('design-form-template')): ?>
    <a class="btn btn-info btn-sm" href="<?php echo e(route('formTemplate.design', $FormTemplate->id)); ?>" id="design-form"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Design')); ?>"><i
            class="ti ti-brush"></i></a>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-form-template')): ?>
    <a class="btn btn-sm small btn-primary" href="<?php echo e(route('form-template.edit', $FormTemplate->id)); ?>" data-bs-toggle="tooltip"
        data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Edit')); ?>" aria-label="<?php echo e(__('Edit')); ?>"><i
            class="ti ti-edit"></i></a>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-form-template')): ?>
    <?php echo Form::open([
        'method' => 'DELETE',
        'class' => 'd-inline',
        'route' => ['form-template.destroy', $FormTemplate->id],
        'id' => 'delete-form-' . $FormTemplate->id,
    ]); ?>

    <a href="#" class="btn btn-sm small btn-danger show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        id="delete-form-<?php echo e($FormTemplate->id); ?>" data-bs-original-title="<?php echo e(__('Delete')); ?>" aria-label="<?php echo e(__('Delete')); ?>"><i
            class="ti ti-trash"></i></a>
    <?php echo Form::close(); ?>

<?php endif; ?>
<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form-template/action.blade.php ENDPATH**/ ?>