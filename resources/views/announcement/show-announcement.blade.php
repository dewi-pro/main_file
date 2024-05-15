@extends('layouts.main')
@section('title', __('Show Announcement'))
@section('breadcrumb')
<div class="col-md-12">
    <div class="page-header-title">
        <h4 class="m-b-10">{{ __('Show Announcements') }}</h4>
    </div>
    <ul class="breadcrumb">
        <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
        <li class="breadcrumb-item">{{ __('Show Announcements') }}</li>
    </ul>
</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-8 m-auto">
            <div class="card text-center">
                <div class="card-header">
                    <h5>{{ __('Show Announcement') }}</h5>
                    <p class="card-subtitle text-muted">{{ __('Start Date') }} : {{ Utility::date_time_format($showAnnouncement->start_date) }}</p>
                    <p class="card-subtitle text-muted">{{ __('End Date') }} : {{ Utility::date_time_format($showAnnouncement->end_date) }}</p>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-4">{{ $showAnnouncement->title }}</h5>
                    <img class="img-fluid card-img-bottom mb-2" src="{{ Storage::url($showAnnouncement->image) }}" alt="Card image cap">
                    <hr>
                    <p>{!! $showAnnouncement->description !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

