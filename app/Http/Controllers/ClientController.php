<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;
use App\Http\Requests\ClientRequest;

class ClientController extends Controller
{
    public function list() {
        $clientList = Client::all()->reverse();
        return view('client.list', compact('clientList'));
    }

    public function item(Client $client) {
        return view('client.item', compact('client'));
    }

    public function create()
    {
        return view('client.create');
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
        // dd($data);
        $client->update($data);

        return redirect()->route('client.item', $client->id);
    }

    public function destroy(Client $client) {
        $client->delete();
        return redirect()->route('client.list');
    }
}
