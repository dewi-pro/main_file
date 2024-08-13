<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormDestination extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'status'];
}
