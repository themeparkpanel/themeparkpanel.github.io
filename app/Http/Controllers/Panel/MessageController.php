<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa', 'admin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('panel.message');
    }

    public function change(Request $request) {
        $validator = Validator::make($request->all(), [
            'message' => ['required', 'string']
        ]);

        if(!$validator->passes()) {
            session()->flash('error', 'Incorrect message');
            return Redirect::back();
        }

        $message = Message::orderByDesc('id')->first();
        if(!empty($message))
            if($message->content === $request->get('message'))
                return Redirect::back();

        $message = Message::create([
            'uuid' => Auth::user()->uuid,
            'content' => $request->get('message')
        ]);

        if(empty($message)) {
            session()->flash('error', 'Unable to create message');
            return Redirect::back();
        }

        session()->flash('success', 'Successfully posted message');
        return Redirect::back();
    }

}
