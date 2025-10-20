<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMetaData extends Model
{
    //

    protected $table = 'users_metadata';
    
    protected $fillable = [
        'user_id',
        'domain_field_id',
        'skill_level_id',
        'learning_goal_id',
        'interest_id',
    ];
}
