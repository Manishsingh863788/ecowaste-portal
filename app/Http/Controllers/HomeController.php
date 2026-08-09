<?php

namespace App\Http\Controllers;

use App\Models\RecyclingTip;
use App\Models\WasteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $tips = Schema::hasTable('recycling_tips') ? RecyclingTip::all() : collect();
        $totalRequests = Schema::hasTable('waste_requests') ? WasteRequest::count() : 0;
        $completedRequests = Schema::hasTable('waste_requests') ? WasteRequest::where('status', 'completed')->count() : 0;
        $recyclingRequests = Schema::hasTable('waste_requests') ? WasteRequest::where('request_type', 'recycling')->count() : 0;

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
