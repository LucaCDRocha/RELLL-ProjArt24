<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trail extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'time',
        'description',
        'difficulty',
        'is_accessible',
        'is_approved',
        'location_start_id',
        'location_end_id',
    ];

    public function interest_points()
    {
        return $this->belongsToMany(InterestPoint::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function img()
    {
        return $this->belongsTo(Img::class);
    }

    public function location_start()
    {
        return $this->belongsTo(Location::class);
    }
    public function location_end()
    {
        return $this->belongsTo(Location::class);
    }
    public function location_parking()
    {
        return $this->belongsTo(Location::class);
    }

    public function themes()
    {
        return $this->belongsToMany(Theme::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Favorite::class);
    }

    public function historics()
    {
        return $this->hasMany(Historic::class);
    }

    public function rankings()
    {
        return $this->hasMany(Ranking::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function interest_points() {
        return $this->belongsToMany(InterestPoint::class);
    }
}
