@php
    $fast2smsJsonkey = isset($fast2smsJsonkey) ? $fast2smsJsonkey : '';
@endphp
<div class="accordion-item card aria-fast2sms">
    <h2 class="accordion-header" id="heading-fast2sms">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapsefast2sms-{{ $fast2smsJsonkey }}" aria-expanded="false"
            aria-controls="collapsefast2sms">
            <span class="flex-1 d-flex align-items-center">
                <i class="ti ti-layout-bottombar text-primary"></i>
                {{ __('Fast2SMS') }}
            </span>
            <div class="d-flex align-items-center">
                <a href="#" class="mr-2 btn btn-danger btn-sm me-3 remove-card"><i class="ti ti-trash"></i></a>
            </div>
        </button>
    </h2>
    <div id="collapsefast2sms-{{ $fast2smsJsonkey }}" class="accordion-collapse collapse"
        aria-labelledby="heading-fast2sms" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('fast2sms_number' . $fast2smsJsonkey, __('Fast2SMS Number'), ['class' => 'form-label']) }}
                        {{ Form::number('fast2sms_number[]', isset($fast2smsJson['fast2sms_number']) ? $fast2smsJson['fast2sms_number'] : null, ['class' => 'form-control', 'required', 'id' => "fast2sms_number$fast2smsJsonkey", 'placeholder' => __('Enter fast2sms number')]) }}
                        <small>{{ __('Note: Please enter the mobile number for send sms. Example: 1234567890') }}</small>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('fast2sms_api_key' . $fast2smsJsonkey, __('Fast2SMS Api Key'), ['class' => 'form-label']) }}
                        {{ Form::text('fast2sms_api_key[]', isset($fast2smsJson['fast2sms_api_key']) ? $fast2smsJson['fast2sms_api_key'] : null, ['class' => 'form-control', 'required', 'id' => "fast2sms_api_key$fast2smsJsonkey", 'placeholder' => __('Enter fast2sms api key')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('fast2sms_field' . $fast2smsJsonkey, __('Fast2SMS Field'), ['class' => 'form-label']) }}
                        <select name="fast2sms_field{{ $fast2smsJsonkey }}[]" class="form-select" data-trigger multiple
                            required id="fast2sms_field{{ $fast2smsJsonkey }}">
                            <option value="">{{ __('Select Value') }}</option>
                            @foreach ($formJsons as $formJson)
                                @foreach ($formJson as $fornVal)
                                    @php
                                        $excludedTypes = ['button', 'header', 'hidden', 'paragraph', 'video', 'selfie', 'break', 'location', 'file', 'SignaturePad'];
                                    @endphp
                                    @if (!in_array($fornVal->type, $excludedTypes))
                                        @isset($fast2smsFieldJsons)
                                            @if (isset($fast2smsFieldJsons[$fast2smsJsonkey]))
                                                @foreach ($fast2smsFieldJsons as $fast2smsFieldkey => $fast2smsFieldJson)
                                                    @php
                                                        $fast2smsarr = explode(',', $fast2smsFieldJson);
                                                    @endphp
                                                    @if ($fast2smsFieldkey == $fast2smsJsonkey)
                                                        <option value="{{ $fornVal->name }}"
                                                            {{ in_array($fornVal->name, $fast2smsarr) ? 'selected' : '' }}>
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
                        <div class="error-message" id="bouncer-error_fast2sms_field{{ $fast2smsJsonkey }}[]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
