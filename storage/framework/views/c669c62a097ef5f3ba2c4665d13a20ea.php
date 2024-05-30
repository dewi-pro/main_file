<?php echo Form::open([
    'route' => 'docmenu.store',
    'method' => 'Post',
    'data-validate',
]); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group">
            <?php echo e(Form::label('title', __('Title'), ['class' => 'form-label'])); ?>

            <?php echo Form::text('title', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter title')]); ?>

        </div>
        <input type="hidden" name="document_id" value="<?php echo e($documents->id); ?>">
    </div>
</div>
<div class="modal-footer">
    <div class="float-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
        <?php echo e(Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary'])); ?>

    </div>
</div>
<?php echo Form::close(); ?>


<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/document-menu/create.blade.php ENDPATH**/ ?>