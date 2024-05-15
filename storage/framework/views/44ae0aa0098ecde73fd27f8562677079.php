<?php $__env->startSection('title', __('Create Booking')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Create Booking')); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Dashboard'), ['']); ?></li>
            <li class="breadcrumb-item"><?php echo Html::link(route('bookings.index'), __('Booking'), ['']); ?></li>
            <li class="breadcrumb-item"><?php echo e(__('Create Booking')); ?></li>
        </ul>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="section-body">
            <div class="m-auto col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5> <?php echo e(__('Create Booking')); ?></h5>
                    </div>
                    <?php echo Form::open([
                        'route' => 'bookings.store',
                        'method' => 'POST',
                        'enctype' => 'multipart/form-data',
                        'data-validate',
                    ]); ?>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('business_name', __('Business Name'), ['class' => 'form-label'])); ?>

                                    <?php echo Form::text('business_name', null, [
                                        'class' => 'form-control',
                                        'required',
                                        'placeholder' => __('Enter business name'),
                                    ]); ?>

                                </div>
                                <div class="form-group">
                                    <?php echo e(Form::label('business_email', __('Business Email'), ['class' => 'form-label'])); ?>

                                    <?php echo Form::text('business_email', null, [
                                        'class' => 'form-control',
                                        'required',
                                        'placeholder' => __('Enter business email'),
                                    ]); ?>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('business_logo', __('Business Logo'), ['class' => 'form-label'])); ?>

                                    <?php echo Form::file('business_logo', ['class' => 'form-control', 'required', 'id' => 'business_logo']); ?>

                                </div>
                                <div class="form-group">
                                    <?php echo e(Form::label('business_website', __('Business Website URL'), ['class' => 'form-label'])); ?>

                                    <?php echo Form::text('business_website', null, [
                                        'class' => 'form-control',
                                        'required',
                                        'placeholder' => __('Enter business website url'),
                                    ]); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('business_address', __('Business Address'), ['class' => 'form-label'])); ?>

                                    <?php echo Form::textarea('business_address', null, [
                                        'class' => 'form-control',
                                        'required',
                                        'rows' => 3,
                                        'placeholder' => __('Enter business address'),
                                    ]); ?>

                                </div>
                                <div class="form-group">
                                    <?php echo e(Form::label('business_number', __('Business Number'), ['class' => 'form-label'])); ?>

                                    <?php echo Form::number('business_number', null, [
                                        'class' => 'form-control',
                                        'required',
                                        'placeholder' => __('Enter business number'),
                                    ]); ?>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('business_phone', __('Business Phone'), ['class' => 'form-label'])); ?>

                                    <input class="form-control" required placeholder="<?php echo e(__('Enter business phone')); ?>"
                                        name="business_phone" type="tel" id="business_phone">
                                </div>
                                <div class="form-group">
                                    <?php echo e(Form::label('booking_slots', __('Booking Slots'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::select('booking_slots', $bookingSlots, null, ['class' => 'form-select', 'required', 'data-trigger'])); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="mb-3 btn-flt float-end">
                            <?php echo Html::link(route('bookings.index'), __('Cancel'), ['class' => 'btn btn-secondary']); ?>

                            <?php echo e(Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary'])); ?>

                        </div>
                    </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
    <script>
        var genericExamples = document.querySelectorAll('[data-trigger]');
        for (i = 0; i < genericExamples.length; ++i) {
            var element = genericExamples[i];
            new Choices(element, {
                placeholderValue: 'This is a placeholder set in the config',
                searchPlaceholderValue: 'This is a search placeholder',
            });
        }
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/bookings/create.blade.php ENDPATH**/ ?>