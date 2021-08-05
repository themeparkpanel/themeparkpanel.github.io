<?php

namespace App;

use App\Cache\Cache;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'email', 'password', 'google2fa_secret',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'google2fa_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function fixedUUID() {
        $uuid = substr_replace($this->uuid, '-', 8, 0);
        $uuid = substr_replace($uuid, '-', 13, 0);
        $uuid = substr_replace($uuid, '-', 18, 0);
        return substr_replace($uuid, '-', 23, 0);
    }

    private $username;
    public function username() {
        if(!empty($this->username))
            return $this->username;

        $username = Cache::getUsername($this->uuid);
        $this->username = $username;
        return $username;
    }

    private $shows = null;
    public function hasShows() {
        if($this->shows !== null)
            return true;

        $shows = Show::join('seats', 'seats.show_id', '=', 'shows.id')
            ->select([
                'shows.title', 'shows.description', 'shows.image', 'seats.*'
            ])
            ->where('seats.uuid', '=', $this->uuid)
            ->where('seats.date', '>', Carbon::now())
            ->get()->all();
        $this->shows = $shows;
        return !empty($shows);
    }

    public function getShows() {
        if($this->shows !== null)
            return $this->shows;

        $shows = Show::join('seats', 'seats.show_id', '=', 'shows.id')
            ->select([
                'shows.title', 'shows.description', 'shows.image', 'seats.*'
            ])
            ->where('seats.uuid', '=', $this->uuid)
            ->where('seats.date', '>', Carbon::now())
            ->get()->all();
        $this->shows = $shows;
        return $shows;
    }

    public function photo() {
        return 'https://crafatar.com/avatars/'.$this->uuid.'?overlay';
    }

}
