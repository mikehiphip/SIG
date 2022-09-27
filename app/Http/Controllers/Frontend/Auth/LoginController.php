<?php

namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontendController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends FrontendController
{

    use AuthenticatesUsers;
    protected $guard = 'user';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:user')->except('logout');
    }

    public function showLoginForm() {
       return view('frontend.signin');
    }

    protected function attemptLogin(Request $request)
    {
        if (\Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember )) {
            return redirect()->intended(\Request::segment(1).'/member');
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect(\Request::segment(1).'/signin');
    }
}
