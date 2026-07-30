<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class PartnerTransactionController extends Controller
{
    /**
     * Laporan transaksi, dibatasi hanya untuk event-event
     * milik partner yang sedang login.
     */
    public function index()
    {
        $partnerId = Auth::user()->partner->id;

        $transactions = Transaction::with('event')
            ->whereHas('event', function ($query) use ($partnerId) {
                $query->where('partner_id', $partnerId);
            })
            ->latest()
            ->paginate(20);

        return view('partner.transactions.index', compact('transactions'));
    }
}