@extends('layouts.main')
@section('title', __('Landing Page'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Header Settings') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Header Settings') }}</li>
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
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    <h5>{{ __('Header Main Menu') }}</h5>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 justify-content-end d-flex">
                                    <a href="javascript:void(0);" data-url="{{ route('header.menu.create') }}"
                                        data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        class="btn btn-sm btn-primary mx-1 header-menu-create"
                                        data-bs-original-title="{{ __('Create') }}">
                                        <i class="ti ti-plus text-light"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No') }}</th>
                                            <th>{{ __('Menu Name') }}</th>
                                            <th>{{ __('Slug') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (is_array($headerSettings) || is_object($headerSettings))
                                            @php
                                                $ff_no = 1;
                                            @endphp
                                            @foreach ($headerSettings as $key => $headerMenu)
                                                <tr>
                                                    <td>{{ $ff_no++ }}</td>
                                                    <td>{{ $headerMenu['menu'] }}</td>
                                                    <td>{{ $headerMenu['slug'] }}</td>
                                                    <td>
                                                        <span class="d-flex">
                                                            <div>
                                                                <a href="javascript:void(0);"
                                                                    data-url="{{ route('header.menu.edit', $headerMenu->id) }}"
                                                                    data-ajax-popup="true" data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom"
                                                                    class="btn btn-sm btn-primary mx-1 header-menu-edit"
                                                                    data-bs-original-title="{{ __('Create') }}">
                                                                    <i class="ti ti-pencil text-light"></i>
                                                                </a>
                                                            </div>

                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'class' => 'd-inline',
                                                                'route' => ['header.menu.delete', $headerMenu->id],
                                                                'id' => 'delete-form-' . $headerMenu->id,
                                                            ]) !!}
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-sm small btn btn-danger show_confirm"
                                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                id="delete-form-1"
                                                                data-bs-original-title="{{ __('Delete') }}">
                                                                <i class="ti ti-trash text-white"></i>
                                                            </a>
                                                            {!! Form::close() !!}

                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">
@endpush
@push('script')
    <script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('body').on('click', '.header-menu-create', function() {
                var action = $(this).data('url');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Create Menu') }}');
                    modal.find('.body').html(response);
                    var multipleCancelButton = new Choices('#page_name', {
                            removeItemButton: true,
                        });
                    modal.modal('show');
                })
            });
        });
        $(document).ready(function() {
            $('body').on('click', '.header-menu-edit', function() {
                var action = $(this).data('url');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Edit Menu') }}');
                    modal.find('.body').html(response);
                    var multipleCancelButton = new Choices('#page_name', {
                            removeItemButton: true,
                        });
                    modal.modal('show');
                })
            });
        });
    </script>
@endpush
