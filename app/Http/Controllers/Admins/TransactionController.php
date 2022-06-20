<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Technician;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:admin|user']);
    }

    public function index()
    {
        return Inertia::render('Admins/Transaction/Index', [
            'users' => Transaction::select('trans_id', 'level',
                'transaction.desc', 'price', 'status', 'rating', 'customer_id', 'id_technician', 'c.cust_id', 'c.user_id',
                't.technician_id', 't.user_id', 'u.name AS user_name', 'u2.name AS tech_name')
                ->join('customer AS c', 'transaction.customer_id', '=', 'c.cust_id')
                ->join('technician AS t', 'transaction.id_technician', '=', 't.technician_id')
                ->join('users AS u', 'c.user_id', '=', 'u.id')
                ->join('users AS u2', 't.user_id', '=', 'u2.id')
                ->orderBy('transaction.created_at', 'DESC')
                ->paginate(5),
            'cust_name' => Customer::select('cust_id', 'user_id', 'u.name')
                ->join('users AS u', 'customer.user_id', '=', 'u.id')->paginate(1000000000000000),
            'technician_name' => Technician::select(
                'technician_id',
                'specialist_id',
                'user_id',
                'technician_id',
                's.category AS spesialis',
                'u.name AS name')
                ->join('specialization AS s', 'technician.specialist_id', '=', 's.id_specialist')
                ->join('users AS u', 'technician.user_id', '=', 'u.id')
                ->paginate(1000000000000000),
        ]);
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasAnyRole(['admin','user'])) {
            Transaction::create([
                'customer_id' => $request->customer,
                'id_technician' => $request->technician,
                'desc' => $request->desc,
                'status' => $request->status,
            ]);
            return back();
        }
        return back();
    }

    public function update(Request $request)
    {
        $transaction = Transaction::where('trans_id', $request->id)->first();

        if (auth()->user()->hasAnyRole(['admin','user'])) {
            $transaction->update([
                'customer_id' => $request->customer,
                'id_technician' => $request->technician,
                'desc' => $request->desc,
                'status' => $request->status,
            ]);
        }
        return back();
    }

    public function destroy($id)
    {if (auth()->user()->hasAnyRole(['admin','user'])) {
        $transaction = Transaction::where('trans_id', $id)->first();
        $transaction->delete();
        return back();
    }
        return back();
    }

}
