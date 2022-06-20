<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
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
        $emailAdmin = 'admin@admin.com';
        return Inertia::render('Admins/Users/Index', [
            'users' => User::where('email', '!=', $emailAdmin)->latest()->paginate(5),
            'roles' => Role::all(),
        ]);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasAnyRole(['admin'])) {
            $this->validate($request, [
                'name' => ['required', 'max:50'],
                'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'is_admin' => 1,
                'password' => Hash::make('password'),
            ]);
            $role = Role::where('id', 5)->first();
            $user->syncRoles($role);
            return back();
        }
        return back();
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->hasAnyRole(['admin'])) {
            $this->validate($request, [
                'name' => ['required', 'max:50'],
                'email' => ['required', 'string', 'email', 'max:50'],
            ]);
            if ($request->roles[0] === null) {
                return back()->withErrors(['roles' => 'The role field is required']);
            }
            if ($request->roles[0]['id'] != 5) {
                $adminRole = Role::where('id', $request->roles[0]['id'])->first();
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'is_admin' => 1,
                ]);
                $user->syncRoles($adminRole);
                return back();
            } else {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
            }
            return back();
        }
        return back();
    }

    public function destroy(User $user)
    {
        if (auth()->user()->hasAnyRole(['admin'])) {
            $user->delete();
            return back();
        }
        return back();
    }
    
}
