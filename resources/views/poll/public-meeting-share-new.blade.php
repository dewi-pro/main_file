@php
    $hashids = new Hashids('', 20);
    $id = $hashids->encodeHex($poll->id);
@endphp
<div class="row">
    <div class="text-center">
        {!! QrCode::size(200)->generate(route('poll.survey.meeting', $id)) !!}
    </div>
</div>
