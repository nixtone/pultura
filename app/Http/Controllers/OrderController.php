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
        // файл от клиента
        if($request->hasFile('client_file')) {
            $clientFile = $orderData['client_file'];
            unset($orderData['client_file']);
        }
        // вынос эскиза
        $eskiz = $orderData['eskiz'];
        unset($orderData['eskiz']);
        // Подготовка даты дедлайн
        $orderData['deadline_date'] = prepareDate($orderData['deadline_date']);


        # Создаем заказ
        $newOrder = Order::create($orderData);

        # Файлы от клиента
        // $eskiz

        # Файлы
        $newDir = "/public/order/".$newOrder->id;
        Storage::makeDirectory($newDir);
        // от клиента
        if($request->hasFile('client_file')) {
            Storage::makeDirectory($newDir."/client");
            foreach($request->file('client_file') as $index => $file) {
                $filename = $file->getClientOriginalName();
                $file->storeAs($newDir."/client", $filename);
                // $arFiles[] = $filename;
            }
        }
        // Эскиз
        $newDirEskiz = $newDir."/eskiz";
        Storage::makeDirectory($newDirEskiz);
        $putEskiz = Storage::put(
            $newDirEskiz.'/eskiz.png',
            base64_decode(str_replace("data:image/png;base64,", "", $eskiz))
        );
        $putEskizBase64 = Storage::put($newDirEskiz.'/eskiz.base64', $eskiz);

        # Прием оплаты
        if($payment) {
            $payStatus = Pay::create([
                'amount' => $payment,
                'comment' => 'Аванс',
                'order_id' => $newOrder->id,
            ]);
        }

        # На страницу заказа
        return redirect()->route('order.item', $newOrder->id);
    }

    public function estimateTotal($order) {

        $result = ['payTotal' => 0];

        // Подсчет итога
        $result['paymentList'] = $order->pay;
        $payTotal = 0;
        foreach($result['paymentList'] as $pay) {
            $result['payTotal'] += $pay->amount;
        }

        // Разница итога и корректировки
        $result['diff_total'] = abs($order->price - $order->total_correct);

        // Кто в итоге?! Итог или корректировка (при наличии)
        $whoIsTotal = $order->total_correct ?? $order->price;
        // Остаток
        $result['rest'] = $whoIsTotal - $result['payTotal'];

        return $result;
    }

    // Страница заказа
    public function item(Order $order) {

        //dd($order->ClientFile);

        # Сбор данных
        $statusList = Status::all();
        $estimateTotal = $this->estimateTotal($order);

        # Вывод
        return view('order.item', compact(
            'order',
            'statusList',
            'estimateTotal',
        ));
    }

    // ajax-запрос сметы
    public function price(Request $request) {

        # Входные данные
        $priceList = objectToArray(json_decode($request->price_list));
        $order = [];
        $price = 0;

        /* ---------------------------------------------- */

        # Модель
        foreach($priceList['model'] as $model) {
            // сбор данных
            $modelData = Product::where('id', $model)->get();
            $model = [
                'category' => Category::where('id', $modelData->pluck('category_id')->first())->get()->pluck('name')->first(),
                'name' => $modelData->pluck('name')->first(),
                'size' => Product::where('id', $priceList['size'])->get()->pluck('name')->first(),
                'material' => Product::where('id', $priceList['material'])->get()
            ];
            // подсчет цены
            $model['volume'] = array_product(explode(" x ", $model['size'])) / 1000000; // объем
            $modelPrice = $model['volume'] * $model['material']->pluck('price')->first(); // объем * цена материала
            $price += $modelPrice;
            // отдаем результат
            $order['model'][] = [
                'label' => "Категория: <strong>".$model['category']."</strong> / Модель: <strong>".$model['name']."</strong> / размер: <strong>".$model['size']."</strong> / материал: <strong>".$model['material']->pluck('name')->first()."</strong>",
                'category' => $model['category'],
                'model_name' => $model['name'],
                'size' => $model['size'],
                'material' => $model['material'],
                'count' => 1,
                'subtotal' => $modelPrice,
                'total' => $modelPrice
            ];
            // берем только первый памятник
            break;
        }

        # Гравировки
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

        # Тексты
        if(!empty($priceList['text'])) {
            // Список текстовых наименований (имя, фамилия, цена...)
            $productTextCollect = Product::where('category_id', 28)->get();
            foreach($productTextCollect as $productText) {
                $order['text'][$productText['slug']] = [
                    'label' => $productText['name'],
                    'value' => [],
                    'valueString' => '',
                    'count' => 0,
                    'subtotal' => $productText['price'],
                    'total' => 0,
                ];
            }
            // Обход текстовых наименований которые есть в заказе
            foreach($priceList['text'] as $arText) {
                foreach($arText as $textSlug => $textItem) {
                    // количество, текстовых наименований
                    ++$order['text'][$textSlug]['count'];
                    // значение
                    $order['text'][$textSlug]['value'][] = $textItem;
                    $order['text'][$textSlug]['valueString'] .= "(".$textItem.") ";
                    // итог
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

        # Цветник / надгробие
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

        # Ограда
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

        # Вазы
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

        # Облицовки
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

        # Услуги
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
                'label' => "Доставка (".$services['delivery']['addr'].")",
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

        # Ответ
        return response()->json(['order' => $order, 'price' => $price], 200);
        // return view('test', compact('order', 'price'));
    }

    public function update(OrderRequest $request, Order $order) {
        $data = $request->validated();
        $updStatus = $order->update($data);
        return response()->json(['status' => $updStatus], 200);
        // return redirect()->route('order.item', $order->id);
    }

    public function destroy(Order $order) {
        $order->delete();
        return redirect()->route('home');
    }







    /*
     * PDF, Договор
     * */

    public function pdf(Order $order) { //

        //
        $estimateTotal = $this->estimateTotal($order);

        // Формируем PDF
        $pdf = Pdf::loadView('order.pdf', compact('order', 'estimateTotal')); // compact('order', 'productList', 'categoryList', 'statusList')
        $pdf->setOption([
            'defaultPaperSize' => "a4",
            'defaultFont' => 'dejavu serif',
            // "default_font" => "dejavu serif",
            // 'dpi' => 150,
        ]);

        //
        return $pdf;
    }
    public function pdfStream(Order $order) { //
        return $this->pdf($order)->stream(); //
    }

    public function pdfDownload(Order $order) {
        return $this->pdf($order)->download('Заказ '.$order->id);
    }

    public function contract(Order $order) {
        // Сбор данных
        $order->model = Product::find($order->model);
        $order->material = Product::find($order->material);
        $order->portrait = Product::find($order->portrait);
        $statusList = Status::all();
        $categoryList = Category::all();

        // Формируем PDF
        $pdf = Pdf::loadView('order.contract', compact('order'));
        $pdf->setOption([
            'defaultPaperSize' => "a4",
            'defaultFont' => 'dejavu serif',
            // "default_font" => "dejavu serif",
            // 'dpi' => 150,
        ]);

        //
        return $pdf->stream();
    }

}

