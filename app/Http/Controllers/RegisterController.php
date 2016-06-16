<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function index() {
		return view('users.register');
	}

	public function store(RegisterRequest $request) {
		$user = new User;

		$user->name = $request->name;
		$user->email = $request->email;
		$user->password = bcrypt($request->password);

		$user->save();

		session()->flash('registered', 'You have successfully registered!');
		return redirect('home');
		\Auth::logout();
	}
}
