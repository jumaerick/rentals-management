<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseMetaData extends Model
{
    //
    protected $table = 'courses_metadata';

    protected $fillable = [
        'course_id',
        'domain_field_id',
        'skill_level_id',
        'learning_goal_id',
        'interest_id',
    ];
}
