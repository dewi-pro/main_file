<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-document')): ?>
    <?php if($document->document_menu && $document->status == 1): ?>
        <a class="btn btn-success btn-sm copy_menu" onclick="copyToClipboard('#copy-menu-<?php echo e($document->id); ?>')"
            href="javascript:void(0)" id="copy-menu-<?php echo e($document->id); ?>" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="<?php echo e(__('Copy Document URL')); ?>"
            data-url="<?php echo e(route('document.public', $document->document_menu->slug)); ?>"><i class="ti ti-copy"></i></a>

        <a href="<?php echo e(route('document.public', $document->document_menu->slug)); ?>" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('View Document')); ?>" target="_blank"
            class="btn btn-info mr-1 btn-sm" data-toggle="tooltip"><i class="ti ti-eye"></i></a>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('document-generate-document')): ?>
        <a class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="<?php echo e(__('Document Generate')); ?>" href="<?php echo e(route('document.design', $document->id)); ?>"
            id="edit-menu"><i class="ti ti-brush"></i></a>
    <?php endif; ?>


    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-document')): ?>
        <a class="btn btn-sm btn-primary" href="<?php echo e(route('document.edit', $document->id)); ?>" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Edit')); ?>" aria-label="<?php echo e(__('Edit')); ?>"><i
                class="ti ti-edit text-white"></i></a>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-document')): ?>
        <?php echo Form::open([
            'method' => 'DELETE',
            'class' => 'd-inline',
            'route' => ['document.destroy', $document->id],
            'id' => 'delete-form-' . $document->id,
        ]); ?>

        <a href="javascript:void(0);" class="btn btn-sm btn btn-danger show_confirm" data-bs-toggle="tooltip"
            data-bs-placement="bottom" title="" id="delete-form-1" data-bs-original-title="<?php echo e(__('Delete')); ?>"
            aria-label="<?php echo e(__('Delete')); ?>"><i class="ti ti-trash text-white"></i></a>
        <?php echo Form::close(); ?>

    <?php endif; ?>
<?php endif; ?>
<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/document/action.blade.php ENDPATH**/ ?>