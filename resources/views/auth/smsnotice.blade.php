@php
    $languages = \App\Facades\UtilityFacades::languages();
    $phone = Auth()->user()->phone;
    $email = Auth()->user()->email;
@endphp
@extends('layouts.app')
@section('title', __('Send Sms Your Number'))
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
                            <h3>{{ __('Send Sms Your Number') }}</h3>
                        </div>
                        <small class="text-muted">{{ __('Send Otp Your Number Click Send Otp Button') }}</small><br />
                        {!! Form::open([
                            'route' => 'sms.noticeverification',
                            'data-validate',
                            'method' => 'POST',
                            'class' => 'form-horizontal',
                        ]) !!}

                        <div class="form-group mb-3">
                            {{ Form::label('phone', __('Phone Number'), ['class' => 'form-label']) }}
                            {!! Form::text('phone', $phone, [
                                'autofocus' => '',
                                'readonly',
                                'required' => true,
                                'autocomplete' => 'off',
                                'placeholder' => 'Enter phone Number',
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <input type="hidden" name="email" value="{{ isset($email) ? $email : $_GET['email'] }}">

                        <div class="d-grid">
                            <button class="btn btn-primary btn-block mt-2" type="submit">{{ __('Send Otp') }}</button>
                        </div>
                        {!! Form::close() !!}
                        <br>
                        <p class="my-4 text-center">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                class="f-w-400">{{ __('Logout') }}</a>
                        </p>
                        {!! Form::open([
                            'route' => 'logout',
                            'method' => 'POST',
                            'id' => 'logout-form',
                            'class' => 'd-none',
                        ]) !!}
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
