@php
    $bulkgateJsonkey = isset($bulkgateJsonkey) ? $bulkgateJsonkey : '';
@endphp
<div class="accordion-item card aria-bulkgate">
    <h2 class="accordion-header" id="heading-bulkgate">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapsebulkgate-{{ $bulkgateJsonkey }}" aria-expanded="false"
            aria-controls="collapsebulkgate">
            <span class="flex-1 d-flex align-items-center">
                <i class="ti ti-layout-bottombar text-primary"></i>
                {{ __('BulkGate') }}
            </span>
            <div class="d-flex align-items-center">
                <a href="#" class="mr-2 btn btn-danger btn-sm me-3 remove-card"><i class="ti ti-trash"></i></a>
            </div>
        </button>
    </h2>
    <div id="collapsebulkgate-{{ $bulkgateJsonkey }}" class="accordion-collapse collapse"
        aria-labelledby="heading-bulkgate" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('bulkgate_number' . $bulkgateJsonkey, __('Bulkgate Number'), ['class' => 'form-label']) }}
                        {{ Form::number('bulkgate_number[]', isset($bulkgateJson['bulkgate_number']) ? $bulkgateJson['bulkgate_number'] : null, ['class' => 'form-control', 'required', 'id' => 'bulkgate_number' . $bulkgateJsonkey, 'placeholder' => __('Enter bulkgate number')]) }}
                        <small>{{ __('Note: Please enter the mobile number for send sms. Example: 1234567890') }}</small>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('bulkgate_token' . $bulkgateJsonkey, __('Bulkgate Token'), ['class' => 'form-label']) }}
                        {{ Form::text('bulkgate_token[]', isset($bulkgateJson['bulkgate_token']) ? $bulkgateJson['bulkgate_token'] : null, ['class' => 'form-control', 'required', 'id' => "bulkgate_token$bulkgateJsonkey", 'placeholder' => __('Enter bulkgate token')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('bulkgate_app_id' . $bulkgateJsonkey, __('Bulkgate App Id'), ['class' => 'form-label']) }}
                        {{ Form::text('bulkgate_app_id[]', isset($bulkgateJson['bulkgate_app_id']) ? $bulkgateJson['bulkgate_app_id'] : null, ['class' => 'form-control', 'required', 'id' => "bulkgate_app_id$bulkgateJsonkey", 'placeholder' => __('Enter bulkgate app id')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('bulkgate_field' . $bulkgateJsonkey, __('bulkgate Field'), ['class' => 'form-label']) }}
                        <select name="bulkgate_field{{ $bulkgateJsonkey }}[]" class="form-select" data-trigger multiple
                            required id="bulkgate_field{{ $bulkgateJsonkey }}">
                            <option value="">{{ __('Select Value') }}</option>
                            @foreach ($formJsons as $formJson)
                                @foreach ($formJson as $fornVal)
                                    @php
                                        $excludedTypes = ['button', 'header', 'hidden', 'paragraph', 'video', 'selfie', 'break', 'location', 'file', 'SignaturePad'];
                                    @endphp
                                    @if (!in_array($fornVal->type, $excludedTypes))
                                        @isset($bulkgateFieldJsons)
                                            @if (isset($slackFieldJsons[$bulkgateJsonkey]))
                                                @foreach ($bulkgateFieldJsons as $bulkgateFieldkey => $bulkgateFieldJson)
                                                    @php
                                                        $bulkgatearr = explode(',', $bulkgateFieldJson);
                                                    @endphp
                                                    @if ($bulkgateFieldJsons == $bulkgateJsonkey)
                                                        <option value="{{ $fornVal->name }}"
                                                            {{ in_array($fornVal->name, $bulkgatearr) ? 'selected' : '' }}>
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
                        <div class="error-message" id="bouncer-error_bulkgate_field{{ $bulkgateJsonkey }}[]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
