<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormTemplate extends Model
{
    use HasFactory;

    public $fillable = [
        'title', 'image', 'json', 'status','created_by'
    ];
}
