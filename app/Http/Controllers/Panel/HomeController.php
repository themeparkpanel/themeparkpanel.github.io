<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Show;
use App\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
        $users = User::count();
        $regions = DB::table('regions')->count();
        $attractions = DB::table('attractions')->count();
        $shows = env('SHOWS', false) ? Show::count() : 0;
        return view('panel.home')->with([
            'users' => $users,
            'regions' => $regions,
            'attractions' => $attractions,
            'shows' => $shows
        ]);
    }

}
