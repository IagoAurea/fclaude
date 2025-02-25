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

    'policies.competition.store.deny' => 'Usuario no autorizado para crear competición',
    'policies.competition.update.deny' => 'Usuario no autorizado para actualizar competición',
    'policies.competition.delete.deny' => 'Usuario no autorizado para eliminar competición',
    'policies.competition.show.deny' => 'Usuario no autorizado para ver detalle de competición',
    'policies.competition_match.store.deny' => 'Usuario no autorizado para crear partido',
    'policies.competition_match.deny.max_limit' => 'Se alcanzó el limite maximo para crear partido',
    'policies.competition_match.update.deny' => 'Usuario no autorizado para actualizar partido',
    'policies.competition_match.show.deny' => 'Usuario no autorizado para ver detalle de partido',
    'policies.competition_match.index.deny' => 'Usuario no autorizado para listar partidos',
];
