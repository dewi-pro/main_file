<div class="col-md-6">
    <div id="pc-datepicker"></div>
    {!! Form::hidden('booking_date', null, []) !!}
</div>
<div class="col-md-6">
    @if ($seatWiseBooking->enable_note == 1)
        <div class="alert alert-warning" role="alert">
            <strong>{{ __('Note : ') }}</strong> {{ $seatWiseBooking->note }}
        </div>
    @endif
    <div class="form-group appointmentSlot">

    </div>
</div>
<div class="mt-4 col-lg-12">
    <p>{!! $seatWiseBooking->services !!}</p>
</div>
