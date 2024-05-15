@php
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

@endphp
@extends('layouts.main')
@section('title', __('Submitted Form'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Submitted Forms of ' . ' ' . $formsDetails->title) }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active"> {{ __('Submitted Forms of ' . ' ' . $formsDetails->title) }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="main-content">
            <section class="section">
                @if (!empty($formsDetails->logo))
                    @if (App\Facades\UtilityFacades::getsettings('storage_type') == 'local')
                        <div class="text-center gallery gallery-md">
                            {!! Form::image(
                                Storage::exists($formsDetails->logo)
                                    ? asset('storage/app/' . $formsDetails->logo)
                                    : Storage::url('not-exists-data-images/78x78.png'),
                                null,
                                [
                                    'class' => 'gallery-item float-none',
                                    'id' => 'app-dark-logo',
                                ],
                            ) !!}
                        </div>
                    @else
                        <div class="text-center gallery gallery-md">
                            {!! Form::image(Storage::url($formsDetails->logo), null, [
                                'class' => 'gallery-item float-none',
                                'id' => 'app-dark-logo',
                            ]) !!}
                        </div>
                    @endif
                @endif
                <h2 class="text-center">{{ $formsDetails->title }}</h2>
                <div class="section-body filter">
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-body">
                                    @can('manage-submitted-form')
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 responsive-search">
                                                <div class="form-group d-flex justify-content-start">
                                                    {{ Form::text('user', null, ['class' => 'form-control mr-1 ', 'placeholder' => __('Search here'), 'data-kt-ecommerce-category-filter' => 'search', 'id' => 'user_search', 'onchange' => 'userExcel()']) }}
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 responsive-search">
                                                <div class="form-group row d-flex justify-content-start">
                                                    {{ Form::text('duration', null, ['class' => 'form-control mr-1 created_at', 'placeholder' => __('Select Date Range'), 'id' => 'pc-daterangepicker-1', 'onchange' => 'updateEndDate()']) }}
                                                    {!! Form::hidden('form_id', $formsDetails->id, ['id' => 'form_id']) !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 btn-responsive-search">
                                                {{ Form::button(__('Filter'), ['class' => 'btn btn-primary btn-lg  add_filter button-left']) }}
                                                {{ Form::button(__('Clear Filter'), ['class' => 'btn btn-secondary btn-lg clear_filter']) }}
                                                {!! Form::open([
                                                    'route' => ['download.form.values.excel'],
                                                    'method' => 'post',
                                                    'id' => 'mass_export',
                                                    'class' => 'd-inline-block',
                                                ]) !!}
                                                {{ Form::hidden('form_id', $formsDetails->id) }}
                                                {{ Form::hidden('select_date') }}
                                                {{ Form::hidden('user_search_excel') }}
                                                {{ Form::submit('Export to Excel', ['class' => 'btn btn-success']) }}
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    @endcan
                                    <div class="row mt-5">
                                        <div class="col-md-12">
                                            <div class="table-responsive py-4">
                                                {{ $dataTable->table(['width' => '100%']) }}
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
                                        @php($key = 1)
                                        @foreach ($chartData as $chart)
                                            <div class="col-md-6 col-xl-4" data-id="1">
                                                <div class="card">
                                                    @if (isset($chart['is_enable_chart']) && $chart['is_enable_chart'] == 'true')
                                                        <div class="card-header">
                                                            <h5 class="mb-0">
                                                                {{ $chart['label'] }}
                                                            </h5>
                                                        </div>
                                                    @endif
                                                    <div class="col-sm-12">
                                                        @if (isset($chart['is_enable_chart']) && $chart['is_enable_chart'] == true && $chart['chart_type'] == 'bar')
                                                            <div id="chartDiv-{{ $key }}"
                                                                class="pie-chart d-flex align-items-center"></div>
                                                        @endif
                                                        @if (isset($chart['is_enable_chart']) && $chart['is_enable_chart'] == true && $chart['chart_type'] == 'pie')
                                                            <div id="chartDive-{{ $key }}"
                                                                class="pie-chart d-flex align-items-center">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <script type="text/javascript">
                                                var colors = '<?php echo $chatcolor; ?>';

                                                function drawChart{{ $key }}() {
                                                    @if (isset($chart['is_enable_chart']) && $chart['is_enable_chart'] == true && $chart['chart_type'] == 'bar')
                                                        var colWidth = (@json(array_keys($chart['options'])).length * 7) + '%';
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
                                                                name: @json($chart['label']),
                                                                data: @json(array_values($chart['options'])),
                                                            }],
                                                            xaxis: {
                                                                categories: @json(array_keys($chart['options'])),
                                                            },
                                                        };
                                                        var chart = new ApexCharts(document.querySelector("#chartDiv-{{ $key }}"), options);
                                                        chart.render();
                                                    @endif
                                                    @if (isset($chart['is_enable_chart']) && $chart['is_enable_chart'] == true && $chart['chart_type'] == 'pie')
                                                        var options = {
                                                            series: @json(array_values($chart['options'])),
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
                                                            labels: @json(array_keys($chart['options'])),
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
                                                        var chart = new ApexCharts(document.querySelector("#chartDive-{{ $key }}"), options);
                                                        chart.render();
                                                    @endif
                                                }
                                            </script>
                                            @php($key++)
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}" />
    @include('layouts.includes.datatable-css')
@endpush
@push('script')
    <script src="{{ asset('assets/js/loader.js') }}"></script>
    <script src="{{ asset('vendor/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
    <script src="{{ asset('vendor/apex-chart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/daterangepicker/daterangepicker.min.js') }}"></script>
    @include('layouts.includes.datatable-js')
    {{ $dataTable->scripts() }}
    <script>
        window.onload = function() {
            @php($key = 1)
            @foreach ($chartData as $chart)
                drawChart{{ $key }}();
                @php($key++)
            @endforeach
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
                    modal.find('.modal-title').html('{{ __('Change Status') }}');
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
@endpush
