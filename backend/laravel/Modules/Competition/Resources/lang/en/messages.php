<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Message Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'policies.competition.store.deny' => 'User not authorize store competition',
    'policies.competition.update.deny' => 'User not authorize updated competition',
    'policies.competition.delete.deny' => 'User not authorize delete competition',
    'policies.competition.delete.deny' => 'User not authorize show competition',
    'policies.competition_match.store.deny' => 'User not authorize store match',
    'policies.competition_match.deny.max_limit' => 'The maximum limit to create match has been reached',
    'policies.competition_match.update.deny' => 'User not authorize update match',
    'policies.competition_match.show.deny' => 'User not authorize show match',
    'policies.competition_match.index.deny' => 'User not authorize list match',
];