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




    /* ---------------------------- */


    /*
    public function price(Request $request) {
        // TODO: собрать цены (конструктор, услуги, корректировка), сформировать labelы
        $price = "Хорошая погода --- ".$request;

        $price = json_decode($request->input('price_list')); // ->material
        // Результат
        return json_encode($price);
        return response()->json(array('msg'=> $msg), 200);
    }
    */
    public function price(Request $request) {

        // $data = objectToArray(json_decode('{"model":[1],"size":285,"material":148,"portrait":[157],"grave":[175,230,214,217],"text":{"1":{"lastname":"test1","firstname":"test2","fathername":"test3"},"2":{"lastname":"test21","firstname":"test22","fathername":"test23","birth_date":"05.10.1980","death_date":"23.02.2021","epitafia":"\u041f\u043b\u043e\u0445\u0430\u044f \u043f\u043e\u0433\u043e\u0434\u0430"}},"face":[],"tombstone":259,"fence":0,"vase":0}'));


        // return response()->json($request->price_list, 200);
        $priceList = objectToArray(json_decode($request->price_list));
        /* --------------------------------------- */

        $order = [];
        $price = 0;

        // Модель
        foreach($priceList['model'] as $model) {
            $model = Product::where('id', $model)->get();
            $price += $model->pluck('price')->first();
            $order['model'][] = [
                'label' => Category::where('id', $model->pluck('category_id')->first())->get()->pluck('name')->first()." / ".$model->pluck('name')->first(),
                'price' => $model->pluck('price')->first()
            ];
        }

        // Размер TODO: применить к модели
        if($priceList['size']) {
            $size = Product::where('id', $priceList['size'])->get();
            $price += $size->pluck('price')->first();
            $order['size'] = [
                'label' => Category::where('id', $size->pluck('category_id')->first())->get()->pluck('name')->first()." / ".$size->pluck('name')->first(),
                'price' => $size->pluck('price')->first()
            ];
        }

        // Материал
        if($priceList['material']) {
            $material = Product::where('id', $priceList['material'])->get();
            $price += 0; // $material->pluck('price')->first(); // там цена за куб
            $order['material'] = [
                'label' => Category::where('id', $material->pluck('category_id')->first())->get()->pluck('name')->first()." / ".$material->pluck('name')->first(),
                'price' => 0 // $material->pluck('price')->first(),
            ];
        }

        // Гравировки
        foreach(array_merge($priceList['portrait'], $priceList['grave']) as $grave) {
            $grave = Product::where('id', $grave)->get();
            $price += $grave->pluck('price')->first();
            $order['grave'][] = [
                'name' => Category::where('id', $grave->pluck('category_id')->first())->get()->pluck('name')->first()." / ".$grave->pluck('name')->first(),
                'price' => $grave->pluck('price')->first()
            ];
        }

        // Тексты
        $productTextCollect = Product::where('category_id', 28)->get();
        $textPrice = [];
        $textLabel = [];
        foreach($productTextCollect as $productText) {
            $textPrice[$productText['slug']] = $productText['price'];
            $textLabel[$productText['slug']] = $productText['name'];
        }
        foreach($priceList['text'] as $textIndex => $arText) {
            foreach($arText as $textSlug => $textItem) {
                $anotherPrice = $textSlug == "epitafia" ? mb_strlen(trim(str_replace(" ", "", $textItem))) * $textPrice[$textSlug] : $textPrice[$textSlug];
                $price += $anotherPrice;
                $order['text'][$textIndex][] = [
                    'name' => $textLabel[$textSlug],
                    'price' => $anotherPrice
                ];
            }
        }

        // Облицовки
        // $order['face'] = Product::where('id', $data['face'])->get()->pluck('name')->first(); // TODO: пригнать данные

        // Цветник / надгробие
        if($priceList['tombstone']) {
            $tombstone = Product::where('id', $priceList['tombstone'])->get();
            $price += $tombstone->pluck('price')->first();
            $order['tombstone'] = [
                'label' => $tombstone->pluck('name')->first(),
                'price' => $tombstone->pluck('price')->first()
            ];
        }

        // Ограда
        if($priceList['fence']) {
            $fence = Product::where('id', $priceList['fence'])->get();
            $price += $fence->pluck('price')->first();
            $order['fence'] = [
                'name' => $fence->pluck('name')->first(),
                'price' => $fence->pluck('price')->first()
            ];
        }

        // Вазы
        if($priceList['vase']) {
            $vase = Product::where('id', $priceList['vase'])->get();
            $price += $vase->pluck('price')->first();
            $order['vase'] = [
                'name' => $vase->pluck('name')->first(),
                'price' => $vase->pluck('price')->first()
            ];
        }


        // Посчитать цену


        return response()->json(['order' => $order, 'price' => $price], 200);
        return view('test', compact('order', 'price'));
    }

}

