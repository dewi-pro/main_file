@extends('layouts.main')
@section('title', __('Categories'))
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h4 class="m-b-10">{{ __('Form Type') }}</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">
                            {!! Html::link(route('home'), __('Dashboard'), ['']) !!}
                        </li>
                        <li class="breadcrumb-item active">{{ __('Form Type') }}</li>
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
        $('body').on('click', '.add-category', function() {
            var modal = $('#common_modal');
            $.ajax({
                type: "GET",
                url: '{{ route('form-type.create') }}',
                data: {},
                success: function(response) {
                    modal.find('.modal-title').html('{{ __('Create Form Type') }}');
                    modal.find('.body').html(response.html);
                    modal.modal('show');
                    var genericExamples = document.querySelectorAll('[data-trigger]');
                    for (i = 0; i < genericExamples.length; ++i) {
                        var element = genericExamples[i];
                        new Choices(element, {
                            placeholderValue: 'Select Option',
                            searchPlaceholderValue: 'Select Option',
                        });
                    }
                },
                error: function(error) {}
            });
        });

        $(document).on('click', '#edit-form-type', function() {
            var action = $(this).data('url');
            var modal = $('#common_modal');
            $.get(action, function(response) {
                modal.find('.modal-title').html('{{ __('Edit Form Type') }}');
                modal.find('.body').html(response.html);
                modal.modal('show');
                var genericExamples = document.querySelectorAll('[data-trigger]');
                for (i = 0; i < genericExamples.length; ++i) {
                    var element = genericExamples[i];
                    new Choices(element, {
                        placeholderValue: 'Select Option',
                        searchPlaceholderValue: 'Select Option',
                    });
                }
            })
        });
    </script>
@endpush
