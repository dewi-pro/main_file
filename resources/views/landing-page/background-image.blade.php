@extends('layouts.main')
@section('title', __('Landing Page'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Background Setting') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Background Setting') }}</li>
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
                    <div class="card"></div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="card">
                            <div class="tab-pane fade show active" id="apps-setting" role="tabpanel"
                                aria-labelledby="landing-apps-setting">
                                {!! Form::open([
                                    'route' => ['landing.page.background.store'],
                                    'method' => 'Post',
                                    'id' => 'froentend-form',
                                    'enctype' => 'multipart/form-data',
                                    'data-validate',
                                    'no-validate',
                                ]) !!}
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h5 class="mb-0">{{ __('Background Setting') }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                {{ Form::label('background_image', __('Background Image'), ['class' => 'form-label']) }}
                                                *
                                                {!! Form::file('background_image', ['class' => 'form-control', 'id' => 'background_image']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-end">
                                        {{ Form::button(__('Save'), ['type' => 'submit',  'class' => 'btn btn-primary']) }}
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
    </div>
@endsection
