@php
    use App\Facades\UtilityFacades;
    $today_date = Carbon\Carbon::now()->toDateTimeString();
@endphp
@extends('layouts.form')
@section('title', __('Fill'))
@section('content')
    <div class="row">
        <div class="col-sm-12 p-5">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Forms') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($forms as $form)
                            @if ($form->json != '')
                                @if ($form->set_end_date != '0')
                                    @if ($form->set_end_date_time && $form->set_end_date_time > $today_date)
                                        @php
                                            $hashids = new Hashids('', 20);
                                            $id = $hashids->encodeHex($form->id);
                                        @endphp
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12 p-4">
                                            <div class="btn-addnew-project text-center">
                                                <div class="card-body">
                                                    <img src="{{ Illuminate\Support\Facades\File::exists(Storage::path($form->logo)) ? Utility::getpath($form->logo) : Storage::url('app-logo/78x78.png') }}"
                                                        width="100px" class="mb-5">
                                                    <h4 class="text-muted mt-2">{{ $form->title }}</h4>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="{{ route('forms.survey', $id) }}"
                                                        class=" btn btn-default btn-light-primary d-inline-flex align-items-center"
                                                        tabindex="0">
                                                        {{ __('Form View') }}
                                                        <i class="ti ti-chevron-right ms-2"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    @php
                                        $hashids = new Hashids('', 20);
                                        $id = $hashids->encodeHex($form->id);
                                    @endphp
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12 p-4">
                                        <div class="btn-addnew-project text-center">
                                            <div class="card-body">
                                                <img src="{{ Illuminate\Support\Facades\File::exists(Storage::path($form->logo)) ? Utility::getpath($form->logo) : Storage::url('app-logo/78x78.png') }}"
                                                    width="100px" class="mb-5">
                                                <h4 class="text-muted mt-2">{{ $form->title }}</h4>
                                            </div>
                                            <div class="card-footer">
                                                <a href="{{ route('forms.survey', $id) }}"
                                                    class=" btn btn-default btn-light-primary d-inline-flex align-items-center"
                                                    tabindex="0">
                                                    {{ __('Form View') }}
                                                    <i class="ti ti-chevron-right ms-2"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
