@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.environment.classic.templateTitle') }}
@endsection

@section('title')
    <i class="ti ti-code fa-fw" aria-hidden="true"></i> {{ trans('installer_messages.environment.classic.title') }}
@endsection

@section('container')

    <form method="post" id="form_install" action="{{ route('LaravelInstaller::environmentSaveClassic') }}">
        {!! csrf_field() !!}
        <textarea class="textarea" name="envConfig">{{ $envConfig }}</textarea>
        <div class="buttons buttons--right">
            <button class="button button--light" type="submit">
            	<i class="ti ti-device-floppy" aria-hidden="true"></i>
             	{!! trans('installer_messages.environment.classic.save') !!}
            </button>
        </div>
    </form>

    @if( ! isset($environment['errors']))
        <div class="buttons-container">
            <a class="button float-left" href="{{ route('LaravelInstaller::environmentWizard') }}">
                <i class="ti ti-mist" aria-hidden="true"></i>
                {!! trans('installer_messages.environment.classic.back') !!}
            </a>
            <a class="button float-end" id="save_and_install" href="#" data-action="{{ route('LaravelInstaller::environmentSaveAndInstallClassic') }}">
                <i class="ti ti-check" aria-hidden="true"></i>
                {!! trans('installer_messages.environment.classic.install') !!}
                <i class="ti ti-chevron-double-right fa-fw" aria-hidden="true"></i>
            </a>
        </div>
    @endif

@endsection

@section('scripts')
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script>
        $(document).on("click","#save_and_install",function(){
            $("#form_install").attr('action',$(this).attr('data-action'));
            $("#form_install").submit();
        })
    </script>
@endsection
