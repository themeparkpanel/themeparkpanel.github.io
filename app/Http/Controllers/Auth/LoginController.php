<?php

namespace App\Http\Controllers\Auth;

use App\Cache\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
        return 'uuid';
    }

    public function showLoginForm()
    {
        $urlPrevious = url()->previous();
        $urlBase = url()->to('/');
        if(($urlPrevious != $urlBase . '/login') && (substr($urlPrevious, 0, strlen($urlBase)) === $urlBase))
            session()->put('url.intended', $urlPrevious);

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $request->merge([
            'uuid' => Cache::getUUID($request->get('uuid'))
        ]);

        if($this->guard()->validate($this->credentials($request))) {
            if(Auth::attempt(['uuid' => $request->get('uuid'), 'password' => $request->get('password')])) {
                return redirect()->intended('home');
            }  else {
                $this->incrementLoginAttempts($request);
                return view('auth.login')->withErrors([
                    'error' => 'Wrong credentials.'
                ]);
            }
        } else {
            $this->incrementLoginAttempts($request);
            return view('auth.login')->withErrors([
                'error' => 'Wrong credentials.'
            ]);
        }
    }

}
