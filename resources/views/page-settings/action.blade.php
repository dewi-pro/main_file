@can('edit-page-setting')
    <a class="btn btn-sm small btn btn-primary" href="{{ route('page-setting.edit', $row->id) }}" data-bs-toggle="tooltip"
        data-bs-placement="bottom" data-bs-original-title="{{ __('Edit') }}">
        <i class="ti ti-edit text-white"></i>
    </a>
@endcan
@can('delete-page-setting')
    {!! Form::open([
        'method' => 'DELETE',
        'class' => 'd-inline',
        'route' => ['page-setting.destroy', $row->id],
        'id' => 'delete-form-' . $row->id,
    ]) !!}
    <a href="javascript:void(0);" class="btn btn-sm small btn btn-danger show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        id="delete-form-1" data-bs-original-title="{{ __('Delete') }}">
        <i class="ti ti-trash text-white"></i>
    </a>
    {!! Form::close() !!}
@endcan
