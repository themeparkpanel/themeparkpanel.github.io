<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class SecurityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['mobile', 'auth', 'verified', '2fa']);
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @param int $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     */
    public function index(Request $request, $page = 1)
    {
        $google2fa = new \PragmaRX\Google2FALaravel\Google2FA($request);
        $tfa = $google2fa->isActivated();
        $pages = Session::where('user_id', Auth::id())->count();
        $pages = (int) ceil($pages/10);
        if($page < 1 || ($page > $pages && $page != 1))
            return redirect()->route('security', ['page' => $pages]);

        $sessions = Session::where('user_id', Auth::id())->where('id', '!=', session()->getId())->skip(($page - 1)*10)->take(($page != 1 ? 10 : 9))->orderBy('last_activity', 'desc')->get();
        $array = ['TFA' => $tfa, 'pages' => $pages, 'page' => $page, 'sessions' => $sessions, 'agent' => new Agent()];

        if(!$tfa) {
            if(!session()->has('redirected')) {
                $secret = $google2fa->generateSecretKey();
                session()->flash('google_secret', $secret);
            } else {
                $secret = session()->get('google_secret');
                session()->keep(['google_secret']);
            }

            $google2fa = new \PragmaRX\Google2FAQRCode\Google2FA();
            $QR = $google2fa->getQRCodeInline(
                config('app.name'),
                Auth::user()->email,
                $secret
            );

            $array['QRCode'] = $QR;
            return view('profile.security')->with($array);
        }

        return view('profile.security')->with($array);
    }

    public function session($id)
    {
        if(session()->getId() === $id)
            return redirect()->route('security');

        Session::where(['id' => $id, 'user_id' => Auth::id()])->forceDelete();
        return redirect()->route('security');
    }

}
