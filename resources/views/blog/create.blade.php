@extends('layouts.main')
@section('title', 'Create Blog')
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Create Blog') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item"><a href="{{ route('blog-category.index') }}">{{ __('Blog') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Create Blog') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="section-body">
            <div class="m-auto col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5> {{ __('Create Blog') }}</h5>
                    </div>
                    {!! Form::open([
                        'route' => 'blogs.store',
                        'method' => 'Post',
                        'enctype' => 'multipart/form-data',
                        'data-validate',
                    ]) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ Form::label('title', __('Title'), ['class' => 'form-label']) }} *
                                    {!! Form::text('title', null, [
                                        'class' => 'form-control',
                                        'placeholder' => __('Enter title'),
                                        'required' => 'required',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ Form::label('category_id', __('Category'), ['class' => 'form-label']) }}
                                    {!! Form::select('category_id', $categories, null, ['class' => 'form-control', 'required', 'data-trigger']) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ Form::label('images', __('Images'), ['class' => 'form-label']) }} *
                                    {!! Form::file('images', ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('short_description', __('Short Description'), ['class' => 'form-label']) }}
                                    *
                                    {!! Form::textarea('short_description', null, [
                                        'class' => 'form-control ',
                                        'placeholder' => __('Enter short description'),
                                        'required' => 'required',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('description', __('Description'), ['class' => 'form-label']) }} *
                                    {!! Form::textarea('description', null, [
                                        'class' => 'form-control ',
                                        'placeholder' => __('Enter description'),
                                        'required' => 'required',
                                    ]) !!}
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="mb-3 btn-flt float-end">
                            {!! Html::link(route('blogs.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
                            {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('short_description', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('description', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
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
@endpush
