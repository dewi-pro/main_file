@php
    $hashids = new Hashids('', 20);
    $id = $hashids->encodeHex($poll->id);
@endphp
<div class="row">
    <h4 class="mt-3 mb-1">{{ __('Share via link') }}</h4>
    <p>{{ __('Use this link to share the poll with your participants.') }}</p>
    <div class="form-group">
        <div class="input-group">
            <input type="text" value="{{ route('poll.survey.meeting', $id) }}" class="form-control js-content"
                id="pc-clipboard-2" placeholder="Type some value to copy">
            <a href="#" class="btn btn-primary js-copy" data-clipboard="true"
                data-clipboard-target="#pc-clipboard-2"> {{ __('Copy') }}
            </a>
        </div>
    </div>
    <hr>
    <h4 class="mt-3 mb-1">{{ __('Share on social media') }}</h4>
    <p>{{ __('Share this poll with friends & followers on social media channels.') }}</p>
    <div class="form-group">
        <div class="d-grid text-center">
            <a href="https://api.whatsapp.com/send?text={{ route('poll.survey.meeting', $id) }}"
                class="btn mb-3 btn-success d-flex justify-content-center align-items-center mx-sm-6"><i
                    class="ti ti-brand-whatsapp me-2"></i>{{ __('Share on WhatsApp') }}</a>
        </div>
        <div class="d-grid text-center">
            <a href="https://twitter.com/intent/tweet?text={{ route('poll.survey.meeting', $id) }}"
                class="btn mb-3 text-white bg-twitter d-flex justify-content-center align-items-center mx-sm-6"><i
                    class="ti ti-brand-twitter me-2"></i>{{ __('Share on Twitter') }}</a>
        </div>
        <div class="d-grid text-center">
            <a href="https://www.facebook.com/share.php?u={{ route('poll.survey.meeting', $id) }}"
                class="btn mb-3 btn-primary d-flex justify-content-center align-items-center mx-sm-6"><i
                    class="ti ti-brand-facebook me-2"></i>{{ __('Share on Facebook') }}</a>
        </div>
        <div class="d-grid text-center">
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ route('poll.survey.meeting', $id) }}"
                class="btn mb-3 text-white bg-linkedin d-flex justify-content-center align-items-center mx-sm-6"><i
                    class="ti ti-brand-linkedin me-2"></i>{{ __('Share on Linkedin') }}</a>
        </div>
    </div>
    <hr>
    <h4 class="mt-3 mb-1">{{ __('Share with live audience') }}</h4>
    <p>{{ __('Easy access for your live audience while sharing your screen.') }}</p>
    <a class="btn mb-3 text-white bg-purple d-flex justify-content-center align-items-center mx-sm-6"
        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Show QR Code" href="javascript:void(1);"
        id="share-qr" data-action="{{ route('poll.share.qr.meeting', $id) }}"><i
            class="ti ti-qrcode me-2"></i>{{ __('Show QR Code') }}</a>
</div>
