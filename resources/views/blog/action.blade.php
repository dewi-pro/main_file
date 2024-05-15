@can('edit-blog')
    <a class="btn btn-sm small btn btn-primary" href="blogs/{{ $blog->id }}/edit" data-bs-toggle="tooltip"
        data-bs-placement="bottom" data-bs-original-title="{{ __('Edit') }}"><i class="ti ti-edit text-white"></i>
    </a>
@endcan
@can('delete-blog')
    {!! Form::open([
        'method' => 'DELETE',
        'class' => 'd-inline',
        'route' => ['blogs.destroy', $blog->id],
        'id' => 'delete-form-' . $blog->id,
    ]) !!}
    <a href="#" class="btn btn-sm small btn btn-danger show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        id="delete-form-1" data-bs-original-title="{{ __('Delete') }}"><i class="ti ti-trash text-white"></i>
    </a>
    {!! Form::close() !!}
@endcan
