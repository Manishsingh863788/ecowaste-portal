<?php

namespace App\Http\Controllers;

use App\Models\WasteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class WasteRequestController extends Controller
{
    public function create(Request $request)
    {
        // Pre-fill form from cookie if returning user
        $savedData = json_decode($request->cookie('last_request_data', '{}'), true) ?? [];

        return view('waste-request.create', compact('savedData'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'           => 'required|string|max:100',
            'email'               => 'required|email|max:150',
            'phone'               => 'required|string|max:20',
            'address'             => 'required|string|max:255',
            'city'                => 'required|string|max:100',
            'postcode'            => 'required|string|max:10',
            'request_type'        => 'required|in:collection,recycling,bulky_item,hazardous,garden_waste,electronic_waste',
            'waste_categories'    => 'required|array|min:1',
            'waste_categories.*'  => 'string',
            'description'         => 'nullable|string|max:1000',
            'estimated_weight_kg' => 'nullable|numeric|min:0.1|max:10000',
            'preferred_date'      => 'required|date|after_or_equal:today',
            'preferred_time'      => 'required|in:morning,afternoon,evening',
            'is_urgent'           => 'nullable|boolean',
            'recurring'           => 'nullable|boolean',
            'recurring_frequency' => 'nullable|in:weekly,fortnightly,monthly',
            'special_instructions'=> 'nullable|string|max:500',
        ]);

        $validated['tracking_number'] = WasteRequest::generateTrackingNumber();
        $validated['ip_address']      = $request->ip();
        $validated['is_urgent']       = $request->boolean('is_urgent');
        $validated['recurring']       = $request->boolean('recurring');

        $wasteRequest = WasteRequest::create($validated);

        // Save user details in cookie for 30 days (convenience)
        $cookieData = json_encode([
            'full_name' => $validated['full_name'],
            'email'     => $validated['email'],
            'phone'     => $validated['phone'],
            'address'   => $validated['address'],
            'city'      => $validated['city'],
            'postcode'  => $validated['postcode'],
        ]);

        return redirect()
            ->route('request.confirmation', $wasteRequest->tracking_number)
            ->withCookie(cookie('last_request_data', $cookieData, 60 * 24 * 30))
            ->withCookie(cookie('requests_submitted', (int) request()->cookie('requests_submitted', 0) + 1, 60 * 24 * 30));
    }

    public function confirmation(string $trackingNumber)
    {
        $wasteRequest = WasteRequest::where('tracking_number', $trackingNumber)->firstOrFail();

        return view('waste-request.confirmation', compact('wasteRequest'));
    }

    public function track(Request $request)
    {
        $wasteRequest = null;
        $error        = null;

        if ($request->isMethod('post')) {
            $request->validate([
                'tracking_number' => 'required|string',
            ]);

            $wasteRequest = WasteRequest::where('tracking_number', strtoupper($request->tracking_number))->first();

            if (! $wasteRequest) {
                $error = 'No request found with that tracking number. Please check and try again.';
            }
        }

        return view('waste-request.track', compact('wasteRequest', 'error'));
    }

    public function index(Request $request)
    {
        $query = WasteRequest::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('request_type', $request->type);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('tracking_number', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $requests = $query->latest()->paginate(10);

        return view('waste-request.index', compact('requests'));
    }

    public function updateStatus(Request $request, WasteRequest $wasteRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled',
        ]);

        $wasteRequest->update(['status' => $request->status]);

        return back()->with('success', 'Status updated successfully.');
    }
}
