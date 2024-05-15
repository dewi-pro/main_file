@if ($row->json)
    @php
        $hashids = new Hashids('', 20);
        $id = $hashids->encodeHex($row->id);
        if ($row->booking_slots == 'time_wise_booking') {
            $route = route('booking.survey.time.wise', $id);
        } elseif ($row->booking_slots == 'seats_wise_booking') {
            $route = route('booking.survey.seats.wise', $id);
        }
    @endphp
    @can('payment-booking')
        <a class="text-white btn btn-warning btn-sm" href="{{ route('booking.payment.integration', $row->id) }}"
            data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="{{ __('Booking Payment Integration') }}"><i class="ti ti-report-money"></i></a>
    @endcan
    <a class="btn btn-primary embed_form btn-sm" href="javascript:void(0);"
        onclick="copyToClipboard('#embed-form-{{ $row->id }}')" id="embed-form-{{ $row->id }}"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('Embed') }}"
        data-url='<iframe src="{{ $route }}"
            scrolling="auto" align="bottom" height="100vh" width="100%"></iframe>'>
        <i class="ti ti-code"></i>
    </a>
    <a class="btn btn-success copy_form btn-sm" onclick="copyToClipboard('#copy-form-{{ $row->id }}')"
        href="javascript:void(0)" id="copy-form-{{ $row->id }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ __('Copy Booking Url') }}" data-url="{{ $route }}"><i class="ti ti-copy"></i>
    </a>
    <a class="text-white btn btn-info btn-sm cust_btn" data-bs-toggle="tooltip"
        data-share="{{ route('booking.survey.qr', $id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ __('Show QR Code') }}" id="share-qr-code"><i class="ti ti-qrcode"></i>
    </a>
    @can('fill-booking')
        @if ($row->booking_slots == 'time_wise_booking')
            <a class="btn btn-secondary btn-sm" href="{{ route('booking.appoinment.time', $row->id) }}"
                id="appoinment-form" data-bs-toggle="tooltip" data-bs-placement="bottom"
                data-bs-original-title="{{ __('Appoinment Time Wise') }}"><i class="ti ti-clock"></i>
            </a>
        @elseif($row->booking_slots == 'seats_wise_booking')
            <a class="btn btn-secondary btn-sm" href="{{ route('booking.appoinment.seat', $row->id) }}"
                id="appoinment-form" data-bs-toggle="tooltip" data-bs-placement="bottom"
                data-bs-original-title="{{ __('Appoinment Seat Wise') }}"><i class="ti ti-border-all"></i>
            </a>
        @endif
    @endcan

@endif
@can('design-booking')
    <a class="btn btn-info btn-sm" href="{{ route('booking.slots.setting', $row->id) }}" id="design-form" data-bs-toggle="tooltip"
        data-bs-placement="bottom" data-bs-original-title="{{ __('Design') }}"><i class="ti ti-brush"></i>
    </a>
@endcan
@can('edit-booking')
    <a class="btn btn-sm small btn-primary" href="{{ route('bookings.edit', $row->id) }}" data-bs-toggle="tooltip"
        data-bs-placement="bottom" data-bs-original-title="{{ __('Edit') }}" aria-label="{{ __('Edit') }}"><i
            class="ti ti-edit"></i>
    </a>
@endcan
@can('delete-booking')
    {!! Form::open([
        'method' => 'DELETE',
        'class' => 'd-inline',
        'route' => ['bookings.destroy', $row->id],
        'id' => 'delete-form-' . $row->id,
    ]) !!}
    <a href="#" class="btn btn-sm small btn-danger show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        id="delete-form-{{ $row->id }}" data-bs-original-title="{{ __('Delete') }}"
        aria-label="{{ __('Delete') }}"><i class="ti ti-trash"></i></a>
    {!! Form::close() !!}
@endcan
