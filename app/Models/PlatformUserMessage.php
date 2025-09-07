<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class PlatformUserMessage extends Model implements Sortable
{
    use HasBlocks, HasPosition;

    protected $fillable = [
        'published',
        'user_id',
        'admin_role',
        'platform_message_id',
        'job_role_id',
        'department_id',
        'team_id',
        'sectors',
        'position',
    ];

    


}
