<?php

namespace Database\Seeders;

use App\Models\RecyclingTip;
use App\Models\User;
use App\Models\WasteRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Demo admin user — safe to run multiple times
        User::updateOrCreate(
            ['email' => 'admin@ecowaste.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // Recycling tips — only seed if table is empty
        if (RecyclingTip::count() === 0) {
            $tips = [
                ['title' => 'Rinse Before Recycling',   'content' => 'Always rinse food containers before placing them in the recycling bin. Food residue can contaminate entire batches of recyclables.',                                          'category' => 'General',     'icon' => '🚿'],
                ['title' => 'Flatten Cardboard Boxes',  'content' => 'Flatten all cardboard boxes before recycling. This saves space in collection vehicles and makes processing more efficient.',                                                  'category' => 'Paper',       'icon' => '📦'],
                ['title' => 'Battery Disposal',         'content' => 'Never put batteries in general waste. Take them to designated battery collection points at supermarkets or recycling centres.',                                               'category' => 'Hazardous',   'icon' => '🔋'],
                ['title' => 'Compost Food Waste',       'content' => 'Up to 30% of household waste is food. Start composting fruit peels, vegetable scraps, and coffee grounds to reduce landfill waste.',                                        'category' => 'Organic',     'icon' => '🌱'],
                ['title' => 'E-Waste Recycling',        'content' => 'Old phones, laptops, and electronics contain valuable metals. Use our electronic waste collection service instead of throwing them away.',                                   'category' => 'Electronics', 'icon' => '💻'],
                ['title' => 'Plastic Bag Alternatives', 'content' => 'Plastic bags are rarely recyclable in kerbside bins. Use reusable bags or take plastic bags to supermarket collection points.',                                              'category' => 'Plastic',     'icon' => '🛍️'],
            ];
            foreach ($tips as $tip) {
                RecyclingTip::create($tip);
            }
        }

        // Sample requests — only seed if table is empty
        if (WasteRequest::count() === 0) {
            $sampleRequests = [
                [
                    'tracking_number'     => 'WM-SAMPLE01',
                    'full_name'           => 'John Smith',
                    'email'               => 'john@example.com',
                    'phone'               => '07700900001',
                    'address'             => '12 Green Lane',
                    'city'                => 'London',
                    'postcode'            => 'SW1A 1AA',
                    'request_type'        => 'recycling',
                    'waste_categories'    => json_encode(['paper', 'plastic', 'glass']),
                    'description'         => 'Monthly recycling collection',
                    'preferred_date'      => now()->addDays(3)->toDateString(),
                    'preferred_time'      => 'morning',
                    'status'              => 'confirmed',
                    'is_urgent'           => false,
                    'recurring'           => true,
                    'recurring_frequency' => 'monthly',
                ],
                [
                    'tracking_number'     => 'WM-SAMPLE02',
                    'full_name'           => 'Sarah Johnson',
                    'email'              => 'sarah@example.com',
                    'phone'               => '07700900002',
                    'address'             => '45 Oak Street',
                    'city'                => 'Manchester',
                    'postcode'            => 'M1 1AE',
                    'request_type'        => 'bulky_item',
                    'waste_categories'    => json_encode(['furniture', 'appliances']),
                    'description'         => 'Old sofa and washing machine',
                    'estimated_weight_kg' => 120.00,
                    'preferred_date'      => now()->addDays(5)->toDateString(),
                    'preferred_time'      => 'afternoon',
                    'status'              => 'pending',
                    'is_urgent'           => false,
                    'recurring'           => false,
                ],
                [
                    'tracking_number'     => 'WM-SAMPLE03',
                    'full_name'           => 'Mike Davis',
                    'email'               => 'mike@example.com',
                    'phone'               => '07700900003',
                    'address'             => '8 Elm Road',
                    'city'                => 'Birmingham',
                    'postcode'            => 'B1 1BB',
                    'request_type'        => 'garden_waste',
                    'waste_categories'    => json_encode(['garden_waste']),
                    'description'         => 'Tree cuttings and grass',
                    'estimated_weight_kg' => 50.00,
                    'preferred_date'      => now()->addDays(2)->toDateString(),
                    'preferred_time'      => 'morning',
                    'status'              => 'completed',
                    'is_urgent'           => false,
                    'recurring'           => false,
                ],
            ];
            foreach ($sampleRequests as $req) {
                WasteRequest::create($req);
            }
        }
    }
}
