<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\SkillLevel;

class SkillLevelRepository extends ModuleRepository
{
    use HandleBlocks, HandleRevisions;

    public function __construct(SkillLevel $model)
    {
        $this->model = $model;
    }
}
