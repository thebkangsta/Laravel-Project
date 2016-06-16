<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    use ResetsPasswords;

    public function __construct()
    {
        $this->middleware($this->guestMiddleware());
    }

    public function resetEmailIndex()
    {
        return view('auth.passwords.email');
    }

    public function getResetSuccessResponse($response)
    {
        \Auth::logout();
        return redirect('home')->with('status', trans($response));
    }
}