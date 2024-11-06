@extends('layouts.main')
@section('title', __('Report Corporate & Operation'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Report Corporate & Operation') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active"> {{ __('Report Corporate & Operation') }} </li>
        </ul>
        <div class="float-end d-flex align-items-center">
            <div class="me-2">
                <button class="btn btn-primary btn-sm" id="filter_btn" data-bs-toggle="tooltip" title="{{ __('Filter') }}"
                    data-bs-placement="bottom"><i class="fas fa-filter"></i></button>
            </div>
        </div>
    </div>
    <div id="filter">
        <div class="card mt-3 mb-0">
            <div class="card-header">
                <h5>{{ __('Filter') }}</h5>
            </div>
            <div class="card-body">
                <div class="row align-items-end filters">
                    <div class="col-md-4 col-sm-12 form-group">
                        {{ Form::label('weekly', __('Weekly'), ['class' => 'form-label']) }}
                        <select name="weekly" id="weekly" class='form-control weekly' onchange=dateExcel() data-trigger>
                            <option value="" selected>{{ __('Select your need!') }}</option>
                                <option value="1, 8">Week 1</option>
                                <option value="9, 15">Week 2</option>
                                <option value="16, 22">Week 3</option>
                                <option value="23, 31">Week 4</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12 form-group">
                        {{ Form::label('month', __('Month'), ['class' => 'form-label']) }}
                        <select name="month" id="month" class='form-control month' onchange=monthExcel() data-trigger>
                            <option value="" selected>{{ __('Select your need!') }}</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12 form-group">
                        {{ Form::label('company', __('COMPANY'), ['class' => 'form-label']) }}
                        <select name="company" id="company" class='form-control company' onchange=companyExcel() data-trigger>
                            <option value="" selected>{{ __('Select Company') }}</option>
                            @foreach ($company as $id => $company_name)
                                <option value="{{ $company_name }}">{{ $company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12 form-group">
                        {{ Form::label('rate', __('RATE'), ['class' => 'form-label']) }}
                        <select name="rate" id="rate" class='form-control rate' onchange=rateExcel() data-trigger>
                            <option value="" selected>{{ __('Select Rate') }}</option>
                                <option value="Very Satisfied (Sangat Puas)">Very Satisfied (Sangat Puas)</option>
                                <option value="Satisfied (Puas)">Satisfied (Puas)</option>
                                <option value="Less Satisfied (Kurang Puas)">Less Satisfied (Kurang Puas)</option>
                                <option value="Not Satisfied (Tidak Puas)">Not Satisfied (Tidak Puas)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer ms-auto">
                {!! Form::button(__('Apply'), ['id' => 'applyfilter', 'class' => 'btn btn-primary']) !!}
                {!! Form::button(__('Clear'), ['id' => 'clearfilter', 'class' => 'btn btn-secondary']) !!}
                {!! Form::open(['route' => ['download.reportco.values.excel'],'method' => 'post','id' => 'mass_export','class' => 'd-inline-block',]) !!}
                {{ Form::hidden('select_date') }}
                {{ Form::hidden('select_month') }}
                {{ Form::hidden('select_company') }}
                {{ Form::hidden('select_rate') }}
                {{ Form::submit('Export to Excel', ['class' => 'btn btn-success']) }}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <!-- <div class="card-header border-bottom justify-content-between">
                    <div class="row justify-content-between">
                        <div class="col-12">
                            <ul class="nav nav-pills mb-2" id="pills-tab" role="tablist">
                                @php
                                    $view = request()->query->get('view');
                                @endphp
                                <li class="nav-item">
                                    <a class="nav-link   {{ $view != 'trash' ? 'active' : '' }}"
                                        href="{{ route('forms.index') }}">{{ __('All') }} <span
                                            class="badge ms-1 {{ isset($view) ? 'bg-primary text-light' : 'bg-light text-primary' }}">{{ isset($form) ? $form : 0 }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $view == 'trash' ? 'active' : '' }}"
                                        href="{{ route('forms.index', 'view=trash') }}">{{ __('Trash') }}
                                        <span
                                            class="badge ms-1 {{ isset($view) ? 'bg-light text-primary' : 'bg-primary text-light' }}">{{ isset($trashForm) ? $trashForm : 0 }}</span></a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <select class="form-select  selectric mb-1" data-trigger>
                                <option value="">{{ __('Action For Selected') }}</option>
                                @php
                                    $view = request()->query->get('view');
                                    if ($view !== null && $view == 'trash') {
                                        echo '<option value="restore">' . __('Restore Back') . '</option>';
                                    } else {
                                        echo '<option value="trash" class="show_confirm_submited_form_delete">' .
                                            __('Move to Trash') .
                                            '</option>';
                                    }
                                @endphp
                                <option value="delete">{{ __('Delete Permanently') }}</option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-3 text-end">
                            @if ($view !== null && $view == 'trash')
                                <a class="deleteAll btn btn-danger btn-lg text-white" tabindex="0" aria-controls="user-table"
                                    type="button"><span><i
                                            class="fa fa-trash me-1 text-md"></i>{{ __('Empty Trash') }}</span></a>
                            @endif
                        </div>
                    </div>

                </div> -->

                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    @include('layouts.includes.datatable-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}" />
@endpush
@push('script')
    @include('layouts.includes.datatable-js')
    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/daterangepicker/daterangepicker.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>

    {{ $dataTable->scripts() }}
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).attr('data-url')).select();
            document.execCommand("copy");
            $temp.remove();
            show_toastr('Great!', '{{ __('Copy Link Successfully.') }}', 'success',
                '{{ asset('assets/images/notification/ok-48.png') }}', 4000);
        }
        $(function() {
            $('body').on('click', '#share-qr-code', function() {
                var action = $(this).data('share');
                var modal = $('#common_modal2');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('QR Code') }}');
                    modal.find('.modal-body').html(response.html);
                    feather.replace();
                    modal.modal('show');
                })
            });
        });


        $(document).on('click', "#filter_btn", function() {
            $("#filter").toggle("slow")
        });

        document.querySelector("#filterdate").flatpickr({
            mode: "range"
        });

        var multipleCancelButton = new Choices(
            '#choices-multiple-remove-button', {
                removeItemButton: true,
            }
        );
        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    // placeholderValue: 'This is a placeholder set in the config',
                    searchPlaceholderValue: 'This is a search placeholder',
                });
            }
        });

        $(document).ready(function() {

            $(document).on('change', 'input[name="checkbox-all"]', function() {
                var isChecked = $(this).prop('checked');
                $('.selected-checkbox').prop('checked', isChecked).trigger('change');
            });

            $(document).on('change', '.selectric', function(e) {
                var selected = [],
                    action = $(this).val();
                if (action != '') {
                    $('input.dt-checkboxes:checked').each(function() {
                        selected.push($(this).data('id'));
                    });
                    if (action == 'trash' && selected.length > 0) {
                        var url = '{{ route('form.destroy.multiple') }}';
                        var text =
                            "If you trash this form, all the submitted forms will also be trashed. Do you want to continue?";
                    } else if (action == 'delete' && selected.length > 0) {
                        @php
                            $view = request()->query->get('view');
                            if ($view !== null && $view == 'trash') {
                                $url = route('form.force.delete.Multiple', 'view=trash');
                            } else {
                                $url = route('form.force.delete.Multiple');
                            }
                        @endphp
                        var url = '{{ $url }}';
                        var text =
                            "If you delete permanently this form, all the submitted forms will also be Delete Permanently. Do you want to continue?";
                    } else if (action == 'restore' && selected.length > 0) {
                        var url = '{{ route('form.restore.multiple') }}';
                        var text =
                            "If you restore this form, all the submitted forms will also be restore. Do you want to continue?"
                    } else {
                        show_toastr('error', '{{ __('Please select any one form') }}', {
                            closeButton: true,
                            tapToDismiss: false
                        });
                        return;

                    }
                    if (selected.length > 0) {
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success',
                                cancelButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                        })
                        swalWithBootstrapButtons.fire({
                            title: 'Are you sure?',
                            text: text,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "POST",
                                    url: url,
                                    data: {
                                        '_token': '{{ csrf_token() }}',
                                        'ids': selected
                                    },
                                    success: function(response) {
                                        show_toastr('Success!', response.msg,
                                            'success');
                                        window.location.reload();
                                    }
                                })
                            } else {
                                $(this).val('').trigger('change');
                            }
                        })
                    }
                }
            });

            $(document).on('click', '.deleteAll', function(e) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "If you delete this form, all the submitted forms will also be deleted. Do you want to continue?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: '{{ route('form.force.delete.all') }}',
                            data: {
                                '_token': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                show_toastr('Success!', response.msg,
                                    'success');
                                window.location.reload();
                            }
                        });
                    }
                });
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
     <script>
        function updateEndDate() {
            var duration = document.getElementById('filterdate').value;
            var startDate = '';
            var startDateArray = duration.split('- ');
            if (startDateArray.length > 0) {
                startDate = startDateArray[0];
            }
            document.querySelector('input[name="select_date"]').value = startDate;
        }
    </script>
    <script>
        function companyExcel() {
            var user1 = document.getElementById('company').value;
            console.log(user1);

            document.querySelector('input[name="select_company"]').value = user1;
        }
    </script>
    <script>
        function rateExcel() {
            var user2 = document.getElementById('rate').value;
            console.log(user2);

            document.querySelector('input[name="select_rate"]').value = user2;
        }
    </script>
    <script>
        function dateExcel() {
            var weekly = document.getElementById('weekly').value;
            var month = document.getElementById('month').value;

            if (weekly !== "" && month !== "") {
                // Lanjutkan proses jika kedua elemen memiliki nilai
                console.log('Weekly: ' + weekly + ', Month: ' + month);
                // Lakukan hal lain yang diperlukan, seperti submit form atau panggil fungsi lainnya
            } else {
                alert('Please select both Weekly and Month options.');
            }
            document.querySelector('input[name="select_date"]').value = weekly;
        }
    </script>
    <script>
        function monthExcel() {
            dateExcel();
            var user4 = document.getElementById('month').value;
            console.log(user4);

            document.querySelector('input[name="select_month"]').value = user4;
        }
    </script>
@endpush
