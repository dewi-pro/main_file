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
            <li class="breadcrumb-item active"> {{ __('Edit Module') }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
            {!! Form::open([
                'route' => ['module.update', $module->id],
                'method' => 'PUT',
                'class' => 'form-horizontal',
            ]) !!}
            <div class="row">
                <div class="col-xl-12 order-xl-1">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-4 heading-small text-muted">{{ __('Edit Module') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {{ Form::label('name', __('First of Module'), ['class' => 'form-label']) }}
                                            {{ Form::text('name', $module->name, ['class' => 'form-control', 'placeholder' => 'Enter module name']) }}
                                            @if ($errors->has('module'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('module') }}</strong>
                                                </span>
                                            @endif
                                            {!! Form::hidden('old_name', $module->name, ['class' => 'form-control', 'id' => 'password']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                {!! Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-primary col-md-2 float-end ']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
@endsection
