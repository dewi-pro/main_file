@extends('layouts.main')
@section('title', __('Add Form'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Add Form') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('forms.index'), __('Forms'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Add Form') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <!-- <div class="col-md-3 d-flex">
            <a class="btn-addnew-project h-100 w-100" href="{{ route('forms.create') }}">
                <div class="bg-primary add_user proj-add-icon">
                    <i class="ti ti-plus"></i>
                </div>
                <h6 class="mt-4 mb-2">{{ __('Start From Scratch') }}</h6>
                <p class="text-center text-muted">{{ __('A blank slate is all you need') }}</p>
            </a>
        </div> -->
        @foreach ($formTemplates as $formTemplate)
            <div class="col-xl-3 d-flex">
                <div class="text-center text-white card h-100 w-100">
                    <div class="pb-0 border-0 card-header">
                        <div class="d-flex align-items-center">
                            @if ($formTemplate->status == 1)
                                <span class="p-2 px-3 badge rounded-pill bg-success">{{ __('Active') }}</span>
                            @else
                                <span class="p-2 px-3 badge rounded-pill bg-danger">{{ __('Deactive') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- <img src="{{ Storage::url($formTemplate->image) }}" alt="user-image" class="w-100"> -->
                        <h4 class="mt-2 text-dark">{{ $formTemplate->title }}</h4>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('forms.use.template', $formTemplate->id) }}"
                            class="my-2 text-center btn btn-light-primary w-100"
                            role="button"><span>{{ __('Use Template') }}</span></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
