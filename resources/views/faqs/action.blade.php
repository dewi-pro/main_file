<span>
    @can('edit-faqs')
        <a class="btn btn-primary btn-sm" href="faqs/{{ $faqs->id }}/edit"
            data-url="faqs/{{ $faqs->id }}/edit" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="{{ __('Edit') }}"><i class="ti ti-edit"></i></a>
    @endcan
    @can('delete-faqs')
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['faqs.destroy', $faqs->id],
            'id' => 'delete-form-' . $faqs->id,
            'class' => 'd-inline',
        ]) !!}
        <a href="#" class="btn btn-danger btn-sm show_confirm" id="delete-form-{{ $faqs->id }}"
            data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('Delete') }}"><i
                class="ti ti-trash mr-0"></i></a>
        {!! Form::close() !!}
    @endcan
</span>
