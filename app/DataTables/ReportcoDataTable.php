<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Facades\UtilityFacades;
use App\Models\formValuesReportcos;
use App\Models\FormStatus;
use App\Models\FormValue;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;

class ReportcoDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (formValuesReportcos $form) {
                $hashids = new Hashids();
                $formValue = FormValue::where('form_id', $form->form_id)->count();
                return view('event.action', compact('form', 'hashids', 'formValue'));
            })
            ->editColumn('created_at', function (formValuesReportcos $form) {
                return UtilityFacades::date_time_format($form->created_at->format('Y-m-d h:i:s'));
            })
            ->rawColumns([ 'action']);
    }
    public function query(formValuesReportcos $model, Request $request)
    {
        $usr = \Auth::user();
        $role_id = $usr->roles->first()->id;
        $user_id = $usr->id;
        if (\Auth::user()->type == 'Admin') {
            $form =   $model->newQuery()
                ->orderBy('form_values_reportcos.created_at', 'asc');
        } else {
            if (\Auth::user()->can('access-all-form')) {
                $form = $model->newQuery()
                        ->orderBy('form_values_reportcos.created_at', 'asc');

                if ($request->query->get('view') && $request->query->get('view') == 'trash') {
                    $form = $model->newQuery()
                        ->orderBy('form_values_reportcos.created_at', 'asc');
                }
            } else {
                $form = $model->newQuery()
                    ->orderBy('form_values_reportcos.created_at', 'asc');

            }
        }
        if ($request->start_date && $request->end_date) {
            $form->whereBetween('form_values_reportcos.created_at', [$request->start_date, $request->end_date]);
        }
        if ($request->company) {
            $form->where('form_values_reportcos.company_name', $request->company);
        }
        if ($request->rate) {
            $form->where('form_values_reportcos.rate_label', $request->rate);
        }
        return $form;
    }

    public function html()
    {
        $dataTable =  $this->builder()
            ->setTableId('forms-table')
            ->columns($this->getColumns())
            ->ajax([
                'data' => 'function(d) {
                    var filter = $("#filterdate").val();
                    var spilit = filter.split(" to ");
                    d.start_date = spilit[0];
                    d.end_date = spilit[1];

                    var company = $(".company").val();
                    d.company = company;

                    var rate = $(".rate").val();
                    d.rate = rate;
                }',
            ])
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
                $("body").on("click", "#applyfilter", function() {

                    if ($(".created_at").val() && !$(".created_at").val().includes("to")) {
                        showToStr("Error!", "Please select both start and end dates.", "danger");
                        return;
                    }

                    $("#forms-table").DataTable().draw();
                });

                $("body").on("click", "#clearfilter", function() {
                    $(".created_at").val("");
                    $(".company").val("");
                    $(".rate").val("");
                    $("#forms-table").DataTable().draw();
                });

                var searchInput = $(\'#\'+table.api().table().container().id+\' label input[type="search"]\');
                searchInput.removeClass(\'form-control form-control-sm\');
                searchInput.addClass(\'dataTable-input\');
                var select = $(table.api().table().container()).find(".dataTables_length select").removeClass(\'custom-select custom-select-sm form-control form-control-sm\').addClass(\'dataTable-selector\');
            }');



        $canCreateForm = \Auth::user()->can('create-form');
        $canExportForm = \Auth::user()->can('export-form');
        $canExportSubmittedForm = \Auth::user()->can('export-submitted-form');

        $buttonsConfig = [];

        // if ($canCreateForm && request()->query->get('view') !== 'trash' )  {
        //     $buttonsConfig[] =  [
        //         'extend' => 'create',
        //         'className' => 'btn btn-light-primary no-corner me-1 add_module',
        //         'action' => "function ( e, dt, node, config ) { window.location = '" . route('forms.add') . "'; }",
        //     ];
        // }

        $exportButtonConfig = [];

        // if ($canExportForm) {
        //     $exportButtonConfig = [
        //         'extend' => 'collection',
        //         'className' => 'btn btn-light-secondary me-1 dropdown-toggle',
        //         'text' => '<i class="ti ti-download"></i> ' . __('Export'),
        //         "buttons" => [
        //             [
        //                 "extend" => "print",
        //                 "text" => '<i class="fas fa-print"></i> ' . __('Print'),
        //                 "className" => "btn btn-light text-primary dropdown-item",
        //                 "exportOptions" => ["columns" => [0, 1, 3]]
        //             ], [
        //                 "extend" => "csv",
        //                 "text" => '<i class="fas fa-file-csv"></i> ' . __('CSV'),
        //                 "className" => "btn btn-light text-primary dropdown-item",
        //                 "exportOptions" => ["columns" => [0, 1, 3]]
        //             ], [
        //                 "extend" => "excel",
        //                 "text" => '<i class="fas fa-file-excel"></i> ' . __('Excel'),
        //                 "className" => "btn btn-light text-primary dropdown-item",
        //                 "exportOptions" => ["columns" => [0, 1, 3]]
        //             ],
        //             //["extend" => "pdf", "text" => '<i class="fas fa-file-pdf"></i> ' . __('PDF'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
        //             [
        //                 "extend" => "copy",
        //                 "text" => '<i class="fas fa-copy"></i> ' . __('Copy'),
        //                 "className" => "btn btn-light text-primary dropdown-item",
        //                 "exportOptions" => ["columns" => [0, 1, 3]]
        //             ],
        //         ]
        //     ];
        // }

        $buttonsConfig = array_merge($buttonsConfig, [
            $exportButtonConfig,
            // [
            //     'extend' => 'reset',
            //     'className' => 'btn btn-light-danger me-1',
            // ],
            // [
            //     'extend' => 'reload',
            //     'className' => 'btn btn-light-warning',
            // ],
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
            // 'columnDefs' => [
            //     [
            //         'targets' => 0,
            //         'render' => 'function(data, type, row, meta){
            //                 data = \'<div><input type="checkbox" data-checkboxes="mygroup" class="form-check-input selected-checkbox dt-checkboxes" id="checkbox-\'+row.id+\'" data-id="\'+row.id+\'" autocomplete="off"></div>\';
            //                   return data;
            //                }',
            //         'checkboxes' => [
            //             'selectAllRender' => '<div><input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" name="checkbox-all" class="form-check-input dt-checkboxes-cell dt-checkboxes-select-all"></div>'
            //         ]
            //     ],
            //     [
            //         'targets' => 2,
            //         'printable' => false,
            //     ]
            // ],
            'select' => 'multi',
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

            // Column::make('id')->title('<div></div>')->exportable(false)->printable(false)->searchable(false)->orderable(false),
            Column::make('No')->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('company_name')->title(__('Company')),
            Column::make('full_name')->title(__('Name')),
            Column::make('rate_label')->title(__('Rate Service'))->className('custom-width-comment text-left')->width('250px'),
            Column::make('tour_consultant')->title(__('Tour Consultant')),
            Column::make('created_at')->title(__('Date Submitted')),
            // Column::computed('action')->title(__('Action'))
            //     ->addClass('text-end d-flex justify-content-end gap-1'),
        ];
    }

    protected function filename(): string
    {
        return 'Forms_' . date('YmdHis');
    }
}
