<?php

namespace App\Http\Controllers;

use App\DataTables\FormsDataTable;
use App\Facades\UtilityFacades;
use App\Mail\FormSubmitEmail;
use App\Mail\Thanksmail;
use App\Models\AssignFormsRoles;
use App\Models\AssignFormsUsers;
use App\Models\DashboardWidget;
use App\Models\Form;
use App\Models\FormCategory;
use App\Models\FormType;
use App\Models\FormCluster;
use App\Models\FormLeader;
use App\Models\FormDestination;
use App\Models\FormComments;
use App\Models\FormCommentsReply;
use App\Models\FormIntegrationSetting;
use App\Models\formRule;
use App\Models\FormStatus;
use App\Models\FormTemplate;
use App\Models\FormValue;
use App\Models\NotificationsSetting;
use App\Models\User;
use App\Models\UserForm;
use App\Notifications\CreateForm;
use App\Notifications\NewSurveyDetails;
use App\Rules\CommaSeparatedEmails;
use Carbon\Carbon;
use Exception;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Stripe\Charge;
use Stripe\Stripe as StripeStripe;
use Illuminate\Support\Facades\Mail;
use Spatie\MailTemplates\Models\MailTemplate;
use Stevebauman\Location\Facades\Location;
use App\Models\Poll;
use App\Models\FormValueDetail10;
use App\Models\formValuesReportcos;
use App\Models\FormValueDetailReportcos;
use App\Models\TourConsultants;

