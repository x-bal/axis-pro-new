<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('role-access'), 403);

        return view('roles.index', [
            'roles' => Role::get()
        ]);
    }

    public function create()
    {
        abort_unless(Gate::allows('role-create'), 403);

        $permissions = Permission::orderBy('name', 'ASC')->get();
        $role = new Role;
        return view('roles.create', compact('permissions', 'role'));
    }

    public function store(Request $request)
    {
        abort_unless(Gate::allows('role-create'), 403);

        $attr = $request->validate([
            'name' => 'required',
            'permission' => 'required',
        ]);

        $attr['name'] = \Str::slug($request->name);

        $role = Role::create(['name' => $attr['name']]);
        $role->syncPermissions($request->permission);

        return redirect()->route('roles.index')->with('success', 'Role has been created');
    }

    public function show($id)
    {
        //
    }

    public function edit(Role $role)
    {
        abort_unless(Gate::allows('role-edit'), 403);

        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $role->id)
            ->get();
        $permissions = Permission::orderBy('name', 'ASC')->get();

        return view('roles.edit', compact('role', 'rolePermissions', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        abort_unless(Gate::allows('role-edit'), 403);

        $attr = $request->validate([
            'name' => 'required',
            'permission' => 'required',
        ]);

        $attr['name'] = \Str::slug($request->name);

        $role->update(['name' => $attr['name']]);

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')->with('success', 'Role has been updated');
    }

    public function destroy(Role $role)
    {
        abort_unless(Gate::allows('role-delete'), 403);

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role has been deleted');
    }
}
