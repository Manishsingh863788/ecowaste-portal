<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_number',
        'full_name',
        'email',
        'phone',
        'address',
        'city',
        'postcode',
        'request_type',
        'waste_categories',
        'description',
        'estimated_weight_kg',
        'preferred_date',
        'preferred_time',
        'status',
        'is_urgent',
        'recurring',
        'recurring_frequency',
        'special_instructions',
        'ip_address',
    ];

    protected $casts = [
        'waste_categories' => 'array',
        'is_urgent'        => 'boolean',
        'recurring'        => 'boolean',
        'preferred_date'   => 'date',
    ];

    public static function generateTrackingNumber(): string
    {
        do {
            $number = 'WM-' . strtoupper(substr(md5(uniqid()), 0, 8));
        } while (self::where('tracking_number', $number)->exists());

        return $number;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'     => 'warning',
            'confirmed'   => 'info',
            'in_progress' => 'primary',
            'completed'   => 'success',
            'cancelled'   => 'danger',
            default       => 'secondary',
        };
    }

    public function getRequestTypeLabelAttribute(): string
    {
        return match ($this->request_type) {
            'collection'       => 'General Collection',
            'recycling'        => 'Recycling',
            'bulky_item'       => 'Bulky Item',
            'hazardous'        => 'Hazardous Waste',
            'garden_waste'     => 'Garden Waste',
            'electronic_waste' => 'Electronic Waste',
            default            => ucfirst($this->request_type),
        };
    }
}
