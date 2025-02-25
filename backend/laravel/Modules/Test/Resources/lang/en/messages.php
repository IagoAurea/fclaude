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

    'policies.test.store.deny.max_limit' => 'The maximum limit to create test report has been reached',
    'policies.test.store.deny' => 'User not authorize store test report',
    'policies.test.update.deny' => 'User not authorize update test report',
    'policies.test.show.deny' => 'User not authorize show test report',
    'policies.test.index.deny' => 'User not authorize list test reports',
    'policies.test.delete.deny' => 'User not authorize delete test report',
];