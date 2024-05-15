@extends('layouts.main')
@section('title', __('Create Faq'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Create Faq') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('faqs.index'), __('Faqs'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Create Faq') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="section-body">
            <div class="col-md-6 m-auto">
                <div class="card ">
                    <div class="card-header">
                        <h5> {{ __('Create Faq') }}</h5>
                    </div>
                    {!! Form::open(['route' => 'faqs.store', 'method' => 'Post', 'data-validate']) !!}
                    <div class="card-body">
                        <div class="form-group ">
                            {{ Form::label('questions', __('questions'), ['class' => 'form-label']) }}
                            {!! Form::text('questions', null, ['class' => 'form-control', ' required', 'placeholder' => __('Enter questions')]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('answer', __('Answer'), ['class' => 'form-label']) }}
                            {!! Form::textarea('answer', null, [
                                'class' => 'form-control',
                                'data-trigger',
                                'required',
                                'placeholder' => __('Enter answer Address'),
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('order', __('Order'), ['class' => 'form-label']) }}
                            {!! Form::number('order', null, ['placeholder' => __('Enter order'), 'class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-flt float-end mb-3">
                            {!! Html::link(route('faqs.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
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
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('answer', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
