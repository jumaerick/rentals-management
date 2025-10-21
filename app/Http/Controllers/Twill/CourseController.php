<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use App\Models\DomainExperience;
use App\Repositories\DomainExperienceRepository;
use App\Repositories\SkillLevelRepository;
use App\Repositories\LearninGoalRepository;
use App\Repositories\InterestRepository;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class CourseController extends BaseModuleController
{
    protected $moduleName = 'courses';
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->disablePermalink();
    }

    /**
     * See the table builder docs for more information. If you remove this method you can use the blade files.
     * When using twill:module:make you can specify --bladeForm to use a blade form instead.
     */
    // public function getForm(TwillModelContract $model): Form
    // {
    //     $form = parent::getForm($model);

    //     $form->add(
    //         Input::make()->name('description')->label('Description')
    //     );

    //     return $form;
    // }

    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */
    protected function formData($request){
        // dd($request->route()->parameters());
        //Extract course id
        $courseId = $request->route('course');
        $course = Course::findorFail($courseId);
        $courseMeta = $course->courseMetaData;

        if($courseMeta){
            //Remove nulls
            $domainExperienceIds = $course->courseMetaData->pluck('domain_experience_id')->filter()->values();
            $skillLevelIds = $course->courseMetaData->pluck('skill_level_id')->filter()->values();
            $interestIds = $course->courseMetaData->pluck('interest_id')->filter()->values();
            $learningGoalsIds = $course->courseMetaData->pluck('learnin_goal_id')->filter()->values();


        }

    $selectedDomainIds = $courseMeta->pluck('domain_experience_id')->filter()->values()->toArray();
    $selectedSkillLevelIds = $courseMeta->pluck('skill_level_id')->filter()->values()->toArray();
    $selectedInterestIds = $courseMeta->pluck('interest_id')->filter()->values()->toArray();
    $selectedLearningGoalIds = $courseMeta->pluck('learnin_goal_id')->filter()->values()->toArray();

    // Get the full option lists for dropdowns (you likely want these)
    $domains = app(DomainExperienceRepository::class)->listAll();
    $skillsLevels = app(SkillLevelRepository::class)->listAll();
    $interests = app(InterestRepository::class)->listAll();
    $learningGoals = app(LearninGoalRepository::class)->listAll();
        // dd(collect($domains));

    return [
        'domains' => $domains,
        'skillsLevels' => $skillsLevels,
        'interests' => $interests,
        'learningGoals' => $learningGoals,

        'selectedDomainIds' => $selectedDomainIds,
        'selectedSkillLevelIds' => $selectedSkillLevelIds,
        'selectedInterestIds' => $selectedInterestIds,
        'selectedLearningGoalIds' => $selectedLearningGoalIds,
    ];
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();

        $table->add(
            Text::make()->field('description')->title('Description')
        );

        return $table;
    }

    public function coursesMetaDataUpdate(Request $request, int $id): RedirectResponse
    {
        $input = $request->all();

        $this->repository->update($id, $input);

        Session::flash('status', twillTrans('twill::lang.publisher.save-success'));

        return redirect()->back();
    }
}
