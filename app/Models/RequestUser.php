<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class RequestUser extends Model
{
    use HasFactory;
    use HasFactory, Notifiable, HasRoles;
    protected $guard_name = 'web';

    protected $fillable = [
        'name',
        'email',
        'password',
        'plan_id',
        'type',
        'disapprove_reason',
        'payment_status',
        'country_code',
        'phone',
    ];

    public function payStatus()
    {
        return $this->hasOne('App\Models\Order', 'request_user_id', 'id');
    }
}
