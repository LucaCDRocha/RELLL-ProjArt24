<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    use HasFactory;

    protected $fillable = [
        'note'
    ];

    public function trail()
    {
        return $this->belongsTo(Trail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
