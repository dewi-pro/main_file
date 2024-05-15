@php
    $twilioJsonkey = isset($twilioJsonkey) ? $twilioJsonkey : '';
@endphp
<div class="accordion-item card aria-twilio">
    <h2 class="accordion-header" id="heading-twilio">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapsetwilio-{{ $twilioJsonkey }}" aria-expanded="false" aria-controls="collapsetwilio">
            <span class="flex-1 d-flex align-items-center">
                <i class="ti ti-layout-bottombar text-primary"></i>
                {{ __('Twilio') }}
            </span>
            <div class="d-flex align-items-center">
                <a href="#" class="mr-2 btn btn-danger btn-sm me-3 remove-card"><i class="ti ti-trash"></i></a>
            </div>
        </button>
    </h2>
    <div id="collapsetwilio-{{ $twilioJsonkey }}" class="accordion-collapse collapse" aria-labelledby="heading-twilio"
        data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('twilio_mobile_number' . $twilioJsonkey, __('Twilio Mobile Number'), ['class' => 'form-label']) }}
                        {{ Form::number('twilio_mobile_number[]', isset($twilioJson['twilio_mobile_number']) ? $twilioJson['twilio_mobile_number'] : null, ['class' => 'form-control', 'required', 'id' => 'twilio_mobile_number' . $twilioJsonkey, 'placeholder' => __('Enter twilio mobile number')]) }}
                        <small>{{ __('Note: Please enter the mobile number for send sms. Example: 911234567890') }}</small>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('twilio_sid' . $twilioJsonkey, __('Twilio Sid'), ['class' => 'form-label']) }}
                        {{ Form::text('twilio_sid[]', isset($twilioJson['twilio_sid']) ? $twilioJson['twilio_sid'] : null, ['class' => 'form-control', 'required', 'id' => "twilio_sid$twilioJsonkey", 'placeholder' => __('Enter twilio sid')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('twilio_auth_token' . $twilioJsonkey, __('Twilio Auth Token'), ['class' => 'form-label']) }}
                        {{ Form::text('twilio_auth_token[]', isset($twilioJson['twilio_auth_token']) ? $twilioJson['twilio_auth_token'] : null, ['class' => 'form-control', 'required', 'id' => "twilio_auth_token$twilioJsonkey", 'placeholder' => __('Enter twilio auth token')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('twilio_number' . $twilioJsonkey, __('Twilio Number'), ['class' => 'form-label']) }}
                        {{ Form::text('twilio_number[]', isset($twilioJson['twilio_number']) ? $twilioJson['twilio_number'] : null, ['class' => 'form-control', 'required', 'id' => "twilio_number$twilioJsonkey", 'placeholder' => __('Enter twilio number')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('twilio_field' . $twilioJsonkey, __('twilio Field'), ['class' => 'form-label']) }}
                        <select name="twilio_field{{ $twilioJsonkey }}[]" class="form-select" data-trigger multiple
                            required id="twilio_field{{ $twilioJsonkey }}">
                            <option value="">{{ __('Select Value') }}</option>
                            @foreach ($formJsons as $formJson)
                                @foreach ($formJson as $fornVal)
                                    @php
                                        $excludedTypes = ['button', 'header', 'hidden', 'paragraph', 'video', 'selfie', 'break', 'location', 'file', 'SignaturePad'];
                                    @endphp
                                    @if (!in_array($fornVal->type, $excludedTypes))
                                        @isset($twilioFieldJsons)
                                            @if (isset($twilioFieldJsons[$twilioJsonkey]))
                                                @foreach ($twilioFieldJsons as $twilioFieldkey => $twilioFieldJson)
                                                    @php
                                                        $twilioarr = explode(',', $twilioFieldJson);
                                                    @endphp
                                                    @if ($twilioFieldkey == $twilioJsonkey)
                                                        <option value="{{ $fornVal->name }}"
                                                            {{ in_array($fornVal->name, $twilioarr) ? 'selected' : '' }}>
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
                        <div class="error-message" id="bouncer-error_twilio_field{{ $twilioJsonkey }}[]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
