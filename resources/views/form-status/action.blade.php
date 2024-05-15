@can('edit-form-status')
    <a class="btn btn-sm small btn btn-primary"  id="edit-form-status" href="javascript:void(0);"
    data-url="{{ route('form-status.edit', $status->id) }}"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('Edit') }}">
        <i class="ti ti-edit text-white"></i>
    </a>
@endcan
@can('delete-form-status')
    {!! Form::open([
        'method' => 'DELETE',
        'class' => 'd-inline',
        'route' => ['form-status.destroy', $status->id],
        'id' => 'delete-form-' . $status->id,
    ]) !!}
    <a href="#" class="btn btn-sm small btn btn-danger show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        id="delete-form-1" data-bs-original-title="{{ __('Delete') }}">
        <i class="ti ti-trash text-white"></i>
    </a>
    {!! Form::close() !!}
@endcan
