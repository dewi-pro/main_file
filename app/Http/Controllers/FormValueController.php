<?php

namespace App\Http\Controllers;

use App\DataTables\FormValuesDataTable;
use App\Exports\FormValuesExport;
use App\Facades\UtilityFacades;
use App\Models\Form;
use App\Models\FormStatus;
use App\Models\FormValue;
use App\Models\User;
use App\Models\UserForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\FormValueDetail10;

class FormValueController extends Controller
{
    public function index(FormValuesDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-submitted-form')) {
            // // $formValue = FormValue::All();
            // // $array      = json_decode($formValue->json);
            $form = FormValue::all();
            $forms = [];
            $forms[''] = __('No select title');
            foreach ($form as $val) {
                $forms[$val->id] = json_decode($val->json);
            }


            // $formValue = FormValue::all();
            // $array      = json_decode($formValue->json);
            
            return $dataTable->render('form-value.index', compact( 'forms'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function showSubmitedForms($form_id, FormValuesDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-submitted-form')) {
            $forms          = Form::all();
            $chartData      = UtilityFacades::dataChart($form_id);
            $formsDetails  = Form::find($form_id);
            $valueDetail1 = FormValueDetail10::select(\DB::raw('((SUM(very_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '1.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail2 = FormValueDetail10::select(\DB::raw('((SUM(very_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '2.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail3 = FormValueDetail10::select(\DB::raw('((SUM(very_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '3.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail4 = FormValueDetail10::select(\DB::raw('((SUM(very_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '4.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail5 = FormValueDetail10::select(\DB::raw('((SUM(very_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '5.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail6 = FormValueDetail10::select(\DB::raw('((SUM(very_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '6.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail7 = FormValueDetail10::select(\DB::raw('((SUM(very_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '7.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail8 = FormValueDetail10::select(\DB::raw('((SUM(very_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '8.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail9 = FormValueDetail10::select(\DB::raw('((SUM(very_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '9.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail10 = FormValueDetail10::select(\DB::raw('((SUM(very_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '10.%')
                            ->where('form_id', '=', $form_id)->get();

            $valueDetail11 = FormValueDetail10::select(\DB::raw('((SUM(satisfied + failry_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '1.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail12 = FormValueDetail10::select(\DB::raw('((SUM(satisfied + failry_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '2.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail13 = FormValueDetail10::select(\DB::raw('((SUM(satisfied + failry_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '3.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail14 = FormValueDetail10::select(\DB::raw('((SUM(satisfied + failry_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '4.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail15 = FormValueDetail10::select(\DB::raw('((SUM(satisfied + failry_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '5.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail16 = FormValueDetail10::select(\DB::raw('((SUM(satisfied + failry_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '6.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail17 = FormValueDetail10::select(\DB::raw('((SUM(satisfied + failry_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '7.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail18 = FormValueDetail10::select(\DB::raw('((SUM(satisfied + failry_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '8.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail19 = FormValueDetail10::select(\DB::raw('((SUM(satisfied + failry_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '9.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail20 = FormValueDetail10::select(\DB::raw('((SUM(satisfied + failry_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '10.%')
                            ->where('form_id', '=', $form_id)->get();
            
            $valueDetail21 = FormValueDetail10::select(\DB::raw('((SUM(not_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '1.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail22 = FormValueDetail10::select(\DB::raw('((SUM(not_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '2.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail23 = FormValueDetail10::select(\DB::raw('((SUM(not_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '3.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail24 = FormValueDetail10::select(\DB::raw('((SUM(not_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '4.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail25 = FormValueDetail10::select(\DB::raw('((SUM(not_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '5.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail26 = FormValueDetail10::select(\DB::raw('((SUM(not_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '6.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail27 = FormValueDetail10::select(\DB::raw('((SUM(not_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '7.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail28 = FormValueDetail10::select(\DB::raw('((SUM(not_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '8.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail29 = FormValueDetail10::select(\DB::raw('((SUM(not_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '9.%')
                            ->where('form_id', '=', $form_id)->get();
            $valueDetail30 = FormValueDetail10::select(\DB::raw('((SUM(not_satisfied)*100)/COUNT(form_values_id)) AS sum'),)
                            ->join('form_values', 'form_values.id', '=', 'form_value_detail10s.form_values_id')
                            ->where('label', 'like', '10.%')
                            ->where('form_id', '=', $form_id)->get();

            return $dataTable->with('form_id', $form_id)->render('form-value.view-submited-form', compact('forms', 'chartData', 'formsDetails', 'valueDetail1', 
            'valueDetail2', 'valueDetail3', 'valueDetail4', 'valueDetail5', 'valueDetail6'
         , 'valueDetail7', 'valueDetail8', 'valueDetail9', 'valueDetail10', 
            'valueDetail11', 'valueDetail12', 'valueDetail13', 'valueDetail14', 'valueDetail15', 
            'valueDetail16', 'valueDetail17', 'valueDetail18', 'valueDetail19', 'valueDetail20',
            'valueDetail21', 'valueDetail22', 'valueDetail23', 'valueDetail24', 'valueDetail25', 
            'valueDetail26', 'valueDetail27', 'valueDetail28', 'valueDetail29', 'valueDetail30'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show($id)
    {
        if (\Auth::user()->can('show-submitted-form')) {
            try {
                $formValue = FormValue::find($id);
                $array      = json_decode($formValue->json);
            } catch (\Throwable $th) {
                return redirect()->back()->with('errors', $th->getMessage());
            }
            return view('form-value.view', compact('formValue', 'array'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        $usr                    = \Auth::user();
        $userRole               = $usr->roles->first()->id;
        $formValue              = FormValue::find($id);
        $formallowededit        = UserForm::where('role_id', $userRole)->where('form_id', $formValue->form_id)->count();

        if (\Auth::user()->can('edit-submitted-form') && $usr->type == 'Admin') {
            $array  = json_decode($formValue->json);
            $form   = $formValue->Form;
            $frm    = Form::find($formValue->form_id);
            return view('form.fill', compact('form', 'formValue', 'array'));
        } else {
            if (\Auth::user()->can('edit-submitted-form') && $formallowededit > 0 && $formValue->form_edit_lock_status == 0) {
                $formValue  = FormValue::find($id);
                $array      = json_decode($formValue->json);
                $form       = $formValue->Form;
                $frm        = Form::find($formValue->form_id);
                return view('form.fill', compact('form', 'formValue', 'array'));
            } else {
                return redirect()->back()->with('failed', __('Permission denied.'));
            }
        }
    }

    public function destroy($id)
    {
        if (\Auth::user()->can('delete-submitted-form')) {
            FormValue::find($id)->delete();
            return redirect()->back()->with('success',  __('Form successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function downloadPdf($id)
    {
        $formValue = FormValue::where('id', $id)->first();
        if ($formValue) {
            $formValue->createPDF();
        } else {
            $formValue = FormValue::where('id', '=', $id)->first();
            if (!$formValue) {
                $id         = Crypt::decryptString($id);
                $formValue = FormValue::find($id);
            }
            if ($formValue) {
                $formValue->createPDF();
            } else {
                return redirect()->route('home')->with('error', __('File is not exist.'));
            }
        }
    }

    public function export(Request $request)
    {
        $form = Form::find($request->form_id);
        return Excel::download(new FormValuesExport($request), $form->title . '.csv');
    }

    public function downloadCsv2($id)
    {
        $formValue = FormValue::where('id', '=', $id)->first();
        if (!$formValue) {
            $id         = Crypt::decryptString($id);
            $formValue = FormValue::find($id);
        }
        if ($formValue) {
            $formValue->createCSV2();
            return response()->download(storage_path('app/public/csv/Survey_' . $formValue->id . '.xlsx'))->deleteFileAfterSend(true);
        } else {
            return redirect()->route('home')->with('error', __('File is not exist.'));
        }
    }

    public function exportXlsx(Request $request)
    {
        $form = Form::find($request->form_id);

        $dateRange = $request->select_date ?? '';
        if ($dateRange != '') {
            list($startDate, $endDate) = array_map('trim', explode('to', $dateRange));
        } else {
            $startDate = '';
            $endDate = '';
        }

        $userSearch = $request->user_search_excel ?? '';
        $user = ($userSearch != '') ? User::select('id', 'name')->where('name', 'LIKE', $userSearch)->first()->id : '';
        return Excel::download(new FormValuesExport($request, $startDate, $endDate, $user), $form->title . '.xlsx');
    }

  

    public function getGraphData(Request $request, $id)
    {
        $form       = Form::find($id);
        $chartData  = UtilityFacades::dataChart($id);
        return view('form-value.chart', compact('chartData', 'id', 'form'));
    }

    public function VideoStore(Request $request)
    {
        $file      = $request->file('media');
        $extension = $file->getClientOriginalExtension();
        $filename  = $file->store('form_video');
        $values    = $filename;
        return response()->json(['success' => 'Video uploded successfully.', 'filename' => $values]);
    }


    public function SelfieDownload($id)
    {

        $data           = FormValue::find($id);
        $json           = $data->json;
        $jsonData       = json_decode($json, true);
        $selfieValue    = null;
        foreach ($jsonData[0] as $field) {
            if ($field['type'] === 'selfie') {
                $selfieValue = $field['value'];
                break;
            } elseif ($field['type'] === 'video') {
                $selfieValue = $field['value'];
                break;
            }
        }

        if ($selfieValue == null) {
            return redirect()->back()->with('errors', __('Image Value Not Found'));
        }else{
            $filePath = storage_path('app/' . $selfieValue);
            return response()->download($filePath);
        }
    }

    public function PaymentSlipDownload($id)
    {
        $formValue           = FormValue::find($id);
        if ($formValue->payment_type == 'offlinepayment') {
            $filePath = storage_path('app/' . $formValue->transfer_slip);

            if (isset($filePath) && Storage::exists($formValue->transfer_slip)) {
                return response()->download($filePath);
            }else{
                return redirect()->back()->with('errors', __('Payment Slip Not Found'));
            }
        } else {
            return redirect()->back()->with('errors', __('invalid payment method'));
        }
    }

    // change form fill edit Lock Status
    public function formFillEditlock($id)
    {
        $form = FormValue::find($id);
        if ($form->form_edit_lock_status == 0) {
            $form->form_edit_lock_status = 1;
            $form->save();
        } else {
            $form->form_edit_lock_status = 0;
            $form->save();
        }
        return redirect()->back()->with('success', __('Form edit Lock status changed successfully.'));
    }

    public function formChangeStatus($id)
    {
        $formValue   = FormValue::find($id);
        $formStatus  = FormStatus::where('status', 1)->pluck('name' , 'id');
        $view        =  view('form-value.form-status', compact('formValue' , 'formStatus'));
        return ['html' => $view->render()];
    }

    public function formstatusUpdated(Request  $request , $id)
    {
        $formValue = FormValue::find($id);
        $status  = $request->form_status ?? 1 ;
        if ($formValue) {
            $formValue->form_status  = $status;
            // $formValue->status = 'POSITIVE';
            $formValue->save();
        }

        return redirect()->back()->with('error' , __('Form Status update successfully.'));
    }

}
