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

    # Список платежей
    public function Pay() {
        return $this->hasMany(Pay::class);
    }

    public function getPayTotalAttribute() {
        $payTotal = 0;
        foreach($this->hasMany(Pay::class) as $pay) {
            $payTotal += $pay->amount;
        }
        return $payTotal;
    }

    # Смета на русском
    public function getEstimateRUAttribute() {
        $conLabel = [
            'model' => "Модель",
            'size' => "Размер",
            'material' => "Материал",
            'grave' => "Гравировки",
            'portrait' => "Портреты",
            'text' => "Тексты",
            'face' => "Облицовка",
            'tombstone' => "Цветник / надгробие",
            'fence' => "Ограда",
            'vase' => "Вазы",
            'services' => "Услуги"
        ];
        $estimateRU = [];
        foreach($this->estimate['order'] as $label => $orderItem) {
            // $estimateRU[$this->conLabel($label)] = $orderItem;
            $estimateRU[$conLabel[$label]] = $orderItem;
        }
        return $estimateRU;
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

    # Дата создания на русском
    public function getCreatedAtRuAttribute() {
        return Carbon::parse($this->created_at)->translatedFormat("d F Y / H:i");
    }

    public function getEskizAttribute() {

        $eskizPath = "storage/order/".$this->id."/eskiz/eskiz.png";
        return asset($eskizPath);

        // Проверка существования файла (не срабатывает)
        return Storage::disk('local')->exists($eskizPath);
        return Storage::fileExists($eskizPath);
        return Storage::disk('public')->exists($eskizPath);
    }

    public function getClientFileAttribute() {
        $fileList = [];
        foreach(Storage::files('/public/order/'.$this->id.'/client') as $filePath) {
            $fileList[basename($filePath)] = str_replace("public", "storage", $filePath);
        }
        return $fileList;
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
