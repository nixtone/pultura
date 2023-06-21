<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
class OrderController extends Controller
{
    public function list() {
        // TODO: вывод в обратном порядке
        $orderList = Order::all();
        return view('order.list', compact('orderList'));
    }

    public function item(Order $order) {
        return view('order.item', compact('order'));
    }

    public function create() {
        return view('order.create');
    }
}
