@php
    $today = now();
    $bookingSlotsDate = $bookingvalue->Booking->bookingSlotsDate;
    $isSlotsDatePassed = $bookingSlotsDate <= $today;
    $hashids = new Hashids('', 20);
    $id = $hashids->encodeHex($bookingvalue->id);
@endphp
@can('copyurl-submitted-form')
    <a class="btn btn-success copy_form btn-sm" onclick="copyToClipboard('#copy-form-{{ $bookingvalue->id }}')"
        href="javascript:void(0);" id="copy-form-{{ $bookingvalue->id }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ __('Copy Booking Value Url') }}" data-url="{{ route('appointment.edit', $id) }}"><i
            class="ti ti-copy"></i>
    </a>
@endcan
@can('show-submitted-form')
    @if ($bookingvalue->Booking->booking_slots == 'time_wise_booking')
        <a href="{{ route('timing.bookingvalues.show', $bookingvalue->id) }}" class="btn btn-info btn-sm"
            data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('View') }}"><i
                class="ti ti-eye"></i></a>
    @elseif ($bookingvalue->Booking->booking_slots == 'seats_wise_booking')
        <a href="{{ route('seats.bookingvalues.show', $bookingvalue->id) }}" class="btn btn-info btn-sm"
            data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('View') }}"><i
                class="ti ti-eye"></i></a>
    @endif
@endcan
@can('delete-submitted-form')
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['bookingvalues.destroy', $bookingvalue->id],
        'id' => 'delete-form-' . $bookingvalue->id,
        'class' => 'd-inline',
    ]) !!}
    <a href="#" class="btn btn-danger btn-sm show_confirm" id="delete-form-{{ $bookingvalue->id }}"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('Delete') }}"><i
            class="mr-0 ti ti-trash"></i></a>
    {!! Form::close() !!}
@endcan
