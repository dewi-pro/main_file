@extends('layouts.main')
@section('title', __('Users'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Users') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active">{{ __('Users') }}</li>
        </ul>
        <div class="float-end">
            <div class="d-flex align-items-center">
                <a href="{{ route('grid.view','view') }}" data-bs-toggle="tooltip" title="{{ __('Grid View') }}"
                    class="btn btn-sm btn-primary" data-bs-placement="bottom">
                    <i class="ti ti-layout-grid"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    {{ $dataTable->table(['width' => '100%']) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('style')
    @include('layouts.includes.datatable-css')
@endpush
@push('script')
    @include('layouts.includes.datatable-js')
    {{ $dataTable->scripts() }}
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script>
        $(function() {
            $('body').on('click', '.add-user', function() {
                var modal = $('#common_modal');
                $.ajax({
                    type: "GET",
                    url: '{{ route('users.create') }}',
                    data: {},
                    success: function(response) {
                        modal.find('.modal-title').html('{{ __('Create User') }}');
                        modal.find('.body').html(response.html);
                        var multipleCancelButton = new Choices('#roles', {
                            removeItemButton: true,
                        });
                        var multipleCancelButton = new Choices('#country_code', {
                            removeItemButton: true,
                        });
                        modal.modal('show');
                    },
                    error: function(error) {}
                });
            });
            $('body').on('click', '#edit-user', function() {
                var action = $(this).attr('data-url');
                var modal = $('#common_modal');
                $.get(action, function(response) {

                    modal.find('.modal-title').html('{{ __('Edit User') }}');
                    modal.find('.body').html(response.html);
                    var multipleCancelButton = new Choices('#roles', {
                        removeItemButton: true,
                    });
                    var multipleCancelButton = new Choices('#country_code', {
                        removeItemButton: true,
                    });
                    modal.modal('show');
                })
            });
        });
    </script>
@endpush
