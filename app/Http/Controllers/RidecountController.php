<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RidecountController extends Controller
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
     * @param $attraction_id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($attraction_id)
    {
        $attraction = DB::table('attractions')->select(['cover','name','status_id'])->where('id', '=', $attraction_id)->first();
        if(empty($attraction))
            return redirect()->route('status');

        $type = env('TOP', 1);
        if($type < 0 || $type > 4)
            return redirect()->route('status');

        switch ($type) {
            case 1:
                $filter = 'week = WEEK(CURDATE(), 1)';
                break;
            case 2:
                $filter = 'month = MONTH(CURDATE())';
                break;
            case 3:
                $filter = 0;
                break;
            case 4:
                $filter = -1;
                break;
            default:
                $filter = 'day = DAYOFYEAR(CURDATE())';
                break;
        }

        $top10 = DB::table(DB::raw('ridecounts, (SELECT @row_number:=0) AS t'))->select('uuid', DB::raw('SUM(`count`) AS `count`'), DB::raw('(@row_number:=@row_number + 1) AS `num`'))
            ->where('attraction_id', '=', $attraction_id);

        if(!empty($filter))
            $top10 = $top10->whereRaw($filter);

        if($filter !== -1)
            $top10 = $top10->whereRaw('year = YEAR(CURDATE())');

        $top10 = $top10->groupBy('uuid')
            ->orderByDesc('count')
            ->take(10)->get()->all();

        $personal = DB::table('ridecounts')
            ->where('attraction_id', '=', $attraction_id)
            ->where('uuid', '=', Auth::user()->fixedUUID())
            ->sum('count');

        $total = DB::table('ridecounts')
            ->where('attraction_id', '=', $attraction_id)
            ->sum('count');

        $attraction->status = DB::table('states')->where('id', '=', $attraction->status_id)->first();
        return view('ridecount')->with([
            'attraction' => $attraction,
            'top10' => $top10,
            'personal' => $personal,
            'total' => $total
        ]);
    }

}
