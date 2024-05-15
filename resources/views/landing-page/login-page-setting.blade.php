@extends('layouts.main')
@section('title', __('Landing Page'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Login Setting') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Login Setting') }}</li>
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
                    <div class="tab-content" id="pills-tabContent">
                        <div class="card">
                            <div class="tab-pane fade show active" id="apps-setting" role="tabpanel"
                                aria-labelledby="landing-apps-setting">
                                {!! Form::open([
                                    'route' => ['landing.login.store'],
                                    'method' => 'Post',
                                    'id' => 'froentend-form',
                                    'enctype' => 'multipart/form-data',
                                    'data-validate',
                                    'no-validate',
                                ]) !!}
                                <div class="card-header">
                                    <h5> {{ __('LogIn Page Setting') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group">
                                            {{ Form::label('login_image', __('Image'), ['class' => 'form-label']) }} *
                                            {!! Form::file('login_image', ['class' => 'form-control', 'id' => 'images']) !!}
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {{ Form::label('login_title', __('Login Title'), ['class' => 'form-label']) }}
                                                {!! Form::text('login_title', Utility::getsettings('login_title'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter login title'),
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {{ Form::label('login_subtitle', __('Login Subtitle'), ['class' => 'form-label']) }}
                                                {!! Form::text('login_subtitle', Utility::getsettings('login_subtitle'), [
                                                    'class' => 'form-control',
                                                    'placeholder' => __('Enter login subtitle'),
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary float-end mb-3']) }}
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
