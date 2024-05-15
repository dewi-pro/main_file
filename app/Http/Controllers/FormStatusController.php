<?php

namespace App\Http\Controllers;

use App\DataTables\FormStatusDataTable;
use App\Models\FormStatus;
use Illuminate\Http\Request;

class FormStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FormStatusDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-form-status')) {
            return $dataTable->render('form-status.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (\Auth::user()->can('create-form-status')) {
            $view =  view('form-status.create');
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
        if (\Auth::user()->can('create-form-status')) {
            request()->validate([
                'name'    => 'required|max:50',
                'status'  => 'required',
                'color'   => 'required',
            ]);

            $formStatus = new FormStatus();
            $formStatus->name = $request->name;
            $formStatus->color = $request->color;
            $formStatus->status = ($request->status == '1' ?? 1);
            $formStatus->save();

            return redirect()->route('form-status.index')->with('success', 'Status Created Succesfully.');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FormStatus $formStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (\Auth::user()->can('edit-form-status')) {
            $formStatus = FormStatus::find($id);
            $view = view('form-status.edit', compact('formStatus'));
            return ['html' => $view->render()];
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit-form-status')) {
            request()->validate([
                'name'    => 'required|max:50',
                'status'  => 'required',
                'color'   => 'required',
            ]);

            $formStatus = FormStatus::find($id);
            $formStatus->name = $request->name;
            $formStatus->color = $request->color;
            $formStatus->status = ($request->status == '1' ?? 1);
            $formStatus->save();

            return redirect()->route('form-status.index')->with('success', 'Status Updated Succesfully.');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (\Auth::user()->can('delete-form-status')) {
            $formStatus = FormStatus::find($id);
            $formStatus->delete();

            return redirect()->route('form-status.index')->with('success', __('Status deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function formStatusChange(Request $request, $id)
    {
        $status = FormStatus::find($id);
        $input = ($request->value == "true") ? 1 : 0;
        if ($status) {
            $status->status = $input;
            $status->save();
        }
        return response()->json(['is_success' => true, 'message' => __('Status changed successfully.')]);
    }
}
