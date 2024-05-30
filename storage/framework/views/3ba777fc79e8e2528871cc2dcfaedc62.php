<?php $__env->startSection('title', __('Add Form')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Add Form')); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Dashboard'), ['']); ?></li>
            <li class="breadcrumb-item"><?php echo Html::link(route('forms.index'), __('Forms'), ['']); ?></li>
            <li class="breadcrumb-item"><?php echo e(__('Add Form')); ?></li>
        </ul>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-3 d-flex">
            <a class="btn-addnew-project h-100 w-100" href="<?php echo e(route('forms.create')); ?>">
                <div class="bg-primary add_user proj-add-icon">
                    <i class="ti ti-plus"></i>
                </div>
                <h6 class="mt-4 mb-2"><?php echo e(__('Start From Scratch')); ?></h6>
                <p class="text-center text-muted"><?php echo e(__('A blank slate is all you need')); ?></p>
            </a>
        </div>
        <?php $__currentLoopData = $formTemplates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formTemplate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-xl-3 d-flex">
                <div class="text-center text-white card h-100 w-100">
                    <div class="pb-0 border-0 card-header">
                        <div class="d-flex align-items-center">
                            <?php if($formTemplate->status == 1): ?>
                                <span class="p-2 px-3 badge rounded-pill bg-success"><?php echo e(__('Active')); ?></span>
                            <?php else: ?>
                                <span class="p-2 px-3 badge rounded-pill bg-danger"><?php echo e(__('Deactive')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <img src="<?php echo e(Storage::url($formTemplate->image)); ?>" alt="user-image" class="w-100">
                        <h4 class="mt-2 text-dark"><?php echo e($formTemplate->title); ?></h4>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo e(route('forms.use.template', $formTemplate->id)); ?>"
                            class="my-2 text-center btn btn-light-primary w-100"
                            role="button"><span><?php echo e(__('Use Template')); ?></span></a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form/add.blade.php ENDPATH**/ ?>