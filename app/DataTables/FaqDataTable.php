<?php

namespace App\DataTables;

use App\Facades\UtilityFacades;
use App\Models\Faq;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FaqDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return UtilityFacades::date_time_format($request->created_at);
            })
            ->addColumn('action', function (Faq $faqs) {
                return view('faqs.action', compact('faqs'));
            })
            ->rawColumns(['action']);
    }

    public function query(Faq $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('order');
    }

    public function html()
    {
        $dataTable =  $this->builder()
            ->setTableId('faq-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->language([
                "paginate" => [
                    "next" => '<i class="ti ti-chevron-right"></i>',
                    "previous" => '<i class="ti ti-chevron-left"></i>'
                ],
                'lengthMenu' => __("_MENU_").__('Entries Per Page'),
                "searchPlaceholder" => __('Search...'), "search" => "",
                "info" => __('Showing _START_ to _END_ of _TOTAL_ entries')

            ]) ->initComplete('function() {
                var table = this;
                var searchInput = $(\'#\'+table.api().table().container().id+\' label input[type="search"]\');
                searchInput.removeClass(\'form-control form-control-sm\');
                searchInput.addClass(\'dataTable-input\');
                var select = $(table.api().table().container()).find(".dataTables_length select").removeClass(\'custom-select custom-select-sm form-control form-control-sm\').addClass(\'dataTable-selector\');
            }');

            $canCreateFaq = \Auth::user()->can('create-faqs');
            $canExportFaq = \Auth::user()->can('export-faqs');

            $buttonsConfig = [];
            if($canCreateFaq){
                $buttonsConfig[] =  [
                    'extend' => 'create',
                    'className' => 'btn btn-light-primary no-corner me-1 add_module',
                    'action' => "function ( e, dt, node, config ) { window.location = '" . route('faqs.create') . "' }",
                ];
            }

            $exportButtonConfig = [];

            if($canExportFaq){
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
            Column::make('No')->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('questions')->title(__('Questions')),
            Column::make('order')->title(__('Order')),
            Column::make('created_at')->title(__('Created At')),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-end')
                ->width('20%'),
        ];
    }

    protected function filename(): string
    {
        return 'Faq_' . date('YmdHis');
    }
}
