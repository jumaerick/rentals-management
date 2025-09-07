<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\ModuleRepository;
use A17\Twill\Models\Contracts\TwillModelContract;
use App\Models\PlatformMessage;

class PlatformMessageRepository extends ModuleRepository
{
    use HandleBlocks;

    public function __construct(PlatformMessage $model)
    {
        $this->model = $model;
    }


// public function afterSave(TwillModelContract $model, array $fields): void
// {
//     $roles = $fields['sectors'] ?? [];
//     // dd($roles);

//     // dd($roles);
//     // Clear old roles
//     // dd($model->userMessages()->count());
//     $model->userMessages()->delete();
//         // dd($model->userMessages()->count());

//     // dd($model->userMessages()->count());

//     // Recreate role assignments
//     // dd($model->userMessages());
//     foreach ($roles as $roleId) {
//         $model->userMessages()->create([
//             'sectors' => $roleId,
//         ]);
//     }

//     // Continue Twill's default logic
//     parent::afterSave($model, $fields);
// }
}
