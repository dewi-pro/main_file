<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourConsultants extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'division'];
}
