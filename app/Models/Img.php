<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Img extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'img_path',
    ];

    public function interestPoint()
    {
        return $this->belongsTo(InterestPoint::class);
    }
}
