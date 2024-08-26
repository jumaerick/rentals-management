<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'name',
        'company_id',
        'property_code',
        'location',

    ];

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function room(){
        return $this->hasMany(Room::class, 'property_code', 'property_code');
    }

}
