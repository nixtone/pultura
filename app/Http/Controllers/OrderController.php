<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
class OrderController extends Controller
{
    public function list() {
        $orderList = Order::all();
        return view('order.list', compact('orderList'));
    }

    public function item(Order $order) {
        // $order = Order::find($id);
        return view('order.item', compact('order'));
    }

    public function create() {
        return view('order.create');
    }
}
