@can('edit-form-category')
    <a class="btn btn-sm small btn btn-primary" href="javascript:void(0);"
    data-url="{{ route('form-category.edit', $category->id) }}" id="edit-form-category"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('Edit') }}">
        <i class="ti ti-edit text-white"></i>
    </a>
@endcan
@can('delete-form-category')
    {!! Form::open([
        'method' => 'DELETE',
        'class' => 'd-inline',
        'route' => ['form-category.destroy', $category->id],
        'id' => 'delete-form-' . $category->id,
    ]) !!}
    <a href="#" class="btn btn-sm small btn btn-danger show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        id="delete-form-1" data-bs-original-title="{{ __('Delete') }}">
        <i class="ti ti-trash text-white"></i>
    </a>
    {!! Form::close() !!}
@endcan
