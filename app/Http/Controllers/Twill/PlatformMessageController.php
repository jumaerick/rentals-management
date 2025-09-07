<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use Illuminate\Http\JsonResponse;
use App\Models\PlatformUserMessage;
use Illuminate\Support\Str;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use DB;


class PlatformMessageController extends BaseModuleController
{
    protected $moduleName = 'platformMessages';
    // protected $appends = ['selected_roles'];
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    // protected function setUpController(): void
    // {
    //     $this->disablePermalink();
    // }

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
    // protected function additionalIndexTableColumns(): TableColumns
    // {
    //     $table = parent::additionalIndexTableColumns();

    //     $table->add(
    //         Text::make()->field('description')->title('Description')
    //     );

    //     return $table;
    // }

protected function formData($request)
{
    $adminRoles = [1 =>'Admin',  2 => 'HR'];

    $selectedRoles = [];
    $r = explode('/', $request->getRequestUri());
    $id = $r[3];
    // dd($id);
    // Check if we're editing an existing record

    // dd(PlatformUserMessage::all()->pluck('platform_message_id'));
    if ($id) {
        $selectedRoles = PlatformUserMessage::where('platform_message_id', $id)
            ->pluck('admin_role')
            ->map(fn($roleId) => (int) $roleId)
            ->toArray();

    }
    // dd($this->selected_roles);
    // dd($adminRoles);

    return [
        'adminRoleList' => $adminRoles,
        'admin_role' => $selectedRoles,
    ];
}


public function update(TwillModelContract|int $id, ?int $submoduleId = null): JsonResponse
{
    // dd('hapa');
    // Get input data from the request
    $roles = request()->input('sectors', []); // This should be an array of role IDs
// dd($roles);
    // Start a DB transaction to keep data integrity
    DB::transaction(function () use ($id, $roles) {
        // Delete all existing messages linked to this platform message
        PlatformUserMessage::where('platform_message_id', $id)->delete();

        // Insert one record per selected role
        foreach ($roles as $roleId) {
            PlatformUserMessage::create([
                'platform_message_id' => $id,
                'sectors' => $roleId, // Assuming admin_role stores role ID
            ]);
        }
    });

    // Continue with default update (saves other form fields)
    return parent::update($id, $submoduleId);
}

}
