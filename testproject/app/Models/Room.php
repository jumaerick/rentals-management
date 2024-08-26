<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public $fillable = [
        'room_code',
        'company_id',
        'property_code',
    ];

    public function property(){
        return $this->belongsTo(Property::class, 'property_code', 'property_code');
    }
}
