@extends('layouts.main')
@section('title', 'Create Category')
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Edit Category') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item"><a href="{{ route('blog-category.index') }}">{{ __('Blog Category') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Edit Category') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-6 col-lg-8 col-sm-12 col-12 m-auto">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Edit Category') }}</h5>
                    {!! Form::model($category, [
                        'route' => ['blog-category.update', $category->id],
                        'method' => 'PUT',
                        'data-validate',
                    ]) !!}
                </div>
                <div class="card-body">
                    <div class="form-group">
                        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                        {!! Form::text('name', null, ['placeholder' => __('Enter name'), 'class' => 'form-control', 'required']) !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                        {!! Form::select('status', ['1' => 'Active', '0' => 'Deactive'], $category->status, [
                            'class' => 'form-select',
                            'data-trigger',
                        ]) !!}
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-end">
                        {!! Html::link(route('blog-category.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
                        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
