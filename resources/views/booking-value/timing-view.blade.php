@extends('layouts.main')
@section('title', __('View Bookings'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('View Bookings') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(
                route('view.booking.values', $bookingValue->booking_id),
                __('Submitted Bookings of ' . ' ' . $booking->business_name),
                [''],
            ) !!}</li>
            <li class="breadcrumb-item">{{ __('View Bookings') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-11 col-xxl-8">
            <div class="row">
                @if (!empty($bookingValue->Booking->business_logo))
                    <div class="text-center gallery gallery-md">
                        <img id="app-dark-logo" class="float-none gallery-item"
                            src="{{ isset($bookingValue->Booking->business_logo)
                                ? Storage::url($bookingValue->Booking->business_logo)
                                : Storage::url('app-logo/78x78.png') }}">
                    </div>
                @endif
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5> {{ $bookingValue->Booking->business_name }}
                                <a href="{{ route('view.booking.values', $bookingValue->booking_id) }}"
                                    class="btn btn-secondary float-end">{{ __('Back') }}</a>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 d-flex flex-column">
                                <p class="mb-0 d-flex align-items-center justify-content-between text-muted">
                                    <strong>{{ __('Booking Status') }}</strong>
                                    @if ($bookingValue->booking_status == 1)
                                        <span class="p-2 px-3 rounded badge bg-success">{{ __('Success') }}</span>
                                    @else
                                        <span class="p-2 px-3 rounded badge bg-danger">{{ __('Cancel') }}</span>
                                    @endif
                                </p>
                            </div>
                            <div class="row align-items-center">
                                @foreach ($array as $keys => $rows)
                                    @foreach ($rows as $row_key => $row)
                                        @if ($row->type == 'checkbox-group')
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                    @if ($row->required)
                                                        <span class="text-danger align-items-center">*</span>
                                                    @endif
                                                    <p>
                                                    <ul>
                                                        @foreach ($row->values as $key => $options)
                                                            @if (isset($options->selected))
                                                                <li>
                                                                    <label>{{ $options->label }}</label>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                    </p>
                                                </div>
                                            </div>
                                        @elseif($row->type == 'file')
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                    @if ($row->required)
                                                        <span class="text-danger align-items-center">*</span>
                                                    @endif
                                                    <p>
                                                        @if (property_exists($row, 'value'))
                                                            @if ($row->value)
                                                                @php
                                                                    $allowedExtensions = ['pdf', 'pdfa', 'fdf', 'xdp', 'xfa', 'pdx', 'pdp', 'pdfxml', 'pdxox', 'xlsx', 'csv', 'xlsm', 'xltx', 'xlsb', 'xltm', 'xlw'];
                                                                @endphp
                                                                @if ($row->multiple)
                                                                    <div class="row">
                                                                        @if (UtilityFacades::getsettings('storage_type') == 'local')
                                                                            @foreach ($row->value as $img)
                                                                                <div class="col-6">
                                                                                    @php
                                                                                        $fileName = explode('/', $img);
                                                                                        $fileName = end($fileName);
                                                                                    @endphp
                                                                                    @if (in_array(pathinfo($img, PATHINFO_EXTENSION), $allowed_extensions))
                                                                                        @php
                                                                                            $fileName = explode('/', $img);
                                                                                            $fileName = end($fileName);
                                                                                        @endphp
                                                                                        <a class="my-2 btn btn-info"
                                                                                            href="{{ asset('storage/app/' . $img) }}"
                                                                                            type="image"
                                                                                            download="">{!! substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : '') !!}</a>
                                                                                    @else
                                                                                        <img src="{{ Storage::exists($img) ? asset('storage/app/' . $img) : Storage::url('not-exists-data-images/78x78.png') }}"
                                                                                            class="mb-2 img-responsive img-thumbnail">
                                                                                    @endif
                                                                                </div>
                                                                            @endforeach
                                                                        @else
                                                                            @foreach ($row->value as $img)
                                                                                <div class="col-6">
                                                                                    @php
                                                                                        $fileName = explode('/', $img);
                                                                                        $fileName = end($fileName);
                                                                                    @endphp
                                                                                    @if (in_array(pathinfo($img, PATHINFO_EXTENSION), $allowed_extensions))
                                                                                        @php
                                                                                            $fileName = explode('/', $img);
                                                                                            $fileName = end($fileName);
                                                                                        @endphp
                                                                                        <a class="my-2 btn btn-info"
                                                                                            href="{{ Storage::url($img) }}"
                                                                                            type="image"
                                                                                            download="">{!! substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : '') !!}</a>
                                                                                    @else
                                                                                        <img src="{{ Storage::url($img) }}"
                                                                                            class="mb-2 img-responsive img-thumbnail">
                                                                                    @endif
                                                                                </div>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            @if ($row->subtype == 'fineuploader')
                                                                                @if (UtilityFacades::getsettings('storage_type') == 'local')
                                                                                    @if ($row->value[0])
                                                                                        @foreach ($row->value as $img)
                                                                                            @php
                                                                                                $fileName = explode('/', $img);
                                                                                                $fileName = end($fileName);
                                                                                            @endphp
                                                                                            @if (in_array(pathinfo($img, PATHINFO_EXTENSION), $allowed_extensions))
                                                                                                <a class="my-2 btn btn-info"
                                                                                                    href="{{ asset('storage/app/' . $img) }}"
                                                                                                    type="image"
                                                                                                    download="">{!! substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : '') !!}</a>
                                                                                            @else
                                                                                                <img src="{{ Storage::exists($img) ? asset('storage/app/' . $img) : Storage::url('not-exists-data-images/78x78.png') }}"
                                                                                                    class="mb-2 img-responsive img-thumbnail">
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @endif
                                                                                @else
                                                                                    @if ($row->value[0])
                                                                                        @foreach ($row->value as $img)
                                                                                            @php
                                                                                                $fileName = explode('/', $img);
                                                                                                $fileName = end($fileName);
                                                                                            @endphp
                                                                                            @if (in_array(pathinfo($img, PATHINFO_EXTENSION), $allowed_extensions))
                                                                                                <a class="my-2 btn btn-info"
                                                                                                    href="{{ Storage::url($img) }}"
                                                                                                    type="image"
                                                                                                    download="">{!! substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : '') !!}</a>
                                                                                            @else
                                                                                                <img src="{{ Storage::url($img) }}"
                                                                                                    class="mb-2 img-responsive img-thumbnail">
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @endif
                                                                                @endif
                                                                            @else
                                                                                @if (UtilityFacades::getsettings('storage_type') == 'local')
                                                                                    @if (in_array(pathinfo($row->value, PATHINFO_EXTENSION), $allowed_extensions))
                                                                                        @php
                                                                                            $fileName = explode('/', $row->value);
                                                                                            $fileName = end($fileName);
                                                                                        @endphp
                                                                                        <a class="my-2 btn btn-info"
                                                                                            href="{{ asset('storage/app/' . $row->value) }}"
                                                                                            type="image"
                                                                                            download="">{!! substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : '') !!}</a>
                                                                                    @else
                                                                                        <img src="{{ Storage::exists($row->value) ? asset('storage/app/' . $row->value) : Storage::url('not-exists-data-images/78x78.png') }}"
                                                                                            class="mb-2 img-responsive img-thumbnailss">
                                                                                    @endif
                                                                                @else
                                                                                    @if (in_array(pathinfo($row->value, PATHINFO_EXTENSION), $allowed_extensions))
                                                                                        @php
                                                                                            $fileName = explode('/', $row->value);
                                                                                            $fileName = end($fileName);
                                                                                        @endphp
                                                                                        <a class="my-2 btn btn-info"
                                                                                            href="{{ Storage::url($row->value) }}"
                                                                                            type="image"
                                                                                            download="">{!! substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : '') !!}</a>
                                                                                    @else
                                                                                        <img src="{{ Storage::url($row->value) }}"
                                                                                            class="mb-2 img-responsive img-thumbnailss">
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        @elseif($row->type == 'header')
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <{{ $row->subtype }}>
                                                        {!! html_entity_decode($row->label) !!}
                                                        </{{ $row->subtype }}>
                                                </div>
                                            </div>
                                        @elseif($row->type == 'paragraph')
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <{{ $row->subtype }}>
                                                        {!! html_entity_decode($row->label) !!}
                                                        </{{ $row->subtype }}>
                                                </div>
                                            </div>
                                        @elseif($row->type == 'radio-group')
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                    @if ($row->required)
                                                        <span class="text-danger align-items-center">*</span>
                                                    @endif
                                                    <p>
                                                        @foreach ($row->values as $key => $options)
                                                            @if (isset($options->selected))
                                                                {{ $options->label }}
                                                            @endif
                                                        @endforeach
                                                    </p>
                                                </div>
                                            </div>
                                        @elseif($row->type == 'select')
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                    @if ($row->required)
                                                        <span class="text-danger align-items-center">*</span>
                                                    @endif
                                                    <p>
                                                        @foreach ($row->values as $options)
                                                            @if (isset($options->selected))
                                                                {{ $options->label }}
                                                            @endif
                                                        @endforeach
                                                    </p>
                                                </div>
                                            </div>
                                        @elseif($row->type == 'autocomplete')
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                    @if ($row->required)
                                                        <span class="text-danger align-items-center">*</span>
                                                    @endif
                                                    <p>
                                                        {{ $row->value }}
                                                    </p>
                                                </div>
                                            </div>
                                        @elseif($row->type == 'number')
                                            <div class="col-12">
                                                <b>{{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                    @if ($row->required)
                                                        <span class="text-danger align-items-center">*</span>
                                                    @endif
                                                </b>
                                                <p>
                                                    {{ isset($row->value) ? $row->value : '' }}
                                                </p>
                                            </div>
                                        @elseif($row->type == 'text')
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                    @if ($row->required)
                                                        <span class="text-danger align-items-center">*</span>
                                                    @endif
                                                    @if ($row->subtype == 'color')
                                                        <div style="padding: 10px;background-color: {{ $row->value }};">
                                                        </div>
                                                    @else
                                                        <p>
                                                            {{ isset($row->value) ? $row->value : '' }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif($row->type == 'date')
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                    @if ($row->required)
                                                        <span class="text-danger align-items-center">*</span>
                                                    @endif
                                                    <p>
                                                        {{ isset($row->value) ? date('d-m-Y', strtotime($row->value)) : '' }}
                                                    </p>
                                                </div>
                                            </div>
                                        @elseif($row->type == 'textarea')
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                    @if ($row->required)
                                                        <span class="text-danger align-items-center">*</span>
                                                    @endif
                                                    @if ($row->subtype == 'ckeditor')
                                                        {!! isset($row->value) ? $row->value : '' !!}
                                                    @else
                                                        <p>
                                                            {{ isset($row->value) ? $row->value : '' }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif($row->type == 'starRating')
                                            <div class="col-12">
                                                <div class="form-group">
                                                    @php
                                                        $attr = ['class' => 'form-control'];
                                                        if ($row->required) {
                                                            $attr['required'] = 'required';
                                                        }
                                                        $value = isset($row->value) ? $row->value : 0;
                                                        $no_of_star = isset($row->number_of_star) ? $row->number_of_star : 5;
                                                    @endphp
                                                    {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}
                                                    @if ($row->required)
                                                        <span class="text-danger align-items-center">*</span>
                                                    @endif
                                                    <p>
                                                    <div id="{{ $row->name }}" class="starRating"
                                                        data-value="{{ $value }}"
                                                        data-no_of_star="{{ $no_of_star }}">
                                                    </div>
                                                    <input type="hidden" name="{{ $row->name }}"
                                                        value="{{ $value }}">
                                                    </p>
                                                </div>
                                            </div>
                                        @elseif($row->type == 'SignaturePad')
                                            @if (property_exists($row, 'value'))
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <img src="{{ asset(Storage::url($row->value)) }}">
                                                    </div>
                                                </div>
                                            @endif
                                        @elseif($row->type == 'break')
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <hr style="border: 1px solid #ccc">
                                                </div>
                                            </div>
                                        @elseif($row->type == 'location')
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {!! Form::label('location_id', 'Location:') !!}
                                                    <iframe width="100%" height="260" frameborder="0" scrolling="no"
                                                        marginheight="0" marginwidth="0"
                                                        src="https://maps.google.com/maps?q={{ $row->value }}&hl=en&z=14&amp;output=embed">
                                                    </iframe>
                                                </div>
                                            </div>
                                        @elseif($row->type == 'video')
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}<br>
                                                    <form action="{{ route('selfie.image.download', $bookingValue->id) }}"
                                                        method="GET">
                                                        <button class="p-2 btn btn-primary"
                                                            id="downloadButton">{{ __('Download Video') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @elseif($row->type == 'video')
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}<br>
                                                    <a href="{{ route('selfie.image.download', $bookingValue->id) }}">
                                                        <button class="p-2 btn btn-primary"
                                                            id="downloadButton">{{ __('Download Video') }}</button></a>
                                                </div>
                                            </div>
                                        @elseif($row->type == 'selfie')
                                            <div class="row">
                                                <div class="col-12">
                                                    {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}<br>
                                                    <img
                                                        src="{{ Illuminate\Support\Facades\File::exists(Storage::path($row->value)) ? Storage::url($row->value) : Storage::url('app-logo/78x78.png') }}"class="mb-2 img-responsive img-thumbnailss">
                                                    <br>
                                                    <a href="{{ route('selfie.image.download', $bookingValue->id) }}">
                                                        <button class="p-2 btn btn-primary"
                                                            id="downloadButton">{{ __('Download Image') }}</button></a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4">{{ __('Order Detlis') }}
                            </h5>
                            <div class="d-flex flex-column">
                                <p class="mb-0 d-flex align-items-center justify-content-between text-muted">
                                    {{ __('Price: ') }}<strong class="ms-sm-2 text-body">
                                        @if (isset($bookingValue) && $bookingValue->currency_symbol && $bookingValue->amount)
                                            <strong
                                                class="ms-sm-2 text-body">{{ $bookingValue->currency_symbol }}{{ $bookingValue->amount }}</strong>
                                        @else
                                            <strong class="ms-sm-2 text-body">{{ __('free') }}</strong>
                                        @endif
                                    </strong>
                                </p>
                                <p class="mb-0 d-flex align-items-center justify-content-between text-muted">
                                    {{ __('Transaction Id:') }} <strong class="ms-sm-2 text-body">
                                        @if (isset($bookingValue) && $bookingValue->transaction_id)
                                            <strong class="ms-sm-2 text-body">{{ $bookingValue->transaction_id }}</strong>
                                        @else
                                            <strong class="ms-sm-2 text-body">{{ __('Not Available') }}</strong>
                                        @endif
                                    </strong>
                                </p>
                                <p class="mb-0 d-flex align-items-center justify-content-between text-muted">
                                    {{ __('Payment Type:') }} <strong class="ms-sm-2 text-body">
                                        @if (isset($bookingValue) && $bookingValue->payment_type)
                                            <strong class="ms-sm-2 text-body">{{ $bookingValue->payment_type }}</strong>
                                        @else
                                            <strong class="ms-sm-2 text-body">{{ __('Not Available') }}</strong>
                                        @endif
                                    </strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4">{{ __('Booking Date & Time') }}</h5>
                            <div class="d-flex flex-column">
                                <p class="mb-0 d-flex align-items-center justify-content-between text-muted">
                                    <strong>{{ __('Date') }}:</strong><strong
                                        class="ms-sm-2 text-body">{{ App\Facades\UtilityFacades::date_format($bookingValue->booking_slots_date) }}</strong>
                                </p>
                            </div>
                            <ul class="mt-3 event-cards list-group list-group-flush w-100">
                                @php
                                    $bookingSlots = explode(',', $bookingValue['booking_slots']);
                                @endphp
                                @foreach ($bookingSlots as $bookingSlot)
                                    <li class="mb-3 list-group-item card">
                                        <div class="d-flex align-items-center">
                                            <div class="theme-avtar">
                                                <i class="ti ti-history text-primary f-20"></i>
                                            </div>
                                            <div class="ms-0">
                                                <h6 class="m-0">{{ $bookingSlot }}</h6>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
@endsection
@push('style')
    <link href="{{ asset('vendor/jqueryform/css/jquery.rateyo.min.css') }}" rel="stylesheet" />
@endpush
@push('script')
    <script src="{{ asset('vendor/jqueryform/js/jquery.rateyo.min.js') }}"></script>
    <script>
        var $starRating = $('.starRating');
        if ($starRating.length) {
            $starRating.each(function() {
                var val = $(this).attr('data-value');
                var no_of_star = $(this).attr('data-no_of_star');
                if (no_of_star == 10) {
                    val = val / 2;
                }
                $(this).rateYo({
                    rating: val,
                    readOnly: true,
                    numStars: no_of_star
                })
            });
        }
    </script>
@endpush
