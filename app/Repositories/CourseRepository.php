<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use A17\Twill\Models\Contracts\TwillModelContract;
use App\Models\Course;
use Illuminate\Support\Arr;
use DB;

class CourseRepository extends ModuleRepository
{
    use HandleBlocks, HandleRevisions;

    public function __construct(Course $model)
    {
        $this->model = $model;
    }

     public function update(int|string $id, array $fields): TwillModelContract
    {
        return DB::transaction(function () use ($id, $fields) {
            $model = $this->model->findOrFail($id);

            $original_fields = $fields;

            $this->beforeSave($model, $fields);

            $fields = $this->prepareFieldsBeforeSave($model, $fields);

            // 🔍 Extract the pivot data (e.g. domain_field_ids)
            $domainFieldIds = $fields['domain_experience_id'] ?? null;
            $skillFieldsIds = $fields['skill_level_id'] ?? null;
            $interestFieldsIds = $fields['interest_id'] ?? null;
            $learningGoalFieldsIds = $fields['learning_goal_id'] ?? null;
            // dd($fields);

            // Remove it from fields before fill/save
            unset($fields['domain_experience_id']);
            unset($fields['skill_level_id']);
            unset($fields['interest_id']);
            unset($fields['learning_goal_id']);
            // dd($fields);
            // Fill and save base model
            $model->fill(Arr::except($fields, $this->getReservedFields()));
            $model->save();

            // Sync pivot relationship if provided

            if (is_array($domainFieldIds)) {
                $model->domainFields()->sync($domainFieldIds);
            }

            if (is_array($skillFieldsIds)) {
                $model->skillLevelFields()->sync($skillFieldsIds);
            }

            if (is_array($learningGoalFieldsIds)) {
                $model->learningGoalFields()->sync($learningGoalFieldsIds);
            }

            if (is_array($interestFieldsIds)) {
                $model->interestFields()->sync($interestFieldsIds);
            }

            $this->afterSaveOriginalData($model, $original_fields);
            $this->afterSave($model, $fields);

            return $model->fresh();
        }, 3);
    }
}
