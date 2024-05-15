{{-- @extends('layouts.main')
@section('title', 'Edit Status')
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Edit Status') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item"><a href="{{ route('form-status.index') }}">{{ __('Form Status') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Edit Status') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-6 col-lg-8 col-sm-12 col-12 m-auto">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Edit Status') }}</h5>
                    {!! Form::model($formStatus, [
                        'route' => ['form-status.update', $formStatus->id],
                        'method' => 'put',
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
                        <select name="color" class="custom_select form-select select2" id="color" data-trigger>
                            <option value="" selected disabled>{{ __('Select Color') }}</option>
                            <option value="danger" @if ($formStatus->color == 'danger') selected @endif>{{ __('Danger') }}
                            </option>
                            <option value="success" @if ($formStatus->color == 'success') selected @endif>{{ __('Success') }}
                            </option>
                            <option value="warning" @if ($formStatus->color == 'warning') selected @endif>{{ __('Warning') }}
                            </option>
                            <option value="info" @if ($formStatus->color == 'info') selected @endif>{{ __('Info') }}
                            </option>
                            <option value="primary" @if ($formStatus->color == 'primary') selected @endif>{{ __('Primary') }}
                            </option>
                            <option value="dark" @if ($formStatus->color == 'dark') selected @endif>{{ __('Dark') }}
                            </option>
                            <option value="secondory" @if ($formStatus->color == 'secondory') selected @endif>
                                {{ __('Secondory') }}</option>

                        </select>
                    </div>
                    <div class="form-group">
                        {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                        {!! Form::hidden('status', null, ['id' => 'status-hidden']) !!}
                        <select name="status" class="custom_select form-select select2" id="status" data-trigger>
                            <option value="" selected disabled>{{ __('Select Status') }}</option>
                            <option value="1" @if ($formStatus->status == '1') selected @endif>{{ __('Active') }}
                            </option>
                            <option value="0" @if ($formStatus->status == '0') selected @endif>{{ __('Deactive') }}
                            </option>
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

{!! Form::model($formStatus, [
    'route' => ['form-status.update', $formStatus->id],
    'method' => 'put',
    'data-validate',
]) !!}

<div class="modal-body">
    <div class="form-group">
        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
        {!! Form::text('name', null, ['placeholder' => __('Enter name'), 'class' => 'form-control', 'required']) !!}
    </div>
    <div class="form-group">
        {{ Form::label('color', __('Color'), ['class' => 'form-label']) }}
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
        <select name="status" class="custom_select form-select select2" id="status" data-trigger>
            <option value="" selected disabled>{{ __('Select Status') }}</option>
            <option value="1" @if ($formStatus->status == '1') selected @endif>{{ __('Active') }}
            </option>
            <option value="0" @if ($formStatus->status == '0') selected @endif>{{ __('Deactive') }}
            </option>
        </select>
    </div>
</div>
<div class="modal-footer">
    <div class="text-end">
        {!! Html::link(route('form-status.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    </div>
</div>
{!! Form::close() !!}

