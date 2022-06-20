<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Technician;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class TechnicianController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:admin|user']);
    }

    public function index()
    {
        return Inertia::render('Admins/Technician/Index', [
            'users' => Technician::select(
                'technician_id',
                'specialist_id',
                'user_id',
                'technician.desc',
                'certification',
                'address',
                'photos',
                's.id_specialist',
                's.category AS spesialis',
                'u.id',
                'u.username',
                'u.name AS name',
                'u.email',
                'u.phone AS phone')

                ->join('specialization AS s', 'technician.specialist_id', '=', 's.id_specialist')
                ->join('users AS u', 'technician.user_id', '=', 'u.id')
            // ->join('transaction AS t', 'technician.technician_id', '=', 't.id_technician')
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
                'id_role' => 3,
                'password' => Hash::make('password'),
            ]);
            $id = Users::where('username', $request->username)->value('id');
            Technician::create([
                'specialist_id' => $request->specialist,
                'user_id' => $id,
                'desc' => $request->description,
                'certification' => $request->certification,
                'address' => $request->address,
            ]);
            return back();
        }
        return back();
    }

    public function update(Request $request)
    {
        $technician = Technician::where('user_id', $request->id)->first();
        $user = Users::where('id', $request->id)->first();

        if (auth()->user()->hasAnyRole(['admin','user'])) {
            $technician->update([
                'specialist_id' => $request->specialist,
                'user_id' => $request->id,
                'desc' => $request->description,
                'certification' => $request->certification,
                'address' => $request->address,
            ]);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'phone' => $request->phone,
                'id_role' => 3,
                'password' => Hash::make('password'),
            ]);
        }
        return back();
    }

    public function destroy($id)
    {if (auth()->user()->hasAnyRole(['admin','user'])) {
        $technician = Technician::where('user_id', $id)->first();
        $technician->user()->delete();
        $technician->delete();
        return back();
    }
        return back();
    }

}
