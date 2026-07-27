<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Partner;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data Event beserta Category dan Ticket Tier
        $events = Event::with(['category', 'ticketTiers'])
            ->latest()
            ->take(3)
            ->get();

        // Ambil semua kategori
        $categories = Category::all();

        // Ambil semua partner
        $partners = Partner::all();

        // Kirim data ke halaman homepage
        return view('welcome', compact(
            'categories',
            'partners',
            'events'
        ));
    }
}
