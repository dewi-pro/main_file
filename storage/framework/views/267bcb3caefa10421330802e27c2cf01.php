<?php $__env->startSection('title', __('Bookings')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Bookings')); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Dashboard'), ['']); ?></li>
            <li class="breadcrumb-item"><?php echo e(__('Bookings')); ?></li>
        </ul>
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

    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).data('url')).select();
            document.execCommand("copy");
            $temp.remove();
            show_toastr('Great!', '<?php echo e(__('Copy Link Successfully.')); ?>', 'success');
        }
        $(document).on('click', '#share-qr-code', function() {
            var action = $(this).data('share');
            var modal = $('#common_modal2');
            $.get(action, function(response) {
                modal.find('.modal-title').html('<?php echo e(__('QR Code')); ?>');
                modal.find('.modal-body').html(response.html);
                feather.replace();
                modal.modal('show');
            })
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/bookings/index.blade.php ENDPATH**/ ?>