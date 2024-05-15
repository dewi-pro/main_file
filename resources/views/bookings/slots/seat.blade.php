@extends('layouts.main')
@section('title', __('Seat Wise Booking'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Seat Wise Booking') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('bookings.index'), __('Booking'), ['']) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('booking.design', $booking->id), __('Booking Design'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Seat Wise Booking') }}</li>
        </ul>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datepicker-bs5.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="m-auto col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5> {{ __('Seat Wise Booking') }}</h5>
                </div>
                {!! Form::model($seatWiseBooking, [
                    'route' => ['booking.slots.setting.update', $booking->id],
                    'method' => 'POST',
                    'enctype' => 'multipart/form-data',
                    'data-validate',
                ]) !!}
                <div class="card-body">
                    <div id="step1" class="row step">
                        <div class="mb-2 col-lg-12">
                            <strong>{{ __('Seat') }}</strong>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="repeater2">
                                    <div data-repeater-list="seat_booking">
                                        <div data-repeater-item>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        {{ Form::label('row', __('Seat Row'), ['class' => 'form-label']) }}
                                                        {!! Form::text('row', null, [
                                                            'class' => 'form-control',
                                                            'placeholder' => __('Select seat row'),
                                                            'id' => 'row',
                                                        ]) !!}
                                                        <small
                                                            class="form-text text-muted">{{ __('Select the seat row using letters from A to Z.') }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        {{ Form::label('column', __('Seat Column'), ['class' => 'form-label']) }}
                                                        {!! Form::text('column', null, [
                                                            'class' => 'form-control',
                                                            'placeholder' => __('Enter seat column'),
                                                            'id' => 'column',
                                                        ]) !!}
                                                        <small
                                                            class="form-text text-muted">{{ __('Enter maximum number of column seat booking.') }}</small>
                                                    </div>
                                                </div>
                                                <div class="text-right mt-27 col-md-2">
                                                    <input data-repeater-delete class="btn btn-danger" type="button"
                                                        value="Delete" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input data-repeater-create class="btn btn-primary" type="button" value="Add" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('services', __('Services'), ['class' => 'form-label']) }}
                            {!! Form::textarea('services', null, [
                                'class' => 'form-control',
                                'required',
                                'placeholder' => __('Enter services'),
                            ]) !!}
                        </div>
                    </div>
                    <div id="step2" class="row step d-none">
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('week_time', __('Week Time'), ['class' => 'form-label']) }}
                                {{ Form::select('week_time[]', $weekTimes, $selectedweektime, ['class' => 'form-select', 'required', 'multiple', 'id' => 'week_time', 'data-trigger']) }}
                                <div class="error-message" id="bouncer-error_week_time"></div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        {{ Form::label('session_time', __('Session Time'), ['class' => 'form-label']) }}
                                    </div>
                                    <div class="col-md-4 form-check form-switch custom-switch-v1">
                                        <input class="form-check-input float-end" id="session_time"
                                            {{ $seatWiseBooking && $seatWiseBooking->session_time_status == '1' ? 'checked' : 'unchecked' }}
                                            name="session_time" type="checkbox">
                                        <span class="custom-switch-indicator"></span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="form-group session-time {{ $seatWiseBooking && $seatWiseBooking->session_time_status == '1' ? '' : 'd-none' }}">
                                <div class="repeater1">
                                    <div data-repeater-list="session_times">
                                        <div data-repeater-item>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        {{ Form::label('start_time', __('To'), ['class' => 'form-label']) }}
                                                        {!! Form::text('start_time', null, [
                                                            'class' => 'form-control timePicker',
                                                            'placeholder' => __('Select start time'),
                                                            'id' => 'start_time',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        {{ Form::label('end_time', __('From'), ['class' => 'form-label']) }}
                                                        {!! Form::text('end_time', null, [
                                                            'class' => 'form-control timePicker',
                                                            'placeholder' => __('Select end time'),
                                                            'id' => 'end_time',
                                                        ]) !!}
                                                    </div>
                                                </div>
                                                <div class="text-right mt-27 col-md-2">
                                                    <input data-repeater-delete class="btn btn-danger" type="button"
                                                        value="Delete" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input data-repeater-create class="btn btn-primary" type="button" value="Add" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-8">
                                                {{ Form::label('limit_time_status', __('Start Booking & End Booking Date'), ['class' => 'form-label']) }}
                                            </div>
                                            <div class="col-md-4 form-check form-switch custom-switch-v1">
                                                <input class="form-check-input float-end" id="limit_time_status"
                                                    {{ $seatWiseBooking && $seatWiseBooking->limit_time_status == '1' ? 'checked' : 'unchecked' }}
                                                    name="limit_time_status" type="checkbox">
                                                <span class="custom-switch-indicator"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="limitTimeDate"
                                class="row {{ $seatWiseBooking && $seatWiseBooking->limit_time_status == '1' ? '' : 'd-none' }}">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                                        {!! Form::text(
                                            'start_date',
                                            $seatWiseBooking && $seatWiseBooking->start_date
                                                ? Carbon\Carbon::parse($seatWiseBooking->start_date)->format('d/m/Y')
                                                : null,
                                            [
                                                'class' => 'form-control datePicker',
                                                'placeholder' => __('Select start date'),
                                                'id' => 'start_date',
                                            ],
                                        ) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                        {!! Form::text(
                                            'end_date',
                                            $seatWiseBooking && $seatWiseBooking->end_date
                                                ? Carbon\Carbon::parse($seatWiseBooking->end_date)->format('d/m/Y')
                                                : null,
                                            [
                                                'class' => 'form-control datePicker',
                                                'placeholder' => __('Select end date'),
                                                'id' => 'end_date',
                                            ],
                                        ) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        {{ Form::label('rolling_days_status', __('Rolling Days'), ['class' => 'form-label']) }}
                                    </div>
                                    <div class="col-md-4 form-check form-switch custom-switch-v1">
                                        <input class="form-check-input float-end" id="rolling_days_status"
                                            {{ $seatWiseBooking && $seatWiseBooking->rolling_days_status == '1' ? 'checked' : 'unchecked' }}
                                            name="rolling_days_status" type="checkbox">
                                        <span class="custom-switch-indicator"></span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="form-group rolling_days {{ $seatWiseBooking && $seatWiseBooking->rolling_days_status == '1' ? '' : 'd-none' }}">
                                {{ Form::label('rolling_days', __('Rolling Days'), ['class' => 'form-label']) }}
                                {!! Form::number('rolling_days', null, [
                                    'class' => 'form-control',
                                    'placeholder' => __('Enter rolling days'),
                                    'id' => 'rolling_days',
                                ]) !!}
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        {{ Form::label('maximum_limit_status', __('Maximum Limit'), ['class' => 'form-label']) }}
                                    </div>
                                    <div class="col-md-4 form-check form-switch custom-switch-v1">
                                        <input class="form-check-input float-end" id="maximum_limit_status"
                                            {{ $seatWiseBooking && $seatWiseBooking->maximum_limit_status == '1' ? 'checked' : 'unchecked' }}
                                            name="maximum_limit_status" type="checkbox">
                                        <span class="custom-switch-indicator"></span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="form-group maximum_limit {{ $seatWiseBooking && $seatWiseBooking->maximum_limit_status == '1' ? '' : 'd-none' }}">
                                {{ Form::label('maximum_limit', __('Maximum Limit'), ['class' => 'form-label']) }}
                                {!! Form::number('maximum_limit', null, [
                                    'class' => 'form-control',
                                    'placeholder' => __('Enter maximum limit'),
                                    'id' => 'maximum_limit',
                                ]) !!}
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        {{ Form::label('multiple_booking', __('Multiple Booking'), ['class' => 'form-label']) }}
                                    </div>
                                    <div class="col-md-4 form-check form-switch custom-switch-v1">
                                        <input class="form-check-input float-end" id="multiple_booking"
                                            {{ $seatWiseBooking && $seatWiseBooking->multiple_booking == '1' ? 'checked' : 'unchecked' }}
                                            name="multiple_booking" type="checkbox">
                                        <span class="custom-switch-indicator"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="step3" class="row step d-none">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        {{ Form::label('email_notification', __('Email Notification'), ['class' => 'form-label']) }}
                                    </div>
                                    <div class="col-md-4 form-check form-switch custom-switch-v1">
                                        <input class="form-check-input float-end" id="email_notification"
                                            {{ $seatWiseBooking && $seatWiseBooking->email_notification == '1' ? 'checked' : 'unchecked' }}
                                            name="email_notification" type="checkbox">
                                        <span class="custom-switch-indicator"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('time_zone', __('Time Zone'), ['class' => 'form-label']) }}
                                <select class="form-control" name="time_zone" id="time_zone" data-trigger>
                                    <option value="">{{ __('Select time zone') }}</option>
                                    @foreach (timezone_identifiers_list() as $timezone)
                                        <option value="{{ $timezone }}"
                                            {{ $seatWiseBooking && $seatWiseBooking->time_zone == $timezone ? 'selected' : '' }}>
                                            {{ $timezone }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="mb-2 col-lg-12">
                                    <strong>{{ __('Date Format') }}</strong>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {!! Form::radio(
                                            'date_format',
                                            'mm/dd/yyyy',
                                            $seatWiseBooking ? ($seatWiseBooking->date_format == 'mm/dd/yyyy' ? true : false) : true,
                                            [
                                                'class' => 'btn-check',
                                                'id' => 'date_format_1',
                                            ],
                                        ) !!}
                                        {!! Form::label('date_format_1', __('MM/DD/YYYY'), ['class' => 'btn btn-outline-primary my-1']) !!}
                                        {!! Form::radio(
                                            'date_format',
                                            'dd/mm/yyyy',
                                            $seatWiseBooking && $seatWiseBooking->date_format == 'dd/mm/yyyy' ? true : false,
                                            [
                                                'class' => 'btn-check',
                                                'id' => 'date_format_2',
                                            ],
                                        ) !!}
                                        {!! Form::label('date_format_2', __('DD/MM/YYYY'), ['class' => 'btn btn-outline-primary my-1']) !!}
                                        {!! Form::radio(
                                            'date_format',
                                            'yyyy/mm/dd',
                                            $seatWiseBooking && $seatWiseBooking->date_format == 'yyyy/mm/dd' ? true : false,
                                            [
                                                'class' => 'btn-check',
                                                'id' => 'date_format_3',
                                            ],
                                        ) !!}
                                        {!! Form::label('date_format_3', __('YYYY/MM/DD'), ['class' => 'btn btn-outline-primary my-1']) !!}
                                    </div>
                                </div>
                                <div class="mb-2 col-lg-12">
                                    <strong>{{ __('Time Format') }}</strong>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {!! Form::radio(
                                            'time_format',
                                            '24_hour',
                                            $seatWiseBooking ? ($seatWiseBooking->time_format == '24_hour' ? true : false) : true,
                                            [
                                                'class' => 'btn-check',
                                                'id' => 'time_format_1',
                                            ],
                                        ) !!}
                                        {!! Form::label('time_format_1', __('24 Hour'), ['class' => 'btn btn-outline-primary my-1']) !!}
                                        {!! Form::radio(
                                            'time_format',
                                            'am/pm',
                                            $seatWiseBooking && $seatWiseBooking->time_format == 'am/pm' ? true : false,
                                            [
                                                'class' => 'btn-check',
                                                'id' => 'time_format_2',
                                            ],
                                        ) !!}
                                        {!! Form::label('time_format_2', __('AM/PM'), ['class' => 'btn btn-outline-primary my-1']) !!}
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-8">
                                                {{ Form::label('enable_note', __('Enable Note'), ['class' => 'form-label']) }}
                                            </div>
                                            <div class="col-md-4 form-check form-switch custom-switch-v1">
                                                <input class="form-check-input float-end" id="enable_note"
                                                    {{ $seatWiseBooking && $seatWiseBooking->enable_note == '1' ? 'checked' : 'unchecked' }}
                                                    name="enable_note" type="checkbox">
                                                <span class="custom-switch-indicator"></span>
                                            </div>
                                        </div>
                                        <div
                                            class="form-group enable_note {{ $seatWiseBooking && $seatWiseBooking->enable_note == '1' ? '' : 'd-none' }}">
                                            {!! Form::label('note', __('Note'), ['class' => 'form-label']) !!}
                                            {!! Form::textarea('note', null, [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter note'),
                                                'rows' => 3,
                                                'id' => 'note',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="mb-3 btn-flt float-start">
                        <button id="prevButton" type="button" class="btn btn-secondary d-none"><i
                                class="ti ti-chevron-left me-2"></i>{{ __('Previous') }}</button>
                    </div>
                    <div class="mb-3 btn-flt float-end">
                        <button id="nextButton" type="button" class="btn btn-primary">{{ __('Next') }}<i
                                class="ti ti-chevron-right ms-2"></i></button>
                        <button id="submitButton" type="submit"
                            class="btn btn-primary d-none">{{ __('Submit') }}</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
    <script src="{{ asset('vendor/repeater/reapeater.js') }}"></script>
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datepicker-full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var currentStep = 1;

            function showStep(stepNumber) {
                $('.step').addClass('d-none');
                $('#step' + stepNumber).removeClass('d-none');
                if (currentStep === 3) {
                    $('#nextButton').addClass('d-none');
                    $('#submitButton').removeClass('d-none');
                    $('#prevButton').removeClass('d-none');
                } else if (currentStep === 1) {
                    $('#nextButton').removeClass('d-none');
                    $('#submitButton').addClass('d-none');
                    $('#prevButton').addClass('d-none');
                } else {
                    $('#submitButton').addClass('d-none');
                    $('#nextButton').removeClass('d-none');
                    $('#prevButton').removeClass('d-none');
                }
            }


            // Function to go to the next step
            function nextStep() {
                if (currentStep < 3) {
                    currentStep++;
                    showStep(currentStep);
                }
            }
            // Function to go back to the previous step
            function prevStep() {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            }
            // Attach event handlers for navigation buttons
            $('#nextButton').click(nextStep);
            $('#prevButton').click(prevStep);
        });

        var genericExamples = document.querySelectorAll('[data-trigger]');
        for (i = 0; i < genericExamples.length; ++i) {
            var element = genericExamples[i];
            new Choices(element, {
                placeholderValue: 'This is a placeholder set in the config',
                searchPlaceholderValue: 'This is a search placeholder',
                removeItemButton: true,
            });
        }
        var genericExamples = document.querySelectorAll('.datePicker');
        for (i = 0; i < genericExamples.length; ++i) {
            var element = genericExamples[i];
            new Datepicker(element, {
                buttonClass: 'btn',
                format: 'dd/mm/yyyy'
            });
        }
        $(document).on('click', 'input[name="slot_duration"]', function() {
            var val = $(this).val();
            if (val == 'custom_min') {
                $('#custom_min').removeClass('d-none');
                $('#custom_min').find('input[name="slot_minutes"]').attr('required', true);
            } else {
                $('#custom_min').addClass('d-none');
                $('#custom_min').find('input[name="slot_minutes"]').attr('required', false);
            }
        });

        $(document).on('click', 'input[name="session_time"]', function() {
            if ($(this).is(':checked')) {
                $('.session-time').removeClass('d-none');
            } else {
                $('.session-time').addClass('d-none');
            }
        });

        $(document).on('click', 'input[name="limit_time_status"]', function() {
            if ($(this).is(':checked')) {
                $('#limitTimeDate').removeClass('d-none');
                $('#limitTimeDate').find('input[name="start_date"]').attr('required', true);
                $('#limitTimeDate').find('input[name="end_date"]').attr('required', true);
            } else {
                $('#limitTimeDate').addClass('d-none');
                $('#limitTimeDate').find('input[name="start_date"]').attr('required', false);
                $('#limitTimeDate').find('input[name="end_date"]').attr('required', false);
            }
        });

        $(document).on('click', 'input[name="enable_note"]', function() {
            if ($(this).is(':checked')) {
                $('.enable_note').removeClass('d-none');
                $('.enable_note').find('textarea[name="note"]').attr('required', true);
            } else {
                $('.enable_note').find('textarea[name="note"]').attr('required', true);
                $('.enable_note').addClass('d-none');
            }
        });

        $(document).on('click', 'input[name="rolling_days_status"]', function() {
            if ($(this).is(':checked')) {
                $('.rolling_days').find('input[name="rolling_days"]').attr('required', true);
                $('.rolling_days').removeClass('d-none');
            } else {
                $('.rolling_days').find('input[name="rolling_days"]').attr('required', false);
                $('.rolling_days').addClass('d-none');
            }
        });

        $(document).on('click', 'input[name="maximum_limit_status"]', function() {
            if ($(this).is(':checked')) {
                $('.maximum_limit').find('input[name="maximum_limit"]').attr('required', true);
                $('.maximum_limit').removeClass('d-none');
            } else {
                $('.maximum_limit').addClass('d-none');
                $('.maximum_limit').find('input[name="maximum_limit"]').attr('required', false);
            }
        });

        var $repeater1 = $('.repeater1').repeater({
            initEmpty: false,
            defaultValues: {},
            show: function() {
                var data = $(this).find('input,textarea,select').toArray();
                data.forEach(function(val) {
                    $(val).parent('.form-group').find('label').attr('for', $(val).attr(
                        'name'));
                    $(val).attr('id', $(val).attr('name'));
                });
                var genericExamples = document.querySelectorAll('.timePicker');
                for (i = 0; i < genericExamples.length; ++i) {
                    var element = genericExamples[i];
                    element.flatpickr({
                        enableTime: true,
                        noCalendar: true,
                    });
                }
                $(this).slideDown();
            },
            hide: function(deleteElement) {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            ready: function(setIndexes) {
                var genericExamples = document.querySelectorAll('.timePicker');
                for (i = 0; i < genericExamples.length; ++i) {
                    var element = genericExamples[i];
                    element.flatpickr({
                        enableTime: true,
                        noCalendar: true,
                    });
                }
            }
        });
        @if ($seatWiseBooking && $seatWiseBooking->session_time_json)
            var Json = JSON.parse({!! json_encode($seatWiseBooking->session_time_json) !!});
            $repeater1.setList(Json);
        @endif
        var $repeater2 = $('.repeater2').repeater({
            initEmpty: false,
            defaultValues: {},
            show: function() {
                var data = $(this).find('input,textarea,select').toArray();
                data.forEach(function(val) {
                    $(val).parent('.form-group').find('label').attr('for', $(val).attr(
                        'name'));
                    $(val).attr('id', $(val).attr('name'));
                });
                $(this).slideDown();
            },
            hide: function(deleteElement) {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            ready: function(setIndexes) {

            }
        });
        @if ($seatWiseBooking && $seatWiseBooking->seat_booking_json)
            var Json = JSON.parse({!! json_encode($seatWiseBooking->seat_booking_json) !!});
            $repeater2.setList(Json);
        @endif
        CKEDITOR.replace('services', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
