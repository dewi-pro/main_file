@php
    $hashids = new Hashids('', 20);
    $id = $hashids->encodeHex($form->id);
    $view = request()->query->get('view');
@endphp

@if ($view == null)
    @can('edit-form')
        @if ($form->json)
            @if ($form->is_active)
                <!-- @can('theme-setting-form')
                    <a class="btn btn-secondary btn-sm" href="{{ route('form.theme', $form->id) }}" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" data-bs-original-title="{{ __('Theme Setting') }}"><i
                            class="ti ti-layout-2"></i></a>
                @endcan -->
                <!-- @can('payment-form')
                    <a class="btn btn-warning btn-sm" href="{{ route('form.payment.integration', $form->id) }}"
                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                        data-bs-original-title="{{ __('Payment Integration') }}"><i class="ti ti-report-money"></i></a>
                @endcan -->
                <!-- @can('integration-form')
                    <a class="btn btn-info btn-sm" href="{{ route('form.integration', $form->id) }}" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" data-bs-original-title="{{ __('Integration') }}"><i
                            class="ti ti-send"></i></a>
                @endcan -->
                <!-- @can('manage-form-rule')
                    <a class="btn btn-secondary btn-sm" href="{{ route('form.rules', $form->id) }}" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" data-bs-original-title="{{ __('Conditional Rules') }}"><i
                            class="ti ti-notebook"></i></a>
                @endcan -->
                <a class="btn btn-primary btn-sm embed_form " href="javascript:void(0)"
                    onclick="copyToClipboard('#embed-form-{{ $form->id }}')" id="embed-form-{{ $form->id }}"
                    data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('Embedded form') }}"
                    data-url='<iframe src="{{ route('forms.survey', $id) }}" scrolling="auto" align="bottom" height:100vh; width="100%></iframe>'><i
                        class="ti ti-code"></i></a>

                @if ($form->limit_status == 1)
                    @if ($form->limit > $formValue)
                        <a class="btn btn-success btn-sm copy_form "
                            onclick="copyToClipboard('#copy-form-{{ $form->id }}')" href="javascript:void(0)"
                            id="copy-form-{{ $form->id }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            data-bs-original-title="{{ __('Copy Form URL') }}"
                            data-url="{{ route('forms.survey', $id) }}"><i class="ti ti-copy"></i></a>
                    @endif
                @else
                    <a class="btn btn-success btn-sm copy_form "
                        onclick="copyToClipboard('#copy-form-{{ $form->id }}')" href="javascript:void(0)"
                        id="copy-form-{{ $form->id }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        data-bs-original-title="{{ __('Copy Form URL') }}" data-url="{{ route('forms.survey', $id) }}"><i
                            class="ti ti-copy"></i></a>
                @endif

                <!-- <a class="btn btn-info btn-sm cust_btn text-white" data-share="{{ route('forms.survey.qr', $id) }}"
                    id="share-qr-code" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    data-bs-original-title="{{ __('Show QR Code') }}"><i class="ti ti-qrcode"></i></a> -->
                <a class="btn btn-secondary btn-sm" href="{{ route('view.form.values', $form->id) }}"
                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                    data-bs-original-title="{{ __('View Submited forms') }}"><i class="ti ti-clipboard-check"></i></a>
            @endif
        @endif
    @endcan
    @can('fill-form')
        @if ($form->json)
            @if ($form->limit_status == 1)
                @if ($form->limit > $formValue)
                    <a class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        data-bs-original-title="{{ __('Fill Form') }}" href="{{ route('forms.fill', $form->id) }}"><i
                            class="ti ti-list"></i></a>
                @endif
            @else
                <a class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    data-bs-original-title="{{ __('Fill Form') }}" href="{{ route('forms.fill', $form->id) }}"><i
                        class="ti ti-list"></i></a>
            @endif
        @endif
    @endcan
    @can('duplicate-form')
        <a href="#" class="btn btn-warning btn-sm " data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="{{ __('Duplicate Form') }}"
            onclick="document.getElementById('duplicate-form-{{ $form->id }}').submit();"><i
                class="ti ti-squares-diagonal"></i></a>
    @endcan


    @can('design-form')
        <a class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="{{ __('Design Form') }}" href="{{ route('forms.design', $form->id) }}"><i
                class="ti ti-brush"></i></a>
    @endcan
    @can('edit-form')
        <a class="btn btn-primary btn-sm" href="{{ route('forms.edit', $form->id) }}" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="{{ __('Edit Form') }}" id="edit-form"><i
                class="ti ti-edit"></i></a>
    @endcan
    @can('delete-form')
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['forms.destroy', $form->id],
            'id' => 'delete-form-' . $form->id,
            'class' => 'd-inline',
        ]) !!}
        <a href="#" class="btn btn-danger btn-sm show_confirm_submited_form_delete" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="{{ __('Delete') }}"
            id="delete-form-{{ $form->id }}"><i class="mr-0 ti ti-trash"></i></a>
        {!! Form::close() !!}
    @endcan
    @can('duplicate-form')
        {!! Form::open(['method' => 'POST', 'route' => ['forms.duplicate'], 'id' => 'duplicate-form-' . $form->id]) !!}
        {!! Form::hidden('form_id', $form->id, []) !!}
        {!! Form::close() !!}
    @endcan
@endif

@if ($view !== null && $view == 'trash')
    <a class="btn btn-success btn-sm" href="{{ route('form.restore', $form->id) }}" data-bs-toggle="tooltip"
        data-bs-placement="bottom" data-bs-original-title="{{ __('Restore') }}"><i class="ti ti-recycle"></i></a>

    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['form.force.delete', $form->id],
        'id' => 'formforcedelete-' . $form->id,
        'class' => 'd-inline',
    ]) !!}
    <a href="#" class="btn btn-danger btn-sm show_confirm" id="formforcedelete-{{ $form->id }}"
        data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ __('Delete Pemanently') }}"><i class="mr-0 ti ti-trash"></i></a>
    {!! Form::close() !!}
@endif
