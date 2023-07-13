<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function getImageAttribute($value) {
        return unserialize($value);
    }

    public function Category() {
        return $this->belongsTo(Category::class);
    }
}
