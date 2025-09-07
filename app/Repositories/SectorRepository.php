<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Sector;

class SectorRepository extends ModuleRepository
{
    use HandleBlocks;

    public function __construct(Sector $model)
    {
        $this->model = $model;
    }
}
