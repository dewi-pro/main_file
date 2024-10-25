<?php

namespace App\Http\Controllers;

use App\DataTables\FormLeaderDataTable;
use App\Models\FormLeader;
use Illuminate\Http\Request;

class FormLeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FormLeaderDataTable $dataTable)
     {
        if (\Auth::user()->can('manage-form-leader')) {
            return $dataTable->render('form-leader.index');
        } else {
            return $dataTable->render('form-leader.index');

            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (\Auth::user()->can('create-form-leader')) {

            $view = view('form-leader.create');
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
        if (\Auth::user()->can('create-form-leader')) {
            $request->validate([
                'name' => 'required|unique:form_leaders',
                'handphone' => 'required|unique:form_leaders',
                'divisi' => 'required|unique:form_leaders'
            ]);

            FormLeader::create([
                'name' => $request->name,
                'status'=>1,
                'handphone'=>$request->handphone,
                'divisi' => $request->divisi,
            ]);
            return redirect()->route('form-leader.index')->with('success', __('Leader Created Successfully!'));
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
        if (\Auth::user()->can('edit-form-leader')) {
            $formLeader = FormLeader::find($id);

            $view = view('form-leader.edit', compact('formLeader'));
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
        if (\Auth::user()->can('edit-form-leader')) {
            $request->validate([
                'name' => 'required',
                'handphone' => 'required',
                'divisi' => 'required'
            ]);

            $formLeader =  FormLeader::find($id);
            $formLeader->name = $request->name;
            $formLeader->handphone = $request->handphone;
            $formLeader->divisi = $request->divisi;
            $formLeader->save();

            return redirect()->route('form-leader.index')->with('success', __('Leader Updated Successfully!'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (\Auth::user()->can('delete-form-leader')) {
            $formLeader = FormLeader::find($id);
            $formLeader->delete();

            return redirect()->route('form-leader.index')->with('success', __('Leader deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}