<?php
    $user = \Auth::user();
    $color = $user->theme_color;
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

<?php $__env->startSection('title', __('Submitted Form')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Submitted Forms of ' . ' ' . $formsDetails->title)); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Dashboard'), []); ?></li>
            <li class="breadcrumb-item active"> <?php echo e(__('Submitted Forms of ' . ' ' . $formsDetails->title)); ?> </li>
        </ul>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="main-content">
            <section class="section">
                <?php if(!empty($formsDetails->logo)): ?>
                    <?php if(App\Facades\UtilityFacades::getsettings('storage_type') == 'local'): ?>
                        <div class="text-center gallery gallery-md">
                            <?php echo Form::image(
                                Storage::exists($formsDetails->logo)
                                    ? asset('storage/app/' . $formsDetails->logo)
                                    : Storage::url('not-exists-data-images/78x78.png'),
                                null,
                                [
                                    'class' => 'gallery-item float-none',
                                    'id' => 'app-dark-logo',
                                ],
                            ); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center gallery gallery-md">
                            <?php echo Form::image(Storage::url($formsDetails->logo), null, [
                                'class' => 'gallery-item float-none',
                                'id' => 'app-dark-logo',
                            ]); ?>

                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <h2 class="text-center"><?php echo e($formsDetails->title); ?></h2>
                <div class="section-body filter">
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-submitted-form')): ?>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 responsive-search">
                                                <div class="form-group d-flex justify-content-start">
                                                    <?php echo e(Form::text('user', null, ['class' => 'form-control mr-1 ', 'placeholder' => __('Search here'), 'data-kt-ecommerce-category-filter' => 'search', 'id' => 'user_search', 'onchange' => 'userExcel()'])); ?>

                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 responsive-search">
                                                <div class="form-group row d-flex justify-content-start">
                                                    <?php echo e(Form::text('duration', null, ['class' => 'form-control mr-1 created_at', 'placeholder' => __('Select Date Range'), 'id' => 'pc-daterangepicker-1', 'onchange' => 'updateEndDate()'])); ?>

                                                    <?php echo Form::hidden('form_id', $formsDetails->id, ['id' => 'form_id']); ?>

                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 btn-responsive-search">
                                                <?php echo e(Form::button(__('Filter'), ['class' => 'btn btn-primary btn-lg  add_filter button-left'])); ?>

                                                <?php echo e(Form::button(__('Clear Filter'), ['class' => 'btn btn-secondary btn-lg clear_filter'])); ?>

                                                <?php echo Form::open([
                                                    'route' => ['download.form.values.excel'],
                                                    'method' => 'post',
                                                    'id' => 'mass_export',
                                                    'class' => 'd-inline-block',
                                                ]); ?>

                                                <?php echo e(Form::hidden('form_id', $formsDetails->id)); ?>

                                                <?php echo e(Form::hidden('select_date')); ?>

                                                <?php echo e(Form::hidden('user_search_excel')); ?>

                                                <?php echo e(Form::submit('Export to Excel', ['class' => 'btn btn-success'])); ?>

                                                <?php echo Form::close(); ?>

                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="row mt-5">
                                        <div class="col-md-12">
                                            <div class="table-responsive py-4">
                                                <?php echo e($dataTable->table(['width' => '100%'])); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-12" id="chart_div">
                                    <style>
                                        .pie-chart {
                                            width: 100%;
                                            height: 400px;
                                            margin: 0 auto;
                                            float: right;
                                        }

                                        .text-center {
                                            text-align: center;
                                        }

                                        @media (max-width: 991px) {
                                            .pie-chart {
                                                width: 100%;
                                            }
                                        }
                                    </style>
                                    <div class="row">
                                        <?php ($key = 1); ?>
                                        <?php $__currentLoopData = $chartData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-6 col-xl-4" data-id="1">
                                                <div class="card">
                                                    <?php if(isset($chart['is_enable_chart']) && $chart['is_enable_chart'] == 'true'): ?>
                                                        <div class="card-header">
                                                            <h5 class="mb-0">
                                                                <?php echo e($chart['label']); ?>

                                                            </h5>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="col-sm-12">
                                                        <?php if(isset($chart['is_enable_chart']) && $chart['is_enable_chart'] == true && $chart['chart_type'] == 'bar'): ?>
                                                            <div id="chartDiv-<?php echo e($key); ?>"
                                                                class="pie-chart d-flex align-items-center"></div>
                                                        <?php endif; ?>
                                                        <?php if(isset($chart['is_enable_chart']) && $chart['is_enable_chart'] == true && $chart['chart_type'] == 'pie'): ?>
                                                            <div id="chartDive-<?php echo e($key); ?>"
                                                                class="pie-chart d-flex align-items-center">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <script type="text/javascript">
                                                var colors = '<?php echo $chatcolor; ?>';

                                                function drawChart<?php echo e($key); ?>() {
                                                    <?php if(isset($chart['is_enable_chart']) && $chart['is_enable_chart'] == true && $chart['chart_type'] == 'bar'): ?>
                                                        var colWidth = (<?php echo json_encode(array_keys($chart['options']), 15, 512) ?>.length * 7) + '%';
                                                        var options = {
                                                            chart: {
                                                                type: 'bar',
                                                                toolbar: {
                                                                    show: false
                                                                }
                                                            },
                                                            plotOptions: {
                                                                bar: {
                                                                    columnWidth: colWidth,
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
                                                                name: <?php echo json_encode($chart['label'], 15, 512) ?>,
                                                                data: <?php echo json_encode(array_values($chart['options']), 15, 512) ?>,
                                                            }],
                                                            xaxis: {
                                                                categories: <?php echo json_encode(array_keys($chart['options']), 15, 512) ?>,
                                                            },
                                                        };
                                                        var chart = new ApexCharts(document.querySelector("#chartDiv-<?php echo e($key); ?>"), options);
                                                        chart.render();
                                                    <?php endif; ?>
                                                    <?php if(isset($chart['is_enable_chart']) && $chart['is_enable_chart'] == true && $chart['chart_type'] == 'pie'): ?>
                                                        var options = {
                                                            series: <?php echo json_encode(array_values($chart['options']), 15, 512) ?>,
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
                                                            labels: <?php echo json_encode(array_keys($chart['options']), 15, 512) ?>,
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
                                                            responsive: [{
                                                                breakpoint: 480,
                                                                options: {
                                                                    chart: {
                                                                        width: 200
                                                                    },
                                                                    legend: {
                                                                        position: 'bottom'
                                                                    }
                                                                }
                                                            }]
                                                        };
                                                        var chart = new ApexCharts(document.querySelector("#chartDive-<?php echo e($key); ?>"), options);
                                                        chart.render();
                                                    <?php endif; ?>
                                                }
                                            </script>
                                            <?php ($key++); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendor/daterangepicker/daterangepicker.css')); ?>" />
    <?php echo $__env->make('layouts.includes.datatable-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/js/loader.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/flatpickr.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/apex-chart/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/daterangepicker/daterangepicker.min.js')); ?>"></script>
    <?php echo $__env->make('layouts.includes.datatable-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo e($dataTable->scripts()); ?>

    <script>
        window.onload = function() {
            <?php ($key = 1); ?>
            <?php $__currentLoopData = $chartData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                drawChart<?php echo e($key); ?>();
                <?php ($key++); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        };
        document.querySelector("#pc-daterangepicker-1").flatpickr({
            mode: "range"
        });


        $(function() {
            $('body').on('click', '#change-form-status', function() {
                var action = $(this).data('share');
                console.log(action);
                var modal = $('#common_modal2');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('<?php echo e(__('Change Status')); ?>');
                    modal.find('.modal-body').html(response.html);
                    modal.on('shown.bs.modal', function() {
                        var genericExamples = document.querySelectorAll('[data-trigger]');
                        for (i = 0; i < genericExamples.length; ++i) {
                            var element = genericExamples[i];
                            new Choices(element, {
                                placeholderValue: 'This is a placeholder set in the config',
                                searchPlaceholderValue: 'This is a search placeholder',
                            });
                        }
                    });
                    feather.replace();
                    modal.modal('show');
                })
            });
        });
    </script>
    <script>
        function updateEndDate() {
            var duration = document.getElementById('pc-daterangepicker-1').value;
            var startDate = '';
            var startDateArray = duration.split(' - ');
            if (startDateArray.length > 0) {
                startDate = startDateArray[0];
            }
            document.querySelector('input[name="select_date"]').value = startDate;
        }
    </script>
    <script>
        function userExcel() {
            var user = document.getElementById('user_search').value;
            console.log(user);

            document.querySelector('input[name="user_search_excel"]').value = user;
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/main_file/resources/views/form-value/view-submited-form.blade.php ENDPATH**/ ?>