class FormController extends Controller
{
    public function index(FormsDataTable $dataTable, Request $request)
    {
        if (\Auth::user()->can('manage-form')) {
            if (\Auth::user()->forms_grid_view == 'Admin') {
                return redirect()->route('grid.form.view', 'view');
            }
            $categories = FormCategory::where('status', 1)->pluck('name', 'id');
            $type           = FormType::where('status', 1)->pluck('name', 'id');
            $roles = Role::pluck('name', 'id');
            $trashForm = Form::onlyTrashed()->count();
            $form = Form::count();
            return $dataTable->render('form.index', compact('categories', 'roles', 'trashForm', 'form', 'type'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function addForm()
    {
        if (\Auth::user()->type == 'Admin') {
            $formTemplates = FormTemplate::where('json', '!=', null)->where('status', 1)->get();
            return view('form.add', compact('formTemplates'));
        } else {
            $formTemplates = FormTemplate::where('image', \Auth::user()->type)->where('json', '!=', null)->where('status', 1)->get();
            return view('form.add', compact('formTemplates'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('create-form')) {
            // $users = User::where('id', '!=', 1)->pluck('name', 'id');
            $roles = Role::where('name', '!=', 'Super Admin')
                ->orwhere('name', Auth::user()->type)
                ->pluck('name', 'id');

            $category = FormCategory::where('status', 1)->pluck('name', 'id');
            $status   = FormStatus::where('status', 1)->pluck('name', 'id');
            $type           = FormType::where('status', 1)->pluck('name', 'id');
            return view('form.create', compact('roles', 'users', 'category', 'status', 'type'));
        } else {
            return response()->json(['failed' => __('Permission denied.')], 401);
        }
    }


    public function useFormtemplate($id)
    {
        if (\Auth::user()->type == 'Admin') {
            $formtemplate = FormTemplate::find($id);
            $cat_id = Role::where('name', $formtemplate->image)->get();
            $form = Form::create([
                'title'     => $formtemplate->title,
                'json'      => $formtemplate->json,
                'category_id' => $cat_id->first()->category_id,
                'created_by' => Auth::user()->id    
            ]);

            return redirect()->route('forms.edit', $form->id)->with('success', __('Form created successfully.'));
        } else {
            $formtemplate = FormTemplate::find($id);
            $cat_id = Role::where('name', Auth::user()->type)->get();
            $form = Form::create([
                'title'     => $formtemplate->title,
                'json'      => $formtemplate->json,
                'category_id' => $cat_id->first()->category_id,
                'created_by' => Auth::user()->id    
            ]);
            
            return redirect()->route('forms.edit', $form->id)->with('success', __('Form created successfully.'));
        }
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create-form')) {
            request()->validate([
                'title'     => 'required|max:191'
            ]);
            $form = new Form();
            $form->title                = $request->title;
           
            $form->save();
            if ($request->assign_type == 'role') {
                $form->assignRole($request->roles);
            }
            if ($request->assign_type == 'user') {
                $form->assignUser($request->users);
            }
            $form->assignFormRoles($request->roles);

        
            return redirect()->route('forms.index')->with('success', __('Form created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        $usr                = \Auth::user();
        $userRole          = $usr->roles->first()->id;
        $userCat          = $usr->roles->first()->category_id;
        $formallowededit    = UserForm::where('role_id', $userRole)->where('form_id', $id)->count();
        if (\Auth::user()->can('edit-form')) {
            $form           = Form::find($id);
            $next           = Form::where('id', '>', $form->id)->first();
            $previous       = Form::where('id', '<', $form->id)->orderBy('id', 'desc')->first();
            $roles          = Role::where('name', '!=', 'Super Admin')->pluck('name', 'id');
            $formRole       = $form->assignedroles->pluck('id')->toArray();
            $getFormRole    = Role::pluck('name', 'id');
            $formUser       =  $form->assignedusers->pluck('id')->toArray();
            $GetformUser    = User::where('id', '!=', 1)->pluck('name', 'id');
            $status         = FormStatus::where('status', 1)->pluck('name', 'id');
            $types           = FormType::where('name', 'Tour')->get();
            $type          = [];
            $type['']      = __('Select type');
            foreach ($types as $value) {
                $type[$value->name] = $value->name;
            }
            if(\Auth::user()->type == 'Admin'){
                $categories           = FormCategory::where('type_name', 'Tour')->get();
                $cat          = [];
                $cat['']      = __('Select categories');
                foreach ($categories as $value) {
                    $cat[$value->name] = $value->name;
                }
            }else{
                $categories           = FormCategory::where('id', $userCat)->get();
                $cat          = [];
                $cat['']      = __('Select categories');
                foreach ($categories as $value) {
                    $cat[$value->name] = $value->name;
                }
            }
            $clusters          = FormCluster::all();
            $cluster          = [];
            $cluster['']      = __('Select clusters');
            foreach ($clusters as $value) {
                $cluster[$value->name] = $value->name;
            }
            $leaders           = FormLeader::all();
            $lead          = [];
            $lead['']      = __('Select leaders');
            foreach ($leaders as $value) {
                $lead[$value->name] = $value->name;
            }
            return view('form.edit', compact('form', 'roles', 'GetformUser', 'formUser', 'formRole', 'getFormRole', 'next', 'previous', 'status', 'type', 'cat', 'cluster', 'lead'));
        } else {
            if (\Auth::user()->can('edit-form') && $formallowededit > 0) {
                $form           = Form::find($id);
                $next           = Form::where('id', '>', $form->id)->first();
                $previous       = Form::where('id', '<', $form->id)->orderBy('id', 'desc')->first();
                $roles          = Role::pluck('name', 'id');
                $formRole       = $form->assignedroles->pluck('id')->toArray();
                $getFormRole    = Role::pluck('name', 'id');
                $formUser       = $form->assignedusers->pluck('id')->toArray();
                $GetformUser    = User::where('id', '!=', 1)->pluck('name', 'id');
                $status         = FormStatus::where('status', 1)->pluck('name', 'id');
                $types           = FormType::where('name', 'Tour')->get();
                $type          = [];
                $type['']      = __('Select type');
                foreach ($types as $value) {
                    $type[$value->name] = $value->name;
                }
                if(\Auth::user()->type == 'Admin'){
                    $categories           = FormCategory::where('type_name', 'Tour')->get();
                    $cat          = [];
                    $cat['']      = __('Select categories');
                    foreach ($categories as $value) {
                        $cat[$value->name] = $value->name;
                    }
                }else{
                    $categories           = FormCategory::where('id', $userCat)->get();
                    $cat          = [];
                    $cat['']      = __('Select categories');
                    foreach ($categories as $value) {
                        $cat[$value->name] = $value->name;
                    }
                }
                $clusters          = FormCluster::all();
                $cluster          = [];
                $cluster['']      = __('Select clusters');
                foreach ($clusters as $value) {
                    $cluster[$value->name] = $value->name;
                }
                $leaders           = FormLeader::all();
                $lead          = [];
                $lead['']      = __('Select leaders');
                foreach ($leaders as $value) {
                    $lead[$value->name] = $value->name;
                }
                return view('form.edit', compact('form', 'getFormRole', 'GetformUser', 'formUser', 'formRole', 'next', 'previous', 'status', 'type', 'cat', 'clusters', 'lead'));
            } else {
                return redirect()->back()->with('failed', __('Permission denied.'));
            }
        }
    }

    public function buttonedit($id)
    {
        $usr                = \Auth::user();
        $userRole          = $usr->roles->first()->id;
        $userCat          = $usr->roles->first()->category_id;
        $formallowededit    = UserForm::where('role_id', $userRole)->where('form_id', $id)->count();
        if (\Auth::user()->can('edit-form')) {
            $form           = Form::find($id);
            $next           = Form::where('id', '>', $form->id)->first();
            $previous       = Form::where('id', '<', $form->id)->orderBy('id', 'desc')->first();
            $roles          = Role::where('name', '!=', 'Super Admin')->pluck('name', 'id');
            $formRole       = $form->assignedroles->pluck('id')->toArray();
            $getFormRole    = Role::pluck('name', 'id');
            $formUser       =  $form->assignedusers->pluck('id')->toArray();
            $GetformUser    = User::where('id', '!=', 1)->pluck('name', 'id');
            $status         = FormStatus::where('status', 1)->pluck('name', 'id');
            $types           = FormType::where('name', 'Tour')->get();
            $type          = [];
            $type['']      = __('Select type');
            foreach ($types as $value) {
                $type[$value->name] = $value->name;
            }
            $categories           = FormCategory::where('id', $userCat)->get();
            $cat          = [];
            $cat['']      = __('Select categories');
            foreach ($categories as $value) {
                $cat[$value->name] = $value->name;
            }
            $clusters          = FormCluster::all();
            $cluster          = [];
            $cluster['']      = __('Select clusters');
            foreach ($clusters as $value) {
                $cluster[$value->name] = $value->name;
            }
            $leaders           = FormLeader::all();
            $lead          = [];
            $lead['']      = __('Select leaders');
            foreach ($leaders as $value) {
                $lead[$value->name] = $value->name;
            }
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $form->start_tour)->format('d/m/Y');
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $form->end_tour)->format('d/m/Y');
            return view('form.buttonedit', compact('form', 'roles', 'GetformUser', 'formUser', 'formRole', 'getFormRole', 'next', 'previous', 'status','type', 'cat', 'cluster', 'lead', 'startDate', 'endDate'));
        } else {
            if (\Auth::user()->can('edit-form') && $formallowededit > 0) {
                $form           = Form::find($id);
                $next           = Form::where('id', '>', $form->id)->first();
                $previous       = Form::where('id', '<', $form->id)->orderBy('id', 'desc')->first();
                $roles          = Role::pluck('name', 'id');
                $formRole       = $form->assignedroles->pluck('id')->toArray();
                $getFormRole    = Role::pluck('name', 'id');
                $formUser       = $form->assignedusers->pluck('id')->toArray();
                $GetformUser    = User::where('id', '!=', 1)->pluck('name', 'id');
                $status         = FormStatus::where('status', 1)->pluck('name', 'id');
                $types           = FormType::where('name', 'Tour')->get();
                $type          = [];
                $type['']      = __('Select type');
                foreach ($types as $value) {
                    $type[$value->name] = $value->name;
                }
                $categories           = FormCategory::where('id', $userCat)->get();
                $cat          = [];
                $cat['']      = __('Select categories');
                foreach ($categories as $value) {
                    $cat[$value->name] = $value->name;
                }
                $clusters          = FormCluster::all();
                $cluster          = [];
                $cluster['']      = __('Select clusters');
                foreach ($clusters as $value) {
                    $cluster[$value->name] = $value->name;
                }
                $leaders           = FormLeader::all();
                $lead          = [];
                $lead['']      = __('Select leaders');
                foreach ($leaders as $value) {
                    $lead[$value->name] = $value->name;
                }
                $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $form->start_tour)->format('d/m/Y');
                $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $form->end_tour)->format('d/m/Y');
                return view('form.buttonedit', compact('form', 'getFormRole', 'GetformUser', 'formUser', 'formRole', 'next', 'previous', 'status', 'type', 'cat', 'cluster', 'lead', 'startDate', 'endDate'));
            } else {
                return redirect()->back()->with('failed', __('Permission denied.'));
            }
        }
    }
    public function fetchState(Request $request)
    {
        $data['states'] = State::where("country_id", $request->country_id)
                                ->get(["name", "id"]);
  
        return response()->json($data);
    }

    public function WidgetChnages(Request $request)
    {
        $widget = $request->widget;
        $form = Form::find($widget);
        $home = json_decode($form->json);
        $label = [];
        if (isset($home)) {
            foreach ($home as $hom) {
                foreach ($hom as $key => $var) {
                    if ($var->type == 'select' || $var->type == 'radio-group' || $var->type == 'date' || $var->type == 'checkbox-group' || $var->type == 'starRating') {
                        $label[$key] = $var;
                    }
                }
            }
        }
        return response()->json($label, 200);
    }

    public function WidgetChnagesC(Request $request)
    {
        $widget = $request->widget;
        $form = FormCategory::where("type_name", $widget)
        ->get(["name", "id"]);
        
        return response()->json($form, 200);
    }

    public function WidgetChnagesDestination(Request $request)
    {
        $widget = $request->widget;
        $form = FormDestination::where("categories_name", $widget)
        ->get(["id", "destination_name"]);
        
        return response()->json($form, 200);
    }

    public function WidgetChnagesCodetour(Request $request)
    {
        $widget = $request->widget;
        $form = FormDestination::where("destination_name", 'LIKE', $widget.'%' )
        ->get(["id", "code_tour", "tour_leader"]);
        
        return response()->json($form, 200);
    }

    public function WidgetChnagesTouleader(Request $request)
    {
        $widget = $request->widget;
        $form = FormDestination::where("code_tour", $widget)
        ->get(["id", "tour_leader", "tour_consultant"]);
        
        return response()->json($form, 200);
    }

    public function WidgetChnagesTouConsultant(Request $request)
    {
        $widget = $request->widget;
        $form = FormDestination::where("tour_leader", $widget)
        ->get(["id", "tour_consultant"]);
        
        return response()->json($form, 200);
    }

    public function WidgetChnagesForm(Request $request)
    {
        $widget = $request->widget;
        $form = Form::where("type", $widget)
        ->get(["id", "tour_leader_name", "tour_consultant"]);
        
        return response()->json($form, 200);
    }

    public function update(Request $request, Form $form)
    {
        if (\Auth::user()->can('edit-form')) {
            request()->validate([
                'title'       => 'required|max:191',
            ]);
            $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
            $cat           = FormCategory::where('name', $request->field_categories)->first();
            $clu = FormCluster::where('name', $request->field_destination)->first();
            $lea = FormLeader::where('name', $request->field_tourleader)->first();

            $form->title                = $request->title;
            $form->type                 = $request->type_id;
            $form->category             = $request->field_categories;
            $form->destination          = $request->field_destination;
            $form->code_tour            = $request->field_codetour;
            $form->tour_leader_name     = $request->field_tourleader;
            $form->number_participants  = $request->numberofpart;
            $form->start_tour           = $startDate;
            $form->end_tour             = $endDate;
            $form->created_by           = Auth::user()->id;
            $form->category_id           = $cat->id;
            $form->cluster_id           = $clu->id;
            $form->leader_id           = $lea->id;
            // $form->assign_type          = $request->assign_type;
            $form->save();
            // if ($request->assign_type == 'role') {
            //     $id = $form->id;
            //     AssignFormsUsers::where('form_id', $id)->delete();
            //     $form->assignRole($request->roles);
            // }
            // if ($request->assign_type == 'user') {
            //     $id = $form->id;
            //     AssignFormsRoles::where('form_id', $id)->delete();
            //     $form->assignUser($request->users);
            // }
            // if ($request->assign_type == 'public') {
            //     $id = $form->id;
            //     AssignFormsRoles::where('form_id', $id)->delete();
            //     AssignFormsUsers::where('form_id', $id)->delete();
            // }
            // $form->assignFormRoles($request->roles);
            
            return redirect()->route('forms.index')->with('success', __('Form updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy(Form $form)
    {
        if (\Auth::user()->can('delete-form')) {
            $comments       = FormComments::where('form_id', $form->id)->get();
            $commentsReply = FormCommentsReply::where('form_id', $form->id)->get();
            $formValues   = FormValue::where('form_id', $form->id)->get();
            DashboardWidget::where('form_id', $form->id)->delete();
            AssignFormsRoles::where('form_id', $form->id)->delete();
            AssignFormsUsers::where('form_id', $form->id)->delete();
            foreach ($comments as $allcomments) {
                $commentsids = $allcomments->id;
                $commentsall = FormComments::find($commentsids);
                if ($commentsall) {
                    $commentsall->delete();
                }
            }
            foreach ($commentsReply as $commentsReplyAll) {
                $commentsReplyIds = $commentsReplyAll->id;
                $reply =  FormCommentsReply::find($commentsReplyIds);
                if ($reply) {
                    $reply->delete();
                }
            }
            foreach ($formValues as  $formValue) {
                $formValue  = FormValue::find($formValue->id);
                if ($formValue) {
                    $formValue->delete();
                }
            }
            $form->delete();
            return redirect()->back()->with('success', __('Form deleted successfully'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function gridView($slug = '')
    {
        $usr                  = \Auth::user();
        $usr->forms_grid_view = ($slug) ? 1 : 0;
        $usr->save();
        if ($usr->forms_grid_view == 0) {
            return redirect()->route('forms.index');
        }

        $roleId    = $usr->roles->first()->id;
        $userId    = $usr->id;
        if ($usr->type == 1) {
            $forms = Form::all();
        } else {
            $forms = Form::where(function ($query) use ($roleId, $userId) {
                $query->whereIn('id', function ($query1) use ($roleId) {
                    $query1->select('form_id')->from('assign_forms_roles')->where('role_id', $roleId);
                })->OrWhereIn('id', function ($query1) use ($userId) {
                    $query1->select('form_id')->from('assign_forms_users')->where('user_id', $userId);
                });
            })->get();
        }

        return view('form.grid-view', compact('forms'));
    }

    public function design($id)
    {
        if (\Auth::user()->can('design-form')) {
            $form = Form::find($id);
            if ($form) {
                return view('form.design', compact('form'));
            } else {
                return redirect()->back()->with('failed', __('Form not found.'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }


    public function designUpdate(Request $request, $id)
    {
        if (\Auth::user()->can('design-form')) {
            $form           = Form::find($id);
            if ($form) {
                $form->json = $request->json;
                $fieldName = json_decode($request->json);
                $arr        = [];
                foreach ($fieldName[0] as $k => $fields) {
                    if ($fields->type == "header" || $fields->type == "paragraph") {
                        $arr[$k] = $fields->type;
                    } else {
                        $arr[$k] = $fields->name;
                    }
                }
                $value = DashboardWidget::where('form_id', $form->id)->pluck('field_name', 'id');
                foreach ($value  as $key => $v) {
                    if (!in_array($v, $arr)) {
                        DashboardWidget::find($key)->delete();
                    }
                }
                $form->save();
                return redirect()->route('forms.index')->with('success', __('Form updated successfully.'));
            } else {
                return redirect()->back()->with('failed', __('Form not found.'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function fill($id)
    {
        if (\Auth::user()->can('fill-form')) {
            $form       = Form::find($id);
            if ($form) {
                $array = $form->getFormArray();
                return view('form.fill', compact('form', 'array'));
            } else {
                return redirect()->back()->with('failed', __('Form not found'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function publicFill($id)
    {
        $hashids    = new Hashids('', 20);
        $id         = $hashids->decodeHex($id);
        if ($id) {
            $form       = Form::find($id);
            $tc           = TourConsultants::all();
            $dest          = FormCluster::all();
            $selectedOptions = ['dest 1', 'dest 3']; // Ini bisa dari database atau request

            $todayDate = Carbon::now()->toDateTimeString();
            if ($form) {
                if ($form->set_end_date != '0') {
                    if ($form->set_end_date_time && $form->set_end_date_time < $todayDate) {
                        abort('404');
                    }
                }
                $array = $form->getFormArray();
                return view('form.public-fill', compact('form', 'array', 'tc', 'dest', 'selectedOptions'));
            } else {
                return redirect()->back()->with('failed', __('Form not found.'));
            }
        } else {
            abort(404);
        }
    }

    public function qrCode($id)
    {
        $hashids  = new Hashids('', 20);
        $id       = $hashids->decodeHex($id);
        $form     = Form::find($id);
        $view     =  view('form.public-fill-qr', compact('form'));
        return ['html' => $view->render()];
    }

    public function fillStore(Request $request, $id)
    {
        $form       = Form::find($id);
        $formValue  = FormValue::where('form_id', $form->id)->count();
        $ipData = $request->input('ip_data');
        $ipDataArray = json_decode($ipData, true);
        $loc = explode(',', $ipDataArray['loc']);
        if ($form->limit_status == 1) {
            if ($form->limit > $formValue || $request->form_value_id != null) {
                if (UtilityFacades::getsettings('captcha_enable') == 'on') {
                    if (UtilityFacades::getsettings('captcha') == 'hcaptcha') {
                        if (empty($_POST['h-captcha-response'])) {
                            if (isset($request->ajax)) {
                                return response()->json(['is_success' => false, 'message' => __('Please check hcaptcha.')]);
                            } else {
                                return back()->with('failed', __('Please check hcaptcha.'));
                            }
                        }
                    }
                    if (UtilityFacades::getsettings('captcha') == 'recaptcha') {
                        if (empty($_POST['g-recaptcha-response'])) {
                            if (isset($request->ajax)) {
                                return response()->json(['is_success' => false, 'message' => __('Please check recaptcha.')]);
                            } else {
                                return back()->with('failed', __('Please check recaptcha.'));
                            }
                        }
                    }
                }
                if ($form) {

                    $clientEmails = [];
                    if ($request->form_value_id) {
                        $formValue = FormValue::find($request->form_value_id);
                        $array = json_decode($formValue->json);
                    } else {
                        $array = $form->getFormArray();
                    }
                    foreach ($array as  &$rows) {
                        foreach ($rows as &$row) {
                            if ($row->type == 'checkbox-group') {
                                foreach ($row->values as &$checkboxvalue) {
                                    if (is_array($request->{$row->name}) && in_array($checkboxvalue->value, $request->{$row->name})) {
                                        $checkboxvalue->selected = 1;
                                    } else {
                                        if (isset($checkboxvalue->selected)) {
                                            unset($checkboxvalue->selected);
                                        }
                                    }
                                }
                            } elseif ($row->type == 'file') {
                                if ($row->subtype == "fineuploader") {
                                    $fileSize = number_format($row->max_file_size_mb / 1073742848, 2);
                                    $fileLimit = $row->max_file_size_mb / 1024;
                                    if ($fileSize < $fileLimit) {
                                        $values = [];
                                        $value = explode(',', $request->input($row->name));
                                        foreach ($value as $file) {
                                            $values[] = $file;
                                        }
                                        $row->value = $values;
                                    } else {
                                        return response()->json(['is_success' => false, 'message' => __("Please upload maximum $row->max_file_size_mb MB file size.")], 200);
                                    }
                                } else {
                                    if ($row->file_extention == 'pdf') {
                                        $allowedFileExtension = ['pdf', 'pdfa', 'fdf', 'xdp', 'xfa', 'pdx', 'pdp', 'pdfxml', 'pdxox'];
                                    } else if ($row->file_extention == 'image') {
                                        $allowedFileExtension = ['jpeg', 'jpg', 'png'];
                                    } else if ($row->file_extention == 'excel') {
                                        $allowedFileExtension = ['xlsx', 'csv', 'xlsm', 'xltx', 'xlsb', 'xltm', 'xlw'];
                                    }
                                    $requiredextention = implode(',', $allowedFileExtension);
                                    $fileSize = number_format($row->max_file_size_mb / 1073742848, 2);
                                    $fileLimit = $row->max_file_size_mb / 1024;
                                    if ($fileSize < $fileLimit) {
                                        if ($row->multiple) {
                                            if ($request->hasFile($row->name)) {
                                                $values = [];
                                                $files = $request->file($row->name);
                                                foreach ($files as $file) {
                                                    $extension = $file->getClientOriginalExtension();
                                                    $check = in_array($extension, $allowedFileExtension);
                                                    if ($check) {
                                                        if ($extension == 'csv') {
                                                            $name = \Str::random(40) . '.' . $extension;
                                                            $file->move(storage_path() . '/app/form-values/' . $form->id, $name);
                                                            $values[] = 'form-values/' . $form->id . '/' . $name;
                                                        } else {
                                                            $path = Storage::path("form-values/$form->id");
                                                            $fileName = $file->store('form-values/' . $form->id);
                                                            if (!file_exists($path)) {
                                                                mkdir($path, 0777, true);
                                                                chmod($path, 0777);
                                                            }
                                                            if (!file_exists(Storage::path($fileName))) {
                                                                mkdir(Storage::path($fileName), 0777, true);
                                                                chmod(Storage::path($fileName), 0777);
                                                            }
                                                            $values[] = $fileName;
                                                        }
                                                    } else {
                                                        if (isset($request->ajax)) {
                                                            return response()->json(['is_success' => false, 'message' => __("Invalid file type, Please upload $requiredextention files")], 200);
                                                        } else {
                                                            return redirect()->back()->with('failed', __("Invalid file type, please upload $requiredextention files."));
                                                        }
                                                    }
                                                }
                                                $row->value = $values;
                                            }
                                        } else {
                                            if ($request->hasFile($row->name)) {
                                                $values = '';
                                                $file = $request->file($row->name);
                                                $extension = $file->getClientOriginalExtension();
                                                $check = in_array($extension, $allowedFileExtension);
                                                if ($check) {
                                                    if ($extension == 'csv') {
                                                        $name = \Str::random(40) . '.' . $extension;
                                                        $file->move(storage_path() . '/app/form-values/' . $form->id, $name);
                                                        $values = 'form-values/' . $form->id . '/' . $name;
                                                        chmod("$values", 0777);
                                                    } else {
                                                        $path = Storage::path("form-values/$form->id");
                                                        $fileName = $file->store('form-values/' . $form->id);
                                                        if (!file_exists($path)) {
                                                            mkdir($path, 0777, true);
                                                            chmod($path, 0777);
                                                        }
                                                        if (!file_exists(Storage::path($fileName))) {
                                                            mkdir(Storage::path($fileName), 0777, true);
                                                            chmod(Storage::path($fileName), 0777);
                                                        }
                                                        $values = $fileName;
                                                    }
                                                } else {
                                                    if (isset($request->ajax)) {
                                                        return response()->json(['is_success' => false, 'message' => __("Invalid file type, Please upload $requiredextention files")], 200);
                                                    } else {
                                                        return redirect()->back()->with('failed', __("Invalid file type, please upload $requiredextention files."));
                                                    }
                                                }
                                                $row->value = $values;
                                            }
                                        }
                                    } else {
                                        return response()->json(['is_success' => false, 'message' => __("Please upload maximum $row->max_file_size_mb MB file size.")], 200);
                                    }
                                }
                            } elseif ($row->type == 'radio-group') {
                                foreach ($row->values as &$radiovalue) {
                                    if ($radiovalue->value == $request->{$row->name}) {
                                        $radiovalue->selected = 1;
                                    } else {
                                        if (isset($radiovalue->selected)) {
                                            unset($radiovalue->selected);
                                        }
                                    }
                                }
                            } elseif ($row->type == 'autocomplete') {
                                if (isset($row->multiple)) {
                                    foreach ($row->values as &$autocompletevalue) {
                                        if (is_array($request->{$row->name}) && in_array($autocompletevalue->value, $request->{$row->name})) {
                                            $autocompletevalue->selected = 1;
                                        } else {
                                            if (isset($autocompletevalue->selected)) {
                                                unset($autocompletevalue->selected);
                                            }
                                        }
                                    }
                                } else {
                                    foreach ($row->values as &$autocompletevalue) {
                                        if ($autocompletevalue->value == $request->autocomplete) {
                                            $autocompletevalue->selected = 1;
                                        } else {
                                            if (isset($autocompletevalue->selected)) {
                                                unset($autocompletevalue->selected);
                                            }
                                            $row->value = $request->autocomplete;
                                        }
                                    }
                                }
                            } elseif ($row->type == 'select') {
                                if ($row->multiple) {
                                    foreach ($row->values as &$selectvalue) {
                                        if (is_array($request->{$row->name}) && in_array($selectvalue->value, $request->{$row->name})) {
                                            $selectvalue->selected = 1;
                                        } else {
                                            if (isset($selectvalue->selected)) {
                                                unset($selectvalue->selected);
                                            }
                                        }
                                    }
                                } else {
                                    foreach ($row->values as &$selectvalue) {
                                        if ($selectvalue->value == $request->{$row->name}) {
                                            $selectvalue->selected = 1;
                                        } else {
                                            if (isset($selectvalue->selected)) {
                                                unset($selectvalue->selected);
                                            }
                                        }
                                    }
                                }
                            } elseif ($row->type == 'date') {
                                $row->value = $request->{$row->name};
                            } elseif ($row->type == 'number') {
                                $row->value = $request->{$row->name};
                            } elseif ($row->type == 'textarea') {
                                $row->value = $request->{$row->name};
                            } elseif ($row->type == 'text') {
                                $clientEmail = '';
                                if ($row->subtype == 'email') {
                                    if (isset($row->is_client_email) && $row->is_client_email) {

                                        $clientEmails[] = $request->{$row->name};
                                    }
                                }
                                $row->value = $request->{$row->name};
                            } elseif ($row->type == 'starRating') {
                                $row->value = $request->{$row->name};
                            } elseif ($row->type == 'SignaturePad') {
                                if (property_exists($row, 'value')) {
                                    $filepath = $row->value;
                                    if ($request->{$row->name} == null) {
                                        $url = $row->value;
                                    } else {
                                        if (file_exists(Storage::path($request->{$row->name}))) {
                                            $url = $request->{$row->name};
                                            $path = $url;
                                            $imgUrl = Storage::path($url);
                                            $filePath = $imgUrl;
                                        } else {
                                            $imgUrl = $request->{$row->name};
                                            $path = "form-values/$form->id/" . rand(1, 1000) . '.png';
                                            $filePath = Storage::path($path);
                                        }
                                        $imageContent = file_get_contents($imgUrl);
                                        $file = file_put_contents($filePath, $imageContent);
                                    }
                                    $row->value = $path;
                                } else {
                                    if ($request->{$row->name} != null) {
                                        if (!file_exists(Storage::path("form-values/$form->id"))) {
                                            mkdir(Storage::path("form-values/$form->id"), 0777, true);
                                            chmod(Storage::path("form-values/$form->id"), 0777);
                                        }
                                        $filepath     = "form-values/$form->id/" . rand(1, 1000) . '.png';
                                        $url          = $request->{$row->name};
                                        $imageContent = file_get_contents($url);
                                        $filePath     = Storage::path($filepath);
                                        $file         = file_put_contents($filePath, $imageContent);
                                        $row->value   = $filepath;
                                    }
                                }
                            } elseif ($row->type == 'location') {
                                $row->value = $request->location;
                            } elseif ($row->type == 'video') {
                                $validator = \Validator::make($request->all(),  [
                                    'media' => 'required',
                                ]);
                                if ($validator->fails()) {
                                    $messages = $validator->errors();
                                }

                                $row->value = $request->media;
                            } elseif ($row->type == 'selfie') {
                                $file = '';
                                $img = $request->image;
                                $folderPath = "form_selfie/";

                                $imageParts = explode(";base64,", $img);

                                if ($imageParts[0]) {

                                    $imageBase64 = base64_decode($imageParts[1]);
                                    $fileName = uniqid() . '.png';

                                    $file = $folderPath . $fileName;
                                    Storage::put($file, $imageBase64);
                                }
                                $row->value  = $file;
                            } 
                        }
                    }

                    if ($request->form_value_id) {
                        $formValue->json = json_encode($array);
                        $formValue->submited_forms_ip          = $ipDataArray['ip'];
                        $formValue->submited_forms_country   = $ipDataArray['country'];
                        $formValue->submited_forms_region     = $ipDataArray['region'];
                        $formValue->submited_forms_city       = $ipDataArray['city'];
                        $formValue->submited_forms_latitude   = $loc[0];
                        $formValue->submited_forms_longitude  = $loc[1];
                        $formValue->save();
                    } else {
                        if (\Auth::user()) {
                            $userId = \Auth::user()->id;
                        } else {
                            $userId = NULL;
                        }
                        $data = [];
                        if ($form->payment_status == 1) {
                            if ($form->payment_type == 'stripe') {
                                StripeStripe::setApiKey(UtilityFacades::getsettings('STRIPE_SECRET', $form->created_by));
                                try {
                                    $charge = Charge::create([
                                        "amount"      => $form->amount * 100,
                                        "currency"    => $form->currency_name,
                                        "description" => "Payment from " . config('app.name'),
                                        "source"      => $request->input('stripeToken')
                                    ]);
                                } catch (Exception $e) {
                                    return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
                                }
                                if ($charge) {
                                    $data['transaction_id']  = $charge->id;
                                    $data['currency_symbol'] = $form->currency_symbol;
                                    $data['currency_name']   = $form->currency_name;
                                    $data['amount']          = $form->amount;
                                    $data['status']          = 'successfull';
                                    $data['payment_type']    = 'Stripe';
                                }
                            } else if ($form->payment_type == 'razorpay') {
                                $data['transaction_id']  = $request->payment_id;
                                $data['currency_symbol'] = $form->currency_symbol;
                                $data['currency_name']   = $form->currency_name;
                                $data['amount']          = $form->amount;
                                $data['status']          = 'successfull';
                                $data['payment_type']    = 'Razorpay';
                            } else if ($form->payment_type == 'paypal') {
                                $data['transaction_id']  = $request->payment_id;
                                $data['currency_symbol'] = $form->currency_symbol;
                                $data['currency_name']   = $form->currency_name;
                                $data['amount']          = $form->amount;
                                $data['status']          = 'successfull';
                                $data['payment_type']    = 'Paypal';
                            } else if ($form->payment_type == 'flutterwave') {
                                $data['transaction_id']  = $request->payment_id;
                                $data['currency_symbol'] = $form->currency_symbol;
                                $data['currency_name']   = $form->currency_name;
                                $data['amount']          = $form->amount;
                                $data['status']          = 'successfull';
                                $data['payment_type'] = 'Flutterwave';
                            } else if ($form->payment_type == 'paytm') {
                                $data['transaction_id']  = $request->payment_id;
                                $data['currency_symbol'] = $form->currency_symbol;
                                $data['currency_name']   = $form->currency_name;
                                $data['amount']          = $form->amount;
                                $data['status']          = 'pending';
                                $data['payment_type']    = 'Paytm';
                            } else if ($form->payment_type == 'paystack') {
                                $data['transaction_id']   = $request->payment_id;
                                $data['currency_symbol']  = $form->currency_symbol;
                                $data['currency_name']    = $form->currency_name;
                                $data['amount']           = $form->amount;
                                $data['status']           = 'successfull';
                                $data['payment_type'] = 'Paystack';
                            } else if ($form->payment_type == 'payumoney') {
                                $data['transaction_id']   = $request->payment_id;
                                $data['currency_symbol']  = $form->currency_symbol;
                                $data['currency_name']    = $form->currency_name;
                                $data['amount']           = $form->amount;
                                $data['status']           = 'successfull';
                                $data['payment_type'] = 'PayuMoney';
                            } else if ($form->payment_type == 'mollie') {
                                $data['transaction_id']   = $request->payment_id;
                                $data['currency_symbol']  = $form->currency_symbol;
                                $data['currency_name']    = $form->currency_name;
                                $data['amount']           = $form->amount;
                                $data['status']           = 'successfull';
                                $data['payment_type'] = 'Mollie';
                            } else if ($form->payment_type == 'coingate') {
                                $data['status'] = 'pending';
                            } else if ($form->payment_type == 'mercado') {
                                $data['status'] = 'pending';
                            } elseif ($form->payment_type == 'offlinepayment') {
                                $data['currency_symbol']  = $form->currency_symbol;
                                $data['currency_name']    = $form->currency_name;
                                $data['amount']           = $form->amount;
                                $data['payment_type']     = 'offlinepayment';

                                $request->validate(['transfer_slip' => 'required']);

                                if ($request->file('transfer_slip')) {
                                    $file = $request->file('transfer_slip');
                                    $filename = $file->store('transfer-slip');
                                    $data['transfer_slip'] = $filename;
                                }
                                if ($request->transfer_slip) {
                                    $data['status']       = 'successfull';
                                } else {
                                    $data['status']       = 'pending';
                                }
                            }
                        } else {
                            $data['status'] = 'free';
                        }

                        $data['form_id']                   = $form->id;
                        $data['user_id']                   = $userId;
                        $data['json']                      = json_encode($array);
                        $data['form_edit_lock_status']     = $form->form_fill_edit_lock;
                        $data['form_status']               = $form->form_status;

                        $data['submited_forms_ip']         = $ipDataArray['ip'];
                        $data['submited_forms_country']    = $ipDataArray['country'];
                        $data['submited_forms_region']     = $ipDataArray['region'];
                        $data['submited_forms_city']       = $ipDataArray['city'];
                        $data['submited_forms_latitude']   = $loc[0];
                        $data['submited_forms_longitude']  = $loc[1];
                        $formValue      = FormValue::create($data);

                    }
                    $formValueArray = json_decode($formValue->json);
                    $emails = explode(',', $form->email);
                    $ccemails = explode(',', $form->ccemail);
                    $bccemails = explode(',', $form->bccemail);
                    if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
                        if ($form->ccemail && $form->bccemail) {
                            try {
                                Mail::to($form->email)
                                    ->cc($form->ccemail)
                                    ->bcc($form->bccemail)
                                    ->send(new FormSubmitEmail($formValue, $formValueArray));
                            } catch (\Exception $e) {
                            }
                        } else if ($form->ccemail) {
                            try {
                                Mail::to($emails)
                                    ->cc($ccemails)
                                    ->send(new FormSubmitEmail($formValue, $formValueArray));
                            } catch (\Exception $e) {
                            }
                        } else if ($form->bccemail) {
                            try {
                                Mail::to($emails)
                                    ->bcc($bccemails)
                                    ->send(new FormSubmitEmail($formValue, $formValueArray));
                            } catch (\Exception $e) {
                            }
                        } else {
                            try {
                                Mail::to($emails)->send(new FormSubmitEmail($formValue, $formValueArray));
                            } catch (\Exception $e) {
                            }
                        }
                        foreach ($clientEmails as $clientEmail) {
                            try {
                                Mail::to($clientEmail)->send(new Thanksmail($formValue));
                            } catch (\Exception $e) {
                            }
                        }
                    }
                    $user = User::where('type', 'Admin')->first();
                    $notificationsSetting = NotificationsSetting::where('title', 'new survey details')->first();
                    if (isset($notificationsSetting)) {
                        if ($notificationsSetting->notify == '1') {
                            $user->notify(new NewSurveyDetails($form));
                        } elseif ($notificationsSetting->email_notification == '1') {
                            if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
                                if (MailTemplate::where('mailable', FormSubmitEmail::class)->first()) {
                                    try {
                                        Mail::to($formValue->email)->send(new FormSubmitEmail($formValue, $formValueArray));
                                    } catch (\Exception $e) {
                                    }
                                }
                            }
                        }
                    }
                    if ($form->payment_type != 'coingate' && $form->payment_type != 'mercado') {
                        $successMsg = strip_tags($form->success_msg);
                    }
                    if ($request->form_value_id) {
                        $successMsg = strip_tags($form->success_msg);
                    }

                    Form::integrationFormData($form, $formValue);
                    if (isset($request->ajax)) {
                        return response()->json(['is_success' => true, 'message' => $successMsg, 'redirect' => route('edit.form.values', $formValue->id)], 200);
                    } else {
                        return redirect()->back()->with('success', $successMsg);
                    }
                } else {
                    if (isset($request->ajax)) {
                        return response()->json(['is_success' => false, 'message' => __('Form not found')], 200);
                    } else {
                        return redirect()->back()->with('failed', __('Form not found.'));
                    }
                }
            } else {
                return response()->json(['is_success' => false, 'message' => __('Form submission limit  is over')], 200);
            }
        } else {
            if (UtilityFacades::getsettings('captcha_enable') == 'on') {
                if (UtilityFacades::getsettings('captcha') == 'hcaptcha') {
                    if (empty($_POST['h-captcha-response'])) {
                        if (isset($request->ajax)) {
                            return response()->json(['is_success' => false, 'message' => __('Please check hcaptcha.')]);
                        } else {
                            return back()->with('failed', __('Please check hcaptcha.'));
                        }
                    }
                }
                if (UtilityFacades::getsettings('captcha') == 'recaptcha') {
                    if (empty($_POST['g-recaptcha-response'])) {
                        if (isset($request->ajax)) {
                            return response()->json(['is_success' => false, 'message' => __('Please check recaptcha.')]);
                        } else {
                            return back()->with('failed', __('Please check recaptcha.'));
                        }
                    }
                }
            }
            if ($form) {
                $clientEmails = [];
                if ($request->form_value_id) {
                    $formValue = FormValue::find($request->form_value_id);
                    $array = json_decode($formValue->json);
                } else {
                    $array = $form->getFormArray();
                }
                foreach ($array as  &$rows) {
                    foreach ($rows as &$row) {
                        if ($row->type == 'checkbox-group') {
                            foreach ($row->values as &$checkboxvalue) {
                                if (is_array($request->{$row->name}) && in_array($checkboxvalue->value, $request->{$row->name})) {
                                    $checkboxvalue->selected = 1;
                                } else {
                                    if (isset($checkboxvalue->selected)) {
                                        unset($checkboxvalue->selected);
                                    }
                                }
                            }
                        } elseif ($row->type == 'file') {
                            if ($row->subtype == "fineuploader") {
                                $fileSize = number_format($row->max_file_size_mb / 1073742848, 2);
                                $fileLimit = $row->max_file_size_mb / 1024;
                                if ($fileSize < $fileLimit) {
                                    $values = [];
                                    $value = explode(',', $request->input($row->name));
                                    foreach ($value as $file) {
                                        $values[] = $file;
                                    }
                                    $row->value = $values;
                                } else {
                                    return response()->json(['is_success' => false, 'message' => __("Please upload maximum $row->max_file_size_mb MB file size.")], 200);
                                }
                            } else {
                                if ($row->file_extention == 'pdf') {
                                    $allowedFileExtension = ['pdf', 'pdfa', 'fdf', 'xdp', 'xfa', 'pdx', 'pdp', 'pdfxml', 'pdxox'];
                                } else if ($row->file_extention == 'image') {
                                    $allowedFileExtension = ['jpeg', 'jpg', 'png'];
                                } else if ($row->file_extention == 'excel') {
                                    $allowedFileExtension = ['xlsx', 'csv', 'xlsm', 'xltx', 'xlsb', 'xltm', 'xlw'];
                                }
                                $requiredextention = implode(',', $allowedFileExtension);
                                $fileSize = number_format($row->max_file_size_mb / 1073742848, 2);
                                $fileLimit = $row->max_file_size_mb / 1024;
                                if ($fileSize < $fileLimit) {
                                    if ($row->multiple) {
                                        if ($request->hasFile($row->name)) {
                                            $values = [];
                                            $files = $request->file($row->name);
                                            foreach ($files as $file) {
                                                $extension = $file->getClientOriginalExtension();
                                                $check = in_array($extension, $allowedFileExtension);
                                                if ($check) {
                                                    if ($extension == 'csv') {
                                                        $name = \Str::random(40) . '.' . $extension;
                                                        $file->move(storage_path() . '/app/form-values/' . $form->id, $name);
                                                        $values[] = 'form-values/' . $form->id . '/' . $name;
                                                    } else {
                                                        $path = Storage::path("form-values/$form->id");
                                                        $fileName = $file->store('form-values/' . $form->id);
                                                        if (!file_exists($path)) {
                                                            mkdir($path, 0777, true);
                                                            chmod($path, 0777);
                                                        }
                                                        if (!file_exists(Storage::path($fileName))) {
                                                            mkdir(Storage::path($fileName), 0777, true);
                                                            chmod(Storage::path($fileName), 0777);
                                                        }
                                                        $values[] = $fileName;
                                                    }
                                                } else {
                                                    if (isset($request->ajax)) {
                                                        return response()->json(['is_success' => false, 'message' => __("Invalid file type, Please upload $requiredextention files")], 200);
                                                    } else {
                                                        return redirect()->back()->with('failed', __("Invalid file type, please upload $requiredextention files."));
                                                    }
                                                }
                                            }
                                            $row->value = $values;
                                        }
                                    } else {
                                        if ($request->hasFile($row->name)) {
                                            $values = '';
                                            $file = $request->file($row->name);
                                            $extension = $file->getClientOriginalExtension();
                                            $check = in_array($extension, $allowedFileExtension);
                                            if ($check) {
                                                if ($extension == 'csv') {
                                                    $name = \Str::random(40) . '.' . $extension;
                                                    $file->move(storage_path() . '/app/form-values/' . $form->id, $name);
                                                    $values = 'form-values/' . $form->id . '/' . $name;
                                                    chmod("$values", 0777);
                                                } else {
                                                    $path = Storage::path("form-values/$form->id");
                                                    $fileName = $file->store('form-values/' . $form->id);
                                                    if (!file_exists($path)) {
                                                        mkdir($path, 0777, true);
                                                        chmod($path, 0777);
                                                    }
                                                    if (!file_exists(Storage::path($fileName))) {
                                                        mkdir(Storage::path($fileName), 0777, true);
                                                        chmod(Storage::path($fileName), 0777);
                                                    }
                                                    $values = $fileName;
                                                }
                                            } else {
                                                if (isset($request->ajax)) {
                                                    return response()->json(['is_success' => false, 'message' => __("Invalid file type, Please upload $requiredextention files")], 200);
                                                } else {
                                                    return redirect()->back()->with('failed', __("Invalid file type, please upload $requiredextention files."));
                                                }
                                            }
                                            $row->value = $values;
                                        }
                                    }
                                } else {
                                    return response()->json(['is_success' => false, 'message' => __("Please upload maximum $row->max_file_size_mb MB file size.")], 200);
                                }
                            }
                        } elseif ($row->type == 'radio-group') {
                            foreach ($row->values as &$radiovalue) {
                                if ($radiovalue->value == $request->{$row->name}) {
                                    $radiovalue->selected = 1;
                                    if($form->type == 'Tour'){
                                        if($radiovalue->value == 100){
                                            $formRule = new FormRule();
                                            $formRule->rule_name  = $radiovalue->value;
                                            $formRule->if_json  = $row->label;
                                            $formRule->form_id  = $form->id;
                                            $formRule->condition  = 1;
                                            $formRule->save();

                                            $formValueDetail = new FormValueDetail10();
                                            $formValueDetail->very_satisfied  = 1;
                                            $formValueDetail->satisfied  = 0;
                                            $formValueDetail->failry_satisfied  = 0;
                                            $formValueDetail->not_satisfied  = 0;
                                            $formValueDetail->label  = $row->label;
                                            $formValueDetail->form_values_id  = 1;
                                            $formValueDetail->status  = 1;
                                            $formValueDetail->save();
                                        }elseif($radiovalue->value == 75){
                                            $formRule = new FormRule();
                                            $formRule->rule_name  = $radiovalue->value;
                                            $formRule->if_json  = $row->label;
                                            $formRule->form_id  = $form->id;
                                            $formRule->condition  = 1;
                                            $formRule->save();

                                            $formValueDetail = new FormValueDetail10();
                                            $formValueDetail->very_satisfied  = 0;
                                            $formValueDetail->satisfied  = 1;
                                            $formValueDetail->failry_satisfied  = 0;
                                            $formValueDetail->not_satisfied  = 0;
                                            $formValueDetail->label  = $row->label;
                                            $formValueDetail->form_values_id  = 1;
                                            $formValueDetail->status  = 1;
                                            $formValueDetail->save();
                                        }elseif($radiovalue->value == 50){
                                            $formRule = new FormRule();
                                            $formRule->rule_name  = $radiovalue->value;
                                            $formRule->if_json  = $row->label;
                                            $formRule->form_id  = $form->id;
                                            $formRule->condition  = 1;
                                            $formRule->save();

                                            $formValueDetail = new FormValueDetail10();
                                            $formValueDetail->very_satisfied  = 0;
                                            $formValueDetail->satisfied  = 0;
                                            $formValueDetail->failry_satisfied  = 1;
                                            $formValueDetail->not_satisfied  = 0;
                                            $formValueDetail->label  = $row->label;
                                            $formValueDetail->form_values_id  = 1;
                                            $formValueDetail->status  = 1;
                                            $formValueDetail->save();
                                        }elseif($radiovalue->value == 25){
                                            $formRule = new FormRule();
                                            $formRule->rule_name  = $radiovalue->value;
                                            $formRule->if_json  = $row->label;
                                            $formRule->form_id  = $form->id;
                                            $formRule->condition  = 1;
                                            $formRule->save();

                                            $formValueDetail = new FormValueDetail10();
                                            $formValueDetail->very_satisfied  = 0;
                                            $formValueDetail->satisfied  = 0;
                                            $formValueDetail->failry_satisfied  = 0;
                                            $formValueDetail->not_satisfied  = 1;
                                            $formValueDetail->label  = $row->label;
                                            $formValueDetail->form_values_id  = 1;
                                            $formValueDetail->status  = 1;
                                            $formValueDetail->save();
                                        }
                                    }
                                        
                                } else {
                                    if (isset($radiovalue->selected)) {
                                        unset($radiovalue->selected);
                                    }
                                }
                            }
                        } elseif ($row->type == 'autocomplete') {
                            if (isset($row->multiple)) {
                                foreach ($row->values as &$autocompletevalue) {
                                    if (is_array($request->{$row->name}) && in_array($autocompletevalue->value, $request->{$row->name})) {
                                        $autocompletevalue->selected = 1;
                                    } else {
                                        if (isset($autocompletevalue->selected)) {
                                            unset($autocompletevalue->selected);
                                        }
                                    }
                                }
                            } else {
                                foreach ($row->values as &$autocompletevalue) {
                                    if ($autocompletevalue->value == $request->autocomplete) {
                                        $autocompletevalue->selected = 1;
                                    } else {
                                        if (isset($autocompletevalue->selected)) {
                                            unset($autocompletevalue->selected);
                                        }
                                        $row->value = $request->autocomplete;
                                    }
                                }
                            }
                        } elseif ($row->type == 'select') {
                            if ($row->multiple) {
                                foreach ($row->values as &$selectvalue) {
                                    if (is_array($request->{$row->name}) && in_array($selectvalue->value, $request->{$row->name})) {
                                        $selectvalue->selected = 1;
                                    } else {
                                        if (isset($selectvalue->selected)) {
                                            unset($selectvalue->selected);
                                        }
                                    }
                                }
                            } else {
                                foreach ($row->values as &$selectvalue) {
                                    if ($selectvalue->value == $request->{$row->name}) {
                                        $selectvalue->selected = 1;
                                    } else {
                                        if (isset($selectvalue->selected)) {
                                            unset($selectvalue->selected);
                                        }
                                    }
                                }
                            }
                        } elseif ($row->type == 'date') {
                            $row->value = $request->{$row->name};
                        } elseif ($row->type == 'number') {
                            $row->value = $request->{$row->name};
                        } elseif ($row->type == 'textarea') {
                            $row->value = $request->{$row->name};
                        } elseif ($row->type == 'text') {
                            $clientEmail = '';
                            if ($row->subtype == 'email') {
                                if (isset($row->is_client_email) && $row->is_client_email) {

                                    $clientEmails[] = $request->{$row->name};
                                }
                            }
                            $row->value = $request->{$row->name};
                        } elseif ($row->type == 'starRating') {
                            $row->value = $request->{$row->name};
                        } elseif ($row->type == 'SignaturePad') {
                            if (property_exists($row, 'value')) {
                                $filepath = $row->value;
                                if ($request->{$row->name} == null) {
                                    $url = $row->value;
                                } else {
                                    if (file_exists(Storage::path($request->{$row->name}))) {
                                        $url = $request->{$row->name};
                                        $path = $url;
                                        $imgUrl = Storage::path($url);
                                        $filePath = $imgUrl;
                                    } else {
                                        $imgUrl = $request->{$row->name};
                                        $path = "form-values/$form->id/" . rand(1, 1000) . '.png';
                                        $filePath = Storage::path($path);
                                    }
                                    $imageContent = file_get_contents($imgUrl);
                                    $file = file_put_contents($filePath, $imageContent);
                                }
                                $row->value = $path;
                            } else {
                                if ($request->{$row->name} != null) {
                                    if (!file_exists(Storage::path("form-values/$form->id"))) {
                                        mkdir(Storage::path("form-values/$form->id"), 0777, true);
                                        chmod(Storage::path("form-values/$form->id"), 0777);
                                    }
                                    $filepath     = "form-values/$form->id/" . rand(1, 1000) . '.png';
                                    $url          = $request->{$row->name};
                                    $imageContent = file_get_contents($url);
                                    $filePath     = Storage::path($filepath);
                                    $file         = file_put_contents($filePath, $imageContent);
                                    $row->value   = $filepath;
                                }
                            }
                        } elseif ($row->type == 'location') {
                            $row->value = $request->location;
                        } elseif ($row->type == 'video') {
                            $validator = \Validator::make($request->all(),  [
                                'media' => 'required',
                            ]);
                            if ($validator->fails()) {
                                $messages = $validator->errors();
                            }

                            $row->value = $request->media;
                        } elseif ($row->type == 'selfie') {
                            $file = '';
                            $img = $request->image;
                            $folderPath = "form_selfie/";

                            $imageParts = explode(";base64,", $img);

                            if ($imageParts[0]) {

                                $imageBase64 = base64_decode($imageParts[1]);
                                $fileName = uniqid() . '.png';

                                $file = $folderPath . $fileName;
                                Storage::put($file, $imageBase64);
                            }
                            $row->value  = $file;
                        } elseif($row->type == 'break'){
                            $test = [];
                            $test= $request->{$row->name};
                        }
                    }
                }

                if ($form->type != 'Tour') {
                    $ok = [];
                    $ok['form_id']  = $form->id;
                    $ok['status']  = '1';
                    $ok['tour_consultant']  = $request->lead;
                    foreach ($array as  &$rows) {
                        foreach ($rows as &$row) {
                            if ($row->type == 'checkbox-group') {
                                foreach ($row->values as &$checkboxvalue) {
                                    if (is_array($request->{$row->name}) && in_array($checkboxvalue->value, $request->{$row->name})) {
                                        $checkboxvalue->selected = 1;
                                    } else {
                                        if (isset($checkboxvalue->selected)) {
                                            unset($checkboxvalue->selected);
                                        }
                                    }
                                }
                            } elseif ($row->type == 'file') {
                                if ($row->subtype == "fineuploader") {
                                    $fileSize = number_format($row->max_file_size_mb / 1073742848, 2);
                                    $fileLimit = $row->max_file_size_mb / 1024;
                                    if ($fileSize < $fileLimit) {
                                        $values = [];
                                        $value = explode(',', $request->input($row->name));
                                        foreach ($value as $file) {
                                            $values[] = $file;
                                        }
                                        $row->value = $values;
                                    } else {
                                        return response()->json(['is_success' => false, 'message' => __("Please upload maximum $row->max_file_size_mb MB file size.")], 200);
                                    }
                                } else {
                                    if ($row->file_extention == 'pdf') {
                                        $allowedFileExtension = ['pdf', 'pdfa', 'fdf', 'xdp', 'xfa', 'pdx', 'pdp', 'pdfxml', 'pdxox'];
                                    } else if ($row->file_extention == 'image') {
                                        $allowedFileExtension = ['jpeg', 'jpg', 'png'];
                                    } else if ($row->file_extention == 'excel') {
                                        $allowedFileExtension = ['xlsx', 'csv', 'xlsm', 'xltx', 'xlsb', 'xltm', 'xlw'];
                                    }
                                    $requiredextention = implode(',', $allowedFileExtension);
                                    $fileSize = number_format($row->max_file_size_mb / 1073742848, 2);
                                    $fileLimit = $row->max_file_size_mb / 1024;
                                    if ($fileSize < $fileLimit) {
                                        if ($row->multiple) {
                                            if ($request->hasFile($row->name)) {
                                                $values = [];
                                                $files = $request->file($row->name);
                                                foreach ($files as $file) {
                                                    $extension = $file->getClientOriginalExtension();
                                                    $check = in_array($extension, $allowedFileExtension);
                                                    if ($check) {
                                                        if ($extension == 'csv') {
                                                            $name = \Str::random(40) . '.' . $extension;
                                                            $file->move(storage_path() . '/app/form-values/' . $form->id, $name);
                                                            $values[] = 'form-values/' . $form->id . '/' . $name;
                                                        } else {
                                                            $path = Storage::path("form-values/$form->id");
                                                            $fileName = $file->store('form-values/' . $form->id);
                                                            if (!file_exists($path)) {
                                                                mkdir($path, 0777, true);
                                                                chmod($path, 0777);
                                                            }
                                                            if (!file_exists(Storage::path($fileName))) {
                                                                mkdir(Storage::path($fileName), 0777, true);
                                                                chmod(Storage::path($fileName), 0777);
                                                            }
                                                            $values[] = $fileName;
                                                        }
                                                    } else {
                                                        if (isset($request->ajax)) {
                                                            return response()->json(['is_success' => false, 'message' => __("Invalid file type, Please upload $requiredextention files")], 200);
                                                        } else {
                                                            return redirect()->back()->with('failed', __("Invalid file type, please upload $requiredextention files."));
                                                        }
                                                    }
                                                }
                                                $row->value = $values;
                                            }
                                        } else {
                                            if ($request->hasFile($row->name)) {
                                                $values = '';
                                                $file = $request->file($row->name);
                                                $extension = $file->getClientOriginalExtension();
                                                $check = in_array($extension, $allowedFileExtension);
                                                if ($check) {
                                                    if ($extension == 'csv') {
                                                        $name = \Str::random(40) . '.' . $extension;
                                                        $file->move(storage_path() . '/app/form-values/' . $form->id, $name);
                                                        $values = 'form-values/' . $form->id . '/' . $name;
                                                        chmod("$values", 0777);
                                                    } else {
                                                        $path = Storage::path("form-values/$form->id");
                                                        $fileName = $file->store('form-values/' . $form->id);
                                                        if (!file_exists($path)) {
                                                            mkdir($path, 0777, true);
                                                            chmod($path, 0777);
                                                        }
                                                        if (!file_exists(Storage::path($fileName))) {
                                                            mkdir(Storage::path($fileName), 0777, true);
                                                            chmod(Storage::path($fileName), 0777);
                                                        }
                                                        $values = $fileName;
                                                    }
                                                } else {
                                                    if (isset($request->ajax)) {
                                                        return response()->json(['is_success' => false, 'message' => __("Invalid file type, Please upload $requiredextention files")], 200);
                                                    } else {
                                                        return redirect()->back()->with('failed', __("Invalid file type, please upload $requiredextention files."));
                                                    }
                                                }
                                                $row->value = $values;
                                            }
                                        }
                                    } else {
                                        return response()->json(['is_success' => false, 'message' => __("Please upload maximum $row->max_file_size_mb MB file size.")], 200);
                                    }
                                }
                            } elseif ($row->type == 'radio-group') {
                                foreach ($row->values as &$radiovalue) {
                                    if ($radiovalue->value == $request->{$row->name}) {
                                        $radiovalue->selected = 1;
                                            if($radiovalue->value == 100){
                                            $ok['rate_value'] = $radiovalue->value;
                                            $ok['rate_label'] = $radiovalue->label;

                                                $formValueDetail = new FormValueDetailReportcos();
                                                $formValueDetail->very_satisfied  = 1;
                                                $formValueDetail->satisfied  = 0;
                                                $formValueDetail->failry_satisfied  = 0;
                                                $formValueDetail->not_satisfied  = 0;
                                                $formValueDetail->label  = $row->label;
                                                $formValueDetail->form_values_id  = 1;
                                                $formValueDetail->status  = 1;
                                                $formValueDetail['tc']  = $request->lead;
                                                $formValueDetail->save();
                                            }elseif($radiovalue->value == 75){
                                                $ok['rate_value'] = $radiovalue->value;
                                                $ok['rate_label'] = $radiovalue->label;

                                                $formValueDetail = new FormValueDetailReportcos();
                                                $formValueDetail->very_satisfied  = 0;
                                                $formValueDetail->satisfied  = 1;
                                                $formValueDetail->failry_satisfied  = 0;
                                                $formValueDetail->not_satisfied  = 0;
                                                $formValueDetail->label  = $row->label;
                                                $formValueDetail->form_values_id  = 1;
                                                $formValueDetail->status  = 1;
                                                $formValueDetail['tc']  = $request->lead;
                                                $formValueDetail->save();
                                            }elseif($radiovalue->value == 50){
                                                $ok['rate_value'] = $radiovalue->value;
                                                $ok['rate_label'] = $radiovalue->label;

                                                $formValueDetail = new FormValueDetailReportcos();
                                                $formValueDetail->very_satisfied  = 0;
                                                $formValueDetail->satisfied  = 0;
                                                $formValueDetail->failry_satisfied  = 1;
                                                $formValueDetail->not_satisfied  = 0;
                                                $formValueDetail->label  = $row->label;
                                                $formValueDetail->form_values_id  = 1;
                                                $formValueDetail->status  = 1;
                                                $formValueDetail['tc']  = $request->lead;
                                                $formValueDetail->save();
                                            }elseif($radiovalue->value == 25){
                                                $ok['rate_value'] = $radiovalue->value;
                                                $ok['rate_label'] = $radiovalue->label;

                                                $formValueDetail = new FormValueDetailReportcos();
                                                $formValueDetail->very_satisfied  = 0;
                                                $formValueDetail->satisfied  = 0;
                                                $formValueDetail->failry_satisfied  = 0;
                                                $formValueDetail->not_satisfied  = 1;
                                                $formValueDetail->label  = $row->label;
                                                $formValueDetail->form_values_id  = 1;
                                                $formValueDetail->status  = 1;
                                                $formValueDetail['tc']  = $request->lead;
                                                $formValueDetail->save();
                                            }
                                    } else {
                                        if (isset($radiovalue->selected)) {
                                            unset($radiovalue->selected);
                                        }
                                    }
                                }
                            } elseif ($row->type == 'select') {
                                foreach ($row->values as &$radiovalue) {
                                    if ($radiovalue->value == $request->{$row->name}) {
                                        $radiovalue->selected = 1;
                                    } else {
                                        if (isset($radiovalue->selected)) {
                                            unset($radiovalue->selected);
                                        }
                                    }
                                }
                            } elseif ($row->type == 'autocomplete') {
                                if (isset($row->multiple)) {
                                    foreach ($row->values as &$autocompletevalue) {
                                        if (is_array($request->{$row->name}) && in_array($autocompletevalue->value, $request->{$row->name})) {
                                            $autocompletevalue->selected = 1;
                                        } else {
                                            if (isset($autocompletevalue->selected)) {
                                                unset($autocompletevalue->selected);
                                            }
                                        }
                                    }
                                } else {
                                    foreach ($row->values as &$autocompletevalue) {
                                        if ($autocompletevalue->value == $request->autocomplete) {
                                            $autocompletevalue->selected = 1;
                                        } else {
                                            if (isset($autocompletevalue->selected)) {
                                                unset($autocompletevalue->selected);
                                            }
                                            $row->value = $request->autocomplete;
                                        }
                                    }
                                }
                            } elseif ($row->label == 'Full Name') {
                                $ok['full_name'] = $request->{$row->name};
                            } elseif ($row->label == 'Email Address') {
                                $ok['email'] = $request->{$row->name};
                            } elseif ($row->label == 'Company Name') {
                                $ok['company_name'] = $request->{$row->name};
                            } elseif ($row->label == 'Date') {
                                $ok['date'] = $request->{$row->name};        
                            } elseif ($row->label == 'Please tell us your suggestions/complaint/compliment of our services') {
                                $ok['comment'] = $request->{$row->name};
                            } 
                        }
                    }
                    $oke    = formValuesReportcos::create($ok);
                    $valueDetailUpdateReportcos = FormValueDetailReportcos::where("form_values_id", 1)->update(["form_values_id" => $oke->id]);

                }

                if ($request->form_value_id) {
                    $formValue->json = json_encode($array);
                    $formValue->submited_forms_ip          = $ipDataArray['ip'];
                    $formValue->submited_forms_country   = $ipDataArray['country'];
                    $formValue->submited_forms_region     = $ipDataArray['region'];
                    $formValue->submited_forms_city       = $ipDataArray['city'];
                    $formValue->submited_forms_latitude   = $loc[0];
                    $formValue->submited_forms_longitude  = $loc[1];
                    $formValue->destinationcust  = $test;

                    $formValue->save();

                } else {
                    if (\Auth::user()) {
                        $userId = \Auth::user()->id;
                    } else {
                        $userId = NULL;
                    }
                    $data = [];
                    if ($form->payment_status == 1) {
                        if ($form->payment_type == 'stripe') {
                            StripeStripe::setApiKey(UtilityFacades::getsettings('STRIPE_SECRET', $form->created_by));
                            try {
                                $charge = Charge::create([
                                    "amount"      => $form->amount * 100,
                                    "currency"    => $form->currency_name,
                                    "description" => "Payment from " . config('app.name'),
                                    "source"      => $request->input('stripeToken')
                                ]);
                            } catch (Exception $e) {
                                return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
                            }
                            if ($charge) {
                                $data['transaction_id']  = $charge->id;
                                $data['currency_symbol'] = $form->currency_symbol;
                                $data['currency_name']   = $form->currency_name;
                                $data['amount']          = $form->amount;
                                $data['status']          = 'successfull';
                                $data['payment_type']    = 'Stripe';
                            }
                        } else if ($form->payment_type == 'razorpay') {
                            $data['transaction_id']  = $request->payment_id;
                            $data['currency_symbol'] = $form->currency_symbol;
                            $data['currency_name']   = $form->currency_name;
                            $data['amount']          = $form->amount;
                            $data['status']          = 'successfull';
                            $data['payment_type']    = 'Razorpay';
                        } else if ($form->payment_type == 'paypal') {
                            $data['transaction_id']  = $request->payment_id;
                            $data['currency_symbol'] = $form->currency_symbol;
                            $data['currency_name']   = $form->currency_name;
                            $data['amount']          = $form->amount;
                            $data['status']          = 'successfull';
                            $data['payment_type']    = 'Paypal';
                        } else if ($form->payment_type == 'flutterwave') {
                            $data['transaction_id']  = $request->payment_id;
                            $data['currency_symbol'] = $form->currency_symbol;
                            $data['currency_name']   = $form->currency_name;
                            $data['amount']          = $form->amount;
                            $data['status']          = 'successfull';
                            $data['payment_type'] = 'Flutterwave';
                        } else if ($form->payment_type == 'paytm') {
                            $data['transaction_id']  = $request->payment_id;
                            $data['currency_symbol'] = $form->currency_symbol;
                            $data['currency_name']   = $form->currency_name;
                            $data['amount']          = $form->amount;
                            $data['status']          = 'pending';
                            $data['payment_type']    = 'Paytm';
                        } else if ($form->payment_type == 'paystack') {
                            $data['transaction_id']   = $request->payment_id;
                            $data['currency_symbol']  = $form->currency_symbol;
                            $data['currency_name']    = $form->currency_name;
                            $data['amount']           = $form->amount;
                            $data['status']           = 'successfull';
                            $data['payment_type'] = 'Paystack';
                        } else if ($form->payment_type == 'payumoney') {
                            $data['transaction_id']   = $request->payment_id;
                            $data['currency_symbol']  = $form->currency_symbol;
                            $data['currency_name']    = $form->currency_name;
                            $data['amount']           = $form->amount;
                            $data['status']           = 'successfull';
                            $data['payment_type'] = 'PayuMoney';
                        } else if ($form->payment_type == 'mollie') {
                            $data['transaction_id']   = $request->payment_id;
                            $data['currency_symbol']  = $form->currency_symbol;
                            $data['currency_name']    = $form->currency_name;
                            $data['amount']           = $form->amount;
                            $data['status']           = 'successfull';
                            $data['payment_type'] = 'Mollie';
                        } else if ($form->payment_type == 'coingate') {
                            $data['status'] = 'pending';
                        } else if ($form->payment_type == 'mercado') {
                            $data['status'] = 'pending';
                        } elseif ($form->payment_type == 'offlinepayment') {
                            $data['currency_symbol']  = $form->currency_symbol;
                            $data['currency_name']    = $form->currency_name;
                            $data['amount']           = $form->amount;
                            $data['payment_type']     = 'offlinepayment';

                            $request->validate(['transfer_slip' => 'required']);

                            if ($request->file('transfer_slip')) {
                                $file = $request->file('transfer_slip');
                                $filename = $file->store('transfer-slip');
                                $data['transfer_slip'] = $filename;
                            }
                            if ($request->transfer_slip) {
                                $data['status']        = 'successfull';
                            } else {
                                $data['status']        = 'pending';
                            }
                        }
                    } else {
                        $data['status'] = 'NEW COMMENT';
                    }

                    $data['form_id']                = $form->id;
                    $data['user_id']                = $userId;
                    $data['json']                   = json_encode($array);
                    $data['form_edit_lock_status']  = $form->form_fill_edit_lock;
                    $data['form_status']            = 4;
                    $data['submited_forms_ip']         = $ipDataArray['ip'];
                    $data['submited_forms_country']    = $ipDataArray['country'];
                    $data['submited_forms_region']     = $ipDataArray['region'];
                    $data['submited_forms_city']       = $ipDataArray['city'];
                    $data['submited_forms_latitude']   = $loc[0];
                    $data['submited_forms_longitude']  = $loc[1];
                    $data['destinationcust'] = $request->desti;

                    $formValue    = FormValue::create($data);
                    $ruleUpdate = formRule::where("condition", 1)->update(["condition" => $formValue->id]);
                    $ruleDelete = formRule::where("rule_name", [1,0]);
                    $ruleDelete->delete();
                    $valueDetaialUpdate = FormValueDetail10::where("form_values_id", 1)->update(["form_values_id" => $formValue->id]);


                }
                $formValueArray = json_decode($formValue->json);
                $emails = explode(',', $form->email);
                $ccemails = explode(',', $form->ccemail);
                $bccemails = explode(',', $form->bccemail);
                if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
                    if ($form->ccemail && $form->bccemail) {
                        try {
                            Mail::to($form->email)
                                ->cc($form->ccemail)
                                ->bcc($form->bccemail)
                                ->send(new FormSubmitEmail($formValue, $formValueArray));
                        } catch (\Exception $e) {
                        }
                    } else if ($form->ccemail) {
                        try {
                            Mail::to($emails)
                                ->cc($ccemails)
                                ->send(new FormSubmitEmail($formValue, $formValueArray));
                        } catch (\Exception $e) {
                        }
                    } else if ($form->bccemail) {
                        try {
                            Mail::to($emails)
                                ->bcc($bccemails)
                                ->send(new FormSubmitEmail($formValue, $formValueArray));
                        } catch (\Exception $e) {
                        }
                    } else {
                        try {
                            Mail::to($emails)->send(new FormSubmitEmail($formValue, $formValueArray));
                        } catch (\Exception $e) {
                        }
                    }
                    foreach ($clientEmails as $clientEmail) {
                        try {
                            Mail::to($clientEmail)->send(new Thanksmail($formValue));
                        } catch (\Exception $e) {
                        }
                    }
                }

                $user = User::where('type', 'Super Admin')->first();
                $notificationsSetting = NotificationsSetting::where('title', 'new survey details')->first();
                // if (isset($notificationsSetting)) {
                //     if ($notificationsSetting->notify == '1') {
                //         $user->notify(new NewSurveyDetails($form));
                //     } elseif ($notificationsSetting->email_notification == '1') {
                //         if (UtilityFacades::getsettings('email_setting_enable') == 'on') {
                //             if (MailTemplate::where('mailable', FormSubmitEmail::class)->first()) {
                //                 try {
                //                     Mail::to($formValue->email)->send(new FormSubmitEmail($formValue, $formValueArray));
                //                 } catch (\Exception $e) {
                //                 }
                //             }
                //         }
                //     }
                // }
                if ($form->payment_type != 'coingate' && $form->payment_type != 'mercado') {
                    $successMsg = strip_tags($form->success_msg);
                }
                if ($request->form_value_id) {
                    $successMsg = strip_tags($form->success_msg);
                }

                Form::integrationFormData($form, $formValue);

                if (isset($request->ajax)) {
                    return response()->json(['is_success' => true, 'message' => $successMsg, 'redirect' => route('edit.form.values', $formValue->id)], 200);
                } else {
                    return redirect()->back()->with('success', $successMsg);
                }
            } else {
                if (isset($request->ajax)) {
                    return response()->json(['is_success' => false, 'message' => __('Form not found')], 200);
                } else {
                    return redirect()->back()->with('failed', __('Form not found.'));
                }
            }
        }
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $fileName           = $request->upload->store('editor');
            $CKEditorFuncNum    = $request->input('CKEditorFuncNum');
            $url                = Storage::url($fileName);
            $msg                = 'Image uploaded successfully';
            $response           = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

    public function duplicate(Request $request)
    {
        if (\Auth::user()->can('duplicate-form')) {
            $request->validate([
                'form_id' => 'required|exists:forms,id',
            ]);
            try {
                $originalForm = Form::findOrFail($request->form_id);
                $newForm = $originalForm->replicate();
                $newForm->title = $originalForm->title . ' (copy)';
                $newForm->created_by = Auth::id();
                $newForm->save();
                return redirect()->back()->with('success', __('Form duplicated successfully.'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', __('Failed to duplicate form. Please try again.'));
            }
        } else {
            return redirect()->back()->with('errors', __('Permission denied.'));
        }
    }

    public function ckupload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName         = $request->file('upload')->getClientOriginalName();
            $fileName           = pathinfo($originName, PATHINFO_FILENAME);
            $extension          = $request->file('upload')->getClientOriginalExtension();
            $fileName           = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('images'), $fileName);
            $CKEditorFuncNum    = $request->input('CKEditorFuncNum');
            $url                = asset('images/' . $fileName);
            $msg                = __('Image uploaded successfully');
            $response           = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

    public function dropzone(Request $request, $id)
    {
        $allowedfileExtension   = [];
        $values                 = '';
        if ($request->file_extention == 'pdf') {
            $allowedfileExtension = ['pdf', 'pdfa', 'fdf', 'xdp', 'xfa', 'pdx', 'pdp', 'pdfxml', 'pdxox'];
        } else if ($request->file_extention == 'image') {
            $allowedfileExtension = ['jpeg', 'jpg', 'png'];
        } else if ($request->file_extention == 'excel') {
            $allowedfileExtension = ['xlsx', 'csv', 'xlsm', 'xltx', 'xlsb', 'xltm', 'xlw'];
        }
        if ($request->hasFile('file')) {
            $file         = $request->file('file');
            $extension    = $file->getClientOriginalExtension();
            if (in_array($extension, $allowedfileExtension)) {
                $filename = $file->store('form-values/' . $id);
                $values   = $filename;
            } else {
                return response()->json(['errors' => 'Only ' . implode(',', $allowedfileExtension) . ' file allowed']);
            }
            return response()->json(['success' => 'File uploded successfully.', 'filename' => $values]);
        } else {
            return response()->json(['errors' => 'File not found.']);
        }
    }

    public function formStatus(Request $request, $id)
    {
        $form   = Form::find($id);
        $input  = ($request->value == "true") ? 1 : 0;
        if ($form) {
            $form->is_active = $input;
            $form->save();
        }
        return response()->json(['is_success' => true, 'message' => __('Form status changed successfully.')]);
    }

    public function formIntegration($id)
    {
        $form           = Form::find($id);
        $formJsons      = json_decode($form->json);
        $slackSettings  = FormIntegrationSetting::where('key', 'slack_integration')->where('form_id', $form->id)->first();
        $slackJsons     = [];
        $slackFieldJsons = [];
        if ($slackSettings) {
            $slackFieldJsons = json_decode($slackSettings->field_json, true);
            $slackJsons      = json_decode($slackSettings->json, true);
        }
        $telegramSettings   = FormIntegrationSetting::where('key', 'telegram_integration')->where('form_id', $form->id)->first();
        $telegramJsons      = [];
        $telegramFieldJsons = [];
        if ($telegramSettings) {
            $telegramFieldJsons = json_decode($telegramSettings->field_json, true);
            $telegramJsons      = json_decode($telegramSettings->json, true);
        }
        $mailgunSettings    = FormIntegrationSetting::where('key', 'mailgun_integration')->where('form_id', $form->id)->first();
        $mailgunJsons       = [];
        $mailgunFieldJsons  = [];
        if ($mailgunSettings) {
            $mailgunFieldJsons = json_decode($mailgunSettings->field_json, true);
            $mailgunJsons      = json_decode($mailgunSettings->json, true);
        }
        $bulkgateSettings   = FormIntegrationSetting::where('key', 'bulkgate_integration')->where('form_id', $form->id)->first();
        $bulkgateJsons      = [];
        $bulkgateFieldJsons = [];
        if ($bulkgateSettings) {
            $bulkgateFieldJsons = json_decode($bulkgateSettings->field_json, true);
            $bulkgateJsons      = json_decode($bulkgateSettings->json, true);
        }
        $nexmoSettings      = FormIntegrationSetting::where('key', 'nexmo_integration')->where('form_id', $form->id)->first();
        $nexmoJsons         = [];
        $nexmoFieldJsons    = [];
        if ($nexmoSettings) {
            $nexmoFieldJsons = json_decode($nexmoSettings->field_json, true);
            $nexmoJsons      = json_decode($nexmoSettings->json, true);
        }
        $fast2smsSettings   = FormIntegrationSetting::where('key', 'fast2sms_integration')->where('form_id', $form->id)->first();
        $fast2smsJsons      = [];
        $fast2smsFieldJsons = [];
        if ($fast2smsSettings) {
            $fast2smsFieldJsons = json_decode($fast2smsSettings->field_json, true);
            $fast2smsJsons      = json_decode($fast2smsSettings->json, true);
        }
        $vonageSettings     = FormIntegrationSetting::where('key', 'vonage_integration')->where('form_id', $form->id)->first();
        $vonageJsons        = [];
        $vonageFieldJsons   = [];
        if ($vonageSettings) {
            $vonageFieldJsons = json_decode($vonageSettings->field_json, true);
            $vonageJsons      = json_decode($vonageSettings->json, true);
        }
        $sendgridSettings   = FormIntegrationSetting::where('key', 'sendgrid_integration')->where('form_id', $form->id)->first();
        $sendgridJsons      = [];
        $sendgridFieldJsons = [];
        if ($sendgridSettings) {
            $sendgridFieldJsons = json_decode($sendgridSettings->field_json, true);
            $sendgridJsons      = json_decode($sendgridSettings->json, true);
        }
        $twilioSettings     = FormIntegrationSetting::where('key', 'twilio_integration')->where('form_id', $form->id)->first();
        $twilioJsons        = [];
        $twilioFieldJsons   = [];
        if ($twilioSettings) {
            $twilioFieldJsons = json_decode($twilioSettings->field_json, true);
            $twilioJsons      = json_decode($twilioSettings->json, true);
        }
        $textlocalSettings      = FormIntegrationSetting::where('key', 'textlocal_integration')->where('form_id', $form->id)->first();
        $textlocalJsons         = [];
        $textlocalFieldJsons    = [];
        if ($textlocalSettings) {
            $textlocalFieldJsons = json_decode($textlocalSettings->field_json, true);
            $textlocalJsons      = json_decode($textlocalSettings->json, true);
        }
        $messenteSettings   = FormIntegrationSetting::where('key', 'messente_integration')->where('form_id', $form->id)->first();
        $messenteJsons      = [];
        $messenteFieldJsons = [];
        if ($messenteSettings) {
            $messenteFieldJsons = json_decode($messenteSettings->field_json, true);
            $messenteJsons      = json_decode($messenteSettings->json, true);
        }
        $smsgatewaySettings = FormIntegrationSetting::where('key', 'smsgateway_integration')->where('form_id', $form->id)->first();
        $smsgatewayJsons = [];
        $smsgatewayFieldJsons = [];
        if ($smsgatewaySettings) {
            $smsgatewayFieldJsons = json_decode($smsgatewaySettings->field_json, true);
            $smsgatewayJsons = json_decode($smsgatewaySettings->json, true);
        }
        $clicktellSettings = FormIntegrationSetting::where('key', 'clicktell_integration')->where('form_id', $form->id)->first();
        $clicktellJsons = [];
        $clicktellFieldJsons = [];
        if ($clicktellSettings) {
            $clicktellFieldJsons = json_decode($clicktellSettings->field_json, true);
            $clicktellJsons = json_decode($clicktellSettings->json, true);
        }
        $clockworkSettings = FormIntegrationSetting::where('key', 'clockwork_integration')->where('form_id', $form->id)->first();
        $clockworkJsons = [];
        $clockworkFieldJsons = [];
        if ($clockworkSettings) {
            $clockworkFieldJsons = json_decode($clockworkSettings->field_json, true);
            $clockworkJsons = json_decode($clockworkSettings->json, true);
        }
        return view('form.integration.index', compact('form', 'slackJsons', 'telegramJsons', 'mailgunJsons', 'bulkgateJsons', 'nexmoJsons', 'fast2smsJsons', 'vonageJsons', 'sendgridJsons', 'twilioJsons', 'textlocalJsons', 'messenteJsons', 'smsgatewayJsons', 'clicktellJsons', 'clockworkJsons', 'formJsons', 'slackFieldJsons', 'telegramFieldJsons', 'mailgunFieldJsons', 'bulkgateFieldJsons', 'nexmoFieldJsons', 'fast2smsFieldJsons', 'vonageFieldJsons', 'sendgridFieldJsons', 'twilioFieldJsons', 'textlocalFieldJsons', 'messenteFieldJsons', 'smsgatewayFieldJsons', 'clicktellFieldJsons', 'clockworkFieldJsons'));
    }

    public function slackIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.slack', compact('form', 'formJsons'));
    }

    public function telegramIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.telegram', compact('form', 'formJsons'));
    }

    public function mailgunIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.mailgun', compact('form', 'formJsons'));
    }

    public function bulkgateIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.bulkgate', compact('form', 'formJsons'));
    }

    public function nexmoIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.nexmo', compact('form', 'formJsons'));
    }

    public function fast2smsIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.fast2sms', compact('form', 'formJsons'));
    }

    public function vonageIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.vonage', compact('form', 'formJsons'));
    }

    public function sendgridIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.sendgrid', compact('form', 'formJsons'));
    }

    public function twilioIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.twilio', compact('form', 'formJsons'));
    }

    public function textlocalIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.textlocal', compact('form', 'formJsons'));
    }

    public function messenteIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.messente', compact('form', 'formJsons'));
    }

    public function smsgatewayIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.smsgateway', compact('form', 'formJsons'));
    }

    public function clicktellIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.clicktell', compact('form', 'formJsons'));
    }

    public function clockworkIntegration($id)
    {
        $form = Form::find($id);
        $formJsons = json_decode($form->json);
        return view('form.integration.clockwork', compact('form', 'formJsons'));
    }

    public function formpaymentIntegration(Request $request, $id)
    {
        $form = Form::find($id);
        $paymentType = [];
        $paymentType[''] = 'Select payment';
        if (UtilityFacades::getsettings('stripesetting') == 'on') {
            $paymentType['stripe'] = 'Stripe';
        }
        if (UtilityFacades::getsettings('paypalsetting') == 'on') {
            $paymentType['paypal'] = 'Paypal';
        }
        if (UtilityFacades::getsettings('razorpaysetting') == 'on') {
            $paymentType['razorpay'] = 'Razorpay';
        }
        if (UtilityFacades::getsettings('paytmsetting') == 'on') {
            $paymentType['paytm'] = 'Paytm';
        }
        if (UtilityFacades::getsettings('flutterwavesetting') == 'on') {
            $paymentType['flutterwave'] = 'Flutterwave';
        }
        if (UtilityFacades::getsettings('paystacksetting') == 'on') {
            $paymentType['paystack'] = 'Paystack';
        }
        if (UtilityFacades::getsettings('payumoneysetting') == 'on') {
            $paymentType['payumoney'] = 'PayuMoney';
        }
        if (UtilityFacades::getsettings('molliesetting') == 'on') {
            $paymentType['mollie'] = 'Mollie';
        }
        if (UtilityFacades::getsettings('coingatesetting') == 'on') {
            $paymentType['coingate'] = 'Coingate';
        }
        if (UtilityFacades::getsettings('mercadosetting') == 'on') {
            $paymentType['mercado'] = 'Mercado';
        }
        if (UtilityFacades::getsettings('offlinepaymentsetting') == 'on') {
            $paymentType['offlinepayment'] = 'offlinepayment';
        }
        return view('form.payment', compact('form', 'paymentType'));
    }

    public function formpaymentIntegrationstore(Request $request, $id)
    {
        $form = Form::find($id);
        if ($request->payment_type == "paystack") {
            if ($request->currency_symbol != '₦' || $request->currency_name != 'NGN') {
                return redirect()->back()->with('failed', __('Currency not suppoted this payment getway. please enter NGN currency and ₦ symbol.'));
            }
        }
        if ($request->payment_type == "paytm") {
            if ($request->currency_symbol != '₹' || $request->currency_name != 'INR') {
                return redirect()->back()->with('failed', __('Currency not suppoted this payment getway. please enter INR currency and ₹ symbol.'));
            }
        }
        $form->payment_status   = ($request->payment == 'on') ? '1' : '0';
        $form->amount           = ($request->amount == '') ? '0' : $request->amount;
        $form->currency_symbol  = $request->currency_symbol;
        $form->currency_name    = $request->currency_name;
        $form->payment_type     = $request->payment_type;
        $form->save();
        return redirect()->back()->with('success', __('Form payment integration succesfully.'));
    }

    public function formIntegrationStore(Request $request, $id)
    {
        $slackdata = [];
        $slackFiledtext = [];
        if ($request->get('slack_webhook_url')) {
            foreach ($request->get('slack_webhook_url') as $slackkey => $slackvalue) {
                $slackdata[$slackkey]['slack_webhook_url'] = $slackvalue;
                $slackField                                = $request->input('slack_field' . $slackkey);
                if ($slackField) {
                    $slackFiledtext[] = implode(',', $slackField);
                }
            }
        }
        $slackJsonData = ($slackdata) ? json_encode($slackdata) : null;
        FormIntegrationSetting::updateOrCreate(
            ['form_id' => $id,  'key' => 'slack_integration'],
            ['status' => ($request->get('slack_webhook_url')) ? 1 : 0, 'field_json' => json_encode($slackFiledtext), 'json' => $slackJsonData]
        );
        $telegramdata = [];
        $telegramFiledtext = [];
        if ($request->get('telegram_access_token') && $request->get('telegram_chat_id')) {
            foreach ($request->get('telegram_access_token') as $telegramkey => $telegramvalue) {
                $telegramdata[$telegramkey]['telegram_access_token'] = $telegramvalue;
                $telegramdata[$telegramkey]['telegram_chat_id']      = $request->get('telegram_chat_id')[$telegramkey];
                $telegramField                                       = $request->input('telegram_field' . $telegramkey);
                if ($telegramField) {
                    $telegramFiledtext[] = implode(',', $telegramField);
                }
            }
        }
        $telegramJsonData = ($telegramdata) ? json_encode($telegramdata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'telegram_integration'],
            ['status' => ($request->get('telegram_access_token') && $request->get('telegram_chat_id')) ? 1 : 0, 'field_json' => json_encode($telegramFiledtext), 'json' => $telegramJsonData]
        );

        $mailgundata = [];
        $mailgunFiledtext = [];
        if ($request->get('mailgun_email') && $request->get('mailgun_domain') && $request->get('mailgun_secret')) {
            foreach ($request->get('mailgun_email') as $mailgunkey => $mailgunvalue) {
                $mailgundata[$mailgunkey]['mailgun_email']       = $mailgunvalue;
                $mailgundata[$mailgunkey]['mailgun_domain']      = $request->get('mailgun_domain')[$mailgunkey];
                $mailgundata[$mailgunkey]['mailgun_secret']      = $request->get('mailgun_secret')[$mailgunkey];
                $mailgunField                                    = $request->input('mailgun_field' . $mailgunkey);
                if ($mailgunField) {
                    $mailgunFiledtext[] = implode(',', $mailgunField);
                }
            }
        }
        $mailgunJsonData = ($mailgundata) ? json_encode($mailgundata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'mailgun_integration'],
            ['status' => ($request->get('mailgun_email') && $request->get('mailgun_domain') && $request->get('mailgun_secret')) ? 1 : 0, 'field_json' => json_encode($mailgunFiledtext), 'json' => $mailgunJsonData]
        );

        $bulkgatedata = [];
        $bulkgateFiledtext = [];
        if ($request->get('bulkgate_number') && $request->get('bulkgate_token') && $request->get('bulkgate_app_id')) {
            foreach ($request->get('bulkgate_number') as $bulkgatekey => $bulkgatevalue) {
                $bulkgatedata[$bulkgatekey]['bulkgate_number']      = $bulkgatevalue;
                $bulkgatedata[$bulkgatekey]['bulkgate_token']       = $request->get('bulkgate_token')[$bulkgatekey];
                $bulkgatedata[$bulkgatekey]['bulkgate_app_id']      = $request->get('bulkgate_app_id')[$bulkgatekey];
                $bulkgateField                                      = $request->input('bulkgate_field' . $bulkgatekey);
                if ($bulkgateField) {
                    $bulkgateFiledtext[] = implode(',', $bulkgateField);
                }
            }
        }
        $bulkgateJsonData = ($bulkgatedata) ? json_encode($bulkgatedata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'bulkgate_integration'],
            ['status' => ($request->get('bulkgate_number') && $request->get('bulkgate_token') && $request->get('bulkgate_app_id')) ? 1 : 0, 'field_json' => json_encode($bulkgateFiledtext), 'json' => $bulkgateJsonData]
        );

        $nexmodata = [];
        $nexmoFiledtext = [];
        if ($request->get('nexmo_number') && $request->get('nexmo_key') && $request->get('nexmo_secret')) {
            foreach ($request->get('nexmo_number') as $nexmokey => $nexmovalue) {
                $nexmodata[$nexmokey]['nexmo_number']   = $nexmovalue;
                $nexmodata[$nexmokey]['nexmo_key']      = $request->get('nexmo_key')[$nexmokey];
                $nexmodata[$nexmokey]['nexmo_secret']   = $request->get('nexmo_secret')[$nexmokey];
                $nexmoField                             = $request->input('nexmo_field' . $nexmokey);
                if ($nexmoField) {
                    $nexmoFiledtext[] = implode(',', $nexmoField);
                }
            }
        }
        $nexmoJsonData = ($nexmodata) ? json_encode($nexmodata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'nexmo_integration'],
            ['status' => ($request->get('nexmo_number') && $request->get('nexmo_key') && $request->get('nexmo_secret')) ? 1 : 0, 'field_json' => json_encode($nexmoFiledtext), 'json' => $nexmoJsonData]
        );
        $fast2smsdata = [];
        $fast2smsFiledtext = [];
        if ($request->get('fast2sms_number') && $request->get('fast2sms_api_key')) {
            foreach ($request->get('fast2sms_number') as $fast2smskey => $fast2smsvalue) {
                $fast2smsdata[$fast2smskey]['fast2sms_number']   = $fast2smsvalue;
                $fast2smsdata[$fast2smskey]['fast2sms_api_key']  = $request->input('fast2sms_api_key')[$fast2smskey];
                $fast2smsField                                   = $request->input('fast2sms_field' . $fast2smskey);
                if ($fast2smsField) {
                    $fast2smsFiledtext[] = implode(',', $fast2smsField);
                }
            }
        }
        $fast2smsJsonData = ($fast2smsdata) ? json_encode($fast2smsdata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'fast2sms_integration'],
            ['status' => ($request->get('fast2sms_number') && $request->get('fast2sms_api_key')) ? 1 : 0, 'field_json' => json_encode($fast2smsFiledtext), 'json' => $fast2smsJsonData]
        );

        $vonagedata = [];
        $vonageFiledtext = [];
        if ($request->get('vonage_number') && $request->get('vonage_key') && $request->get('vonage_secret')) {
            foreach ($request->get('vonage_number') as $vonagekey => $vonagevalue) {
                $vonagedata[$vonagekey]['vonage_number']  = $vonagevalue;
                $vonagedata[$vonagekey]['vonage_key']     = $request->input('vonage_key')[$vonagekey];
                $vonagedata[$vonagekey]['vonage_secret']  = $request->input('vonage_secret')[$vonagekey];
                $vonageField                              = $request->input('vonage_field' . $vonagekey);
                if ($vonageField) {
                    $vonageFiledtext[] = implode(',', $vonageField);
                }
            }
        }
        $vonageJsonData = ($vonagedata) ? json_encode($vonagedata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'vonage_integration'],
            ['status' => ($request->get('vonage_number') && $request->get('vonage_key') && $request->get('vonage_secret')) ? 1 : 0, 'field_json' => json_encode($vonageFiledtext), 'json' => $vonageJsonData]
        );

        $sendgriddata = [];
        $sendgridFiledtext = [];
        if ($request->get('sendgrid_email') && $request->get('sendgrid_host') && $request->get('sendgrid_port') && $request->get('sendgrid_username') && $request->get('sendgrid_password') && $request->get('sendgrid_encryption') && $request->get('sendgrid_from_address') && $request->get('sendgrid_from_name')) {
            foreach ($request->get('sendgrid_email') as $sendgridkey => $sendgridvalue) {
                $sendgriddata[$sendgridkey]['sendgrid_email']           = $sendgridvalue;
                $sendgriddata[$sendgridkey]['sendgrid_host']            = $request->get('sendgrid_host')[$sendgridkey];
                $sendgriddata[$sendgridkey]['sendgrid_port']            = $request->get('sendgrid_port')[$sendgridkey];
                $sendgriddata[$sendgridkey]['sendgrid_username']        = $request->get('sendgrid_username')[$sendgridkey];
                $sendgriddata[$sendgridkey]['sendgrid_password']        = $request->get('sendgrid_password')[$sendgridkey];
                $sendgriddata[$sendgridkey]['sendgrid_encryption']      = $request->get('sendgrid_encryption')[$sendgridkey];
                $sendgriddata[$sendgridkey]['sendgrid_from_address']    = $request->get('sendgrid_from_address')[$sendgridkey];
                $sendgriddata[$sendgridkey]['sendgrid_from_name']       = $request->get('sendgrid_from_name')[$sendgridkey];
                $sendgridField                                          = $request->input('sendgrid_field' . $sendgridkey);
                if ($sendgridField) {
                    $sendgridFiledtext[] = implode(',', $sendgridField);
                }
            }
        }
        $sendgridJsonData = ($sendgriddata) ? json_encode($sendgriddata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'sendgrid_integration'],
            ['status' => ($request->get('sendgrid_email') && $request->get('sendgrid_host') && $request->get('sendgrid_port') && $request->get('sendgrid_username') && $request->get('sendgrid_password') && $request->get('sendgrid_encryption') && $request->get('sendgrid_from_address') && $request->get('sendgrid_from_name')) ? 1 : 0, 'field_json' => json_encode($sendgridFiledtext), 'json' => $sendgridJsonData]
        );

        $twiliodata = [];
        $twilioFiledtext = [];
        if ($request->get('twilio_mobile_number') && $request->get('twilio_sid') && $request->get('twilio_auth_token') && $request->get('twilio_number')) {
            foreach ($request->get('twilio_mobile_number') as $twiliokey => $twiliovalue) {
                $twiliodata[$twiliokey]['twilio_mobile_number']    = $twiliovalue;
                $twiliodata[$twiliokey]['twilio_sid']              = $request->get('twilio_sid')[$twiliokey];
                $twiliodata[$twiliokey]['twilio_auth_token']       = $request->get('twilio_auth_token')[$twiliokey];
                $twiliodata[$twiliokey]['twilio_number']           = $request->get('twilio_number')[$twiliokey];
                $twilioField                                       = $request->input('twilio_field' . $twiliokey);
                if ($twilioField) {
                    $twilioFiledtext[] = implode(',', $twilioField);
                }
            }
        }
        $twilioJsonData = ($twiliodata) ? json_encode($twiliodata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'twilio_integration'],
            ['status' => ($request->get('twilio_mobile_number') && $request->get('twilio_sid') && $request->get('twilio_auth_token') && $request->get('twilio_number')) ? 1 : 0, 'field_json' => json_encode($twilioFiledtext), 'json' => $twilioJsonData]
        );

        $textlocaldata = [];
        $textlocalFiledtext = [];
        if ($request->get('textlocal_number') && $request->get('textlocal_api_key')) {
            foreach ($request->get('textlocal_number') as $textlocalkey => $textlocalvalue) {
                $textlocaldata[$textlocalkey]['textlocal_number']   = $textlocalvalue;
                $textlocaldata[$textlocalkey]['textlocal_api_key']  = $request->input('textlocal_api_key')[$textlocalkey];
                $textlocalField                                   = $request->input('textlocal_field' . $textlocalkey);
                if ($textlocalField) {
                    $textlocalFiledtext[] = implode(',', $textlocalField);
                }
            }
        }
        $textlocalJsonData = ($textlocaldata) ? json_encode($textlocaldata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'textlocal_integration'],
            ['status' => ($request->get('textlocal_number') && $request->get('textlocal_api_key')) ? 1 : 0, 'field_json' => json_encode($textlocalFiledtext), 'json' => $textlocalJsonData]
        );

        $messentedata = [];
        $messenteFiledtext = [];
        if ($request->get('messente_number') && $request->get('messente_api_username') && $request->get('messente_api_password') && $request->get('messente_sender')) {
            foreach ($request->get('messente_number') as $messentekey => $messentevalue) {
                $messentedata[$messentekey]['messente_number']                    = $messentevalue;
                $messentedata[$messentekey]['messente_api_username']              = $request->get('messente_api_username')[$messentekey];
                $messentedata[$messentekey]['messente_api_password']              = $request->get('messente_api_password')[$messentekey];
                $messentedata[$messentekey]['messente_sender']                    = $request->get('messente_sender')[$messentekey];
                $messenteField                                                    = $request->input('messente_field' . $messentekey);
                if ($messenteField) {
                    $messenteFiledtext[] = implode(',', $messenteField);
                }
            }
        }
        $messenteJsonData = ($messentedata) ? json_encode($messentedata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'messente_integration'],
            ['status' => ($request->get('messente_number') && $request->get('messente_api_username') && $request->get('messente_api_password') && $request->get('messente_sender')) ? 1 : 0, 'field_json' => json_encode($messenteFiledtext), 'json' => $messenteJsonData]
        );

        $smsgatewaydata = [];
        $smsgatewayFiledtext = [];
        if ($request->get('smsgateway_number') && $request->get('smsgateway_api_key') && $request->get('smsgateway_user_id') && $request->get('smsgateway_user_password') && $request->get('smsgateway_sender_id')) {
            foreach ($request->get('smsgateway_number') as $smsgatewaykey => $smsgatewayvalue) {
                $smsgatewaydata[$smsgatewaykey]['smsgateway_number']              = $smsgatewayvalue;
                $smsgatewaydata[$smsgatewaykey]['smsgateway_api_key']             = $request->get('smsgateway_api_key')[$smsgatewaykey];
                $smsgatewaydata[$smsgatewaykey]['smsgateway_user_id']             = $request->get('smsgateway_user_id')[$smsgatewaykey];
                $smsgatewaydata[$smsgatewaykey]['smsgateway_user_password']       = $request->get('smsgateway_user_password')[$smsgatewaykey];
                $smsgatewaydata[$smsgatewaykey]['smsgateway_sender_id']           = $request->get('smsgateway_sender_id')[$smsgatewaykey];
                $smsgatewayField                                                  = $request->input('smsgateway_field' . $smsgatewaykey);
                if ($smsgatewayField) {
                    $smsgatewayFiledtext[] = implode(',', $smsgatewayField);
                }
            }
        }
        $smsgatewayJsonData = ($smsgatewaydata) ? json_encode($smsgatewaydata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'smsgateway_integration'],
            ['status' => ($request->get('smsgateway_number') && $request->get('smsgateway_sid') && $request->get('smsgateway_user_id') && $request->get('smsgateway_user_password') && $request->get('smsgateway_sender_id')) ? 1 : 0, 'field_json' => json_encode($smsgatewayFiledtext), 'json' => $smsgatewayJsonData]
        );
        $clicktelldata = [];
        $clicktellFiledtext = [];
        if ($request->get('clicktell_number') && $request->get('clicktell_api_key')) {
            foreach ($request->get('clicktell_number') as $clicktellkey => $clicktellvalue) {
                $clicktelldata[$clicktellkey]['clicktell_number']              = $clicktellvalue;
                $clicktelldata[$clicktellkey]['clicktell_api_key']             = $request->get('clicktell_api_key')[$clicktellkey];
                $clicktellField                                                = $request->input('clicktell_field' . $clicktellkey);
                if ($clicktellField) {
                    $clicktellFiledtext[] = implode(',', $clicktellField);
                }
            }
        }
        $clicktellJsonData = ($clicktelldata) ? json_encode($clicktelldata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'clicktell_integration'],
            ['status' => ($request->get('clicktell_number') && $request->get('clicktell_api_key')) ? 1 : 0, 'field_json' => json_encode($clicktellFiledtext), 'json' => $clicktellJsonData]
        );

        $clockworkdata = [];
        $clockworkFiledtext = [];
        if ($request->get('clockwork_number') && $request->get('clockwork_api_token')) {
            foreach ($request->get('clockwork_number') as $clockworkkey => $clockworkvalue) {
                $clockworkdata[$clockworkkey]['clockwork_number']     = $clockworkvalue;
                $clockworkdata[$clockworkkey]['clockwork_api_token']  = $request->input('clockwork_api_token')[$clockworkkey];
                $clockworkField                                       = $request->input('clockwork_field' . $clockworkkey);
                if ($clockworkField) {
                    $clockworkFiledtext[] = implode(',', $clockworkField);
                }
            }
        }
        $clockworkJsonData = ($clockworkdata) ? json_encode($clockworkdata) : null;
        FormIntegrationSetting::updateorcreate(
            ['form_id' => $id,  'key' => 'clockwork_integration'],
            ['status' => ($request->get('clockwork_number') && $request->get('clockwork_api_token')) ? 1 : 0, 'field_json' => json_encode($clockworkFiledtext), 'json' => $clockworkJsonData]
        );
        return redirect()->back()->with('success', __('Form integration succesfully.'));
    }

