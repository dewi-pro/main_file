<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormValueDetail10 extends Model
{
    use HasFactory;

    protected $fillable = ['very_satisfied' , 'satisfied' ,'failry_satisfied' , 'not_satisfied' , 'label', 'status'];
}
