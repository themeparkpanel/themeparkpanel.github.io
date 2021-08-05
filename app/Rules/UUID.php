<?php

namespace App\Rules;

use App\Cache\Cache;
use App\User;
use Illuminate\Contracts\Validation\Rule;

class UUID implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $uuid = Cache::getUUID($value);
        if(empty($uuid))
            return false;

        if($uuid === $value)
            return false;

        $user = User::where('uuid', '=', $uuid)->first();
        return empty($user);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Username: :value is incorrect or already in use';
    }
}
