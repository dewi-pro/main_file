@extends('layouts.main')
@section('title', __('Edit Bookings'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Edit Bookings') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('bookings.index'), __('Bookings'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Edit Booking') }}</li>
        </ul>
    </div>
@endsection
@section('content')
<div class="row">
    <div class="section-body">
        <div class="m-auto col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5> {{ __('Edit Booking') }}</h5>
                </div>
                {!! Form::model($booking, [
                    'route' => ['bookings.update', $booking->id],
                    'method' => 'patch',
                    'enctype' => 'multipart/form-data',
                    'data-validate',
                ]) !!}
                @method('put')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-4 text-center">
                                @if (isset($booking->business_logo))
                                    <img src="{{ Storage::url($booking->business_logo) }}" width="100" height="100" class="img-fluid rounded-circle" alt="Business Logo">
                                @endif
                            </div>
                            <div class="form-group">
                                {{ Form::label('business_logo', __('Business Logo'), ['class' => 'form-label']) }}
                                {!! Form::file('business_logo', ['class' => 'form-control', 'id' => 'business_logo']) !!}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('business_name', __('Business Name'), ['class' => 'form-label']) }}
                                        {!! Form::text('business_name', null, [
                                            'class' => 'form-control',
                                            'required',
                                            'placeholder' => __('Enter business name'),
                                        ]) !!}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('business_email', __('Business Email'), ['class' => 'form-label']) }}
                                        {!! Form::text('business_email', null, [
                                            'class' => 'form-control',
                                            'required',
                                            'placeholder' => __('Enter business email'),
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('business_website', __('Business Website URL'), ['class' => 'form-label']) }}
                                        {!! Form::text('business_website', null, [
                                            'class' => 'form-control',
                                            'required',
                                            'placeholder' => __('Enter business website url'),
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('business_address', __('Business Address'), ['class' => 'form-label']) }}
                                    {!! Form::textarea('business_address', null, [
                                        'class' => 'form-control',
                                        'required',
                                        'rows' => 3,
                                        'placeholder' => __('Enter business address'),
                                    ]) !!}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('business_number', __('Business Number'), ['class' => 'form-label']) }}
                                    {!! Form::number('business_number', null, [
                                        'class' => 'form-control',
                                        'required',
                                        'placeholder' => __('Enter business number'),
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('business_phone', __('Business Phone'), ['class' => 'form-label']) }}
                                    <input class="form-control" required placeholder="{{ __('Enter business phone') }}"
                                        name="business_phone" value="{{ $booking->business_phone }}" type="tel" id="business_phone">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="mb-3 btn-flt float-end">
                        {!! Html::link(route('bookings.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
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
    <script>
        var genericExamples = document.querySelectorAll('[data-trigger]');
        for (i = 0; i < genericExamples.length; ++i) {
            var element = genericExamples[i];
            new Choices(element, {
                placeholderValue: 'This is a placeholder set in the config',
                searchPlaceholderValue: 'This is a search placeholder',
            });
        }
    </script>
@endpush
