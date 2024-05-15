@php
$users = \Auth::user();
$currantLang = $users->currentLanguage();
@endphp
@extends('layouts.main')
@section('title', 'Create Language')
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Create Language') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('manage.language', [$currantLang]),__('Languages'),[]) !!}</li>
            <li class="breadcrumb-item active">{{ __('Create Language') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        {!! Form::open([
            'route' => ['store.language'],
            'method' => 'POST',
            'class' => 'form-horizontal',
            'data-validate',
        ]) !!}
        <div class="row">
            <div class="mx-auto col-xl-4 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Create Language') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::label('code', __('Language Code'), ['class' => 'form-label']) }}
                                        {{ Form::text('code', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter language code']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-end">
                            {!! Html::link(route('manage.language', [$currantLang]),__('Cancel'),['class'=>'btn btn-secondary mr-1']) !!}
                            {!! Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
