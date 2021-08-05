<?php
namespace App\Http\Controllers\Panel;

use App\ChangeEmail;
use App\Http\Controllers\Controller;
use App\Show;
use App\ShowDate;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ShowsController extends Controller
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
        $pages = empty($search) ? ShowDate::whereRaw('`show_dates`.`date` > CURDATE()')->count() : Show::join('shows', 'shows.id', '=', 'show_dates.show_id')
            ->whereRaw('`show_dates`.`date` > CURDATE()')
            ->whereRaw("UPPER(`title`) LIKE '%". strtoupper($search)."%'")->count();

        $pages = (int) ceil($pages/25);
        if($pages < 1 && $page == 1)
            $page = 1;

        if($page < 1 || ($pages > 0 && $page > $pages)) {
            $array['page'] = $pages > 0 ? $pages : 1;
            if(!empty($search) && $pages > 0)
                $array['search'] = $search;

            return redirect()->route('panel.shows', $array);
        }

        $query = ShowDate::join('shows', 'shows.id', '=', 'show_dates.show_id')
            ->whereRaw('`show_dates`.`date` > CURDATE()')
            ->select('show_dates.id', 'shows.title', DB::raw('DATE_FORMAT(`show_dates`.`date`, "%d-%m-%Y %H:%i") AS `date`'));

        if(!empty($search))
            $query->whereRaw("UPPER(`shows.title`) LIKE '%". strtoupper($search)."%'");

        $data = $query->get();
        return view('panel.shows.index')->with([
            'dates' => $data,
            'page' => $page,
            'pages' => $pages,
            'search' => $search
        ]);
    }

    public function search(Request $request) {
        if(!$request->has('searchText'))
            return response()->json([]);

        $shows = Show::whereRaw("UPPER(`title`) LIKE '%". strtoupper($request->get('searchText'))."%'")->select('id', 'title')->get();
        return response()->json($shows->all());
    }

    public function add() {
        return view('panel.shows.create');
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'show_id' => ['required', 'numeric', 'exists:shows,id'],
            'date' => ['required', 'date']
        ]);

        if(!$validator->passes())
            return Redirect::back()->withErrors($validator->errors());

        $request->merge([
            'date' => date('Y-m-d H:i:s', strtotime($request->get('date')))
        ]);

        $date = ShowDate::create($request->all());
        if(empty($date)) {
            session()->flash('error', 'Unable to create a new show date');
            return Redirect::route('panel.ums');
        }

        session()->flash('success', 'Successfully created show date.');
        return Redirect::route('panel.shows');
    }

    public function info($id) {
        $date = ShowDate::findOrFail($id);

        $filled = DB::table('seats')->where('show_id', '=', $date->show_id)->where('date', '=', $date->date)->count();
        return view('panel.shows.info')->with([
            'date' => $date,
            'show' => Show::findOrFail($date->show_id),
            'filled' => $filled
        ]);
    }

    public function delete($id) {
        $show = ShowDate::findOrFail($id);
        if($show->delete()) {
            session()->flash('success', 'Successfully deleted show date.');
        } else {
            session()->flash('error', 'Unable to delete show date.');
        }

        return Redirect::back();
    }

}
