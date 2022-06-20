<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionController extends Controller
{
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
        return Inertia::render('Admins/Permissions/Index', [
            'permissions' => Permission::latest()->paginate(5),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:25', 'unique:permissions'],
            'description' => ['required', 'max:25'],
        ]);
        Permission::create([
            'name' => $request->name,
            'description' => $request->description,
            'guard_name' => 'web',
        ]);
        return back();
    }

    public function update(Request $request, Permission $permission)
    {
        $this->validate($request, [
            'name' => ['required', 'max:25'],
            'description' => ['required', 'max:25'],
        ]);
        $permission->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return back();
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return back();
    }

}
