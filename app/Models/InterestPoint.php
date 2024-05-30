<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'url',
        'open_season',
    ];

    public function trails()
    {
        return $this->belongsToMany(Trail::class);
    }

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
