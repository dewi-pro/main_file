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
            <!-- <div class="float-end">
                <div class="d-flex align-items-center">
                    <a href="@if (!empty($previous)) {{ route('forms.edit', [$previous->id]) }}@else javascript:void(0) @endif"
                        type="button" class="btn btn-outline-primary"><i class="me-2"
                            data-feather="chevrons-left"></i>{{ __('Previous') }}</a>
                    <a href="@if (!empty($next)) {{ route('forms.edit', [$next->id]) }}@else javascript:void(0) @endif"
                        class="btn btn-outline-primary ms-1"><i class="me-2"
                            data-feather="chevrons-right"></i>{{ __('Next') }}</a>
                </div>
            </div> -->
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        {{ Form::model($form, ['route' => ['forms.update', $form->id], 'data-validate', 'method' => 'PUT', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) }}
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <!-- <div class="card-header">
                        <h5>{{ __('General') }}</h5>
                    </div> -->
                    <div class="card-body">
                        <div class="form-group">
                            {{ Form::label('title', __('Title of Survey'), ['class' => 'form-label']) }}
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
                                <div class="row">
                                    <div class="col-lg-6">
                                    {{ Form::label('type_id', __('Type'), ['class' => 'form-label']) }}
                                    {!! Form::hidden('type_id', null, ['id' => 'type-hidden']) !!}
                                    {{ Form::select(
                                        'type_id', $type,null,
                                        ['class' => 'custom_select form-select', 'id' => 'type_id', 'data-trigger'],
                                    ) }}
                                    </div>
                                    <div class="col-lg-6">
                                        {{ Form::label('field_categories', __('Category'), ['class' => 'form-label']) }}
                                        {!! Form::hidden('field_categories', null, ['id' => 'type-hidden']) !!}
                                        {{ Form::select(
                                            'field_categories',$cat,null,
                                            ['class' => 'custom_select form-select', 'id' => 'field_categories', 'data-trigger'],
                                        ) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                            {{ Form::label('field_destination', __('Cluster'), ['class' => 'form-label']) }}
                                            {!! Form::select('field_destination', $cluster, null, ['class' => 'form-control','id' => 'field_destination', 'data-trigger']) !!}
                                    </div>
                                    <div class="col-lg-6">
                                            {{ Form::label('field_codetour', __('Code Tour'), ['class' => 'form-label']) }}
                                            {!! Form::text('field_codetour', null, ['class' => 'form-control','id' => 'password',]) !!}                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                            {{ Form::label('field_tourleader', __('Tour Leader'), ['class' => 'form-label']) }}
                                            {!! Form::select('field_tourleader', $lead, null, ['class' => 'form-control','data-trigger']) !!}
                                    </div>
                                    <div class="col-lg-6">
                                        {{ Form::label('numberofpart', __('Number of Participants'), ['class' => 'form-label']) }}
                                        {!! Form::number('numberofpart', null, [
                                            'autofocus' => '',
                                            'autocomplete' => 'off',
                                            'class' => 'form-control',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        {{ Form::label('start_date', __('Start Date Tour'), ['class' => 'form-label']) }}
                                        {!! Form::text('start_date', null, ['class' => 'form-control',
                                            'id' => 'datepicker-start-date',
                                            'placeholder' => __('Start Date'),]) !!}                  
                                    </div>
                                    <div class="col-lg-6">
                                        {{ Form::label('end_date', __('End Date Tour'), ['class' => 'form-label']) }}
                                        {!! Form::text('end_date', null, ['class' => 'form-control',
                                            'id' => 'datepicker-end-date',
                                            'placeholder' => __('End Date'),]) !!}                                        </div>
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
<link rel="stylesheet" href="{{ asset('assets/css/plugins/datepicker-bs5.min.css') }}">
    <link href="{{ asset('vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
@endpush
@push('script')
    <script src="{{ asset('vendor/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datepicker-full.min.js') }}"></script>
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
        // $(document).on("change", "#form_title", function() {
        //     var cate_id = $(this).val();
        //     $.ajax({
        //         url: '{{ route('widget.chnages') }}',
        //         type: 'POST',
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             widget: cate_id,
        //         },
        //         success: function(data) {
        //             var toAppend = '';
        //             $.each(data, function(i, o) {
        //                 toAppend += '<option value=' + o.name + '>' + o.label + '</option>';
        //             });
        //             $('.field_name').html(
        //                 '<select name="field_name" class="form-control" id="field_name" data-trigger>' +
        //                 toAppend +
        //                 '</select>');
        //             new Choices('#field_name', {
        //                 removeItemButton: true,
        //             });
        //         }
        //     })
        // });
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
                        toAppend += '<option value=' + o.destination_name +'>' + o.destination_name + '</option>';
                       
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
                    var toAppend2 = '';

                    $.each(data, function(i, o) {
                        toAppend += '<option value=' + o.code_tour + '>' + o.code_tour + '</option>';
                        toAppend2 += '<option value=' + o.tour_leader + '>' + o.tour_leader + '</option>';

                    });
                    $('.field_codetour').html(
                        '<select name="field_codetour" class="form-control" id="field_codetour" data-trigger>' +
                        toAppend +
                        '</select>');
                    new Choices('#field_codetour', {
                        removeItemButton: true,
                    });
                    $('.field_tourleader').html(
                        '<select name="field_tourleader" class="form-control" id="field_tourleader" data-trigger>' +
                        toAppend2 +
                        '</select>');
                    new Choices('#field_tourleader', {
                        removeItemButton: true,
                    });
                }
            })
        });
        // $(document).on("change", "#field_codetour", function() {
        //     var cate_id = $(this).val();
        //     $.ajax({
        //         url: '{{ route('widget.ChnagesTouleader') }}',
        //         type: 'POST',
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             widget: cate_id,
        //         },
        //         success: function(data) {
        //             var toAppend = '';
        //             var toAppend1 = '';

        //             $.each(data, function(i, o) {
        //                 toAppend += '<option value=' + o.tour_leader + '>' + o.tour_leader + '</option>';
        //                 toAppend1 += '<option value=' + o.tour_consultant + '>' + o.tour_consultant + '</option>';

        //             });
        //             $('.field_tourleader').html(
        //                 '<select name="field_tourleader" class="form-control" id="field_tourleader" data-trigger>' +
        //                 toAppend +
        //                 '</select>');
        //             new Choices('#field_tourleader', {
        //                 removeItemButton: true,
        //             });

        //             $('.field_tourconsultant').html(
        //                 '<select name="field_tourconsultant" class="form-control" id="field_tourconsultant" data-trigger>' +
        //                 toAppend1+
        //                 '</select>');
        //             new Choices('#field_tourconsultant', {
        //                 removeItemButton: true,
        //             });
        //         }
        //     })
        // });
        // $(document).on("change", "#field_tourleader", function() {
        //     var cate_id = $(this).val();
        //     $.ajax({
        //         url: '{{ route('widget.ChnagesTouConsultant') }}',
        //         type: 'POST',
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             widget: cate_id,
        //         },
        //         success: function(data) {
        //             var toAppend = '';
        //             $.each(data, function(i, o) {
        //                 toAppend += '<option value=' + o.tour_consultant + '>' + o.tour_consultant + '</option>';
        //             });
        //             $('.field_tourconsultant').html(
        //                 '<select name="field_tourconsultant" class="form-control" id="field_tourconsultant" data-trigger>' +
        //                 toAppend +
        //                 '</select>');
        //             new Choices('#field_tourconsultant', {
        //                 removeItemButton: true,
        //             });
        //         }
        //     })
        // });
    </script>
    <script>
        (function() {
            const d_week = new Datepicker(document.querySelector('#datepicker-start-date'), {
                buttonClass: 'btn',
                format: 'dd/mm/yyyy'
            });
        })();
    </script>
    <script>
        (function() {
            const d_week = new Datepicker(document.querySelector('#datepicker-end-date'), {
                buttonClass: 'btn',
                format: 'dd/mm/yyyy'
            });
        })();
    </script>
@endpush
