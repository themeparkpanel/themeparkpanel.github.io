<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TwoFactorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    protected function index(Request $request)
    {
        $google2fa = new \PragmaRX\Google2FALaravel\Google2FA($request);
        if(!$google2fa->isActivated())
            return redirect()->route('home');

        $google2fa = new \PragmaRX\Google2FALaravel\Support\Authenticator($request);
        if($google2fa->isAuthenticated())
            return redirect()->route('home');

        return view('2fa.authenticate');
    }

    protected function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'two_factor' => ['required', 'digits:6']
        ]);

        if(!$validator->passes())
            return Redirect::back()->withErrors($validator);

        $google2fa = new \PragmaRX\Google2FALaravel\Google2FA($request);
        if(!$google2fa->verifyGoogle2FA(Auth::user()->google2fa_secret, $request->two_factor)) {
            $validator->getMessageBag()->add('two_factor', 'Incorrect 2FA Code');
            return Redirect::back()->withErrors($validator);
        }

        $google2fa->login();
        return redirect()->route('home');
    }
}
