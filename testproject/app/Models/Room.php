<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public $fillable = [
        'room_code',
        'property_id',
    ];

    public function property(){
        return $this->belongsTo(Property::class);
    }

    public function rent(){
        return $this->hasOne(Rent::class);
    }

    public function payment(){
        return $this->hasMany(Payment::class, 'room_id', 'room_id');
    }
}
