@php
    $hashids = new Hashids('', 20);
    $id = $hashids->encodeHex($form->id);
@endphp
<div class="row">
    <div class="text-center">
        {!! QrCode::size(200)->generate(route('forms.survey', $id)) !!}
    </div>
</div>
