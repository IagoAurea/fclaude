<?php

namespace Modules\Tutorship\Database\Seeders\Fixtures;

trait SpecialistReferralFixturesTrait
{
    /**
     * * Get the list of specialist referrals
     */
    private function getSpecialistReferrals()
    {
        return [
            [
                'code' => 'direction',
                'es_name' => 'Dirección',
                'en_name' => 'Direction',
            ],
            [
                'code' => 'orientation-department',
                'es_name' => 'Departamento de orientación',
                'en_name' => 'Orientation department',
            ],
            [
                'code' => 'psychiatrist',
                'es_name' => 'Psiquiatra',
                'en_name' => 'Psychiatrist',
            ],
            [
                'code' => 'neurologist',
                'es_name' => 'Neurólogo',
                'en_name' => 'Neurologist',
            ],
            [
                'code' => 'others',
                'es_name' => 'Otros',
                'en_name' => 'Others',
            ],
            [
                'code' => 'none',
                'es_name' => 'Ninguno',
                'en_name' => 'None',
            ],
        ];
    }
}
