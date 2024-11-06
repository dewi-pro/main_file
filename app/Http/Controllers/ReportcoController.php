<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\GoogleCalendar\Event as GoogleEvent;
use App\DataTables\ReportcoDataTable;
use App\Models\FormCategory;
use App\Models\FormType;
use Spatie\Permission\Models\Role;
use App\Models\Form;
use App\Models\FormCluster;
use App\Models\FormLeader;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExportCO;
use App\Models\formValuesReportcos;

class ReportcoController extends Controller
{
    public static $colorCode = [
        1 => 'event-warning',
        2 => 'event-secondary',
        3 => 'event-info',
        4 => 'event-danger',
        5 => 'event-dark',
        6 => 'event-info',
        7 => 'event-success',
    ];

    public function index(ReportcoDataTable $dataTable, Request $request)
    {
        if (\Auth::user()->can('manage-dashboardwidget')) {
            if (\Auth::user()->forms_grid_view == 1) {
                return redirect()->route('grid.form.view', 'view');
            }
            $company = formValuesReportcos::groupBy('company_name')->pluck('company_name');
            $type           = FormType::where('status', 1)->pluck('name', 'id');
            $cluster = FormCluster::where('status', 1)->pluck('name', 'id');
            $leaders = FormLeader::where('status', 1)->pluck('name', 'id');

            $roles = Role::pluck('name', 'id');
            $trashForm = Form::onlyTrashed()->count();
            $form = Form::count();
            return $dataTable->render('reportco.index', compact('company', 'roles', 'trashForm', 'form', 'type', 'cluster', 'leaders'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function exportXlsx(Request $request)
    {
        // $dateRange = $request->select_date ?? '';
        // if ($dateRange != '') {
        //     list($startDate, $endDate) = array_map('trim', explode('to', $dateRange));
        // } else {
        //     $startDate = '';
        //     $endDate = '';
        // }
        $company = $request->select_company;
        $rate = $request->select_rate;
        $date = $request->select_date;
        $month = $request->select_month;

        return Excel::download(new ReportExportCO($company, $rate, $date, $month),'Report Corporate Operation' . '.xlsx');
    }

    public function getEventData(Request $request)
    {
        $arrayJson = [];
        if ($request->get('calenderType') == 'google_calender') {
            $data = GoogleEvent::get();
            $type = 1;
            foreach ($data as $val) {
                $end_date = Carbon::parse($val->endDateTime)->addDay();
                if ($val->colorId == $type) {
                    $arrayJson[] = [
                        "id"        => $val->id,
                        "title"     => $val->summary,
                        "start"     => $val->startDateTime,
                        "end"       => $end_date->format('Y-m-d H:i:s'),
                        "className" => Self::$colorCode[$type],
                        "allDay"    => true,
                    ];
                }
            }
            return $arrayJson;
        } else {
            $data = Event::all();
            $user = Auth::user();
            if ($user->type != 'Admin') {
                $data = Event::where('user', 'LIKE', '%,' . $user->id . ',%')
                    ->orWhere('user', 'LIKE', $user->id . ',%')
                    ->orWhere('user', 'LIKE', '%,' . $user->id)
                    ->orWhere('user', 'LIKE', '%' . $user->id . '%')
                    ->get();
            } else {
                if ($request->user) {
                    $user = User::select('id' , 'name')->where('name' , $request->user)->first();
                    $data = Event::select(['events.*', 'users.name as user_name', 'users.id as user_id'])
                        ->join('users', 'users.id', '=', 'events.user')
                        ->where('users.name', 'LIKE', '%' . $request->user . '%')
                        ->where('events.user', 'LIKE', '%,' . $user->id . ',%')
                        ->orWhere('events.user', 'LIKE', $user->id . ',%')
                        ->orWhere('events.user', 'LIKE', '%,' . $user->id)
                        ->orWhere('events.user', 'LIKE', '%' . $user->id . '%')
                        ->get();
                } else {
                    $data = Event::where('created_by', Auth::user()->id)->get();
                }
            }
            foreach ($data as $val) {
                $end_date = Carbon::parse($val->end_date)->addDay();
                $arrayJson[] = [
                    "id"         => $val->id,
                    "title"      => $val->title,
                    "start"      => $val->start_date,
                    "end"        => $end_date->format('Y-m-d H:i:s'),
                    "className"  => $val->color . ' event-edit',
                    'url'        => route('event.edit', $val['id']),
                    "allDay"     => true,
                ];
            }
        }
        return $arrayJson;
    }

    public function create(Request $request)
    {
        if (\Auth::user()->can('create-event')) {
            $startDate = Carbon::now()->format('d/m/Y');
            $endDate = Carbon::now()->format('d/m/Y');
            if ($request->start_date) {
                $startDate = Carbon::parse($request->start_date)->format('d/m/Y');
            }
            if ($request->end_date) {
                $endDate = Carbon::parse($request->end_date)->subDay()->format('d/m/Y');
            }
            $users = User::pluck('name', 'id');
            return view('event.create', compact('users', 'startDate', 'endDate'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create-event')) {
            if (Auth::user()->type == 'Admin') {
                $createdBy = Auth::user()->id;
                $user = implode(',', $request->user);
            } else {
                $createdBy = Auth::user()->created_by;
                $user = Auth::user()->id;
            }
            request()->validate([
                'title'      => 'required|max:50',
                'start_date' => 'required|date_format:d/m/Y',
                'end_date'   => 'required|date_format:d/m/Y',
                'color'      => 'required',
            ]);

            try {
                $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
            } catch (\Exception $e) {
                return redirect()->back()->with('errors', 'Invalid date format. Please use the format: dd/mm/YY');
            }


            $event = Event::create([
                'title'        => $request->title,
                'start_date'   => $startDate,
                'end_date'     => $endDate,
                'color'        => $request->color,
                'description'  => $request->description,
                'created_by'   => $createdBy,
                'user'         => $user,
            ]);

            if ($request->get('synchronize_type')  == 'google_calender') {
                $event                = new GoogleEvent();
                $event->name          = $request->title;
                $event->startDateTime = Carbon::createFromFormat('d/m/Y', $request->start_date)->setTime(0, 0, 0);
                $event->endDateTime   = Carbon::createFromFormat('d/m/Y', $request->end_date)->setTime(23, 59, 59);
                $event->colorId       = 1;
                $event->save();
            }
            return redirect()->route('event.index')->with('success', __('Event successfully created.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        $event      = Event::find($id);
        if (\Auth::user()->can('edit-event')) {
            $startDate     = Carbon::parse($event->start_date)->format('d/m/Y');
            $endDate       = Carbon::parse($event->end_date)->format('d/m/Y');
            $users          = User::pluck('name', 'id');
            $selectedUsers = explode(",", $event->user);
            return view('event.edit', compact('event', 'startDate', 'endDate', 'users', 'selectedUsers'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, Event $event)
    {
        if (\Auth::user()->can('edit-event')) {

            if (Auth::user()->type == 'Admin') {
                $user =   implode(',', $request->user);
            } else {
                $user = Auth::user()->id;
            }

            request()->validate([
                'title'      => 'required|max:50',
                'start_date' => 'required|date_format:d/m/Y',
                'end_date'   => 'required|date_format:d/m/Y',
                'color'      => 'required',
            ]);
            try {
                $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
            } catch (\Exception $e) {
                return redirect()->back()->with('errors', 'Invalid date format. Please use the format: dd/mm/YY');
            }

            $event->title       = $request->title;
            $event->start_date  = $startDate;
            $event->end_date    = $endDate;
            $event->color       = $request->color;
            $event->created_by  = Auth::user()->id;
            $event->user        = $user;
            $event->description = $request->description;
            $event->save();
            return redirect()->route('event.index')->with('success', __('Event successfully updated.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy(Event $event)
    {
        if (\Auth::user()->can('delete-event')) {
            $event->delete();
            return redirect()->route('event.index')->with('success', __('Event successfully deleted.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}
