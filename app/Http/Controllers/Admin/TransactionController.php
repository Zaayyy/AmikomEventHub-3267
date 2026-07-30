<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('event.partner')
            ->when(Auth::user()->partner_id, function ($query, $partnerId) {
                $query->whereHas('event', function ($eventQuery) use ($partnerId) {
                    $eventQuery->where('partner_id', $partnerId);
                });
            })
            ->latest()
            ->paginate(20);

        return view('admin.transactions.index', compact('transactions'));
    }
}
