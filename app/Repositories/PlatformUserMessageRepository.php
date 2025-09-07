<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\PlatformUserMessage;

class PlatformUserMessageRepository extends ModuleRepository
{
    use HandleBlocks;

    public function __construct(PlatformUserMessage $model)
    {
        $this->model = $model;
    }
}
