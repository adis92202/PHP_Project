<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    public function game(): \Illuminate\Contracts\Database\Eloquent\Builder
    {
        return $this->belongsTo(Game::class);
    }
    public function user(): \Illuminate\Contracts\Database\Eloquent\Builder
    {
        return $this->belongsTo(User::class);
    }
}
