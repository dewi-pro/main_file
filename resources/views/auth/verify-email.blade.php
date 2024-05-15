@php
    $languages = \App\Facades\UtilityFacades::languages();
@endphp
@extends('layouts.app')
@section('title', __('Email verify'))
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
                            <h3>{{ __('Verify Your Email Address') }}</h3>
                        </div>
                        @if (session('status') == 'verification-link-sent')
                            <div class="custom-alert custom-alert-danger" role="alert">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </div>
                        @endif
                        <br>
                        <p>{{ __('Before proceeding, please check your email for a verification link.') }}
                            {{ __('If you did not receive the email') }},</p>
                        <br>
                        <div class="text-center">
                            <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit"
                                    class="mt-2 btn btn-link">{{ __('Resend Verification Email') }}</button>
                            </form>
                        </div>
                        <div class="text-center d-flex justify-content-center align-items-center">
                            <p class="my-3 mt-2 text-center verify">
                                <a onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                    class="btn btn-link">{{ __('Logout') }}</a>
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
