@php
    use App\Facades\UtilityFacades;
    use App\Models\Role;
    use App\Models\AssignFormsRoles;
    use App\Models\AssignFormsUsers;
@endphp
@php
    $hashids = new Hashids('', 20);
    $id = $hashids->encodeHex($form->id);
@endphp
<div class="section-body">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-7">

            @if (!empty($form->logo))
                <div class="mb-2 text-center gallery gallery-md">
                    <!-- <img id="app-dark-logo" class="float-none gallery-item"
                        src="{{ asset('vendor/app_logo/logo.png') }}"> -->
                </div>
            @endif
            @if (session()->has('success'))
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center w-100">{{ $form->title }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center gallery" id="success_loader">
                            <img src="{{ asset('assets/images/success.gif') }}" />
                            <br>
                            <br>
                     </div>
                    </div>
                </div>
            @else
                <div class="card">
                    @php
                        $formRules = App\Models\formRule::where('form_id', $form->id)->get();
                        // foreach ($formRules as $formRule) {
                        //     $ifJsonArray = json_decode($formRule->if_json, true);
                        //     $thenJsonArray = json_decode($formRule->then_json, true);
                        // }
                    @endphp
                    <div class="card-header">
                        <h1 class=" survey-name  text-center">{{ $form -> title}}</h1>
                    </div>
                    <div class="card-body form-card-body">
                        <form action="{{ route('forms.fill.store', $form->id) }}" method="POST"
                            enctype="multipart/form-data" id="fill-form">
                            @method('PUT')
                            @if (isset($array))
                                @foreach ($array as $keys => $rows)
                                    <div class="tab">
                                        <div class="row">
                                            @foreach ($rows as $row_key => $row)
                                                @php
                                                    if (isset($row->column)) {
                                                        if ($row->column == 1) {
                                                            $col = 'col-12 step-' . $keys;
                                                        } elseif ($row->column == 2) {
                                                            $col = 'col-6 step-' . $keys;
                                                        } elseif ($row->column == 3) {
                                                            $col = 'col-4 step-' . $keys;
                                                        }  
                                                    } else {
                                                        $col = 'col-12 step-' . $keys;
                                                    }
                                                @endphp
                                                
                                                @if ($row->type == 'checkbox-group')
                                                    <div class="form-group {{ $col }}"
                                                        data-name="{{ $row->name }}">
                                                        <label for="{{ $row->name }}"
                                                            class="d-block form-label">{{ $row->label }}
                                                            @if ($row->required)
                                                                <span
                                                                    class="text-danger align-items-center">*</span>
                                                            @endif
                                                            @if (isset($row->description))
                                                                <span type="button" class="tooltip-element"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ $row->description }}">
                                                                    ?
                                                                </span>
                                                            @endif
                                                        </label>
                                                        @foreach ($row->values as $key => $options)
                                                            @php
                                                                $attr = [
                                                                    'class' => 'form-check-input',
                                                                    'id' => $row->name . '_' . $key,
                                                                ];
                                                                $attr['name'] = $row->name . '[]';
                                                                if ($row->required) {
                                                                    $attr['required'] = 'required';
                                                                    $attr['class'] = $attr['class'] . ' required';
                                                                }
                                                                if ($row->inline) {
                                                                    $class = 'form-check form-check-inline col-4 ';
                                                                    if ($row->required) {
                                                                        $attr['class'] =
                                                                            'form-check-input required';
                                                                    } else {
                                                                        $attr['class'] = 'form-check-input';
                                                                    }
                                                                    $l_class = 'form-check-label mb-0 ml-1';
                                                                } else {
                                                                    $class = 'form-check';
                                                                    if ($row->required) {
                                                                        $attr['class'] =
                                                                            'form-check-input required';
                                                                    } else {
                                                                        $attr['class'] = 'form-check-input';
                                                                    }
                                                                    $l_class = 'form-check-label';
                                                                }
                                                            @endphp
                                                            <div class="{{ $class }}">
                                                                {{ Form::checkbox($row->name, $options->value, isset($options->selected) && $options->selected == 1 ? true : false, $attr) }}
                                                                <label class="{{ $l_class }}"
                                                                    for="{{ $row->name . '_' . $key }}">{{ $options->label }}</label>
                                                            </div>
                                                        @endforeach
                                                        @if ($row->required)
                                                            <div class=" error-message required-checkbox"></div>
                                                        @endif
                                                    </div>
                                                @elseif($row->type == 'file')
                                                    @php
                                                        $attr = [];
                                                        $attr['class'] = 'form-control upload';
                                                        if ($row->multiple) {
                                                            $maxupload = 10;
                                                            $attr['multiple'] = 'true';
                                                            if ($row->subtype != 'fineuploader') {
                                                                $attr['name'] = $row->name . '[]';
                                                            }
                                                        }
                                                        if (
                                                            $row->required &&
                                                            (!isset($row->value) || empty($row->value))
                                                        ) {
                                                            $attr['required'] = 'required';
                                                            $attr['class'] = $attr['class'] . ' required';
                                                        }
                                                        if ($row->subtype == 'fineuploader') {
                                                            $attr['class'] = $attr['class'] . ' ' . $row->name;
                                                        }
                                                    @endphp
                                                    <div class="form-group {{ $col }}"
                                                        data-name="{{ $row->name }}">
                                                        {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                        @if ($row->required)
                                                            <span class="text-danger align-items-center">*</span>
                                                        @endif
                                                        @if (isset($row->description))
                                                            <span type="button" class="tooltip-element"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="{{ $row->description }}">
                                                                ?
                                                            </span>
                                                        @endif
                                                        @if ($row->subtype == 'fineuploader')
                                                            <div class="dropzone" id="{{ $row->name }}"
                                                                data-extention="{{ $row->file_extention }}">
                                                            </div>
                                                            @include('form.js.dropzone')
                                                            {!! Form::hidden($row->name, null, $attr) !!}
                                                        @else
                                                            {{ Form::file($row->name, $attr) }}
                                                        @endif
                                                        @if ($row->required)
                                                            <div class="error-message required-file"></div>
                                                        @endif
                                                    </div>
                                                @elseif($row->type == 'header')
                                                    @php
                                                        $class = '';
                                                        if (isset($row->className)) {
                                                            $class = $class . ' ' . $row->className;
                                                        }
                                                    @endphp
                                                    <div class="{{ $col }}">
                                                        <!-- <{{ $row->subtype }} class="{{ $class }}">
                                                            {{ html_entity_decode($row->label) }}
                                                            </{{ $row->subtype }}> -->
                                                            <h2 class="text-base font-semibold leading-7 text-gray-900">
                                                                 Category : {{ $form->category }}
                                                            </h2>
                                                            <h2 class="text-base font-semibold leading-7 text-gray-900">
                                                                Destination : {{ $form->destination }}
                                                            </h2>
                                                            <h2 class="text-base font-semibold leading-7 text-gray-900">
                                                                Code Tour : {{ $form->code_tour }}
                                                            </h2>
                                                            <h2 class="text-base font-semibold leading-7 text-gray-900">
                                                                Tour Leader : {{ $form->tour_leader_name }}
                                                            </h2>
                                                    </div>
                                                @elseif($row->type == 'paragraph')
                                                    @php
                                                        $class = '';
                                                        if (isset($row->className)) {
                                                            $class = $class . ' ' . $row->className;
                                                        }
                                                    @endphp
                                                    <!-- <div class="{{ $col }}">
                                                        <{{ $row->subtype }} class="{{ $class }}">
                                                            {{ html_entity_decode($row->label) }}
                                                            </{{ $row->subtype }}>
                                                    </div> -->
                                                    <h6 class="text-center w-100">Thank you for choosing AntaVaya.</h6>
                                            <h6 class="text-center w-100">In effort to maintain our service,
                                                we would be grateful if you would take a moment of your time
                                                to complete the questionnaire</h6>
                                            <h3 class="text-center w-100">Welcome to AntaVaya Questionnaire</h3>
                                            <div class="mb-2 text-center gallery gallery-md">
                                                <img id="app-dark-logo" class="float-none gallery-item"
                                                    src="{{ asset('vendor/app_logo/LogoAntaVaya-removebg-preview.png') }}">
                                            </div>
                                                @elseif($row->type == 'radio-group')
                                                    <div class="form-group {{ $col }}"
                                                        data-name={{ $row->name }}>
                                                        <label for="{{ $row->name }}"
                                                            class="d-block form-label">{{ $row->label }}
                                                            @if ($row->required)
                                                                <span
                                                                    class="text-danger align-items-center">*</span>
                                                            @endif
                                                            @if (isset($row->description))
                                                                <span type="button" class="tooltip-element"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ $row->description }}">
                                                                    ?
                                                                </span>
                                                            @endif
                                                        </label>
                                                        @foreach ($row->values as $key => $options)
                                                            @php
                                                                if ($row->required) {
                                                                    $attr['required'] = 'required';
                                                                    $attr = [
                                                                        'class' => 'form-check-input required',
                                                                        'required' => 'required',
                                                                        'id' => $row->name . '_' . $key,
                                                                    ];
                                                                } else {
                                                                    $attr = [
                                                                        'class' => 'form-check-input',
                                                                        'id' => $row->name . '_' . $key,
                                                                    ];
                                                                }
                                                                if ($row->inline) {
                                                                    $class = 'form-check form-check-inline ';
                                                                    if ($row->required) {
                                                                        $attr['class'] =
                                                                            'form-check-input required';
                                                                    } else {
                                                                        $attr['class'] = 'form-check-input';
                                                                    }
                                                                    $l_class = 'form-check-label mb-0 ml-1';
                                                                } else {
                                                                    $class = 'form-check';
                                                                    if ($row->required) {
                                                                        $attr['class'] =
                                                                            'form-check-input required';
                                                                    } else {
                                                                        $attr['class'] = 'form-check-input';
                                                                    }
                                                                    $l_class = 'form-check-label';
                                                                }
                                                            @endphp
                                                            <div class=" {{ $class }}">
                                                                {{ Form::radio($row->name, $options->value, isset($options->selected) && $options->selected ? true : false, $attr) }}
                                                                <label class="{{ $l_class }}"
                                                                    for="{{ $row->name . '_' . $key }}">{{ $options->label }}</label>
                                                            </div>
                                                        @endforeach
                                                        @if ($row->required)
                                                            <div class="error-message required-radio "></div>
                                                        @endif
                                                    </div>
                                                @elseif($row->type == 'select')
                                                    <div class="form-group {{ $col }}">
                                                        {{ Form::label('lead', __('Name of Travel Consultant who serves you (if you know)'), ['class' => 'form-label']) }}
                                                        <select name="lead" id="lead" class='form-control roles' data-trigger>
                                                            <option value="" selected>{{ __('Select Travel Consultant') }}</option>
                                                            @foreach ($tc as $lead)
                                                            <option value="{{ $lead->name }}">{{ $lead->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @elseif($row->type == 'autocomplete')
                                                    <div class="form-group {{ $col }}"
                                                        data-name={{ $row->name }}>
                                                        {{-- @include('form.js.autocomplete') --}}
                                                        @php
                                                            $attr = [
                                                                'class' => 'form-select w-100',
                                                                'id' => 'sschoices-multiple-remove-button',
                                                                'data-trigger',
                                                            ];
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                                $attr['class'] = $attr['class'] . ' required';
                                                            }
                                                            if (isset($row->multiple) && !empty($row->multiple)) {
                                                                $attr['multiple'] = 'true';
                                                                $attr['name'] = $row->name . '[]';
                                                            }
                                                            if (
                                                                isset($row->className) &&
                                                                $row->className == 'calculate'
                                                            ) {
                                                                $attr['class'] =
                                                                    $attr['class'] . ' ' . $row->className;
                                                            }
                                                            if ($row->label == 'Registration') {
                                                                $attr['class'] = $attr['class'] . ' registration';
                                                            }
                                                            if (
                                                                isset($row->is_parent) &&
                                                                $row->is_parent == 'true'
                                                            ) {
                                                                $attr['class'] = $attr['class'] . ' parent';
                                                                $attr['data-number-of-control'] = isset(
                                                                    $row->number_of_control,
                                                                )
                                                                    ? $row->number_of_control
                                                                    : 1;
                                                            }
                                                            $values = [];
                                                            $selected = [];
                                                        @endphp
                                                        <div class="form-group">
                                                            <label for="autocompleteInputZero"
                                                                class="form-label">{{ $row->label }}</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="{{ $row->label }}"
                                                                list="list-timezone" name="autocomplete"
                                                                id="input-datalist">
                                                            <datalist id="list-timezone">
                                                                @foreach ($row->values as $options)
                                                                    @if (is_object($options) && property_exists($options, 'value'))
                                                                        <option value="{{ $options->value }}">
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </datalist>
                                                        </div>
                                                    </div>
                                                @elseif($row->type == 'date')
                                                    <div class="form-group {{ $col }}"
                                                        data-name={{ $row->name }}>
                                                        @php
                                                            $attr = ['class' => 'form-control'];
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                                $attr['class'] = $attr['class'] . ' required';
                                                            }
                                                        @endphp
                                                        {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                        @if ($row->required)
                                                            <span class="text-danger align-items-center">*</span>
                                                        @endif
                                                        @if (isset($row->description))
                                                            <span type="button" class="tooltip-element"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="{{ $row->description }}">
                                                                ?
                                                            </span>
                                                        @endif
                                                        {{ Form::date($row->name, isset($row->value) ? $row->value : null, $attr) }}
                                                        @if ($row->required)
                                                            <div class="error-message required-date"></div>
                                                        @endif
                                                    </div>
                                                @elseif($row->type == 'hidden')
                                                    <div class="form-group {{ $col }}"
                                                        data-name={{ $row->name }}>
                                                        {{ Form::hidden($row->name, isset($row->value) ? $row->value : null) }}
                                                    </div>
                                                @elseif($row->type == 'number')
                                                    <div class="form-group {{ $col }}"
                                                        data-name={{ $row->name }}>
                                                        @php
                                                            $row_class = isset($row->className)
                                                                ? $row->className
                                                                : '';
                                                            $attr = ['class' => 'number ' . $row_class];
                                                            if (isset($row->min)) {
                                                                $attr['min'] = $row->min;
                                                            }
                                                            if (isset($row->max)) {
                                                                $attr['max'] = $row->max;
                                                            }
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                                $attr['class'] = $attr['class'] . ' required ';
                                                            }
                                                        @endphp
                                                        {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                        @if ($row->required)
                                                            <span class="text-danger align-items-center">*</span>
                                                        @endif
                                                        @if (isset($row->description))
                                                            <span type="button" class="tooltip-element"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="{{ $row->description }}">
                                                                ?
                                                            </span>
                                                        @endif
                                                        {{ Form::number($row->name, isset($row->value) ? $row->value : null, $attr) }}
                                                        @if ($row->required)
                                                            <div class="error-message required-number"></div>
                                                        @endif
                                                    </div>
                                                @elseif($row->type == 'textarea')
                                                    <div class="form-group {{ $col }} "
                                                        data-name={{ $row->name }}>
                                                        @php
                                                            $attr = ['class' => 'form-control text-area-height'];
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                                $attr['class'] = $attr['class'] . ' required';
                                                            }
                                                            if (isset($row->rows)) {
                                                                $attr['rows'] = $row->rows;
                                                            } else {
                                                                $attr['rows'] = '3';
                                                            }
                                                            if (isset($row->placeholder)) {
                                                                $attr['placeholder'] = $row->placeholder;
                                                            }
                                                            if ($row->subtype == 'ckeditor') {
                                                                $attr['class'] = $attr['class'] . ' ck_editor';
                                                            }
                                                        @endphp
                                                        {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                        @if ($row->required)
                                                            <span class="text-danger align-items-center">*</span>
                                                        @endif
                                                        @if (isset($row->description))
                                                            <span type="button" class="tooltip-element"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="{{ $row->description }}">
                                                                ?
                                                            </span>
                                                        @endif
                                                        {{ Form::textarea($row->name, isset($row->value) ? $row->value : null, $attr) }}
                                                        @if ($row->required)
                                                            <div class="error-message required-textarea"></div>
                                                        @endif
                                                    </div>
                                                @elseif($row->type == 'button')
                                                    <div class="form-group {{ $col }}"
                                                        data-name={{ $row->name }}>
                                                        @if (isset($row->value) && !empty($row->value))
                                                            <a href="{{ $row->value }}" target="_new"
                                                                class="{{ $row->className }}">{{ __($row->label) }}</a>
                                                        @else
                                                            {{ Form::button(__($row->label), ['name' => $row->name, 'type' => $row->subtype, 'class' => $row->className, 'id' => $row->name]) }}
                                                        @endif
                                                    </div>
                                                @elseif($row->type == 'text')
                                                    @php
                                                        $class = '';
                                                        if ($row->subtype == 'text' || $row->subtype == 'email') {
                                                            $class = 'form-group-text';
                                                        }
                                                    @endphp
                                                    <div class="form-group {{ $class }} {{ $col }}"
                                                        data-name={{ $row->name }}>
                                                        @php
                                                            $attr = ['class' => 'form-control ' . $row->subtype];
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                                $attr['class'] = $attr['class'] . ' required';
                                                            }
                                                            if (isset($row->maxlength)) {
                                                                $attr['max'] = $row->maxlength;
                                                            }
                                                            if (isset($row->placeholder)) {
                                                                $attr['placeholder'] = $row->placeholder;
                                                            }
                                                            $value = isset($row->value) ? $row->value : '';
                                                            if ($row->subtype == 'datetime-local') {
                                                                $row->subtype = 'datetime-local';
                                                                $attr['class'] = $attr['class'] . ' date_time';
                                                            }
                                                        @endphp
                                                        <label for="{{ $row->name }}"
                                                            class="form-label">{{ $row->label }}
                                                            @if ($row->required)
                                                                <span
                                                                    class="text-danger align-items-center">*</span>
                                                            @endif
                                                        </label>
                                                        @if (isset($row->description))
                                                            <span type="button" class="tooltip-element"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="{{ $row->description }}">
                                                                ?
                                                            </span>
                                                        @endif
                                                        {{ Form::input($row->subtype, $row->name, $value, array_merge($attr, ['data-input' => $row->name])) }}
                                                        @if ($row->required)
                                                            <div class="error-message required-text"></div>
                                                        @endif
                                                    </div>
                                                @elseif($row->type == 'starRating')
                                                    <div class="form-group {{ $col }}">
                                                        
                                                    </div>
                                                @elseif($row->type == 'SignaturePad')
                                                    @php
                                                        $attr = ['class' => $row->name];
                                                        if ($row->required) {
                                                            $attr['required'] = 'required';
                                                            $attr['class'] = $attr['class'] . ' required';
                                                        }
                                                        $value = isset($row->value) ? $row->value : null;
                                                    @endphp
                                                    <div class="row form-group {{ $col }}"
                                                        data-name={{ $row->name }}>
                                                        @include('form.js.signature')
                                                        <div class="col-12">
                                                            <label for="{{ $row->name }}"
                                                                class="form-label">{{ $row->label }}</label>
                                                            @if ($row->required)
                                                                <span
                                                                    class="text-danger align-items-center">*</span>
                                                            @endif
                                                            @if (isset($row->description))
                                                                <span type="button" class="tooltip-element"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-placement="top"
                                                                    title="{{ $row->description }}">
                                                                    ?
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <div class="signature-pad-body">
                                                                <canvas class="signaturePad form-control"
                                                                    id="{{ $row->name }}"></canvas>
                                                                <div class="sign-error"></div>
                                                                {!! Form::hidden($row->name, $value, $attr) !!}
                                                                <div class="buttons signature_buttons">
                                                                    <button id="save{{ $row->name }}"
                                                                        type="button" data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom"
                                                                        data-bs-original-title="{{ __('Save') }}"
                                                                        class="btn btn-primary btn-sm">{{ __('Save') }}</button>
                                                                    <button id="clear{{ $row->name }}"
                                                                        type="button" data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom"
                                                                        data-bs-original-title="{{ __('Clear') }}"
                                                                        class="btn btn-danger btn-sm">{{ __('Clear') }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- @if (@$row->value != '')
                                                            <div class="col-lg-6 col-md-12 col-12">
                                                                <img src="{{ Storage::url($row->value) }}"
                                                                    width="80%" class="border" alt="">
                                                            </div>
                                                        @endif -->
                                                    </div>
                                                @elseif($row->type == 'break')
                                                    <div class="form-group {{ $col }}"
                                                        {{ Form::label('desti', __('13. What country do you plan your next holiday to (rencana liburan berikutnya negara mana) ?'), ['class' => 'form-label']) }}<br>
                                                        @foreach($dest as $desti)
                                                            <label>
                                                                <input type="checkbox" name="desti" value="{{ $desti->name }}" 
                                                                    {{ in_array($desti->name, $selectedOptions) ? 'checked' : '' }} onclick="onlyOneCheckbox(this)"> 
                                                                {{ $desti->name }}
                                                            </label><br>
                                                        @endforeach
                                                            <label>
                                                                <input type="checkbox" name="desti" value="Other" id="other-checkbox"> Other
                                                            </label>
                                                            <input type="text"  class="form-control" name="other_choice" id="other-input" placeholder="Please specify" style="display: none;"><br>
                                                    </div>                     
                                               @elseif($row->type == 'location')
                                                    <div class="form-group {{ $col }}"
                                                        data-name={{ $row->name }}>
                                                        @include('form.js.map')
                                                        <input id="pac-input" class="controls" type="text"
                                                            name="location" placeholder="Search Box" />
                                                        <div id="map"></div>
                                                    </div>
                                                @elseif($row->type == 'video')
                                                    @php
                                                        $attr = ['class' => $row->name];
                                                        if ($row->required) {
                                                            $attr['required'] = 'required';
                                                            $attr['class'] = $attr['class'] . ' required';
                                                        }
                                                        $value = isset($row->value) ? $row->value : null;
                                                    @endphp
                                                    <div class="row form-group {{ $col }}"
                                                        data-name={{ $row->name }}>
                                                        @include('form.js.video')
                                                        <label for="{{ $row->name }}"
                                                            class="form-label">{{ $row->label }}</label>
                                                        @if ($row->required)
                                                            <span class="text-danger align-items-center">*</span>
                                                        @endif
                                                        <div class="d-flex justify-content-start">
                                                            <!-- <button type="button" class="btn btn-primary"
                                                                id="videostream">
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24"
                                                                        viewBox="0 0 24 24">
                                                                        <path
                                                                            d="M5 5h-3v-1h3v1zm8 5c-1.654 0-3 1.346-3 3s1.346 3 3 3 3-1.346 3-3-1.346-3-3-3zm11-4v15h-24v-15h5.93c.669 0 1.293-.334 1.664-.891l1.406-2.109h8l1.406 2.109c.371.557.995.891 1.664.891h3.93zm-19 4c0-.552-.447-1-1-1-.553 0-1 .448-1 1s.447 1 1 1c.553 0 1-.448 1-1zm13 3c0-2.761-2.239-5-5-5s-5 2.239-5 5 2.239 5 5 5 5-2.239 5-5z"
                                                                            fill="black" />
                                                                    </svg>
                                                                </span>
                                                                {{ __('Record Video') }}
                                                            </button> -->
                                                        </div>
                                                        @if ($row->required)
                                                            <div class="error-message required-text"></div>
                                                        @endif
                                                        <div class="cam-buttons d-none">
                                                            <video autoplay controls id="web-cam-container"
                                                                class="p-2" style="width:100%; height:80%;">
                                                                {{ __("Your browser doesn't support the video tag") }}
                                                            </video>
                                                            <div class="py-4">
                                                                <div class="field-required">
                                                                    <div
                                                                        class="mb-2 btn btn-lg btn-primary float-end">
                                                                        <div id="timer">
                                                                            <span id="hours">00:</span>
                                                                            <span id="mins">00:</span>
                                                                            <span id="seconds">00</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id='gUMArea' class="video_cam">
                                                                    <div class="web_cam_video">
                                                                        <input type="hidden"
                                                                            class="{{ implode(' ', $attr) }}"
                                                                            name="media" checked
                                                                            value="{{ $value }}"
                                                                            id="mediaVideo">

                                                                    </div>
                                                                </div>
                                                                <!-- <div id='btns'>
                                                                    <div id="controls">
                                                                        <button class="btn btn-light-primary"
                                                                            id='start' type="button">
                                                                            <span class="svg-icon svg-icon-2">
                                                                                <span class="svg-icon svg-icon-2">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        width="24"
                                                                                        height="24"
                                                                                        viewBox="0 0 24 24">
                                                                                        <path
                                                                                            d="M16 18c0 1.104-.896 2-2 2h-12c-1.105 0-2-.896-2-2v-12c0-1.104.895-2 2-2h12c1.104 0 2 .896 2 2v12zm8-14l-6 6.223v3.554l6 6.223v-16z"
                                                                                            fill="black" />
                                                                                    </svg>
                                                                                </span>
                                                                            </span>
                                                                            {{ __('Start') }}
                                                                        </button>
                                                                        <button class="btn btn-light-danger"
                                                                            id='stop' type="button">
                                                                            <span class="svg-icon svg-icon-2">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24"
                                                                                    viewBox="0 0 24 24">
                                                                                    <path d="M2 2h20v20h-20z"
                                                                                        fill="black" />
                                                                                </svg>
                                                                            </span>
                                                                            <span
                                                                                class="indicator-label">{{ __('Stop') }}</span>
                                                                        </button>
                                                                    </div>
                                                                </div> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($row->type == 'selfie')
                                                    @php
                                                        $attr = ['class' => $row->name];
                                                        if ($row->required) {
                                                            $attr['required'] = 'required';
                                                            $attr['class'] = $attr['class'] . ' required';
                                                        }
                                                        $value = isset($row->value) ? $row->value : null;
                                                    @endphp
                                                    <div class="row {{ $col }} selfie_screen"
                                                        data-name={{ $row->name }}>
                                                        @include('form.js.selfie')
                                                        <div class="col-md-6 selfie_photo">
                                                            <div class="form-group">
                                                                <label for="{{ $row->name }}"
                                                                    class="form-label">{{ $row->label }}</label>
                                                                @if ($row->required)
                                                                    <span
                                                                        class="text-danger align-items-center">*</span>
                                                                @endif
                                                                <div id="my_camera" class="camera_screen"></div>
                                                                <br />
                                                                <!-- <button type="button"
                                                                    class="btn btn-default btn-light-primary"
                                                                    onClick="take_snapshot()">
                                                                    <i class="ti ti-camera"></i>
                                                                    {{ __('Take Selfie') }}
                                                                </button> -->
                                                                <input type="hidden" name="image"
                                                                    value="{{ $value }}"
                                                                    class="image-tag  {{ implode(' ', $attr) }}">
                                                            </div>

                                                        </div>
                                                        <div class="mt-4 col-md-6">
                                                            <div id="results" class="selfie_result">
                                                                {{ __('Your captured image will appear here...') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                               
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            <!-- <div class="row">
                                <div class="col cap">
                                    @if (UtilityFacades::getsettings('captcha_enable') == 'on')
                                        @if (UtilityFacades::getsettings('captcha') == 'hcaptcha')
                                            {!! HCaptcha::renderJs() !!}
                                            <small
                                                class="text-danger font-weight-bold">{{ __('Note :- reCAPTCHA Is required') }}</small>
                                            <div class="g-hcaptcha"
                                                data-sitekey="{{ UtilityFacades::getsettings('hcaptcha_key') }}">
                                            </div>
                                            {!! HCaptcha::display() !!}
                                            @error('g-hcaptcha-response')
                                                <span class="text-danger text-bold">{{ $message }}</span>
                                            @enderror
                                        @endif
                                        @if (UtilityFacades::getsettings('captcha') == 'recaptcha')
                                            {!! NoCaptcha::renderJs() !!}
                                            <small
                                                class="text-danger font-weight-bold">{{ __('Note :- reCAPTCHA Is required') }}</small>
                                            <div class="g-recaptcha"
                                                data-sitekey="{{ UtilityFacades::getsettings('captcha_sitekey') }}">
                                            </div>
                                            {!! NoCaptcha::display() !!}
                                        @endif
                                    @endif

                                    <div class="pb-0 mt-3 form-actions">
                                        <input type="hidden" name="form_value_id"
                                            value="{{ isset($formValue) ? $formValue->id : '' }}"
                                            id="form_value_id">
                                    </div>
                                </div>
                            </div> -->

                            @if (!isset($formValue) && $form->payment_status == 1)
                                @if (!isset($formValue) && $form->payment_type == 'stripe')
                                    <div class="strip">
                                        <strong class="d-block">{{ __('Payment') }}
                                            ({{ $form->currency_symbol }}{{ $form->amount }})</strong>
                                        <div id="card-element" class="form-control">
                                        </div>
                                        <span id="card-errors" class="payment-errors"></span>
                                        <br>
                                    </div>
                                @elseif(!isset($formValue) && $form->payment_type == 'razorpay')
                                    <div class="razorpay">
                                        <p>{{ __('Make Payment') }}</p>
                                        <input type="hidden" name="payment_id" id="payment_id">
                                        <h5>{{ __('Payable Amount') }} : {{ $form->currency_symbol }}
                                            {{ $form->amount }}</h5>
                                    </div>
                                @elseif(!isset($formValue) && $form->payment_type == 'paypal')
                                    <div class="paypal">
                                        <p>{{ __('Make Payment') }}</p>
                                        <input type="hidden" name="payment_id" id="payment_id">
                                        <h5>{{ __('Payable Amount') }} : {{ $form->currency_symbol }}
                                            {{ $form->amount }}</h5>
                                        <div id="paypal-button-container"></div>
                                        <span id="paypal-errors" class="payment-errors"></span>
                                        <br>
                                    </div>
                                @elseif(!isset($formValue) && $form->payment_type == 'paytm')
                                    <div class="paytm">
                                        <p>{{ __('Make Payment') }}</p>
                                        {!! Form::hidden('payment_id', null, ['id' => 'payment_id']) !!}
                                        <h5>{{ __('Payble Amount') }} : {{ $form->currency_symbol }}
                                            {{ $form->amount }}</h5>
                                    </div>
                                @elseif(!isset($formValue) && $form->payment_type == 'flutterwave')
                                    <div class="flutterwave">
                                        <p>{{ __('Make Payment') }}</p>
                                        {!! Form::hidden('payment_id', null, ['id' => 'payment_id']) !!}
                                        <h5>{{ __('Payble Amount') }} : {{ $form->currency_symbol }}
                                            {{ $form->amount }}</h5>
                                    </div>
                                @elseif(!isset($formValue) && $form->payment_type == 'paystack')
                                    <div class="paystack">
                                        <p>{{ __('Make Payment') }}</p>
                                        {!! Form::hidden('payment_id', null, ['id' => 'payment_id']) !!}
                                        <h5>{{ __('Payble Amount') }} : {{ $form->currency_symbol }}
                                            {{ $form->amount }}</h5>
                                    </div>
                                @elseif(!isset($formValue) && $form->payment_type == 'coingate')
                                    <div class="coingate">
                                        <p>{{ __('Make Payment') }}</p>
                                        {!! Form::hidden('payment_id', null, ['id' => 'payment_id']) !!}
                                        <h5>{{ __('Payble Amount') }} : {{ $form->currency_symbol }}
                                            {{ $form->amount }}</h5>
                                    </div>
                                @elseif(!isset($formValue) && $form->payment_type == 'mercado')
                                    <div class="mercado">
                                        <p>{{ __('Make Payment') }}</p>
                                        {!! Form::hidden('payment_id', null, ['id' => 'payment_id']) !!}
                                        <h5>{{ __('Payble Amount') }} : {{ $form->currency_symbol }}
                                            {{ $form->amount }}</h5>
                                    </div>
                                @elseif(!isset($formValue) && $form->payment_type == 'payumoney')
                                    <div class="payumoney">
                                        <p>{{ __('Make Payment') }}</p>
                                        {!! Form::hidden('payment_id', null, ['id' => 'payment_id']) !!}
                                        <h5>{{ __('Payble Amount') }} : {{ $form->currency_symbol }}
                                            {{ $form->amount }}</h5>
                                    </div>
                                @elseif(!isset($formValue) && $form->payment_type == 'mollie')
                                    <div class="mollie">
                                        <p>{{ __('Make Payment') }}</p>
                                        {!! Form::hidden('payment_id', null, ['id' => 'payment_id']) !!}
                                        <h5>{{ __('Payble Amount') }} : {{ $form->currency_symbol }}
                                            {{ $form->amount }}</h5>
                                    </div>
                                @elseif (!isset($formValue) && $form->payment_type == 'offlinepayment')
                                    <div class="offlinepayment">
                                        <p>{{ __('Make Payment') }}</p>
                                        <input type="hidden" name="payment_id" id="payment_id">
                                        <h5>{{ __('Payble Amount') }} : {{ $form->currency_symbol }}
                                            {{ $form->amount }}</h5>

                                        <div class="form-group">
                                            {{ Form::label('payment_details', __('Payment Details'), ['class' => 'form-label']) }}
                                            <P>{{ UtilityFacades::getsettings('offline_payment_details') }}</P>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('transfer_slip', __('Upload Payment Slip'), ['class' => 'form-label']) }}
                                            <span>{{ __('( jpg, png, pdf )') }}</span>
                                            {!! Form::file('transfer_slip', ['class' => 'form-control required', 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                @endif
                            @endif
                            {{ Form::hidden('ip_data', '', ['id' => 'ip_data']) }}
                            <div class="over-auto">
                                <div class="float-right">
                                    {!! Form::button(__('Previous'), ['class' => 'btn btn-default', 'id' => 'prevBtn', 'onclick' => 'nextPrev(-1)']) !!}
                                    {!! Form::button(__('Next'), ['class' => 'btn btn-primary', 'id' => 'nextBtn', 'onclick' => 'nextPrev(1)']) !!}
                                </div>
                            </div>
                            <div class="extra_style">
                                @if (isset($array))
                                    @foreach ($array as $keys => $rows)
                                        <span class="step"></span>
                                    @endforeach
                                @endif
                            </div>
                        </form>
                        {!! Form::open(['route' => ['coingateprepare'], 'method' => 'post', 'id' => 'coingate_payment_frms']) !!}
                        {{ Form::hidden('cg_currency', null, ['id' => 'cg_currency']) }}
                        {{ Form::hidden('cg_amount', null, ['id' => 'cg_amount']) }}
                        {{ Form::hidden('cg_form_id', null, ['id' => 'cg_form_id']) }}
                        {!! Form::hidden('cg_submit_type', null, ['id' => 'cg_submit_type']) !!}
                        {!! Form::close() !!}
                        {!! Form::open([
                            'route' => ['payumoneyfillprepare'],
                            'method' => 'post',
                            'id' => 'payumoney_payment_frms',
                            'name' => 'payuForm',
                        ]) !!}
                        <!-- {{ Form::hidden('payumoney_currency', null, ['id' => 'payumoney_currency']) }}
                        {{ Form::hidden('payumoney_amount', null, ['id' => 'payumoney_amount']) }}
                        {{ Form::hidden('payumoney_form_id', null, ['id' => 'payumoney_form_id']) }}
                        {{ Form::hidden('payumoney_created_by', null, ['id' => 'payumoney_created_by']) }}
                        {!! Form::hidden('payumoney_submit_type', null, ['id' => 'payumoney_submit_type']) !!} -->
                        {!! Form::close() !!}
                        <!-- {!! Form::open([
                            'route' => ['molliefillprepare'],
                            'method' => 'post',
                            'id' => 'mollie_payment_frms',
                            'name' => 'mollieForm',
                        ]) !!}
                        {{ Form::hidden('mollie_currency', null, ['id' => 'mollie_currency']) }}
                        {{ Form::hidden('mollie_amount', null, ['id' => 'mollie_amount']) }}
                        {{ Form::hidden('mollie_form_id', null, ['id' => 'mollie_form_id']) }}
                        {{ Form::hidden('mollie_created_by', null, ['id' => 'mollie_created_by']) }}
                        {!! Form::hidden('mollie_submit_type', null, ['id' => 'mollie_submit_type']) !!}
                        {!! Form::close() !!}
                        {!! Form::open(['route' => ['mercadofillprepare'], 'method' => 'post', 'id' => 'mercado_payment_frms']) !!}
                        {{ Form::hidden('mercado_amount', null, ['id' => 'mercado_amount']) }}
                        {{ Form::hidden('mercado_form_id', null, ['id' => 'mercado_form_id']) }}
                        {{ Form::hidden('mercado_created_by', null, ['id' => 'mercado_created_by']) }}
                        {!! Form::hidden('mercado_submit_type', null, ['id' => 'mercado_submit_type']) !!}
                        {!! Form::close() !!} -->
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@if ($form->conditional_rule == '1')
    @include('form.js.conditional-rule')
@endif
@push('script')
<script src="{{ asset('vendor/location-get/intlTelInput.min.js') }}"></script>
<script src="{{ asset('vendor/location-get/utils.js') }}"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $.get("https://ipinfo.io", function(data) {
                $('#ip_data').val(JSON.stringify(data));
            }, "jsonp");
        }, 2000);
    });
