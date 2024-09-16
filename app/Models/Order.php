<?php

namespace App\Models;

use Carbon\Carbon;
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



    public function Client() {
        return $this->belongsTo(Client::class);
    }

    public function Status() {
        return $this->belongsTo(Status::class);
    }

    public function getServicesAttribute($value) {
        return unserialize($value);
    }

    public function getPriceListAttribute($value) {
        return objectToArray(json_decode($value));
    }

    public function getEstimateAttribute($value) {
        return objectToArray(json_decode($value));
    }

    //
    public function getDeadlineDateRuAttribute($value) {
        return Carbon::parse($this->deadline_date)->translatedFormat("d F Y");
        //return date("d.m.Y", strtotime($value));
    }

    public function Pay() {
        return $this->hasMany(Pay::class);
    }

    /*
    public function getFilesAttribute($value) {
        foreach(Storage::files("/public/order/{$this->id}/files") as $file) {
            $result[pathinfo($file, PATHINFO_FILENAME)] = str_replace("public", "storage", $file);
        }
        return $result ?? [];
    }

    public function getEskizAttribute() {
        // return str_replace("public", "storage", Storage::files("/public/order/{$this->id}")[0]);
        //return str_replace("public", "storage", Storage::files("/public/order/{$this->id}")[0]);
        return "storage/order/".$this->id."/eskiz.png";
    }
    public function getEskizBase64Attribute() {
        return Storage::disk('public')->get("order/".$this->id."/eskiz.base64");
    }

    # Дедлайн на русском
    public function getDeadlineDateRuAttribute($value) {
        return Carbon::parse($this->deadline_date)->translatedFormat("d F Y");
    }

    # Сколько осталось дней?
    public function getDayRestAttribute() {
        $diff = Carbon::parse($this->deadline_date)->diffInDays(Carbon::now());
        if(Carbon::parse($this->deadline_date)->isPast()) $diff = 0;
        return $diff;
    }

    #
    public function getLevelAttribute() {
        $endPeriod = 10;
        $day = $this->dayRest;
        $level = 1;


        // 1 - много дней
        // 2 - остается 10 дней
        // 3 - сегодня
        // 4 - завершено

        switch($day) {
            case ($day <= $endPeriod): {
                $level = 2;
            } break;

            case (0): {
                if(Carbon::parse($this->deadline_date)->isCurrentDay()) {
                    $level = 3;
                }
                else {
                    $level = 4;
                }
            } break;

        }

        return $level;
    }

    # Дата создания на русском
    public function getCreatedAtRuAttribute() {
        return Carbon::parse($this->created_at)->translatedFormat("d F Y / H:i");
    }



    public function getModelSizeAttribute($value) {
        if(!$value) return '';
        $size = Size::find($value);
        return $size->width." x ".$size->height." x ".$size->thick;
    }



    public function Status() {
        return $this->belongsTo(Status::class);
    }


    */
}
