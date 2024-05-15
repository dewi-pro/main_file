<?php $__env->startSection('title', __('Landing Page')); ?>
<?php $__env->startSection('breadcrumb'); ?>
<div class="col-md-12">
    <div class="page-header-title">
        <h4 class="m-b-10"><?php echo e(__('App Settings')); ?></h4>
    </div>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><?php echo Html::link(route('home'),__('Dashboard'),['']); ?></li>
        <li class="breadcrumb-item"><?php echo e(__('App Settings')); ?></li>
    </ul>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <?php echo $__env->make('landing-page.landingpage-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="card">
                            <div class="tab-pane fade show active" id="apps-setting" role="tabpanel"
                                aria-labelledby="landing-apps-setting">
                                <?php echo Form::open([
                                    'route' => ['landing.app.store'],
                                    'method' => 'Post',
                                    'id' => 'froentend-form',
                                    'enctype' => 'multipart/form-data',
                                    'data-validate',
                                    'no-validate',
                                ]); ?>

                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <h5 class="mb-0"><?php echo e(__('App Setting')); ?></h5>
                                        </div>
                                        <div class="col-lg-4 d-flex justify-content-end">
                                            <div class="form-switch custom-switch-v1 d-inline-block">
                                                <?php echo Form::checkbox(
                                                    'apps_setting_enable',
                                                    null,
                                                    Utility::getsettings('apps_setting_enable') == 'on' ? true : false,
                                                    [
                                                        'class' => 'custom-control custom-switch form-check-input input-primary',
                                                        'id' => 'appsSettingEnableBtn',
                                                        'data-onstyle' => 'primary',
                                                        'data-toggle' => 'switchbutton',
                                                    ],
                                                ); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('apps_image', __('App Image'), ['class' => 'form-label'])); ?> *
                                                <?php echo Form::file('apps_image', ['class' => 'form-control', 'id' => 'apps_image']); ?>

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('apps_multiple_image', __('App Multiple Image'), ['class' => 'form-label'])); ?> *
                                                <?php echo Form::file('apps_multiple_image[]', ['class' => 'form-control', 'id' => 'apps_multiple_image', 'multiple']); ?>

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('apps_name', __('App Name'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('apps_name', Utility::getsettings('apps_name'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter app name'),
                                                ]); ?>

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('apps_bold_name', __('App Bold Name'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::text('apps_bold_name', Utility::getsettings('apps_bold_name'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter app bold name'),
                                                ]); ?>

                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <?php echo e(Form::label('app_detail', __('App Detail'), ['class' => 'form-label'])); ?>

                                                <?php echo Form::textarea('app_detail', Utility::getsettings('app_detail'), [
                                                    'class' => 'form-control',
                                                    'rows' => '3',
                                                    'placeholder' => __('Enter app detail'),
                                                ]); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-end">
                                        <?php echo e(Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary'])); ?>

                                    </div>
                                </div>
                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/landing-page/app-setting.blade.php ENDPATH**/ ?>