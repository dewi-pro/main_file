<?php
    $user_theme = \Auth::user();
    $color = $user_theme->theme_color;
    $chatcolor = '#145388';
    if ($color == 'theme-1') {
        $chatcolor = '#0CAF60';
    } elseif ($color == 'theme-2') {
        $chatcolor = '#584ED2';
    } elseif ($color == 'theme-3') {
        $chatcolor = '#6FD943';
    } elseif ($color == 'theme-4') {
        $chatcolor = '#145388';
    } elseif ($color == 'theme-5') {
        $chatcolor = '#B9406B';
    } elseif ($color == 'theme-6') {
        $chatcolor = '#008ECC';
    } elseif ($color == 'theme-7') {
        $chatcolor = '#922C88';
    } elseif ($color == 'theme-8') {
        $chatcolor = '#C0A145';
    } elseif ($color == 'theme-9') {
        $chatcolor = '#48494B';
    } elseif ($color == 'theme-10') {
        $chatcolor = '#0C7785';
    }
?>

<?php $__env->startSection('title', __('Dashboard')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Dashboard')); ?></h4>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12 d-flex">
            <div class="mb-3 row">
                <div class="mb-3 col-xxl-7">
                    <div class="row h-100">
                        <?php if(\Auth::user()->can('manage-user')): ?>
                            <div class="col-lg-3 col-6 card-event">
                                <a href="users">
                                    <div class="card comp-card number-card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-12 m-b-20">
                                                    <i class="text-white ti ti-users bg-primary"></i>
                                                </div>
                                                <div class="col-12">
                                                    <h6 class="m-b-20 text-muted"><?php echo e(__('Total User')); ?></h6>
                                                    <h3 class="text-primary"><?php echo e(isset($user) ? $user : 0); ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if(\Auth::user()->can('manage-form')): ?>
                            <div class="col-lg-3 col-6 card-event">
                                <a href="forms">
                                    <div class="card comp-card number-card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-12 m-b-20">
                                                    <i class="text-white ti ti-file-text bg-success"></i>
                                                </div>
                                                <div class="col-12">
                                                    <h6 class="m-b-20 text-muted"><?php echo e(__('Total Form')); ?></h6>
                                                    <h3 class="text-success"><?php echo e(isset($forms) ? $forms : 0); ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if(\Auth::user()->can('manage-submitted-form')): ?>
                            <div class="col-lg-3 col-6 card-event">
                                    <div class="card comp-card number-card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-12 m-b-20">
                                                    <i class="text-white ti ti-ad-2 bg-danger"></i>
                                                </div>
                                                <div class="col-12">
                                                    <h6 class="m-b-20 text-muted"><?php echo e(__('Total Submited Form')); ?></h6>
                                                    <h3 class="text-danger">
                                                        <?php echo e(isset($submittedForm) ? $submittedForm : 0); ?>

                                                    </h3>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                            </div>
                        <?php endif; ?>
                        <!-- <?php if(\Auth::user()->can('manage-poll')): ?>
                            <div class="col-lg-3 col-6 card-event">
                                <a href="poll">
                                    <div class="card comp-card number-card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-12 m-b-20">
                                                    <i class="text-white ti ti-ad-2 bg-info"></i>
                                                </div>
                                                <div class="col-12">
                                                    <h6 class="m-b-20 text-muted"><?php echo e(__('Total Poll')); ?></h6>
                                                    <h3 class="text-info"><?php echo e(isset($poll) ? $poll : 0); ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?> -->
                    </div>
                </div>
                <div class="mb-3 col-xxl-5">
                    <div class="row">
                        <?php if(\Auth::user()->can('dashboard-qrcode-form')): ?>
                            <div class="col-lg-4 col-sm-6 col-12 dash-card-responsive">
                                <div class="m-0 card comp-card h-100">
                                    <div class="card-body qr-card-body">
                                        <div class="row">
                                            <div class="text-center col-12">
                                                <h6 class="mt-1 text-muted"><?php echo e(__('Forms')); ?></h6>
                                                <div class="mt-3 text-center">
                                                    <?php
                                                        $hashids = new Hashids('', 20);
                                                        $id = $hashids->encodeHex(Auth::user()->id);
                                                    ?>
                                                    <?php echo QrCode::size(100)->generate(route('users.all.formsSurvey', $id)); ?>

                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <a class="copy_form dash-btn btn btn-default btn-light-primary"
                                                    onclick="copyToClipboard('#copy-form-<?php echo e($id); ?>')"
                                                    href="javascript:void(0)" id="copy-form-<?php echo e($id); ?>"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-original-title="<?php echo e(__('Click to copy link')); ?>"
                                                    data-url="<?php echo e(route('users.all.formsSurvey', $id)); ?>"><i
                                                        class="ti ti-copy"></i><?php echo e(__('Copy Link')); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-lg-8 col-sm-6 col-12 dash-card-responsive">
                            <div class="m-0 card comp-card">
                                <div class="card-body admin-wish-card">
                                    <div class="row h-100">
                                        <div class="col-xxl-12">
                                            <div class="row">
                                                <h4 id="wishing"><?php echo e('Good morning ,'); ?></h4>
                                            </div>
                                        </div>
                                        <h4 class="f-w-400">
                                            <a href="<?php echo e(Storage::exists(Auth::user()->avatar) ? Storage::url(Auth::user()->avatar) : Auth::user()->avatar_image); ?>" target="_new">
                                                <img src="<?php echo e(asset('vendor/avatar_image/avatar.png')); ?>"
                                                    class="me-2 img-thumbnail rounded-circle" width="50px"
                                                    height="50px"></a>
                                            <span class="text-muted"><?php echo e(Auth::user()->name); ?></span>
                                        </h4>
                                        <p>
                                            <!-- <?php echo e(__('Have a nice day! you can quickly add your forms or polls Chart ')); ?> -->
                                        </p>
                                        <div class="dropdown quick-add-btn">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['create-form'])): ?>

                                            <!-- , 'create-poll', 'create-event' -->

                                                <a class="btn-q-add dropdown-toggle dash-btn btn btn-default btn-light-primary"
                                                    data-bs-toggle="dropdown" href="#" role="button"
                                                    aria-haspopup="false" aria-expanded="false">
                                                    <i class="ti ti-plus drp-icon"></i>
                                                    <span class="ms-1"><?php echo e(__('Quick add')); ?></span>
                                                </a>
                                            <?php endif; ?>
                                            <div class="dropdown-menu">
                                                <?php if(\Auth::user()->can('create-form')): ?>
                                                    <a href="<?php echo e(route('forms.create')); ?>" data-size="lg" data-url=""
                                                        data-ajax-popup="true" data-title="Add Product"
                                                        class="dropdown-item"
                                                        data-bs-placement="top "><span><?php echo e(__('Add New Form')); ?></span></a>
                                                <?php endif; ?>
                                                <!-- <?php if(\Auth::user()->can('create-poll')): ?>
                                                    <a href="<?php echo e(route('poll.create')); ?>" data-size="md"
                                                        data-ajax-popup="true" data-title="Create Tax"
                                                        class="dropdown-item"
                                                        data-bs-placement="top "><span><?php echo e(__('Add New Poll')); ?></span></a>
                                                <?php endif; ?>
                                                <?php if(\Auth::user()->can('create-event')): ?>
                                                    <a href="javascript:void(0);" data-size="md"
                                                        data-url="<?php echo e(route('event.create')); ?>" id="EventCalender"
                                                        data-ajax-popup="true" data-kt-modal="true"
                                                        data-title="Create Tax" class="dropdown-item"
                                                        data-bs-placement="top "><span><?php echo e(__('Add New Event')); ?></span></a>
                                                <?php endif; ?> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <section id="draggable-cards">
            <div class="row" id="widget-drag-area">
                <?php if(isset($widgets)): ?>
                    <?php $__currentLoopData = $widgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($widget->size == '25.00'): ?>
                            <div class="col-md-6 col-xl-3 widget-responsive sortable" data-id="<?php echo e($widget->id); ?>">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <?php echo e($widget->title); ?>

                                            <div class="float-end">
                                                <button type="button"class="btn btn-md" data-bs-original-title="Move"
                                                    data-bs-toggle="tooltip" data-title="Move">
                                                    <i class="fa fa-arrows-alt handle"></i>
                                                </button>
                                            </div>
                                        </h5>
                                    </div>
                                    <div class="widgetnew" id="<?php echo e($widget->id); ?>">
                                    </div>
                                    <div class="card-body">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-md-12" id="chart<?php echo e($widget->id); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php elseif($widget->size == '33.00'): ?>
                            <div class="col-md-6 col-xl-4 widget-responsive sortable" data-id="<?php echo e($widget->id); ?>">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <?php echo e($widget->title); ?>

                                            <div class="float-end">
                                                <button type="button"class="btn btn-md" data-bs-original-title="Move"
                                                    data-bs-toggle="tooltip" data-title="Move">
                                                    <i class="fa fa-arrows-alt handle"></i>
                                                </button>
                                            </div>
                                        </h5>
                                    </div>
                                    <div class="widgetnew" id="<?php echo e($widget->id); ?>">
                                    </div>
                                    <div class="card-body">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-md-12" id="chart<?php echo e($widget->id); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php elseif($widget->size == '50.00'): ?>
                            <div class="col-md-6 col-xl-6 sortable widget-responsive" data-id="<?php echo e($widget->id); ?>">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <?php echo e($widget->title); ?>

                                            <div class="float-end">
                                                <button type="button"class="btn btn-md" data-bs-original-title="Move"
                                                    data-bs-toggle="tooltip" data-title="Move">
                                                    <i class="fa fa-arrows-alt handle"></i>
                                                </button>
                                            </div>
                                        </h5>
                                    </div>
                                    <div class="widgetnew" id="<?php echo e($widget->id); ?>">
                                    </div>
                                    <div class="card-body">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-md-12" id="chart<?php echo e($widget->id); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="col-md-6 col-xl-12 sortable" data-id="<?php echo e($widget->id); ?>">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <?php echo e($widget->title); ?>

                                            <div class="float-end">
                                                <button type="button"class="btn btn-md" data-bs-original-title="Move"
                                                    data-bs-toggle="tooltip" data-title="Move">
                                                    <i class="fa fa-arrows-alt handle"></i>
                                                </button>
                                            </div>
                                        </h5>
                                    </div>
                                    <div class="widgetnew" id="<?php echo e($widget->id); ?>">
                                    </div>
                                    <div class="card-body">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-md-12" id="chart<?php echo e($widget->id); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendor/dragdrop/dragula.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/datepicker-bs5.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('vendor/apex-chart/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/dragdrop/dragula.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/datepicker-full.min.js')); ?>"></script>
    <script>
        var colors = '<?php echo $chatcolor; ?>';
        var widgetnew = $('.widgetnew').map((_, el) => el.id).get();
        widgetnew.forEach(function(val) {
            var cate_id = (val);
            $.ajax({
                url: '<?php echo e(route('widget.chartdata')); ?>',
                type: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    widget: cate_id,
                },
                success: function(data) {
                    type = data.type;
                    if (type == "form") {
                        var k = [];
                        var v = [];
                        var w = 0;
                        $.each(data, function(response, dt) {
                            $.each(dt.options, function(key, value) {
                                k += key + ",";
                                v += value + ',';
                                w += 1;
                            });
                        });
                        k = k.slice(0, -1);
                        v = v.slice(0, -1);
                        w = w * 7;
                        chart = data.chart_type;
                        if (chart == "bar") {
                            var options = {
                                chart: {
                                    type: 'bar',
                                    toolbar: {
                                        show: false
                                    }
                                },
                                title: {
                                    text: data.label,
                                    fontSize: 24
                                },
                                plotOptions: {
                                    bar: {
                                        columnWidth: w + '%',
                                        borderRadius: 5,
                                        dataLabels: {
                                            position: 'top',
                                        },
                                    }
                                },
                                colors: colors,
                                dataLabels: {
                                    enabled: false,
                                },
                                stroke: {
                                    show: true,
                                    width: 1,
                                    colors: ['#fff']
                                },
                                grid: {
                                    strokeDashArray: 4,
                                },
                                series: [{
                                    name: data.label,
                                    data: v.split(',').map(x => {
                                        return parseInt(x)
                                    })
                                }],
                                xaxis: {
                                    categories: k.split(',')
                                },
                            };
                        } else {
                            var options = {
                                series: v.split(',').map(x => {
                                    return parseInt(x)
                                }),
                                chart: {
                                    width: '100%',
                                    type: 'donut',
                                },
                                plotOptions: {
                                    pie: {
                                        startAngle: -90,
                                        endAngle: 270
                                    }
                                },
                                labels: k.split(','),
                                dataLabels: {
                                    enabled: false
                                },
                                fill: {
                                    type: 'gradient',
                                },
                                legend: {
                                    formatter: function(val, opts) {
                                        return val + " - " + opts.w.globals.series[opts
                                            .seriesIndex]
                                    }
                                },
                                title: {
                                    text: data.label,
                                },
                                responsive: [{
                                    breakpoint: 480,
                                    options: {
                                        chart: {
                                            width: '100%'
                                        },
                                        legend: {
                                            position: 'bottom'
                                        }
                                    }
                                }]
                            };
                        }
                        var chart = new ApexCharts(document.querySelector("#chart" + data.id), options);
                        chart.render();
                    } else {
                        var k = [];
                        var v = [];
                        var w = 0;
                        $.each(data.options, function(key, val) {
                            k += key + ",";
                            v += val + ',';
                            w += 1;
                        });
                        w = w * 7;
                        k = k.slice(0, -1);
                        v = v.slice(0, -1);
                        chart = data.chart_type;
                        if (chart == "bar") {
                            var options = {
                                chart: {
                                    type: 'bar',
                                    toolbar: {
                                        show: false
                                    }
                                },
                                title: {
                                    text: data.label,
                                    fontSize: 24
                                },
                                plotOptions: {
                                    bar: {
                                        columnWidth: w + '%',
                                        borderRadius: 5,
                                        dataLabels: {
                                            position: 'top',
                                        },
                                    }
                                },
                                colors: colors,
                                dataLabels: {
                                    enabled: false,
                                },
                                stroke: {
                                    show: true,
                                    width: 1,
                                    colors: ['#fff']
                                },
                                grid: {
                                    strokeDashArray: 4,
                                },
                                series: [{
                                    name: data.label,
                                    data: v.split(',').map(x => {
                                        return parseInt(x)
                                    })
                                }],
                                xaxis: {
                                    categories: k.split(',')
                                },
                            };
                        } else {
                            var options = {
                                series: v.split(',').map(x => {
                                    return parseInt(x)
                                }),
                                chart: {
                                    width: '100%',
                                    type: 'donut',
                                },
                                plotOptions: {
                                    pie: {
                                        startAngle: -90,
                                        endAngle: 270
                                    }
                                },
                                labels: k.split(','),
                                dataLabels: {
                                    enabled: false
                                },
                                fill: {
                                    type: 'gradient',
                                },
                                legend: {
                                    formatter: function(val, opts) {
                                        return val + " - " + opts.w.globals.series[opts
                                            .seriesIndex]
                                    }
                                },
                                title: {
                                    text: data.label,
                                },
                                responsive: [{
                                    breakpoint: 480,
                                    options: {
                                        chart: {
                                            width: '100%'
                                        },
                                        legend: {
                                            position: 'bottom'
                                        }
                                    }
                                }]
                            };
                        }
                        var chart = new ApexCharts(document.querySelector("#chart" + data.id), options);
                        chart.render();
                    }
                }
            })
        });
    </script>
    <script>
        $(function() {
            dragula([document.getElementById('widget-drag-area')], {
                moves: function(el, container, handle) {
                    return handle.classList.contains('handle');
                }
            }).on('drop', function(el, t) {
                var position = [];
                $(t).find('.sortable').each(function(index, data) {
                    position[index] = $(data).data('id');
                });
                $.ajax({
                    url: "<?php echo e(route('updatedash.dashboard')); ?>",
                    data: {
                        position: position,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    success: function(data) {
                        show_toastr('Done!', 'Chart updated successfully.', 'success',
                            '<?php echo e(asset('assets/images/notification/ok-48.png')); ?>', 4000);
                    },
                    error: function(data) {
                        show_toastr('Failed!', 'Chart does not updated.', 'danger',
                            '<?php echo e(asset('assets/images/notification/high_priority-48.png')); ?>',
                            4000);
                    }
                })
            });
        });
    </script>

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
    </script>

    <script>
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
    </script>

    <script>
        var today = new Date()
        var curHr = today.getHours()
        var target = document.getElementById("wishing");

        if (curHr < 12) {
            target.innerHTML = "Good Morning,";
        } else if (curHr < 17) {
            target.innerHTML = "Good Afternoon,";
        } else {
            target.innerHTML = "Good Evening,";
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/main_file/resources/views/dashboard/home.blade.php ENDPATH**/ ?>