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

    public function list() {
        $orderList = Order::all()->reverse();
        return view('order.list', compact('orderList'));
    }

    public function create() { // создание заказа
        $clientList = Client::all()->reverse();
        // Если клиентов нет, отправляем его создавать
        if($clientList->isEmpty()) return redirect()->route('client.list');
        $categoryList = Category::all();
        $productList = Product::all();
        $sizeList = [
            30 => $productList->where('category_id', 30),
            31 => $productList->where('category_id', 31)
        ];
        $clientID = request()->get('client');
        return view('order.create', compact('clientList', 'categoryList', 'productList', 'sizeList', 'clientID'));
    }

    public function store(OrderRequest $request) {
        // dump($request);
        $data = $request->validated();
        dump($data);
    }

}

