@extends('layouts.main')
@section('title', __('Form'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Create Form') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('forms.index'), __('Forms'), []) !!}</li>
            <li class="breadcrumb-item active"> {{ __('Create Form') }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        {!! Form::open([
            'route' => ['forms.store'],
            'method' => 'POST',
            'data-validate',
            'id' => 'payment-form',
            'class' => 'form-horizontal',
            'enctype' => 'multipart/form-data',
        ]) !!}
        <div class="row">
                <div class="card">
                    <!-- <div class="card-header">
                        <h5>{{ __('General') }}</h5>
                    </div> -->
                    <div class="card-body">
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('title', __('Title of form'), ['class' => 'form-label']) }}
                                {!! Form::text('title', null, [
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
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                            {{ Form::label('type_id', __('Type'), ['class' => 'form-label']) }}
                                            {!! Form::select('type_id', $type, null, [
                                            'class' => 'form-select',
                                            'id' => 'type_id',
                                            'data-trigger',
                                        ]) !!}
                                    </div>
                                    <div class="col-lg-6">
                                        {{ Form::label('field_categories', __('Category'), ['class' => 'form-label']) }}
                                        <div class="field_categories">
                                            {!! Form::select('field_categories', [], null, ['class' => 'form-control','data-trigger']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                            {{ Form::label('field_destination', __('Destination'), ['class' => 'form-label']) }}
                                        <div class="field_destination">
                                            {!! Form::select('field_destination', [], null, ['class' => 'form-control','data-trigger']) !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                            {{ Form::label('field_codetour', __('Code Tour'), ['class' => 'form-label']) }}
                                        <div class="field_codetour">
                                            {!! Form::select('field_codetour', [], null, ['class' => 'form-control','data-trigger']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                            {{ Form::label('field_tourleader', __('Tour Leader'), ['class' => 'form-label']) }}
                                        <div class="field_tourleader">
                                            {!! Form::select('field_tourleader', [], null, ['class' => 'form-control','data-trigger']) !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                            {{ Form::label('field_tourconsultant', __('Tour Consultant'), ['class' => 'form-label']) }}
                                        <div class="field_tourconsultant">
                                            {!! Form::select('field_tourconsultant', [], null, ['class' => 'form-control','data-trigger']) !!}
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                {{ Form::label('form_status', __('Status'), ['class' => 'form-label']) }}
                               
                            </div> -->
                                </div>
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
                                                        {!! Form::radio('assign_type', 'role', true, [
                                                            'class' => 'form-check-input input-primary',
                                                            'id' => 'assign_type_role',
                                                        ]) !!}
                                                    </label>
                                                </div>
                                                <div>
                                                    {!! Form::label('assign_type_user', __('User'), ['class' => 'form-label ']) !!}
                                                    <label class="form-switch custom-switch-v1 ms-2">
                                                        {!! Form::radio('assign_type', 'user', null, [
                                                            'class' => 'form-check-input input-primary',
                                                            'id' => 'assign_type_user',
                                                        ]) !!}
                                                    </label>
                                                </div>
                                                <div>
                                                    {!! Form::label('assign_type_public', __('Public'), ['class' => 'form-label ']) !!}
                                                    <label class="form-switch custom-switch-v1 ms-2">
                                                        {!! Form::radio('assign_type', 'public', null, [
                                                            'class' => 'form-check-input input-primary',
                                                            'id' => 'assign_type_public',
                                                        ]) !!}
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="role" class="desc">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            {{ Form::label('roles', __('Role'), ['class' => 'form-label']) }}
                                                            {!! Form::select('roles[]', $roles, null, [
                                                                'class' => 'form-control role-remove',
                                                                'id' => 'choices-multiple-remove-button',
                                                                'multiple' => 'multiple',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="user" class="desc d-none">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            {{ Form::label('users', __('User'), ['class' => 'form-label']) }}
                                                            {!! Form::select('users[]', $users, null, [
                                                                'class' => 'form-control',
                                                                'id' => 'choices-multiples-remove-button',
                                                                'multiple' => 'multiple',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    <script src="https://www.google.com/recaptcha/api.js"></script>
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
        $(document).on('click', '.theme-button button', function() {
            var url = $(this).attr('data-url');
            var modal = $('#common_modal');
            $.ajax({
                type: "GET",
                url: url,
                data: {},
                success: function(response) {
                    modal.find('.modal-title').html('{{ __('Select Theme Color') }}');
                    modal.find('.body').html(response);
                    modal.modal('show');
                    modal.find('.theme-colors').click(function() {
                        $('.theme-colors').removeClass('active_color');
                        $(this).addClass('active_color');

                    });
                    modal.find('#save-btn').click(function() {
                        var color = $('.active_color').attr('data-value');
                        $('input[name="theme_color"]').val(color);
                    });
                },
                error: function(error) {}
            });
        });
        $(document).on('click', '.theme-view-hover', function() {
            var theme = $(this).find('img').attr('data-id');
            $('input[name="theme"]').val(theme);
            $('.theme-view-card').removeClass('selected-theme');
            $(this).parents('.theme-view-card').addClass('selected-theme');
        });
    </script>
    <script>
        CKEDITOR.replace('success_msg', {
            filebrowserUploadUrl: "{{ route('ckeditors.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('thanks_msg', {
            filebrowserUploadUrl: "{{ route('ckeditors.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
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
            }
        });

        $(document).on('click', "input[name$='password_enable']", function() {
            if (this.checked) {
                $('#password_enable').fadeIn(500);
                $("#password_enable").removeClass('d-none');
                $("#password_enable").addClass('d-block');

            } else {

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
        $(document).on('click', "input[name$='assign_type']", function() {
            var test = $(this).val();
            if (test == 'role') {
                $("#role").fadeIn(500);
                $("#role").removeClass('d-none');
                $("#user").addClass('d-none');
                $("#public").addClass('d-none');
            } else if (test == 'user') {
                $('select[name="roles[]"]').data('options', $('select[name="roles[]"]').clone());
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
    <script>
        $(document).on("change", "#type_id", function() {
            var cate_id = $(this).val();
            $.ajax({
                url: '{{ route('widget.chnagesc') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    widget: cate_id,
                },
                success: function(data) {
                    var toAppend = '';
                    $.each(data, function(i, o) {
                        toAppend += '<option value=' + o.name + '>' + o.name+ '</option>';
                    });
                    $('.field_categories').html(
                        '<select name="field_categories" class="form-control" id="field_categories" data-trigger>' +
                        toAppend +
                        '</select>');
                    new Choices('#field_categories', {
                        removeItemButton: true,
                    });
                }
            })
        });
        $(document).on("change", "#field_categories", function() {
            var cate_id = $(this).val();
            $.ajax({
                url: '{{ route('widget.ChnagesDestination') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    widget: cate_id,
                },
                success: function(data) {
                    var toAppend = '';
                    $.each(data, function(i, o) {
                        toAppend += '<option value=' + o.destination_name + '>' + o.destination_name + '</option>';
                    });
                    $('.field_destination').html(
                        '<select name="field_destination" class="form-control" id="field_destination" data-trigger>' +
                        toAppend +
                        '</select>');
                    new Choices('#field_destination', {
                        removeItemButton: true,
                    });
                }
            })
        });
        $(document).on("change", "#field_destination", function() {
            var cate_id = $(this).val();
            $.ajax({
                url: '{{ route('widget.ChnagesCodetour') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    widget: cate_id,
                },
                success: function(data) {
                    var toAppend = '';
                    $.each(data, function(i, o) {
                        toAppend += '<option value=' + o.code_tour + '>' + o.code_tour + '</option>';
                    });
                    $('.field_codetour').html(
                        '<select name="field_codetour" class="form-control" id="field_codetour" data-trigger>' +
                        toAppend +
                        '</select>');
                    new Choices('#field_codetour', {
                        removeItemButton: true,
                    });
                }
            })
        });
        $(document).on("change", "#field_codetour", function() {
            var cate_id = $(this).val();
            $.ajax({
                url: '{{ route('widget.ChnagesTouleader') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    widget: cate_id,
                },
                success: function(data) {
                    var toAppend = '';
                    var toAppend1 = '';

                    $.each(data, function(i, o) {
                        toAppend += '<option value=' + o.tour_leader + '>' + o.tour_leader + '</option>';
                        toAppend1 += '<option value=' + o.tour_consultant + '>' + o.tour_consultant + '</option>';

                    });
                    $('.field_tourleader').html(
                        '<select name="field_tourleader" class="form-control" id="field_tourleader" data-trigger>' +
                        toAppend +
                        '</select>');
                    new Choices('#field_tourleader', {
                        removeItemButton: true,
                    });

                    $('.field_tourconsultant').html(
                        '<select name="field_tourconsultant" class="form-control" id="field_tourconsultant" data-trigger>' +
                        toAppend1+
                        '</select>');
                    new Choices('#field_tourconsultant', {
                        removeItemButton: true,
                    });
                }
            })
        });
        $(document).on("change", "#field_tourleader", function() {
            var cate_id = $(this).val();
            $.ajax({
                url: '{{ route('widget.ChnagesTouConsultant') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    widget: cate_id,
                },
                success: function(data) {
                    var toAppend = '';
                    $.each(data, function(i, o) {
                        toAppend += '<option value=' + o.tour_consultant + '>' + o.tour_consultant + '</option>';
                    });
                    $('.field_tourconsultant').html(
                        '<select name="field_tourconsultant" class="form-control" id="field_tourconsultant" data-trigger>' +
                        toAppend +
                        '</select>');
                    new Choices('#field_tourconsultant', {
                        removeItemButton: true,
                    });
                }
            })
        });
    </script>
@endpush
