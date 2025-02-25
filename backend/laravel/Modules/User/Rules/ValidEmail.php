<?php

namespace Modules\User\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ValidEmail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct() {

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
        // Search for a club invitation
        $clubInvite = DB::table('club_invitations')->where(
            'invited_user_email', '=', $value
        )->first();

        // Check that the accepted_at column stills null and the emails are the same
        if ($clubInvite) {
            return $clubInvite->accepted_at == null && $clubInvite->invited_user_email == $value;
        }

        // If invitation does not exists, search an user
        $user = DB::table('users')->where(
            'email', '=', $value
        )->first();

        // If there's an existent user, return false
        return $user ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is already on use.';
    }
}
