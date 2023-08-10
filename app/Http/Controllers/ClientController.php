<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;
use App\Http\Requests\ClientRequest;
use App\Models\ClientCategory;

class ClientController extends Controller
{
    public function list() {
        $clientCategory = ClientCategory::all();
        $clientList = (request()->get('cat') ? Client::where('client_category', request()->get('cat'))->get() : Client::all())->reverse();
        return view('client.list', compact('clientList', 'clientCategory'));
    }

    public function item(Client $client) {
        return view('client.item', compact('client'));
    }

    public function create() {
        $clientCategories = ClientCategory::all();
        return view('client.create', compact('clientCategories'));
    }

    public function store(ClientRequest $request)
    {
        $data = $request->validated();
        $newClient = Client::create($data);
        return redirect()->route('client.item', $newClient->id);
    }

    public function edit(Client $client) {
        return view('client.edit', compact('client'));
    }

    public function update(ClientRequest $request, Client $client) {
        $data = $request->validated();
        $client->update($data);
        return redirect()->route('client.item', $client->id);
    }

    public function destroy(Client $client) {
        $client->delete();
        return redirect()->route('client.list');
    }
}
