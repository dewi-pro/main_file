<?php $__env->startSection('title', __('Forms')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Forms')); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Dashboard'), []); ?></li>
            <li class="breadcrumb-item active"> <?php echo e(__('Forms')); ?> </li>
        </ul>
        <div class="float-end d-flex align-items-center">
            <div class="me-2">
                <button class="btn btn-primary btn-sm" id="filter_btn" data-bs-toggle="tooltip" title="<?php echo e(__('Filter')); ?>"
                    data-bs-placement="bottom"><i class="fas fa-filter"></i></button>
            </div>
            <div>
                <div class="d-flex align-items-center">
                    <a href="<?php echo e(route('grid.form.view', 'view')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Grid View')); ?>"
                        class="btn btn-sm btn-primary" data-bs-placement="bottom">
                        <i class="ti ti-layout-grid"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="filter" style="display:none">
        <div class="card mt-3 mb-0">
            <div class="card-header">
                <h5><?php echo e(__('Filter')); ?></h5>
            </div>
            <div class="card-body">
                <div class="row align-items-end filters">
                    <div class="col-md-4 col-sm-12 form-group">
                        <?php echo e(Form::label('created_at', __('date'), ['class' => 'form-label'])); ?>

                        <?php echo Form::text('filterdate', null, [
                            'id' => 'filterdate',
                            'class' => 'form-control created_at',
                            'placeholder' => 'Select date',
                        ]); ?>

                    </div>
                    <div class="col-md-4 col-sm-12 form-group">
                        <?php echo e(Form::label('category', __('Category'), ['class' => 'form-label'])); ?>

                        <?php echo Form::select('category[]', $categories, null, [
                            'class' => 'form-control category',
                            'id' => 'choices-multiple-remove-button',
                            'multiple' => 'multiple',
                            'data-trigger',
                        ]); ?>

                    </div>
                    <div class="col-md-4 col-sm-12 form-group">
                        <?php echo e(Form::label('roles', __('Roles'), ['class' => 'form-label'])); ?>

                        <select name="roles" id="role" class='form-control roles' data-trigger>
                            <option value="" selected><?php echo e(__('Select Role')); ?></option>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>"><?php echo e($role); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer ms-auto">
                <?php echo Form::button(__('Apply'), ['id' => 'applyfilter', 'class' => 'btn btn-primary']); ?>

                <?php echo Form::button(__('Clear'), ['id' => 'clearfilter', 'class' => 'btn btn-secondary']); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-bottom justify-content-between">
                    <div class="row justify-content-between">
                        <div class="col-12">
                            <ul class="nav nav-pills mb-2" id="pills-tab" role="tablist">
                                <?php
                                    $view = request()->query->get('view');
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link   <?php echo e($view != 'trash' ? 'active' : ''); ?>"
                                        href="<?php echo e(route('forms.index')); ?>"><?php echo e(__('All')); ?> <span
                                            class="badge ms-1 <?php echo e(isset($view) ? 'bg-primary text-light' : 'bg-light text-primary'); ?>"><?php echo e(isset($form) ? $form : 0); ?></span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e($view == 'trash' ? 'active' : ''); ?>"
                                        href="<?php echo e(route('forms.index', 'view=trash')); ?>"><?php echo e(__('Trash')); ?>

                                        <span
                                            class="badge ms-1 <?php echo e(isset($view) ? 'bg-light text-primary' : 'bg-primary text-light'); ?>"><?php echo e(isset($trashForm) ? $trashForm : 0); ?></span></a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <select class="form-select  selectric mb-1" data-trigger>
                                <option value=""><?php echo e(__('Action For Selected')); ?></option>
                                <?php
                                    $view = request()->query->get('view');
                                    if ($view !== null && $view == 'trash') {
                                        echo '<option value="restore">' . __('Restore Back') . '</option>';
                                    } else {
                                        echo '<option value="trash" class="show_confirm_submited_form_delete">' .
                                            __('Move to Trash') .
                                            '</option>';
                                    }
                                ?>
                                <option value="delete"><?php echo e(__('Delete Permanently')); ?></option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-3 text-end">
                            <?php if($view !== null && $view == 'trash'): ?>
                                <a class="deleteAll btn btn-danger btn-lg text-white" tabindex="0" aria-controls="user-table"
                                    type="button"><span><i
                                            class="fa fa-trash me-1 text-md"></i><?php echo e(__('Empty Trash')); ?></span></a>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
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
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendor/daterangepicker/daterangepicker.css')); ?>" />
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <?php echo $__env->make('layouts.includes.datatable-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="<?php echo e(asset('assets/js/plugins/flatpickr.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/daterangepicker/daterangepicker.min.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>

    <?php echo e($dataTable->scripts()); ?>

    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).attr('data-url')).select();
            document.execCommand("copy");
            $temp.remove();
            show_toastr('Great!', '<?php echo e(__('Copy Link Successfully.')); ?>', 'success',
                '<?php echo e(asset('assets/images/notification/ok-48.png')); ?>', 4000);
        }
        $(function() {
            $('body').on('click', '#share-qr-code', function() {
                var action = $(this).data('share');
                var modal = $('#common_modal2');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('<?php echo e(__('QR Code')); ?>');
                    modal.find('.modal-body').html(response.html);
                    feather.replace();
                    modal.modal('show');
                })
            });
        });


        $(document).on('click', "#filter_btn", function() {
            $("#filter").toggle("slow")
        });

        document.querySelector("#filterdate").flatpickr({
            mode: "range"
        });

        var multipleCancelButton = new Choices(
            '#choices-multiple-remove-button', {
                removeItemButton: true,
            }
        );
        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'This is a placeholder set in the config',
                    searchPlaceholderValue: 'This is a search placeholder',
                });
            }
        });

        $(document).ready(function() {

            $(document).on('change', 'input[name="checkbox-all"]', function() {
                var isChecked = $(this).prop('checked');
                $('.selected-checkbox').prop('checked', isChecked).trigger('change');
            });

            $(document).on('change', '.selectric', function(e) {
                var selected = [],
                    action = $(this).val();
                if (action != '') {
                    $('input.dt-checkboxes:checked').each(function() {
                        selected.push($(this).data('id'));
                    });
                    if (action == 'trash' && selected.length > 0) {
                        var url = '<?php echo e(route('form.destroy.multiple')); ?>';
                        var text =
                            "If you trash this form, all the submitted forms will also be trashed. Do you want to continue?";
                    } else if (action == 'delete' && selected.length > 0) {
                        <?php
                            $view = request()->query->get('view');
                            if ($view !== null && $view == 'trash') {
                                $url = route('form.force.delete.Multiple', 'view=trash');
                            } else {
                                $url = route('form.force.delete.Multiple');
                            }
                        ?>
                        var url = '<?php echo e($url); ?>';
                        var text =
                            "If you delete permanently this form, all the submitted forms will also be Delete Permanently. Do you want to continue?";
                    } else if (action == 'restore' && selected.length > 0) {
                        var url = '<?php echo e(route('form.restore.multiple')); ?>';
                        var text =
                            "If you restore this form, all the submitted forms will also be restore. Do you want to continue?"
                    } else {
                        show_toastr('error', '<?php echo e(__('Please select any one form')); ?>', {
                            closeButton: true,
                            tapToDismiss: false
                        });
                        return;

                    }
                    if (selected.length > 0) {
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success',
                                cancelButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                        })
                        swalWithBootstrapButtons.fire({
                            title: 'Are you sure?',
                            text: text,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "POST",
                                    url: url,
                                    data: {
                                        '_token': '<?php echo e(csrf_token()); ?>',
                                        'ids': selected
                                    },
                                    success: function(response) {
                                        show_toastr('Success!', response.msg,
                                            'success');
                                        window.location.reload();
                                    }
                                })
                            } else {
                                $(this).val('').trigger('change');
                            }
                        })
                    }
                }
            });

            $(document).on('click', '.deleteAll', function(e) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "If you delete this form, all the submitted forms will also be deleted. Do you want to continue?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: '<?php echo e(route('form.force.delete.all')); ?>',
                            data: {
                                '_token': '<?php echo e(csrf_token()); ?>'
                            },
                            success: function(response) {
                                show_toastr('Success!', response.msg,
                                    'success');
                                window.location.reload();
                            }
                        });
                    }
                });
            });

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/form/index.blade.php ENDPATH**/ ?>