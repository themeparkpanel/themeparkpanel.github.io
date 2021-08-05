<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class OpenAudioMCController extends Controller
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
        $url = env('OPENAUDIOMC_URL', '');
        if(empty($url))
            return  view('openaudiomc')->with(['type' => 1]);

        if(!filter_var($url, FILTER_VALIDATE_URL))
            return  view('openaudiomc')->with(['type' => 1]);

        $result = file_get_contents($url);
        $json = json_decode($result);
        if(empty($result) || json_last_error() != JSON_ERROR_NONE)
            return view('openaudiomc')->with(['type' => 1]);

        if(isset($json->errors) && !empty($json->errors))
            return  view('openaudiomc')->with(['type' => 2]);

        if(!isset($json->response))
            return  view('openaudiomc')->with(['type' => 2]);

        $response = $json->response;
        if(!isset($response->players) || empty($response->players))
            return  view('openaudiomc')->with(['type' => 2]);

        $response = $response->players;

        $uuid = Auth::user()->fixedUUID();
        $user = null;
        foreach ($response as $player) {
            if($player->uuid === $uuid) {
                $user = $player;
                break;
            }
        }

        if(empty($user))
            return view('openaudiomc')->with(['type' => 2]);

        if(!isset($user->isConnected) || $user->isConnected)
            return view('openaudiomc')->with(['type' => 3]);

        header('Location: '.$user->url);
        exit;
    }

}
