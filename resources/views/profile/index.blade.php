@extends('layouts.main')
@section('title', 'Profile')
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Profile') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item"> {{ __('Profile') }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#useradd-1" class="list-group-item list-group-item-action">{{ __('Profile') }}
                                <div class="float-end"></div>
                            </a>
                            <a href="#useradd-2" class="list-group-item list-group-item-action">{{ __('Basic Info') }}
                                <div class="float-end"></div>
                            </a>
                            <a href="#useradd-3" class="list-group-item list-group-item-action">{{ __('Login Details') }}
                                <div class="float-end"></div>
                            </a>
                            @if (setting('2fa') == '1')
                                <a href="#useradd-4" class="list-group-item list-group-item-action">{{ __('2FA') }}
                                    <div class="float-end"></div>
                                </a>
                            @endif
                            <a href="#useradd-5" class="list-group-item list-group-item-action">{{ __('Delete Account') }}
                                <div class="float-end"></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div id="useradd-1" class="text-white card bg-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    <img src="{{ Storage::exists($user->avatar) ? Storage::url($user->avatar) : $user->avatar_image }}"
                                        class="img-user wid-80 rounded-circle">
                                </div>
                                <div class="d-block d-sm-flex align-items-center justify-content-between w-100">
                                    <div class="mb-3 mb-sm-0">
                                        <h4 class="mb-1 text-white">{{ $user->name }}</h4>
                                        <h4 class="mb-1 text-white">{{ $user->email }}</h4>
                                        <p class="mb-0 text-sm">{{ $role ? $role->name : 'Role Not Set' }}</p>
                                        @if (\Auth::user()->social_type != null)
                                            <p class="mb-0 text-sm"><b>{{ __('Login with:') }}</b>
                                                {{ ucfirst($user->social_type) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="useradd-2" class="card">
                        <div class="card-header">
                            <h5>{{ __('Basic info') }}</h5>
                            <small class="text-muted">{{ __('Mandatory informations') }}</small>
                        </div>
                        {!! Form::open([
                            'route' => 'profile.update.basicinfo',
                            'method' => 'POST',
                            'class' => 'form-horizontal',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        <div class="card-body">
                            <div class="mt-3 row container-fluid">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('fullname', __('Full Name'), ['class' => 'form-label']) }}
                                        {!! Form::text('fullname', $user->name, [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter full name'),
                                        ]) !!}

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('phone', __('Phone'), ['class' => 'form-label']) }}
                                        {!! Form::text('phone', $user->phone, [
                                            'class' => 'form-control',
                                            'placeholder' => __('Enter phone'),
                                        ]) !!}

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('country', __('Country'), ['class' => 'form-label']) }}
                                        {!! Form::select('country', $countries, $user->country, [
                                            'data-trigger',
                                            'class' => 'form-control form-control-inline-block',
                                        ]) !!}

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('address', __('Address'), ['class' => 'form-label']) }}
                                        {!! Form::text('address', $user->address, [
                                            'class' => 'form-control',
                                            'id' => 'address',
                                            'placeholder' => __('Enter address'),
                                        ]) !!}

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('role', __('Role'), ['class' => 'form-label']) }}
                                        {!! Form::text('role', $role ? $role->name : __('Role Not Set'), ['class' => 'form-control', 'disabled']) !!}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('avatarCrop', __('Update Avatar'), ['class' => 'avatar_crop btn btn-primary btn-lg d-block mx-auto col-sm-12 mb-0']) }}
                                        {{ Form::file('avatarCrop', ['class' => 'd-none', 'id' => 'avatarCrop']) }}
                                    </div>
                                    <div id="avatar-updater" class="col-xs-12 d-none">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="image-preview"></div>
                                            </div>
                                            <div class="col-md-12">
                                                {!! Form::text('avatar-url', route('update.avatar'), ['class' => 'd-none']) !!}
                                                {!! Form::button(__('Rotate Image'), [
                                                    'class' => 'btn btn-gradient-info col-sm-12 mb-1',
                                                    'id' => 'rotate-image',
                                                ]) !!}
                                                {!! Form::button(__('Crop Image'), [
                                                    'class' => 'btn btn-gradient-primary col-sm-12',
                                                    'id' => 'crop_image',
                                                ]) !!}
                                                {!! Form::button(__('Cancel'), [
                                                    'class' => 'btn btn-gradient-danger col-sm-12 mt-1',
                                                    'id' => 'avatar-cancel-btn',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-md-12s">
                                {!! Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary col-sm-2 float-end mb-3']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div id="useradd-3" class="card">
                        <div class="card-header">
                            <h5>{{ __('Login Details') }}</h5>
                            <small class="text-muted">{{ __('Login informations') }}</small>
                        </div>
                        {!! Form::open([
                            'route' => 'update.login.details',
                            'method' => 'POST',
                            'class' => 'form-horizontal',
                        ]) !!}
                        <div class="card-body">
                            <div class="mt-3 row container-fluid">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
                                        {!! Form::text('email', $user->email, ['placeholder' => __('Enter email address'), 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('password', __('Password'), ['class' => 'form-label']) }}
                                        {!! Form::password('password', [
                                            'class' => 'form-control',
                                            'placeholder' => __('Leave blank if you dont want to change'),
                                            'autocomplete' => 'off',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('password_confirmation', __('Confirm Password'), ['class' => 'form-label']) }}
                                        {!! Form::password('password_confirmation', [
                                            'class' => 'form-control',
                                            'placeholder' => __('Leave blank if you dont want to change'),
                                            'autocomplete' => 'off',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-md-12 text-end">
                                {!! Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary col-sm-2 float-end mb-3']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    @if (setting('2fa') == '1')
                        <div id="useradd-4" class="card">
                            <div class="card-header">
                                <div class="float-end">
                                </div>
                                <h5>{{ __('Two-factor authentication') }}</h5>
                            </div>
                            <div class="card-body">
                                <ul class="mt-2 list-group list-group-flush">
                                    @if (extension_loaded('imagick') && setting('2fa'))
                                        <div class="tab-pane" id="tfa-settings" role="tabpanel"
                                            aria-labelledby="tfa-settings-tab">
                                            <!--Google Two Factor Authentication card-->
                                            <div class="col-md-12">
                                                @if (empty(auth()->user()->loginSecurity))
                                                    <!--=============Generate QRCode for Google 2FA Authentication=============-->
                                                    <div class="p-0 row">
                                                        <div class="col-md-12">
                                                            <p>{{ __('To activate Two factor Authentication Generate QRCode') }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-12">
                                                            {!! Form::open([
                                                                'route' => ['generate2faSecret'],
                                                                'method' => 'POST',
                                                                'class' => 'tfa-form',
                                                            ]) !!}
                                                            {{ Form::button(__('Activate 2FA'), ['type' => 'submit', 'class' => 'btn btn-primary col-md-6']) }}
                                                        </div>
                                                        <hr>
                                                        <h3 class="">
                                                            {{ __('Two Factor Authentication(2FA) Setup Instruction') }}
                                                        </h3>
                                                        <hr>
                                                        <div class="mt-4 ">
                                                            <h4>{{ __('Below is a step by step instruction on setting up Two Factor Authentication') }}
                                                            </h4>
                                                            <p><label>{{ __('Step 1') }}:</label>
                                                                {{ __('Download') }}
                                                                <strong>{{ __('Google Authenticator App') }}</strong>
                                                                {{ __('Application for Andriod or iOS') }}
                                                            </p>
                                                            <p class="text-center">
                                                                <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en"
                                                                    target="_blank"
                                                                    class="btn btn-success">{{ __('Download for Andriod') }}<i
                                                                        class="fa fa-android fa-2x ms-1"></i></a>
                                                                <a href="https://apps.apple.com/us/app/google-authenticator/id388497605"
                                                                    target="_blank"
                                                                    class="btn btn-dark ms-1">{{ __('Download for iPhones') }}<i
                                                                        class="fa fa-apple fa-2x ms-1"></i></a>
                                                            </p>
                                                            <p><label>{{ __('Step 2') }}:</label>
                                                                {{ __('Click on Generate Secret Key on the platform to generate a QRCode') }}
                                                            </p>
                                                            <p><label>{{ __('Step 3') }}:</label>
                                                                {{ __('Open the') }}
                                                                <strong>{{ __('Google Authenticator App') }}</strong>
                                                                {{ __('and clcik on') }}
                                                                <strong>{{ __('Begin') }}</strong>
                                                                {{ __('on the mobile app') }}
                                                            </p>
                                                            <p><label>{{ __('Step 4') }}:</label>
                                                                {{ __('After which click on') }}
                                                                <strong>{{ __('Scan a QRcode') }}</strong>
                                                            </p>
                                                            <p><label>{{ __('Step 5') }}:</label>
                                                                {{ __('Then scan the barcode on the platform') }}
                                                            </p>
                                                            <p><label>{{ __('Step 6') }}:</label>
                                                                {{ __('Enter the verification code generated on the platform and Enable 2FA') }}
                                                            </p>
                                                            <hr>
                                                            <p><label>{{ __('Note') }}:</label>
                                                                {{ __('To disable 2FA enter code from the Google Authenticator App and account password to disable 2FA') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!--=============Generate QRCode for Google 2FA Authentication=============-->
                                                @elseif(!auth()->user()->loginSecurity->google2fa_enable)
                                                    <!--=============Enable Google 2FA Authentication=============-->
                                                    {!! Form::open([
                                                        'route' => ['enable2fa'],
                                                        'method' => 'POST',
                                                        'class' => 'form-horizontal',
                                                    ]) !!}
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <p><strong>{{ __('Scan the QRCode with') }}
                                                                    <dfn>{{ __('Google Authenticator App') }}</dfn>
                                                                    {{ __('Enter the generated code below') }}</strong>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-12">
                                                            @if (!extension_loaded('imagick'))
                                                                {!! $google2fa_url !!}
                                                            @else
                                                                <img src="{{ $google2fa_url }}" />
                                                            @endif
                                                        </div>
                                                        <div class="col-md-12">
                                                            <p>{{ __('To enable 2-Factor Authentication verify QRCode') }}
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            {{ Form::label('secret', __('Verification code'), ['class' => 'form-label']) }}
                                                            {!! Form::password('secret', [
                                                                'class' => 'form-control',
                                                                'id' => 'code',
                                                                'placeholder' => __('Enter verification code'),
                                                                'required',
                                                            ]) !!}

                                                            @if ($errors->has('verify-code'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('verify-code') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="mt-2 col-md-12 text-end">
                                                        {{ Form::button(__('Enable 2FA'), ['type' => 'submit', 'class' => 'btn btn-primary col-sm-2']) }}
                                                    </div>
                                                    {!! Form::close() !!}

                                                    <!--=============Enable Google 2FA Authentication=============-->
                                                @elseif(auth()->user()->loginSecurity->google2fa_enable)
                                                    <!--=============Disable Google 2FA Authentication=============-->
                                                    {!! Form::open([
                                                        'route' => ['disable2fa'],
                                                        'method' => 'POST',
                                                        'class' => 'form-horizontal',
                                                    ]) !!}
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            @if (!extension_loaded('imagick'))
                                                                {!! $google2fa_url !!}
                                                            @else
                                                                <img src="{{ $google2fa_url }}" />
                                                            @endif
                                                        </div>
                                                        <div class="col-md-12">
                                                            <p>{{ __('To disable 2-Factor Authentication verify QRCode') }}
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            {{ Form::label('current-password', __('Current Password'), ['class' => 'form-label']) }}
                                                            {!! Form::password('current-password', [
                                                                'class' => "form-control $errors->has('password') ? ' is-invalid' : ''",
                                                                'placeholder' => __('Enter current password'),
                                                                'required',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="col-md-12 text-end">
                                                        {{ Form::button(__('Disable 2FA'), ['type' => 'submit', 'class' => 'btn btn-danger col-sm-2']) }}
                                                    </div>
                                                    {!! Form::close() !!}

                                                    <!--=============Disable Google 2FA Authentication=============-->
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endif
                    <div id="useradd-5" class="card">
                        <div class="card-header">
                            <h5>{{ __('Delete Account') }}</h5>
                            <small
                                class="text-muted">{{ __('Once you delete your account, there is no going back. Please be certain.') }}</small>
                        </div>
                        <div class="card-footer">
                            <div class="mb-3 col-sm-auto text-sm-end d-flex float-end">
                                @if ($user->active_status == 1)
                                    {!! Html::link('profile-status', __('Deactivate'), [
                                        'class' => 'btn btn-outline-secondary  d-flex me-3 float-end',
                                    ]) !!}
                                @endif
                                {!! Form::open([
                                    'method' => 'DELETE',
                                    'route' => ['users.destroy', $user->id],
                                    'id' => 'delete-form-' . $user->id,
                                ]) !!}
                                <a class="btn btn-danger show_confirm d-flex" data-toggle="tooltip"
                                    href="#!">{{ __('Delete Account') }}<i
                                        class="ti ti-chevron-right ms-1 ms-sm-2"></i></a>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
        <!-- [ sample-page ] end -->
    </div>
    <!-- [ Main Content ] end -->
    </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('vendor/js/plugins/croppie/css/croppie.min.css') }}">
@endpush
@push('script')
    <script src="{{ asset('vendor/js/plugins/croppie/js/croppie.min.js') }}"></script>
    <script src="{{ asset('vendor/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            window.setTimeout(function() {}, 9e3), $image_crop = $(".image-preview").croppie({
                enableExif: !0,
                enforceBoundary: !1,
                enableOrientation: !0,
                viewport: {
                    width: 200,
                    height: 200,
                    type: "square"
                },
                boundary: {
                    width: 300,
                    height: 300
                }
            }), $(" #avatarCrop").change(function() {
                $("#avatar-holder").addClass("d-none"), $("#avatar-updater").removeClass("d-none");
                var e = new FileReader;
                e.onload = function(e) {
                    $image_crop.croppie("bind", {
                        url: e.target.result
                    })
                }, e.readAsDataURL(this.files[0])
            }), $("#toggleClose").click(function() {
                $("#toggleClose").css("display", "none"), $(".app-logo").css("display", "none"), $(
                    ".toggleopen").css("display", "block")
            }), $(".toggleopen").click(function() {
                $(".toggleopen").css("display", "none"), $(".app-logo").css("display", "block"), $(
                    "#toggleClose").css("display", "block")
            }), $("#rotate-image").click(function(e) {
                $image_crop.croppie("rotate", 90)
            }), $("#crop_image").click(function() {
                $image_crop.croppie("result", {
                    type: "canvas",
                    size: "viewport"
                }).then(function(e) {
                    var a = $("input[name=avatar-url]").val(),
                        t = $('meta[name="csrf-token"]').attr("content"),
                        o = $("#crop_image");
                    o.html("Saving Avatar..."), o.attr("disabled", "disabled"), $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        }
                    }), $.ajax({
                        url: a,
                        type: "POST",
                        data: {
                            avatar: e,
                            _token: t
                        },
                        dataType: "json",
                        success: function(e) {},
                        complete: function(e) {
                            new swal({
                                text: e.responseText,
                                icon: "success"
                            }).then(() => {
                                location.reload()
                            })
                        }
                    })
                })
            }), $("#avatar-cancel-btn").click(function() {
                $("#avatar-holder").removeClass("d-none"), $("#avatar-updater").addClass("d-none")
            });
            $("#backup-file-btn").click(function() {
                swal({
                    text: "Application file backup is disabled by administrator.",
                    icon: 'error',
                });
            });
            $("#backup-database-btn").click(function() {
                swal({
                    text: "Database backup is disabled by administrator.",
                    icon: 'error',
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'This is a placeholder set in the config',
                    searchPlaceholderValue: 'This is a search placeholder.',
                });
            }
        });
    </script>
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 200
        })
    </script>
@endpush
