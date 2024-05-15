<?php

namespace App\Http\Controllers;

use App\DataTables\PollDataTable;
use App\Facades\UtilityFacades;
use App\Models\Comments;
use App\Models\CommentsReply;
use App\Models\DashboardWidget;
use App\Models\ImagePoll;
use App\Models\MeetingPoll;
use App\Models\MultipleChoice;
use App\Models\Poll;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PollController extends Controller
{
    public function index(PollDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-poll')) {
            return $dataTable->render('poll.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('create-poll')) {
            return view('poll.create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create-poll')) {
            request()->validate([
                'title' => 'required|max:191',
            ]);
            if ($request->voting_type == 'Multiple_choice') {
                request()->validate([
                    'multiple_answer_options.*.answer_options' => 'required|max:191',
                ]);
            }elseif ($request->voting_type == 'Image_poll') {
                request()->validate([
                    'image_answer_options.*.optional_name' => 'required',
                ]);
            }else{
                request()->validate([
                    'meeting_answer_options.*.datetime' => 'required',
                ]);
            }
            if ($request->voting_type == 'Multiple_choice') {
                $multipleAnswer['multiple_answer_options']         =  $request->multiple_answer_options;
                $pollAnswer['title']                               =  $request->title;
                $pollAnswer['description']                         =  $request->description;
                $pollAnswer['voting_type']                         =  $request->voting_type;
                $pollAnswer['multiple_answer_options']             =  json_encode($multipleAnswer);
                $pollAnswer['require_participants_names']          =  ($request->require_participants_names == 'on') ? 1 : 0;
                $pollAnswer['voting_restrictions']                 =  $request->voting_restrictions;
                $pollAnswer['set_end_date']                        =  ($request->set_end_date == 'on') ? 1 : 0;
                $pollAnswer['allow_comments']                      =  ($request->allow_comments == 'on') ? 1 : 0;
                $pollAnswer['hide_participants_from_each_other']   =  ($request->hide_participants_from_each_other == 'on') ? 1 : 0;
                $pollAnswer['results_visibility']                  =  $request->results_visibility;
                $pollAnswer['set_end_date_time']                   =  Carbon::parse($request['set_end_date_time'])->toDateTimeString();
                $pollAnswer                                        =  Poll::create($pollAnswer);
            } else if ($request->voting_type == 'Image_poll') {
                $images = $request->image_answer_options;
                $abc = [];
                foreach ($images as $key => $img) {
                    $allowedfileExtension           = ['jpeg', 'jpg', 'png'];
                    $file                           = $img['image'];
                    $extension                      = $file->getClientOriginalExtension();
                    $check                          = in_array($extension, $allowedfileExtension);
                    $filename                       = $file->store('polls');
                    $abc['image_answer_options'][]  =  [
                        'optional_name' => $img['optional_name'],
                        'image'         => $filename
                    ];
                }
                $imagePollAnswer['title']                                     =  $request->title;
                $imagePollAnswer['description']                               =  $request->description;
                $imagePollAnswer['voting_type']                               =  $request->voting_type;
                $imagePollAnswer['image_answer_options']                      =  json_encode($abc);
                $imagePollAnswer['image_require_participants_names']          =  ($request->image_require_participants_names == 'on') ? 1 : 0;
                $imagePollAnswer['image_voting_restrictions']                 =  $request->image_voting_restrictions;
                $imagePollAnswer['image_set_end_date']                        =  ($request->image_set_end_date == 'on') ? 1 : 0;
                $imagePollAnswer['image_set_end_date_time']                   =  Carbon::parse($request['image_set_end_date_time'])->toDateTimeString();
                $imagePollAnswer['image_allow_comments']                      =  ($request->image_allow_comments == 'on') ? 1 : 0;
                $imagePollAnswer['image_hide_participants_from_each_other']   =  ($request->image_hide_participants_from_each_other == 'on') ? 1 : 0;
                $imagePollAnswer['image_results_visibility']                  =  $request->image_results_visibility;
                $imagePollAnswer                                              = Poll::create($imagePollAnswer);
            } else {
                $meetingMultipleAnswer['meeting_answer_options'] =  $request->meeting_answer_options;
                $i = [];
                foreach ($meetingMultipleAnswer as $meetingMultiple) {
                    foreach ($meetingMultiple as $meeting) {
                        $meetingDatetime = Carbon::parse($meeting['datetime'])->toDateTimeString();
                        $i['meeting_answer_options'][] =  [
                            'datetime' => $meetingDatetime
                        ];
                    }
                }
                $meetingPollAnswer['title']                                       = $request->title;
                $meetingPollAnswer['description']                                 = $request->description;
                $meetingPollAnswer['voting_type']                                 = $request->voting_type;
                $meetingPollAnswer['meeting_answer_options']                      = json_encode($i);
                $meetingPollAnswer['meeting_fixed_time_zone']                     = ($request->meeting_fixed_time_zone == 'on') ? 1 : 0;
                $meetingPollAnswer['meetings_fixed_time_zone']                    = $request->meetings_fixed_time_zone;
                $meetingPollAnswer['limit_selection_to_one_option_only']          = ($request->limit_selection_to_one_option_only == 'on') ? 1 : 0;
                $meetingPollAnswer['meeting_set_end_date']                        = ($request->meeting_set_end_date == 'on') ? 1 : 0;
                $meetingPollAnswer['meeting_set_end_date_time']                   = Carbon::parse($request['meeting_set_end_date_time'])->toDateTimeString();
                $meetingPollAnswer['meeting_allow_comments']                      = ($request->meeting_allow_comments == 'on') ? 1 : 0;
                $meetingPollAnswer['meeting_hide_participants_from_each_other']   = ($request->meeting_hide_participants_from_each_other == 'on') ? 1 : 0;
                $meetingPollAnswer                                                = Poll::create($meetingPollAnswer);
            }
            return redirect()->route('poll.index')->with('success', __('Poll created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }


    public function poll(Request $request, $id)
    {
        if (\Auth::user()->can('vote-poll')) {
            $poll       = poll::find($id);
            $commmant   = Comments::where('poll_id', $id)->get();
            $options    = json_decode($poll->multiple_answer_options);
            return view('poll.multiple-fill', compact('poll', 'options', 'commmant'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function fillStore(Request $request, $id)
    {
        $newSessid     = \Session::getId();
        $location       = \Location::get($request->ip());
        // $location = \Location::get('103.74.73.193');
        $poll = poll::find($id);
        if ($poll->set_end_date == '1' && Carbon::now() >= $poll->set_end_date_time == true) {
            return redirect()->back()->with('failed', __('The date for voting has already expired.'));
        } else {
            if ($poll->voting_restrictions == 'One_vote_per_ip_address') {
                if ($ipAddress = MultipleChoice::where('poll_id', $id)->where('location', $location->ip)->first()) {
                    return redirect()->back()->with('failed', __('You already voted on this poll.'));
                } else {
                    request()->validate([
                        'multiple_answer_options' => 'required',
                    ]);
                    MultipleChoice::create([
                        'vote'          => $request->multiple_answer_options,
                        'poll_id'       => $id,
                        'location'      => $location->ip,
                        'session_id'    => $newSessid,
                        'name'          => $request->name,
                    ]);
                    return redirect()->back()->with('success', __('Voting successfully.'));
                }
            } else if ($poll->voting_restrictions == 'One_vote_per_browser_session') {
                if ($ipAddress = MultipleChoice::where('poll_id', $id)->where('session_id', $newSessid)->first()) {
                    return redirect()->back()->with('failed', __('You already voted on this poll.'));
                } else {
                    request()->validate([
                        'multiple_answer_options' => 'required|string|max:191',
                    ]);
                    MultipleChoice::create([
                        'vote'         => $request->multiple_answer_options,
                        'poll_id'      => $id,
                        'location'     => $location->ip,
                        'session_id'   => $newSessid,
                        'name'         => $request->name,
                    ]);
                    return redirect()->back()->with('success', __('Voting successfully.'));
                }
            } else {
                if (Auth::user()) {
                    request()->validate([
                        'multiple_answer_options' => 'required|string|max:191',
                    ]);
                    MultipleChoice::create([
                        'vote'          => $request->multiple_answer_options,
                        'poll_id'       => $id,
                        'location'      => $location->ip,
                        'session_id'    => $newSessid,
                        'name'          => $request->name,
                    ]);
                    return redirect()->back()->with('success', __('Voting successfully.'));
                } else {
                    return redirect()->back()->with('failed', __('User account required. Please sign up or log in to vote.'));
                }
            }
        }
    }

    public function PollResult(Request $request, $id)
    {

        if (\Auth::user()->can('result-poll')) {
            $poll      = poll::find($id);
            $votes     = MultipleChoice::where('poll_id', $id)->get();
            $chartData = json_decode($poll->multiple_answer_options);
            $options   = [];
            foreach ($chartData as $chart) {
                foreach ($chart as $key => $value) {
                    $options['options'][$value->answer_options] = 0;
                }
            }
            foreach ($votes as $value) {
                $options['options'][$value->vote]++;
            }
            return view('poll.multiple-result ', compact('votes', 'poll', 'options', 'chartData'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function PollImageResult(Request $request, $id)
    {
        if (\Auth::user()->can('result-poll')) {
            $poll       = poll::find($id);
            $imgs       = json_decode($poll->image_answer_options);
            $votes      = ImagePoll::where('poll_id', $poll->id)->get();
            $chartData  = json_decode($poll->image_answer_options);
            $options    = [];
            foreach ($chartData as $chart) {
                foreach ($chart as $key => $value) {
                    $options['options'][$value->optional_name] = 0;
                }
            }
            foreach ($votes as $value) {
                $options['options'][$value->vote]++;
            }
            return view('poll.image-result', compact('poll', 'imgs', 'votes', 'options', 'chartData'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function PollMeetingResult(Request $request, $id)
    {
        if (\Auth::user()->can('result-poll')) {
            $poll       = poll::find($id);
            $votes      = MeetingPoll::where('poll_id', $id)->get();
            $chartData  = json_decode($poll->meeting_answer_options);
            $options    = [];
            foreach ($chartData as $chart) {
                foreach ($chart as $key => $value) {
                    $options['options'][UtilityFacades::date_time_format($value->datetime)] = 0;
                }
            }
            foreach ($votes as $value) {
                $options['options'][UtilityFacades::date_time_format($value->vote)]++;
            }
            return view('poll.meeting-result ', compact('poll', 'options', 'chartData', 'votes'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function ImagePoll(Request $request, $id)
    {
        if (\Auth::user()->can('vote-poll')) {
            $poll       = poll::find($id);
            $options    = json_decode($poll->image_answer_options);
            return view('poll.image-fill', compact('poll', 'options'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function ImageStore(Request $request, $id)
    {
        $location = \Location::get($request->ip());
        // $location = \Location::get('103.74.73.193');
        $poll = poll::find($id);
        $newSessid   = \Session::getId();
        if ($poll->image_set_end_date == '1' && Carbon::now() >= $poll->image_set_end_date_time == true) {
            return redirect()->back()->with('failed', __('The date for voting has already expired.'));
        } else {
            if ($poll->image_voting_restrictions == 'One_vote_per_ip_address') {
                if ($ipAddress = ImagePoll::where('poll_id', $id)->where('location', $location->ip)->first()) {
                    return redirect()->back()->with('failed', __('You already voted on this poll.'));
                } else {
                    request()->validate([
                        'optional_name' => 'required',
                    ]);
                    ImagePoll::create([
                        'vote'       => $request->optional_name,
                        'poll_id'    => $id,
                        'location'   => $location->ip,
                        'name'       => $request->name,
                        'session_id' => $newSessid,
                    ]);
                    return redirect()->back()->with('success', __('Voting successfully.'));
                }
            } else if ($poll->image_voting_restrictions == 'One_vote_per_browser_session') {
                if ($ipAddress = ImagePoll::where('poll_id', $id)->where('session_id', $newSessid)->first()) {
                    return redirect()->back()->with('failed', __('You already voted on this poll.'));
                } else {
                    request()->validate([
                        'optional_name' => 'required',
                    ]);
                    ImagePoll::create([
                        'vote'          => $request->optional_name,
                        'poll_id'       => $id,
                        'location'      => $location->ip,
                        'name'          => $request->name,
                        'session_id'    => $newSessid,
                    ]);
                    return redirect()->back()->with('success', __('Voting successfully.'));
                }
            } else {
                if (Auth::user()) {
                    request()->validate([
                        'optional_name' => 'required',
                    ]);
                    ImagePoll::create([
                        'vote'          => $request->optional_name,
                        'poll_id'       => $id,
                        'location'      => $location->ip,
                        'name'          => $request->name,
                        'session_id'    => $newSessid,
                    ]);
                    return redirect()->back()->with('success', __('Voting successfully.'));
                } else {
                    return redirect()->back()->with('failed', __('User account required. Please sign up or log in to vote.'));
                }
            }
        }
    }

    public function MeetingPoll(Request $request, $id)
    {
        if (\Auth::user()->can('vote-poll')) {
            $poll    = poll::find($id);
            $options = json_decode($poll->meeting_answer_options);
            return view('poll.meeting-fill', compact('poll', 'options'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function MeetingStore(Request $request, $id)
    {
        $location = \Location::get($request->ip());
        // $location = \Location::get('103.74.73.193');
        $newSessid   = \Session::getId();
        $poll = poll::find($id);
        if ($poll->meeting_set_end_date == '1' && Carbon::now() >= $poll->meeting_set_end_date_time == true) {
            return redirect()->back()->with('failed', __('The date for voting has already expired.'));
        } else {
            request()->validate([
                'meeting_answer_options' => 'required',
                'name'                   => 'required',
            ]);
            foreach ($request->meeting_answer_options as $meetingAnswer) {
                MeetingPoll::create([
                    'vote'        => $meetingAnswer,
                    'poll_id'     => $id,
                    'location'    => $location->ip,
                    'name'        => $request->name,
                    'session_id'  => $newSessid,

                ]);
            }
            return redirect()->back()->with('success', __('Voting successfully.'));
        }
    }

    public function publicFill(Request $request, $id)
    {
        $hashids = new Hashids('', 20);
        $id = $hashids->decodeHex($id);
        if ($id) {
            $poll = Poll::find($id);
            if ($poll) {
                $array = $poll->getPollArray();
                return view('poll.public-multiple-choice', compact('poll', 'array'));
            } else {
                return redirect()->back()->with('failed', __('Form not found.'));
            }
        } else {
            abort(404);
        }
    }

    public function PublicFillResult(Request $request, $id)
    {
        $hashids = new Hashids('', 20);
        $id = $hashids->decodeHex($id);
        $poll = Poll::find($id);
        $newSessid   = \Session::getId();
        $location = \Location::get($request->ip());
        // $location = \Location::get('103.74.73.193');
        if ($poll->results_visibility == 'public_after_vote') {
            if ($poll->voting_restrictions == 'One_vote_per_ip_address') {
                if ($ipAddress = MultipleChoice::where('poll_id', $id)->where('location', $location->ip)->first()) {
                    if ($id) {
                        $votes = MultipleChoice::where('poll_id', $id)->get();
                        $chartData = json_decode($poll->multiple_answer_options);
                        if ($poll) {
                            $options = [];
                            foreach ($chartData as $chart) {
                                foreach ($chart as $key => $value) {
                                    $options['options'][$value->answer_options] = 0;
                                }
                            }
                            foreach ($votes as $value) {
                                $options['options'][$value->vote]++;
                            }
                            return view('poll.public-multiple-choice-result', compact('poll','options', 'chartData', 'votes'));
                        } else {
                            return redirect()->back()->with('failed', __('Form not found.'));
                        }
                    } else {
                        abort(404);
                    }
                } else {
                    return redirect()->back()->with('failed', __('After Vote Results Visibility'));
                }
            } else if ($poll->voting_restrictions == 'One_vote_per_browser_session') {
                if ($ipAddress = MultipleChoice::where('poll_id', $id)->where('session_id', $newSessid)->first()) {
                    if ($id) {
                        $votes = MultipleChoice::where('poll_id', $id)->get();
                        $chartData = json_decode($poll->multiple_answer_options);
                        if ($poll) {
                            $options = [];
                            foreach ($chartData as $chart) {
                                foreach ($chart as $key => $value) {
                                    $options['options'][$value->answer_options] = 0;
                                }
                            }
                            foreach ($votes as $value) {
                                $options['options'][$value->vote]++;
                            }
                            return view('poll.public-multiple-choice-result', compact('poll', 'options', 'chartData', 'votes'));
                        } else {
                            return redirect()->back()->with('failed', __('Form not found.'));
                        }
                    } else {
                        abort(404);
                    }
                } else {
                    return redirect()->back()->with('failed', __('After vote results visibility'));
                }
            } else {
                return redirect()->back()->with('failed', __('Only vote results visibility in user.'));
            }
        } else {
            if ($id) {
                $votes = MultipleChoice::where('poll_id', $id)->get();
                $chartData = json_decode($poll->multiple_answer_options);
                if ($poll) {
                    $options = [];
                    foreach ($chartData as $chart) {
                        foreach ($chart as $key => $value) {
                            $options['options'][$value->answer_options] = 0;
                        }
                    }
                    foreach ($votes as $value) {
                        $options['options'][$value->vote]++;
                    }
                    return view('poll.public-multiple-choice-result', compact('poll', 'options', 'chartData', 'votes'));
                } else {
                    return redirect()->back()->with('failed', __('Form not found.'));
                }
            } else {
                abort(404);
            }
        }
    }

    public function PublicFillMeeting(Request $request, $id)
    {
        $hashids = new Hashids('', 20);
        $id = $hashids->decodeHex($id);
        if ($id) {
            $poll        = Poll::find($id);
            if ($poll) {
                $options = $poll->getMeetingArray();
                return view('poll.public-meeting-poll', compact('poll','options'));
            } else {
                return redirect()->back()->with('failed', __('Form not found.'));
            }
        } else {
            abort(404);
        }
    }

    public function PublicFillResultMeeting(Request $request, $id)
    {
        $hashids = new Hashids('', 20);
        $id = $hashids->decodeHex($id);
        if ($id) {
            $poll       = Poll::find($id);
            $votes      = MeetingPoll::where('poll_id', $id)->get();
            $chartData  = json_decode($poll->meeting_answer_options);
            $options    = [];
            if ($poll) {
                foreach ($chartData as $chart) {
                    foreach ($chart as $key => $value) {
                        $options['options'][UtilityFacades::date_time_format($value->datetime)] = 0;
                    }
                }
                foreach ($votes as $value) {
                    $options['options'][UtilityFacades::date_time_format($value->vote)]++;
                }
                return view('poll.public-meeting-result', compact('poll','options', 'chartData', 'votes'));
            } else {
                return redirect()->back()->with('failed', __('Form not found.'));
            }
        } else {
            abort(404);
        }
    }

    public function PublicFillImage(Request $request, $id)
    {
        $hashids = new Hashids('', 20);
        $id = $hashids->decodeHex($id);
        if ($id) {
            $poll = Poll::find($id);
            if ($poll) {
                $options = $poll->getPollImage();
                return view('poll.public-image-poll', compact('poll','options'));
            } else {
                return redirect()->back()->with('failed', __('Form not found.'));
            }
        } else {
            abort(404);
        }
    }

    public function PublicFillResultImage(Request $request, $id)
    {
        $hashids = new Hashids('', 20);
        $id = $hashids->decodeHex($id);
        $newSessid   = \Session::getId();
        $location = \Location::get($request->ip());
        // $location = \Location::get('103.74.73.193');
        try {
        $poll = Poll::find($id);
            if ($poll->image_results_visibility == 'public_after_vote') {
                if ($poll->image_voting_restrictions == 'One_vote_per_ip_address') {
                    if ($ipAddress = ImagePoll::where('poll_id', $id)->where('location', $location->ip)->first()) {
                        if ($id) {
                            $imgs       = json_decode($poll->image_answer_options);
                            $votes      = ImagePoll::where('poll_id', $poll->id)->get();
                            $chartData  = json_decode($poll->image_answer_options);
                            $options    = [];

                            if ($poll) {
                                foreach ($chartData as $chart) {
                                    foreach ($chart as $key => $value) {
                                        $options['options'][$value->optional_name] = 0;
                                    }
                                }

                                foreach ($votes as $value) {
                                    $options['options'][$value->vote]++;
                                }
                                return view('poll.public-image-result', compact('poll',  'imgs', 'options', 'votes', 'chartData'));
                            } else {
                                return redirect()->back()->with('failed', __('Form not found.'));
                            }
                        } else {
                            abort(404);
                        }
                    } else {
                        return redirect()->back()->with('failed', __('After vote results visibility'));
                    }
                } else if ($poll->image_voting_restrictions == 'One_vote_per_browser_session') {
                    if ($ipAddress = ImagePoll::where('poll_id', $id)->where('session_id', $newSessid)->first()) {
                        if ($id) {
                            $imgs       = json_decode($poll->image_answer_options);
                            $votes      = ImagePoll::where('poll_id', $poll->id)->get();
                            $chartData  = json_decode($poll->image_answer_options);
                            $options    = [];
                            if ($poll) {
                                foreach ($chartData as $chart) {
                                    foreach ($chart as $key => $value) {
                                        $options['options'][$value->optional_name] = 0;
                                    }
                                }
                                foreach ($votes as $value) {
                                    $options['options'][$value->vote]++;
                                }
                                return view('poll.public-image-result', compact('poll', 'imgs', 'options', 'votes', 'chartData'));
                            } else {
                                return redirect()->back()->with('failed', __('Form not found.'));
                            }
                        } else {
                            abort(404);
                        }
                    } else {
                        return redirect()->back()->with('failed', __('After vote results visibility.'));
                    }
                } else {
                    return redirect()->back()->with('failed', __('Only vote results visibility in user.'));
                }
            } else {
                if ($id) {
                    $imgs       = json_decode($poll->image_answer_options);
                    $votes      = ImagePoll::where('poll_id', $poll->id)->get();
                    $chartData  = json_decode($poll->image_answer_options);
                    $options    = [];
                    if ($poll) {
                        foreach ($chartData as $chart) {
                            foreach ($chart as $key => $value) {
                                $options['options'][$value->optional_name] = 0;
                            }
                        }
                        foreach ($votes as $value) {
                            $options['options'][$value->vote]++;
                        }
                        return view('poll.public-image-result', compact('poll', 'imgs', 'options', 'votes', 'chartData'));
                    } else {
                        return redirect()->back()->with('failed', __('Form not found.'));
                    }
                } else {
                    abort(404);
                }
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    public function Share($id)
    {
        $hashids   = new Hashids('', 20);
        $id        = $hashids->decodeHex($id);
        $poll      = Poll::find($id);
        $view      = view('poll.public-multiple-share', compact('poll'));
        return ['html' => $view->render()];
    }

    public function ShareQr($id)
    {
        $hashids    = new Hashids('', 20);
        $id         = $hashids->decodeHex($id);
        $poll       = Poll::find($id);
        $view       = view('poll.public-multiple-share-new', compact('poll'));
        return ['html' => $view->render()];
    }

    public function ShareQrImage($id)
    {
        $hashids    = new Hashids('', 20);
        $id         = $hashids->decodeHex($id);
        $poll       = Poll::find($id);
        $view       = view('poll.public-image-share-new', compact('poll'));
        return ['html' => $view->render()];
    }

    public function ShareImage($id)
    {
        $hashids    = new Hashids('', 20);
        $id         = $hashids->decodeHex($id);
        $poll       = Poll::find($id);
        $view       = view('poll.public-image-share', compact('poll'));
        return ['html' => $view->render()];
    }

    public function ShareMeeting($id)
    {
        $hashids   = new Hashids('', 20);
        $id        = $hashids->decodeHex($id);
        $poll      = Poll::find($id);
        $view      = view('poll.public-meeting-share', compact('poll'));
        return ['html' => $view->render()];
    }

    public function ShareQrMeeting($id)
    {
        $hashids    = new Hashids('', 20);
        $id         = $hashids->decodeHex($id);
        $poll       = Poll::find($id);
        $view       = view('poll.public-meeting-share-new', compact('poll'));
        return ['html' => $view->render()];
    }

    public function Shares($id)
    {
        $poll       = Poll::find($id);
        $view       = view('poll.multiple-share', compact('poll'));
        return ['html' => $view->render()];
    }

    public function ShareMeetings($id)
    {
        $poll   = Poll::find($id);
        $view   = view('poll.meeting-share', compact('poll'));
        return ['html' => $view->render()];
    }

    public function ShareImages($id)
    {
        $poll   = Poll::find($id);
        $view   = view('poll.image-share', compact('poll'));
        return ['html' => $view->render()];
    }

    public function destroy($id)
    {
        if (\Auth::user()->can('delete-poll')) {
            $poll               = Poll::find($id);
            $multiplechoice     = MultipleChoice::where('poll_id', $id)->get();
            $meetingPoll        = MeetingPoll::where('poll_id', $id)->get();
            $imagePoll          = ImagePoll::where('poll_id', $id)->get();
            $comments           = Comments::where('poll_id', $id)->get();
            $commentsReply      = CommentsReply::where('poll_id', $id)->get();
            DashboardWidget::where('poll_id', $id)->delete();
            if ($poll->voting_type == 'Multiple_choice') {
                foreach ($multiplechoice as $value) {
                    $ids        = $value->id;
                    $multiple   =  MultipleChoice::find($ids);
                    if ($multiple) {
                        $multiple->delete();
                    }
                }
            } elseif ($poll->voting_type == 'Meeting_poll') {
                foreach ($meetingPoll as $meetingValue) {
                    $meetingValueIds = $meetingValue->id;
                    $meeting           =  MeetingPoll::find($meetingValueIds);
                    if ($meeting) {
                        $meeting->delete();
                    }
                }
            } else {
                $imgs = json_decode($poll->image_answer_options);
                foreach ($imgs->image_answer_options as $key => $img) {
                    $imageName = $img->image;
                    if ($imageName) {
                        Storage::delete($imageName);
                    }
                }
                foreach ($imagePoll as $imagePollValue) {
                    $imagePollValueIds = $imagePollValue->id;
                    $image                =  ImagePoll::find($imagePollValueIds);
                    if ($image) {
                        $image->delete();
                    }
                }
            }
            foreach ($comments as $allcomments) {
                $commentsids = $allcomments->id;
                $commentsall = Comments::find($commentsids);
                if ($commentsall) {
                    $commentsall->delete();
                }
            }
            foreach ($commentsReply as $commentsReplyAll) {
                $commentsReplyIds = $commentsReplyAll->id;
                $reply              =  CommentsReply::find($commentsReplyIds);
                if ($reply) {
                    $reply->delete();
                }
            }
            $poll->delete();
            return redirect()->back()->with('success', __('Poll deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (\Auth::user()->can('edit-poll')) {
            $poll                      = Poll::find($id);
            $next                      = Poll::where('id', '>', $poll->id)->first();
            $previous                  = Poll::where('id', '<', $poll->id)->orderBy('id', 'desc')->first();
            $imageAnswerOptions        = json_decode($poll->image_answer_options);
            $meetingAnswerOptions      = json_decode($poll->meeting_answer_options);
            $multipleAnswerOptions     = json_decode($poll->multiple_answer_options);
            $multiple = [];
            $meetingPoll = [];
            $imagePoll = [];
            if ($poll->voting_type == 'Multiple_choice') {
                foreach ($multipleAnswerOptions as $value) {
                    foreach ($value as $data) {
                        $multiple[] = [
                            'answer_options' => $data->answer_options
                        ];
                    }
                }
            } else if ($poll->voting_type == 'Meeting_poll') {
                foreach ($meetingAnswerOptions as $value) {
                    foreach ($value as $data) {
                        $meetingPoll[] = [
                            'datetime' => $data->datetime
                        ];
                    }
                }
            } else {
                foreach ($imageAnswerOptions as $value) {
                    foreach ($value as $data) {
                        $imagePoll[] = [
                            'optional_name' => $data->optional_name,
                            'image' => Storage::url($data->image),
                            'old_image' => $data->image
                        ];
                    }
                }
            }
            return view('poll.edit', compact('poll', 'multiple', 'meetingPoll', 'imagePoll', 'next', 'previous'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit-poll')) {
            request()->validate([
                'title' => 'required',
            ]);

            if ($request->voting_type == 'Image_poll') {
                request()->validate([
                    'image_answer_options.*.optional_name' => 'required',
                ]);
            }
            if ($request->voting_type == 'Multiple choice') {
                $pollAnswer                                        = Poll::find($id);
                $multipleAnswer['multiple_answer_options']         = $request->multiple_answer_options;
                $pollAnswer['title']                               = $request->title;
                $pollAnswer['description']                         = $request->description;
                $pollAnswer['voting_type']                         = 'Multiple_choice';
                $pollAnswer['multiple_answer_options']             = json_encode($multipleAnswer);
                $pollAnswer['require_participants_names']          = ($request->require_participants_names == 'on') ? 1 : 0;
                $pollAnswer['voting_restrictions']                 = $request->voting_restrictions;
                $pollAnswer['set_end_date']                        = ($request->set_end_date == 'on') ? 1 : 0;
                $pollAnswer['allow_comments']                      = ($request->allow_comments == 'on') ? 1 : 0;
                $pollAnswer['hide_participants_from_each_other']   = ($request->hide_participants_from_each_other == 'on') ? 1 : 0;
                $pollAnswer['results_visibility']                  = $request->results_visibility;
                $pollAnswer['set_end_date_time']                   = Carbon::parse($request['set_end_date_time'])->toDateTimeString();
                $pollAnswer->save();
            } else if ($request->voting_type == 'Image poll') {
                $imagePollAnswer = Poll::find($id);
                $images            = $request->image_answer_options;
                $abc                = [];
                foreach ($images as $img) {
                    $allowedfileExtension = ['jpeg', 'jpg', 'png'];
                    if ($img['old_image']) {
                        $abc['image_answer_options'][] =  [
                            'optional_name' => $img['optional_name'],
                            'image'         => $img['old_image']
                        ];
                    } else {
                        $file                          = $img['new_image'];
                        $extension                     = $file->getClientOriginalExtension();
                        $check                         = in_array($extension, $allowedfileExtension);
                        $filename                      = $file->store('polls');
                        $abc['image_answer_options'][] =  [
                            'optional_name' => $img['optional_name'],
                            'image'         => $filename
                        ];
                    }
                }
                $imagePollAnswer['title']                                   =  $request->title;
                $imagePollAnswer['description']                             =  $request->description;
                $imagePollAnswer['voting_type']                             =  'Image_poll';
                $imagePollAnswer['image_answer_options']                    =  json_encode($abc);
                $imagePollAnswer['image_require_participants_names']        =  ($request->image_require_participants_names == 'on') ? 1 : 0;
                $imagePollAnswer['image_voting_restrictions']               =  $request->image_voting_restrictions;
                $imagePollAnswer['image_set_end_date']                      =  ($request->image_set_end_date == 'on') ? 1 : 0;
                $imagePollAnswer['image_set_end_date_time']                 =  Carbon::parse($request['image_set_end_date_time'])->toDateTimeString();
                $imagePollAnswer['image_allow_comments']                    =  ($request->image_allow_comments == 'on') ? 1 : 0;
                $imagePollAnswer['image_hide_participants_from_each_other'] =  ($request->image_hide_participants_from_each_other == 'on') ? 1 : 0;
                $imagePollAnswer['image_results_visibility']                =  $request->image_results_visibility;
                $imagePollAnswer->save();
            } else {
                $meetingPollAnswer = Poll::find($id);
                $meetingMultipleAnswer['meeting_answer_options'] =  $request->meeting_answer_options;
                $i = [];
                foreach ($meetingMultipleAnswer as $meetingMultiple) {
                    foreach ($meetingMultiple as $meeting) {
                        $meetingDatetime = Carbon::parse($meeting['datetime'])->toDateTimeString();
                        $i['meeting_answer_options'][] =  [
                            'datetime' => $meetingDatetime
                        ];
                    }
                }
                $meetingPollAnswer['title']                                      =  $request->title;
                $meetingPollAnswer['description']                                =  $request->description;
                $meetingPollAnswer['voting_type']                                =  'Meeting_poll';
                $meetingPollAnswer['meeting_answer_options']                     =  json_encode($i);
                $meetingPollAnswer['meeting_fixed_time_zone']                    =  ($request->meeting_fixed_time_zone == 'on') ? 1 : 0;
                $meetingPollAnswer['meetings_fixed_time_zone']                   =  $request->meetings_fixed_time_zone;
                $meetingPollAnswer['limit_selection_to_one_option_only']         =  ($request->limit_selection_to_one_option_only == 'on') ? 1 : 0;
                $meetingPollAnswer['meeting_set_end_date']                       =  ($request->meeting_set_end_date == 'on') ? 1 : 0;
                $meetingPollAnswer['meeting_set_end_date_time']                  =  Carbon::parse($request['meeting_set_end_date_time'])->toDateTimeString();
                $meetingPollAnswer['meeting_allow_comments']                     =  ($request->meeting_allow_comments == 'on') ? 1 : 0;
                $meetingPollAnswer['meeting_hide_participants_from_each_other']  =  ($request->meeting_hide_participants_from_each_other == 'on') ? 1 : 0;
                $meetingPollAnswer->save();
            }
            return redirect()->route('poll.index')->with('success', __('Poll created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}
