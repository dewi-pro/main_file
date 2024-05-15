<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use App\DataTables\ModuleDataTable;
use Spatie\Permission\Models\Permission;
use DB;

class ModuleController extends Controller
{
    public function index(ModuleDataTable $dataTable)
    {
        return $dataTable->render('module.index');
    }

    public function create()
    {
        return view('module.create');
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|regex:/^[a-zA-Z0-9\-_\.]+$/|min:4|unique:permissions',
        ]);

        $this->module =  module::create([
            'name' => str_replace(' ', '-', strtolower($request->name)),
        ]);
        $moduleName  = str_replace(' ', '-', strtolower($request->name));
        if (!empty($_POST['permissions'])) {
            foreach ($_POST['permissions'] as $check) {
                if ($check == 'M') {
                    $data[] = ['name' => 'manage-' . $moduleName, 'guard_name' => 'web', 'created_at' => new \DateTime()];
                } else if ($check == 'C') {
                    $data[] = ['name' => 'create-' . $moduleName, 'guard_name' => 'web', 'created_at' => new \DateTime()];
                } else if ($check == 'E') {
                    $data[] = ['name' => 'edit-' . $moduleName, 'guard_name' => 'web', 'created_at' => new \DateTime()];
                } else if ($check == 'D') {
                    $data[] = ['name' => 'delete-' . $moduleName, 'guard_name' => 'web', 'created_at' => new \DateTime()];
                } else if ($check == 'S') {
                    $data[] = ['name' => 'show-' . $moduleName, 'guard_name' => 'web', 'created_at' => new \DateTime()];
                }
            }
        }
        Permission::insert($data);
        return redirect()->route('module.index')->with('success',  __('Module created successfully.'));
    }

    public function edit($id)
    {
        $this->module = module::findOrfail($id);
        return view('module.edit')->with('module', $this->module);
    }

    public function update(Request $request, $id)
    {
        $module = Module::find($id);
        request()->validate([
            'name' => 'required|regex:/^[a-zA-Z0-9\-_\.]+$/|min:4|unique:modules,name,' . $module->id,
        ]);
        $module->name = str_replace(' ', '-', strtolower($request->name));
        $permissions = DB::table('permissions')
            ->where('name', 'like', '%' . $request->old_name . '%')
            ->get();
        $moduleName  = str_replace(' ', '-', strtolower($request->name));
        foreach ($permissions as $permission) {
            $update_permission = permission::find($permission->id);
            if ($permission->name == 'manage-' . $request->old_name) {
                $update_permission->name = 'manage-' . $moduleName;
            }
            if ($permission->name == 'create-' . $request->old_name) {
                $update_permission->name = 'create-' . $moduleName;
            }
            if ($permission->name == 'edit-' . $request->old_name) {
                $update_permission->name = 'edit-' . $moduleName;
            }
            if ($permission->name == 'delete-' . $request->old_name) {
                $update_permission->name = 'delete-' . $moduleName;
            }
            if ($permission->name == 'show-' . $request->old_name) {
                $update_permission->name = 'show-' . $moduleName;
            }
            $update_permission->save();
        }
        $module->save();
        return redirect()->route('module.index')->with('success',  __('Module updated sucessfully.'));
    }

    public function destroy($id)
    {
        $this->module = module::find($id);
        $users = DB::table('permissions')
            ->where('name', 'like', '%' . $this->module->name . '%')
            ->get();
        foreach ($users as $user) {
            $permission = permission::find($user->id);
            $permission->delete();
        }
        $this->module->delete();
        return redirect()->route('module.index')->with('success',  __('Module deleted successfully.'));
    }
}
