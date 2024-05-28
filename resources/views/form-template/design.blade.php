@extends('layouts.main')
@section('title', __('Form Template Design'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Form Template Design') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('form-template.index'), __('Form Templates'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Form Template Design') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="main-content">
            @if (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'http')
                <div class="alert alert-warning">
                    <b>
                        {{ __('Please note that the video recording and selfie features are only available on HTTPS websites and its not work on HTTP sites.') }}</b>
                </div>
            @endif
            <section class="section">
                <div class="section-body">
                    {{ Form::model($formTemplate, ['route' => ['form.template.design.update', $formTemplate->id], 'method' => 'PUT', 'id' => 'design-form']) }}
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
                                                    $array = json_decode($formTemplate->json);
                                                @endphp
                                                <ul class="mb-3 nav nav-tabs" id="tabs">
                                                    @if (!empty($formTemplate->json))
                                                        @foreach ($array as $key => $data)
                                                            <li class="nav-item">
                                                                <a class="nav-link"
                                                                    href="#page-{{ $key + 1 }}">{{ __('Page') . ($key + 1) }}</a>
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        <li class="nav-item"><a class="nav-link "
                                                                href="#page-1">{{ __('Page') }}1</a></li>
                                                    @endif
                                                    <li class="nav-item" id="add-page-tab"><a class="nav-link"
                                                            href="#new-page">+
                                                            {{ __('Page') }}</a>
                                                    </li>
                                                </ul>
                                                @if (!empty($formTemplate->json))
                                                    @foreach ($array as $key => $data)
                                                        <div id="page-{{ $key + 1 }}" class="build-wrap">
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div id="page-1" class="build-wrap"></div>
                                                @endif
                                                <div id="new-page"></div>
                                                <input type="hidden" name="json" value="{{ $formTemplate->json }}">
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
                                                        type="button">{{ __('Update') }}</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="{{ asset('vendor/jqueryform/js/form-builder.min.js') }}"></script>
    <script src="{{ asset('vendor/jqueryform/js/form-render.min.js') }}"></script>
    <script src="{{ asset('vendor/jqueryform/js/demoFirst.js') }}"></script>
    <script src="{{ asset('vendor/jqueryform/js/jquery.rateyo.min.js') }}"></script>
@endpush
