<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    public $fillable = [
        'room_id',
        'amount',
        'deposit',
        'rent_date',
    ];

    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function payment(){
        return $this->hasMany(Payment::class, 'room_id','room_id');
    }
    
}
