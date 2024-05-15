@extends('layouts.main')
@section('title', __('Landing Page'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Recaptcha Setting') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Recaptcha Setting') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            @include('landing-page.landingpage-sidebar')
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="card">
                            <div class="tab-pane fade show active" id="apps-setting" role="tabpanel"
                                aria-labelledby="landing-apps-setting">
                                {!! Form::open([
                                    'route' => ['landing.captcha.store'],
                                    'method' => 'Post',
                                    'id' => 'froentend-form',
                                    'data-validate',
                                    'no-validate',
                                ]) !!}
                                <div class="card-header">
                                    <h5> {{ __('Captcha Setting') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="contact_us_recaptcha_status">{{ __('Contact Us Recaptcha Status') }}</label>
                                                <label class="mt-2 form-switch float-end custom-switch-v1">
                                                    {!! Form::checkbox(
                                                        'contact_us_recaptcha_status',
                                                        null,
                                                        Utility::getsettings('contact_us_recaptcha_status') ? true : false,
                                                        [
                                                            'class' => 'form-check-input input-primary',
                                                            'id' => 'contact_us_recaptcha_status',
                                                        ],
                                                    ) !!}
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="login_recaptcha_status">{{ __('LogIn Recaptcha Status') }}</label>
                                                <label class="mt-2 form-switch float-end custom-switch-v1">
                                                    {!! Form::checkbox(
                                                        'login_recaptcha_status',
                                                        null,
                                                        Utility::getsettings('login_recaptcha_status') ? true : false,
                                                        [
                                                            'class' => 'form-check-input input-primary',
                                                            'id' => 'login_recaptcha_status',
                                                        ],
                                                    ) !!}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {{ Form::label('recaptcha_key', __('Recaptcha Key'), ['class' => 'col-form-label']) }}
                                                {!! Form::text('recaptcha_key', Utility::getsettings('recaptcha_key'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter recaptcha key'),
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {{ Form::label('recaptcha_secret', __('Recaptcha Secret'), ['class' => 'col-form-label']) }}
                                                {!! Form::text('recaptcha_secret', Utility::getsettings('recaptcha_secret'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter recaptcha secret'),
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary float-end mb-3']) }}
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
