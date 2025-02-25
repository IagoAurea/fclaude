<?php

return [

    'models' => [

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your permissions. Of course, it
         * is often just the "Permission" model but you may use whatever you like.
         *
         * The model you want to use as a Permission model needs to implement the
         * `Spatie\Permission\Contracts\Permission` contract.
         */

        // 'permission' => Spatie\Permission\Models\Permission::class,
        'permission' => Modules\User\Entities\Permission::class,

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your roles. Of course, it
         * is often just the "Role" model but you may use whatever you like.
         *
         * The model you want to use as a Role model needs to implement the
         * `Spatie\Permission\Contracts\Role` contract.
         */

        'role' => Spatie\Permission\Models\Role::class,

    ],

    'table_names' => [

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your roles. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'roles' => 'roles',

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * table should be used to retrieve your permissions. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'permissions' => 'permissions',

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * table should be used to retrieve your models permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'model_has_permissions' => 'model_has_permissions',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your models roles. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'model_has_roles' => 'model_has_roles',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your roles permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [

        /*
         * Change this if you want to name the related model primary key other than
         * `model_id`.
         *
         * For example, this would be nice if your primary keys are all UUIDs. In
         * that case, name this `model_uuid`.
         */

        'model_morph_key' => 'model_id',
    ],

    /*
     * When set to true, the required permission names are added to the exception
     * message. This could be considered an information leak in some contexts, so
     * the default setting is false here for optimum safety.
     */

    'display_permission_in_exception' => false,

    /*
     * When set to true, the required role names are added to the exception
     * message. This could be considered an information leak in some contexts, so
     * the default setting is false here for optimum safety.
     */

    'display_role_in_exception' => false,

    /*
     * By default wildcard permission lookups are disabled.
     */

    'enable_wildcard_permission' => false,

    'cache' => [

        /*
         * By default all permissions are cached for 24 hours to speed up performance.
         * When permissions or roles are updated the cache is flushed automatically.
         */

        'expiration_time' => \DateInterval::createFromDateString('24 hours'),

        /*
         * The cache key used to store all permissions.
         */

        'key' => 'spatie.permission.cache',

        /*
         * When checking for a permission against a model by passing a Permission
         * instance to the check, this key determines what attribute on the
         * Permissions model is used to cache against.
         *
         * Ideally, this should match your preferred way of checking permissions, eg:
         * `$user->can('view-posts')` would be 'name'.
         */

        'model_key' => 'name',

        /*
         * You may optionally indicate a specific cache driver to use for permission and
         * role caching using any of the `store` drivers listed in the cache.php config
         * file. Using 'default' here means to use the `default` set in cache.php.
         */

        'store' => 'default',
    ],

    /**
     * General permission list to be managed around all the application
     */
    'names' => [
        [
            'entity_code' => 'club',
            'codes' => [
                'club_list',
                'club_store',
                'club_read',
                'club_update',
                'club_delete',
            ]
        ],
        [
            'entity_code' => 'team',
            'codes' => [
                'club_team_list',
                'club_team_read',
                'club_team_store',
                'club_team_update',
                'club_team_delete',
            ]
        ],
        [
            'entity_code' => 'competition',
            'codes' => [
                'team_competition_list',
                'team_competition_read',
                'team_competition_store',
                'team_competition_update',
                'team_competition_delete',
            ]
        ],
        [
            'entity_code' => 'competition_match',
            'codes' => [
                'team_competition_match_list',
                'team_competition_match_read',
                'team_competition_match_store',
                'team_competition_match_update',
                'team_competition_match_delete',
            ]
        ],
        [
            'entity_code' => 'scouting',
            'codes' => [
                'team_scouting_list',
                'team_scouting_read',
                'team_scouting_store',
                'team_scouting_update',
                'team_scouting_delete',
            ]
        ],
        [
            'entity_code' => 'player',
            'codes' => [
                'team_players_list',
                'team_players_read',
                'team_players_store',
                'team_players_update',
                'team_players_delete',
            ]
        ],
        [
            'entity_code' => 'exercise',
            'codes' => [
                'team_exercise_list',
                'team_exercise_read',
                'team_exercise_store',
                'team_exercise_update',
                'team_exercise_delete',
            ]
        ],
        [
            'entity_code' => 'session_exercise',
            'codes' => [
                'team_session_exercise_list',
                'team_session_exercise_read',
                'team_session_exercise_store',
                'team_session_exercise_update',
                'team_session_exercise_delete',
            ]
        ],
        [
            'entity_code' => 'test',
            'codes' => [
                
                'team_test_list',
                'team_test_read',
                'team_test_store',
                'team_test_update',
                'team_test_delete',
            ]
        ],
        [
            'entity_code' => 'injury_prevention',
            'codes' => [
                
                'team_injury_prevention_list',
                'team_injury_prevention_read',
                'team_injury_prevention_store',
                'team_injury_prevention_update',
                'team_injury_prevention_delete',
            ]
        ],
        [
            'entity_code' => 'injury_rfd',
            'codes' => [
                
                'team_injury_rfd_list',
                'team_injury_rfd_read',
                'team_injury_rfd_store',
                'team_injury_rfd_update',
                'team_injury_rfd_delete',
            ]
        ],
        [
            'entity_code' => 'fisiotherapy',
            'codes' => [
                
                'team_fisiotherapy_list',
                'team_fisiotherapy_read',
                'team_fisiotherapy_store',
                'team_fisiotherapy_update',
                'team_fisiotherapy_delete',
            ]
        ],
        [
            'entity_code' => 'effort_recovery',
            'codes' => [
                
                'team_effort_recovery_list',
                'team_effort_recovery_read',
                'team_effort_recovery_store',
                'team_effort_recovery_update',
                'team_effort_recovery_delete',
            ]
        ],
        [
            'entity_code' => 'nutrition',
            'codes' => [
                
                'team_nutrition_list',
                'team_nutrition_read',
                'team_nutrition_store',
                'team_nutrition_update',
                'team_nutrition_delete',
            ]
        ],
        [
            'entity_code' => 'psychology',
            'codes' => [
                
                'team_psychology_list',
                'team_psychology_read',
                'team_psychology_store',
                'team_psychology_update',
                'team_psychology_delete',
            ]
        ],
    ]
];
