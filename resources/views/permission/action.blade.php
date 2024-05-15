@can('edit-permission')
    <a class="btn btn-primary btn-sm edit-permission" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="bottom"
        title="" data-bs-original-title="{{ __('Edit') }}" id="edit-permission"
        data-action="permission/{{ $permission->id }}/edit"><i class="ti ti-edit"></i></a>
@endcan
@can('delete-permission')
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['permission.destroy', $permission->id],
        'id' => 'delete-form-' . $permission->id,
        'class' => 'd-inline',
    ]) !!}
    <a href="#" class="btn btn-danger btn-sm show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
    data-bs-original-title="{{ __('Delete') }}" id="delete-form-{{ $permission->id }}"><i
            class="ti ti-trash"></i></a>
    {!! Form::close() !!}
@endcan
