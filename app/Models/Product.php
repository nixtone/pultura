<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $guarded = false;

    public function getFilesAttribute($value) {
        foreach(Storage::disk('local')->files("/public/product/{$this->id}") as $file) {
            $result[pathinfo($file, PATHINFO_FILENAME)] = str_replace("public", "storage", $file);
        }
        return $result ?? [];
    }

    public function Category() {
        return $this->belongsTo(Category::class);
    }
}
