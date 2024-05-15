<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormComments extends Model
{
    use HasFactory;
    protected $fillable = [

        'form_id','comment','name'
    ];

    public function replyby()
    {
        return $this->hasMany(FormCommentsReply::class, 'comment_id', 'id');
    }

}
