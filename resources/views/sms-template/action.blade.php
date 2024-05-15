@can('edit-sms-template')
<a class="btn btn-primary btn-sm" href="{{ route('sms-template.edit', $row->id) }}"
            data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="{{ __('Edit') }}" aria-label="{{ __('Edit') }}"><i
            class="ti ti-edit"></i></a>
@endcan
