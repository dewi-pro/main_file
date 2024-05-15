<?php

namespace App\Http\Controllers;

use App\DataTables\FormCategoryDataTable;
use App\Models\FormCategory;
use Illuminate\Http\Request;

class FromCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FormCategoryDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-form-category')) {
            return $dataTable->render('form-category.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (\Auth::user()->can('create-form-category')) {

            $view = view('form-category.create');
            return ['html' => $view->render()];
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('create-form-category')) {

            $request->validate([
                'name' => 'required|unique:form_categories',
                'status' => 'required',
            ]);

            FormCategory::create([
                'name' => $request->name,
                'status' => $request->status
            ]);
            return redirect()->route('form-category.index')->with('success', __('Category Created Successfully!'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
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
        if (\Auth::user()->can('edit-form-category')) {
            $formCategory = FormCategory::find($id);

            $view = view('form-category.edit', compact('formCategory'));
            return ['html' => $view->render()];
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (\Auth::user()->can('edit-form-category')) {
            $request->validate([
                'name' => 'required|unique:form_categories,name,' . $id,
                'status' => 'required'
            ]);

            $formCategory =  FormCategory::find($id);
            $formCategory->name = $request->name;
            $formCategory->status = $request->status;
            $formCategory->save();

            return redirect()->route('form-category.index')->with('success', __('Category Updated Successfully!'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (\Auth::user()->can('delete-form-category')) {
            $formCategory = FormCategory::find($id);
            $formCategory->delete();

            return redirect()->route('form-category.index')->with('success', __('Category deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }


    public function formCategoryStatus(Request $request, $id)
    {
        $category = FormCategory::find($id);
        $input = ($request->value == "true") ? 1 : 0;
        if ($category) {
            $category->status = $input;
            $category->save();
        }
        return response()->json(['is_success' => true, 'message' => __('Category status changed successfully.')]);
    }
}
