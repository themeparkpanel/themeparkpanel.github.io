<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Show;
use App\ShowDate;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ToolController extends Controller
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
     * Show the operator tool.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function operator()
    {
        return view('panel.operator');
    }

    //Default values for cssTags
    private $cssDefaults = [
        'banner' => 'url("../img/banner.png") center center',
        'bg' => '#f2f2f2',
        'light' => '#2ecc71',
        'dark' => "#27ae60",
        'text' => '#fff',
    ];

    //Tags that can be changed in root.css
    private $cssTags = [
        'banner' => 'banner',
        "bg" => "bg",
        "light" => "color-light",
        "dark" => "color-dark",
        "text" => "color-text",
    ];

    public function css() {
        $styles = $this->cssDefaults;

        if(file_exists(storage_path('app/public/css.json'))) {
            $json = file_get_contents(storage_path('app/public/css.json'));
            $json = json_decode($json);
            if(json_last_error() != JSON_ERROR_NONE && !empty($json))
                $styles = $json;
        }

        return view('panel.css')->with([
            'styles' => $styles,
        ]);
    }

    public function cssPost(Request $request) {
        $rules = [];
        foreach($this->cssTags as $key => $value)
            $rules[$key] = ['required'];

        $validator = Validator::make($request->all(), $rules);

        if(!$validator->passes())
            return Redirect::back()->withErrors($validator->errors());

        $styles = [];
        foreach($request->all() as $key => $value)
            if(array_key_exists($key, $this->cssTags))
                $styles[$key] = $value;

        file_put_contents(storage_path('app/public/css.json'), json_encode($styles));

        $str = ":root {\n";
        foreach($styles as $key => $value)
            $str .= "\t--".$this->cssTags[$key].': '.$value.";\n";

        file_put_contents(public_path('assets/css/root.css'), $str.'}');

        return view('panel.css')->with([
            'styles' => $styles,
        ]);
    }

    public function cssReset() {
        $styles = $this->cssDefaults;

        file_put_contents(storage_path('app/public/css.json'), json_encode($styles));

        $str = ":root {\n";
        foreach($styles as $key => $value)
            $str .= '--'.$this->cssTags[$key].': '.$value.";\n";

        file_put_contents(public_path('assets/css/root.css'), $str.'}');

        return Redirect::back();
    }

}
