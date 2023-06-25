<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pay;

class PayController extends Controller
{
    public function create($order) {
        return view('pay.create', compact('order'));
    }
    public function edit(Pay $pay) {
        return view('pay.edit', compact('pay'));
    }
    public function store() {

    }
}
