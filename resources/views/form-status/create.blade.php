{{-- @extends('layouts.main')
@section('title', 'Create Status')
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Create Status') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item"><a href="{{ route('form-status.index') }}">{{ __('Form Status') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Create Status') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-6 col-lg-8 col-sm-12 col-12 m-auto">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Create Status') }}</h5>
                    {!! Form::open([
                        'route' => 'form-status.store',
                        'method' => 'Post',
                        'data-validate',
                    ]) !!}
                </div>
                <div class="card-body">
                    <div class="form-group">
                        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                        {!! Form::text('name', null, ['placeholder' => __('Enter name'), 'class' => 'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('color', __('Select Color'), ['class' => 'form-label']) }}
                        {!! Form::hidden('color', null, ['id' => 'color-hidden']) !!}
                        <select name="color" class="form-select" id="color" data-trigger>
                            <option value="" selected disabled>{{ __('Select Color') }}</option>
                            <option value="danger">{{ __('Danger') }}</option>
                            <option value="success">{{ __('Success') }}</option>
                            <option value="warning">{{ __('Warning') }}</option>
                            <option value="info">{{ __('Info') }}</option>
                            <option value="primary">{{ __('Primary') }}</option>
                            <option value="dark">{{ __('Dark') }}</option>
                            <option value="secondary">{{ __('Secondary') }}</option>
                        </select>
                    </div>



                    <div class="form-group">
                        {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                        {!! Form::hidden('status', null, ['id' => 'status-hidden']) !!}
                        <select name="status" class="form-select" id="status" data-trigger>
                            <option value="" selected disabled>{{ __('Select Status') }}</option>
                            <option value="1">{{ __('Active') }}</option>
                            <option value="0">{{ __('Deactive') }}</option>
                        </select>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="text-end">
                        {!! Html::link(route('form-status.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
                        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script>
       document.addEventListener('DOMContentLoaded', function() {
        var colorSelect = document.getElementById('color');
        var statusSelect = document.getElementById('status');

        var colorChoices = new Choices(colorSelect, {
            placeholder: true,
            searchEnabled: true,
            searchPlaceholderValue: 'Type to search'
        });

        var statusChoices = new Choices(statusSelect, {
            placeholder: true,
            searchEnabled: true,
            searchPlaceholderValue: 'Type to search'
        });

        colorSelect.addEventListener('change', function(event) {
            document.getElementById('color-hidden').value = event.target.value;
        });

        statusSelect.addEventListener('change', function(event) {
            document.getElementById('status-hidden').value = event.target.value;
        });
    });
    </script>
@endpush --}}

{!! Form::open([
    'route' => 'form-status.store',
    'method' => 'Post',
    'data-validate',
]) !!}
<div class="modal-body">
    <div class="form-group">
        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
        {!! Form::text('name', null, ['placeholder' => __('Enter name'), 'class' => 'form-control', 'required']) !!}
    </div>
    <div class="form-group">
        {{ Form::label('color', __('Select Color'), ['class' => 'form-label']) }}
        {!! Form::hidden('color', null, ['id' => 'color-hidden']) !!}
        {{ Form::select(
            'color',
            [
                '' => __('Select Status Color'),
                'danger' => __('Danger'),
                'success' => __('Success'),
                'info' => __('Info'),
                'primary' => __('Primary'),
                'secondary' => __('Secondary'),
                'warning' => __('Warning'),
            ],
            null,
            ['class' => 'custom_select form-select', 'id' => 'color', 'data-trigger'],
        ) }}
    </div>

    <div class="form-group">
        {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
        {!! Form::hidden('status', null, ['id' => 'status-hidden']) !!}
        {{ Form::select(
            'status',
            [
                '' => __('Select Form Status'),
                '1' => __('Active'),
                '2' => __('Deactive'),
            ],
            null,
            ['class' => 'custom_select form-select', 'id' => 'status', 'data-trigger'],
        ) }}
    </div>
</div>
<div class="modal-footer">
    <div class="text-end">
        {!! Html::link(route('form-status.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    </div>
</div>
{!! Form::close() !!}

