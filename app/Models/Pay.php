<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function Order() {
        return $this->belongsTo(Order::class);
    }

    public function getCreatedAtRuAttribute($value) {
        return Carbon::parse($this->created_at)->translatedFormat("d F Y / H:i");
    }
}
