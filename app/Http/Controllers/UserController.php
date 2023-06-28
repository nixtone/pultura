<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function login(Request $request) {
        User::create($request->only(['name', 'password']));
        dd($request);
        $loginFields = $request->only(['name', 'password']);
        Auth::attempt($loginFields);

        /*
        $formFields = $request->only(['email', 'password']); // only() заберает только указанные поля

        if(Auth::attempt($formFields)) {
            // редирект-helper сначала кидает на стр откуда пришли, если нет то на 'user.private'
            return redirect()->intended(route('user.private'));
        }

        return redirect(route('user.login'))->withErrors([
            'formError' => 'Не удалось аутентифицироваться'
        ]);
        */
    }

    public function save(UserRequest $request) {
        //dd($request);
        //$data = $request->validate();
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password,
        ];
        $user = User::create($data);
        return redirect()->route('user.list');
    }

    public function list() {
        $userList = User::all();
        return view('user.list', compact('userList'));
    }

    public function item(User $user) {
        return view('user.item', compact('user'));
    }

    public function reg() {
        return view('user.reg');
    }

    public function edit(User $user) {

        return view('user.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user) {
        $data = $request->validated();
        // dd($request);
        $user->update($data); // $user
        return redirect()->route('user.item', $user->id);
    }

    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('user.list');
    }

    /*
    public function save(Request $request) {
        return view('user.reg');

        if(Auth::check()) {
            return redirect(route('user.private'));
        }
        $validateFields = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(user::where('email', $validateFields['email'])->exists()) {
            return redirect(route('user.reg'))->withErrors([
                'email' => 'Пользователь уже существует'
            ]);
        }

        $user = User::create($validateFields);
        if($user) {
            Auth::login($user);
            // auth()->login($user); // можно через helper, эквивалент
            return redirect(route('user.private'));
        }
        return redirect(route('user.login'))->withErrors([
            'formError' => 'Ошибка создания пользователя'
        ]);

    }


    public function item() {
        return view('user.item');
    }
    public function edit() {
        return view('user.edit');
    }
    */



}
