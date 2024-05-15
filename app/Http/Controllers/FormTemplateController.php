<?php

namespace App\Http\Controllers;

use App\DataTables\FormTemplateDataTable;
use App\Models\FormTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FormTemplateController extends Controller
{
    public function index(FormTemplateDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-form-template')) {
            return $dataTable->render('form-template.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('create-form-template')) {
            return view('form-template.create');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create-form-template')) {
            request()->validate([
                'title'         => 'required|max:191',
                'image'         => 'required|mimes:jpeg,jpg,png',
            ]);

            $fileName = '';
            if ($request->file('image')) {
                $file       = $request->file('image');
                $fileName  =  $file->store('form-template');
            }

            FormTemplate::create([
                'title'         => $request->title,
                'image'         => $fileName,
                'created_by'    => \Auth::user()->id,
            ]);
            return redirect()->route('form-template.index')->with('success', __('Form Template created succesfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
    public function edit($id)
    {
        if (\Auth::user()->can('edit-form-template')) {
            $formTemplate = FormTemplate::find($id);
            return view('form-template.edit', compact('formTemplate'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit-form-template')) {
            request()->validate([
                'title' => 'required|max:191',
                'image' => 'required|mimes:jpeg,jpg,png',
            ]);

            $formTemplate = FormTemplate::find($id);
            if ($request->hasfile('image')) {
                $file                   = $request->file('image');
                $fileName              =  $file->store('form-template');
                $formTemplate->image    = $fileName;
            }
            $formTemplate->title        = $request->title;
            $formTemplate->created_by   = \Auth::user()->id;
            $formTemplate->save();
            return redirect()->route('form-template.index')->with('success', __('Form Template updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (\Auth::user()->can('delete-form-template')) {
            $formTemplate  = FormTemplate::find($id);
            if (File::exists(Storage::path($formTemplate->image))) {
                Storage::delete($formTemplate->image);
            }
            $formTemplate->delete();
            return redirect()->back()->with('success', __('Form Template Deleted succesfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function status(Request $request, $id)
    {
        $formTemplate       = FormTemplate::find($id);
        $input              = ($request->value == "true") ? 1 : 0;
        if ($formTemplate) {
            $formTemplate->status = $input;
            $formTemplate->save();
        }
        return response()->json(['is_success' => true, 'message' => __('Form Template status changed successfully.')]);
    }

    public function design($id)
    {
        if (\Auth::user()->can('design-form-template')) {
            $formTemplate = FormTemplate::find($id);
            return view('form-template.design', compact('formTemplate'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function designUpdate(Request $request, $id)
    {
        if (\Auth::user()->can('design-form-template')) {
            $formtemplate               = FormTemplate::find($id);
            $formtemplate->json         = $request->json;
            $formtemplate->created_by   = \Auth::user()->id;
            $formtemplate->save();
            return redirect()->route('form-template.index')->with('success', __('Form Template design updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}
