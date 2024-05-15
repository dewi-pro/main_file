@can('edit-testimonial')
<a class="btn btn-primary btn-sm" href="{{ route('testimonial.edit', $row->id) }}"
    data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="{{ __('Edit') }}"
    aria-label="{{ __('Edit') }}"><i class="ti ti-edit"></i></a>
@endcan

@can('delete-testimonial')
{!! Form::open([
    'method' => 'DELETE',
    'class' => 'd-inline',
    'route' => ['testimonial.destroy', $row->id],
    'id' => 'delete-form-' . $row->id,
]) !!}
<a href="#" class="btn btn-danger btn-sm show_confirm" data-bs-toggle="tooltip"
    data-bs-placement="bottom" title="" id="delete-form-1" data-bs-original-title="{{ __('Delete') }}"
    aria-label="{{ __('Delete') }}"><i class="ti ti-trash"></i></a>
{!! Form::close() !!}
@endcan

