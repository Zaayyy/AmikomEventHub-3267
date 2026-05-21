<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil data nyata dari database untuk ditampilkan di Stats Grid
        $total_events = Event::count();
        $total_users = User::count();
        // total_income menjumlahkan kolom total_price dari tabel transaksi yang sudah sukses
        $total_income = Transaction::where('status', 'Success')->sum('total_price');
        $pending_orders = Transaction::where('status', 'Pending')->count();

        // Mengambil 5 transaksi terbaru untuk tabel bawah
        $latest_transactions = Transaction::latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'total_events', 
            'total_users', 
            'total_income', 
            'pending_orders', 
            'latest_transactions'
        ));
    }
}