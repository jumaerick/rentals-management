<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public $fillable = [
        'room_id',
        'amount',
        'payment_method',
        'transaction_id',
    ];

    public function rent(){
        return $this->belongsTo(Rent::class, 'room_id','room_id');
    }
}
