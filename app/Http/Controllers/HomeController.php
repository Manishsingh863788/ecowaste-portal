<?php

namespace App\Http\Controllers;

use App\Models\RecyclingTip;
use App\Models\WasteRequest;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $tips = RecyclingTip::all();
        $totalRequests = WasteRequest::count();
        $completedRequests = WasteRequest::where('status', 'completed')->count();
        $recyclingRequests = WasteRequest::where('request_type', 'recycling')->count();

        // Cookie: track visit count
        $visitCount = (int) $request->cookie('visit_count', 0) + 1;
        $lastVisit  = $request->cookie('last_visit');

        $response = response()->view('home', compact(
            'tips',
            'totalRequests',
            'completedRequests',
            'recyclingRequests',
            'visitCount',
            'lastVisit'
        ));

        $response->cookie('visit_count', $visitCount, 60 * 24 * 30); // 30 days
        $response->cookie('last_visit', now()->toDateTimeString(), 60 * 24 * 30);

        return $response;
    }
}
