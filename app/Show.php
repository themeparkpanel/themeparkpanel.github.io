<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Show extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shows';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'price', 'vault_price', 'image', 'seats'
    ];

    private $data = null;
    public function getShowDates($uuid = null) {
        if($this->data !== null)
            return $this->data;

        $data = DB::table('show_dates')
            ->leftJoin('seats', 'seats.date', '=','show_dates.date')
            ->havingRaw('COUNT(`seats`.`id`) < '.$this->seats)
            ->whereRaw('`show_dates`.`date` > CURDATE()')
            ->where('show_dates.show_id', '=', $this->id)
            ->select('show_dates.date', DB::raw('COUNT(`seats`.`id`) AS `filled_seats`'))
            ->groupBy('show_dates.date');

        if($uuid !== null)
            $data = $data->whereRaw( "`show_dates`.`date` NOT IN (SELECT date FROM seats WHERE uuid='".$uuid."' AND show_id='".$this->id."')");

        $data = $data->get()->all();
        $dates = [];
        foreach ($data as $row)
            array_push($dates, [
                'date' => $row->date,
                'free_seats' => $this->seats - $row->filled_seats
            ]);

        $this->data = $dates;
        return $dates;
    }

}
