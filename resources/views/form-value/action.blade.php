@if (Auth::user()->type == 'Admin')
    @if ($formValue->form_edit_lock_status == 1)
        <a href="{{ route('form.fill.edit.lock', $formValue->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="{{ __('Unlock') }}" title="{{ __('Unlock Edit') }}" class="btn btn-danger btn-sm"
            data-toggle="tooltip"><i class="ti ti-lock"></i> </a>
    @else
        <a href="{{ route('form.fill.edit.lock', $formValue->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="{{ __('Lock') }}" title="{{ __('Lock Edit') }}" class="btn btn-success btn-sm"
            data-toggle="tooltip"><i class="ti ti-lock-open"></i> </a>
    @endif
@endif
@can('download-submitted-form')
    <a href="{{ route('download.form.values.pdf', $formValue->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ __('Download') }}" class="btn btn-success btn-sm" data-toggle="tooltip"><i
            class="ti ti-file-download"></i></a>
@endcan
@can('show-submitted-form')
    <a href="{{ route('form-values.show', $formValue->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ __('Show') }}" title="{{ __('View Survey') }}" class="btn btn-info btn-sm"
        data-toggle="tooltip"><i class="ti ti-eye"></i></a>
@endcan
@can('edit-submitted-form')
    @if (Auth::user()->type == 'Admin')
        <a href="{{ route('form-values.edit', $formValue->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="{{ __('Edit') }}" title="{{ __('Edit Survey') }}" class="btn btn-primary btn-sm"
            data-toggle="tooltip"><i class="ti ti-edit"></i> </a>
    @elseif ($formValue->form_edit_lock_status == 0 && Auth::user()->type != 'Admin')
        <a href="{{ route('form-values.edit', $formValue->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="{{ __('Edit') }}" title="{{ __('Edit Survey') }}" class="btn btn-primary btn-sm"
            data-toggle="tooltip"><i class="ti ti-edit"></i> </a>
    @endif
@endcan
@can('change-status-form-status')
        <!-- <a class="btn btn-info btn-sm cust_btn text-white" data-share="{{ route('form-value.status.change', $formValue->id) }}"
            data-bs-toggle="tooltip" data-bs-placement="bottom" id="change-form-status"
            data-bs-original-title="{{ __('Change Status') }}"><i class="ti ti-switch-2"></i></a> -->
@endcan
@can('delete-submitted-form')
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['form-values.destroy', $formValue->id],
        'id' => 'delete-form-' . $formValue->id,
        'class' => 'd-inline',
    ]) !!}
    <a href="#" class="btn btn-danger btn-sm show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ __('Delete') }}" id="delete-form-{{ $formValue->id }}"><i class="ti ti-trash"></i></a>
    {!! Form::close() !!}
@endcan
