<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = Carbon::now();
        $ago = $now->subDays(3);
        return Inertia::render('Admins/Dashboard', [
            'users' => User::where('is_admin', 0)->whereDate('created_at', '>', $ago)->count(),
        ]);
    }

}
