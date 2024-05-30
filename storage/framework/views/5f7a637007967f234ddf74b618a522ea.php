<?php $__env->startSection('title', __('Form')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Design Form')); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Dashboard'), []); ?></li>
            <li class="breadcrumb-item"><?php echo Html::link(route('forms.index'), __('Forms'), []); ?></li>
            <li class="breadcrumb-item active"> <?php echo e(__('Design Form')); ?> </li>
        </ul>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="main-content">
            <?php if(isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'http'): ?>
                <div class="alert alert-warning">
                    <b>
                        <?php echo e(__('Please note that the video recording and selfie features are only available on HTTPS websites and its not work on HTTP sites.')); ?></b>
                </div>
            <?php endif; ?>
            <section class="section">
                <div class="section-body">
                    <?php echo e(Form::model($form, ['route' => ['forms.design.update', $form->id], 'data-validate', 'method' => 'PUT', 'id' => 'design-form'])); ?>

                    <div class="row">
                        <div class="col-xl-12 order-xl-1">
                            <div class="card">
                                <div class="card-header">
                                    <h5><?php echo e(__('Design Form')); ?></h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php
                                                        $array = json_decode($form->json);
                                                    ?>
                                                    <ul id="tabs"
                                                        class="mb-3 nav nav-tabs ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
                                                        <?php if(!empty($form->json)): ?>
                                                            <?php $__currentLoopData = $array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
                                                                    $key = $key + 1;
                                                                ?>
                                                                <li
                                                                    class="nav-item ui-state-default ui-corner-top ui-state-focus">
                                                                    <?php echo Html::link("#page-$key", __('Page') . $key, ['class' => 'nav-link']); ?>

                                                                </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                            <li>
                                                                <?php echo Html::link('#page-1', __('Page1'), []); ?>

                                                            </li>
                                                        <?php endif; ?>
                                                        <li id="add-page-tab">
                                                            <?php echo Html::link('#new-page', __('+Page'), [
                                                                'class' => 'nav-link',
                                                            ]); ?>

                                                        </li>
                                                    </ul>
                                                    <?php if(!empty($form->json)): ?>
                                                        <?php $__currentLoopData = $array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div id="page-<?php echo e($key + 1); ?>" class="build-wrap"></div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <div id="page-1" class="build-wrap"></div>
                                                    <?php endif; ?>

                                                    <div id="new-page"></div>
                                                    <?php echo Form::hidden('json', $form->json, ['class' => '']); ?>

                                                    <br>
                                                    <div class="action-buttons">
                                                        <?php echo Form::button(__('Show Data'), ['class' => 'd-none', 'id' => 'showData']); ?>

                                                        <?php echo Form::button(__('Clear All Fields'), ['class' => 'd-none', 'id' => 'clearFields']); ?>

                                                        <?php echo Form::button(__('Get Data'), ['class' => 'd-none', 'id' => 'getData']); ?>

                                                        <?php echo Form::button(__('Get XML Data'), ['class' => 'd-none', 'id' => 'getXML']); ?>

                                                        <?php echo Form::button(__('Update'), ['class' => 'btn btn-primary', 'id' => 'getJSON']); ?>

                                                        <?php echo Form::button(__('Back'), [
                                                            'class' => 'd-none',
                                                            'onClick' => 'javascript:history.go(-1)',
                                                            'id' => 'getJSONs',
                                                        ]); ?>

                                                        <?php echo Form::button(__('Get JS Data'), ['class' => 'd-none', 'id' => 'getJS']); ?>

                                                        <?php echo Form::button(__('Set Data'), ['class' => 'd-none', 'id' => 'setData']); ?>

                                                        <?php echo Form::button(__('Add Field'), ['class' => 'd-none', 'id' => 'addField']); ?>

                                                        <?php echo Form::button(__('Remove Field'), ['class' => 'd-none', 'id' => 'removeField']); ?>

                                                        <?php echo Form::button(__('Test Submit'), ['type' => 'submit', 'class' => 'd-none', 'id' => 'testSubmit']); ?>

                                                        <?php echo Form::button(__('Reset Demo'), ['class' => 'd-none', 'id' => 'resetDemo']); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </section>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendor/jqueryform/css/demo.css')); ?>">
    <link href="<?php echo e(asset('vendor/jqueryform/css/jquery.rateyo.min.css')); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/jquery-ui.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        var lang = '<?php echo e(app()->getLocale()); ?>';
        var lang_other = '<?php echo e(__('Other')); ?>';
        var lang_other_placeholder = '<?php echo e(__('Enter Please')); ?>';
        var lang_Page = '<?php echo e(__('Page')); ?>';
        var lang_Custom_Autocomplete = '<?php echo e(__('Custom Autocomplete')); ?>';
    </script>
    <script src="<?php echo e(asset('vendor/jqueryform/js/signaturePad.umd.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/jqueryform/js/vendor.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/modules/jquery.nicescroll.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/jqueryform/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/jqueryform/js/form-builder.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/jqueryform/js/form-render.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/jqueryform/js/demoFirst.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/jqueryform/js/jquery.rateyo.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form/design.blade.php ENDPATH**/ ?>