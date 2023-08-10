<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function Orders() {
        return $this->hasMany(Order::class);
    }

    public function getClientCategoryAttribute($cat_id) {
        return $cat_id ? ClientCategory::find($cat_id) : $cat_id ;
    }
}
