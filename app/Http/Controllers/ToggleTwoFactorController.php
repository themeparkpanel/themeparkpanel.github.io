<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ToggleTwoFactorController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function toggle(Request $request) {
        $google2fa = new \PragmaRX\Google2FALaravel\Google2FA($request);
        $validator = Validator::make($request->all(), [
            'two_factor' => ['required', 'digits:6']
        ]);

        if(!$google2fa->isActivated()) {
            $secret = session()->get('google_secret');
            if (!$validator->passes()) {
                session()->flash('redirected', true);
                session()->keep(['google_secret']);
                return Redirect::back()->withErrors($validator);
            }

            $google2fa = new \PragmaRX\Google2FALaravel\Google2FA($request);
            if (!$google2fa->verifyGoogle2FA($secret, $request->two_factor)) {
                $validator->getMessageBag()->add('two_factor', 'Incorrect 2FA Code');
                session()->flash('redirected', true);
                session()->keep(['google_secret']);
                return Redirect::back()->withErrors($validator);
            }

            $google2fa->login();
            Auth::user()->update([
                'google2fa_secret' => $secret
            ]);

            session()->flash('success', 'Successfully enabled 2FA');
            return redirect()->route('security');
        } else {
            if(!$validator->passes())
                return Redirect::back()->withErrors($validator);

            $google2fa = new \PragmaRX\Google2FALaravel\Google2FA($request);
            if(!$google2fa->verifyGoogle2FA(Auth::user()->google2fa_secret, $request->two_factor)) {
                $validator->getMessageBag()->add('two_factor', 'Incorrect 2FA Code');
                return Redirect::back()->withErrors($validator);
            }

            $google2fa->logout();
            Auth::user()->update([
                'google2fa_secret' => null
            ]);

            session()->flash('success', 'Successfully disabled 2FA');
            return redirect()->route('security');
        }
    }

}
