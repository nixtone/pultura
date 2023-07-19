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
        $order->model = Product::find($order->model);
        $order->material = Product::find($order->material);
        $order->portrait = Product::find($order->portrait);
        $statusList = Status::all();
        $categoryList = Category::all();
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

        // Создаем заказ
        //dd($data);
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
        return json_encode($_POST);
    }
}
