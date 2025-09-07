<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasPosition;

use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class PlatformMessage extends Model implements Sortable
{
    use HasBlocks, HasPosition;

    protected $fillable = [
        'published',
        'title',
        'message_type',
        'is_recurrent',
        'recurrent_frequency',
        'sent_status',
        'next_run',
        'sectors',
        'position',
    ];

    protected $casts = [

    'admin_role' => 'array',
    'sectors'=>'array',
    


    ];

    // protected $appends = ['selected_roles'];


    public function userMessages()
    {
        return $this->hasMany(PlatformUserMessage::class, 'platform_message_id');
    }
    
public function getSectorsAttribute($value)

{

    return collect(json_decode($value))->map(function($item) {

        return ['id' => $item];

    })->all();

}

 

        public function setSectorsAttribute($value)

        {

            $this->attributes['sectors'] = collect($value)->filter()->values();

        }
}
