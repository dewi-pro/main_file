@can('edit-mailtemplate')
    <a href="{{ route('mailtemplate.edit', $mailtemple->id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('Edit') }}"><i
            class="ti ti-edit"></i> </a>
@endcan

