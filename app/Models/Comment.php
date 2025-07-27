<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    //
    protected $fillable = [
        'course_id',
        'user_id',
        'message',
    ];

    public function user(){
        return $this->BelongsTo(User::class);
    }
}
