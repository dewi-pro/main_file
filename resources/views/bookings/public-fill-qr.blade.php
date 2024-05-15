@php
    $hashids = new Hashids('', 20);
    $id = $hashids->encodeHex($booking->id);
    if ($booking->booking_slots == 'time_wise_booking') {
        $route = route('booking.survey.time.wise', $id);
    } elseif ($booking->booking_slots == 'seats_wise_booking') {
        $route = route('booking.survey.seats.wise', $id);
    } elseif ($booking->booking_slots == 'images_wise_booking') {
        $route = route('booking.survey.images.wise', $id);
    }
@endphp
<div class="row">
    <div class="text-center">
        {!! QrCode::size(200)->generate($route) !!}
    </div>
</div>
