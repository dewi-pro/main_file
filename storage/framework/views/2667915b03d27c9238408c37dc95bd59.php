<?php $__env->startSection('title', __('Form Payment Integration')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="d-flex justify-content-between">
            <div class="previous-next-btn">
                <div class="page-header-title">
                    <h4 class="m-b-10"><?php echo e(__('Form Payment Integration')); ?></h4>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('forms.index')); ?>"><?php echo e(__('Forms')); ?></a></li>
                    <li class="breadcrumb-item"> <?php echo e(__('Form Payment Integration')); ?> </li>
                </ul>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="m-auto col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Payment Setting')); ?></h5>
                </div>
                <?php echo Form::open([
                    'route' => ['form.payment.integration.store', $form->id],
                    'method' => 'POST',
                    'data-validate',
                ]); ?>

                <div class="card-body">
                    <?php if($paymentType): ?>
                        <div class="row">
                            <div class="col-md-8">
                                <b>
                                    <?php echo e(Form::label('customswitchv1-1', __('Payment getway (active)'), ['class' => 'd-block '])); ?>

                                </b>
                            </div>
                            <div class="mb-3 col-md-4">
                                <div class="form-check form-switch custom-switch-v1 float-end">
                                    <?php echo Form::checkbox('payment', null, $form->payment_status == '1' ? true : false, [
                                        'id' => 'customswitchv1-1',
                                        'class' => 'form-check-input input-primary',
                                    ]); ?>

                                </div>
                            </div>
                            <div class="col-lg-12 paymenttype <?php echo e($form->payment_status == '1' ? 'd-block' : 'd-none'); ?>">
                                <div class="form-group">
                                    <?php echo e(Form::label('payment_type', __('Payment Type'), ['class' => 'form-label'])); ?>

                                    <?php echo Form::select('payment_type', $paymentType,  $form->payment_type, ['class' => 'form-control', 'data-trigger']); ?>

                                </div>
                                <div class="form-group">
                                    <?php echo e(Form::label('amount', __('Amount'), ['class' => 'form-label'])); ?>

                                    <?php echo Form::number('amount', $form->amount, [
                                        'id' => 'amount',
                                        'placeholder' => __('Enter amount'),
                                        'class' => 'form-control',
                                    ]); ?>

                                    <?php if($errors->has('amount')): ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($errors->first('amount')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <?php echo e(Form::label('currency_symbol', __('Currency symbol'), ['class' => 'form-label'])); ?>

                                    <?php echo Form::text('currency_symbol', $form->currency_symbol, [
                                        'id' => 'currency_symbol',
                                        'placeholder' => __('Enter currency symbol'),
                                        'class' => 'form-control',
                                    ]); ?>

                                    <?php if($errors->has('currency_symbol')): ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($errors->first('currency_symbol')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <?php echo e(Form::label('currency_name', __('Currency Name'), ['class' => 'form-label'])); ?>

                                    <?php echo Form::text('currency_name', $form->currency_name, [
                                        'id' => 'currency_name',
                                        'placeholder' => __('Enter currency name'),
                                        'class' => 'form-control',
                                    ]); ?>

                                    <?php if($errors->has('currency_name')): ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($errors->first('currency_name')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <div class="text-end">
                        <?php echo Html::link(route('forms.index'), __('Cancel'), ['class' => 'btn btn-secondary']); ?>

                        <?php echo Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']); ?>

                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        $(document).on('click', "#customswitchv1-1", function() {
            if (this.checked) {
                $(".paymenttype").fadeIn(500);
                $('.paymenttype').removeClass('d-none');
            } else {
                $(".paymenttype").fadeOut(500);
                $('.paymenttype').addClass('d-none');
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form/payment.blade.php ENDPATH**/ ?>