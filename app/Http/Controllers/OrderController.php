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

    // Список заказов
    public function list() {
        $orderList = Order::all()->reverse();
        return view('order.list', compact('orderList'));
    }

    // Страница создания заказа
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

    // Обработка создания заказа
    public function store(OrderRequest $request) {

        # Подготовка данных
        $orderData = $request->validated();
        $orderData['services'] = serialize($orderData['services']);
        // Вынос платежа
        $payment = $orderData['payment'];
        unset($orderData['payment']);
        // Вынос эскиза
        $eskiz = $orderData['eskiz'];
        unset($orderData['eskiz']);
        // Подготовка даты дедлайн
        $orderData['deadline_date'] = prepareDate($orderData['deadline_date']);


        # Создаем заказ
        $newOrder = Order::create($orderData);

        # Файлы от клиента
        // $eskiz

        # Прием оплаты
        if($payment) {
            $payStatus = Pay::create([
                'amount' => $payment,
                // 'comment' => '',
                'order_id' => $newOrder->id,
            ]);
        }

        # На страницу заказа
        return redirect()->route('order.item', $newOrder->id);
    }

    public function conLabel($key = '') {
        $conLabel = [
            'model' => "Модель",
            'size' => "Размер",
            'material' => "Материал",
            'grave' => "Гравировки",
            'portrait' => "Портреты",
            'text' => "Тексты",
            'face' => "Облицовка",
            'tombstone' => "Цветник / надгробие",
            'fence' => "Ограда",
            'vase' => "Вазы",
            'services' => "Услуги"
        ];
        return empty($key) ? $conLabel : $conLabel[$key];
    }

    // Страница заказа
    public function item(Order $order) {

        # Сбор данных
        $statusList = Status::all();
        $paymentList = $order->pay;

        // dump($this->conLabel('model'));

        /*
        $productList = Product::all();
        $order->model = Product::find($order->model);
        $order->material = Product::find($order->material);
        $order->portrait = Product::find($order->portrait);

        $categoryList = Category::all();

        // Калькуляция оплаты
        $order->paid = 0;
        foreach($order->pay as $pay) $order->paid += $pay->amount;
        $order->remain = $order->price_list['total'] - $order->paid;
        // Шаблон страницы
        */
        return view('order.item', compact('order', 'statusList', 'paymentList')); // , 'productList', 'categoryList'
    }

    // ajax-запрос сметы
    public function price(Request $request) {
    //public function test() {

        //
        $priceList = objectToArray(json_decode($request->price_list));
        $order = [];
        $price = 0;

        /* ---------------------------------------------- */

        // Модель
        // TODO: Материал (там цена за куб). Цена модель+размер+материал


        foreach($priceList['model'] as $model) {

            $model = Product::where('id', $model)->get();
            $model_category = Category::where('id', $model->pluck('category_id')->first())->get()->pluck('name')->first();
            $model_name = $model->pluck('name')->first();
            $model_size = Product::where('id', $priceList['size'])->get()->pluck('name')->first();
            $model_material = Product::where('id', $priceList['material'])->get()->pluck('name')->first();

            $price += $model->pluck('price')->first();
            $order['model'][] = [
                'label' => "Категория: <strong>".$model_category."</strong> / Модель: <strong>".$model_name."</strong> / размер: <strong>".$model_size."</strong> / материал: <strong>".$model_material."</strong>",
                'category' => $model_category,
                'model_name' => $model_name,
                'size' => $model_size,
                'material' => $model_material,
                'count' => 1,
                'subtotal' => $model->pluck('price')->first(),
                'total' => $model->pluck('price')->first()
            ];
        }

        // Гравировки
        foreach(array_merge($priceList['portrait'], $priceList['grave']) as $grave) {
            $grave = Product::where('id', $grave)->get();
            $price += $grave->pluck('price')->first();
            $order['grave'][] = [
                'label' => Category::where('id', $grave->pluck('category_id')->first())->get()->pluck('name')->first()." / ".$grave->pluck('name')->first(),
                'count' => 1,
                'subtotal' => $grave->pluck('price')->first(),
                'total' => $grave->pluck('price')->first()
            ];
        }

        // Тексты
        if(!empty($priceList['text'])) {
            $productTextCollect = Product::where('category_id', 28)->get();
            foreach($productTextCollect as $productText) {
                $order['text'][$productText['slug']] = [
                    'label' => $productText['name'],
                    'count' => 0,
                    'subtotal' => $productText['price'],
                    'total' => 0,
                ];
            }
            foreach($priceList['text'] as $arText) {
                foreach($arText as $textSlug => $textItem) {
                    ++$order['text'][$textSlug]['count'];
                    $order['text'][$textSlug]['total'] +=
                        $textSlug == "epitafia" ?
                            mb_strlen(trim(str_replace(" ", "", $textItem))) * $order['text'][$textSlug]['subtotal'] :
                            $order['text'][$textSlug]['subtotal'];
                }
            }
            foreach($order['text'] as $slug => $textItem) {
                if(!$textItem['count'])
                    unset($order['text'][$slug]);
                else
                    $price += $textItem['total'];
            }
        }

        // Цветник / надгробие
        if($priceList['tombstone']) {
            $tombstone = Product::where('id', $priceList['tombstone'])->get();
            $price += $tombstone->pluck('price')->first();
            $order['tombstone'][] = [
                'label' => $tombstone->pluck('name')->first(),
                'count' => 1,
                'subtotal' => $tombstone->pluck('price')->first(),
                'total' => $tombstone->pluck('price')->first()
            ];
        }

        // Ограда
        if($priceList['fence']) {
            $fence = Product::where('id', $priceList['fence'])->get();
            $price += $fence->pluck('price')->first();
            $order['fence'][] = [
                'label' => $fence->pluck('name')->first(),
                'count' => 1,
                'subtotal' => $fence->pluck('price')->first(),
                'total' => $fence->pluck('price')->first()
            ];
        }

        // Вазы
        if($priceList['vase']) {
            $vase = Product::where('id', $priceList['vase'])->get();
            $price += $vase->pluck('price')->first();
            $order['vase'][] = [
                'label' => $vase->pluck('name')->first(),
                'count' => 1,
                'subtotal' => $vase->pluck('price')->first(),
                'total' => $vase->pluck('price')->first()
            ];
        }

        // Облицовки
        if($priceList['face']) {
            $face = Product::where('id', $priceList['face']['facing'])->get(); // ->pluck('price')->first()
            $facePrice = $face->pluck('price')->first();
            $faceTotal = $facePrice * $priceList['face']['m2'];
            $order['face'][] = [
                'label' => $face->pluck('name')->first(),
                'count' => $priceList['face']['m2'],
                'subtotal' => $facePrice,
                'total' => $faceTotal
            ];
            $price += $faceTotal;
        }


        // Услуги
        $services = $request->services;
        // Доставка
        if($services['delivery']['km']) {
            $deliveryPrice = [
                'for10km' => Product::where('id', 269)->get()->pluck('price')->first(),
                'perkm' => Product::where('id', 270)->get()->pluck('price')->first()
            ];
            $deliveryTotal = $deliveryPrice['for10km'];
            if($services['delivery']['km'] > 10) {
                $deliveryTotal += ($services['delivery']['km'] - 10) * $deliveryPrice['perkm'];
            }
            $order['services']['delivery'] = [
                'label' => "Доставка",
                'count' => $services['delivery']['km'],
                'subtotal' => '',
                'total' => $deliveryTotal
            ];
            $price += $deliveryTotal;
        }
        // Установка
        if($services['install']) {
            $order['services']['install'] = [
                'label' => "Установка",
                'count' => 1,
                'subtotal' => $services['install'],
                'total' => $services['install']
            ];
            $price += $services['install'];
        }
        // Демонтаж
        if($services['deinstall']) {
            $order['services']['deinstall'] = [
                'label' => "Демонтаж",
                'count' => 1,
                'subtotal' => $services['deinstall'],
                'total' => $services['deinstall']
            ];
            $price += $services['deinstall'];
        }




        //
        //return response()->json($face, 200);
        return response()->json(['order' => $order, 'price' => $price], 200);
        //return view('test', compact('order', 'price'));
    }

}

