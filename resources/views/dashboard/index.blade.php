@extends('layouts.main')
@section('title', __('Dashboard Widgets'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Dashboard Widgets') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active">{{ __('Dashboard Widgets') }}</li>
        </ul>
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
            $('body').on('click', '.add_dashboard', function() {
                var modal = $('#common_modal');
                $.ajax({
                    type: "GET",
                    url: '{{ route('create.dashboard') }}',
                    data: {},
                    success: function(response) {
                        modal.find('.modal-title').html('{{ __('Create Dashboard Widget') }}');
                        modal.find('.body').html(response);
                        new Choices('#form_title', {
                            removeItemButton: true,
                        });
                        new Choices('#poll_title', {
                            removeItemButton: true,
                        });
                        new Choices('#size', {
                            removeItemButton: true,
                        });
                        new Choices('#type', {
                            removeItemButton: true,
                        });
                        new Choices('#chart_type', {
                            removeItemButton: true,
                        });
                        modal.modal('show');
                    },
                    error: function(error) {
                    }
                });
            });
            $('body').on('click', '#edit-dashboard', function() {
                var action = $(this).attr('data-url');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Edit Dashboard Widget') }}');
                    modal.find('.body').html(response);
                    new Choices('#form_title', {
                        removeItemButton: true,
                    });
                    new Choices('#poll_title', {
                        removeItemButton: true,
                    });
                    new Choices('#field_name', {
                        removeItemButton: true,
                    });
                    new Choices('#size', {
                        removeItemButton: true,
                    });
                    new Choices('#chart_type', {
                        removeItemButton: true,
                    });
                    modal.modal('show');
                })
            });
        });
        $(document).on("change", "#form_title", function() {
            var cate_id = $(this).val();
            $.ajax({
                url: '{{ route('widget.chnages') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    widget: cate_id,
                },
                success: function(data) {
                    var toAppend = '';
                    $.each(data, function(i, o) {
                        toAppend += '<option value=' + o.name + '>' + o.label + '</option>';
                    });
                    $('.field_name').html(
                        '<select name="field_name" class="form-control" id="field_name" data-trigger>' +
                        toAppend +
                        '</select>');
                    new Choices('#field_name', {
                        removeItemButton: true,
                    });
                }
            })
        });
    </script>
@endpush
