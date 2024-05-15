@extends('layouts.main')
@section('title', __('Booking Design'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Booking Design') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('bookings.index'), __('Bookings'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Booking Design') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="main-content">
            <section class="section">
                <div class="section-body">
                    {{ Form::model($booking, ['route' => ['booking.design.update', $booking->id], 'method' => 'PUT', 'id' => 'design-form']) }}
                    <div class="row">
                        <div class="col-xl-12 order-xl-1">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{ __('Design Form') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                @php
                                                    $array = json_decode($booking->json);
                                                @endphp
                                                <ul class="mb-3 nav nav-tabs" id="tabs">
                                                    <li class="nav-item"><a class="nav-link "
                                                            href="#page-1">{{ __('Page') }}1</a></li>
                                                </ul>
                                                <div id="page-1" class="build-wrap"></div>
                                                <div id="new-page"></div>
                                                <input type="hidden" name="json" value="{{ $booking->json }}">
                                                <br>
                                                <div class="action-buttons">
                                                    <button id="showData" class="d-none"
                                                        type="button">{{ __('Show Data') }}</button>
                                                    <button id="clearFields" class="d-none"
                                                        type="button">{{ __('Clear All Fields') }}</button>
                                                    <button id="getData" class="d-none"
                                                        type="button">{{ __('Get Data') }}</button>
                                                    <button id="getXML" class="d-none"
                                                        type="button">{{ __('Get XML Data') }}</button>
                                                    <button id="getJSON" class="btn btn-primary"
                                                        type="button">{{ __('Next') }}</button>
                                                    <button id="getJSONs" class="d-none"
                                                        onClick="javascript:history.go(-1)"
                                                        type="button">{{ __('Back') }}</button>
                                                    <button id="getJS" class="d-none"
                                                        type="button">{{ __('Get JS Data') }}</button>
                                                    <button id="setData" class="d-none"
                                                        type="button">{{ __('Set Data') }}</button>
                                                    <button id="addField" class="d-none"
                                                        type="button">{{ __('Add Field') }}</button>
                                                    <button id="removeField" class="d-none"
                                                        type="button">{{ __('Remove Field') }}</button>
                                                    <button id="testSubmit" class="d-none"
                                                        type="submit">{{ __('Test Submit') }}</button>
                                                    <button id="resetDemo" class="d-none"
                                                        type="button">{{ __('Reset Demo') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </section>
        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/jqueryform/css/demo.css') }}">
    <link href="{{ asset('vendor/jqueryform/css/jquery.rateyo.min.css') }}" rel="stylesheet" />
    <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" />
@endpush
@push('script')
    <script>
        var lang = '{{ app()->getLocale() }}';
        var lang_other = '{{ __('Other') }}';
        var lang_other_placeholder = '{{ __('Enter please') }}';
        var lang_Page = '{{ __('Page') }}';
        var lang_Custom_Autocomplete = '{{ __('Custom Autocomplete') }}';
    </script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="{{ asset('vendor/jqueryform/js/signaturePad.umd.js') }}"></script>
    <script src="{{ asset('vendor/jqueryform/js/vendor.js') }}"></script>
    <script src="{{ asset('vendor/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="{{ asset('vendor/jqueryform/js/form-builder.min.js') }}"></script>
    <script src="{{ asset('vendor/jqueryform/js/form-render.min.js') }}"></script>
    <script src="{{ asset('vendor/jqueryform/js/demobookingFirst.js') }}"></script>
    <script src="{{ asset('vendor/jqueryform/js/jquery.rateyo.min.js') }}"></script>
@endpush
