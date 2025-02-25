<?php

namespace Modules\Injury\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Injury\Repositories\Interfaces\MechanismInjuryRepositoryInterface;

class MechanismsInjuryTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $mechanismInjuryRepository;

    public function __construct(MechanismInjuryRepositoryInterface $mechanismInjuryRepository)
    {
        $this->mechanismInjuryRepository = $mechanismInjuryRepository;
    }

    /**
     * @return void
     */
    protected function createMechanismInjury(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->mechanismInjuryRepository->create($elm);
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
                    'name' => 'Corriendo / esprintando'
                ],
                'en' => [
                    'name' => 'Running / sprinting'
                ],
                'code' => 'running_sprinting'
            ],
            [
                'es' => [
                    'name' => 'Girando'
                ],
                'en' => [
                    'name' => 'Turning'
                ],
                'code' => 'turning'
            ],
            [
                'es' => [
                    'name' => 'Tirando / Lanzando'
                ],
                'en' => [
                    'name' => 'Pulling / Throwing'
                ],
                'code' => 'pulling_throwing'
            ],
            [
                'es' => [
                    'name' => 'Driblando'
                ],
                'en' => [
                    'name' => 'Dribbling'
                ],
                'code' => 'dribbling'
            ],
            [
                'es' => [
                    'name' => 'Saltando / aterrizando'
                ],
                'en' => [
                    'name' => 'Jumping / landing'
                ],
                'code' => 'jumping_landing'
            ],
            [
                'es' => [
                    'name' => 'Caída'
                ],
                'en' => [
                    'name' => 'Fall'
                ],
                'code' => 'fall'
            ],
            [
                'es' => [
                    'name' => 'Estirando'
                ],
                'en' => [
                    'name' => 'Stretching'
                ],
                'code' => 'stretching'
            ],
            [
                'es' => [
                    'name' => 'Resbalando / deslizando'
                ],
                'en' => [
                    'name' => 'Slipping / sliding'
                ],
                'code' => 'slipping_sliding'
            ],
            [
                'es' => [
                    'name' => 'Sobreuso'
                ],
                'en' => [
                    'name' => 'Overuse'
                ],
                'code' => 'overuse'
            ],
            [
                'es' => [
                    'name' => 'Golpeando el balón'
                ],
                'en' => [
                    'name' => 'Hitting the ball'
                ],
                'code' => 'hitting_ball'
            ],
            [
                'es' => [
                    'name' => 'Colisión'
                ],
                'en' => [
                    'name' => 'Collision'
                ],
                'code' => 'collision'
            ],
            [
                'es' => [
                    'name' => 'Rematando de cabeza'
                ],
                'en' => [
                    'name' => 'Topping off head'
                ],
                'code' => 'topping_head'
            ],
            [
                'es' => [
                    'name' => 'Tras una entrada realizada'
                ],
                'en' => [
                    'name' => 'After an entry made'
                ],
                'code' => 'after_entry_made'
            ],
            [
                'es' => [
                    'name' => 'Tras una entrada recibida'
                ],
                'en' => [
                    'name' => 'After an entry received'
                ],
                'code' => 'after_entry_received'
            ],
            [
                'es' => [
                    'name' => 'Golpeando'
                ],
                'en' => [
                    'name' => 'Hitting'
                ],
                'code' => 'hitting'
            ],
            [
                'es' => [
                    'name' => 'Bloqueando'
                ],
                'en' => [
                    'name' => 'Blocking'
                ],
                'code' => 'blocking'
            ]
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createMechanismInjury($this->get()->current());
    }
}
