<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-form-category')): ?>
    <a class="btn btn-sm small btn btn-primary" href="javascript:void(0);"
    data-url="<?php echo e(route('form-category.edit', $category->id)); ?>" id="edit-form-category"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Edit')); ?>">
        <i class="ti ti-edit text-white"></i>
    </a>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-form-category')): ?>
    <?php echo Form::open([
        'method' => 'DELETE',
        'class' => 'd-inline',
        'route' => ['form-category.destroy', $category->id],
        'id' => 'delete-form-' . $category->id,
    ]); ?>

    <a href="#" class="btn btn-sm small btn btn-danger show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        id="delete-form-1" data-bs-original-title="<?php echo e(__('Delete')); ?>">
        <i class="ti ti-trash text-white"></i>
    </a>
    <?php echo Form::close(); ?>

<?php endif; ?>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form-category/action.blade.php ENDPATH**/ ?>