<?php

namespace Modules\Player\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PlayerRelationEmail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        $user = DB::table('users')->where(
            'email', $value
        )->where(
            'deleted_at', NULL
        )->first();

        $player = DB::table('players')->where(
            'email', $value
        )->where(
            'deleted_at', '=', NULL
        )->first();

        // In case none of both exists
        if (!$user && !$player) {
            return true;
        // In case user does not exists but a player does
        } else if (!$user && $player) {
            return false;
        // In case the user does exists but theres no player
        } else if ($user && !$player) {
            return true;
        // If both exists and have the same user related
        } else if ($player->user_id !== $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Email is alrady on use.';
    }
}