</script>
<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/clipboard.min.js') }}"></script>
<script>
    new ClipboardJS('[data-clipboard=true]').on('success', function(e) {
        e.clearSelection();
    });
</script>
<script>
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).attr('data-url')).select();
        document.execCommand("copy");
        $temp.remove();
        show_toastr('Great!', '{{ __('Copy Link Successfully..') }}', 'success',
            '{{ asset('assets/images/notification/ok-48.png') }}', 4000);
    }

    $(document).ready(function() {
        let area = document.createElement('textarea');
        document.body.appendChild(area);
        area.style.display = "none";
        let content = document.querySelectorAll('.js-content');
        let copy = document.querySelectorAll('.js-copy');
        for (let i = 0; i < copy.length; i++) {
            copy[i].addEventListener('click', function() {
                area.style.display = "block";
                area.value = content[i].innerText;
                area.select();
                document.execCommand('copy');
                area.style.display = "none";
                this.innerHTML = 'Copied ';
                setTimeout(() => this.innerHTML = "Copy", 2000);
            });
        }
    });
</script>
<script>
    function onlyOneCheckbox(checkbox) {
        // Dapatkan semua checkbox dengan nama 'option[]'
        var checkboxes = document.getElementsByName('desti');
        
        // Loop melalui checkbox dan matikan yang lain jika salah satu dipilih
        checkboxes.forEach((item) => {
            if (item !== checkbox) item.checked = false;
        });
    }
</script>
<script>
    document.getElementById('other-checkbox').addEventListener('change', function() {
        const otherInput = document.getElementById('other-input');
        if (this.checked) {
            otherInput.style.display = 'block';
        } else {
            otherInput.style.display = 'none';
        }
    });
</script>
@endpush
