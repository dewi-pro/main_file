<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeWiseBooking extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id',
        'slot_duration',
        'slot_duration_minutes',
        'payment_status',
        'payment_type',
        'services',
        'week_time',
        'intervals_time_status',
        'intervals_time_json',
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
