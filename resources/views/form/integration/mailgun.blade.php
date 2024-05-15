@php
    $mailgunJsonkey = isset($mailgunJsonkey) ? $mailgunJsonkey : '';
@endphp
<div class="accordion-item card aria-mailgun">
    <h2 class="accordion-header" id="heading-mailgun">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapsemailgun-{{ $mailgunJsonkey }}" aria-expanded="false" aria-controls="collapsemailgun">
            <span class="flex-1 d-flex align-items-center">
                <i class="ti ti-layout-bottombar text-primary"></i>
                {{ __('Mailgun') }}
            </span>
            <div class="d-flex align-items-center">
                <a href="#" class="mr-2 btn btn-danger btn-sm me-3 remove-card"><i class="ti ti-trash"></i></a>
            </div>
        </button>
    </h2>
    <div id="collapsemailgun-{{ $mailgunJsonkey }}" class="accordion-collapse collapse"
        aria-labelledby="heading-mailgun" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('mailgun_email' . $mailgunJsonkey, __('Mailgun Email'), ['class' => 'form-label']) }}
                        {{ Form::email('mailgun_email[]', isset($mailgunJson['mailgun_email']) ? $mailgunJson['mailgun_email'] : null, ['class' => 'form-control', 'required', 'id' => 'mailgun_email' . $mailgunJsonkey, 'placeholder' => __('Enter mailgun email')]) }}
                        <small>{{ __("Note: Please enter the email address to be used as the sender's email for Mailgun.") }}</small>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('mailgun_domain' . $mailgunJsonkey, __('Mailgun Domain'), ['class' => 'form-label']) }}
                        {{ Form::text('mailgun_domain[]', isset($mailgunJson['mailgun_domain']) ? $mailgunJson['mailgun_domain'] : null, ['class' => 'form-control', 'required', 'id' => 'mailgun_domain' . $mailgunJsonkey, 'placeholder' => __('Enter mailgun domain')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('mailgun_secret' . $mailgunJsonkey, __('Mailgun Secret'), ['class' => 'form-label']) }}
                        {{ Form::text('mailgun_secret[]', isset($mailgunJson['mailgun_secret']) ? $mailgunJson['mailgun_secret'] : null, ['class' => 'form-control', 'required', 'id' => 'mailgun_secret' . $mailgunJsonkey, 'placeholder' => __('Enter mailgun secret')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('mailgun_field' . $mailgunJsonkey, __('Mailgun Field'), ['class' => 'form-label']) }}
                        <select name="mailgun_field{{ $mailgunJsonkey }}[]" class="form-select" data-trigger multiple
                            required id="mailgun_field{{ $mailgunJsonkey }}">
                            <option value="">{{ __('Select Value') }}</option>
                            @foreach ($formJsons as $formJson)
                                @foreach ($formJson as $fornVal)
                                    @php
                                        $excludedTypes = ['button', 'header', 'hidden', 'paragraph', 'video', 'selfie', 'break', 'location'];
                                    @endphp
                                    @if (!in_array($fornVal->type, $excludedTypes))
                                        @isset($mailgunFieldJsons)
                                            @if (isset($mailgunFieldJsons[$mailgunJsonkey]))
                                                @foreach ($mailgunFieldJsons as $mailgunFieldkey => $mailgunFieldJson)
                                                    @php
                                                        $mailgunarr = explode(',', $mailgunFieldJson);
                                                    @endphp
                                                    @if ($mailgunFieldkey == $mailgunJsonkey)
                                                        <option value="{{ $fornVal->name }}"
                                                            {{ in_array($fornVal->name, $mailgunarr) ? 'selected' : '' }}>
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
                        <div class="error-message" id="bouncer-error_mailgun_field{{ $mailgunJsonkey }}[]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
