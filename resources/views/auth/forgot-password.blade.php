@php
    $languages = \App\Facades\UtilityFacades::languages();
    config([
        'captcha.sitekey' => Utility::getsettings('recaptcha_key'),
        'captcha.secret' => Utility::getsettings('recaptcha_secret'),
    ]);
@endphp
@extends('layouts.app')
@section('title', __('Forgot Password'))
@section('auth-topbar')
    <li class="language-btn">
        <select class="btn btn-primary me-2 nice-select"
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
            id="language">
            @foreach ($languages as $language)
                <option class="" @if ($lang == $language) selected @endif
                    value="{{ route('change.lang', $language) }}">{{ Str::upper($language) }}
                </option>
            @endforeach
        </select>
    </li>
@endsection
@section('content')
<div class="login-page-wrapper">
    <div class="login-container">
        <div class="login-row d-flex">
            <div class="login-col-6">
                <div class="login-content-inner">
                    <div class="login-title">
                        <h3>{{ __('Forgot Password') }}</h3>
                    </div>
                    {!! Form::open([
                        'route' => 'password.email',
                        'method' => 'POST',
                        'class' => 'needs-validation',
                        'data-validate',
                    ]) !!}
                    <div class="form-group">
                        {{ Form::label('email', __('E-mail address'), ['class' => 'form-label']) }}
                        {!! Form::email('email', null, [
                            'class' => 'form-control',
                            'id' => 'email',
                            'placeholder' => __('E-mail Address'),
                            'tabindex' => '1',
                            'required',
                            'autocomplete' => 'email',
                            'autofocus',
                        ]) !!}
                    </div>
                    @if (Utility::getsettings('login_recaptcha_status') == '1')
                        <div class="my-3 text-center">
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}
                        </div>
                    @endif
                    <div class="text-center d-flex justify-content-center align-items-center">
                        {{ Form::button(__('Email Password Reset Link'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                        <a href="{{ route('home') }}" class="ml-2 text-white btn btn-secondary">{{ __('Back') }}</a>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
            <div class="login-media-col">
                <div class="login-media-inner">
                    <img src="{{ Utility::getsettings('login_image')
                        ? Storage::url(Utility::getsettings('login_image'))
                        : asset('assets/images/auth/img-auth-3.svg') }}"
                        class="img-fluid" />
                    <h3>
                        {{ Utility::getsettings('login_title') ? Utility::getsettings('login_title') : 'Attention is the new currency' }}
                    </h3>
                    <p>
                        {{ Utility::getsettings('login_subtitle') ? Utility::getsettings('login_subtitle') : 'The more effortless the writing looks, the more effort the writer actually put into the process.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

