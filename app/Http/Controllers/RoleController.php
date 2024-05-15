<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Permission;
use App\DataTables\RolesDataTable;
use App\Models\Module;
use DB;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:manage-role|create-role|edit-role|delete-role', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-role', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-role', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }

    public function index(RolesDataTable $dataTable)
    {
        return $dataTable->render('roles.index');
    }

    public function create()
    {
        $permission     = Permission::get();
        $view           = view('roles.create', compact('permission'));
        return ['html' => $view->render()];
    }

    public function store(Request $request)
    {
        request()->validate([
            'name'       => 'required|unique:roles|max:20',
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        return redirect()->route('roles.index')->with('success', __('Role created successfully.'));
    }

    public function show($id)
    {
        $role               = Role::find($id);
        $permissions        = $role->permissions->pluck('name', 'id')->toArray();
        $allpermissions     = Permission::all()->pluck('name', 'id')->toArray();
        $allmodules         = Module::all()->pluck('name', 'id')->toArray();
        return view('roles.show')
            ->with('role', $role)
            ->with('permissions', $permissions)
            ->with('allpermissions', $allpermissions)
            ->with('allmodules', $allmodules);
    }

    public function edit($id)
    {

        $role               = Role::find($id);
        $permission         = Permission::get();
        $rolePermissions    = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
                                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                                ->all();
        $view               = View::make('roles.edit', compact('role', 'permission', 'rolePermissions'));
        return ['html' => $view->render()];
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'name'       => 'required|unique:roles|max:20',
        ]);
        $role       = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index')->with('success', __('Role updated successfully.'));
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', __('Role deleted successfully.'));
    }

    public function assignPermission(Request $request, $id)
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $role = Role::find($id);
        $permissions = $role->permissions()->get();
        $role->revokePermissionTo($permissions);
        $role->givePermissionTo($request->permissions);
        return redirect()->route('roles.index')->with('success',  __('Permissions assigned to role successfully.'));
    }
}
