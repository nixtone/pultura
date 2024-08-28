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

    // Препоиск. Подсказки при наборе
    public function presearch(Request $request) {
        // Сбор данных
        $criterion = $request->input('criterion');
        $category = $request->input('category');
        $presearchQuery = $request->input($criterion);

        // Запрос
        $result = Client::where($criterion, 'like', "%$presearchQuery%");
        if($category) $result = $result->where('client_category', $category);

        // Результат
        return $result->get();
    }

    // Результаты поиска
    public function search(Request $request) {

        // TODO: фиксировать в полях набранный поиск
        //dump($request);
        // Сбор данных
        $criterion = $request->input('criterion');
        $category = $request->input('category');
        $presearchQuery = $request->input($criterion);
        $clientCategory = ClientCategory::all();

        // TODO: странный результат на телефоне
        dd($presearchQuery);

        // Запрос
        $result = Client::where($criterion, 'like', "%$presearchQuery%");
        if($category) $result = $result->where('client_category', $category);
        $clientList = $result->get();

        // Результат
        return view('client.list', compact('clientList', 'clientCategory'));

        /*
        $presearchQuery = $request->input('query');
        $clientCategory = ClientCategory::all();
        $clientList = Client::where('name', 'like', "%$presearchQuery%")->get();
        //dd($clientList);
        return view('client.list', compact('clientList', 'clientCategory'));
        */
    }

}
