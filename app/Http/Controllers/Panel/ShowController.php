<?php
namespace App\Http\Controllers\Panel;

use App\ChangeEmail;
use App\Http\Controllers\Controller;
use App\Show;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ShowController extends Controller
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
    public function index($page = 1, $search = '')
    {
        $pages = empty($search) ? Show::count() : Show::whereRaw("UPPER(`title`) LIKE '%". strtoupper($search)."%'")->count();
        $pages = (int) ceil($pages/25);
        if($pages < 1 && $page == 1)
            $page = 1;

        if($page < 1 || ($pages > 0 && $page > $pages)) {
            $array['page'] = $pages > 0 ? $pages : 1;
            if(!empty($search) && $pages > 0)
                $array['search'] = $search;

            return redirect()->route('panel.show', $array);
        }

        $query = Show::select('id', 'title', 'price', 'vault_price', 'seats');
        if(!empty($search))
            $query->whereRaw("UPPER(`title`) LIKE '%". strtoupper($search)."%'");

        $data = $query->get();
        return view('panel.show.index')->with([
            'shows' => $data,
            'page' => $page,
            'pages' => $pages,
            'search' => $search
        ]);
    }

    public function add() {
        return view('panel.show.create');
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'unique:shows,title', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'vault_price' => ['required', 'numeric', 'min:0.01'],
            'seats' => ['required', 'numeric', 'min:1'],
            'image' => ['required', 'string', 'max:255'],
        ]);

        if(!$validator->passes())
            return Redirect::back()->withErrors($validator->errors());

        $request->merge([
            'price' => number_format($request->get('price'), 2),
            'vault_price' => number_format($request->get('vault_price'), 2)
        ]);

        $show = Show::create($request->all());
        if(empty($show)) {
            session()->flash('error', 'Unable to create a new Show');
            return Redirect::route('panel.ums');
        }

        session()->flash('success', 'Successfully created show.');
        return Redirect::route('panel.show');
    }

    public function info($id) {
        return view('panel.show.info')->with([
            'show' => Show::findOrFail($id)
        ]);
    }

    public function edit($id) {
        return view('panel.show.edit')->with([
            'show' => Show::findOrFail($id)
        ]);
    }

    public function update(Request $request) {
        if(!$request->has('id'))
            return Redirect::back();

        $show = Show::findOrFail($request->get('id'));
        $validator = Validator::make($request->all(), [
           'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'vault_price' => ['required', 'numeric', 'min:0.01'],
            'image' => ['required', 'string', 'max:255'],
        ]);

        if(!$validator->passes())
            return Redirect::back()->withErrors($validator->errors());

        $show->description = $request->get('description');
        $show->price = number_format($request->get('price'), 2);
        $show->vault_price = number_format($request->get('vault_price'), 2);
        $show->image = $request->get('image');
        if($show->save()) {
            session()->flash('success', 'Successfully edited show');
            return Redirect::route('panel.show');
        }

        session()->flash('error', 'Unable to edit show');
        return Redirect::back();
    }

    public function delete($id) {
        $show = Show::findOrFail($id);
        if($show->delete()) {
            session()->flash('success', 'Successfully deleted show.');
        } else {
            session()->flash('error', 'Unable to delete show.');
        }

        return Redirect::back();
    }

}
