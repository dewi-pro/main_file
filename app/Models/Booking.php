<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'business_email',
        'business_website',
        'business_address',
        'business_number',
        'business_phone',
        'business_logo',
        'booking_slots',
        'json',
        'payment_status',
        'amount',
        'currency_symbol',
        'currency_name',
        'payment_type',
    ];

    public function getFormArray()
    {
        return json_decode($this->json);
    }
}
