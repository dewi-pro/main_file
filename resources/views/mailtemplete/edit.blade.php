@extends('layouts.main')
@section('title', __('Edit Email Template'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Edit Email Template') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('mailtemplate.index'), __('Email Templates'), []) !!} </li>
            <li class="breadcrumb-item active">{{ __('Edit Email Template') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="layout-px-spacing row">
        <div id="basic" class="mx-auto col-lg-6 layout-spacing">
            <div class="statbox card box box-shadow">
                <div class="card-header">
                    <h5>{{ __('Edit Email Template') }}</h5>
                </div>
                {!! Form::model($mailtemplate, [
                    'route' => ['mailtemplate.update', $mailtemplate->id],
                    'method' => 'PUT',
                    'data-validate',
                ]) !!}
                <div class="card-body">
                    <div class="row">
                        <div class="mx-auto col-lg-12 col-12">
                            <div class="form-group">
                                {{ Form::label('variables', __('Variables ;'), ['class' => 'form-label fw-bolder text-dark fs-6']) }}
                                @foreach ($mailtemplate->variables as $variables)
                                    <span class="fw-bolder text-dark fs-6">{{ <?php echo $variables; ?> }}</span>
                                @endforeach
                            </div>
                            <div class="form-group">
                                {{ Form::label('mailable', __('Mailable'), ['class' => 'form-label']) }}
                                {!! Form::text('mailable', null, ['placeholder' => 'App\Mail\TestMail', 'class' => 'form-control', 'readonly']) !!}
                            </div>
                            <div class="form-group">
                                {{ Form::label('subject', __('Subject'), ['class' => 'form-label']) }}
                                {!! Form::text('subject', null, [
                                    'placeholder' => 'readonly',
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group">
                                {{ Form::label('html_template', __('Html Template'), ['class' => 'form-label']) }}
                                {!! Form::textarea('html_template', null, [
                                    'placeholder' => '',
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-end">
                        {!! Html::link(route('mailtemplate.index'), __('Cancel'), ['class' => 'btn btn-secondary']) !!}
                        {{ Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-primary']) }}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@push('script')
<script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('html_template', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
