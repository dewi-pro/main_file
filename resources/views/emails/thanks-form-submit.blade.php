@component('mail::message')
    # {{ $form_value->Form->title }}
@php
$array = json_decode($form_value->json);
@endphp
<link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
<div class="section-body">
<div class="row mx-0">
<div class="col-6 mx-auto">
<div class="card">
<div class="card-header">
<h4 class="text-center w-100">{{ $form_value->Form->title }}</h4>
</div>
<div class="card-body">
@if (!empty($form_value->Form->logo))
<div class="text-center">
{!! Form::image(asset('storage/app/' . $form_value->Form->logo), null, [
'id' => 'app-dark-logo',
'class' => 'img img-responsive my-5 w-30 justify-content-center text-center',
]) !!}
</div>
@endif
<h2 class="text-center w-100">{{ $form_value->Form->thanks_msg }}</h2>
</div>
</div>
</div>
</div>
</div>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
