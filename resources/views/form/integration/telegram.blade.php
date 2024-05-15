@php
    $telegramJsonkey = isset($telegramJsonkey) ? $telegramJsonkey : '';
@endphp
<div class="accordion-item card aria-telegram">
    <h2 class="accordion-header" id="heading-telegram">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseTelegram-{{ $telegramJsonkey }}" aria-expanded="false"
            aria-controls="collapseTelegram">
            <span class="flex-1 d-flex align-items-center">
                <i class="ti ti-layout-bottombar text-primary"></i>
                {{ __('Telegram') }}
            </span>
            <div class="d-flex align-items-center">
                <a href="#" class="mr-2 btn btn-danger btn-sm me-3 remove-card"><i class="ti ti-trash"></i></a>
            </div>
        </button>
    </h2>
    <div id="collapseTelegram-{{ $telegramJsonkey }}" class="accordion-collapse collapse"
        aria-labelledby="heading-telegram" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('telegram_access_token' . $telegramJsonkey, __('Telegram Access Token'), ['class' => 'form-label']) }}
                        {{ Form::text('telegram_access_token[]', isset($telegramJson['telegram_access_token']) ? $telegramJson['telegram_access_token'] : null, ['class' => 'form-control', 'required', 'id' => 'telegram_access_token' . $telegramJsonkey, 'placeholder' => __('Enter telegram access token')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('telegram_chat_id' . $telegramJsonkey, __('Telegram Chat Id'), ['class' => 'form-label']) }}
                        {{ Form::text('telegram_chat_id[]', isset($telegramJson['telegram_chat_id']) ? $telegramJson['telegram_chat_id'] : null, ['class' => 'form-control', 'required', 'id' => 'telegram_chat_id' . $telegramJsonkey, 'placeholder' => __('Enter telegram chat id')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('telegram_field' . $telegramJsonkey, __('Telegram Field'), ['class' => 'form-label']) }}
                        <select name="telegram_field{{ $telegramJsonkey }}[]" class="form-select" data-trigger multiple
                            required id="telegram_field{{ $telegramJsonkey }}">
                            <option value="">{{ __('Select Value') }}</option>
                            @foreach ($formJsons as $formJson)
                                @foreach ($formJson as $fornVal)
                                    @php
                                        $excludedTypes = ['button', 'header', 'hidden', 'paragraph', 'video', 'selfie', 'break', 'location', 'file', 'SignaturePad'];
                                    @endphp
                                    @if (!in_array($fornVal->type, $excludedTypes))
                                        @isset($telegramFieldJsons)
                                            @if (isset($telegramFieldJsons[$telegramJsonkey]))
                                                @foreach ($telegramFieldJsons as $telegramFieldkey => $telegramFieldJson)
                                                    @php
                                                        $telegramarr = explode(',', $telegramFieldJson);
                                                    @endphp
                                                    @if ($telegramFieldkey == $telegramJsonkey)
                                                        <option value="{{ $fornVal->name }}"
                                                            {{ in_array($fornVal->name, $telegramarr) ? 'selected' : '' }}>
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
                        <div class="error-message" id="bouncer-error_telegram_field{{ $telegramJsonkey }}[]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
