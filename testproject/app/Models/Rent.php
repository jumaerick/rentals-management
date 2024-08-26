<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    public $fillable = [
        'room_code',
        'property_code',
        'amount',
        'deposit',
        'year',
        'month',
    ];
}
