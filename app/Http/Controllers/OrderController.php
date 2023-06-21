<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
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
        // TODO: вывод в обратном порядке
        $orderList = Order::all();
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
        return view('order.create');
    }

    public function edit(Order $order) {
        return view('order.edit', compact('order'));
    }
}
