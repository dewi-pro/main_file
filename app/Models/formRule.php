<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formRule extends Model
{
    use HasFactory;

    protected $fillable = ['form_id' , 'rule_name' ,'if_json' , 'then_json' , 'condition'];
}
