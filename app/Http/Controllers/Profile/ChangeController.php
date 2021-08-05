<?php

namespace App\Http\Controllers\Profile;

use App\ChangeEmail;
use App\Http\Controllers\Controller;
use App\Mail\EmailChange;
use App\Notifications\SendMailChange;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class ChangeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('profile.change');
    }

    public function changePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'max:255'],
            'new_password' => ['required', 'min:6', 'confirmed', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/'],
            'new_confirm_password' => ['required', 'same:new_password']
        ]);

        if(!$validator->passes())
            return Redirect::back()->withErrors($validator);

        $user = Auth::user();
        if(!Hash::check($request->get('password'), $user->password)) {
            $validator->getMessageBag()->add('pass_password', 'Wrong user password.');
            return Redirect::back()->withErrors($validator);
        }

        $user->password = Hash::make($request->get('new_password'));
        if(!$user->save()) {
            $validator->getMessageBag()->add('new_password', 'Unable to change password.');
            return Redirect::back()->withErrors($validator);
        }

        session()->flash('pass_success', 'Successfully changed password.');
        return Redirect::back();
    }

    public function changeEmail(Request $request) {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'max:255'],
            'new_email' => ['required', 'email', 'unique:users,email', 'max:255'],
            'new_confirm_email' => ['required', 'same:new_email']
        ]);

        if(!$validator->passes())
            return Redirect::back()->withErrors($validator);

        $user = Auth::user();
        if(!Hash::check($request->get('password'), $user->password)) {
            $validator->getMessageBag()->add('email_password', 'Wrong user password.');
            return Redirect::back()->withErrors($validator);
        }

        $user->email = $request->get('new_email');
        $change = ChangeEmail::create([
            'user_id' => $user->id,
            'email' => $request->get('new_email'),
            'token' => Str::random(12)
        ]);

        Mail::to($user->email)->send(new EmailChange($change));
        session()->flash('email_success', 'Successfully requested email change');
        return Redirect::back();
    }

    public function verifyEmail($id, $token, $email) {
        if(Auth::id() != $id) {
            session()->flash('email_error', 'Incorrect email change request: '.$email);
            return Redirect::route('change');
        }

        $user = Auth::user();
        $model = ChangeEmail::where([
            'user_id' => $user->id,
            'token' => $token,
            'email' => $email
        ])->first();

        if(empty($model)) {
            session()->flash('email_error', 'Unable to change email address to: '.$email);
            return Redirect::route('change');
        }

        $user->email = $email;
        $user->save();
        $model->delete();
        session()->flash('email_success', 'Successfully changed email address to: '.$email);
        return Redirect::route('change');
    }

}
