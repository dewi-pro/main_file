



@php
    $languages = \App\Facades\UtilityFacades::languages();
    config([
        'captcha.sitekey' => Utility::getsettings('recaptcha_key'),
        'captcha.secret' => Utility::getsettings('recaptcha_secret'),
    ]);
@endphp
@extends('layouts.app')
@section('title', __('Two Factor Authentication'))
{{-- @section('auth-topbar')
    <li class="language-btn">
        <select class="btn btn-primary me-2 nice-select"
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
            id="language">
            @foreach ($languages as $language)
                <option class="" @if ($lang == $language) selected @endif
                    value="{{ route('login', $language) }}">{{ Str::upper($language) }}
                </option>
            @endforeach
        </select>
    </li>
@endsection --}}
@section('content')
    <div class="login-page-wrapper">
        <div class="login-container">
            <div class="login-row d-flex">
                <div class="login-col-6">
                    <div class="login-content-inner">
                        <div class="login-title">
                            <h3>{{ __('Two Factor Authentication') }}</h3>
                        </div>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="text-start">
                        {!! Form::open([
                            'route' => ['2fa'],
                            'method' => 'POST',
                            'data-validate',
                            'class' => 'form-horizontal',
                        ]) !!}
                        <div class="mb-3 form-group">
                            {{ Form::label('one_time_password', __('One time Password'), ['class' => 'form-label mb-2']) }}
                            {{ Form::text('one_time_password', old('one_time_password'), ['class' => 'form-control', 'onfocus', 'required', 'id' => 'one_time_password']) }}
                            @if ($errors->has('email'))
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            @if ($errors->has('one_time_password'))
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('one_time_password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="text-center">
                            {!! Form::button(__('Click And Verify'), ['type' => 'submit','class' => 'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
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
