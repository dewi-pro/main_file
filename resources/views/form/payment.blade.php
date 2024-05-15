@extends('layouts.main')
@section('title', __('Form Payment Integration'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="d-flex justify-content-between">
            <div class="previous-next-btn">
                <div class="page-header-title">
                    <h4 class="m-b-10">{{ __('Form Payment Integration') }}</h4>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('forms.index') }}">{{ __('Forms') }}</a></li>
                    <li class="breadcrumb-item"> {{ __('Form Payment Integration') }} </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="m-auto col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Payment Setting') }}</h5>
                </div>
                {!! Form::open([
                    'route' => ['form.payment.integration.store', $form->id],
                    'method' => 'POST',
                    'data-validate',
                ]) !!}
                <div class="card-body">
                    @if ($paymentType)
                        <div class="row">
                            <div class="col-md-8">
                                <b>
                                    {{ Form::label('customswitchv1-1', __('Payment getway (active)'), ['class' => 'd-block ']) }}
                                </b>
                            </div>
                            <div class="mb-3 col-md-4">
                                <div class="form-check form-switch custom-switch-v1 float-end">
                                    {!! Form::checkbox('payment', null, $form->payment_status == '1' ? true : false, [
                                        'id' => 'customswitchv1-1',
                                        'class' => 'form-check-input input-primary',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-lg-12 paymenttype {{ $form->payment_status == '1' ? 'd-block' : 'd-none' }}">
                                <div class="form-group">
                                    {{ Form::label('payment_type', __('Payment Type'), ['class' => 'form-label']) }}
                                    {!! Form::select('payment_type', $paymentType,  $form->payment_type, ['class' => 'form-control', 'data-trigger']) !!}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('amount', __('Amount'), ['class' => 'form-label']) }}
                                    {!! Form::number('amount', $form->amount, [
                                        'id' => 'amount',
                                        'placeholder' => __('Enter amount'),
                                        'class' => 'form-control',
                                    ]) !!}
                                    @if ($errors->has('amount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label('currency_symbol', __('Currency symbol'), ['class' => 'form-label']) }}
                                    {!! Form::text('currency_symbol', $form->currency_symbol, [
                                        'id' => 'currency_symbol',
                                        'placeholder' => __('Enter currency symbol'),
                                        'class' => 'form-control',
                                    ]) !!}
                                    @if ($errors->has('currency_symbol'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('currency_symbol') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{ Form::label('currency_name', __('Currency Name'), ['class' => 'form-label']) }}
                                    {!! Form::text('currency_name', $form->currency_name, [
                                        'id' => 'currency_name',
                                        'placeholder' => __('Enter currency name'),
                                        'class' => 'form-control',
                                    ]) !!}
                                    @if ($errors->has('currency_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('currency_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="text-end">
                        {!! Html::link(route('forms.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
                        {!! Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).on('click', "#customswitchv1-1", function() {
            if (this.checked) {
                $(".paymenttype").fadeIn(500);
                $('.paymenttype').removeClass('d-none');
            } else {
                $(".paymenttype").fadeOut(500);
                $('.paymenttype').addClass('d-none');
            }
        });
    </script>
@endpush
