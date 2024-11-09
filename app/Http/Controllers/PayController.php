<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pay;
use App\Http\Requests\PayRequest;

class PayController extends Controller
{
    public function create($order) {
        return view('pay.create', compact('order'));
    }

    public function store(PayRequest $request) {
        $newPay = Pay::create($request->validated());

        return '
        <tr class="pay">
            <td>'.$newPay->comment.'</td>
            <td class="tac">'.$newPay->created_at_ru.'</td>
            <td class="tac">'.$newPay->amount.'</td>
        </tr>';

        return $newPay;
        // return redirect()->route('order.item', $data['order_id']);
    }

    public function edit(Pay $pay) {
        return view('pay.edit', compact('pay'));
    }
    public function update(PayRequest $request, Pay $pay) {
        $data = $request->validated();
        $pay->update($data);
        return redirect()->route('order.item', $pay->order_id);
    }

    public function destroy(Pay $pay) {
        $pay->delete();
        return redirect()->route('order.item', $pay->order_id);
    }

}
