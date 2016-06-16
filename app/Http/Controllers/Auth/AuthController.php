<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	public function login(Request $request) {
		if (\Auth::attempt($request->only('email','password'))) {
			session()->flash('loggedin','You have successfully logged in!');
            return redirect()->intended('dashboard/analytics');
        }
		else {
			session()->flash('badcredentials', 'Your email or password is incorrect!');
			return redirect('home');
		}
	}

	public function logout() {
		\Auth::logout();
		return redirect('home');
	}
}