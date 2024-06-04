<?php $__env->startSection('title', __('Dashboard Widgets')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Dashboard Widgets')); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Dashboard'), []); ?></li>
            <li class="breadcrumb-item active"><?php echo e(__('Dashboard Widgets')); ?></li>
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

    <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
    <script>
        $(function() {
            $('body').on('click', '.add_dashboard', function() {
                var modal = $('#common_modal');
                $.ajax({
                    type: "GET",
                    url: '<?php echo e(route('create.dashboard')); ?>',
                    data: {},
                    success: function(response) {
                        modal.find('.modal-title').html('<?php echo e(__('Create Dashboard Widget')); ?>');
                        modal.find('.body').html(response);
                        new Choices('#form_title', {
                            removeItemButton: true,
                        });
                        new Choices('#poll_title', {
                            removeItemButton: true,
                        });
                        new Choices('#size', {
                            removeItemButton: true,
                        });
                        new Choices('#type', {
                            removeItemButton: true,
                        });
                        new Choices('#chart_type', {
                            removeItemButton: true,
                        });
                        modal.modal('show');
                    },
                    error: function(error) {
                    }
                });
            });
            $('body').on('click', '#edit-dashboard', function() {
                var action = $(this).attr('data-url');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('<?php echo e(__('Edit Dashboard Widget')); ?>');
                    modal.find('.body').html(response);
                    new Choices('#form_title', {
                        removeItemButton: true,
                    });
                    new Choices('#poll_title', {
                        removeItemButton: true,
                    });
                    new Choices('#field_name', {
                        removeItemButton: true,
                    });
                    new Choices('#size', {
                        removeItemButton: true,
                    });
                    new Choices('#chart_type', {
                        removeItemButton: true,
                    });
                    modal.modal('show');
                })
            });
        });
        $(document).on("change", "#form_title", function() {
            var cate_id = $(this).val();
            $.ajax({
                url: '<?php echo e(route('widget.chnages')); ?>',
                type: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    widget: cate_id,
                },
                success: function(data) {
                    var toAppend = '';
                    $.each(data, function(i, o) {
                        toAppend += '<option value=' + o.name + '>' + o.label + '</option>';
                    });
                    $('.field_name').html(
                        '<select name="field_name" class="form-control" id="field_name" data-trigger>' +
                        toAppend +
                        '</select>');
                    new Choices('#field_name', {
                        removeItemButton: true,
                    });
                }
            })
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/main_file/resources/views/dashboard/index.blade.php ENDPATH**/ ?>