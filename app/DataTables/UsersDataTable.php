<?php

namespace App\DataTables;

use App\Facades\UtilityFacades;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return UtilityFacades::date_time_format($request->created_at);
            })
            ->editColumn('active_status', function (User $user) {
                if ($user->active_status == 1) {
                    return '<div class="form-check form-switch">
                                            <input class="form-check-input chnageStatus" checked type="checkbox" role="switch" id="' . $user->id . '" data-url="' . route('users.status', $user->id) . '">
                                        </div>';
                } else {
                    return '<div class="form-check form-switch">
                                             <input class="form-check-input chnageStatus" type="checkbox" role="switch" id="' . $user->id . '" data-url="' . route('users.status', $user->id) . '">
                                        </div>';
                }
            })
            ->addColumn('role', function (User $user) {
                $out = '';
                $out = '<span class="p-2 px-3 badge rounded-pill bg-primary">' . $user->type . '</span>';
                return $out;
            })
            ->addColumn('email_verified_at', function (User $user) {
                if ($user->email_verified_at) {
                    $out = '<span class="p-2 px-3 badge rounded-pill bg-info">' . __('Verified') . '</span>';
                    return $out;
                } else {
                    $out = '<span class="p-2 px-3 badge rounded-pill bg-warning">' . __('Unverified') . '</span>';
                    return $out;
                }
            })
            ->addColumn('phone_verified_at', function (User $user) {
                if ($user->phone_verified_at) {
                    $out = '<span class="p-2 px-3 badge rounded-pill bg-info">' . __('Verified') . '</span>';
                    return $out;
                } else {
                    $out = '<span class="p-2 px-3 badge rounded-pill bg-warning">' . __('Unverified') . '</span>';
                    return $out;
                }
            })
            ->addColumn('action', function (User $user) {
                return view('users.action', compact('user'));
            })
            ->rawColumns(['role', 'email_verified_at', 'action', 'active_status', 'phone_verified_at']);
    }

    public function query(User $model): QueryBuilder
    {

        if (Auth::user()->type == 'Admin') {

            return $model->newQuery()->where('type', '!=', 'Admin')->orderBy('id', 'ASC');
        }
        else{
            return $model->newQuery()->where('created_by', Auth::user()->id)->whereNot('type','Admin')->orderBy('id', 'ASC');
        }


    }

    public function html(): HtmlBuilder
    {
        $dataTable = $this->builder()
        ->setTableId('users-table')
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->orderBy(1)
        ->language([
            "paginate" => [
                "next" => '<i class="ti ti-chevron-right"></i>',
                "previous" => '<i class="ti ti-chevron-left"></i>'
            ],
            'lengthMenu' => __("_MENU_") . __('Entries Per Page'),
            "searchPlaceholder" => __('Search...'),
            "search" => "",
            "info" => __('Showing _START_ to _END_ of _TOTAL_ entries')
        ])
        ->initComplete('function() {
    var table = this;
    var searchInput = $(\'#\'+table.api().table().container().id+\' label input[type="search"]\');
    searchInput.removeClass(\'form-control form-control-sm\');
    searchInput.addClass(\'dataTable-input\');
    var select = $(table.api().table().container()).find(".dataTables_length select").removeClass(\'custom-select custom-select-sm form-control form-control-sm\').addClass(\'dataTable-selector\');
}');

    $canCreateUser = \Auth::user()->can('create-user');
    $canExportUser = \Auth::user()->can('export-user');
    $buttonsConfig = [];


    if ($canCreateUser) {
        $buttonsConfig[] = [
            'extend' => 'create',
            'className' => 'btn btn-light-primary no-corner me-1 add-user',
            'action' => " function (e, dt, node, config) { }",
        ];
    }
    $exportButtonConfig = [];

    if ($canExportUser) {
        $exportButtonConfig = [
            'extend' => 'collection',
            'className' => 'btn btn-light-secondary me-1 dropdown-toggle',
            'text' => '<i class="ti ti-download"></i> ' . __('Export'),
            'buttons' => [
                [
                    'extend' => 'print',
                    'text' => '<i class="fas fa-print"></i> ' . __('Print'),
                    'className' => 'btn btn-light text-primary dropdown-item',
                    'exportOptions' => ['columns' => [0, 1, 3]],
                ],
                [
                    'extend' => 'csv',
                    'text' => '<i class="fas fa-file-csv"></i> ' . __('CSV'),
                    'className' => 'btn btn-light text-primary dropdown-item',
                    'exportOptions' => ['columns' => [0, 1, 3]],
                ],
                [
                    'extend' => 'excel',
                    'text' => '<i class="fas fa-file-excel"></i> ' . __('Excel'),
                    'className' => 'btn btn-light text-primary dropdown-item',
                    'exportOptions' => ['columns' => [0, 1, 3]],
                ],
            ],
        ];
    }


    $buttonsConfig = array_merge($buttonsConfig, [
        $exportButtonConfig,
        [
            'extend' => 'reset',
            'className' => 'btn btn-light-danger me-1',
        ],
        [
            'extend' => 'reload',
            'className' => 'btn btn-light-warning',
        ],
    ]);

    $dataTable->parameters([
        "dom" =>  "
    <'dataTable-top row'<'dataTable-dropdown page-dropdown col-lg-2 col-sm-12'l><'dataTable-botton table-btn col-lg-6 col-sm-12'B><'dataTable-search tb-search col-lg-3 col-sm-12'f>>
    <'dataTable-container'<'col-sm-12'tr>>
    <'dataTable-bottom row'<'col-sm-5'i><'col-sm-7'p>>
",
        'buttons' => $buttonsConfig,
        "drawCallback" => 'function( settings ) {
            var tooltipTriggerList = [].slice.call(
                document.querySelectorAll("[data-bs-toggle=tooltip]")
              );
              var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
              });
              var popoverTriggerList = [].slice.call(
                document.querySelectorAll("[data-bs-toggle=popover]")
              );
              var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
              });
              var toastElList = [].slice.call(document.querySelectorAll(".toast"));
              var toastList = toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl);
              });
        }'
    ]);

    $dataTable->language([
        'buttons' => [
            'create' => __('Create'),
            'export' => __('Export'),
            'print' => __('Print'),
            'reset' => __('Reset'),
            'reload' => __('Reload'),
            'excel' => __('Excel'),
            'csv' => __('CSV'),
        ]
    ]);

    return $dataTable;
    }

    protected function getColumns(): array
    {
        return [
            Column::make('No')->title(__('No'))->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('name')->title(__('Name')),
            Column::make('email')->title(__('Email')),
            Column::make('role')->title(__('Role')),
            Column::make('active_status')->title(__('Status')),
            Column::make('email_verified_at')->title(__('Email Verified At')),
            Column::make('phone_verified_at')->title(__('Phone Verified At')),
            Column::computed('action')->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-end'),
        ];
    }

    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
