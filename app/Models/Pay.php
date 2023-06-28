<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function Order() {
        return $this->belongsTo(Order::class);
    }
}
