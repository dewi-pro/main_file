@php
    $clicktellJsonkey = isset($clicktellJsonkey) ? $clicktellJsonkey : '';
@endphp
<div class="accordion-item card aria-clicktell">
    <h2 class="accordion-header" id="heading-clicktell">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseclicktell-{{ $clicktellJsonkey }}" aria-expanded="false"
            aria-controls="collapseclicktell">
            <span class="flex-1 d-flex align-items-center">
                <i class="ti ti-layout-bottombar text-primary"></i>
                {{ __('Clicktell') }}
            </span>
            <div class="d-flex align-items-center">
                <a href="#" class="mr-2 btn btn-danger btn-sm me-3 remove-card"><i class="ti ti-trash"></i></a>
            </div>
        </button>
    </h2>
    <div id="collapseclicktell-{{ $clicktellJsonkey }}" class="accordion-collapse collapse"
        aria-labelledby="heading-clicktell" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('clicktell_number' . $clicktellJsonkey, __('Clicktell Number'), ['class' => 'form-label']) }}
                        {{ Form::number('clicktell_number[]', isset($clicktellJson['clicktell_number']) ? $clicktellJson['clicktell_number'] : null, ['class' => 'form-control', 'required', 'id' => 'clicktell_number' . $clicktellJsonkey, 'placeholder' => __('Enter clicktell number')]) }}
                        <small>{{ __('Note: Please enter the mobile number for send sms. Example: 911234567890') }}</small>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('clicktell_api_key' . $clicktellJsonkey, __('Clicktell Api Key'), ['class' => 'form-label']) }}
                        {{ Form::text('clicktell_api_key[]', isset($clicktellJson['clicktell_api_key']) ? $clicktellJson['clicktell_api_key'] : null, ['class' => 'form-control', 'required', 'id' => "clicktell_api_key$clicktellJsonkey", 'placeholder' => __('Enter clicktell api key')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('clicktell_field' . $clicktellJsonkey, __('Clicktell Field'), ['class' => 'form-label']) }}
                        <select name="clicktell_field{{ $clicktellJsonkey }}[]" class="form-select" data-trigger
                            required multiple id="clicktell_field{{ $clicktellJsonkey }}">
                            <option value="">{{ __('Select Value') }}</option>
                            @foreach ($formJsons as $formJson)
                                @foreach ($formJson as $fornVal)
                                    @php
                                        $excludedTypes = ['button', 'header', 'hidden', 'paragraph', 'video', 'selfie', 'break', 'location', 'file', 'SignaturePad'];
                                    @endphp
                                    @if (!in_array($fornVal->type, $excludedTypes))
                                        @isset($clicktellFieldJsons)
                                            @if (isset($clicktellFieldJsons[$clicktellJsonkey]))
                                                @foreach ($clicktellFieldJsons as $clicktellFieldkey => $clicktellFieldJson)
                                                    @php
                                                        $clicktellarr = explode(',', $clicktellFieldJson);
                                                    @endphp
                                                    @if ($clicktellFieldkey == $clicktellJsonkey)
                                                        <option value="{{ $fornVal->name }}"
                                                            {{ in_array($fornVal->name, $clicktellarr) ? 'selected' : '' }}>
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
                        <div class="error-message" id="bouncer-error_clicktell_field{{ $clicktellJsonkey }}[]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
