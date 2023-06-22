<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Client;
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
    */

    public function list() {
        $orderList = Order::all()->reverse();
        /*
        foreach($orderList as $index => $order) {
            $orderList[$index]->status = $this->status[$order->status];
        }
        */
        return view('order.list', compact('orderList'));
    }

    public function item(Order $order) {
        return view('order.item', compact('order'));
    }

    public function create() {
        $clientList = Client::all()->reverse();
        return view('order.create', compact('clientList'));
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
        // Формируем массив заказа
        $data['status_id'] = 1;
        $data['client_id'] = $client_id;
        $data['fullname'] = implode(" ", [$request->lastname, $request->firstname, $request->fathername]);
        // Создаем заказ
        $newOrder = Order::create($data);
        return redirect()->route('order.item', $newOrder->id);
    }

    public function edit(Order $order) {
        return view('order.edit', compact('order'));
    }
}
