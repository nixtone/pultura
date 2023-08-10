<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Size;

class Order extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $guarded = false;

    public function getFilesAttribute($value) {
        foreach(Storage::files("/public/order/{$this->id}/files") as $file) {
            $result[pathinfo($file, PATHINFO_FILENAME)] = str_replace("public", "storage", $file);
        }
        return $result ?? [];
    }

    public function getEskizAttribute() {
        return str_replace("public", "storage", Storage::files("/public/order/{$this->id}")[0]);
    }

    public function getBirthDateAttribute($value) {
        return date("d.m.Y", strtotime($value));
    }

    public function getDeathDateAttribute($value) {
        return date("d.m.Y", strtotime($value));
    }

    public function getPriceListAttribute($value) {
        return unserialize($value);
    }

    public function getModelSizeAttribute($value) {
        if(!$value) return '';
        $size = Size::find($value);
        return $size->width." x ".$size->height." x ".$size->thick;
    }

    public function Client() {
        return $this->belongsTo(Client::class);
    }

    public function Status() {
        return $this->belongsTo(Status::class);
    }

    public function Pay() {
        return $this->hasMany(Pay::class);
    }
}
