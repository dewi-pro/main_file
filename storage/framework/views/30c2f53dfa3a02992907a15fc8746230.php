<?php echo Form::open([
    'route' => ['form.theme.update', $form->id],
    'method' => 'POST',
    'enctype' => 'multipart/form-data',
    'novalidate',
    'data-validate',
]); ?>

<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <?php echo e(Form::hidden('theme', $slug, [])); ?>

            <div class="form-group d-flex align-items-center row">
                <div class="setting-card setting-logo-box">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <h6 class="mt-2">
                                    <i data-feather="credit-card" class="me-2"></i><?php echo e(__('Primary color settings')); ?>

                                </h6>
                                <div class="theme-color themes-color">
                                    <a href="javascript:void(0);"
                                        class="theme-colors <?php echo e($form->theme_color == 'theme-1' ? 'active_color' : ''); ?>"
                                        data-value="theme-1"></a>
                                    <input type="radio" class="theme_color d-none" <?php echo e($form->theme_color == 'theme-1' ? 'checked' : ''); ?> name="color" value="theme-1">
                                    <a href="javascript:void(0);"
                                        class="theme-colors <?php echo e($form->theme_color == 'theme-2' ? 'active_color' : ''); ?>"
                                        data-value="theme-2"></a>
                                    <input type="radio" class="theme_color d-none" <?php echo e($form->theme_color == 'theme-2' ? 'checked' : ''); ?> name="color" value="theme-2">
                                    <a href="javascript:void(0);"
                                        class="theme-colors <?php echo e($form->theme_color == 'theme-3' ? 'active_color' : ''); ?>"
                                        data-value="theme-3"></a>
                                    <input type="radio" class="theme_color d-none" <?php echo e($form->theme_color == 'theme-3' ? 'checked' : ''); ?> name="color" value="theme-3">
                                    <a href="javascript:void(0);"
                                        class="theme-colors <?php echo e($form->theme_color == 'theme-4' ? 'active_color' : ''); ?>"
                                        data-value="theme-4"></a>
                                    <input type="radio" class="theme_color d-none" <?php echo e($form->theme_color == 'theme-4' ? 'checked' : ''); ?> name="color" value="theme-4">
                                    <a href="javascript:void(0);"
                                        class="theme-colors <?php echo e($form->theme_color == 'theme-5' ? 'active_color' : ''); ?>"
                                        data-value="theme-5"></a>
                                    <input type="radio" class="theme_color d-none" <?php echo e($form->theme_color == 'theme-5' ? 'checked' : ''); ?> name="color" value="theme-5">
                                    <br>
                                    <a href="javascript:void(0);"
                                        class="theme-colors <?php echo e($form->theme_color == 'theme-6' ? 'active_color' : ''); ?>"
                                        data-value="theme-6"></a>
                                    <input type="radio" class="theme_color d-none" <?php echo e($form->theme_color == 'theme-6' ? 'checked' : ''); ?> name="color" value="theme-6">
                                    <a href="javascript:void(0);"
                                        class="theme-colors <?php echo e($form->theme_color == 'theme-7' ? 'active_color' : ''); ?>"
                                        data-value="theme-7"></a>
                                    <input type="radio" class="theme_color d-none" <?php echo e($form->theme_color == 'theme-7' ? 'checked' : ''); ?> name="color" value="theme-7">
                                    <a href="javascript:void(0);"
                                        class="theme-colors <?php echo e($form->theme_color == 'theme-8' ? 'active_color' : ''); ?>"
                                        data-value="theme-8"></a>
                                    <input type="radio" class="theme_color d-none" <?php echo e($form->theme_color == 'theme-8' ? 'checked' : ''); ?> name="color" value="theme-8">
                                    <a href="javascript:void(0);"
                                        class="theme-colors <?php echo e($form->theme_color == 'theme-9' ? 'active_color' : ''); ?>"
                                        data-value="theme-9"></a>
                                    <input type="radio" class="theme_color d-none" <?php echo e($form->theme_color == 'theme-9' ? 'checked' : ''); ?> name="color" value="theme-9">
                                    <a href="javascript:void(0);"
                                        class="theme-colors <?php echo e($form->theme_color == 'theme-10' ? 'active_color' : ''); ?>"
                                        data-value="theme-10"></a>
                                    <input type="radio" class="theme_color d-none" <?php echo e($form->theme_color == 'theme-10' ? 'checked' : ''); ?> name="color" value="theme-10">
                                </div>
                            </div>
                            <?php if($slug == 'theme3'): ?>
                                <div class="form-group">
                                    <?php echo e(Form::label('background_image', __('Background Image'), ['class' => 'form-label'])); ?>

                                    <?php echo Form::file('background_image', ['class' => 'form-control']); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="float-end">
        <?php echo e(Form::button(__('Cancel'), ['class' => 'btn btn-secondary', 'data-bs-dismiss' => 'modal'])); ?>

        <?php echo e(Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary', 'data-bs-dismiss' => 'modal', 'id' => 'save-btn'])); ?>

    </div>
</div>
<?php echo Form::close(); ?>

<?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form/themes/index.blade.php ENDPATH**/ ?>