@php
    $messenteJsonkey = isset($messenteJsonkey) ? $messenteJsonkey : '';
@endphp
<div class="accordion-item card aria-messente">
    <h2 class="accordion-header" id="heading-messente">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapsemessente-{{ $messenteJsonkey }}" aria-expanded="false"
            aria-controls="collapsemessente">
            <span class="flex-1 d-flex align-items-center">
                <i class="ti ti-layout-bottombar text-primary"></i>
                {{ __('Messente') }}
            </span>
            <div class="d-flex align-items-center">
                <a href="#" class="mr-2 btn btn-danger btn-sm me-3 remove-card"><i class="ti ti-trash"></i></a>
            </div>
        </button>
    </h2>
    <div id="collapsemessente-{{ $messenteJsonkey }}" class="accordion-collapse collapse"
        aria-labelledby="heading-messente" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('messente_number' . $messenteJsonkey, __('messente Number'), ['class' => 'form-label']) }}
                        {{ Form::number('messente_number[]', isset($messenteJson['messente_number']) ? $messenteJson['messente_number'] : null, ['class' => 'form-control', 'required', 'id' => 'messente_number' . $messenteJsonkey, 'placeholder' => __('Enter messente number')]) }}
                        <small>{{ __('Note: Please enter the mobile number for send sms. Example: 911234567890') }}</small>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('messente_api_username' . $messenteJsonkey, __('Messente Api Username'), ['class' => 'form-label']) }}
                        {{ Form::text('messente_api_username[]', isset($messenteJson['messente_api_username']) ? $messenteJson['messente_api_username'] : null, ['class' => 'form-control', 'required', 'id' => "messente_api_username$messenteJsonkey", 'placeholder' => __('Enter messente api username')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('messente_api_password' . $messenteJsonkey, __('Messente Api Password'), ['class' => 'form-label']) }}
                        {{ Form::text('messente_api_password[]', isset($messenteJson['messente_api_password']) ? $messenteJson['messente_api_password'] : null, ['class' => 'form-control', 'required', 'id' => "messente_api_password$messenteJsonkey", 'placeholder' => __('Enter messente api password')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('messente_sender' . $messenteJsonkey, __('Messente Sender'), ['class' => 'form-label']) }}
                        {{ Form::text('messente_sender[]', isset($messenteJson['messente_sender']) ? $messenteJson['messente_sender'] : null, ['class' => 'form-control', 'required', 'id' => "messente_sender$messenteJsonkey", 'placeholder' => __('Enter messente sender')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('messente_field' . $messenteJsonkey, __('messente Field'), ['class' => 'form-label']) }}
                        <select name="messente_field{{ $messenteJsonkey }}[]" class="form-select" data-trigger multiple
                            required id="messente_field{{ $messenteJsonkey }}">
                            <option value="">{{ __('Select Value') }}</option>
                            @foreach ($formJsons as $formJson)
                                @foreach ($formJson as $fornVal)
                                    @php
                                        $excludedTypes = ['button', 'header', 'hidden', 'paragraph', 'video', 'selfie', 'break', 'location', 'file', 'SignaturePad'];
                                    @endphp
                                    @if (!in_array($fornVal->type, $excludedTypes))
                                        @isset($messenteFieldJsons)
                                            @if (isset($messenteFieldJsons[$messenteJsonkey]))
                                                @foreach ($messenteFieldJsons as $messenteFieldkey => $messenteFieldJson)
                                                    @php
                                                        $messentearr = explode(',', $messenteFieldJson);
                                                    @endphp
                                                    @if ($messenteFieldkey == $messenteJsonkey)
                                                        <option value="{{ $fornVal->name }}"
                                                            {{ in_array($fornVal->name, $messentearr) ? 'selected' : '' }}>
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
                        <div class="error-message" id="bouncer-error_messente_field{{ $messenteJsonkey }}[]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
