<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'order',
        'status'
    ];

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}
