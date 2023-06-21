<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;

class ClientController extends Controller
{
    public function list() {
        $clientList = Client::all();
        return view('client.list', compact('clientList'));
    }

    public function item(Client $client) {
        return view('client.item', compact('client'));
    }

    public function create() {
        return view('client.create');
    }
}
