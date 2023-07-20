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
        return view('order.item', compact('order', 'categoryList', 'statusList'));
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
        // Назначаем клиента
        $client_id = $request->client_id;
        if(!$request->client_id) {
            $newClient = Client::create([
                'name' => $request->name,
                'phone' => $request->phone,
            ]);
            $client_id = $newClient->id;
        }

        // Стандартная валидация
        $data = $request->validated();

        // Формируем данные заказа
        $data['client_id'] = $client_id;
        $data['status_id'] = 1;
        //
        $data['model'] = $request->model;
        $data['model_size'] = $request->model_size;
        $data['material'] = $request->material;
        $data['portrait'] = $request->portrait;



        //
        $data['lastname'] = $request->lastname;
        $data['firstname'] = $request->firstname;
        $data['fathername'] = $request->fathername;
        if($request->birth_date) $data['birth_date'] = date("Y-m-d", strtotime($request->birth_date));
        if($request->death_date) $data['death_date'] = date("Y-m-d", strtotime($request->death_date));
        $data['epitafia'] = $request->epitafia;
        //
        /*
        $data['cross'] = $request->cross;
        */
        $data['delivery_addr'] = $request->delivery_addr;
        $data['delivery_km'] = $request->delivery_km;

        $data['comment'] = $request->comment;

        $data['total_amount'] = $request->total_amount;

        // Создаем заказ


        $newItem = Order::create($data);

        // Файлы от клиента
        if($request->hasFile('files')) {
            $newDir = $this->filePath.$newItem->id;
            $dir = Storage::makeDirectory($newDir);
            foreach($request->file('files') as $index => $file) {
                $filename = $file->getClientOriginalName();
                $file->storeAs($newDir, $filename);
                $arFiles[] = $filename;
            }
        }

        // Прием оплаты
        if($request->pay_amount) {
            Pay::create([
                'amount' => $request->pay_amount,
                'comment' => $request->pay_comment,
                'order_id' => $newItem->id,
            ]);
        }

        // На страницу заказа
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

        //return view("order.pdf");

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
        return $pdf->stream();
        // return $pdf->download('invoice.pdf');
    }

    public function price(OrderRequest $request) {
        $total = 0;
        // Сбор данных
        $productList = Product::all();
        // Стоимость памятника
        if(!empty($_POST['model_size']) AND !empty($_POST['material'])) {
            $size = Size::find((int)$_POST['model_size']);
            $obyem = ($size['width'] * $size['height'] * $size['thick']) / 1000000;
            $materialPrice = $productList[(int)$_POST['material']]->price;
            /*
            Найти объем (желательно сложить со стеллой) --- 80 x 40 x 5 = 16000
            Разделить на миллион --- 16000/1000000 = 0,016
            Умножить на стоимость материала за куб --- 0.016 x 600000 = 9600
            Надбавка за цвет 20% --- 9600 + 1920 = 11520
            */
            $total += $obyem * $materialPrice;
        }
        // ФИО
        if(!empty($_POST['lastname']) AND !empty($_POST['firstname']) AND !empty($_POST['fathername'])) {
            $total += 2500;
        }
        // Эпитафия
        if(!empty($_POST['epitafia'])) {
            $total += mb_strlen($_POST['epitafia']) * $productList->where('id', 274)->first()->price;
        }
        // Облицовка
        if(!empty($_POST['face']) AND !empty($_POST['face_km'])) {
            $total += $productList->where('id', (int)$_POST['face'])->first()->price * (int)$_POST['face_km'];
        }
        // Доставка
        if(!empty($_POST['delivery_km'])) {
            $do10km = $productList->where('id', 269)->first()->price;
            $zakm = $productList->where('id', 270)->first()->price;

            $total += $do10km;

            if($_POST['delivery_km'] > 10) {
                $total += ($_POST['delivery_km'] - 10) * $zakm;
            }
        }




        //return json_encode($face); // ->price
        return json_encode($total);
        return json_encode($_POST);
    }
}
