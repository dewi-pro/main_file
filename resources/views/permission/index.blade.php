@extends('layouts.main')
@section('title', __('Permission'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Permissions') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item"> {{ __('Permissions') }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive py-5 pb-4 ">
                        <div class="container-fluid">
                            {{ $dataTable->table(['width' => '100%']) }}
                        </div>
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
    <script>
        $(function() {
            $('.add-permission').on('click', function() {
                var modal = $('#common_modal');
                $.ajax({
                    type: "GET",
                    url: '{{ route('permission.create') }}',
                    data: {},
                    success: function(response) {
                        modal.find('.modal-title').html('{{ __('Create permission') }}');
                        modal.find('.body').html(response.html);
                        modal.modal('show');
                    },
                    error: function(error) {
                    }
                });
            });
            $('body').on('click', '.edit-permission', function() {
                var action = $(this).data('action');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Edit permission') }}');
                    modal.find('.body').html(response.html);
                    modal.modal('show');
                })
            });
        });
    </script>
@endpush
