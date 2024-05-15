<?php
    $hashids = new Hashids('', 20);
    $id = $hashids->encodeHex($form->id);
    $view = request()->query->get('view');
?>

<?php if($view == null): ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-form')): ?>
        <?php if($form->json): ?>
            <?php if($form->is_active): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('theme-setting-form')): ?>
                    <a class="btn btn-secondary btn-sm" href="<?php echo e(route('form.theme', $form->id)); ?>" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Theme Setting')); ?>"><i
                            class="ti ti-layout-2"></i></a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payment-form')): ?>
                    <a class="btn btn-warning btn-sm" href="<?php echo e(route('form.payment.integration', $form->id)); ?>"
                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                        data-bs-original-title="<?php echo e(__('Payment Integration')); ?>"><i class="ti ti-report-money"></i></a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('integration-form')): ?>
                    <a class="btn btn-info btn-sm" href="<?php echo e(route('form.integration', $form->id)); ?>" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Integration')); ?>"><i
                            class="ti ti-send"></i></a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-form-rule')): ?>
                    <a class="btn btn-secondary btn-sm" href="<?php echo e(route('form.rules', $form->id)); ?>" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Conditional Rules')); ?>"><i
                            class="ti ti-notebook"></i></a>
                <?php endif; ?>
                <a class="btn btn-primary btn-sm embed_form " href="javascript:void(0)"
                    onclick="copyToClipboard('#embed-form-<?php echo e($form->id); ?>')" id="embed-form-<?php echo e($form->id); ?>"
                    data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Embedded form')); ?>"
                    data-url='<iframe src="<?php echo e(route('forms.survey', $id)); ?>" scrolling="auto" align="bottom" height:100vh; width="100%></iframe>'><i
                        class="ti ti-code"></i></a>

                <?php if($form->limit_status == 1): ?>
                    <?php if($form->limit > $formValue): ?>
                        <a class="btn btn-success btn-sm copy_form "
                            onclick="copyToClipboard('#copy-form-<?php echo e($form->id); ?>')" href="javascript:void(0)"
                            id="copy-form-<?php echo e($form->id); ?>" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            data-bs-original-title="<?php echo e(__('Copy Form URL')); ?>"
                            data-url="<?php echo e(route('forms.survey', $id)); ?>"><i class="ti ti-copy"></i></a>
                    <?php endif; ?>
                <?php else: ?>
                    <a class="btn btn-success btn-sm copy_form "
                        onclick="copyToClipboard('#copy-form-<?php echo e($form->id); ?>')" href="javascript:void(0)"
                        id="copy-form-<?php echo e($form->id); ?>" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        data-bs-original-title="<?php echo e(__('Copy Form URL')); ?>" data-url="<?php echo e(route('forms.survey', $id)); ?>"><i
                            class="ti ti-copy"></i></a>
                <?php endif; ?>

                <a class="btn btn-info btn-sm cust_btn text-white" data-share="<?php echo e(route('forms.survey.qr', $id)); ?>"
                    id="share-qr-code" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    data-bs-original-title="<?php echo e(__('Show QR Code')); ?>"><i class="ti ti-qrcode"></i></a>
                <a class="btn btn-secondary btn-sm" href="<?php echo e(route('view.form.values', $form->id)); ?>"
                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                    data-bs-original-title="<?php echo e(__('View Submited forms')); ?>"><i class="ti ti-clipboard-check"></i></a>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('fill-form')): ?>
        <?php if($form->json): ?>
            <?php if($form->limit_status == 1): ?>
                <?php if($form->limit > $formValue): ?>
                    <a class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        data-bs-original-title="<?php echo e(__('Fill Form')); ?>" href="<?php echo e(route('forms.fill', $form->id)); ?>"><i
                            class="ti ti-list"></i></a>
                <?php endif; ?>
            <?php else: ?>
                <a class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    data-bs-original-title="<?php echo e(__('Fill Form')); ?>" href="<?php echo e(route('forms.fill', $form->id)); ?>"><i
                        class="ti ti-list"></i></a>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('duplicate-form')): ?>
        <a href="#" class="btn btn-warning btn-sm " data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="<?php echo e(__('Duplicate Form')); ?>"
            onclick="document.getElementById('duplicate-form-<?php echo e($form->id); ?>').submit();"><i
                class="ti ti-squares-diagonal"></i></a>
    <?php endif; ?>


    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('design-form')): ?>
        <a class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="<?php echo e(__('Design Form')); ?>" href="<?php echo e(route('forms.design', $form->id)); ?>"><i
                class="ti ti-brush"></i></a>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-form')): ?>
        <a class="btn btn-primary btn-sm" href="<?php echo e(route('forms.edit', $form->id)); ?>" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Edit Form')); ?>" id="edit-form"><i
                class="ti ti-edit"></i></a>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-form')): ?>
        <?php echo Form::open([
            'method' => 'DELETE',
            'route' => ['forms.destroy', $form->id],
            'id' => 'delete-form-' . $form->id,
            'class' => 'd-inline',
        ]); ?>

        <a href="#" class="btn btn-danger btn-sm show_confirm_submited_form_delete" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Delete')); ?>"
            id="delete-form-<?php echo e($form->id); ?>"><i class="mr-0 ti ti-trash"></i></a>
        <?php echo Form::close(); ?>

    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('duplicate-form')): ?>
        <?php echo Form::open(['method' => 'POST', 'route' => ['forms.duplicate'], 'id' => 'duplicate-form-' . $form->id]); ?>

        <?php echo Form::hidden('form_id', $form->id, []); ?>

        <?php echo Form::close(); ?>

    <?php endif; ?>
<?php endif; ?>

<?php if($view !== null && $view == 'trash'): ?>
    <a class="btn btn-success btn-sm" href="<?php echo e(route('form.restore', $form->id)); ?>" data-bs-toggle="tooltip"
        data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Restore')); ?>"><i class="ti ti-recycle"></i></a>

    <?php echo Form::open([
        'method' => 'DELETE',
        'route' => ['form.force.delete', $form->id],
        'id' => 'formforcedelete-' . $form->id,
        'class' => 'd-inline',
    ]); ?>

    <a href="#" class="btn btn-danger btn-sm show_confirm" id="formforcedelete-<?php echo e($form->id); ?>"
        data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="<?php echo e(__('Delete Pemanently')); ?>"><i class="mr-0 ti ti-trash"></i></a>
    <?php echo Form::close(); ?>

<?php endif; ?>
<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form/action.blade.php ENDPATH**/ ?>