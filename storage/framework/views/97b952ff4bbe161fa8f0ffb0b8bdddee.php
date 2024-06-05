<?php $__env->startSection('title', __('Users')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Users')); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Dashboard'), []); ?></li>
            <li class="breadcrumb-item active"><?php echo e(__('Users')); ?></li>
        </ul>
        <div class="float-end">
            <div class="d-flex align-items-center">
                <a href="<?php echo e(route('grid.view','view')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Grid View')); ?>"
                    class="btn btn-sm btn-primary" data-bs-placement="bottom">
                    <i class="ti ti-layout-grid"></i>
                </a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <?php echo e($dataTable->table(['width' => '100%'])); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
    <?php echo $__env->make('layouts.includes.datatable-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <?php echo $__env->make('layouts.includes.datatable-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo e($dataTable->scripts()); ?>

    <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
    <script>
        $(function() {
            $('body').on('click', '.add-user', function() {
                var modal = $('#common_modal');
                $.ajax({
                    type: "GET",
                    url: '<?php echo e(route('users.create')); ?>',
                    data: {},
                    success: function(response) {
                        modal.find('.modal-title').html('<?php echo e(__('Create User')); ?>');
                        modal.find('.body').html(response.html);
                        var multipleCancelButton = new Choices('#roles', {
                            removeItemButton: true,
                        });
                        var multipleCancelButton = new Choices('#country_code', {
                            removeItemButton: true,
                        });
                        modal.modal('show');
                    },
                    error: function(error) {}
                });
            });
            $('body').on('click', '#edit-user', function() {
                var action = $(this).attr('data-url');
                var modal = $('#common_modal');
                $.get(action, function(response) {

                    modal.find('.modal-title').html('<?php echo e(__('Edit User')); ?>');
                    modal.find('.body').html(response.html);
                    var multipleCancelButton = new Choices('#roles', {
                        removeItemButton: true,
                    });
                    var multipleCancelButton = new Choices('#country_code', {
                        removeItemButton: true,
                    });
                    modal.modal('show');
                })
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/users/index.blade.php ENDPATH**/ ?>