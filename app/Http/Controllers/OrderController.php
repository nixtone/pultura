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
        $order->remain = $order->total_amount - $order->paid;
        // Шаблон страницы
        return view('order.item', compact('order', 'productList', 'categoryList', 'statusList'));
    }

    public function create() {
        $clientList = Client::all()->reverse();
        $categoryList = Category::all();
        $productList = Product::all();
        $sizeList = Size::all();
        return view('order.create', compact('clientList', 'categoryList', 'productList', 'sizeList'));
    }

    public function store(OrderRequest $request)
    {
        // dd($request);

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

        // Внешний вид памятника
        $data['model'] = $request->model;
        $data['model_size'] = $request->model_size;
        $data['material'] = $request->material;
        $data['portrait'] = $request->portrait;

        // Текст для памятника
        $data['lastname'] = $request->lastname;
        $data['firstname'] = $request->firstname;
        $data['fathername'] = $request->fathername;
        if($request->birth_date) $data['birth_date'] = date("Y-m-d", strtotime($request->birth_date));
        if($request->death_date) $data['death_date'] = date("Y-m-d", strtotime($request->death_date));
        $data['epitafia'] = $request->epitafia;

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
        $data['delivery_addr'] = $request->delivery_addr;
        $data['install'] = $request->install;
        $data['deinstall'] = $request->deinstall;

        // Остальное
        $data['deadline_date'] = $request->deadline_date;
        $data['total_amount'] = $request->total_amount;
        $data['comment'] = $request->comment;


        # Создаем заказ
        $newItem = Order::create($data);

        # Файлы от клиента
        if($request->hasFile('files')) {
            $newDir = $this->filePath.$newItem->id;
            $dir = Storage::makeDirectory($newDir);
            foreach($request->file('files') as $index => $file) {
                $filename = $file->getClientOriginalName();
                $file->storeAs($newDir, $filename);
                $arFiles[] = $filename;
            }
        }

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

    public function price(OrderRequest $request) {

        // Сбор данных
        $productList = Product::all();
        $total = 0;

        /* ------------------------ */


        # Внешний вид памятника

        // Модель, материал
        if(!empty($_POST['model_size']) AND !empty($_POST['material'])) {
            $size = Size::find((int)$_POST['model_size']);
            $obyem = ($size['width'] * $size['height'] * $size['thick']) / 1000000;
            $materialPrice = $productList[(int)$_POST['material']]->price;
            $total += $obyem * $materialPrice;
            /*
            Найти объем (желательно сложить со стеллой) --- 80 x 40 x 5 = 16000
            Разделить на миллион --- 16000/1000000 = 0,016
            Умножить на стоимость материала за куб --- 0.016 x 600000 = 9600
            Надбавка за цвет 20% --- 9600 + 1920 = 11520
            */
        }
        // Портрет
        if(!empty($_POST['portrait'])) $total += $productList->where('id', $_POST['portrait'])->first()->price;


        # Текст для памятника

        // ФИО
        if(!empty($_POST['lastname'])) $total += $productList->where('id', 271)->first()->price;
        if(!empty($_POST['firstname'])) $total += $productList->where('id', 272)->first()->price;
        if(!empty($_POST['fathername'])) $total += $productList->where('id', 273)->first()->price;
        if(!empty($_POST['birth_date'])) $total += $productList->where('id', 274)->first()->price;
        if(!empty($_POST['death_date'])) $total += $productList->where('id', 275)->first()->price;
        // Эпитафия
        if(!empty($_POST['epitafia'])) {
            $total += mb_strlen(str_replace(" ", "", $_POST['epitafia'])) * $productList->where('id', 276)->first()->price;
        }


        # Гравировка
        if(!empty($_POST['crescent'])) $total += $productList->where('id', $_POST['crescent'])->first()->price;
        if(!empty($_POST['cross'])) $total += $productList->where('id', $_POST['cross'])->first()->price;
        if(!empty($_POST['flower'])) $total += $productList->where('id', $_POST['flower'])->first()->price;
        if(!empty($_POST['icon'])) $total += $productList->where('id', $_POST['icon'])->first()->price;
        if(!empty($_POST['branch'])) $total += $productList->where('id', $_POST['branch'])->first()->price;
        if(!empty($_POST['candle'])) $total += $productList->where('id', $_POST['candle'])->first()->price;
        if(!empty($_POST['angel'])) $total += $productList->where('id', $_POST['angel'])->first()->price;
        if(!empty($_POST['bird'])) $total += $productList->where('id', $_POST['bird'])->first()->price;


        # Дополнения
        if(!empty($_POST['tombstone'])) $total += $productList->where('id', $_POST['tombstone'])->first()->price;
        if(!empty($_POST['fence'])) $total += $productList->where('id', $_POST['fence'])->first()->price;
        if(!empty($_POST['vase'])) $total += $productList->where('id', $_POST['vase'])->first()->price;


        # Облицовка
        if(!empty($_POST['facing']) AND !empty($_POST['face_m2'])) {
            $total += $productList->where('id', (int)$_POST['facing'])->first()->price * (int)$_POST['face_m2'];
        }


        # Услуги

        // Доставка
        if(!empty($_POST['delivery_km'])) {
            $do10km = $productList->where('id', 269)->first()->price;
            $zakm = $productList->where('id', 270)->first()->price;

            $total += $do10km;

            if($_POST['delivery_km'] > 10) {
                $total += ($_POST['delivery_km'] - 10) * $zakm;
            }
        }
        // Установка
        if(!empty($_POST['install'])) $total += $_POST['install'];
        // Демонтаж
        if(!empty($_POST['deinstall'])) $total += $_POST['deinstall'];


        // Результат
        return json_encode($total);
    }
}
