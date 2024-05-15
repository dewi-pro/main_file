<?php $__env->startSection('title', __('Create Announcement')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Create Announcement')); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Dashboard'), []); ?></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('announcement.index')); ?>"><?php echo e(__('Announcement')); ?></a></li>
            <li class="breadcrumb-item active"><?php echo e(__('Create Announcement')); ?></li>
        </ul>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-6 col-md-8 col-xxl-8 m-auto">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Create Announcement')); ?></h5>
                </div>
                <div class="card-body">
                    <?php echo Form::open([
                        'route' => 'announcement.store',
                        'method' => 'Post',
                        'class' => 'form-horizontal',
                        'enctype' => 'multipart/form-data',
                        'data-validate',
                    ]); ?>

                    <div class="row">
                        <div class="form-group col-6">
                            <?php echo e(Form::label('title', __('Title'), ['class' => 'form-label'])); ?>

                            <?php echo Form::text('title', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter title')]); ?>

                        </div>
                        <div class="form-group col-6">
                            <?php echo e(Form::label('image', __('Image'), ['class' => 'form-label'])); ?>

                            <?php echo Form::file('image', ['class' => 'form-control', 'required' => 'required']); ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo e(Form::label('description', __('Description'), ['class' => 'form-label'])); ?>

                        <?php echo Form::textarea('description', null, [
                            'class' => 'form-control',
                            'rows' => '3',
                            'required',
                            'placeholder' => __('Enter description'),
                        ]); ?>

                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <?php echo e(Form::label('start_date', __('Start Date'), ['class' => 'form-label'])); ?>

                            <?php echo Form::text('start_date', null, [
                                'class' => 'form-control',
                                'id' => 'datepicker-start-date',
                                'required',
                                'placeholder' => __('Start Date'),
                            ]); ?>

                        </div>
                        <div class="form-group col-6">
                            <?php echo e(Form::label('end_date', __('End Date'), ['class' => 'form-label'])); ?>

                            <?php echo Form::text('end_date', null, [
                                'class' => 'form-control',
                                'id' => 'datepicker-end-date',
                                'required',
                                'placeholder' => __('End Date'),
                            ]); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="share_with_public" class="form-check-input"
                                    id="share_with_public">
                                <?php echo e(Form::label('share_with_public', __('Share With Public'), ['class' => 'form-check-label'])); ?>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="show_landing_page_announcebar" class="form-check-input"
                                    id="show_landing_page_announcebar">
                                <?php echo e(Form::label('show_landing_page_announcebar', __('Show Landing Page Announcebar'), ['class' => 'form-check-label'])); ?>

                            </div>
                        </div>
                    </div>



                </div>
                <div class="card-footer">
                    <div class="float-end">
                        <a href="<?php echo e(route('announcement.index')); ?>" class="btn btn-secondary"><?php echo e(__('Cancel')); ?></a>
                        <?php echo e(Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary'])); ?>

                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/datepicker-bs5.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/datepicker-full.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/ckeditor/ckeditor.js')); ?>"></script>
    <script>
        CKEDITOR.replace('description', {
            filebrowserUploadUrl: "<?php echo e(route('ckeditor.upload', ['_token' => csrf_token()])); ?>",
            filebrowserUploadMethod: 'form'
        });
    </script>
    <script>
        (function() {
            const d_week = new Datepicker(document.querySelector('#datepicker-start-date'), {
                buttonClass: 'btn',
                format: 'dd/mm/yyyy'
            });
        })();
    </script>
    <script>
        (function() {
            const d_week = new Datepicker(document.querySelector('#datepicker-end-date'), {
                buttonClass: 'btn',
                format: 'dd/mm/yyyy'
            });
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/announcement/create.blade.php ENDPATH**/ ?>