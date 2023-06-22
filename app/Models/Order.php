<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = false;

    /*
    protected $appends = [
        'statusLabel'
    ];
    public function getStatusLabelAttribute() {
        switch ($this->status) {
            case 1: return 'Принят'; break;
            case 2: return 'Выполняется'; break;
            case 3: return 'Готов'; break;
        }
    }
    */

    public function Client() {
        return $this->belongsTo(Client::class);
    }

    public function Status() {
        return $this->belongsTo(Status::class);
    }
}
