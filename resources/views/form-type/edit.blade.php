{{-- @extends('layouts.main')
@section('title', 'Create Type')
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Create Type') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item"><a href="{{ route('form-type.index') }}">{{ __('Type') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Create Type') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-6 col-lg-8 col-sm-12 col-12 m-auto">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Create Type') }}</h5>
                    {!! Form::model($formType, [
                        'route' => ['form-type.update', $formType->id],
                        'method' => 'put',
                        'data-validate',
                    ]) !!}
                </div>
                <div class="card-body">
                    <div class="form-group">
                        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                        {!! Form::text('name', null, ['placeholder' => __('Enter name'), 'class' => 'form-control', 'required']) !!}
                    </div>
                    <!-- <div class="form-group">
                        {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                        <select name="status" class="custom_select form-select" id="status" data-trigger>
                            <option value="" disabled>{{ __('Select Type Status') }}</option>
                            <option value="1" @select('1' == $formType)>{{ __('Active') }}</option>
                            <option value="2" @select('2' == $formType)>{{ __('Deactive') }}</option>
                        </select>
                    </div> -->
                </div>
                <div class="card-footer">
                    <div class="text-end">
                        {!! Html::link(route('form-type.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
                        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection --}}
{!! Form::model($formType, [
    'route' => ['form-type.update', $formType->id],
    'method' => 'put',
    'data-validate',
]) !!}
</div>
<div class="modal-body">
    <div class="form-group">
        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
        {!! Form::text('name', null, ['placeholder' => __('Enter name'), 'class' => 'form-control', 'required']) !!}
    </div>
    <!-- <div class="form-group">
        {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
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
    </div> -->
</div>
<div class="modal-footer">
    <div class="text-end">
        {!! Html::link(route('form-type.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    </div>
</div>
{!! Form::close() !!}
</div>
