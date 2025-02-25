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

    'policies.test.store.deny.max_limit' => 'Se alcanzó el limite maximo para crear ficha de test',
    'policies.test.store.deny' => 'Usuario no tiene permiso para crear ficha de test',
    'policies.test.update.deny' => 'Usuario no tiene permiso para actualizar ficha de test',
    'policies.test.show.deny' => 'Usuario no tiene permiso para ver ficha de test',
    'policies.test.index.deny' => 'Usuario no tiene permiso para listar fichas de test',
    'policies.test.delete.deny' => 'Usuario no tiene permiso para borrar ficha de test',

];