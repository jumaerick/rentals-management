<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;
use App\Models\DomainExperience;
use App\Models\SkillLevel;
use App\Models\Interest;
use App\Models\LearninGoal;
use App\Models\CourseMetaData;

class Course extends Model implements Sortable
{
    use HasBlocks, HasRevisions, HasPosition;

    protected $fillable = [
        'published',
        'title',
        'domain_field_id',
        'skill_level_id',
        'learning_goal_id',
        'interest_id',
        'position',
    ];

    //
    public function domainFields()
    {
        // dd(DomainExperience::all());
        // return $this->belongsToMany(DomainExperience::class);
        return $this->belongsToMany(DomainExperience::class, 'courses_metadata'); // pivot table name
    }

    public function skillLevelFields()
    {
        // dd(DomainExperience::all());
        // return $this->belongsToMany(DomainExperience::class);
        return $this->belongsToMany(SkillLevel::class, 'courses_metadata'); // pivot table name
    }

    public function interestFields()
    {
        // dd(DomainExperience::all());
        // return $this->belongsToMany(DomainExperience::class);
        return $this->belongsToMany(Interest::class, 'courses_metadata'); // pivot table name
    }

    public function learningGoalFields()
    {
        // dd(DomainExperience::all());
        // return $this->belongsToMany(DomainExperience::class);
        return $this->belongsToMany(LearninGoal::class, 'courses_metadata'); // pivot table name
    }

    public function courseMetaData(){
        return $this->hasMany(CourseMetaData::class);
    }
    
}
