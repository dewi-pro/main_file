@php
    $vonageJsonkey = isset($vonageJsonkey) ? $vonageJsonkey : '';
@endphp
<div class="accordion-item card aria-vonage">
    <h2 class="accordion-header" id="heading-vonage">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapsevonage-{{ $vonageJsonkey }}" aria-expanded="false" aria-controls="collapsevonage">
            <span class="flex-1 d-flex align-items-center">
                <i class="ti ti-layout-bottombar text-primary"></i>
                {{ __('Vonage') }}
            </span>
            <div class="d-flex align-items-center">
                <a href="#" class="mr-2 btn btn-danger btn-sm me-3 remove-card"><i class="ti ti-trash"></i></a>
            </div>
        </button>
    </h2>
    <div id="collapsevonage-{{ $vonageJsonkey }}" class="accordion-collapse collapse" aria-labelledby="heading-vonage"
        data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('vonage_number' . $vonageJsonkey, __('Vonage Number'), ['class' => 'form-label']) }}
                        {{ Form::number('vonage_number[]', isset($vonageJson['vonage_number']) ? $vonageJson['vonage_number'] : null, ['class' => 'form-control', 'required', 'id' => 'vonage_number' . $vonageJsonkey, 'placeholder' => __('Enter vonage number')]) }}
                        <small>{{ __('Note: Please enter the mobile number for send sms. Example: 911234567890') }}</small>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('vonage_key' . $vonageJsonkey, __('Vonage Key'), ['class' => 'form-label']) }}
                        {{ Form::text('vonage_key[]', isset($vonageJson['vonage_key']) ? $vonageJson['vonage_key'] : null, ['class' => 'form-control', 'required', 'id' => "vonage_key$vonageJsonkey", 'placeholder' => __('Enter vonage key')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('vonage_secret' . $vonageJsonkey, __('Vonage Secret'), ['class' => 'form-label']) }}
                        {{ Form::text('vonage_secret[]', isset($vonageJson['vonage_secret']) ? $vonageJson['vonage_secret'] : null, ['class' => 'form-control', 'required', 'id' => "vonage_secret$vonageJsonkey", 'placeholder' => __('Enter vonage secret')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('vonage_field' . $vonageJsonkey, __('Vonage Field'), ['class' => 'form-label']) }}
                        <select name="vonage_field{{ $vonageJsonkey }}[]" class="form-select" data-trigger multiple
                            required id="vonage_field{{ $vonageJsonkey }}">
                            <option value="">{{ __('Select Value') }}</option>
                            @foreach ($formJsons as $formJson)
                                @foreach ($formJson as $fornVal)
                                    @php
                                        $excludedTypes = ['button', 'header', 'hidden', 'paragraph', 'video', 'selfie', 'break', 'location', 'file', 'SignaturePad'];
                                    @endphp
                                    @if (!in_array($fornVal->type, $excludedTypes))
                                        @isset($vonageFieldJsons)
                                            @if (isset($vonageFieldJsons[$vonageJsonkey]))
                                                @foreach ($vonageFieldJsons as $vonageFieldkey => $vonageFieldJson)
                                                    @php
                                                        $vonagearr = explode(',', $vonageFieldJson);
                                                    @endphp
                                                    @if ($vonageFieldkey == $vonageJsonkey)
                                                        <option value="{{ $fornVal->name }}"
                                                            {{ in_array($fornVal->name, $vonagearr) ? 'selected' : '' }}>
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
                        <div class="error-message" id="bouncer-error_vonage_field{{ $vonageJsonkey }}[]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
