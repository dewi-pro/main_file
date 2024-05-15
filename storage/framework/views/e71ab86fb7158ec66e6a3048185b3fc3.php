<?php $__env->startSection('title', __('Statuses')); ?>
<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h4 class="m-b-10"><?php echo e(__('Form Statuses')); ?></h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">
                            <?php echo Html::link(route('home'), __('Dashboard'), ['']); ?>

                        </li>
                        <li class="breadcrumb-item active"><?php echo e(__('Form Statuses')); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
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
            $('body').on('click', '.form-status', function() {
                var modal = $('#common_modal');
                $.ajax({
                    type: "GET",
                    url: '<?php echo e(route('form-status.create')); ?>',
                    data: {},
                    success: function(response) {
                        modal.find('.modal-title').html('<?php echo e(__('Create Form Status')); ?>');
                        modal.find('.body').html(response.html);
                        modal.modal('show');
                        var colorSelect = document.getElementById('color');
                        var statusSelect = document.getElementById('status');

                        var colorChoices = new Choices(colorSelect, {
                            placeholder: true,
                            searchEnabled: true,
                            searchPlaceholderValue: 'Type to search'
                        });

                        var statusChoices = new Choices(statusSelect, {
                            placeholder: true,
                            searchEnabled: true,
                            searchPlaceholderValue: 'Type to search'
                        });

                        colorSelect.addEventListener('change', function(event) {
                            document.getElementById('color-hidden').value = event.target
                                .value;
                        });

                        statusSelect.addEventListener('change', function(event) {
                            document.getElementById('status-hidden').value = event
                                .target.value;
                        });
                    },
                    error: function(error) {}
                });
            });

            $(document).on('click', '#edit-form-status', function() {
                var action = $(this).data('url');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('<?php echo e(__('Edit Form Status')); ?>');
                    modal.find('.body').html(response.html);
                    modal.modal('show');
                    var colorSelect = document.getElementById('color');
                    var statusSelect = document.getElementById('status');

                    var colorChoices = new Choices(colorSelect, {
                        placeholder: true,
                        searchEnabled: true,
                        searchPlaceholderValue: 'Type to search'
                    });

                    var statusChoices = new Choices(statusSelect, {
                        placeholder: true,
                        searchEnabled: true,
                        searchPlaceholderValue: 'Type to search'
                    });

                    colorSelect.addEventListener('change', function(event) {
                        document.getElementById('color-hidden').value = event.target.value;
                    });

                    statusSelect.addEventListener('change', function(event) {
                        document.getElementById('status-hidden').value = event.target.value;
                    });
                })
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form-status/index.blade.php ENDPATH**/ ?>