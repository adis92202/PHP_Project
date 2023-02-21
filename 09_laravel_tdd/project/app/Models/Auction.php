<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'state',
        'description',
        'price',
        'email',
        'phone',
    ];

    public function user(): \Illuminate\Contracts\Database\Eloquent\Builder
    {
        return $this->belongsTo(User::class);
    }
}
