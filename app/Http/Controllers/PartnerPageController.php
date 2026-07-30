<?php

namespace App\Http\Controllers;

use App\Models\Partner;

class PartnerPageController extends Controller
{
    public function show(Partner $partner)
    {
        $partner->load([
            'events.category',
        ]);

        $reviews = \App\Models\Review::with([
            'user',
            'event',
        ])
        ->whereHas('event', function ($query) use ($partner) {
            $query->where('partner_id', $partner->id);
        })
        ->latest()
        ->get();

        return view('partners.show', compact(
            'partner',
            'reviews'
        ));
    }
}