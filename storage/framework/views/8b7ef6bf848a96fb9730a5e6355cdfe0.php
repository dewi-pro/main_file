<?php $__env->startSection('title', __('Edit Form Template')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Edit Form Template')); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Dashboard'), ['']); ?></li>
            <li class="breadcrumb-item"><?php echo Html::link(route('form-template.index'), __('Form Template'), ['']); ?></li>
            <li class="breadcrumb-item"><?php echo e(__('Edit Testimonial')); ?></li>
        </ul>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="section-body">
            <div class="m-auto col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5> <?php echo e(__('Edit Form Template')); ?></h5>
                    </div>
                    <?php echo Form::model($formTemplate, [
                        'route' => ['form-template.update', $formTemplate->id],
                        'method' => 'patch',
                        'enctype' => 'multipart/form-data',
                        'data-validate',
                    ]); ?>

                    <?php echo method_field('put'); ?>
                    <div class="card-body">
                        <div class="form-group">
                            <?php echo e(Form::label('title', __('Title'), ['class' => 'form-label'])); ?>

                            <?php echo Form::text('title', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter title')]); ?>

                        </div>
                        <div class="form-group">
                            <?php echo e(Form::label('image', __('Image'), ['class' => 'form-label'])); ?>

                            <?php echo Form::file('image', ['class' => 'form-control', 'id' => 'image']); ?>

                            <?php if(isset($formTemplate->image)): ?>
                                <img src="<?php echo e(Storage::url($formTemplate->image)); ?>" width="100"
                                    height="100" class="mt-2">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="mb-3 btn-flt float-end">
                            <?php echo Html::link(route('form-template.index'), __('Cancel'), ['class' => 'btn btn-secondary']); ?>

                            <?php echo e(Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary'])); ?>

                        </div>
                    </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form-template/edit.blade.php ENDPATH**/ ?>