<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\PermissionsDataTable;
use DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:manage-permission|create-permission|edit-permission|delete-permission', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-permission', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-permission', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-permission', ['only' => ['destroy']]);
    }

    public function index(PermissionsDataTable $dataTable)
    {
        return $dataTable->render('permission.index');
    }

    public function create()
    {
        $view = view('permission.create');
        return ['html' => $view->render()];
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
        ]);
        Permission::create($request->all());
        return redirect()->route('permission.index')
            ->with('success',  __('Permission created successfully.'));
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        $view = view('permission.edit')->with('permission', $permission);
        return ['html' => $view->render()];
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->update($request->except('_token'));
        return redirect()->route('permission.index')
            ->with('success',  __('Permission updated successfully.'));
    }

    public function destroy($id)
    {
        DB::table("role_has_permissions")->where('permission_id', $id)->delete();
        $permission = Permission::find($id);
        $permission->delete();
        return redirect()->route('permission.index')
            ->with('success',  __('Permission deleted successfully.'));
    }
}
