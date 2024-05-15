@php
    $clockworkJsonkey = isset($clockworkJsonkey) ? $clockworkJsonkey : '';
@endphp
<div class="accordion-item card aria-clockwork">
    <h2 class="accordion-header" id="heading-clockwork">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseclockwork-{{ $clockworkJsonkey }}" aria-expanded="false"
            aria-controls="collapseclockwork">
            <span class="flex-1 d-flex align-items-center">
                <i class="ti ti-layout-bottombar text-primary"></i>
                {{ __('Clockwork') }}
            </span>
            <div class="d-flex align-items-center">
                <a href="#" class="mr-2 btn btn-danger btn-sm me-3 remove-card"><i class="ti ti-trash"></i></a>
            </div>
        </button>
    </h2>
    <div id="collapseclockwork-{{ $clockworkJsonkey }}" class="accordion-collapse collapse"
        aria-labelledby="heading-clockwork" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('clockwork_number' . $clockworkJsonkey, __('Clockwork Number'), ['class' => 'form-label']) }}
                        {{ Form::number('clockwork_number[]', isset($clockworkJson['clockwork_number']) ? $clockworkJson['clockwork_number'] : null, ['class' => 'form-control', 'required', 'id' => "clockwork_number$clockworkJsonkey", 'placeholder' => __('Enter clockwork number')]) }}
                        <small>{{ __('Note: Please enter the mobile number for send sms. Example: 911234567890') }}</small>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('clockwork_api_token' . $clockworkJsonkey, __('Clockwork Api Token'), ['class' => 'form-label']) }}
                        {{ Form::text('clockwork_api_token[]', isset($clockworkJson['clockwork_api_token']) ? $clockworkJson['clockwork_api_token'] : null, ['class' => 'form-control', 'required', 'id' => "clockwork_api_token$clockworkJsonkey", 'placeholder' => __('Enter clockwork api key')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('clockwork_field' . $clockworkJsonkey, __('Clockwork Field'), ['class' => 'form-label']) }}
                        <select name="clockwork_field{{ $clockworkJsonkey }}[]" class="form-select" data-trigger
                            required multiple id="clockwork_field{{ $clockworkJsonkey }}">
                            <option value="">{{ __('Select Value') }}</option>
                            @foreach ($formJsons as $formJson)
                                @foreach ($formJson as $fornVal)
                                    @php
                                        $excludedTypes = ['button', 'header', 'hidden', 'paragraph', 'video', 'selfie', 'break', 'location', 'file', 'SignaturePad'];
                                    @endphp
                                    @if (!in_array($fornVal->type, $excludedTypes))
                                        @isset($clockworkFieldJsons)
                                            @if (isset($clockworkFieldJsons[$clockworkJsonkey]))
                                                @foreach ($clockworkFieldJsons as $clockworkFieldkey => $clockworkFieldJson)
                                                    @php
                                                        $clockworkarr = explode(',', $clockworkFieldJson);
                                                    @endphp
                                                    @if ($clockworkFieldkey == $clockworkJsonkey)
                                                        <option value="{{ $fornVal->name }}"
                                                            {{ in_array($fornVal->name, $clockworkarr) ? 'selected' : '' }}>
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
                        <div class="error-message" id="bouncer-error_clockwork_field{{ $clockworkJsonkey }}[]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
