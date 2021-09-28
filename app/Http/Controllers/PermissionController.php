<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('permission-access'), 403);

        return view('permission.index', [
            'permissions' => Permission::get()
        ]);
    }

    public function create()
    {
        abort_unless(Gate::allows('permission-create'), 403);

        return view('permission.create');
    }

    public function store(Request $request)
    {
        abort_unless(Gate::allows('permission-create'), 403);

        $attr = $request->validate([
            'name' => 'required'
        ]);
        $attr['name'] = \Str::slug($request->name);

        Permission::create($attr);
        // return redirect()->route('permission.index')->with('success', 'Permission has been created');
        return back();
    }

    public function show($id)
    {
        //
    }

    public function edit(Permission $permission)
    {
        abort_unless(Gate::allows('permission-edit'), 403);

        return view('permission.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        abort_unless(Gate::allows('permission-edit'), 403);

        $attr = $request->validate([
            'name' => 'required'
        ]);
        $attr['name'] = \Str::slug($request->name);

        $permission->update($attr);
        return redirect()->route('permission.index')->with('success', 'Permission has been updated');
    }

    public function destroy(Permission $permission)
    {
        abort_unless(Gate::allows('permission-delete'), 403);

        $permission->delete();
        return redirect()->route('permission.index')->with('success', 'Permission has been deleted');
    }
}