    public function formTheme($id)
    {
        $form = Form::find($id);
        return view('form.themes.theme', compact('form'));
    }

    public function formThemeEdit(Request $request, $slug, $id)
    {
        $form = Form::find($id);
        return view('form.themes.index', compact('slug', 'form'));
    }

    public function themeChange(Request $request, $id)
    {
        $form = Form::find($id);
        $form->theme = $request->theme;
        $form->save();
        return redirect()->route('forms.index')->with('success', __('Theme successfully changed.'));
    }

    public function formThemeUpdate(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'background_image' => 'image|mimes:png,jpg,jpeg',
        ]);
        if ($validator->fails()) {
            $messages = $validator->errors();
            return response()->json(['errors' => $messages->first()]);
        }
        $form = Form::find($id);
        $form->theme = $request->theme;
        $form->theme_color = $request->color;
        if ($request->hasFile('background_image')) {
            $themeBackgroundImage = 'form-background.' . $request->background_image->getClientOriginalExtension();
            $themeBackgroundImagePath = 'form-themes/theme3/' . $form->id;
            $backgroundImage = $request->file('background_image')->storeAs(
                $themeBackgroundImagePath,
                $themeBackgroundImage
            );
            $form->theme_background_image = $backgroundImage;
        }
        $form->save();
        return redirect()->route('forms.index')->with('success', __('Form theme selected succesfully.'));
    }

    public function formRules(Request $request,  $id)
    {
        if (\Auth::user()->can('manage-form-rule')) {
            $formRules      = form::find($id);
            $jsonData       = json_decode($formRules->json);

            $rules          = formRule::where('form_id', $id)->get();
            return view('form.conditional-rules.rules', compact('formRules', 'jsonData', 'rules'));
        } else {
            return redirect()->back()->with('errors', __('permission Denied'));
        }
    }

    public function storeRule(Request $request)
    {
        if (\Auth::user()->can('create-form-rule')) {

            request()->validate([
                'rule_name'                 => 'required|max:50',
                'condition_type'            => 'nullable',
                'rules.*.if_field_name'     => 'required',
                'rules.*.if_rule_type'      => 'required',
                'rules.*.if_rule_value'     => 'required',
                'rules2.*.else_rule_type'   => 'required',
                'rules2.*.else_field_name'  => 'required',
            ]);

            $conditioal = Form::find($request->form_id);
            $conditioal->conditional_rule = ($request->conditional_rule  == '1' ? '1'  : '0');
            $conditioal->save();

            $ifJson     = json_encode($request->rules);
            $thenJson   = json_encode($request->rules2);

            $formRule              = new formRule();
            $formRule->form_id     = $request->form_id;
            $formRule->rule_name   = $request->rule_name;
            $formRule->if_json     = $ifJson;
            $formRule->then_json   = $thenJson;
            $formRule->condition   = ($request->condition_type) ?  $request->condition_type : 'or';
            $formRule->save();

            return redirect()->route('form.rules', $request->form_id)->with('success', __('Rule set successfully'));
        } else {
            return redirect()->back()->with('errors', __('permission Denied'));
        }
    }

    public function editRule($id)
    {
        if (\Auth::user()->can('edit-form-rule')) {
            $rule           = formRule::where('id', $id)->first();
            $form           = form::find($rule->form_id);

            $jsonDataIf     = json_decode($rule->if_json);
            $jsonDataThen   = json_decode($rule->then_json);
            $jsonData       = json_decode($form->json);

            return view('form.conditional-rules.edit', compact('form', 'rule', 'jsonDataIf', 'jsonDataThen', 'jsonData'));
        } else {
            return redirect()->back()->with('errors', __('permission Denied'));
        }
    }

    public function ruleUpdate($id, Request $request)
    {
        if (\Auth::user()->can('edit-form-rule')) {
            request()->validate([
                'rule_name'                 => 'required|max:50',
                'condition_type'            => 'nullable',
                'rules.*.if_field_name'     => 'required',
                'rules.*.if_rule_type'      => 'required',
                'rules.*.if_rule_value'     => 'required',
                'rules2.*.else_rule_type'   => 'required',
                'rules2.*.else_field_name'  => 'required',
            ]);

            $conditioal = Form::find($request->form_id);
            $conditioal->conditional_rule = ($request->conditional_rule     == 'on' ? '1'  : '0');
            $conditioal->save();

            $newRules       = $request->rules;
            $existingRules  = formRule::find($id)->if_json;
            $existingRules  = json_decode($existingRules, true);

            $countNewRules = count($newRules);
            $countExistingRules = count($existingRules);

            $lastPosition   = count($newRules) - 1;
            $lastRule       = $newRules[$lastPosition];

            if ($countExistingRules < $countNewRules) {
                foreach ($newRules as $newRule) {
                    $newFieldName = $lastRule['if_field_name'];
                    foreach ($existingRules as $existingRule) {
                        $existingFieldName = $existingRule['if_field_name'];

                        if ($newFieldName === $existingFieldName) {
                            return redirect()->back()->with('errors', 'This name Rule already exists.');
                        }
                    }
                }
            }

            $ifJson = json_encode($request->rules);
            $thenJson = json_encode($request->rules2);

            $ruleUpdate                 = formRule::find($id);
            $ruleUpdate->rule_name      = $request->rule_name;
            $ruleUpdate->if_json        = $ifJson;
            $ruleUpdate->then_json      = $thenJson;
            $ruleUpdate->condition      = ($request->condition_type) ?  $request->condition_type : 'or';
            $ruleUpdate->save();

            return redirect()->route('form.rules', $request->form_id)->with('success', __('Rule set successfully'));
        } else {
            return redirect()->back()->with('errors', __('permission Denied'));
        }
    }

    public function ruleDelete($id)
    {
        if (\Auth::user()->can('delete-form-rule')) {
            $ruleDelete  = formRule::find($id);
            $ruleDelete->delete();

            return back()->with('success', __('Rule Deleted Succesfully'));
        } else {
            return redirect()->back()->with('errors', __('permission Denied'));
        }
    }

    public function getField(Request $request)
    {
        $form = Form::find($request->id);
        $formData = json_decode($form->json, true);
        $fieldName = $request->input('fieldname');

        $matchingField = null;
        foreach ($formData as $section) {
            foreach ($section as $field) {
                if (isset($field['name']) && $field['name'] === $fieldName) {
                    $matchingField = $field;
                    break 2;
                }
            }
        }

        return response(['matchingField' => $matchingField]);
    }

    public function passwordProtection($id)
    {
        $hashids = new Hashids('', 20);
        $DechashId = $hashids->decodeHex($id);

        $form = Form::find($DechashId);

        return view('form.password-protection', compact('form'));
    }

    public function passwordMatchProtecrtion(Request $request,  $id)
    {
        $form = Form::find($id);
        request()->validate([
            'form_password' => 'required',
        ]);

        $hashids = new Hashids('', 20);
        $hashId = $hashids->encodeHex($form->id);

        if (Hash::check($request->form_password, $form->form_password)) {
            $request->session()->put('form_unlocked_' . $hashId, true);
            return redirect()->route('forms.survey', $hashId);
        } else {
            return redirect()->back()->with('errors', 'Password Dosen`t Match.! ');
        }
    }

    public function destroyMultiple(Request $request)
    {
        if (\Auth::user()->can('delete-form')) {
            $form =  Form::whereIn('id', $request->ids)->delete();
            $formValue = FormValue::whereIn('form_id', $request->ids)->delete();
            return response()->json(['msg' =>  'Form moved to trash']);
        } else {
            return redirect()->back()->with('failed', __('Permission Denied.'));
        }
    }

    public function restore($id)
    {
        $form = Form::where('id', $id)->restore();
        $formValue = FormValue::where('form_id', $id)->restore();

        return redirect()->back()->with('success',  'form restored successfully');
    }

    public function restoreMultiple(Request $request)
    {
        $form = Form::whereIn('id', $request->ids)->restore();
        $formValue = FormValue::whereIn('form_id', $request->ids)->restore();
        return response()->json(['msg' =>  'form restored successfully']);
    }

    public function forcedelete($id)
    {
        Form::where('id', $id)->forceDelete();
        FormValue::where('form_id', $id)->forceDelete();
        AssignFormsRoles::where('form_id', $id)->forceDelete();
        AssignFormsUsers::where('form_id', $id)->forceDelete();
        return redirect()->route('forms.index', 'view=trash')->with('success', __('Forms deteted successfully.'));
    }

    public function forcedeleteMultiple(Request $request)
    {
        $form = Form::whereIn('id', $request->ids)->forceDelete();
        $formValue = FormValue::whereIn('form_id', $request->ids)->forceDelete();
        return response()->json(['msg' =>  'form deteted successfully']);
        if ($request->query->get('view')) {
            return route('forms.index', 'view=trash');
        } else {
            return route('forms.index');
        }
    }

    public function forcedeleteAll(Request $request)
    {
        $form = Form::onlyTrashed()->forceDelete();
        $formValue = FormValue::onlyTrashed()->forceDelete();
        return response()->json(['msg' =>  'Trash is empty now.']);
    }
}
