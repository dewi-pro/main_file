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
                                            <!-- <div class="col-lg-4 col-md-6 responsive-search">
                                                <div class="form-group d-flex justify-content-start">
                                                    {{ Form::text('user', null, ['class' => 'form-control mr-1 ', 'placeholder' => __('Search here'), 'data-kt-ecommerce-category-filter' => 'search', 'id' => 'user_search', 'onchange' => 'userExcel()']) }}
                                                </div>
                                            </div> -->
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
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-body">
                               <!-- <h2> {{$forms[0]->title }}</h2> -->
                                <?php
 
                                    $dataPoints1 = array( 
                                        array("label" => "Q1",  "y" => $valueDetail1[0]->sum ),
                                        array("label" => "Q2", "y" => $valueDetail2[0]->sum),
                                        array("label" => "Q3", "y" => $valueDetail3[0]->sum ),
                                        array("label" => "Q4",  "y" => $valueDetail4[0]->sum ),
                                        array("label" => "Q5", "y" => $valueDetail5[0]->sum ),
                                        array("label" => "Q6",  "y" => $valueDetail6[0]->sum ),
                                        array("label" => "Q7",  "y" => $valueDetail7[0]->sum ),
                                        array("label" => "Q8",  "y" => $valueDetail8[0]->sum ),
                                        array("label" => "Q9",  "y" => $valueDetail9[0]->sum ),
                                        array("label" => "Q10",  "y" => $valueDetail10[0]->sum )
                                    );
                                    
                                    $dataPoints2 = array( 
                                        array("label" => "Q1",  "y" => $valueDetail11[0]->sum ),
                                        array("label" => "Q2", "y" => $valueDetail12[0]->sum),
                                        array("label" => "Q3", "y" => $valueDetail13[0]->sum ),
                                        array("label" => "Q4",  "y" => $valueDetail14[0]->sum ),
                                        array("label" => "Q5", "y" => $valueDetail15[0]->sum ),
                                        array("label" => "Q6",  "y" => $valueDetail16[0]->sum ),
                                        array("label" => "Q7",  "y" => $valueDetail17[0]->sum ),
                                        array("label" => "Q8",  "y" => $valueDetail18[0]->sum ),
                                        array("label" => "Q9",  "y" => $valueDetail19[0]->sum ),
                                        array("label" => "Q10",  "y" => $valueDetail20[0]->sum )
                                    );
                                    
                                    $dataPoints3 = array( 
                                        array("label" => "Q1",  "y" => $valueDetail21[0]->sum ),
                                        array("label" => "Q2", "y" => $valueDetail22[0]->sum),
                                        array("label" => "Q3", "y" => $valueDetail23[0]->sum ),
                                        array("label" => "Q4",  "y" => $valueDetail24[0]->sum ),
                                        array("label" => "Q5", "y" => $valueDetail25[0]->sum ),
                                        array("label" => "Q6",  "y" => $valueDetail26[0]->sum ),
                                        array("label" => "Q7",  "y" => $valueDetail27[0]->sum ),
                                        array("label" => "Q8",  "y" => $valueDetail28[0]->sum ),
                                        array("label" => "Q9",  "y" => $valueDetail29[0]->sum ),
                                        array("label" => "Q10",  "y" => $valueDetail30[0]->sum )
                                    );
                                    ?>
                                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                                    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
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
    <script>
        window.onload = function() {
        
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            // title: {
            //     text: "Social Media Engagement"
            // },
            toolTip: {
                shared: true
            },
            axisY: {
                title: "Percentage of Users",
                suffix: "%"
            },
            data: [{
                type: "stackedBar100",
                name: "Top Boxes",
                yValueFormatString: "#,##0\"%\"",
                dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
            },{
                type: "stackedBar100",
                yValueFormatString: "#,##0\"%\"",
                name: "Neutral 2 Boxes",
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            },{
                type: "stackedBar100",
                yValueFormatString: "#,##0\"%\"",
                name: "Bottom Boxes",
                dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
        
        }
    </script>
@endpush
