<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\DomainExperience;

class DomainExperienceRepository extends ModuleRepository
{
    use HandleBlocks, HandleRevisions;

    public function __construct(DomainExperience $model)
    {
        $this->model = $model;
    }
    
}
