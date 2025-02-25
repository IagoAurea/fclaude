<?php

namespace Modules\EffortRecovery\Database\Seeders;

use Illuminate\Database\Seeder;

// Repositories
use Modules\EffortRecovery\Repositories\Interfaces\EffortRecoveryStrategyRepositoryInterface;

class EffortRecoveryStrategyTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $effortStrategyRepository;

    /**
     * Creates a new seeder instance
     */
    public function __construct(EffortRecoveryStrategyRepositoryInterface $effortStrategyRepository)
    {
        $this->effortStrategyRepository = $effortStrategyRepository;
    }

    /**
     * @return void
     */
    protected function createStrategyItems(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->effortStrategyRepository->create($elm);
        }
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                'es' => [
                    'name' => 'Sueño'
                ],
                'en' => [
                    'name' => 'Dream'
                ],
                'code' => 'dream',
            ],
            [
                'es' => [
                    'name' => 'Nutrición'
                ],
                'en' => [
                    'name' => 'Nutrition'
                ],
                'code' => 'nutrition',
            ],
            [
                'es' => [
                    'name' => 'Estiramientos'
                ],
                'en' => [
                    'name' => 'Stretching'
                ],
                'code' => 'stretching',
            ],
            [
                'es' => [
                    'name' => 'Compresión'
                ],
                'en' => [
                    'name' => 'Compression'
                ],
                'code' => 'compression',
            ],
            [
                'es' => [
                    'name' => 'Inmersión en agua fría'
                ],
                'en' => [
                    'name' => 'Immersion in cold water'
                ],
                'code' => 'immersion',
            ],
            [
                'es' => [
                    'name' => 'Liberación miofascial'
                ],
                'en' => [
                    'name' => 'Myofascial release'
                ],
                'code' => 'myofascial',
            ],
            [
                'es' => [
                    'name' => 'Recuperación activa'
                ],
                'en' => [
                    'name' => 'Active recovery'
                ],
                'code' => 'active_recovery',
            ],
            [
                'es' => [
                    'name' => 'Recuperación activa en agua'
                ],
                'en' => [
                    'name' => 'Active recovery in water'
                ],
                'code' => 'active_water_recovery',
            ],
            [
                'es' => [
                    'name' => 'Ejercicios resistidos activos'
                ],
                'en' => [
                    'name' => 'Active resisted exercises'
                ],
                'code' => 'resisted_exercises',
            ],
            [
                'es' => [
                    'name' => 'Terapia manual / masaje'
                ],
                'en' => [
                    'name' => 'Manual therapy / massage'
                ],
                'code' => 'manual_therapy',
            ],
            [
                'es' => [
                    'name' => 'Evento social de grupo'
                ],
                'en' => [
                    'name' => 'Group social event'
                ],
                'code' => 'social_event',
            ],
            [
                'es' => [
                    'name' => 'Acupuntura'
                ],
                'en' => [
                    'name' => 'Acupuncture'
                ],
                'code' => 'acupuncture',
            ],
            [
                'es' => [
                    'name' => 'Otro'
                ],
                'en' => [
                    'name' => 'Other'
                ],
                'code' => 'other',
            ],
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createStrategyItems($this->get()->current());
    }
}
