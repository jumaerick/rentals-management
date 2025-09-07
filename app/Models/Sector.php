<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class Sector extends Model implements Sortable
{
    use HasBlocks, HasPosition;

    protected $fillable = [
        'published',
        'title',
        'description',
        'position',
    ];
    
}
