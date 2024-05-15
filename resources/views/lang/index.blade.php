@extends('layouts.main')
@section('title', __('Languages'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Languages') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item">{{ __('Languages') }}</li>
        </ul>
        <div class="float-end">
            <div class="d-flex align-items-center">
                @can('create-language')
                <a href="{{ route('create.language', [$currantLang]) }}" data-bs-toggle="tooltip"
                    data-bs-original-title="{{ __('Create') }}" id="create" class="btn btn-sm btn-primary"
                    data-bs-placement="bottom">
                    <i class="ti ti-plus"></i>
                </a>
                @endcan
                @can('delete-language')
                {!! Form::open([
                    'method' => 'DELETE',
                    'route' => ['lang.destroy', $currantLang],
                    'id' => 'delete-form-' . $currantLang,
                ]) !!}
                <a href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                    data-bs-original-title="{{ __('Delete') }}"
                    class="btn btn-sm btn-danger float-end btn-lg text-light ms-1 show_confirm">
                    <i class="ti ti-trash"></i>
                </a>
                {!! Form::close() !!}
                @endcan
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top mt-3">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            @foreach ($languages as $lang)
                                <a href="{{ route('manage.language', [$lang]) }}"
                                    class="list-group-item list-group-item-action border-0 {{ $currantLang == $lang ? 'active' : '' }}">{{ Str::upper($lang) }}
                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div id="useradd-1" class="card">
                        <div class="card-header">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    {!! Html::link('#account-details', __('Labels'), [
                                        'data-bs-toggle' => 'pill',
                                        'role' => 'tab',
                                        'aria-selected' => 'true',
                                        'aria-controls' => 'account-details',
                                        'class' => 'nav-link active',
                                        'id' => 'account-details-tab',
                                    ]) !!}
                                </li>
                                <li class="nav-item">
                                    {!! Html::link('#login-details', __('Message'), [
                                        'data-bs-toggle' => 'pill',
                                        'role' => 'tab',
                                        'aria-selected' => 'false',
                                        'aria-controls' => 'login-details',
                                        'class' => 'nav-link',
                                        'id' => 'login-details-tab',
                                    ]) !!}
                                </li>
                            </ul>
                        </div>
                        <div class="card-body pt-0">
                            <div class="tab-content">
                                <div class="tab-pane active" id="account-details" role="tabpanel"
                                    aria-labelledby="account-details-tab">
                                    {!! Form::open([
                                        'route' => ['store.language.data', [$currantLang]],
                                        'method' => 'POST',
                                    ]) !!}
                                    <div class="row form-group">
                                        @foreach ($arrLabel as $label => $value)
                                            <div class="col-md-6">
                                                <div class="mt-3">
                                                    {{ Form::label('example3cols1Input', $label, ['class' => 'form-label']) }}
                                                    {{ Form::text("label[$label]", $value, ['class' => 'form-control']) }}
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                <div class="tab-pane" id="login-details" role="tabpanel"
                                    aria-labelledby="login-details-tab">
                                    <div class="row form-group">
                                        @foreach ($arrMessage as $fileName => $fileValue)
                                            <div class="col-lg-12">
                                                <h4>{{ ucfirst($fileName) }}</h4>
                                            </div>
                                            @foreach ($fileValue as $label => $value)
                                                @if (is_array($value))
                                                    @foreach ($value as $label2 => $value2)
                                                        @if (is_array($value2))
                                                            @foreach ($value2 as $label3 => $value3)
                                                                @if (is_array($value3))
                                                                    @foreach ($value3 as $label4 => $value4)
                                                                        @if (is_array($value4))
                                                                            @foreach ($value4 as $label5 => $value5)
                                                                                <div class="col-md-6">
                                                                                    <div class="mt-3">
                                                                                        {{ Form::label('message', $fileName . $label . $label2 . $label3 . $label4 . $label5, ['class' => 'form-label']) }}
                                                                                        {{ Form::text("message[$fileName][$label][$label2][$label3][$label4][$label5]", $value5, ['class' => 'form-control']) }}
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        @else
                                                                            <div class="col-lg-6">
                                                                                <div class="mt-3">
                                                                                    {{ Form::label('message', $fileName . $label . $label2 . $label3 . $label4, ['class' => 'form-label']) }}
                                                                                    {{ Form::text("message[$fileName][$label][$label2][$label3][$label4]", $value4, ['class' => 'form-control']) }}
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <div class="col-lg-6">
                                                                        <div class="mt-1">
                                                                            {{ Form::label('message', $fileName . $label . $label2 . $label3, ['class' => 'form-label']) }}
                                                                            {{ Form::text("message[$fileName][$label][$label2][$label3]", $value3, ['class' => 'form-control']) }}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <div class="col-lg-6">
                                                                <div class="mt-1">
                                                                    {{ Form::label('message', $fileName . $label . $label2, ['class' => 'form-label']) }}
                                                                    {{ Form::text("message[$fileName][$label][$label2]", $value2, ['class' => 'form-control']) }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <div class="col-lg-6">
                                                        <div class="mt-1">
                                                            {{ Form::label('message', $fileName . $label, ['class' => 'form-label']) }}
                                                            {{ Form::text("message[$fileName][$label]", $value, ['class' => 'form-control']) }}
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-lg-12 float-end mb-3">
                                {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary float-end']) }}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <link href="{{ asset('vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
@endpush
@push('script')
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        })
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'This is a placeholder set in the config',
                    searchPlaceholderValue: 'This is a search placeholder',
                });
            }
        });
    </script>
    <script src="{{ asset('vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script>
        $(".inputtags").tagsinput('items');
    </script>
@endpush
