@can('edit-role')
    <a class="btn btn-info btn-sm" href="{{ route('roles.show', $role->id) }}" id="edit-role"
        data-url="roles/{{ $role->id }}/edit" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ __('Permissions') }}"><i class="ti ti-key"></i></a>
@endcan
@can('edit-role')
    <a class="btn btn-primary btn-sm edit-role" href="javascript:void(0);" id="edit-role"
        data-url="roles/{{ $role->id }}/edit" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ __('Permissions') }}"><i class="ti ti-edit"></i></a>
@endcan
@can('delete-role')
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['roles.destroy', $role->id],
        'id' => 'delete-form-' . $role->id,
        'class' => 'd-inline',
    ]) !!}
    <a href="#" class="btn btn-danger btn-sm show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ __('Delete') }}" id="delete-form-{{ $role->id }}"><i
            class="ti ti-trash"></i></a>
    {!! Form::close() !!}
@endcan
