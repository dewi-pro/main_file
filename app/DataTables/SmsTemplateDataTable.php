<?php

namespace App\DataTables;

use App\Facades\UtilityFacades;
use App\Models\SmsTemplate;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SmsTemplateDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('created_at', function (SmsTemplate $row) {
                return UtilityFacades::date_time_format($row->created_at);
            })
            ->addColumn('action', function (SmsTemplate $row) {
                return view('sms-template.action', compact('row'));
            })
            ->rawColumns(['action']);
    }

    public function query(SmsTemplate $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        $dataTable =  $this->builder()
            ->setTableId('mailtempledatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->language([
                "paginate" => [
                    "next" => '<i class="ti ti-chevron-right"></i>',
                    "previous" => '<i class="ti ti-chevron-left"></i>'
                ],
                'lengthMenu' => __("_MENU_") . __('Entries Per Page'),
                "searchPlaceholder" => __('Search...'), "search" => "",
                "info" => __('Showing _START_ to _END_ of _TOTAL_ entries')

            ])
            ->initComplete('function() {
            var table = this;
            var searchInput = $(\'#\'+table.api().table().container().id+\' label input[type="search"]\');
            searchInput.removeClass(\'form-control form-control-sm\');
            searchInput.addClass(\'dataTable-input\');
            var select = $(table.api().table().container()).find(".dataTables_length select").removeClass(\'custom-select custom-select-sm form-control form-control-sm\').addClass(\'dataTable-selector\');
        }');

        $canExportSmsTemplatePermission = \Auth::user()->can('export-sms-template');

        $exportButtonConfig = [];
        if ($canExportSmsTemplatePermission) {
            $exportButtonConfig = [
                'extend' => 'collection', 'className' => 'btn btn-light-secondary me-1 dropdown-toggle', 'text' => '<i class="ti ti-download"></i> ' . ('Export'), "buttons" => [
                    ["extend" => "print", "text" => '<i class="fas fa-print"></i> ' . ('Print'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                    ["extend" => "csv", "text" => '<i class="fas fa-file-csv"></i> ' . __('CSV'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                    ["extend" => "excel", "text" => '<i class="fas fa-file-excel"></i> ' . __('Excel'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                    // ["extend" => "pdf", "text" => '<i class="fas fa-file-pdf"></i> '.__('PDF'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                    ["extend" => "copy", "text" => '<i class="fas fa-copy"></i> ' . __('Copy'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                ],
            ];
        }
        $buttonsConfig = [
            $exportButtonConfig,
            ['extend' => 'reset', 'className' => 'w-inherit btn btn-light-danger me-1'],
            ['extend' => 'reload', 'className' => 'w-inherit btn btn-light-warning'],
        ];

        $dataTable->parameters([
            "dom" =>  "
            <'dataTable-top row'<'dataTable-dropdown page-dropdown col-lg-2 col-sm-12'l><'dataTable-botton table-btn col-lg-6 col-sm-12'B><'dataTable-search tb-search col-lg-3 col-sm-12'f>>
            <'dataTable-container'<'col-sm-12'tr>>
            <'dataTable-bottom row'<'col-sm-5'i><'col-sm-7'p>>
            ",
            'buttons' =>  $buttonsConfig,
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

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title(__('No'))->orderable(false)->searchable(false),
            Column::make('event')->title(__('Event')),
            Column::make('created_at')->title(__('Created At')),
            Column::computed('action')->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(100),
        ];
    }

    protected function filename(): string
    {
        return 'SmsTemplate_' . date('YmdHis');
    }
}
