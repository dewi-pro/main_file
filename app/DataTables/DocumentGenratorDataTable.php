<?php

namespace App\DataTables;

use App\Facades\UtilityFacades;
use App\Models\DocumentGenrator;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class DocumentGenratorDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return UtilityFacades::date_time_format($request->created_at);
            })
            ->editColumn('status', function (DocumentGenrator $document) {
                if ($document->status == 1) {
                    $st =  '<div class="form-check form-switch">
                   <input class="form-check-input chnageStatus" checked type="checkbox" role="switch" id="' . $document->id . '" data-url="' . route('document.status', $document->id) . '">
                   </div>';
                } else {
                    $st = '<div class="form-check form-switch">
                    <input class="form-check-input chnageStatus" type="checkbox" role="switch" id="' . $document->id . '" data-url="' . route('document.status', $document->id) . '">
                </div>';
                }
                return $st;
            })
            ->addColumn('action', function (DocumentGenrator $document) {

                return view('document.action', compact('document'));
            })
            ->rawColumns(['action', 'status', 'actions', 'created_at']);
    }

    public function query(DocumentGenrator $model): QueryBuilder
    {
        $user = Auth::user();
        if (Auth::user()->type == 'Admin') {
            return $model->newQuery();
        } else {
            return $model->newQuery()->where('created_by', Auth::user()->id)->orderBy('id', 'ASC');
        }
    }


    public function html()
    {
        $dataTable =  $this->builder()
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
        $canCreateDocument = \Auth::user()->can('create-document');
        $canExportDocument = \Auth::user()->can('export-document');

        $buttonsConfig = [];
        if($canCreateDocument){
            $buttonsConfig[] =  [
                'extend' => 'create',
                'className' => 'btn btn-light-primary no-corner me-1 add_dashboard',
                'action' => "function ( e, dt, node, config ) { window.location = '" . route('document.create') . "' }",
            ];
        }
        $exportButtonConfig = [];

        if($canExportDocument){
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
                    ],[
                        "extend" => "csv",
                        "text" => '<i class="fas fa-file-csv"></i> ' . __('CSV'),
                        "className" => "btn btn-light text-primary dropdown-item",
                        "exportOptions" => ["columns" => [0, 1, 3]]
                    ],[
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
                'buttons'   => $buttonsConfig,
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
            Column::make('title')->title(__('Title')),
            Column::make('status')->title(__('Status')),
            Column::make('slug')->title(__('Slug')),
            Column::make('created_at')->title(__('Created At')),
            Column::computed('action')->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-end'),
        ];
    }

    protected function filename(): string
    {
        return 'DocumentGenrator_' . date('YmdHis');
    }
}
