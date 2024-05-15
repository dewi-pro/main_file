@php
    $slackJsonkey = isset($slackJsonkey) ? $slackJsonkey : '';
@endphp
<div class="accordion-item card aria-slack">
    <h2 class="accordion-header" id="heading-slack">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseSlack-{{ $slackJsonkey }}" aria-expanded="false" aria-controls="collapseSlack">
            <span class="flex-1 d-flex align-items-center">
                <i class="ti ti-layout-bottombar text-primary"></i>
                {{ __('Slack') }}
            </span>
            <div class="d-flex align-items-center">
                <a href="#" class="mr-2 btn btn-danger btn-sm me-3 remove-card"><i class="ti ti-trash"></i></a>
            </div>
        </button>
    </h2>
    <div id="collapseSlack-{{ $slackJsonkey }}" class="accordion-collapse collapse" aria-labelledby="heading-slack"
        data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('slack_webhook_url' . $slackJsonkey, __('Slack Webhook URL'), ['class' => 'form-label']) }}
                        {{ Form::text('slack_webhook_url[]', isset($slackJson['slack_webhook_url']) ? $slackJson['slack_webhook_url'] : null, ['class' => 'form-control', 'required', 'id' => "slack_webhook_url$slackJsonkey", 'placeholder' => __('Enter Slack webhook url')]) }}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        {{ Form::label('slack_field' . $slackJsonkey, __('Slack Field'), ['class' => 'form-label']) }}
                        <select name="slack_field{{ $slackJsonkey }}[]" class="form-select" data-trigger multiple
                            required id="slack_field{{ $slackJsonkey }}">
                            <option value="">{{ __('Select Value') }}</option>
                            @foreach ($formJsons as $formJson)
                                @foreach ($formJson as $fornVal)
                                    @php
                                        $excludedTypes = ['button', 'header', 'hidden', 'paragraph', 'video', 'selfie', 'break', 'location'];
                                    @endphp
                                    @if (!in_array($fornVal->type, $excludedTypes))
                                        @isset($slackFieldJsons)
                                            @if (isset($slackFieldJsons[$slackJsonkey]))
                                                @foreach ($slackFieldJsons as $slackFieldkey => $slackFieldJson)
                                                    @php
                                                        $slackarr = explode(',', $slackFieldJson);
                                                    @endphp
                                                    @if ($slackFieldkey == $slackJsonkey)
                                                        <option value="{{ $fornVal->name }}"
                                                            {{ in_array($fornVal->name, $slackarr) ? 'selected' : '' }}>
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
                        <div class="error-message" id="bouncer-error_slack_field{{ $slackJsonkey }}[]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
