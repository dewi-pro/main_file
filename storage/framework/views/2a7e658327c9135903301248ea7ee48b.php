<?php $__env->startSection('title', __('Create Form Template')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Create Form Template')); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Dashboard'), ['']); ?></li>
            <li class="breadcrumb-item"><?php echo Html::link(route('form-template.index'), __('Form Template'), ['']); ?></li>
            <li class="breadcrumb-item"><?php echo e(__('Create Form Template')); ?></li>
        </ul>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="section-body">
            <div class="m-auto col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5> <?php echo e(__('Create Form Template')); ?></h5>
                    </div>
                    <?php echo Form::open([
                        'route' => 'form-template.store',
                        'method' => 'Post',
                        'enctype' => 'multipart/form-data',
                        'data-validate',
                    ]); ?>

                    <div class="card-body">
                        <div class="form-group">
                            <?php echo e(Form::label('title', __('Title'), ['class' => 'form-label'])); ?>

                            <?php echo Form::text('title', null ,['class' => 'form-control', 'required', 'placeholder' => __('Enter title')]); ?>

                        </div>
                        <div class="form-group">
                            <?php echo e(Form::label('image', __('Image'), ['class' => 'form-label'])); ?>

                            <?php echo Form::file('image', ['class' => 'form-control', 'id' => 'image']); ?>

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

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/main_file/resources/views/form-template/create.blade.php ENDPATH**/ ?>