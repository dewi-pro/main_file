@php
    $hashids = new Hashids('', 20);
    $id = $hashids->encodeHex($poll->id);
    $userTheme = \Auth::user();
    $color = $userTheme->theme_color;
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
@endphp
@extends('layouts.main')
@section('title', __('Result'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Result') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('poll.index'), __('Polls'), []) !!}</li>
            <li class="breadcrumb-item active"> {{ __('Result') }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-6 col-xl-6 sortable">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">
                                {{ $poll['title'] }}
                                <div class="float-end">
                                </div>
                            </h5>
                        </div>
                        <div id="chartDiv">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-6 sortable">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">
                                {{ $poll['title'] }}
                            </h5>
                        </div>
                        <div id="chartDivs">
                        </div>
                    </div>
                </div>

                <script src="{{ asset('assets/js/loader.js') }}"></script>
                <script src="{{ asset('vendor/js/jquery.min.js') }}"></script>
                <script type="text/javascript">
                    var chartColor = '{{ $chatcolor }}';

                    function drawChart() {
                        var colWidth = (@json(array_keys($options['options'])).length * 7) + '%';
                        var barOptions = {
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
                            colors: [chartColor],
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
                                name: @json($poll['title']),
                                data: @json(array_values($options['options'])),
                            }],
                            xaxis: {
                                categories: @json(array_keys($options['options'])),
                            },
                        };
                        var chart = new ApexCharts(document.querySelector("#chartDiv"), barOptions);
                        chart.render();
                        var pieOptions = {
                            series: @json(array_values($options['options'])),
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
                            labels: @json(array_keys($options['options'])),
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
                                        width: 200,
                                    },
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }]
                        };
                        var chart = new ApexCharts(document.querySelector("#chartDivs"), pieOptions);
                        chart.render();
                    }
                </script>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-xl-6 ">
            <div class="card">
                <div class="card-header">
                    <h5> <i class="me-2" data-feather="share-2"></i>{{ __('Share') }}</h5>
                </div>
                <div class="card-body ">
                    <div class="m-auto form-group col-6">
                        <p>{{ __('Use this link to share the poll with your participants.') }}</p>
                        <div class="input-group">
                            <input type="text" value="{{ route('poll.survey.meeting', $id) }}"
                                class="form-control js-content" id="pc-clipboard-1" placeholder="Type some value to copy">
                            <a href="#" class="btn btn-primary js-copy" data-clipboard="true"
                                data-clipboard-target="#pc-clipboard-1"> {{ __('Copy') }}
                            </a>
                        </div>
                        <div class="mt-3 social-links-share">
                            <a href="https://api.whatsapp.com/send?text={{ route('poll.survey.meeting', $id) }}"
                                title="Whatsapp" class="social-links-share-main">
                                <i class="ti ti-brand-whatsapp"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ route('poll.survey.meeting', $id) }}"
                                title="Twitter" class="social-links-share-main">
                                <i class="ti ti-brand-twitter"></i>
                            </a>
                            <a href="https://www.facebook.com/share.php?u={{ route('poll.survey.meeting', $id) }}"
                                title="Facebook" class="social-links-share-main">
                                <i class="ti ti-brand-facebook"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ route('poll.survey.meeting', $id) }}"
                                title="Linkedin" class="social-links-share-main">
                                <i class="ti ti-brand-linkedin"></i>
                            </a>
                            <a href="javascript:void(1);" class="social-links-share-main" title="Show QR Code"
                                data-action="{{ route('poll.share.qr.meeting', $id) }}" id="share-qr">
                                <i class="ti ti-qrcode"></i>
                            </a>
                            <a href="javascript:void(0)" title="Embed" class="social-links-share-main"
                                onclick="copyToClipboard('#embed-form-{{ $poll->id }}')"
                                id="embed-form-{{ $poll->id }}"
                                data-url='<iframe src="{{ route('poll.survey.meeting', $id) }}" scrolling="auto" align="bottom" height=100vh" width="100%"></iframe>'>
                                <i class="ti ti-code"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($poll->meeting_allow_comments == 1)
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5> <i class="me-2" data-feather="message-circle"></i>{{ __('Comments') }}</h5>
                        </div>
                        {!! Form::open([
                            'route' => 'comment.store',
                            'method' => 'Post',
                        ]) !!}
                        <div class="card-body">
                            <div class="form-group">
                                {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter your name')]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::textarea('comment', null, [
                                    'class' => 'form-control',
                                    'rows' => '3',
                                    'required',
                                    'placeholder' => __('Add a comment'),
                                ]) !!}
                            </div>
                        </div>
                        <input type="hidden" id="poll_id" name="poll_id" value="{{ $poll->id }}">
                        <div class="card-footer">
                            <div class="text-end">
                                {!! Form::button(__('Add a comment'), ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                            </div>
                            {!! Form::close() !!}
                            @foreach ($poll->commmant as $value)
                                <div class="comments-item">
                                    <div class="comment-user-icon">
                                        <img src="{{ asset('assets/images/comment.png') }}" alt="">
                                    </div>
                                    <span class="text-left comment-info">
                                        <h6>{{ $value->name }}</h6>
                                        <span class="d-block"><small>{{ $value->comment }}</small></span>
                                        <h6 class="d-block"><small>({{ $value->created_at->diffForHumans() }})</small>
                                            <a href="#reply-comment" class="text-dark reply-comment-{{ $value->id }}"
                                                id="comment-reply" data-bs-toggle="collapse" data-id="{{ $value->id }}"
                                                title="{{ __('Reply') }}">
                                                {{ __('Reply') }}</i></a>
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['comment.destroy', $value->id],
                                                'id' => 'delete-form-' . $value->id,
                                                'class' => 'd-inline',
                                            ]) !!}
                                            <a href="#" class="text-dark show_confirm" title="Delete"
                                                id="delete-form-{{ $value->id }}">{{ __('Delete') }}</a>
                                            {!! Form::close() !!}
                                        </h6>
                                        <li class="list-inline-item"> </li>
                                        @foreach ($value->replyby as $replyValue)
                                            <div class="comment-replies">
                                                <div class="comment-user-icon">
                                                    <img src="{{ asset('assets/images/comment.png') }}" alt="">
                                                </div>
                                                <div class="comment-replies-content">
                                                    <h6>{{ $replyValue->name }}</h6>
                                                    <span class="d-block"><small>{{ $replyValue->reply }}</small></span>
                                                    <h6 class="d-block">
                                                        <small>({{ $replyValue->created_at->diffForHumans() }})</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </span>
                                </div>
                                {!! Form::open([
                                    'route' => 'comment.reply.store',
                                    'method' => 'Post',
                                    'data-validate',
                                ]) !!}
                                <div class="row commant" id="reply-comment-{{ $value->id }}">
                                    <div class="form-group">
                                        {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter your name')]) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::textarea('reply', null, [
                                            'class' => 'form-control',
                                            'rows' => '2',
                                            'required',
                                            'placeholder' => __('Add a comment'),
                                        ]) !!}
                                    </div>
                                    <input type="hidden" id="poll_id" name="poll_id" value="{{ $poll->id }}">
                                    <input type="hidden" id="comment_id" name="comment_id"
                                        value="{{ $value->id }}">
                                    <div class="card-footer">
                                        <div class="text-end">
                                            {!! Form::button(__('Add a Reply'), ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            @endforeach
                        </div>
                    </div>
                </div>
        @endif
    </div>
    <div class="col-lg-12">
        <div class="card-footer">
            <a href="{{ route('poll.fill', $poll->id) }}" class="btn btn-primary"><i class="me-2"
                    data-feather="skip-back"></i>{{ __('Back To Poll') }}</a>
            <a class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="share"
                href="javascript:void(0);" id="share-poll" data-action="{{ route('poll.shares', $poll->id) }}"><i
                    class="me-2" data-feather="share-2"></i>{{ __('Share') }}</a>
        </div>
    </div>
@endsection
@push('script')
    <script>
        window.onload = function() {
            drawChart();
        };
    </script>
    <script src="{{ asset('assets/js/plugins/clipboard.min.js') }}"></script>
    <script src="{{ asset('vendor/apex-chart/apexcharts.min.js') }}"></script>

    <script>
        new ClipboardJS('[data-clipboard=true]').on('success', function(e) {
            e.clearSelection();
        });
    </script>
    <script>
        $(function() {
            $('body').on('click', '#share-poll', function() {
                var action = $(this).data('action');
                var modal = $('#common_modal1');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Share') }}');
                    modal.find('.modal-body').html(response.html);
                    feather.replace();
                    let area = document.createElement('textarea');
                    document.body.appendChild(area);
                    area.style.display = "none";
                    let content = document.querySelectorAll('.js-content');
                    let copy = document.querySelectorAll('.js-copy');
                    for (let i = 0; i < copy.length; i++) {
                        copy[i].addEventListener('click', function() {
                            area.style.display = "block";
                            area.value = content[i].innerText;
                            area.select();
                            document.execCommand('copy');
                            area.style.display = "none";
                            this.innerHTML = 'Copied ';
                            setTimeout(() => this.innerHTML = "Copy", 2000);
                        });
                    }
                    modal.modal('show');
                })
            });
        });
    </script>
    <script>
        $(function() {
            $('body').on('click', '#share-qr', function() {
                var action = $(this).data('action');
                var modal = $('#common_modal2');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('QR Code') }}');
                    modal.find('.modal-body').html(response.html);
                    feather.replace();
                    modal.modal('show');
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
            show_toastr('Great!', '{{ __('Copy Link Successfully..') }}', 'success',
                '{{ asset('assets/images/notification/ok-48.png') }}', 4000);
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.commant').hide();
            $(document).on('click', '#comment-reply', function() {
                var dataId = $(this).attr("data-id");
                $('#reply-comment-' + dataId).show();

            });
        });
    </script>
    <script>
        (function() {
            let area = document.createElement('textarea');
            document.body.appendChild(area);
            area.style.display = "none";
            let content = document.querySelectorAll('.js-content');
            let copy = document.querySelectorAll('.js-copy');
            for (let i = 0; i < copy.length; i++) {
                copy[i].addEventListener('click', function() {
                    area.style.display = "block";
                    area.value = content[i].innerText;
                    area.select();
                    document.execCommand('copy');
                    area.style.display = "none";
                    this.innerHTML = 'Copied ';
                    setTimeout(() => this.innerHTML = "Copy", 2000);
                });
            }
        })();
    </script>
@endpush
