<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'time',
        'description',
        'open_hour',
        'close_hour',
        'url',
        'open_season',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function imgs()
    {
        return $this->hasMany(Img::class);
    }
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
