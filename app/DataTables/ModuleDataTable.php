<?php

namespace App\DataTables;

use App\Models\Module;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ModuleDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (module $module) {
                return view('module.action', compact('module'));
            })
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('d-m-Y');
            })
            ->rawColumns(['created_at']);
    }

    public function query(Module $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        $dataTable = $this->builder()
            ->setTableId('index-table')
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

        $canCreateModule = \Auth::user()->can('create-module');
        $canExportModule = \Auth::user()->can('export-module');
        $buttonsConfig = [];


        if ($canCreateModule) {
            $buttonsConfig[] = [
                'extend' => 'create',
                'className' => 'btn btn-light-primary no-corner me-1 add_module',
                'action' => " function (e, dt, node, config) { window.location = '" . route('module.create') . "'; }",
            ];
        }
        $exportButtonConfig = [];

        if ($canExportModule) {
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

    protected function getColumns()
    {
        return [
            Column::make('No')->title(__('No'))->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('name')->title(__('Name')),
            Column::make('created_at')->title(__('Created At')),
            Column::computed('action')->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-end'),

        ];
    }

    protected function filename(): string
    {
        return 'Module_' . date('YmdHis');
    }
}
