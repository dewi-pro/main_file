@extends('layouts.main')
@section('title', __('Landing Page'))
@section('breadcrumb')
<div class="col-md-12">
    <div class="page-header-title">
        <h4 class="m-b-10">{{ __('Start View Settings') }}</h4>
    </div>
    <ul class="breadcrumb">
        <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
        <li class="breadcrumb-item">{{ __('Start View Settings') }}</li>
    </ul>
</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            @include('landing-page.landingpage-sidebar')
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="card">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="apps-setting" role="tabpanel"
                                aria-labelledby="landing-apps-setting">
                                {!! Form::open([
                                    'route' => ['landing.start.view.store'],
                                    'method' => 'Post',
                                    'id' => 'froentend-form',
                                    'enctype' => 'multipart/form-data',
                                    'data-validate',
                                    'no-validate',
                                ]) !!}
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <h5 class="mb-0">{{ __('Start Using View Setting') }}</h5>
                                        </div>
                                        <div class="col-lg-4 d-flex justify-content-end">
                                            <div class="form-switch custom-switch-v1 d-inline-block">
                                                {!! Form::checkbox(
                                                    'start_view_setting_enable',
                                                    null,
                                                    Utility::getsettings('start_view_setting_enable') == 'on' ? true : false,
                                                    [
                                                        'class' => 'custom-control custom-switch form-check-input input-primary',
                                                        'id' => 'startViewSettingEnableBtn',
                                                        'data-onstyle' => 'primary',
                                                        'data-toggle' => 'switchbutton',
                                                    ],
                                                ) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                {{ Form::label('start_view_name', __('Start View Name'), ['class' => 'form-label']) }}
                                                {!! Form::text('start_view_name', Utility::getsettings('start_view_name'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter start view name'),
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                {{ Form::label('start_view_detail', __('Start View Detail'), ['class' => 'form-label']) }}
                                                {!! Form::text('start_view_detail', Utility::getsettings('start_view_detail'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter start view detail'),
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                {{ Form::label('start_view_link_name', __('Start View Link Name'), ['class' => 'form-label']) }}
                                                {!! Form::text('start_view_link_name', Utility::getsettings('start_view_link_name'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter start view link name'),
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                {{ Form::label('start_view_link', __('Start View Link'), ['class' => 'form-label']) }}
                                                {!! Form::text('start_view_link', Utility::getsettings('start_view_link'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter start view link'),
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                {{ Form::label('start_view_image', __('Image'), ['class' => 'form-label']) }} *
                                                {!! Form::file('start_view_image', ['class' => 'form-control', 'id' => 'start_view_image']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-end">
                                        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
