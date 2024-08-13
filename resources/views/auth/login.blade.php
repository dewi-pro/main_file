@php
    $languages = \App\Facades\UtilityFacades::languages();
    config([
        'captcha.sitekey' => Utility::getsettings('recaptcha_key'),
        'captcha.secret' => Utility::getsettings('recaptcha_secret'),
    ]);
@endphp
@extends('layouts.app')
@section('title', __('Sign in'))
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
                    <div class="login-content-inner ">
                        <div class="login-title">
                            <h3>{{ __('Sign In') }}</h3>
                        </div>
                        {{ Form::open(['route' => ['login'], 'method' => 'POST', 'data-validate', 'class' => 'needs-validation']) }}
                        <div class="mb-3 form-group">
                            {{ Form::label('email', __('Email'), ['class' => 'form-label mb-2']) }}
                            {!! Form::email('email', old('email'), [
                                'class' => 'form-control',
                                'id' => 'email',
                                'placeholder' => __('Enter email address'),
                                'onfocus',
                                'required',
                            ]) !!}
                        </div>
                        <div class="mb-3 form-group">
                            <div class="col-md-12">
                                {{ Form::label('password', __('Enter Password'), ['class' => 'form-label']) }}
                                <!-- {!! Html::link(route('password.request'), __('Forgot Password ?'), ['class' => 'float-end forget-password']) !!} -->
                                {!! Form::password('password', [
                                    'class' => 'form-control',
                                    'placeholder' => __('Enter password'),
                                    'required',
                                    'tabindex' => '2',
                                    'id' => 'password',
                                    'autocomplete' => 'current-password',
                                ]) !!}
                            </div>
                        </div>
                        @if (Utility::getsettings('login_recaptcha_status') == '1')
                            <div class="my-3 text-center">
                                {!! NoCaptcha::renderJs() !!}
                                {!! NoCaptcha::display() !!}
                            </div>
                        @endif
                        <div class="d-grid">
                            {!! Form::button(__('Sign In'), ['type' => 'submit', 'class' => 'btn btn-primary login-do-btn btn-block mt-3']) !!}
                        </div>
                        {{ Form::close() }}
                        <div class="register-option">
                            @if (Utility::getsettings('register') == 1)
                                <div class="create_user text-center ">
                                    {{ __('Do not have an account?') }}
                                    <a href="{{ route('register') }}">{{ __('Create One') }}</a>
                                </div>
                            @endif
                        </div>
                        <div class="social-media-icon">
                            @if (Utility::getsettings('GOOGLESETTING') == 'on' ||
                                    Utility::getsettings('FACEBOOKSETTING') == 'on' ||
                                    Utility::getsettings('GITHUBSETTING') == 'on')
                                <div class="mt-1 mb-4 row">
                                    @if (Utility::getsettings('GOOGLESETTING') == 'on' ||
                                            Utility::getsettings('FACEBOOKSETTING') == 'on' ||
                                            Utility::getsettings('GITHUBSETTING') == 'on')
                                        <p class="my-3 text-center register-link">{{ __('or register with') }}</p>
                                    @endif
                                    <div class="register-btn-wrapper">
                                        @if (Utility::getsettings('GOOGLESETTING') == 'on')
                                            <div class="col-4">
                                                <div class="d-grid"><a href="{{ url('/redirect/google') }}"
                                                        class="btn btn-light">
                                                        {!! form::image(asset('assets/images/auth/img-google.svg'), null, ['class' => 'img-fluid wid-25']) !!}
                                                    </a></div>
                                            </div>
                                        @endif
                                        @if (Utility::getsettings('FACEBOOKSETTING') == 'on')
                                            <div class="col-4">
                                                <div class="d-grid"><a href="{{ url('/redirect/facebook') }}"
                                                        class="btn btn-light">
                                                        {!! form::image(asset('assets/images/auth/img-facebook.svg'), null, ['class' => 'img-fluid wid-25']) !!}
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                        @if (Utility::getsettings('GITHUBSETTING') == 'on')
                                            <div class="col-4">
                                                <div class="d-grid"><a href="{{ url('/redirect/github') }}"
                                                        class="btn btn-light">
                                                        {!! form::image(asset('assets/images/auth/github.svg'), null, ['class' => 'img-fluid wid-25']) !!}
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="login-media-col">
                    <div class="login-media-inner">
                        <img src="{{ Utility::getsettings('login_image')
                            ? Storage::url(Utility::getsettings('login_image'))
                            : asset('assets/images/auth/img-auth-3.svg') }}"
                            class="img-fluid" />
                        <!-- <h3>
                            {{ Utility::getsettings('login_title') ? Utility::getsettings('login_title') : 'Attention is the new currency' }}
                        </h3>
                        <p>
                            {{ Utility::getsettings('login_subtitle') ? Utility::getsettings('login_subtitle') : 'The more effortless the writing looks, the more effort the writer actually put into the process.' }}
                        </p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
