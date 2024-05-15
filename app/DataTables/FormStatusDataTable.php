<?php

namespace App\DataTables;

use App\Facades\UtilityFacades;
use App\Models\FormStatus;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FormStatusDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (FormStatus $status) {
                return view('form-status.action', compact('status'));
            })
            ->editColumn('created_at', function ($request) {
                return UtilityFacades::date_time_format($request->created_at);
            })
            ->editColumn('status', function (FormStatus $status) {
                $checked = ($status->status == 1) ? 'checked' : '';

                if ($status->status == 1) {
                    $status =  '<label class="form-switch">
                         <input class="form-check-input chnageStatus" name="custom-switch-checkbox" ' . $checked . ' data-url="' . route('form-status.status', $status->id) . '" type="checkbox">
                         </label>';
                } else {
                    $status =  '<label class="form-switch">
                    <input class="form-check-input chnageStatus" name="custom-switch-checkbox" ' . $checked . ' data-url="' . route('form-status.status', $status->id) . '" type="checkbox">
                    </label>';
                }
                return $status;
            })
            ->rawColumns(['action' , 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\FormStatus $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FormStatus $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        $dataTable =  $this->builder()
            ->setTableId('blogcategory-table')
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

        $canCreateStatus = \Auth::user()->can('create-form-status');

        $buttonsConfig = [];

        if ($canCreateStatus) {
            $buttonsConfig[] =  [
                'extend' => 'create',
                'className' => 'btn btn-light-primary no-corner me-1 add_module  form-status',
                'action' => "function ( e, dt, node, config ) {}",
            ];
        }

        $exportButtonConfig = [];


        $exportButtonConfig = [
            'extend' => 'collection',
            'className' => 'btn btn-light-secondary me-1 dropdown-toggle',
            'text' => '<i class="ti ti-download"></i> ' . __('Export'),
            "buttons" => [
                [
                    "extend" => "print",
                    "text" => '<i class="fas fa-print"></i> ' . __('Print'),
                    "className" => "btn btn-light text-primary dropdown-item",
                    "exportOptions" => ["columns" => [0, 1, 3]]
                ], [
                    "extend" => "csv",
                    "text" => '<i class="fas fa-file-csv"></i> ' . __('CSV'),
                    "className" => "btn btn-light text-primary dropdown-item",
                    "exportOptions" => ["columns" => [0, 1, 3]]
                ], [
                    "extend" => "excel",
                    "text" => '<i class="fas fa-file-excel"></i> ' . __('Excel'),
                    "className" => "btn btn-light text-primary dropdown-item",
                    "exportOptions" => ["columns" => [0, 1, 3]]
                ],
                //["extend" => "pdf", "text" => '<i class="fas fa-file-pdf"></i> ' . __('PDF'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                [
                    "extend" => "copy",
                    "text" => '<i class="fas fa-copy"></i> ' . __('Copy'),
                    "className" => "btn btn-light text-primary dropdown-item",
                    "exportOptions" => ["columns" => [0, 1, 3]]
                ],
            ]
        ];


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
                }',
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

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('No')->title(__('No'))->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('name'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center '),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'FormStatus_' . date('YmdHis');
    }
}
