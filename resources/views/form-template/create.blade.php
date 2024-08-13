@extends('layouts.main')
@section('title', __('Create Form Template'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Create Form Template') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('form-template.index'), __('Form Template'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Create Form Template') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="section-body">
            <div class="m-auto col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5> {{ __('Create Form Template') }}</h5>
                    </div>
                    {!! Form::open([
                        'route' => 'form-template.store',
                        'method' => 'Post',
                        'enctype' => 'multipart/form-data',
                        'data-validate',
                    ]) !!}
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}
                            {!! Form::text('title', null ,['class' => 'form-control', 'required', 'placeholder' => __('Enter title')]) !!}
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <!-- {{ Form::label('assignform', __('Assign Form'), ['class' => 'form-label']) }} -->
                                <div class="assignform" id="assign_form">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    {!! Form::label('assign_type_role', __('Role'), ['class' => 'form-label']) !!}
                                                    <!-- <label class="form-switch custom-switch-v1 ms-2">
                                                        {!! Form::radio('assign_type', 'role', true, [
                                                            'class' => 'form-check-input input-primary',
                                                            'id' => 'assign_type_role',
                                                        ]) !!}
                                                    </label> -->
                                                </div>
                                            </div>
                                            <div id="role" class="desc">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <!-- {{ Form::label('roles', __('Role'), ['class' => 'form-label']) }} -->
                                                            <!-- {!! Form::select('roles', $roles, null, [
                                                                'class' => 'form-control role-remove',
                                                                'id' => 'choices-multiple-remove-button',
                                                                'multiple' => 'multiple',
                                                            ]) !!} -->
                                                            {!! Form::select('roles', $roles, null, ['class' => 'form-select', 'class' => 'form-control', 'required']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="mb-3 btn-flt float-end">
                            {!! Html::link(route('form-template.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
                            {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
