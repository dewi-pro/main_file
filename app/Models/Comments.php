<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = [

        'poll_id','comment','name'
    ];

    public function replyby()
    {
        return $this->hasMany(CommentsReply::class, 'comment_id', 'id');
    }

}
