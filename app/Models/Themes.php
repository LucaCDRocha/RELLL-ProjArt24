<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Themes extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function trails()
    {
        return $this->belongsToMany(Trail::class);
    }
}
