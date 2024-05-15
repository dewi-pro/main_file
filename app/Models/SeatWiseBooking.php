<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatWiseBooking extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id',
        'seat_booking_json',
        'services',
        'week_time',
        'session_time_status',
        'session_time_json',
        'limit_time_status',
        'start_date',
        'end_date',
        'rolling_days_status',
        'rolling_days',
        'maximum_limit_status',
        'maximum_limit',
        'multiple_booking',
        'email_notification',
        'time_zone',
        'date_format',
        'time_format',
        'enable_note',
        'note'
    ];
}
