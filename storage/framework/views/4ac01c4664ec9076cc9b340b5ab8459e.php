<?php $__env->startSection('title', __('Theme Setting')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="d-flex justify-content-between">
            <div class="previous-next-btn">
                <div class="page-header-title">
                    <h4 class="m-b-10"><?php echo e(__('Theme Setting')); ?></h4>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('forms.index')); ?>"><?php echo e(__('Forms')); ?></a></li>
                    <li class="breadcrumb-item"> <?php echo e(__('Theme Setting')); ?> </li>
                </ul>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Theme Setting')); ?></h5>
                </div>
                <?php echo Form::open([
                    'route' => ['form.theme.change', $form->id],
                    'method' => 'POST',
                    'novalidate',
                    'data-validate',
                ]); ?>

                <div class="card-body">
                    <?php echo e(Form::hidden('theme', $form->theme, [])); ?>

                    <div class="form-group">
                        <label class="form-label"><?php echo e(__('Select Themes')); ?></label>
                    </div>
                    <div class="uploaded-pics gy-3 row">
                        <div
                            class="col-lg-3 col-md-4 col-sm-6 theme-view-card <?php echo e($form->theme == 'theme1' ? 'selected-theme' : ''); ?>">
                            <div class="theme-view-inner theme-view-hover">
                                <div class="theme-view-img">
                                    <img data-id="theme1" src="<?php echo e(asset('assets/form-themes/theme1/theme1.png')); ?>">
                                </div>
                                <div class="theme-overlay"></div>
                                <div class="theme-button"><button
                                        data-url="<?php echo e(route('form.theme.edit', ['theme1', $form->id])); ?>"
                                        class="btn btn-primary btn-sm selectTheme" type="button"><i
                                            class="ti ti-edit"></i></button>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-lg-3 col-md-4 col-sm-6 theme-view-card <?php echo e($form->theme == 'theme2' ? 'selected-theme' : ''); ?>">
                            <div class="theme-view-inner theme-view-hover">
                                <div class="theme-view-img">
                                    <img data-id="theme2" src="<?php echo e(asset('assets/form-themes/theme2/theme2.jpg')); ?>">
                                </div>
                                <div class="theme-overlay"></div>
                                <div class="theme-button"><button
                                        data-url="<?php echo e(route('form.theme.edit', ['theme2', $form->id])); ?>"
                                        class="btn btn-primary btn-sm selectTheme" type="button"><i
                                            class="ti ti-edit"></i></button>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-lg-3 col-md-4 col-sm-6 theme-view-card <?php echo e($form->theme == 'theme3' ? 'selected-theme' : ''); ?>">
                            <div class="theme-view-inner theme-view-hover">
                                <div class="theme-view-img">
                                    <img data-id="theme3" src="<?php echo e(asset('assets/form-themes/theme3/theme3.jpg')); ?>">
                                </div>
                                <div class="theme-overlay"></div>
                                <div class="theme-button">
                                    <button data-url="<?php echo e(route('form.theme.edit', ['theme3', $form->id])); ?>"
                                        class="btn btn-primary btn-sm selectTheme" type="button"><i
                                            class="ti ti-edit"></i></button>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-lg-3 col-md-4 col-sm-6 theme-view-card <?php echo e($form->theme == 'theme4' ? 'selected-theme' : ''); ?>">
                            <div class="theme-view-inner theme-view-hover">
                                <div class="theme-view-img">
                                    <img data-id="theme4" src="<?php echo e(asset('assets/form-themes/theme4/theme4.png')); ?>">
                                </div>
                                <div class="theme-overlay"></div>
                                <div class="theme-button"><button
                                        data-url="<?php echo e(route('form.theme.edit', ['theme4', $form->id])); ?>"
                                        class="btn btn-primary btn-sm selectTheme" type="button"><i
                                            class="ti ti-edit"></i></button>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-lg-3 col-md-4 col-sm-6 theme-view-card <?php echo e($form->theme == 'theme5' ? 'selected-theme' : ''); ?>">
                            <div class="theme-view-inner theme-view-hover">
                                <div class="theme-view-img">
                                    <img data-id="theme5" src="<?php echo e(asset('assets/form-themes/theme5/theme5.png')); ?>">
                                </div>
                                <div class="theme-overlay"></div>
                                <div class="theme-button"><button
                                        data-url="<?php echo e(route('form.theme.edit', ['theme5', $form->id])); ?>"
                                        class="btn btn-primary btn-sm selectTheme" type="button"><i
                                            class="ti ti-edit"></i></button>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-lg-3 col-md-4 col-sm-6 theme-view-card <?php echo e($form->theme == 'theme6' ? 'selected-theme' : ''); ?>">
                            <div class="theme-view-inner theme-view-hover">
                                <div class="theme-view-img">
                                    <img data-id="theme6" src="<?php echo e(asset('assets/form-themes/theme6/theme6.png')); ?>">
                                </div>
                                <div class="theme-overlay"></div>
                                <div class="theme-button"><button
                                        data-url="<?php echo e(route('form.theme.edit', ['theme6', $form->id])); ?>"
                                        class="btn btn-primary btn-sm selectTheme" type="button"><i
                                            class="ti ti-edit"></i></button>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-lg-3 col-md-4 col-sm-6 theme-view-card <?php echo e($form->theme == 'theme7' ? 'selected-theme' : ''); ?>">
                            <div class="theme-view-inner theme-view-hover">
                                <div class="theme-view-img">
                                    <img data-id="theme7" src="<?php echo e(asset('assets/form-themes/theme7/theme7.jpg')); ?>">
                                </div>
                                <div class="theme-overlay"></div>
                                <div class="theme-button"><button
                                        data-url="<?php echo e(route('form.theme.edit', ['theme7', $form->id])); ?>"
                                        class="btn btn-primary btn-sm selectTheme" type="button"><i
                                            class="ti ti-edit"></i></button>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-lg-3 col-md-4 col-sm-6 theme-view-card <?php echo e($form->theme == 'theme8' ? 'selected-theme' : ''); ?>">
                            <div class="theme-view-inner theme-view-hover">
                                <div class="theme-view-img">
                                    <img data-id="theme8" src="<?php echo e(asset('assets/form-themes/theme8/theme8.jpg')); ?>">
                                </div>
                                <div class="theme-overlay"></div>
                                <div class="theme-button"><button
                                        data-url="<?php echo e(route('form.theme.edit', ['theme8', $form->id])); ?>"
                                        class="btn btn-primary btn-sm selectTheme" type="button"><i
                                            class="ti ti-edit"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-end">
                        <?php echo Html::link(route('forms.index'), __('Cancel'), ['class' => 'btn btn-secondary']); ?>

                        <?php echo e(Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary'])); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.theme-button button.selectTheme', function() {
                var url = $(this).attr('data-url');
                var modal = $('#common_modal');
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {},
                    success: function(response) {
                        modal.find('.modal-title').html('<?php echo e(__('Edit Theme')); ?>');
                        modal.find('.body').html(response);
                        modal.modal('show');
                        modal.find('.theme-colors').click(function() {
                            $('.theme-colors').removeClass('active_color');
                            $(this).addClass('active_color');
                            var val = $(this).attr('data-value');
                            modal.find('input[name="color"]').attr('checked', false);
                            modal.find('input[value="' + val + '"]').attr('checked',
                                true);
                        });
                    },
                    error: function(error) {}
                });
            });
            $(document).on('click', '.theme-view-hover', function() {
                var theme = $(this).find('img').attr('data-id');
                $('input[name="theme"]').val(theme);
                $('.theme-view-card').removeClass('selected-theme');
                $(this).parents('.theme-view-card').addClass('selected-theme');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form/themes/theme.blade.php ENDPATH**/ ?>