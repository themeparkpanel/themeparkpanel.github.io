<?php

namespace App\Http\Controllers;

use App\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $this->middleware(['auth', 'verified', '2fa']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $shows = DB::select(DB::raw('SELECT t1.* FROM `shows` AS t1 RIGHT JOIN `show_dates` AS t2 ON t1.`id` = t2.`show_id` WHERE t2.`date` > CURRENT_TIMESTAMP() GROUP BY t1.`id`'));
        return view('show')->with([
            'shows' => $shows
        ]);
    }

    public function order($show_id) {
        $show = Show::join('show_dates', 'show_dates.show_id', '=', 'shows.id')->select('shows.*')->where('shows.id', '=', $show_id)->where('show_dates.date', '>', DB::raw('CURRENT_TIMESTAMP()'))->firstOrFail();
        $dates = $show->getShowDates(Auth::user()->uuid);

        return view('order')->with([
            'show' => $show,
            'dates' => $dates
        ]);
    }

    public function makeOrder(Request $request) {
        if(!$request->has('id')) {
            session()->flash('error', 'Incorrect form data');
            return Redirect::back();
        }

        $show = Show::find($request->get('id'));
        if(empty($show)) {
            session()->flash('error', 'Incorrect form data');
            return Redirect::back();
        }

        $validator = Validator::make($request->all(), [
           'id' => ['required', 'numeric'],
            'date' => ['required', 'date']
        ]);

        if(!$validator->passes()) {
            session()->flash('error', 'Incorrect show date');
            return Redirect::back();
        }

        $data = DB::table('show_dates')
            ->leftJoin('seats', 'seats.date', '=','show_dates.date')
            ->where('show_dates.date', '=', $request->get('date'))
            ->where('show_dates.show_id', '=', $show->id)
            ->select('show_dates.date', DB::raw('COUNT(`seats`.`id`) AS `filled_seats`'), DB::raw('GROUP_CONCAT(`seats`.`uuid`) AS `uuids`'), DB::raw('GROUP_CONCAT(`seats`.`seat`) AS `used_seats`'))
            ->groupBy('show_dates.date')
            ->first();

        if(empty($data)) {
            session()->flash('error', 'Incorrect show date');
            return Redirect::back();
        }

        $time = strtotime($request->get('date'));
        if(strpos($data->uuids, Auth::user()->uuid) !== false) {
            session()->flash('error', 'You already booked the show on '.date('d-m-Y', $time).' at '.date('H:m', $time));
            return Redirect::back();
        }

        if($data->filled_seats >= $show->seats) {
            session()->flash('error', 'This show is already fully booked on '.date('d-m-Y', $time).' at '.date('H:m', $time));
            return Redirect::back();
        }

        $array = [];
        $seats = explode(',', $data->used_seats);
        for($i = 1; $i <= $show->seats; $i++)
            if(!in_array($i, $seats))
                array_push($array, $i);

        $result = DB::table('seats')->insert([
            'uuid' => Auth::user()->uuid,
            'show_id' => $show->id,
            'seat' => $array[array_rand($array)],
            'voucher' => Str::random(8),
            'date' => $request->date
        ]);

        if(empty($result)) {
            session()->flash('error', 'Unable to book show on '.date('d-m-Y', $time).' at '.date('H:m', $time));
            return Redirect::back();
        }

        session()->flash('success', 'Successfully reserved seat for show on '.date('d-m-Y', $time).' at '.date('H:m', $time));
        return Redirect::back();
    }

}
