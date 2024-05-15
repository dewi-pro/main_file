@can('edit-dashboardwidget')
    <a class="btn btn-primary  btn-sm" href="javascript:void(0);" id="edit-dashboard"
        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('Edit') }}"
        data-url="edit-dashboard/{{ $dashboard->id }}/edit"><i class="ti ti-edit"></i></a>
@endcan
@can('delete-dashboardwidget')
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['delete.dashboard', $dashboard->id],
        'id' => 'delete-form-' . $dashboard->id,
        'class' => 'd-inline',
    ]) !!}
    <a href="#" class="btn btn-danger btn-sm  show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ __('Delete') }}" id="delete-form-{{ $dashboard->id }}"><i
            class="ti ti-trash mr-0"></i></a>
    {!! Form::close() !!}
@endcan
