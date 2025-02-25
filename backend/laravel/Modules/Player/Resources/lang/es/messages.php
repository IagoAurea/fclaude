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

    'policies.player.store.deny' => 'Usuario no autorizado para agregar jugador',
    'policies.player.store.deny.max_limit' => 'Se alcanzó el limite maximo para crear juagdor',
    'policies.player.update.deny' => 'Usuario no autorizado para actualizar jugador',
    'policies.player.show.deny' => 'Usuario no autorizado para ver jugador',
    'policies.player.index.deny' => 'Usuario no autorizado para listar jugadores',
    'policies.player.delete.deny' => 'Usuario no autorizado para eliminar jugador',
];