<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomAssignment extends Model
{
    use HasFactory;

    protected $table = 'rooms_assignments';

    public $fillable = 
    [
        'room_id',
        'user_id',
    ];

    public function user(){
        $this->belongsTo(User::class);
    }

    public function room(){
        $this->belongsTo(Room::class);
    }

}
