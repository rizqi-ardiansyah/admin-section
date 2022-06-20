<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Traits\HasRoles;

class RoleController extends Controller
{
    use HasRoles;
    public function __construct()
    {
        $this->middleware(['role:admin|user']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admins/Roles/Index', [
            'roles' => Role::with('permissions')->paginate(5),
            'permissions' => Permission::all(),
        ]);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasAnyRole(['admin'])) {
            $this->validate($request, [
                'name' => ['required', 'max:25', 'unique:roles'],
                'permissions' => 'required',
            ]);
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);
            if ($request->has('permissions')) {
                $role->givePermissionTo(collect($request->permissions)->pluck('id')->toArray());
            }
            return back();
        }
        return back();
    }

    public function update(Request $request, Role $role)
    {
        if (auth()->user()->hasAnyRole(['admin'])) {
            $this->validate($request, [
                'name' => ['required', 'max:25'],
                'permissions' => 'required',
            ]);
            if ($request->has('permissions')) {
                $role->givePermissionTo(collect($request->permissions)->pluck('id')->toArray());
            }
            $role->syncPermissions(collect($request->permissions)->pluck('id')->toArray());
            $role->update(['name' => $request->name]);
            return back();
        }
        return back();
    }

    public function destroy(Role $role)
    {
        if (auth()->user()->hasAnyRole(['admin'])) {
            $role->delete();
            return back();
        }
        return back();
    }
}
