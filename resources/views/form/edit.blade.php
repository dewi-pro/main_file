@extends('layouts.main')
@section('title', __('Form'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="d-flex justify-content-between">
            <div class="previous-next-btn">
                <div class="page-header-title">
                    <h4 class="m-b-10">{{ __('Edit Form') }}</h4>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('forms.index') }}">{{ __('Forms') }}</a></li>
                    <li class="breadcrumb-item"> {{ __('Edit Form') }} </li>
                </ul>
            </div>
            <div class="float-end">
                <div class="d-flex align-items-center">
                    <a href="@if (!empty($previous)) {{ route('forms.edit', [$previous->id]) }}@else javascript:void(0) @endif"
                        type="button" class="btn btn-outline-primary"><i class="me-2"
                            data-feather="chevrons-left"></i>{{ __('Previous') }}</a>
                    <a href="@if (!empty($next)) {{ route('forms.edit', [$next->id]) }}@else javascript:void(0) @endif"
                        class="btn btn-outline-primary ms-1"><i class="me-2"
                            data-feather="chevrons-right"></i>{{ __('Next') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        {{ Form::model($form, ['route' => ['forms.update', $form->id], 'data-validate', 'method' => 'PUT', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) }}
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('General') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label('title', __('Title of form'), ['class' => 'form-label']) }}
                            {!! Form::text('title', $form->title, [
                                'class' => 'form-control',
                                'id' => 'password',
                                'placeholder' => __('Enter title of form'),
                            ]) !!}
                            @if ($errors->has('form'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('form') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('form_logo', __('Select Logo'), ['class' => 'form-label']) }}
                                {!! Form::file('form_logo', ['class' => 'form-control']) !!}

                                @if ($form->logo)
                                    @if (App\Facades\UtilityFacades::getsettings('storage_type') == 'local')
                                        <div class="text-center form-group w-25">
                                            {!! Form::image(
                                                Storage::exists($form->logo) ? asset('storage/app/' . $form->logo) : Storage::url('app-logo/78x78.png'),
                                                null,
                                                [
                                                    'class' => 'img img-responsive justify-content-center text-center form-img',
                                                    'id' => 'app-dark-logo',
                                                ],
                                            ) !!}
                                        </div>
                                    @else
                                        <div class="text-center form-group w-25">
                                            {!! Form::image(Storage::url($form->logo), null, [
                                                'class' => 'img img-responsive justify-content-center text-center form-img',
                                                'id' => 'app-dark-logo',
                                            ]) !!}
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('category_id', __('Category'), ['class' => 'form-label']) }}
                                {!! Form::select('category_id', $categories, $form->category_id, [
                                    'class' => 'form-select',
                                    'required',
                                    'data-trigger',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('form_status', __('Status'), ['class' => 'form-label']) }}
                                {!! Form::select('form_status', $status, $form->form_status, [
                                    'class' => 'form-select',
                                    'required',
                                    'data-trigger',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('form_description', __('Short Description'), ['class' => 'form-label']) }}
                                <p><small>{{ 'Note' }} :-
                                        {{ __('This Description Only Show in front side') }}</small></p>
                                {!! Form::textarea('form_description', $form->description, [
                                    'id' => 'form_description',
                                    'placeholder' => __('Enter short description'),
                                    'rows' => '3',
                                    'class' => 'form-control',
                                ]) !!}
                                @if ($errors->has('form_description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('form_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('success_msg', __('Success Message'), ['class' => 'form-label']) }}
                                {!! Form::textarea('success_msg', $form->success_msg, [
                                    'id' => 'success_msg',
                                    'placeholder' => __('Enter success message'),
                                    'class' => 'form-control',
                                ]) !!}
                                @if ($errors->has('success_msg'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('success_msg') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('thanks_msg', __('Thanks Message'), ['class' => 'form-label']) }}
                                {!! Form::textarea('thanks_msg', $form->thanks_msg, [
                                    'id' => 'thanks_msg',
                                    'placeholder' => __('Enter client message'),
                                    'class' => 'form-control',
                                ]) !!}
                                @if ($errors->has('thanks_msg'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('thanks_msg') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('assignform', __('Assign Form'), ['class' => 'form-label']) }}
                                <div class="assignform" id="assign_form">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    {!! Form::label('assign_type_role', __('Role'), ['class' => 'form-label']) !!}
                                                    <label class="form-switch custom-switch-v1 ms-2">
                                                        {!! Form::radio('assign_type', 'role', $getFormRole ? true : false, [
                                                            'class' => 'form-check-input input-primary',
                                                            'id' => 'assign_type_role',
                                                        ]) !!}
                                                    </label>
                                                </div>
                                                <div>
                                                    {!! Form::label('assign_type_user', __('User'), ['class' => 'form-label tesk-1']) !!}
                                                    <label class="form-switch custom-switch-v1 ms-2">
                                                        {!! Form::radio('assign_type', 'user', $GetformUser ? true : false, [
                                                            'class' => 'form-check-input input-primary',
                                                            'id' => 'assign_type_user',
                                                        ]) !!}
                                                    </label>
                                                </div>
                                                <div>
                                                    {!! Form::label('assign_type_public', __('Public'), ['class' => 'form-label tesk-1']) !!}
                                                    <label class="form-switch custom-switch-v1 ms-2">
                                                        {!! Form::radio('assign_type', 'public', null, [
                                                            'class' => 'form-check-input input-primary',
                                                            'id' => 'assign_type_public',
                                                        ]) !!}
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="role" class="desc {{ $formRole ? 'd-block' : 'd-none' }}">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            {{ Form::label('roles', __('Role'), ['class' => 'form-label']) }}
                                                            <select name="roles[]" class="form-select" multiple
                                                                id="choices-multiple-remove-button">
                                                                @foreach ($getFormRole as $k => $role)
                                                                    <option value="{{ $k }}"
                                                                        {{ in_array($k, $formRole) ? 'selected' : '' }}>
                                                                        {{ $role }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="user" class="desc {{ $formUser ? 'd-block' : 'd-none' }}">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            {{ Form::label('users', __('User'), ['class' => 'form-label']) }}
                                                            <select name="users[]" class="form-select" multiple
                                                                id="choices-multiples-remove-button">
                                                                @foreach ($GetformUser as $key => $user)
                                                                    <option value="{{ $key }}"
                                                                        {{ in_array($key, $formUser) ? 'selected' : '' }}>
                                                                        {{ $user }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('form_fill_edit_lock', __('Form Fill Edit Lock'), ['class' => 'form-label']) }}
                                <label class="mt-2 form-switch float-end custom-switch-v1">
                                    <input type="checkbox" name="form_fill_edit_lock" id="form_fill_edit_lock"
                                        class="form-check-input input-primary"
                                        {{ $form->form_fill_edit_lock == 1 ? 'checked' : 'unchecked' }}>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('allow_comments', __('Allow comments'), ['class' => 'form-label']) }}
                                <label class="mt-2 form-switch float-end custom-switch-v1">
                                    <input type="checkbox" name="allow_comments" id="allow_comments"
                                        class="form-check-input input-primary"
                                        {{ $form->allow_comments == 1 ? 'checked' : 'unchecked' }}>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('allow_share_section', __('Allow Share Section'), ['class' => 'form-label']) }}
                                <label class="mt-2 form-switch float-end custom-switch-v1">
                                    <input type="checkbox" name="allow_share_section" id="allow_share_section"
                                        class="form-check-input input-primary"
                                        {{ $form->allow_share_section == 1 ? 'checked' : 'unchecked' }}>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Email Setting') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('email[]', __('Recipient Email'), ['class' => 'form-label']) }}
                                {!! Form::text('email[]', null, [
                                    'class' => 'form-control',
                                    'placeholder' => __('Enter recipient email'),
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('ccemail[]', __('Enter cc emails (Optional)'), ['class' => 'form-label']) }}
                                {!! Form::text('ccemail[]', null, [
                                    'class' => 'form-control inputtags',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('bccemail[]', __('Enter bcc emails (Optional)'), ['class' => 'form-label']) }}
                                {!! Form::text('bccemail[]', null, [
                                    'class' => 'form-control inputtags',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Lmit Setting') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mt-2 row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    {{ Form::label('limit_status', __('Set limit'), ['class' => 'form-label']) }}
                                    <label class="mt-2 form-switch float-end custom-switch-v1">
                                        <input type="hidden" name="limit_status" value="0">
                                        <input type="checkbox" name="limit_status" id="m_limit_status"
                                            class="form-check-input input-primary"
                                            @if ($form->limit_status == '1') checked @endif>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="limit_status" class="{{ $form->limit ? 'd-block' : 'd-none' }}">
                            <div class="form-group">
                                {!! Form::number('limit', null, ['class' => 'form-control limit', 'placeholder' => __('limit')]) !!}
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Password Protection') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mt-2 row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    {{ Form::label('password_enable', __('Password Protection Enable'), ['class' => 'form-label']) }}
                                    <label class="mt-2 form-switch float-end custom-switch-v1">
                                        <input type="hidden" name="password_enable" value="0">
                                        <input type="checkbox" name="password_enable" id="form_password_enable"
                                            class="form-check-input input-primary"  @if ($form->password_enabled == '1') checked @endif value="1">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="password_enable" class="{{ $form->form_password ? 'd-block' : 'd-none' }}">
                            <div class="form-group">
                                <div class="position-relative password-toggle">
                                    {!! Form::password('form_password' , [
                                        'class' => 'form-control password-toggle-input',
                                        'placeholder' => __('************'),
                                        'autocomplete' => 'off',
                                        'id' => 'form_protection_password',
                                    ]) !!}

                                    <div class="input-group-append password-toggle-icon" id="togglePassword">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Set End Date') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mt-2 row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    {{ Form::label('set_end_date', __('Set end date'), ['class' => 'form-label']) }}
                                    <label class="mt-2 form-switch float-end custom-switch-v1">
                                        <input type="hidden" name="set_end_date" value="0">
                                        <input type="checkbox" name="set_end_date" id="m_set_end_date"
                                            class="form-check-input input-primary"
                                            @if ($form->set_end_date == '1') checked @endif>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="set_end_date" class="{{ isset($form->set_end_date_time) ? 'd-block' : 'd-none' }}">
                            <div class="form-group">
                                <input class="form-control" name="set_end_date_time" id="set_end_date_time"
                                    value="{{ $form->set_end_date_time }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-end">
                            {!! Html::link(route('forms.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
                            {!! Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}" />
    <link href="{{ asset('vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
@endpush
@push('script')
    <script src="{{ asset('vendor/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script>
        var multipleCancelButton = new Choices(
            '#choices-multiple-remove-button', {
                removeItemButton: true,
            }
        );
        var multipleCancelButton = new Choices(
            '#choices-multiples-remove-button', {
                removeItemButton: true,
            }
        );
        $(".inputtags").tagsinput('items');
    </script>
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).on('click', "input[name$='payment']", function() {
            if (this.checked) {
                $('#payment').fadeIn(500);
                $("#payment").removeClass('d-none');
                $("#payment").addClass('d-block');
            } else {
                $('#payment').fadeOut(500);
                $("#payment").removeClass('d-block');
                $("#payment").addClass('d-none');
            }
        });
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
    <script>
        $(function() {
            $('input[name="set_end_date_time"]').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                showDropdowns: true,
                minYear: 2000,
                locale: {
                    format: 'YYYY-MM-DD HH:mm:ss'
                }
            });
        });
        $(document).on('click', "input[name$='set_end_date']", function() {
            if (this.checked) {
                $('#set_end_date').fadeIn(500);
                $("#set_end_date").removeClass('d-none');
                $("#set_end_date").addClass('d-block');
            } else {
                $('#set_end_date').fadeOut(500);
                $("#set_end_date").removeClass('d-block');
                $("#set_end_date").addClass('d-none');
            }
        });
        $(document).on('click', "input[name$='limit_status']", function() {
            if (this.checked) {
                $('#limit_status').fadeIn(500);
                $("#limit_status").removeClass('d-none');
                $("#limit_status").addClass('d-block');
            } else {
                $('#limit_status').fadeOut(500);
                $("#limit_status").removeClass('d-block');
                $("#limit_status").addClass('d-none');
                $(".limit").val(null);
            }
        });

        $(document).on('click', "input[name$='password_enable']", function() {
            if (this.checked) {
                $('#password_enable').fadeIn(500);
                $("#password_enable").removeClass('d-none');
                $("#password_enable").addClass('d-block');
                console.log($('#password_enable'));
            } else {
                console.log(2345);
                $('#password_enable').fadeOut(500);
                $("#password_enable").removeClass('d-block');
                $("#password_enable").addClass('d-none');
            }
        });

        // toggle password

        function togglePasswordVisibility() {
            const passwordField = document.getElementById('form_protection_password');
            const toggleButton = document.getElementById('togglePassword');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleButton.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
            } else {
                passwordField.type = 'password';
                toggleButton.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
            }
        }
        document.getElementById('togglePassword').addEventListener('click', togglePasswordVisibility);


    </script>
    <script>
        CKEDITOR.replace('success_msg', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('thanks_msg', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
    <script>
        $(document).on('click', "input[name$='assignform']", function() {
            if (this.checked) {
                $('#assign_form').fadeIn(500);
                $("#assign_form").removeClass('d-none');
                $("#assign_form").addClass('d-block');
            } else {
                $('#assign_form').fadeOut(500);
                $("#assign_form").removeClass('d-block');
                $("#assign_form").addClass('d-none');
            }
        });

        $(document).on('click', "input[name$='assign_type']", function() {
            var test = $(this).val();
            if (test == 'role') {
                $("#role").fadeIn(500);
                $("#role").removeClass('d-none');
                $("#user").addClass('d-none');
                $("#public").addClass('d-none');
            } else if (test == 'user') {
                $("#user").fadeIn(500);
                $("#user").removeClass('d-none');
                $("#role").addClass('d-none');
                $("#public").addClass('d-none');
            } else {
                $("#public").fadeIn(500);
                $("#public").removeClass('d-none');
                $("#role").addClass('d-none');
                $("#user").addClass('d-none');
            }
        });
    </script>
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
