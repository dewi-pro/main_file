

<?php echo Form::model($formStatus, [
    'route' => ['form-status.update', $formStatus->id],
    'method' => 'put',
    'data-validate',
]); ?>


<div class="modal-body">
    <div class="form-group">
        <?php echo e(Form::label('name', __('Name'), ['class' => 'form-label'])); ?>

        <?php echo Form::text('name', null, ['placeholder' => __('Enter name'), 'class' => 'form-control', 'required']); ?>

    </div>
    <div class="form-group">
        <?php echo e(Form::label('color', __('Color'), ['class' => 'form-label'])); ?>

        <?php echo Form::hidden('color', null, ['id' => 'color-hidden']); ?>

        <?php echo e(Form::select(
            'color',
            [
                '' => __('Select Status Color'),
                'danger' => __('Danger'),
                'success' => __('Success'),
                'info' => __('Info'),
                'primary' => __('Primary'),
                'secondary' => __('Secondary'),
                'warning' => __('Warning'),
            ],
            null,
            ['class' => 'custom_select form-select', 'id' => 'color', 'data-trigger'],
        )); ?>

    </div>
    <div class="form-group">
        <?php echo e(Form::label('status', __('Status'), ['class' => 'form-label'])); ?>

        <?php echo Form::hidden('status', null, ['id' => 'status-hidden']); ?>

        <select name="status" class="custom_select form-select select2" id="status" data-trigger>
            <option value="" selected disabled><?php echo e(__('Select Status')); ?></option>
            <option value="1" <?php if($formStatus->status == '1'): ?> selected <?php endif; ?>><?php echo e(__('Active')); ?>

            </option>
            <option value="0" <?php if($formStatus->status == '0'): ?> selected <?php endif; ?>><?php echo e(__('Deactive')); ?>

            </option>
        </select>
    </div>
</div>
<div class="modal-footer">
    <div class="text-end">
        <?php echo Html::link(route('form-status.index'), __('Cancel'), ['class' => 'btn btn-secondary']); ?>

        <?php echo e(Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary'])); ?>

    </div>
</div>
<?php echo Form::close(); ?>


<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form-status/edit.blade.php ENDPATH**/ ?>