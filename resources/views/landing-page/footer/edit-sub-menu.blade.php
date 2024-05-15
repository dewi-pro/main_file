@extends('layouts.main')
@section('title', __('Landing Page'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Landing page') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('edit sub menu') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-6 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Edit Footer Sub Menu') }}</h5>
                        </div>
                        <div class="card-body">
                            {!! Form::open([
                                'route' => ['footer.sub.menu.update', $footerPage->id],
                                'method' => 'Post',
                                'class' => 'form-horizontal',
                                'data-validate',
                                'no-validate',
                            ]) !!}
                            <div class="row">
                                <div class="form-group">
                                    {{ Form::label('page_id', __('Select Page'), ['class' => 'form-label']) }}
                                    {!! Form::select('page_id', $pages, $footerPage->page_id, [
                                        'class' => 'form-select',
                                        'required',
                                        'data-trigger',
                                    ]) !!}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('parent_id', __('Menu'), ['class' => 'form-label']) }}
                                    {!! Form::select('parent_id', $footer, $footerPage->parent_id, [
                                        'class' => 'form-select',
                                        'required',
                                        'data-trigger',
                                    ]) !!}
                                </div>
                                <div class="card-footer">
                                    <div class="text-end">
                                        <a href="{{ route('landing.footer.index') }}"><button type="button"
                                                class="btn btn-secondary"
                                                data-bs-dismiss="modal">{{ __('Close') }}</button></a>
                                        {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'This is a placeholder set in the config',
                    searchPlaceholderValue: 'This is a search placeholder',
                });
            }
        });
    </script>
@endpush
