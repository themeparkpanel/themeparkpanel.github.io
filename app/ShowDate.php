<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShowDate extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'show_dates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'show_id', 'date'
    ];

    public function show() {
        return $this->belongsTo('\App\Show');
    }

}
