<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\GoogleCalendar\Event as GoogleEvent;

class EventController extends Controller
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

    public function index(Request $request)
    {

        if (\Auth::user()->can('manage-event')) {
            $date = Carbon::now();
            $events    = Event::all();
            $transdate = $date->format('Y-m-d');
            $todayDate = $date->format('m');
            $user = \Auth::user();
            if (\Auth::user()->type == 'Admin') {
                $currentMonthEvent = Event::select('id', 'start_date', 'end_date', 'title', 'created_at', 'color', 'user')
                    ->where('created_by', $user->id)
                    ->whereRaw('MONTH(start_date)=' . $todayDate)
                    ->whereRaw('MONTH(end_date)=' . $todayDate)
                    ->get();
            } else {
                $currentMonthEvent = Event::select('id', 'start_date', 'end_date', 'title', 'created_by', 'color', 'user')
                    ->where('user', 'LIKE', '%,' . $user->id . ',%')
                    ->orWhere('user', 'LIKE', $user->id . ',%')
                    ->orWhere('user', 'LIKE', '%,' . $user->id)
                    ->orWhere('user', 'LIKE', '%' . $user->id . '%')
                    ->whereRaw('MONTH(start_date)=' . $todayDate)->whereRaw('MONTH(end_date)=' . $todayDate)
                    ->get();
            }

            $arrEvents = [];
            foreach ($events as $event) {
                $arr['id']        = $event['id'];
                $arr['title']     = $event['title'];
                $arr['start']     = $event['start_date'];
                $arr['end']       = $event['end_date'];
                $arr['className'] = $event['color'] . ' event-edit';
                $arr['url']       = route('event.edit', $event['id']);
                $arrEvents[]      = $arr;
            }
            $arrEvents = str_replace('"[', '[', str_replace(']"', ']', json_encode($arrEvents)));
            return view('event.index', compact('arrEvents', 'transdate', 'events', 'currentMonthEvent'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
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
