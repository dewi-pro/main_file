<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardWidget extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'size',
        'order',
        'form_id',
        'user_id',
        'poll_id',
        'field_name',
        'chart_type',
        'type',
        'position',
        'created_by',
    ];

    public function Form()
    {
        return $this->hasOne('App\Models\Form', 'id', 'form_id');
    }

    public function Poll()
    {
        return $this->hasOne('App\Models\Poll', 'id', 'poll_id');
    }

    public function creatorId()
    {
        return $this->created_by;
    }
}
