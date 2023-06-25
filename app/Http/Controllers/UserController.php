<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function list() {
        $userList = User::all();
        return view('personal.list', compact('userList'));
    }
}
