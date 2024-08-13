<?php

namespace App\Http\Controllers;

use App\DataTables\FormClusterDataTable;
use App\Models\FormDestination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\FormCategory;
use App\Models\FormType;
use App\Models\Destination;
use App\Models\Leader;
use App\Models\FormCluster;


class FormClusterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FormClusterDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-form-cluster')) {
            return $dataTable->render('form-cluster.index');
        } else {
            return $dataTable->render('form-cluster.index');

            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (\Auth::user()->can('create-form-cluster')) {
            $view = view('form-cluster.create');
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
        if (\Auth::user()->can('create-form-cluster')) {
            $request->validate([
                'name' => 'required',
            ]);

            FormCluster::create([
                'name' => $request->name,
                'status'=>1
            ]);
            return redirect()->route('form-cluster.index')->with('success', __('Cluster Created Successfully!'));
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
        if (\Auth::user()->can('edit-form-cluster')) {
            $formCluster = FormCluster::find($id);

            $view = view('form-cluster.edit', compact('formCluster'));
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
        if (\Auth::user()->can('edit-form-cluster')) {
            $request->validate([
                'name' => 'required'
            ]);

            $formCluster =  FormCluster::find($id);
            $formCluster->name = $request->name;
            $formCluster->save();

            return redirect()->route('form-cluster.index')->with('success', __('Cluster Updated Successfully!'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (\Auth::user()->can('delete-form-cluster')) {
            $formCluster = FormCluster::find($id);
            $formCluster->delete();

            return redirect()->route('form-cluster.index')->with('success', __('Cluster deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }    
    }

}
