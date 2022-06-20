<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:admin|user']);
    }

    public function index()
    {
        return Inertia::render('Admins/Customer/Index', [
            'users' => Customer::select('photos', 'cust_id', 'address', 'user_id',
                'u.name AS name', 'u.email AS email', 'u.phone AS phone', 'u.username AS username', 'r.name AS role_name',
                'u.id_role AS role_id')
                ->join('users AS u', 'customer.user_id', '=', 'u.id')
                ->join('role AS r', 'u.id_role', '=', 'r.id')
                ->orderBy('u.created_at', 'DESC')
                ->paginate(5),
        ]);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasAnyRole(['admin','user'])) {
            Users::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'phone' => $request->phone,
                'id_role' => 2,
                'password' => Hash::make('password'),
            ]);
            Customer::create([
                'address' => $request->address,
                // 'photos' => null,
                $id = Users::where('username', $request->username)->value('id'),
                'user_id' => $id,
            ]);
            return back();
        }
        return back();
    }

    public function update(Request $request)
    {
        $customer = Customer::where('user_id', $request->id)->first();
        $user = Users::where('id', $request->id)->first();

        if (auth()->user()->hasAnyRole(['admin','user'])) {
            $customer->update([
                'address' => $request->address,
                'user_id' => $request->id,

            ]);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'phone' => $request->phone,
                'id_role' => 2,
                'password' => Hash::make('password'),
            ]);
        }
        return back();
    }

    public function destroy($id)
    {if (auth()->user()->hasAnyRole(['admin'])) {
        $customer = Customer::where('user_id', $id)->first();
        $customer->user()->delete();
        $customer->delete();
        return back();
    }
        return back();
    }

}
