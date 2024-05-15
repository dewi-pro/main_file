@php
    $languages = \App\Facades\UtilityFacades::languages();
    config([
        'captcha.sitekey' => Utility::getsettings('recaptcha_key'),
        'captcha.secret' => Utility::getsettings('recaptcha_secret'),
    ]);
    $roles = App\Models\Role::whereNotIn('name', ['Super Admin', 'Admin'])
        ->pluck('name', 'name')
        ->all();
@endphp
@extends('layouts.app')
@section('title', __('Sign Up'))
@section('auth-topbar')
    <li class="language-btn">
        <select class="my-1 btn btn-primary me-2 nice-select"
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
                    <div class="login-content-inner register-form">
                        <div class="login-title">
                            <h3>{{ __('Sign Up') }}</h3>
                        </div>
                        {{ Form::open(['route' => ['register'], 'method' => 'POST', 'data-validate']) }}
                        <div class="mb-3 form-group">
                            {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                            {!! Form::text('name', old('name'), [
                                'class' => 'form-control',
                                'placeholder' => __('Enter name'),
                                'required',
                                'id' => 'name',
                                'autocomplete' => 'name',
                                'autofocus',
                            ]) !!}
                        </div>
                        <div class="mb-3 form-group">
                            {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
                            {!! Form::email('email', old('email'), [
                                'class' => 'form-control',
                                'placeholder' => __('Enter email'),
                                'required',
                                'id' => 'email',
                                'autocomplete' => 'email',
                                'autofocus',
                            ]) !!}
                        </div>
                        <div class="mb-3 form-group">
                            {{ Form::label('password', __('Password'), ['class' => 'form-label']) }}
                            {!! Form::password('password', [
                                'class' => 'form-control',
                                'placeholder' => __('Enter password'),
                                'required',
                                'id' => 'password',
                                'autocomplete' => 'new-password',
                                'autofocus',
                            ]) !!}
                        </div>
                        <div class="mb-3 form-group">
                            {{ Form::label('password_confirmation', __('Confirm Password'), ['class' => 'form-label']) }}
                            {!! Form::password('password_confirmation', [
                                'class' => 'form-control',
                                'placeholder' => __('Enter confirm password'),
                                'required',
                                'id' => 'password-confirm',
                                'autocomplete' => 'new-password',
                                'autofocus',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('country_code', __('Country Code'), ['class' => 'd-block form-label']) }}
                            <select id="country_code" name="country_code"class="form-control" data-trigger>
                                @foreach (\App\Core\Data::getCountriesList() as $key => $value)
                                    <option data-kt-flag="{{ $value['flag'] }}" value="{{ $key }}">
                                        +{{ $value['phone_code'] }} {{ $value['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 form-group">
                            {{ Form::label('phone', __('Phone Number'), ['class' => 'form-label']) }}
                            {!! Form::number('phone', null, [
                                'autofocus' => '',
                                'required' => true,
                                'autocomplete' => 'off',
                                'placeholder' => 'Enter phone Number',
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        @if (Utility::getsettings('login_recaptcha_status') == '1')
                            <div class="my-3 text-center">
                                {!! NoCaptcha::renderJs() !!}
                                {!! NoCaptcha::display() !!}
                            </div>
                        @endif
                        <div class="d-grid">
                            {!! Form::button(__('Register'), ['type' => 'submit', 'class' => 'btn btn-primary btn-block mt-3']) !!}
                        </div>
                        {{ Form::close() }}
                        <div class="create_user mt-4 text-center text-muted">
                            {{ __('Already have an account?') }}
                            <a href="{{ route('login') }}">{{ __('Sign In') }}</a>
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
@push('script')
    <script>
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

