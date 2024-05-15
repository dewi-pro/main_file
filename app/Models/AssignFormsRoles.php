<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignFormsRoles extends Model
{
    use HasFactory;
    public $fillable = [
        'form_id', 'role_id'
    ];
}
