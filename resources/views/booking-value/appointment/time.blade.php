@php
    use App\Facades\UtilityFacades;
@endphp
@extends('layouts.form')
@section('title', __('Show Booking'))
@section('content')
    <div class="container">
        <div class="mx-auto mt-5 col-md-7">
            <div class="card" id="printTable">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-8 invoice-contact">
                            <div class="invoice-box row">
                                <div class="col-sm-12">
                                    <table class="table mt-0 table-responsive invoice-table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td>{{ $booking->business_name }},<br>{{ $booking->business_address }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ $booking->business_email }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ $booking->business_website }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ $booking->business_number }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ $booking->business_phone }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                    <div class="row invoive-info d-print-inline-flex">
                        <div class="col-sm-8">
                            <h6 class="m-b-20">{{ __('Order Details :') }}</h6>
                            <table class="table mt-0 table-responsive invoice-table invoice-order table-borderless">
                                <tbody>
                                    <tr>
                                        <th>{{ __('Booking Slot Date') }} : </th>
                                        <td>{{ UtilityFacades::date_format($bookingValue->booking_slots_date) }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Booking Slots') }} :</th>
                                        <td>{{ $bookingValue->booking_slots }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ 'Status' }} :</th>
                                        <td>
                                            @if ($bookingValue->booking_status == 1)
                                                <span class="badge bg-success">{{ __('Successfully') }}</span>
                                            @elseif($bookingValue->booking_status == 0)
                                                <span class="badge bg-danger">{{ __('Cancel') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-4">
                            @if ($bookingValue->booking_status == 1)
                                {!! Form::open([
                                    'method' => 'DELETE',
                                    'class' => 'd-inline',
                                    'route' => ['appointment.slot.cancel', $bookingValue->id],
                                    'id' => 'delete-form-' . $bookingValue->id,
                                ]) !!}
                                <a href="#" class="btn btn-sm small btn-danger show_confirm" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" id="delete-form-{{ $bookingValue->id }}"
                                    data-bs-original-title="{{ __('Cancel Slots') }}"
                                    aria-label="{{ __('Cancel Slots') }}">{{ __('Cancel Slots') }}</a>
                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            @foreach ($array as $keys => $rows)
                                @foreach ($rows as $row_key => $row)
                                    @if ($row->type == 'checkbox-group')
                                        <div class="col-md-6 col-12">
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
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <{{ $row->subtype }}>
                                                    {!! html_entity_decode($row->label) !!}
                                                    </{{ $row->subtype }}>
                                            </div>
                                        </div>
                                    @elseif($row->type == 'paragraph')
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <{{ $row->subtype }}>
                                                    {!! html_entity_decode($row->label) !!}
                                                    </{{ $row->subtype }}>
                                            </div>
                                        </div>
                                    @elseif($row->type == 'radio-group')
                                        <div class="col-md-6 col-12">
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
                                        <div class="col-md-6 col-12">
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
                                        <div class="col-md-6 col-12">
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
                                        <div class="col-md-6 col-12">
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
                                        <div class="col-md-6 col-12">
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
                                        <div class="col-md-6 col-12">
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
                                        <div class="col-md-6 col-12">
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
                                        <div class="col-md-6 col-12">
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
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <img src="{{ asset(Storage::url($row->value)) }}">
                                                </div>
                                            </div>
                                        @endif
                                    @elseif($row->type == 'break')
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <hr style="border: 1px solid #ccc">
                                            </div>
                                        </div>
                                    @elseif($row->type == 'location')
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                {!! Form::label('location_id', 'Location:') !!}
                                                <iframe width="100%" height="260" frameborder="0" scrolling="no"
                                                    marginheight="0" marginwidth="0"
                                                    src="https://maps.google.com/maps?q={{ $row->value }}&hl=en&z=14&amp;output=embed">
                                                </iframe>
                                            </div>
                                        </div>
                                    @elseif($row->type == 'video')
                                        <div class="col-md-6 col-12">
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
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}<br>
                                                <a href="{{ route('selfie.image.download', $bookingValue->id) }}">
                                                    <button class="p-2 btn btn-primary"
                                                        id="downloadButton">{{ __('Download Video') }}</button></a>
                                            </div>
                                        </div>
                                    @elseif($row->type == 'selfie')
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                {{ Form::label($row->name, $row->label, ['class' => 'form-label']) }}<br>
                                                <img
                                                    src=" {{ Illuminate\Support\Facades\File::exists(Storage::path($row->value)) ? Storage::url($row->value) : Storage::url('app-logo/78x78.png') }}"class="mb-2 img-responsive img-thumbnailss">
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
                        <div class="col-sm-12">
                            <div class="text-end">
                                <button class="btn btn-primary btn-print-invoice"><i
                                        class="ti ti-printer"></i>{{ __('Print') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <link href="{{ asset('vendor/jqueryform/css/jquery.rateyo.min.css') }}" rel="stylesheet" />
@endpush
@push('script')
    <script src="{{ asset('vendor/jqueryform/js/jquery.rateyo.min.js') }}"></script>
    <script>
        document.querySelector('.btn-print-invoice').addEventListener('click', function() {
            var link2 = document.createElement('link');
            link2.innerHTML =
                '<style>@media print{*,::after,::before{text-shadow:none!important;box-shadow:none!important}a:not(.btn){text-decoration:none}abbr[title]::after{content:" ("attr(title) ")"}pre{white-space:pre-wrap!important}blockquote,pre{border:1px solid #adb5bd;page-break-inside:avoid}thead{display:table-header-group}img,tr{page-break-inside:avoid}table,thead,tr,td{background:transparent}h2,h3,p{orphans:3;widows:3}h2,h3{page-break-after:avoid}@page{size:a3}body{min-width:992px!important}.container{min-width:992px!important}.page-header,.pc-sidebar,.pc-mob-header,.pc-header,.pct-customizer,.modal,.navbar{display:none}.pc-container{top:0;}.invoice-contact{padding-top:0;}@page,.card-body,.card-header,body,.pcoded-content{padding:0;margin:0}.badge{border:1px solid #000}.table{border-collapse:collapse!important}.table td,.table th{background-color:#fff!important}.table-bordered td,.table-bordered th{border:1px solid #dee2e6!important}.table-dark{color:inherit}.table-dark tbody+tbody,.table-dark td,.table-dark th,.table-dark thead th{border-color:#dee2e6}.table .thead-dark th{color:inherit;border-color:#dee2e6}}</style>';
            document.getElementsByTagName('head')[0].appendChild(link2);
            window.print();
        });
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
