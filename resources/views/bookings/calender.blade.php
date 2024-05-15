@extends('layouts.main')
@section('title', __('Booking Calendar'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Booking Calendar') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Booking Calendar') }}</li>
        </ul>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datepicker-bs5.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Calendar') }}</h5>
                </div>
                <div class="card-body">
                    <div id='calendar' class='calendar'></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var data = {!! $bookingData !!};
            var etitle;
            var etype;
            var etypeclass;
            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    timeGridDay: "{{ __('Day') }}",
                    timeGridWeek: "{{ __('Week') }}",
                    dayGridMonth: "{{ __('Month') }}"
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
        });
    </script>
@endpush
