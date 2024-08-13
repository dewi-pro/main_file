<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormDestination extends Model
{
    use HasFactory;

    protected $fillable = ['destination_name', 'code_tour', 'tour_leader', 'type', 'categories_name', 'status'];
}
