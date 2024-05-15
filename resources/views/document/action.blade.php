@can('manage-document')
    @if ($document->document_menu && $document->status == 1)
        <a class="btn btn-success btn-sm copy_menu" onclick="copyToClipboard('#copy-menu-{{ $document->id }}')"
            href="javascript:void(0)" id="copy-menu-{{ $document->id }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="{{ __('Copy Document URL') }}"
            data-url="{{ route('document.public', $document->document_menu->slug) }}"><i class="ti ti-copy"></i></a>

        <a href="{{ route('document.public', $document->document_menu->slug) }}" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="{{ __('View Document') }}" target="_blank"
            class="btn btn-info mr-1 btn-sm" data-toggle="tooltip"><i class="ti ti-eye"></i></a>
    @endif
    @can('document-generate-document')
        <a class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="{{ __('Document Generate') }}" href="{{ route('document.design', $document->id) }}"
            id="edit-menu"><i class="ti ti-brush"></i></a>
    @endcan


    @can('edit-document')
        <a class="btn btn-sm btn-primary" href="{{ route('document.edit', $document->id) }}" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="{{ __('Edit') }}" aria-label="{{ __('Edit') }}"><i
                class="ti ti-edit text-white"></i></a>
    @endcan
    @can('delete-document')
        {!! Form::open([
            'method' => 'DELETE',
            'class' => 'd-inline',
            'route' => ['document.destroy', $document->id],
            'id' => 'delete-form-' . $document->id,
        ]) !!}
        <a href="javascript:void(0);" class="btn btn-sm btn btn-danger show_confirm" data-bs-toggle="tooltip"
            data-bs-placement="bottom" title="" id="delete-form-1" data-bs-original-title="{{ __('Delete') }}"
            aria-label="{{ __('Delete') }}"><i class="ti ti-trash text-white"></i></a>
        {!! Form::close() !!}
    @endcan
@endcan
