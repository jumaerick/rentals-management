<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalToken extends Model
{
    //
    protected $fillable = [
        'user_id',
        'google_access_token',
        'google_refresh_token',
        'google_token_expires_at',
    ];
}
