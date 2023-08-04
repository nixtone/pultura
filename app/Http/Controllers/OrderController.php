<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use http\Client\Response;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Client;
use App\Models\Pay;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use App\Models\Status;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    protected $filePath = "/public/order/";

    public function list() {
        $orderList = Order::all()->reverse();
        return view('order.list', compact('orderList'));
    }

    public function item(Order $order) {

        // Сбор данных
        $productList = Product::all();
        $order->model = Product::find($order->model);
        $order->material = Product::find($order->material);
        $order->portrait = Product::find($order->portrait);
        $statusList = Status::all();
        $categoryList = Category::all();

        // Калькуляция оплаты
        $order->paid = 0;
        foreach($order->pay as $pay) $order->paid += $pay->amount;
        $order->remain = $order->price_list['total'] - $order->paid;
        // Шаблон страницы
        return view('order.item', compact('order', 'productList', 'categoryList', 'statusList'));
    }

    public function create() {
        $clientList = Client::all()->reverse();
        $categoryList = Category::all();
        $productList = Product::all();
        $sizeList = Size::all();
        $clientID = request()->get('client');
        return view('order.create', compact('clientList', 'categoryList', 'productList', 'sizeList', 'clientID'));
    }

    public function store(OrderRequest $request)
    {

        # Стандартная валидация
        $data = $request->validated();

        # Статус
        $data['status_id'] = 1;

        # Клиент
        $client_id = $request->client_id;
        if(!$request->client_id) {
            $newClient = Client::create([
                'name' => $request->name,
                'phone' => $request->phone,
            ]);
            $client_id = $newClient->id;
        }
        $data['client_id'] = $client_id;

        # Аутентифицированный пользователь
        $data['user_id'] = Auth::user()->id;

        // Внешний вид памятника
        $data['model'] = $request->model ?? 0;
        $data['model_size'] = $request->model_size ?? '';
        $data['material'] = $request->material ?? 0;
        $data['portrait'] = $request->portrait ?? 0;

        // Текст для памятника
        $data['lastname'] = $request->lastname ?? '';
        $data['firstname'] = $request->firstname ?? '';
        $data['fathername'] = $request->fathername ?? '';
        if($request->birth_date) $data['birth_date'] = date("Y-m-d", strtotime($request->birth_date));
        if($request->death_date) $data['death_date'] = date("Y-m-d", strtotime($request->death_date));
        $data['epitafia'] = $request->epitafia ?? '';

        // Гравировка
        $data['crescent'] = $request->crescent ?? 0;
        $data['cross'] = $request->cross ?? 0;
        $data['flower'] = $request->flower ?? 0;
        $data['icon'] = $request->icon ?? 0;
        $data['branch'] = $request->branch ?? 0;
        $data['candle'] = $request->candle ?? 0;
        $data['angel'] = $request->angel ?? 0;
        $data['bird'] = $request->bird ?? 0;

        // Дополнения
        $data['tombstone'] = $request->tombstone ?? 0;
        $data['fence'] = $request->fence ?? 0;
        $data['vase'] = $request->vase ?? 0;

        // Облицовка
        $data['face_m2'] = $request->face_m2 ?? 0;
        $data['facing'] = $request->facing ?? 0;

        // Услуги
        $data['delivery_km'] = $request->delivery_km ?? 0;
        $data['delivery_addr'] = $request->delivery_addr ?? '';
        $data['install'] = $request->install ?? 0;
        $data['deinstall'] = $request->deinstall ?? 0;

        // Остальное
        if($request->deadline_date) $data['deadline_date'] = date("Y-m-d", strtotime($request->deadline_date));
        $data['comment'] = $request->comment ?? '';
        $data['price_list'] = $request->price_list ?? ''; // Смета

        # Создаем заказ
        $newItem = Order::create($data);

        # Файлы
        $newDir = $this->filePath.$newItem->id;
        Storage::makeDirectory($newDir);


        // от клиента
        if($request->hasFile('files')) {
            $dir = Storage::makeDirectory($newDir."/files");
            foreach($request->file('files') as $index => $file) {
                $filename = $file->getClientOriginalName();
                $file->storeAs($newDir."/files", $filename);
                $arFiles[] = $filename;
            }
        }
        // эскиз
        //dd($request->eskiz_image);
        /*
        file_put_contents(
            $_SERVER['DOCUMENT_ROOT']."/storage/app".$this->filePath.$newItem->id."/eskiz.png",
            base64_decode(str_replace("data:image/png;base64,", "", file_get_contents($request->eskiz_image)))
        );
        */
        // storage\app\public\order\4
        //$file->storeAs($newDir, base64_decode(str_replace("data:image/png;base64,", "", file_get_contents($request->eskiz_image))));

        // disk('public')->
        Storage::put(
            $newDir.'/eskiz.png',
            base64_decode(str_replace("data:image/png;base64,", "", $request->eskiz_image))
        );


        # Прием оплаты
        if($request->pay_amount) {
            Pay::create([
                'amount' => $request->pay_amount,
                'comment' => $request->pay_comment,
                'order_id' => $newItem->id,
            ]);
        }

        # На страницу заказа
        return redirect()->route('order.item', $newItem->id);
    }

    public function edit(Order $order) {
        return view('order.edit', compact('order'));
    }

    public function update(OrderRequest $request, Order $order) {
        $data = $request->validated();
        $order->update($data);
        // TODO: полное очко с датами, в базе Ymd а нужно dmY
        return redirect()->route('order.item', $order->id);
    }

    public function destroy(Order $order) {
        $order->delete();
        return redirect()->route('home');
    }

    public function pdf(Order $order) {

        // Сбор данных
        $order->model = Product::find($order->model);
        $order->material = Product::find($order->material);
        $order->portrait = Product::find($order->portrait);
        $statusList = Status::all();
        $categoryList = Category::all();

        // Формируем PDF
        $pdf = Pdf::loadView('order.pdf', compact('order'));
        $pdf->setOption([
            'defaultPaperSize' => "a4",
            'defaultFont' => 'dejavu serif',
            // "default_font" => "dejavu serif",
            // 'dpi' => 150,
        ]);

        //
        return $pdf;
    }
    public function pdfStream(Order $order) {
        return $this->pdf($order)->stream();
    }

    public function pdfDownload(Order $order) {
        return $this->pdf($order)->download('Заказ '.$order->id);
    }

    public function contract(Order $order) {
        // Сбор данных
        $order->model = Product::find($order->model);
        $order->material = Product::find($order->material);
        $order->portrait = Product::find($order->portrait);
        $statusList = Status::all();
        $categoryList = Category::all();

        // Формируем PDF
        $pdf = Pdf::loadView('order.contract', compact('order'));
        $pdf->setOption([
            'defaultPaperSize' => "a4",
            'defaultFont' => 'dejavu serif',
            // "default_font" => "dejavu serif",
            // 'dpi' => 150,
        ]);

        //
        return $pdf->stream();
    }

    public function price() {

        // Сбор данных
        $data = $_POST;
        $productList = Product::all();
        $price = [
            'total' => 0,
            'stella' => 0,
            'epitafia' => 0,
            'facing' => 0,
            'delivery_km' => 0,
            'install' => 0,
            'deinstall' => 0,
        ];

        /* ------------------------ */


        // Модель, материал
        if(!empty($data['model_size']) AND !empty($data['material'])) {
            $size = Size::find((int)$data['model_size']);
            $obyem = ($size['width'] * $size['height'] * $size['thick']) / 1000000;
            $materialPrice = $productList[(int)$data['material']]->price;
            $total = $obyem * $materialPrice;
            $price['stella'] = $total;
            $price['total'] = $total;
        }

        // Эпитафия
        if(!empty($data['epitafia'])) {
            $total = mb_strlen(str_replace(" ", "", $data['epitafia'])) * $productList->where('id', 276)->first()->price;
            $price['epitafia'] = $total;
            $price['total'] += $total;
        }

        # Облицовка
        if(!empty($data['facing']) AND !empty($data['face_m2'])) {
            $total = $productList->where('id', (int)$data['facing'])->first()->price * (int)$data['face_m2'];
            $price['facing'] = $total;
            $price['total'] += $total;
        }

        # Услуги

        // Доставка
        if(!empty($data['delivery_km'])) {
            $do10km = $productList->find(269)->price;
            $zakm = $productList->find(270)->price;

            $total = $do10km;

            if($data['delivery_km'] > 10) {
                $total += ($data['delivery_km'] - 10) * $zakm;
            }
            $price['delivery_km'] = $total;
            $price['total'] += $total;
        }
        // Установка
        if(!empty($data['install'])) {
            $price['install'] = $data['install'];
            $price['total'] += $data['install'];
        }
        // Демонтаж
        if(!empty($data['deinstall'])) {
            $price['deinstall'] = $data['deinstall'];
            $price['total'] += $data['deinstall'];
        }

        $arFields = [
            // Текст для памятника
            ['name' => 'portrait', 'where' => $data['portrait'] ?? null],
            ['name' => 'lastname', 'where' => 271],
            ['name' => 'firstname', 'where' => 272],
            ['name' => 'fathername', 'where' => 273],
            ['name' => 'birth_date', 'where' => 274],
            ['name' => 'death_date', 'where' => 275],
            //Гравировка
            ['name' => 'crescent', 'where' => $data['crescent'] ?? null],
            ['name' => 'cross', 'where' => $data['cross'] ?? null],
            ['name' => 'flower', 'where' => $data['flower'] ?? null],
            ['name' => 'icon', 'where' => $data['icon'] ?? null],
            ['name' => 'branch', 'where' => $data['branch'] ?? null],
            ['name' => 'candle', 'where' => $data['candle'] ?? null],
            ['name' => 'angel', 'where' => $data['angel'] ?? null],
            ['name' => 'bird', 'where' => $data['bird'] ?? null],
            // Дополнения
            ['name' => 'tombstone', 'where' => $data['tombstone'] ?? null],
            ['name' => 'fence', 'where' => $data['fence'] ?? null],
            ['name' => 'vase', 'where' => $data['vase'] ?? null],
        ];
        foreach($arFields as $field) {
            if(!empty($data[$field['name']])) {
                $total = $productList->where('id', $field['where'])->first()->price ?? 0;
                $price[$field['name']] = $total;
                $price['total'] += $total;
            }
        }

        // Смета
        $price['serialize'] = serialize($price);

        // Результат
        return json_encode($price);
    }
}

