@php
    $currantColumn = [];
@endphp

<table>
    <tbody>
        <tr>
            <th>{{ __('Date Submitted') }}</th>
            <th>{{ __('Company Name') }}</th>
            <th>{{ __('Full Name') }}</th>
            <th>{{ __('Email') }}</th>
            <th>{{ __('Rate Services') }}</th>
            <th>{{ __('Comment') }}</th>
            <th>{{ __('Tour Consultant') }}</th>
        </tr> 
        @foreach ($formvalues as $key => $formvalues)
        <tr>
            <td>{{$formvalues->created_at}}</td>
            <td>{{$formvalues->company_name}}</td>
            <td>{{$formvalues->full_name}}</td>
            <td>{{$formvalues->email}}</td>
            <td>{{$formvalues->rate_label}}</td>
            <td>{{$formvalues->comment}}</td>
            <td>{{$formvalues->tour_consultant}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

 <div id="chartContainer" style="height: 370px; width: 100%;"></div>
 <!-- <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script> -->
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
@endpush

