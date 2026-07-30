<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerReviewController extends Controller
{
    /**
     * Daftar seluruh review dari semua event milik partner yang login.
     */
    public function index()
    {
        $partner = Auth::user()->partner;

        $reviews = $partner->reviews()
            ->with(['event', 'user'])
            ->latest()
            ->paginate(10);

        return view('partner.reviews.index', compact('reviews'));
    }

    /**
     * Simpan/perbarui balasan partner untuk sebuah review.
     */
    public function reply(Request $request, Review $review)
    {
        $this->authorizeOwnership($review);

        $request->validate([
            'reply' => 'required|string|max:2000',
        ], [
            'reply.required' => 'Balasan tidak boleh kosong.',
            'reply.max' => 'Balasan maksimal 2000 karakter.',
        ]);

        $review->update([
            'reply' => $request->reply,
            'replied_at' => now(),
        ]);

        return redirect()->route('partner.reviews.index')->with('success', 'Balasan berhasil dikirim.');
    }

    /**
     * Pastikan review yang dibalas benar milik partner yang login.
     * Mencegah partner A membalas review di event milik partner B.
     */
    private function authorizeOwnership(Review $review): void
    {
        $partnerId = Auth::user()->partner->id;

        if ((int) $review->partner_id !== (int) $partnerId) {
            abort(403, 'Review ini bukan milik event Anda.');
        }
    }
}