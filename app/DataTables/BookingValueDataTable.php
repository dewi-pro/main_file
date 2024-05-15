<?php

namespace App\DataTables;

use App\Facades\UtilityFacades;
use App\Models\Booking;
use App\Models\Form;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;
use App\Models\BookingValue;
use App\Models\User;
use Carbon\Carbon;

class BookingValueDataTable extends DataTable
{
    public function dataTable($query)
    {
        $data = datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('user', function (BookingValue $bookingvalue) {
                $tu = '';
                if ($bookingvalue->User) {
                    $tu = $bookingvalue->User->name;
                }
                return $tu;
            })
            ->editColumn('created_at', function (BookingValue $bookingvalue) {
                return UtilityFacades::date_time_format($bookingvalue->created_at);
            })
            ->editColumn('user', function (BookingValue $bookingvalue) {
                $username =  User::where('id', $bookingvalue->user_id)->first();
                $user = ($bookingvalue->user_id) ? $username->name : 'Guest';
                return $user;
            })
            ->addColumn('action', function (BookingValue $bookingvalue) {
                return view('booking-value.action', compact('bookingvalue'));
            });
        $labels = $this->labels();
        if ($labels != null) {
            foreach ($labels as $key => $label) {
                $data->editColumn($key, function (BookingValue $bookingvalue) use ($key) {
                    $jsonData = $bookingvalue->json;
                    $jsonArray = json_decode($jsonData, true);
                    $value = "-";
                    foreach ($jsonArray as $items) {
                        foreach ($items as $item) {
                            if (isset($item['show_datatable']) && $item['show_datatable']) {
                                if ($item['name'] === $key) {
                                    if ($item['type'] === 'starRating') {
                                        $value = '';
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($item['value'] < $i) {
                                                if (is_float($item['value']) && (round($item['value']) == $i)) {
                                                    $value .= '<i class="text-warning fas fa-star-half-alt"></i>';
                                                } else {
                                                    $value .= '<i class="fas fa-star"></i>';
                                                }
                                            } else {
                                                $value .= '<i class="text-warning fas fa-star"></i>';
                                            }
                                        }
                                    } elseif ($item['type'] === 'radio-group' || $item['type'] === 'select' || $item['type'] === 'checkbox-group') {
                                        $selectedValues = [];
                                        foreach ($item['values'] as $option) {
                                            if (isset($option['selected']) && $option['selected'] == 1) {
                                                $selectedValues[] = $option['label'];
                                            }
                                        }
                                        $value = implode(', ', $selectedValues);
                                    } elseif ($item['type'] === 'date') {
                                        $value = '';
                                        if ($item['value']) {
                                            $date = Carbon::createFromFormat('Y-m-d', $item['value']);
                                            $formattedDate = $date->format('jS M Y');
                                            $value = $formattedDate;
                                        }
                                    } else {
                                        $value = $item['value'];
                                    }
                                }
                            }
                        }
                    }
                    return $value;
                });
            }
            $arr = array_merge(['user', 'type','action','created_at'], array_keys($labels));
        } else {
            $arr = array_merge(['user', 'type','action','created_at']);
        }
        $data->rawColumns($arr);
        return $data;
    }

    public function query(BookingValue $model, Request $request)
    {
        $usr = \Auth::user();
        $role_id = $usr->roles->first()->id;
        $user_id = $usr->id;
        if ($usr->type != 'Admin') {
            $bookingvalue =  $model->newQuery()
                ->select(['booking_values.*', 'bookings.business_name'])
                ->join('bookings', 'bookings.id', '=', 'booking_values.booking_id');

        } else {
            $bookingvalue = BookingValue::select(['booking_values.*', 'bookings.business_name'])
                ->join('bookings', 'bookings.id', '=', 'booking_values.booking_id')
                ->leftJoin('users', 'users.id', 'booking_values.user_id');
        }
        if ($request->start_date && $request->end_date) {
            $bookingvalue->whereBetween('booking_values.created_at', [$request->start_date, $request->end_date]);
        }
        if ($request->booking) {
            $bookingvalue->where('booking_values.booking_id', '=', $request->booking);
        }
        if ($request->user_name) {
            $bookingvalue = BookingValue::select(['booking_values.*', 'users.name as usr_name'])
                ->join('users', 'users.id', '=', 'booking_values.user_id');
            $bookingvalue->where('users.name', 'LIKE', '%' . $request->user_name . '%')->Where('booking_values.booking_id', '=', $request->booking);
        }

        return $bookingvalue;
    }

    public function labels()
    {
        $recordId = $this->booking_id;
        $bookingvalue = Booking::find($recordId);
        if ($bookingvalue->json != '') {
            $jsonData = $bookingvalue->json;
            $jsonArray = json_decode($jsonData, true);
            $filteredData = [];
            foreach ($jsonArray as $j_array) {
                foreach ($j_array as $item) {
                    if (isset($item['show_datatable']) && $item['show_datatable'] == true) {
                        $filteredData[$item['name']] =  $item['label'];
                    }
                }
            }
            $label = $filteredData;
            return $label;
        }
    }

    public function html()
    {
        $dataTable = $this->builder()
            ->setTableId('booking-table')
            ->addIndex()
            ->columns($this->getColumns($this->labels()))
            ->ajax([
                'data' => 'function(d) {
                            var filter = $(".created_at").val();
                            var spilit = filter.split("to");
                            d.booking = $("#booking_id").val();
                            d.start_date = spilit[0];
                            d.end_date = spilit[1];

                            var user_filter = $("input[name=user]").val();
                            d.user_name = user_filter;
                        }'
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
                $("body").on("click", ".add_filter", function() {
                    $("#booking-table").DataTable().draw();
                });
                $("body").on("click", ".clear_filter", function() {
                    $(".created_at").val("");
                    $("input[name=user]").val("");
                    $("#booking-table").DataTable().draw();
                });
                var searchInput = $(\'#\'+table.api().table().container().id+\' label input[type="search"]\');
                searchInput.removeClass(\'booking-control booking-control-sm\');
                searchInput.addClass(\'dataTable-input\');
                var select = $(table.api().table().container()).find(".dataTables_length select").removeClass(\'custom-select custom-select-sm form-control form-control-sm\').addClass(\'dataTable-selector\');
            }');
            $canExportSubmittedForm = \Auth::user()->can('export-submitted-booking');

            $exportButtonConfig = [];
            if ($canExportSubmittedForm) {
                $exportButtonConfig = [
                    'extend' => 'collection',
                    'className' => 'w-inherit btn btn-light-secondary me-1 dropdown-toggle',
                    'text' => '<i class="ti ti-download"></i> ' . __('Export'),
                    "buttons" => [
                        ["extend" => "print", "text" => '<i class="fas fa-print"></i> ' . __('Print'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                        ["extend" => "csv", "text" => '<i class="fas fa-file-csv"></i> ' . __('CSV'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                        ["extend" => "excel", "text" => '<i class="fas fa-file-excel"></i> ' . __('Excel'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
                        //["extend" => "pdf", "text" => '<i class="fas fa-file-pdf"></i> ' . __('PDF'), "className" => "btn btn-light text-primary dropdown-item", "exportOptions" => ["columns" => [0, 1, 3]]],
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
            <'dataTable-top row'<'dataTable-dropdown page-dropdown col-lg-2 col-sm-12'l><'dataTable-botton table-btn col-lg-6 col-sm-12'B>>
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


    protected function getColumns($label)
    {
        $columns = [
            Column::make('No')->title(__('No'))->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('user')->title(__('User')),
        ];
        if ($label != null) {
            foreach ($label as $key => $value) {
                $columns[] = Column::make($key)->title($value)->searchable(false)->orderable(false);
            }
        }
        $columns[] = Column::make('created_at')->title(__('Created At'));
        $columns[] = Column::computed('action')->title(__('Action'))
            ->exportable(false)
            ->printable(false)
            ->addClass('text-end');

        return $columns;
    }

    protected function filename(): string
    {
        return 'BookingValue_' . date('YmdHis');
    }
}
