<?php $__env->startSection('title', __('Form Template Design')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Form Template Design')); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Dashboard'), ['']); ?></li>
            <li class="breadcrumb-item"><?php echo Html::link(route('form-template.index'), __('Form Templates'), ['']); ?></li>
            <li class="breadcrumb-item"><?php echo e(__('Form Template Design')); ?></li>
        </ul>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="main-content">
            <?php if($_SERVER['REQUEST_SCHEME'] == 'http'): ?>
                <div class="alert alert-warning">
                    <b>
                        <?php echo e(__('Please note that the video recording and selfie features are only available on HTTPS websites and its not work on HTTP sites.')); ?></b>
                </div>
            <?php endif; ?>
            <section class="section">
                <div class="section-body">
                    <?php echo e(Form::model($formTemplate, ['route' => ['form.template.design.update', $formTemplate->id], 'method' => 'PUT', 'id' => 'design-form'])); ?>

                    <div class="row">
                        <div class="col-xl-12 order-xl-1">
                            <div class="card">
                                <div class="card-header">
                                    <h5><?php echo e(__('Design Form')); ?></h5>
                                </div>
                                <div class="card-body">
                                    <div class="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php
                                                    $array = json_decode($formTemplate->json);
                                                ?>
                                                <ul class="mb-3 nav nav-tabs" id="tabs">
                                                    <?php if(!empty($formTemplate->json)): ?>
                                                        <?php $__currentLoopData = $array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li class="nav-item">
                                                                <a class="nav-link"
                                                                    href="#page-<?php echo e($key + 1); ?>"><?php echo e(__('Page') . ($key + 1)); ?></a>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <li class="nav-item"><a class="nav-link "
                                                                href="#page-1"><?php echo e(__('Page')); ?>1</a></li>
                                                    <?php endif; ?>
                                                    <li class="nav-item" id="add-page-tab"><a class="nav-link"
                                                            href="#new-page">+
                                                            <?php echo e(__('Page')); ?></a>
                                                    </li>
                                                </ul>
                                                <?php if(!empty($formTemplate->json)): ?>
                                                    <?php $__currentLoopData = $array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div id="page-<?php echo e($key + 1); ?>" class="build-wrap">
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <div id="page-1" class="build-wrap"></div>
                                                <?php endif; ?>
                                                <div id="new-page"></div>
                                                <input type="hidden" name="json" value="<?php echo e($formTemplate->json); ?>">
                                                <br>
                                                <div class="action-buttons">
                                                    <button id="showData" class="d-none"
                                                        type="button"><?php echo e(__('Show Data')); ?></button>
                                                    <button id="clearFields" class="d-none"
                                                        type="button"><?php echo e(__('Clear All Fields')); ?></button>
                                                    <button id="getData" class="d-none"
                                                        type="button"><?php echo e(__('Get Data')); ?></button>
                                                    <button id="getXML" class="d-none"
                                                        type="button"><?php echo e(__('Get XML Data')); ?></button>
                                                    <button id="getJSON" class="btn btn-primary"
                                                        type="button"><?php echo e(__('Update')); ?></button>
                                                    <button id="getJSONs" class="d-none"
                                                        onClick="javascript:history.go(-1)"
                                                        type="button"><?php echo e(__('Back')); ?></button>
                                                    <button id="getJS" class="d-none"
                                                        type="button"><?php echo e(__('Get JS Data')); ?></button>
                                                    <button id="setData" class="d-none"
                                                        type="button"><?php echo e(__('Set Data')); ?></button>
                                                    <button id="addField" class="d-none"
                                                        type="button"><?php echo e(__('Add Field')); ?></button>
                                                    <button id="removeField" class="d-none"
                                                        type="button"><?php echo e(__('Remove Field')); ?></button>
                                                    <button id="testSubmit" class="d-none"
                                                        type="submit"><?php echo e(__('Test Submit')); ?></button>
                                                    <button id="resetDemo" class="d-none"
                                                        type="button"><?php echo e(__('Reset Demo')); ?></button>
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
    <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" />
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        var lang = '<?php echo e(app()->getLocale()); ?>';
        var lang_other = '<?php echo e(__('Other')); ?>';
        var lang_other_placeholder = '<?php echo e(__('Enter please')); ?>';
        var lang_Page = '<?php echo e(__('Page')); ?>';
        var lang_Custom_Autocomplete = '<?php echo e(__('Custom Autocomplete')); ?>';
    </script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="<?php echo e(asset('vendor/jqueryform/js/signaturePad.umd.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/jqueryform/js/vendor.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="<?php echo e(asset('vendor/jqueryform/js/form-builder.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/jqueryform/js/form-render.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/jqueryform/js/demoFirst.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/jqueryform/js/jquery.rateyo.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form-template/design.blade.php ENDPATH**/ ?>