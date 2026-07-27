<?php

namespace App\Http\Controllers;

use App\Models\Partner;

class PartnerController extends Controller
{
    public function show($id)
    {
        $partner = Partner::with([
            'events',
            'reviews.user',
            'reviews.event'
        ])->findOrFail($id);

        // Hitung rating rata-rata
        $averageRating = $partner->reviews->avg('rating');

        // Jumlah review
        $totalReviews = $partner->reviews->count();

        return view('partner-profile', compact(
            'partner',
            'averageRating',
            'totalReviews'
        ));
    }
}
