<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Partner; // 1. TAMBAHKAN INI: Import model Partner

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil parameter 'category' dari URL
        $categoryId = $request->query('category');

        $events = Event::with('category')
            ->when($categoryId, function ($query, $categoryId) {
                // Filter kolom category_id di tabel events
                return $query->where('category_id', $categoryId);
            })
            ->latest()
            ->get();

        $categories = Category::all();

        // 2. TAMBAHKAN INI: Ambil semua data partner dari database
        $partners = Partner::latest()->get();

        // 3. PERBAIKAN: Ikut sertakan variabel 'partners' ke dalam compact
        return view('welcome', compact('events', 'categories', 'partners'));
    }
}