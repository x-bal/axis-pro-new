<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('user-access'), 403);

        return view('users.index', [
            'users' => User::get(),
        ]);
    }

    public function create()
    {
        abort_unless(Gate::allows('user-create'), 403);

        return view('users.create', [
            'roles' => Role::get(),
            'user' => new User
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(Gate::allows('user-create'), 403);

        $attr = $this->validate($request, [
            'nama_lengkap' => 'required',
            'no_telepon' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'kode_adjuster' => 'required',
        ]);

        $attr['password'] = \Hash::make($request->password);

        $user = User::create($attr);
        $user->assignRole($request->input('role'));

        return redirect()->route('users.index')->with('success', 'User has been created');
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        abort_unless(Gate::allows('user-edit'), 403);

        $roles = Role::all();
        // $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles',));
    }

    public function update(Request $request, User $user)
    {
        abort_unless(Gate::allows('user-edit'), 403);

        $attr = $this->validate($request, [
            'nama_lengkap' => 'required',
            'no_telepon' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'kode_adjuster' => 'required'
        ]);

        if ($request->password != null) {
            $attr['password'] = \Hash::make($request->password);
        } else {
            $attr['password'] = $user->password;
        }

        $user->update($attr);
        $user->syncRoles($request->input('role'));

        return redirect()->route('users.index')->with('success', 'User has been created');
    }

    public function destroy(User $user)
    {
        abort_unless(Gate::allows('user-delte'), 403);

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User has been deleted');
    }
}
