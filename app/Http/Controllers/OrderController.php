<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Client;
use App\Models\Pay;
use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{

    /*
    public $status;

    public function __construct()
    {
        $this->status = collect([
            1 => 'Принят',
            2 => 'Выполняется',
            3 => 'Готов'
        ]);
    }
    foreach($orderList as $index => $order) {
            $orderList[$index]->status = $this->status[$order->status];
        }
    */

    public function list() {
        $orderList = Order::all()->reverse();
        return view('order.list', compact('orderList'));
    }

    public function item(Order $order) {
        return view('order.item', compact('order'));
    }

    public function create() {
        $clientList = Client::all()->reverse();
        $categoryList = Category::all();
        $productList = Product::all();
        return view('order.create', compact('clientList', 'categoryList', 'productList'));
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
        $data['status_id'] = 1;
        $data['client_id'] = $client_id;
        //
        $data['lastname'] = $request->lastname;
        $data['firstname'] = $request->firstname;
        $data['fathername'] = $request->fathername;
        if($request->birth_date) $data['birth_date'] = date("Y-m-d", strtotime($request->birth_date));
        if($request->death_date) $data['death_date'] = date("Y-m-d", strtotime($request->death_date));
        $data['epitafia'] = $request->epitafia;

        // Создаем заказ
        $newOrder = Order::create($data);

        // Прием оплаты
        if($request->pay_amount) {
            Pay::create([
                'amount' => $request->pay_amount,
                'comment' => $request->pay_comment,
                'order_id' => $newOrder->id,
            ]);
        }

        // На страницу заказа
        return redirect()->route('order.item', $newOrder->id);
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
}
