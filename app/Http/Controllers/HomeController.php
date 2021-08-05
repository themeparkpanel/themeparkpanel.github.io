<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
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
        if(!env('HOME_PAGE', false))
            return redirect()->route('status');

        return view('home')->with([
            'message' => \App\Message::orderByDesc('id')->first()
        ]);
    }

    public function status()
    {
        return view('status');
    }

    public function photo() {
        $photos = DB::table('actionfotos')
            ->join('attraction', 'attraction.id', '=', 'actionfotos.ride')
            ->where('actionfotos.uuid', '=', Auth::user()->uuid)
            ->select('actionfotos.base64')
            ->get()->all();

        return view('photo', [
            'photos' => $photos
        ]);
    }

    public function store()
    {
        return Redirect::to(env('STORE_URL', 'https://sbdplugins.nl'));
    }

}
