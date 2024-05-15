@php
    $textlocalJsonkey = isset($textlocalJsonkey) ? $textlocalJsonkey : '';
@endphp
<div class="accordion-item card aria-textlocal">
    <h2 class="accordion-header" id="heading-textlocal">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapsetextlocal-{{ $textlocalJsonkey }}" aria-expanded="false"
            aria-controls="collapsetextlocal">
            <span class="flex-1 d-flex align-items-center">
                <i class="ti ti-layout-bottombar text-primary"></i>
                {{ __('Textlocal') }}
            </span>
            <div class="d-flex align-items-center">
                <a href="#" class="mr-2 btn btn-danger btn-sm me-3 remove-card"><i class="ti ti-trash"></i></a>
            </div>
        </button>
    </h2>
    <div id="collapsetextlocal-{{ $textlocalJsonkey }}" class="accordion-collapse collapse"
        aria-labelledby="heading-textlocal" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('textlocal_number' . $textlocalJsonkey, __('Textlocal Number'), ['class' => 'form-label']) }}
                        {{ Form::number('textlocal_number[]', isset($textlocalJson['textlocal_number']) ? $textlocalJson['textlocal_number'] : null, ['class' => 'form-control', 'required', 'id' => 'textlocal_number' . $textlocalJsonkey, 'placeholder' => __('Enter textlocal number')]) }}
                        <small>{{ __('Note: Please enter the mobile number for send sms. Example: 911234567890') }}</small>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('textlocal_api_key' . $textlocalJsonkey, __('Textlocal Api Key'), ['class' => 'form-label']) }}
                        {{ Form::text('textlocal_api_key[]', isset($textlocalJson['textlocal_api_key']) ? $textlocalJson['textlocal_api_key'] : null, ['class' => 'form-control', 'required', 'id' => "textlocal_api_key$textlocalJsonkey", 'placeholder' => __('Enter textlocal api key')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('textlocal_field' . $textlocalJsonkey, __('textlocal Field'), ['class' => 'form-label']) }}
                        <select name="textlocal_field{{ $textlocalJsonkey }}[]" class="form-select" data-trigger
                            multiple required id="textlocal_field{{ $textlocalJsonkey }}">
                            <option value="">{{ __('Select Value') }}</option>
                            @foreach ($formJsons as $formJson)
                                @foreach ($formJson as $fornVal)
                                    @php
                                        $excludedTypes = ['button', 'header', 'hidden', 'paragraph', 'video', 'selfie', 'break', 'location', 'file', 'SignaturePad'];
                                    @endphp
                                    @if (!in_array($fornVal->type, $excludedTypes))
                                        @isset($textlocalFieldJsons)
                                            @if (isset($textlocalFieldJsons[$textlocalJsonkey]))
                                                @foreach ($textlocalFieldJsons as $textlocalFieldkey => $textlocalFieldJson)
                                                    @php
                                                        $textlocalarr = explode(',', $textlocalFieldJson);
                                                    @endphp
                                                    @if ($textlocalFieldkey == $textlocalJsonkey)
                                                        <option value="{{ $fornVal->name }}"
                                                            {{ in_array($fornVal->name, $textlocalarr) ? 'selected' : '' }}>
                                                            {{ $fornVal->label . ' (' . $fornVal->name . ')' }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @else
                                                <option value="{{ $fornVal->name }}">
                                                    {{ $fornVal->label . ' (' . $fornVal->name . ')' }}
                                                </option>
                                            @endif
                                        @else
                                            <option value="{{ $fornVal->name }}">
                                                {{ $fornVal->label . ' (' . $fornVal->name . ')' }}
                                            </option>
                                        @endisset
                                    @endif
                                @endforeach
                            @endforeach
                        </select>
                        <div class="error-message" id="bouncer-error_textlocal_field{{ $textlocalJsonkey }}[]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
