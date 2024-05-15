@extends('layouts.main')
@section('title', __('Edit Form Template'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Edit Form Template') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('form-template.index'), __('Form Template'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Edit Testimonial') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="section-body">
            <div class="m-auto col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5> {{ __('Edit Form Template') }}</h5>
                    </div>
                    {!! Form::model($formTemplate, [
                        'route' => ['form-template.update', $formTemplate->id],
                        'method' => 'patch',
                        'enctype' => 'multipart/form-data',
                        'data-validate',
                    ]) !!}
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}
                            {!! Form::text('title', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter title')]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('image', __('Image'), ['class' => 'form-label']) }}
                            {!! Form::file('image', ['class' => 'form-control', 'id' => 'image']) !!}
                            @if (isset($formTemplate->image))
                                <img src="{{ Storage::url($formTemplate->image) }}" width="100"
                                    height="100" class="mt-2">
                            @endif
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
