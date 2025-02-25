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

    'policies.player.store.deny' => 'User not authorize store player',
    'policies.player.store.deny.max_limit' => 'The maximum limit to create player has been reached',
    'policies.player.update.deny' => 'User not authorize update player',
    'policies.player.show.deny' => 'User not authorize show player',
    'policies.player.index.deny' => 'User not authorize list players',
    'policies.player.delete.deny' => 'User not authorize delete player',
];