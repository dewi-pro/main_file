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

class FormValueController extends Controller
{
    public function index(FormValuesDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-submitted-form')) {
            $forms = Form::all();
            return $dataTable->render('form-value.index', compact('forms'));
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
            return $dataTable->with('form_id', $form_id)->render('form-value.view-submited-form', compact('forms', 'chartData', 'formsDetails'));
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
            $formValue->save();
        }

        return redirect()->back()->with('error' , __('Form Status update successfully.'));
    }

}
