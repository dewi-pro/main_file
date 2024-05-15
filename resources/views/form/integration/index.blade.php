@extends('layouts.main')
@section('title', __('Form Integration'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="d-flex justify-content-between">
            <div class="previous-next-btn">
                <div class="page-header-title">
                    <h4 class="m-b-10">{{ __('Form Integration') }}</h4>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('forms.index') }}">{{ __('Forms') }}</a></li>
                    <li class="breadcrumb-item"> {{ __('Form Integration') }} </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="m-auto col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Integration') }}</h5>
                </div>
                {!! Form::open([
                    'route' => ['form.integration.store', $form->id],
                    'method' => 'POST',
                    'data-validate',
                ]) !!}
                <div class="card-body">
                    <div class="btn-group integrate">
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="{{ route('slack.integration', $form->id) }}" id="slack"><i
                                class="ti ti-plus"></i>{{ __('Slack') }}</button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="{{ route('telegram.integration', $form->id) }}" id="telegram"><i
                                class="ti ti-plus"></i>{{ __('Telegram') }}</button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="{{ route('mailgun.integration', $form->id) }}" id="mailgun"><i
                                class="ti ti-plus"></i>{{ __('Mailgun') }}</button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="{{ route('bulkgate.integration', $form->id) }}" id="bulkgate"><i
                                class="ti ti-plus"></i>{{ __('BulkGate') }}</button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="{{ route('nexmo.integration', $form->id) }}" id="nexmo"><i
                                class="ti ti-plus"></i>{{ __('Nexmo') }}</button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="{{ route('fast2sms.integration', $form->id) }}" id="fast2sms"><i
                                class="ti ti-plus"></i>{{ __('Fast2SMS') }}</button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="{{ route('vonage.integration', $form->id) }}" id="vonage"><i
                                class="ti ti-plus"></i>{{ __('Vonage') }}</button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="{{ route('sendgrid.integration', $form->id) }}" id="sendgrid"><i
                                class="ti ti-plus"></i>{{ __('SendGrid') }}</button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="{{ route('twilio.integration', $form->id) }}" id="twilio"><i
                                class="ti ti-plus"></i>{{ __('Twilio') }}</button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="{{ route('textlocal.integration', $form->id) }}" id="textlocal"><i
                                class="ti ti-plus"></i>{{ __('Textlocal') }}</button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="{{ route('messente.integration', $form->id) }}" id="messente"><i
                                class="ti ti-plus"></i>{{ __('Messente') }}</button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="{{ route('smsgateway.integration', $form->id) }}" id="smsgateway"><i
                                class="ti ti-plus"></i>{{ __('SmsGateway') }}</button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="{{ route('clicktell.integration', $form->id) }}" id="clicktell"><i
                                class="ti ti-plus"></i>{{ __('Clicktell') }}</button>
                        <button type="button" class="my-1 btn btn-sm btn-primary"
                            data-url="{{ route('clockwork.integration', $form->id) }}" id="clockwork"><i
                                class="ti ti-plus"></i>{{ __('Clockwork') }}</button>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-10 col-xxl-12">
                            <div class="faq justify-content-center">
                                <div class="accordion accordion-flush setting-accordion" id="accordionExample-integration">
                                    @if ($slackJsons)
                                        @foreach ($slackJsons as $slackJsonkey => $slackJson)
                                            @include('form.integration.slack')
                                        @endforeach
                                    @endif
                                    @if ($telegramJsons)
                                        @foreach ($telegramJsons as $telegramJsonkey => $telegramJson)
                                            @include('form.integration.telegram')
                                        @endforeach
                                    @endif
                                    @if ($mailgunJsons)
                                        @foreach ($mailgunJsons as $mailgunJsonkey => $mailgunJson)
                                            @include('form.integration.mailgun')
                                        @endforeach
                                    @endif
                                    @if ($bulkgateJsons)
                                        @foreach ($bulkgateJsons as $bulkgateJsonkey => $bulkgateJson)
                                            @include('form.integration.bulkgate')
                                        @endforeach
                                    @endif
                                    @if ($nexmoJsons)
                                        @foreach ($nexmoJsons as $nexmoJsonkey => $nexmoJson)
                                            @include('form.integration.nexmo')
                                        @endforeach
                                    @endif
                                    @if ($fast2smsJsons)
                                        @foreach ($fast2smsJsons as $fast2smsJsonkey => $fast2smsJson)
                                            @include('form.integration.fast2sms')
                                        @endforeach
                                    @endif
                                    @if ($vonageJsons)
                                        @foreach ($vonageJsons as $vonageJsonkey => $vonageJson)
                                            @include('form.integration.vonage')
                                        @endforeach
                                    @endif
                                    @if ($sendgridJsons)
                                        @foreach ($sendgridJsons as $sendgridJsonkey => $sendgridJson)
                                            @include('form.integration.sendgrid')
                                        @endforeach
                                    @endif
                                    @if ($twilioJsons)
                                        @foreach ($twilioJsons as $twilioJsonkey => $twilioJson)
                                            @include('form.integration.twilio')
                                        @endforeach
                                    @endif
                                    @if ($textlocalJsons)
                                        @foreach ($textlocalJsons as $textlocalJsonkey => $textlocalJson)
                                            @include('form.integration.textlocal')
                                        @endforeach
                                    @endif
                                    @if ($messenteJsons)
                                        @foreach ($messenteJsons as $messenteJsonkey => $messenteJson)
                                            @include('form.integration.messente')
                                        @endforeach
                                    @endif
                                    @if ($smsgatewayJsons)
                                        @foreach ($smsgatewayJsons as $smsgatewayJsonkey => $smsgatewayJson)
                                            @include('form.integration.smsgateway')
                                        @endforeach
                                    @endif
                                    @if ($clicktellJsons)
                                        @foreach ($clicktellJsons as $clicktellJsonkey => $clicktellJson)
                                            @include('form.integration.clicktell')
                                        @endforeach
                                    @endif
                                    @if ($clockworkJsons)
                                        @foreach ($clockworkJsons as $clockworkJsonkey => $clockworkJson)
                                            @include('form.integration.clockwork')
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-end">
                        {!! Html::link(route('forms.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
                        {!! Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'This is a placeholder set in the config',
                    searchPlaceholderValue: 'This is a search placeholder',
                    removeItemButton: true,
                });
            }
        });
        $(document).ready(function() {
            $(document).on('click', '.integrate button', function() {
                var $this = $(this);
                var url = $this.attr('data-url');
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        var html = $.parseHTML(response);
                        var countId = $this.attr('id');
                        var classCount = $('.aria-' + countId).length;
                        var inputData = $(html).find('input,textarea').toArray();
                        inputData.forEach(function(val, key) {
                            var id = $(val).attr('id');
                            $(val).parent().find('label').attr('for', id + classCount);
                            $(val).attr('id', id + classCount);
                        });
                        var selectData = $(html).find('select').toArray();
                        selectData.forEach(function(val, key) {
                            var id = $(val).attr('id');
                            $(val).parent().find('label').attr('for', id + classCount);
                            $(val).attr('id', id + classCount);
                            $(val).attr('name', id + classCount + '[]');
                        });

                        var genericExamples = $(html).find('[data-trigger]');
                        for (i = 0; i < genericExamples.length; ++i) {
                            var element = genericExamples[i];
                            new Choices(element, {
                                placeholderValue: 'This is a placeholder set in the config',
                                searchPlaceholderValue: 'This is a search placeholder',
                                removeItemButton: true,
                            });
                        }
                        var accordionBtn = $(html).find('.collapse').attr('id');
                        $(html).find('.collapse').attr('id', accordionBtn + '-' + classCount);
                        $(html).find('.accordion-button').attr('data-bs-target', '#' +
                            accordionBtn + '-' + classCount);
                        $('#accordionExample-integration').append(html);
                    },
                    error: function(xhr, status, error) {

                    }
                });
            });
            $(document).on('click', '.remove-card', function() {
                $(this).parents('.accordion-item').remove();
            });
        });
    </script>
@endpush
