<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class PartnerDashboardController extends Controller
{
    /**
     * Status transaksi yang dianggap lunas / berhasil dibayar.
     * Harus selalu sinkron dengan MidtransWebhookController::handle().
     */
    private const PAID_STATUSES = ['settlement', 'success'];

    public function index()
    {
        $partner = Auth::user()->partner;

        $events = $partner->events()->latest()->get();

        $totalEvent = $partner->events()->count();

        $totalReview = $partner->reviews()->count();

        $averageRating = round($partner->averageRating(), 1);

        // Total pendapatan dari seluruh event milik partner ini,
        // dihitung dari transaksi yang statusnya sudah lunas.
        $totalRevenue = Transaction::whereIn('status', self::PAID_STATUSES)
            ->whereHas('event', function ($query) use ($partner) {
                $query->where('partner_id', $partner->id);
            })
            ->sum('total_price');

        // Jumlah tiket terjual (baris transaksi lunas), berguna untuk
        // konteks di samping angka rupiah di kartu dashboard.
        $totalTicketsSold = Transaction::whereIn('status', self::PAID_STATUSES)
            ->whereHas('event', function ($query) use ($partner) {
                $query->where('partner_id', $partner->id);
            })
            ->count();

        return view('partner.dashboard', compact(
            'partner',
            'events',
            'totalEvent',
            'totalReview',
            'averageRating',
            'totalRevenue',
            'totalTicketsSold'
        ));
    }
}