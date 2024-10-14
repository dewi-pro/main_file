<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formValuesReportcos extends Model
{
    use HasFactory;

    protected $fillable = ['form_id' , 'company_name' ,'full_name' , 'email' , 'rate_value', 'rate_label', 'comment', 'tour_consultant'];
}
