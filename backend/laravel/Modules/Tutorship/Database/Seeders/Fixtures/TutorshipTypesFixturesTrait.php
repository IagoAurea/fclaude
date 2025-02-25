<?php

namespace Modules\Tutorship\Database\Seeders\Fixtures;

trait TutorshipTypesFixturesTrait
{
    /**
     * * Get the list of tutorship types to seed
     */
    private function getTutorshipTypes()
    {
        return [
            [
                'code' => 'face-to-face',
                'es_name' => 'Presencial',
                'en_name' => 'Face to face',
            ],
            [
                'code' => 'telephone',
                'es_name' => 'Telefónica',
                'en_name' => 'Telephone',
            ],
            [
                'code' => 'email',
                'es_name' => 'Vía e-mail',
                'en_name' => 'Via email',
            ],
            [
                'code' => 'videocall',
                'es_name' => 'Videollamada',
                'en_name' => 'Video call',
            ],
            [
                'code' => 'digital-platform',
                'es_name' => 'Plataforma digital',
                'en_name' => 'Digital platform',
            ],
            [
                'code' => 'chat',
                'es_name' => 'Chat',
                'en_name' => 'Chat',
            ],
            [
                'code' => 'other',
                'es_name' => 'Otra',
                'en_name' => 'Other',
            ],
        ];
    }
}
