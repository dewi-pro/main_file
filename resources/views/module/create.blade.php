@extends('layouts.main')
@section('title', __('Module'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Module') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('module.index'), __('Module'), []) !!}</li>
            <li class="breadcrumb-item active"> {{ __('Create') }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        {!! Form::open([
            'route' => ['module.store'],
            'method' => 'POST',
            'class' => 'form-horizontal',
        ]) !!}
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-4 heading-small text-muted">{{ __('Create Module') }}</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::label('name', __('Role'), ['class' => 'form-label']) }}
                                        {!! Form::text('name', null, [
                                            'class' => 'form-control',
                                            'id' => 'password',
                                            'placeholder' => __('Enter module namee'),
                                        ]) !!}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('name', __('Permission'), ['class' => 'form-label']) }}
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            {!! Form::checkbox('permissions[]', 'M', null, ['class' => 'custom-control-input', 'id' => 'managepermission']) !!}
                                            {{ Form::label('managepermission', __('Manage'), ['class' => 'form-label custom-control-label']) }}
                                        </div>
                                        <div class="custom-control custom-checkbox custom-control-inline ">
                                            {!! Form::checkbox('permissions[]', 'C', null, ['class' => 'custom-control-input', 'id' => 'createpermission']) !!}
                                            {{ Form::label('createpermission', __('Create'), ['class' => 'form-label custom-control-label']) }}
                                        </div>
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            {!! Form::checkbox('permissions[]', 'E', null, ['class' => 'custom-control-input', 'id' => 'editpermission']) !!}
                                            {{ Form::label('editpermission', __('Edit'), ['class' => 'form-label custom-control-label']) }}
                                        </div>
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            {!! Form::checkbox('permissions[]', 'D', null, ['class' => 'custom-control-input', 'id' => 'deletepermission']) !!}
                                            {{ Form::label('deletepermission', __('Delete'), ['class' => 'form-label custom-control-label']) }}
                                        </div>
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            {!! Form::checkbox('permissions[]', 'S', null, ['class' => 'custom-control-input', 'id' => 'showpermission']) !!}
                                            {{ Form::label('showpermission', __('Show'), ['class' => 'form-label custom-control-label']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            {!! Html::link(route('module.index'), __('Cancel'), ['class'=>'btn btn-secondary']) !!}
                            {!! Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-primary col-md-2 float-end ']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
