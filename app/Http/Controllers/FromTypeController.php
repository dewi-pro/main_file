<?php

namespace App\Http\Controllers;

use App\DataTables\FormTypeDataTable;
use App\Models\FormType;
use Illuminate\Http\Request;

class FromTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FormTypeDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-form-type')) {
            return $dataTable->render('form-type.index');
        } else {
            return $dataTable->render('form-type.index');

            // return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (\Auth::user()->can('create-form-type')) {

            $view = view('form-type.create');
            return ['html' => $view->render()];
        } else {
            $view = view('form-type.create');
            return ['html' => $view->render()];
            // return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('create-form-type')) {

            $request->validate([
                'name' => 'required|unique:form_types',
            ]);

            FormType::create([
                'name' => $request->name,
            ]);
            return redirect()->route('form-type.index')->with('success', __('Type Created Successfully!'));
        } else {
            $request->validate([
                'name' => 'required|unique:form_types',
            ]);

            FormType::create([
                'name' => $request->name,
            ]);
            return redirect()->route('form-type.index')->with('success', __('Type Created Successfully!'));
            // return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (\Auth::user()->can('edit-form-type')) {
            $formType = FormType::find($id);

            $view = view('form-type.edit', compact('formType'));
            return ['html' => $view->render()];
        } else {
            $formType = FormType::find($id);

            $view = view('form-type.edit', compact('formType'));
            return ['html' => $view->render()];

            // return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (\Auth::user()->can('edit-form-type')) {
            $request->validate([
                'name' => 'required|unique:form_types,name,' . $id,
            ]);

            $formType =  FormType::find($id);
            $formType->name = $request->name;
            $formType->save();

            return redirect()->route('form-type.index')->with('success', __('Type Updated Successfully!'));
        } else {
            $request->validate([
                'name' => 'required|unique:form_types,name,' . $id,
            ]);

            $formType =  FormType::find($id);
            $formType->name = $request->name;
            $formType->save();

            return redirect()->route('form-type.index')->with('success', __('Type Updated Successfully!'));

            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $formType = FormType::find($id);
            $formType->delete();

            return redirect()->route('form-type.index')->with('success', __('Type deleted successfully.'));
        // if (\Auth::user()->can('delete-form-type')) {
        //     $formType = FormType::find($id);
        //     $formType->delete();

        //     return redirect()->route('form-type.index')->with('success', __('Type deleted successfully.'));
        // } else {
        //     return redirect()->back()->with('failed', __('Permission denied.'));
        // }
    }

}
