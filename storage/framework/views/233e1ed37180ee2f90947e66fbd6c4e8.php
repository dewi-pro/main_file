<?php echo Form::open([
    'route' => 'form-category.store',
    'method' => 'Post',
    'data-validate',
]); ?>

<div class="modal-body">
    <div class="form-group">
        <?php echo e(Form::label('name', __('Name'), ['class' => 'form-label'])); ?>

        <?php echo Form::text('name', null, ['placeholder' => __('Enter name'), 'class' => 'form-control', 'required']); ?>

    </div>

    <div class="form-group">
        <?php echo e(Form::label('status', __('Status'), ['class' => 'form-label'])); ?>

        <?php echo Form::hidden('status', null, ['id' => 'status-hidden']); ?>

        <?php echo e(Form::select(
            'status',
            [
                '' => __('Select Form Status'),
                '1' => __('Active'),
                '2' => __('Deactive'),
            ],
            null,
            ['class' => 'custom_select form-select', 'id' => 'status', 'data-trigger'],
        )); ?>

    </div>
</div>
<div class="modal-footer">
    <div class="text-end">
        <?php echo Html::link(route('form-category.index'), __('Cancel'), ['class' => 'btn btn-secondary']); ?>

        <?php echo e(Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary'])); ?>

    </div>
</div>
<?php echo Form::close(); ?>

<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form-category/create.blade.php ENDPATH**/ ?>