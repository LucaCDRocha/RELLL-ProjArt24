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
        'open_seasons',
        'tag_id',
        'location_id',
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
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
