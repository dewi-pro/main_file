@extends('layouts.main')
@section('title', __('Condition Rules'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="d-flex justify-content-between">
            <div class="previous-next-btn">
                <div class="page-header-title">
                    <h4 class="m-b-10">{{ __('Form Rules') }}</h4>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('forms.index') }}">{{ __('Forms') }}</a></li>
                    <li class="breadcrumb-item"> {{ __('Form Rules') }} </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 col-12 m-auto">
            {{ Form::open(['route' => 'rule.store', 'method' => 'post', 'id' => 'form-rule', 'data-validate', 'no-validate']) }}
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-8">
                            <h5 class="card-title">{{ __('New Rule') }}</h5>
                            <p class="text-muted">
                                {{ __('Configure rules to show or hide fields based on the input of another field.') }}</p>
                        </div>
                        <div class="col-lg-4 form-check form-switch custom-switch-v1">
                            <div class="form-group">
                                <label class="mt-2 form-switch float-end custom-switch-v1">
                                    <input type="hidden" name="conditional_rule" value="0">
                                    <input type="checkbox" name="conditional_rule" class="form-check-input input-primary"
                                        {{ 'unchecked' }} value="1">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group mb-6">
                            <label for="rule" class="mb-1">{{ __('Rule Name') }}</label>
                            {{ Form::text('rule_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Rule name']) }}
                            <small>{{ '(Maximum 50 characters)' }}</small>
                            <input type="hidden" name="form_id" value="{{ $formRules->id }}">
                        </div>

                        <div class="form-group mb-6 condition-select d-none w-25">
                            <select name="condition_type" class="form-control" data-trigger>
                                <option value="" selected disabled>{{ __('Select Condition type') }}</option>
                                <option value="and">{{ __('And') }}</option>
                                <option value="or">{{ __('Or') }}</option>
                            </select>
                        </div>
                        <div class="form-group mb-6">
                            <div class="row">
                                <div class="col-2">
                                    <button type="button" class="btn btn-secondary">{{ __('IF') }}</button>
                                </div>
                                <div class="col-10">
                                    <div class="repeater">
                                        <div data-repeater-list="rules">
                                            <div data-repeater-item class="border-bottom py-2">
                                                <div class="row count-row">
                                                    <div class="col-lg-4">
                                                        <select name="if_field_name" class="if_field_name form-control"
                                                            data-trigger>
                                                            <option selected disabled>{{ __('Select Field') }}</option>
                                                            @foreach ($jsonData as $jsons)
                                                                @foreach ($jsons as $json)
                                                                    @if (
                                                                        !in_array($json->type, [
                                                                            'SignaturePad',
                                                                            'header',
                                                                            'file',
                                                                            'location',
                                                                            'video',
                                                                            'selfie',
                                                                            'autocomplete',
                                                                            'button',
                                                                            'break',
                                                                            'starRating',
                                                                            'hidden',
                                                                            'paragraph',
                                                                            'number',
                                                                        ]))
                                                                        @if (isset($json->name) && isset($json->label))
                                                                            @php
                                                                                $ifDataFieldNames = [];
                                                                                $rules = App\Models\FormRule::where('form_id', $formRules->id)->get();
                                                                            @endphp

                                                                            @foreach ($rules as $rule)
                                                                                @php
                                                                                    $ifJsonArray = json_decode($rule->if_json, true);
                                                                                    foreach ($ifJsonArray as $ifData) {
                                                                                        $ifDataFieldNames[] = $ifData['if_field_name'];
                                                                                    }
                                                                                @endphp
                                                                            @endforeach

                                                                            @if (!in_array($json->name, $ifDataFieldNames))
                                                                                <option value="{{ $json->name }}">
                                                                                    {{ $json->label }}</option>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <select name="if_rule_type" id="if_rule_type" class="form-control"
                                                            data-trigger>
                                                            <option value="" selected disabled>
                                                                {{ __('Select Type') }}
                                                            </option>
                                                            <option value="is">{{ __('Is') }}</option>
                                                            <option value="is-not">{{ __('Is Not') }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 input-container">
                                                        {{ Form::text('if_rule_value', null, ['class' => 'form-control', 'id' => 'if_rule_value']) }}
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <input data-repeater-delete class="btn btn-danger p-2"
                                                            type="button" value="Delete" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <input data-repeater-create class="btn btn-primary p-2 add-repeater-button"
                                                type="button" value="Add" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-6">
                            <div class="row">
                                <div class="col-2">
                                    <button type="button" class="btn btn-secondary">{{ __('Then') }}</button>
                                </div>
                                <div class="col-10">
                                    <div class="repeater2">
                                        <div data-repeater-list="rules2">
                                            <div data-repeater-item class="border-bottom py-2">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <select name="else_rule_type" id="else_rule_type"
                                                            class="form-control" data-trigger>
                                                            <option value="" selected disabled>
                                                                {{ __('Select Type') }}
                                                            </option>
                                                            <option value="show">{{ __('Show') }}</option>
                                                            <option value="hide">{{ __('Hide') }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <select name="else_field_name" id="else_field_name"
                                                            class="form-control form-select" data-trigger multiple>
                                                            @php
                                                                $thenDataFieldNames = [];
                                                                foreach ($rules as $rule) {
                                                                    $ThenJsonArray = json_decode($rule->then_json, true);
                                                                    foreach ($ThenJsonArray as $thenData) {
                                                                        $thenDataFieldNames = array_merge($thenDataFieldNames, $thenData['else_field_name']);
                                                                    }
                                                                }
                                                            @endphp
                                                            @foreach ($jsonData as $jsons)
                                                                @foreach ($jsons as $json)
                                                                    @if (isset($json->name) && isset($json->label))
                                                                        @if (!in_array($json->name, $thenDataFieldNames))
                                                                            <option value="{{ $json->name }}">
                                                                                {{ $json->label }}
                                                                            </option>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <input data-repeater-delete class="btn btn-danger p-2"
                                                            type="button" value="Delete" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <input data-repeater-create class="btn btn-primary p-2 " type="button"
                                                value="Add" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    {{-- <a href="{{ route('forms.index') }}"><button
                            class="btn btn-secondary text-white">{{ __('Cancel') }}</button></a> --}}
                    {{ form::button(__('Save'), ['class' => 'btn btn-primary', 'id' => 'save-btn', 'type' => 'submit']) }}
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>

    <div class="row">
        <div class="m-auto col-lg-8 col-md-8 col-sm-12 col-12">
            <div class="card">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('No') }}</th>
                            <th>{{ __('Rule Name') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (is_array($rules) || is_object($rules))
                            @php
                                $ff_no = 1;
                            @endphp
                            @foreach ($rules as $rule)
                                <tr>
                                    <td>{{ $ff_no++ }}</td>
                                    <td>{{ $rule->rule_name }}</td>
                                    <td>
                                        <a href="{{ route('rule.edit', $rule->id) }}"><button
                                                class="btn btn-primary btn-sm small">{{ __('Edit') }}</button></a>
                                        {!! Form::open([
                                            'method' => 'DELETE',
                                            'class' => 'd-inline',
                                            'route' => ['rule.delete', $rule->id],
                                            'id' => 'delete-form-' . $rule->id,
                                        ]) !!}
                                        <a href="#" class="btn btn-sm small btn-danger show_confirm"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            id="delete-form-{{ $rule->id }}"
                                            data-bs-original-title="{{ __('Cancel Rule') }}"
                                            aria-label="{{ __('Cancel Rule') }}">{{ __('Delete') }}</a>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script src="{{ asset('vendor/repeater/reapeater.js') }}"></script>
    <script src="{{ asset('vendor/repeater/jquery.input.js') }}"></script>
    <script src="{{ asset('vendor/repeater/jquery.repeater.js') }}"></script>
    <script>
        $(document).ready(function() {
            var $repeater = $('.repeater').repeater({
                initEmpty: false,
                show: function() {
                    $(this).slideDown();
                    var data = $(this).find('input, textarea, select').toArray();
                    data.forEach(function(val) {
                        $(val).parents('.form-group').find('label').attr('for', $(val).attr(
                            'name'));
                        $(val).attr('id', $(val).attr('name'));
                    });

                    var $selects = $(this).find('select[data-trigger]');
                    $selects.each(function() {
                        var select = this;
                        new Choices(select, {
                            removeItemButton: true,
                        });
                    });
                    var rowCount = $('.count-row').length;
                    if (rowCount > 1) {
                        $('.condition-select').removeClass('d-none');
                        $('.condition-select').addClass('d-block');
                        $('.condition-select').fadeIn(500);
                    }
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function(setIndexes) {
                    var $initialSelects = $('.repeater [data-trigger]');
                    $initialSelects.each(function() {
                        var select = this;
                        new Choices(select, {
                            placeholderValue: 'This is a placeholder set in the config',
                            searchPlaceholderValue: 'This is a search placeholder',
                            removeItemButton: true,

                        });
                    });
                },
                isFirstItemUndeletable: true
            });

            var $repeater2 = $('.repeater2').repeater({
                initEmpty: false,
                show: function() {
                    $(this).slideDown();
                    var data = $(this).find('input, textarea, select').toArray();
                    data.forEach(function(val) {
                        $(val).parents('.form-group').find('label').attr('for', $(val).attr(
                            'name'));
                        $(val).attr('id', $(val).attr('name'));
                    });

                    var $selects = $(this).find('select[data-trigger]');
                    $selects.each(function() {
                        var select = this;
                        new Choices(select, {
                            removeItemButton: true,
                        });
                    });
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function(setIndexes) {
                    var genericExamples = document.querySelectorAll('[data-trigger]');
                    for (i = 0; i < genericExamples.length; ++i) {
                        var element = genericExamples[i];
                        new Choices(element, {
                            placeholderValue: 'This is a placeholder set in the config',
                            searchPlaceholderValue: 'This is a search placeholder',
                            removeItemButton: true,

                        });
                    }
                },
                isFirstItemUndeletable: true
            });
        });
    </script>

    <script>
        $(document).on('click', '#save-btn', function(e) {
            e.preventDefault();
            $('.is-invalid').removeClass('is-invalid');
            $('.error-message').remove();

            var isValid = true;
            if ($('input[name="rule_name"]').val() === '') {
                $('input[name="rule_name"]').addClass('is-invalid');
                $('input[name="rule_name"]').after('<div class="error-message">Please fill this field.</div>');
                isValid = false;
            }

            if ($(".if_field_name").val() === '') {
                $(".if_field_name").addClass('is-invalid');
                $(".if_field_name").after('<div class="error-message">Select Any One.</div>');
                isValid = false;
            }

            if ($("#if_rule_type").val() === '') {
                $("#if_rule_type").addClass('is-invalid');
                $("#if_rule_type").after('<div class="error-message">Select Any One.</div>');
                isValid = false;
            }

            if ($("#if_rule_value").val() === '') {
                $("#if_rule_value").addClass('is-invalid');
                $("#if_rule_value").after('<div class="error-message">Please fill this field.</div>');
                isValid = false;
            }

            if ($("#else_rule_type").val() === '') {
                $("#else_rule_type").addClass('is-invalid');
                $("#else_rule_type").after('<div class="error-message">Select Any One.</div>');
                isValid = false;
            }

            if ($("#else_field_name").val() === '') {
                $("#else_field_name").addClass('is-invalid');
                $("#else_field_name").after('<div class="error-message">Select Any One.</div>');
                isValid = false;
            }
            if (isValid) {
                $("#form-rule").submit();
            }

        });
    </script>

    <script>
        var repeaterIndex = 0;
        $(document).on('click', '.add-repeater-button', function() {
            repeaterIndex++;
        });
        $(document).on('change', '.if_field_name', function() {
            var fieldName = $(this).find(':selected').val();
            var id = '{{ $formRules->id }}';
            console.log(id);
            var inputContainer = $(this).closest('[data-repeater-item]').find('.input-container');
            inputContainer.empty();

            $.ajax({
                type: "GET",
                url: "{{ route('get.field') }}",
                data: {
                    id: id,
                    fieldname: fieldName
                },
                success: function(response) {
                    var inputType = '';
                    if (response.matchingField.type == 'date') {
                        inputType = 'date';
                        var html = '<input class="form-control" name="rules[' + repeaterIndex +
                            '][if_rule_value]" data-name="' + response.matchingField.name + '" type="' +
                            inputType + '">';
                        inputContainer.append(html);
                    } else if (response.matchingField.type == 'text') {
                        inputType = 'text';
                        var html = '<input class="form-control" name="rules[' + repeaterIndex +
                            '][if_rule_value]" data-name="' + response.matchingField.name + '" type="' +
                            inputType + '">';
                        inputContainer.append(html);

                    } else if (response.matchingField.type == 'textarea') {
                        inputType = 'textarea';
                        var html = '<textarea class="form-control" name="rules[' + repeaterIndex +
                            '][if_rule_value]" data-name="' + response.matchingField.name + '" type="' +
                            inputType + '"></textarea>';
                        inputContainer.append(html);
                    } else {
                        var select = $('<select>', {
                            name: 'rules[' + repeaterIndex + '][if_rule_value]',
                            class: 'form-control',
                        });
                        response.matchingField.values.forEach(function(value) {
                            var option = $('<option>', {
                                value: value.value,
                                text: value.label
                            });
                            select.append(option);
                        });
                        inputContainer.append(select);
                    }
                }
            });
        });
    </script>
@endpush
