<?php $__env->startSection('title', 'Create Document'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Create Document')); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Dashboard'), []); ?></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('document.index')); ?>"><?php echo e(__('Documents')); ?></a></li>
            <li class="breadcrumb-item active"><?php echo e(__('Create Document')); ?></li>
        </ul>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="m-auto col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
            <?php echo Form::open([
                'route' => 'document.store',
                'method' => 'Post',
                'enctype' => 'multipart/form-data',
                'data-validate',
            ]); ?>

            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Create Document')); ?></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <?php echo e(Form::label('title', __('Title'), ['class' => 'form-label'])); ?>

                                <?php echo Form::text('title', null, ['class' => 'form-control', ' required', 'placeholder' => __('Enter title')]); ?>

                            </div>
                            <div class="form-group">
                                <?php echo e(Form::label('document_logo', __('Select Logo'), ['class' => 'form-label'])); ?>

                                <?php echo Form::file('document_logo', ['class' => 'form-control']); ?>

                                <small>
                                    <?php echo e(__('Note: Select an image of 250X 60 size.')); ?>

                                </small>
                            </div>

                            <div class="uploaded-pics gy-3 row">
                                <input id="themefile1" name="theme" type="hidden" value="theme1">
                                <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-5 theme-view-card selected-theme">
                                    <div class="theme-view-inner">
                                        <div class="theme-view-img">
                                            <img data-id="theme1" src="<?php echo e(asset('assets/document-theme/Stisla.png')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-5 theme-view-card">
                                    <div class="theme-view-inner">
                                        <div class="theme-view-img">
                                            <img data-id="theme2" src="<?php echo e(asset('assets/document-theme/Editor.png')); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <?php echo e(Form::label('change_log_status', __('Change Log'), ['class' => 'form-label'])); ?>

                                    </div>
                                    <div class="col-md-4 form-check form-switch">
                                        <input class="form-check-input float-end" id="change_log_status"
                                            name="change_log_status" type="checkbox">
                                        <span class="custom-switch-indicator"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group changeLog d-none">
                                <div class="repeater2">
                                    <div data-repeater-list="change_log_json">
                                        <div data-repeater-item>
                                            <hr />
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label('version', __('Change Log Version'), ['class' => 'form-label'])); ?>

                                                        <?php echo Form::text('version', null, [
                                                            'class' => 'form-control',
                                                            'placeholder' => __('Enter change log version'),
                                                            'id' => 'version',
                                                        ]); ?>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label('date', __('Change Log Date'), ['class' => 'form-label'])); ?>

                                                        <?php echo Form::text('date', null, [
                                                            'class' => 'form-control datePicker',
                                                            'placeholder' => __('Enter change log date'),
                                                            'id' => 'date',
                                                        ]); ?>

                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="inner-repeater">
                                                            <div data-repeater-list="inner-list">
                                                                <hr />
                                                                <div data-repeater-item>
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <?php echo e(Form::label('badge', __('Change Log Badge'), ['class' => 'form-label'])); ?>

                                                                                <?php echo Form::text('badge', null, [
                                                                                    'class' => 'form-control',
                                                                                    'placeholder' => __('Enter change log badge'),
                                                                                    'id' => 'badge',
                                                                                ]); ?>

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <?php echo e(Form::label('color', __('Change Log Color'), ['class' => 'form-label'])); ?>

                                                                                <?php echo Form::select('color', $colors, null, [
                                                                                    'class' => 'form-control',
                                                                                    'data-trigger',
                                                                                    'id' => 'color',
                                                                                ]); ?>

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                            <div class="form-group">
                                                                                <?php echo e(Form::label('text', __('Change Log Text'), ['class' => 'form-label'])); ?>

                                                                                <?php echo Form::text('text', null, [
                                                                                    'class' => 'form-control',
                                                                                    'placeholder' => __('Enter change log text'),
                                                                                    'id' => 'text',
                                                                                ]); ?>

                                                                            </div>
                                                                        </div>
                                                                        <div class="mt-27 col-lg-3">
                                                                            <input data-repeater-delete
                                                                                class="btn btn-danger" type="button"
                                                                                value="Delete" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input data-repeater-create class="btn btn-primary"
                                                                type="button" value="Add" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-2 text-right col-lg-12">
                                                    <input data-repeater-delete class="btn btn-danger" type="button"
                                                        value="Delete" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <input data-repeater-create class="btn btn-primary" type="button" value="Add" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-end">
                        <a href="<?php echo e(route('document.index')); ?>" class="btn btn-secondary"><?php echo e(__('Cancel')); ?></a>
                        <?php echo e(Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary'])); ?>

                    </div>
                </div>
            </div>
        </div>
        <?php echo Form::close(); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/datepicker-bs5.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/datepicker-full.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/repeater/reapeater.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.theme-view-img', function() {
                var theme = $(this).find('img').attr('data-id');
                $('input[name="theme"]').val(theme);
                $('.theme-view-card').removeClass('selected-theme');
                $(this).parents('.theme-view-card').addClass('selected-theme');
            });

            $(document).on('click', 'input[name="change_log_status"]', function() {
                if ($(this).is(':checked')) {
                    $('.changeLog').removeClass('d-none');
                } else {
                    $('.changeLog').addClass('d-none');
                }
            });

            var $repeater2 = $('.repeater2').repeater({
                initEmpty: false,
                repeaters: [{
                    selector: '.inner-repeater',
                    show: function() {
                        $(this).slideDown();
                        var selectName = $(this).find('select').attr('name');
                        var escapedSelectName = selectName.replace(/[-\/\\^$*+?.()|[\]{}]/g,
                            '\\$&');
                        var select = $(this).find('select[name="' + escapedSelectName + '"]');
                        var multipleCancelButton = new Choices(select[0], {
                            removeItemButton: true,
                        });
                    },
                    hide: function(deleteElement) {
                        if (confirm('Are you sure you want to delete this element?')) {
                            $(this).slideUp(deleteElement);
                        }
                    },
                    ready: function(setIndexes) {
                        var genericExamples = document.querySelectorAll('[data-trigger]');
                        for (i = 0; i < genericExamples.length; ++i) {
                            var element = genericExamples[i];
                            new Choices(element, {
                                placeholderValue: 'This is a placeholder set in the config',
                                searchPlaceholderValue: 'This is a search placeholder',
                            });
                        }
                    }
                }],
                defaultValues: {},
                show: function() {
                    $(this).slideDown();
                    var data = $(this).find('input,textarea,select').toArray();
                    data.forEach(function(val) {
                        $(val).parents('.form-group').find('label').attr('for', $(val).attr(
                            'name'));
                        $(val).attr('id', $(val).attr('name'));
                    });
                    var selectName = $(this).find('select').attr('name');
                    var escapedSelectName = selectName.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                    var select = $(this).find('select[name="' + escapedSelectName + '"]');
                    var multipleCancelButton = new Choices(select[0], {
                        removeItemButton: true,
                    });
                    var datePicker = document.querySelectorAll('.datePicker');
                    for (i = 0; i < datePicker.length; ++i) {
                        var element = datePicker[i];
                        const d_week = new Datepicker(element, {
                            buttonClass: 'btn',
                        });
                    }
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function(setIndexes) {
                    var genericExamples = document.querySelectorAll('[data-trigger]');
                    for (i = 0; i < genericExamples.length; ++i) {
                        var element = genericExamples[i];
                        new Choices(element, {
                            placeholderValue: 'This is a placeholder set in the config',
                            searchPlaceholderValue: 'This is a search placeholder',
                        });
                    }
                    var datePicker = document.querySelectorAll('.datePicker');
                    for (i = 0; i < datePicker.length; ++i) {
                        var element = datePicker[i];
                        const d_week = new Datepicker(element, {
                            buttonClass: 'btn',
                        });
                    }
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/document/create.blade.php ENDPATH**/ ?>