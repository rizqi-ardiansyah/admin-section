<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Traits\HasRoles;

class AdminController extends Controller
{
    use HasRoles;

    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emailAdmin = 'admin@admin.com';
        return Inertia::render('Admins/Admins/Index', [
            'admins' => User::where('email', '!=', $emailAdmin)->get(),
            'roles' => Role::all(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->hasAnyRole(['admin'])) {
            $this->validate($request, [
                'name' => ['required', 'max:50'],
                'email' => ['required', 'string', 'email', 'max:50'],
            ]);
            if (!$request->roles) {
                return back()->withErrors(['roles' => 'The role field is required']);
            }
            if ($request->roles['id'] != 5) {
                $adminRole = Role::where('id', $request->roles['id'])->first();
                $user->syncRoles($adminRole);
                return back();
            } else {
                $userRole = Role::where('id', 5)->first();
                $user->update(['is_admin' => 0]);
                $user->syncRoles($userRole);
                return back();
            }
            return back();
        }
        return back();
    }
    
}
