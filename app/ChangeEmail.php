<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeEmail extends Model
{

    protected $table = 'change_user_email';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'email', 'token'
    ];

}
