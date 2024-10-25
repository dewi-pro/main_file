<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Facades\UtilityFacades;
use App\Models\Form;
use App\Models\FormStatus;
use App\Models\FormValue;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Carbon\Carbon;

class ResultDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('status', function (Form $form) {
                $st = '';
                if ($form->is_active == 1) {
                    $st = '<div class="form-check form-switch">
                            <input class="form-check-input chnageStatus" checked type="checkbox" role="switch" id="' . $form->id . '" data-url="' . route('form.status', $form->id) . '">
                            </div>';
                } else {
                    $st = '<div class="form-check form-switch">
                            <input class="form-check-input chnageStatus" type="checkbox" role="switch" id="' . $form->id . '" data-url="' . route('form.status', $form->id) . '">
                        </div>';
                }
                return $st;
            })
            ->addColumn('action', function (Form $form) {
                $hashids = new Hashids();
                $formValue = FormValue::where('form_id', $form->id)->count();
                return view('event.action', compact('form', 'hashids', 'formValue'));
            })
            ->editColumn('created_at', function (Form $form) {
                $endDate = new Carbon($form->end_tour);
                return $endDate->format('d/m/Y');
            })
            ->rawColumns(['status', 'location', 'action', 'form_status']);
    }
    public function query(Form $model, Request $request)
    {
        $usr = \Auth::user();
        $role_id = $usr->roles->first()->id;
        $user_id = $usr->id;
        if (\Auth::user()->type == 'Admin') {
            $form =   $model->newQuery()
            ->select('forms.*', 'form_categories.name as category_name')
            ->leftJoin('form_categories', 'form_categories.id', '=', 'forms.category_id')
                ->where('type', '=', 'Tour')
                ->orderBy('forms.created_at', 'asc');

            if ($request->query->get('view') && $request->query->get('view') == 'trash') {
                $form =   $model->newQuery()
                    ->select('forms.*', 'form_categories.name as category_name')
                    ->leftJoin('form_categories', 'form_categories.id', '=', 'forms.category_id')
                    ->where('type', '=', 'Tour')
                    ->orderBy('forms.created_at', 'asc')
                    ->onlyTrashed();
            }
        } else {
            if (\Auth::user()->can('access-all-form')) {
                $form = $model->newQuery()
                    ->select('forms.*', 'form_categories.name as category_name')
                    ->leftJoin('form_categories', 'form_categories.id', '=', 'forms.category_id')
                    ->where('type', '=', 'Tour')
                    ->where('forms.created_by', Auth::user()->id)
                    // ->orWhere('forms.created_by', Auth::user()->created_by)
                    ->orderBy('forms.created_at', 'asc');


                if ($request->query->get('view') && $request->query->get('view') == 'trash') {
                    $form = $model->newQuery()
                        ->select('forms.*', 'form_categories.name as category_name')
                        ->leftJoin('form_categories', 'form_categories.id', '=', 'forms.category_id')
                        ->where('type', '=', 'Tour')
                        ->where('forms.created_by', Auth::user()->id)
                        ->orderBy('forms.created_at', 'asc')
                        ->onlyTrashed();
                }
            } else {
                $form = $model->newQuery()
                    ->select('forms.*', 'form_categories.name AS category_name')
                    ->leftJoin('form_categories', 'form_categories.id', '=', 'forms.category_id')
                    ->where('type', '=', 'Tour')
                    ->where('forms.created_by', Auth::user()->id)
                    // ->where(function ($query)   use ($role_id, $user_id) {
                    //     $query->whereIn('forms.id', function ($query) use ($role_id) {
                    //         $query->select('form_id')->from('assign_forms_roles')->where('role_id', $role_id);
                    //     })->orWhereIn('forms.id', function ($query) use ($user_id) {
                    //         $query->select('form_id')->from('assign_forms_users')->where('user_id', $user_id);
                    //     })->orWhere('forms.assign_type', 'public');
                    // })
                    ->orderBy('forms.created_at', 'asc');

                if ($request->query->get('view') && $request->query->get('view') == 'trash') {
                    $form = $model->newQuery()
                        ->select('forms.*', 'form_categories.name AS category_name')
                        ->leftJoin('form_categories', 'form_categories.id', '=', 'forms.category_id')
                        ->where('type', '=', 'Tour')
                        ->where('forms.created_by', Auth::user()->id)
                        // ->where(function ($query)   use ($role_id, $user_id) {
                        //     $query->whereIn('forms.id', function ($query) use ($role_id) {
                        //         $query->select('form_id')->from('assign_forms_roles')->where('role_id', $role_id);
                        //     })->orWhereIn('forms.id', function ($query) use ($user_id) {
                        //         $query->select('form_id')->from('assign_forms_users')->where('user_id', $user_id);
                        //     })->orWhere('forms.assign_type', 'public');
                        // })
                        ->orderBy('forms.created_at', 'asc')
                        ->onlyTrashed();
                }
            }
        }

        if ($request->start_date && $request->end_date) {
            $form->whereBetween('forms.end_tour', [$request->start_date, $request->end_date]);
        }
        if ($request->category) {
            $form->where('forms.category_id', $request->category);
        }
        if ($request->cluster) {
            $form->where('forms.cluster_id', $request->cluster);
        }
        if ($request->leader) {
            $form->where('forms.leader_id', $request->leader);
        }
        if ($request->role) {
            $form->Join('assign_forms_roles', 'forms.id', '=', 'assign_forms_roles.form_id')
                ->where('assign_forms_roles.role_id', $request->role);
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

                    var category = $(".category").val();
                    d.category = category;

                    var cluster = $(".cluster").val();
                    d.cluster = cluster;

                    var leader = $(".leader").val();
                    d.leader = leader;

                    var roles = $(".roles").val();
                    d.role = roles;
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
                    $(".category").val("");
                    $(".cluster").val("");
                    $(".leader").val("");
                    $(".roles").val("").trigger("change");
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

            // Column::make('id')->title('<div><input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" name="checkbox-all" class="form-check-input dt-checkboxes-cell dt-checkboxes-select-all p-2"></div>')->exportable(false)->printable(false)->searchable(false)->orderable(false),
            Column::make('No')->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('title')->title(__('Title')),
            // Column::make('form_status')->title(__('Form Status')),
            Column::make('category')->title(__('Category')),
            Column::make('destination')->title(__('Destination')),
            Column::make('tour_leader_name')->title(__('Tour Leader')),
            Column::make('created_at')->title(__('End Tour')),
            Column::computed('action')->title(__('Action'))
                ->addClass('text-end d-flex justify-content-end gap-1'),
        ];
    }

    protected function filename(): string
    {
        return 'Forms_' . date('YmdHis');
    }
}
