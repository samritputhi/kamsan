<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        "title","category_id","order","status","image","des"
    ];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
