<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Replies extends Model
{
    //
    protected $fillable = [
        'comment_id',
        'parent_reply_id',
        'user_id',
        'message',
    ];

}
