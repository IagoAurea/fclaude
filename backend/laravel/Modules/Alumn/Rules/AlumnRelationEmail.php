<?php

namespace Modules\Alumn\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AlumnRelationEmail implements Rule
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
            'deleted_at', null
        )->first();

        $alumn = DB::table('alumns')->where(
            'email', $value
        )->where(
            'deleted_at', '=', null
        )->first();

        // In case none of both exists
        if (!$user && !$alumn) {
            return true;
        // In case user does not exists but a alumn does
        } elseif (!$user && $alumn) {
            return false;
        // In case the user does exists but theres no alumn
        } elseif ($user && !$alumn) {
            return true;
        // If both exists and have the same user related
        } elseif ($alumn->user_id !== $user->id) {
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
