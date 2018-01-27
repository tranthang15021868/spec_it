<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\LoginRequest;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = 'admin/cate/list';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this -> auth = $auth;
        $this->middleware('guest')->except('logout');
    }

    public function login(LoginRequest $request) {
        $login = array(
            'username' => $request -> username,
            'password' => $request -> password,
        );
        if ($this -> auth -> attempt($login)) {
            return redirect() -> route('create.getRequest');
        }
        else {
            return redirect() -> back();
        }
    }
}
