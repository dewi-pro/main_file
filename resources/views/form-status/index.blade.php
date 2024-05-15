@extends('layouts.main')
@section('title', __('Statuses'))
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h4 class="m-b-10">{{ __('Form Statuses') }}</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">
                            {!! Html::link(route('home'), __('Dashboard'), ['']) !!}
                        </li>
                        <li class="breadcrumb-item active">{{ __('Form Statuses') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
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
            $('body').on('click', '.form-status', function() {
                var modal = $('#common_modal');
                $.ajax({
                    type: "GET",
                    url: '{{ route('form-status.create') }}',
                    data: {},
                    success: function(response) {
                        modal.find('.modal-title').html('{{ __('Create Form Status') }}');
                        modal.find('.body').html(response.html);
                        modal.modal('show');
                        var colorSelect = document.getElementById('color');
                        var statusSelect = document.getElementById('status');

                        var colorChoices = new Choices(colorSelect, {
                            placeholder: true,
                            searchEnabled: true,
                            searchPlaceholderValue: 'Type to search'
                        });

                        var statusChoices = new Choices(statusSelect, {
                            placeholder: true,
                            searchEnabled: true,
                            searchPlaceholderValue: 'Type to search'
                        });

                        colorSelect.addEventListener('change', function(event) {
                            document.getElementById('color-hidden').value = event.target
                                .value;
                        });

                        statusSelect.addEventListener('change', function(event) {
                            document.getElementById('status-hidden').value = event
                                .target.value;
                        });
                    },
                    error: function(error) {}
                });
            });

            $(document).on('click', '#edit-form-status', function() {
                var action = $(this).data('url');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Edit Form Status') }}');
                    modal.find('.body').html(response.html);
                    modal.modal('show');
                    var colorSelect = document.getElementById('color');
                    var statusSelect = document.getElementById('status');

                    var colorChoices = new Choices(colorSelect, {
                        placeholder: true,
                        searchEnabled: true,
                        searchPlaceholderValue: 'Type to search'
                    });

                    var statusChoices = new Choices(statusSelect, {
                        placeholder: true,
                        searchEnabled: true,
                        searchPlaceholderValue: 'Type to search'
                    });

                    colorSelect.addEventListener('change', function(event) {
                        document.getElementById('color-hidden').value = event.target.value;
                    });

                    statusSelect.addEventListener('change', function(event) {
                        document.getElementById('status-hidden').value = event.target.value;
                    });
                })
            });
        });
    </script>
@endpush
