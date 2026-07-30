<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Partner;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = $this->transactionQuery()
            ->whereIn('status', ['settlement', 'success'])
            ->sum('total_price');
        
        $ticketsSold = $this->transactionQuery()
            ->whereIn('status', ['settlement', 'success'])
            ->count();
        
        $activeEvents = $this->eventQuery()
            ->where('date', '>=', now())
            ->count();
        
        $pendingOrders = $this->transactionQuery()
            ->where('status', 'pending')
            ->count();
        
        $recentTransactions = $this->transactionQuery()
            ->with('event.partner')
            ->latest()
            ->take(5)
            ->get();

        $currentYear = now()->year;

        $monthlyEventsRaw = $this->eventQuery()
            ->selectRaw('MONTH(date) as month_number, COUNT(*) as total')
            ->whereYear('date', $currentYear)
            ->groupBy('month_number')
            ->orderBy('month_number')
            ->get();

        // Isi semua 12 bulan (Jan-Des), termasuk yang belum punya event,
        // supaya grafik selalu menampilkan satu tahun penuh.
        $monthlyEvents = collect(range(1, 12))->map(function ($month) use ($monthlyEventsRaw, $currentYear) {
            $match = $monthlyEventsRaw->firstWhere('month_number', $month);

            return (object) [
                'month_number' => $month,
                'month_name' => \Carbon\Carbon::createFromDate($currentYear, $month, 1)->format('M'),
                'total' => $match->total ?? 0,
            ];
        });

        $maxMonthlyEvents = max($monthlyEvents->max('total') ?? 0, 1);

        $organizerStats = Partner::query()
            ->withCount('events')
            ->when(Auth::user()->partner_id, function ($query, $partnerId) {
                $query->where('id', $partnerId);
            })
            ->orderByDesc('events_count')
            ->take(5)
            ->get();

        $totalUsers = User::count();
        $totalPartners = Partner::count();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'recentTransactions',
            'monthlyEvents',
            'maxMonthlyEvents',
            'organizerStats',
            'totalUsers',
            'totalPartners'
        ));
    }

    private function eventQuery(): Builder
    {
        return Event::query()
            ->when(Auth::user()->partner_id, function ($query, $partnerId) {
                $query->where('partner_id', $partnerId);
            });
    }

    private function transactionQuery(): Builder
    {
        return Transaction::query()
            ->when(Auth::user()->partner_id, function ($query, $partnerId) {
                $query->whereHas('event', function ($eventQuery) use ($partnerId) {
                    $eventQuery->where('partner_id', $partnerId);
                });
            });
    }
}