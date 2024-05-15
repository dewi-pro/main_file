<?php $__env->startSection('title', __('Event')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Event')); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Dashboard'), ['']); ?></li>
            <li class="breadcrumb-item"><?php echo e(__('Event')); ?></li>
        </ul>
        <div class="mb-2 col-lg-12 text-end">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-event')): ?>
                <a href="javascript:void(0);" data-size="lg" data-bs-placement="bottom" id="EventCalender"
                    data-url="<?php echo e(route('event.create')); ?>" data-ajax-popup="true" data-kt-modal="true" data-bs-toggle="tooltip"
                    title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create New Event')); ?>" class="btn btn-sm btn-primary">
                    <i class="ti ti-plus"></i><span><?php echo e(__('Create Event')); ?></span>
                </a>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/main.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/datepicker-bs5.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php
    use App\Facades\UtilityFacades;
?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-lg-5">
                            <h5><?php echo e(__('Calendar')); ?></h5>
                        </div>
                        <div class="col-lg-7">
                            <div class="row">
                                <div class="col-lg-6">
                                    <?php if(Utility::getsettings('google_calendar_enable') && Utility::getsettings('google_calendar_enable') == 'on'): ?>
                                        <select class="form-control float-end" name="calenderType" id="calenderType"
                                            onchange="get_data()">
                                            <option value="google_calender"><?php echo e(__('Google Calender')); ?></option>
                                            <option value="local_calender" selected="true"><?php echo e(__('Local Calender')); ?>

                                            </option>
                                        </select>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="search_user" class="form-control search_user_event"
                                        value="" placeholder="Search User....">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id='calendar' class='calendar'></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-4"><?php echo e(__('Upcoming Events')); ?></h6>
                    <ul class="mt-3 event-cards list-group list-group-flush w-100">
                        <li class="mb-3 list-group-item card">
                            <div class="row align-items-center justify-content-between">
                                <div class="align-items-center">
                                    <?php if(!$events->isEmpty()): ?>
                                        <?php $__empty_1 = true; $__currentLoopData = $currentMonthEvent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <div class="mb-3 border shadow-none card">
                                                <div class="px-3">
                                                    <div class="row align-items-center">
                                                        <div class="col ml-n2">
                                                            <h5 class="mb-3 text-sm fc-event-title-container">
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-event')): ?>
                                                                <a href="javascript:void(0);" data-size="lg"
                                                                    data-url="<?php echo e(route('event.edit', $event->id)); ?>"
                                                                    data-ajax-popup="true" id="editEvent"
                                                                    data-title="<?php echo e(__('Edit Event')); ?>"
                                                                    class="fc-event-title text-primary">
                                                                    <?php echo e($event->title); ?>

                                                                </a>
                                                            <?php endif; ?>
                                                            </h5>
                                                            <p class="card-text small text-dark">
                                                                <?php echo e(__('Start Date : ')); ?>

                                                                <?php echo e(Utility::date_format($event->start_date)); ?><br>
                                                                <?php echo e(__('End Date : ')); ?>

                                                                <?php echo e(Utility::date_format($event->end_date)); ?>

                                                            </p>
                                                        </div>
                                                        <div class="col-auto text-right d-flex">
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-event')): ?>
                                                                <div class="action-btn bg-primary ms-2">
                                                                    <a class="rounded btn btn-sm small btn-primary edit_form cust_btn"
                                                                        data-url="<?php echo e(route('event.edit', $event->id)); ?>"
                                                                        href="javascript:void(0);" data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom" title=""
                                                                        data-bs-original-title="<?php echo e(__('Edit Form')); ?>"
                                                                        id="editEvent"><i class="ti ti-edit"></i></a>
                                                                </div>
                                                            <?php endif; ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-event')): ?>
                                                                <div class="action-btn bg-danger ms-2">
                                                                    <?php echo Form::open([
                                                                        'method' => 'DELETE',
                                                                        'route' => ['event.destroy', $event->id],
                                                                        'id' => 'delete-form-' . $event->id,
                                                                        'class' => 'd-inline',
                                                                    ]); ?>

                                                                    <a href="#"
                                                                        class="rounded btn btn-sm small btn-danger show_confirm"
                                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                        title=""
                                                                        data-bs-original-title="<?php echo e(__('Delete')); ?>"
                                                                        id="delete-form-<?php echo e($event->id); ?>"><i
                                                                            class="mr-0 ti ti-trash"></i></a>
                                                                    <?php echo Form::close(); ?>

                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="4">
                                                    <div class="text-center">
                                                        <h6><?php echo e(__('There is no event in this month')); ?></h6>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="text-center">

                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/main.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/datepicker-full.min.js')); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            get_data();
        });
        function get_data(user = '') {
            console.log(user);
            var calenderType = $('#calenderType :selected').val();
            var data = $('input[name="search_user"]').val();
            $('#calendar').removeClass('local_calender');
            $('#calendar').removeClass('google_calender');
            if (calenderType == undefined) {
                calenderType = 'local_calender';
            }
            $('#calendar').addClass(calenderType);
            $.ajax({
                url: '<?php echo e(route('event.get.data')); ?>',
                method: "POST",
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                    'calenderType': calenderType,
                    'user': user
                },
                success: function(data) {
                    (function() {
                        var etitle;
                        var etype;
                        var etypeclass;
                        var calendarElement = document.getElementById('calendar');
                        if (calendarElement.fullCalendar) {
                            calendarElement.fullCalendar.destroy();
                        }
                        var calendar = new FullCalendar.Calendar(calendarElement, {
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                            },
                            select: function(date) {
                                var url = $('#EventCalender').attr('data-url');
                                var start = date.startStr;
                                var end = date.endStr;
                                $.ajax({
                                    type: 'GET',
                                    url: url,
                                    data: {
                                        start_date: start,
                                        end_date: end
                                    },
                                    success: function(response) {
                                        $("#common_modal .modal-title").html(
                                            '<?php echo e(__('Create Event')); ?>');
                                        $("#common_modal .body").html(response);
                                        if ($('#user').length) {
                                            var multipleCancelButton = new Choices(
                                                '#user', {
                                                    removeItemButton: true,
                                                });
                                        }
                                        const start_date = new Datepicker(document
                                            .querySelector(
                                                '#start_date'), {
                                                buttonClass: 'btn',
                                                format: 'dd/mm/yyyy'
                                            });
                                        const end_date = new Datepicker(document
                                            .querySelector(
                                                '#end_date'), {
                                                buttonClass: 'btn',
                                                format: 'dd/mm/yyyy'
                                            });
                                        $("#common_modal").modal('show');
                                    },
                                    error: function(response) {}
                                });
                            },
                            buttonText: {
                                timeGridDay: "<?php echo e(__('Day')); ?>",
                                timeGridWeek: "<?php echo e(__('Week')); ?>",
                                dayGridMonth: "<?php echo e(__('Month')); ?>"
                            },
                            themeSystem: 'bootstrap',
                            slotDuration: '00:10:00',
                            navLinks: true,
                            droppable: true,
                            selectable: true,
                            selectMirror: true,
                            editable: true,
                            dayMaxEvents: true,
                            handleWindowResize: true,
                            events: data,
                        });
                        calendar.render();
                    })();
                }
            });
        }

        $(document).on('click', '#EventCalender', function() {
            var url = $(this).attr('data-url');
            $.ajax({
                type: 'GET',
                url: url,
                data: {},
                success: function(response) {
                    $("#common_modal .modal-title").html('<?php echo e(__('Create Event')); ?>');
                    $("#common_modal .body").html(response);
                    if ($('#user').length) {
                        var multipleCancelButton = new Choices(
                            '#user', {
                                removeItemButton: true,
                            });
                    }
                    const start_date = new Datepicker(document
                        .querySelector(
                            '#start_date'), {
                            buttonClass: 'btn',
                            format: 'dd/mm/yyyy'
                        });
                    const end_date = new Datepicker(document
                        .querySelector(
                            '#end_date'), {
                            buttonClass: 'btn',
                            format: 'dd/mm/yyyy'
                        });
                    $("#common_modal").modal('show');
                },
                error: function(response) {}
            });
        });

        $(document).on('click', '#editEvent,.event-edit', function(e) {
            e.preventDefault();
            if ($(this).attr('data-url')) {
                var url = $(this).attr('data-url');
            } else {
                var url = $(this).attr('href');
            }
            $.ajax({
                type: 'GET',
                url: url,
                data: {},
                success: function(response) {
                    $("#common_modal .modal-title").html('<?php echo e(__('Edit Event')); ?>');
                    $("#common_modal .body").html(response);
                    var startDate = $("#common_modal .body").find('input[name="start_date"]').val();
                    var endDate = $("#common_modal .body").find('input[name="end_date"]').val();
                    if ($('#user').length) {
                        var multipleCancelButton = new Choices('#user', {
                            removeItemButton: true,
                        });
                    }
                    const start_date = new Datepicker(document
                        .querySelector(
                            '#start_date'), {
                            buttonClass: 'btn',
                            format: 'dd/mm/yyyy'
                        });
                    const end_date = new Datepicker(document
                        .querySelector(
                            '#end_date'), {
                            buttonClass: 'btn',
                            format: 'dd/mm/yyyy'
                        });
                    $("#common_modal").modal('show');
                },
                error: function(response) {}
            });
        });


        $(document).on('keyup', '.search_user_event', function() {
            var user = $('input[name="search_user"]').val();
            get_data(user);
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/dewi/Downloads/primelaravel-304/codecanyon-33546000-prime-laravel-form-builder-form-builder-users-role-permissions-settings/main_file/resources/views/event/index.blade.php ENDPATH**/ ?>