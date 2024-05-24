<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    // Je ne pense pas que c'est nécessaire d'avoir ce tableau, à tester
    // ================================================================
    protected $fillable = [
        'latitude',
        'longitude',
    ];
    // ================================================================



}
