<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingValue extends Model
{
    use HasFactory;
    protected $fillable = ['booking_id', 'user_id', 'json', 'transaction_id', 'currency_symbol', 'currency_name', 'status', 'amount', 'payment_type', 'booking_slots_date', 'booking_slots', 'booking_seats_date', 'booking_seats_session', 'booking_seats', 'booking_status'];

    public function Booking()
    {
        return $this->hasOne(Booking::class, 'id', 'booking_id');
    }

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getFormArray()
    {
        return json_decode($this->json);
    }
}
