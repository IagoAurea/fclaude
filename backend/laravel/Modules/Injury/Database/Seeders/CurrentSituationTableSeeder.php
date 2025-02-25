<?php

namespace Modules\Injury\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Injury\Repositories\Interfaces\CurrentSituationRepositoryInterface;

class CurrentSituationTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $currentSituationRepository;

    public function __construct(CurrentSituationRepositoryInterface $currentSituationRepository)
    {
        $this->currentSituationRepository = $currentSituationRepository;
    }

    /**
     * @return void
     */
    protected function createCurrentSituation(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->currentSituationRepository->create($elm);
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
                    'name' => 'EL JUGADOR PUEDE VOLVER CON CIERTAS GARANTÍAS'
                ],
                'en' => [
                    'name' => 'THE PLAYER CAN RETURN WITH CERTAIN GUARANTEES'
                ],
                'code'           => 'can_return',
                'color'          => '#82FD07',
                'min_percentage' => 40,
                'max_percentage' => 100,
                'type'           => 1,
            ],
            [
                'es' => [
                    'name' => 'SE DEBERÍAN DE TENER EN CUENTA OTRO TIPO DE PRUEBAS COMPLEMENTARIAS'
                ],
                'en' => [
                    'name' => 'ANOTHER TYPE OF ADDITIONAL TESTS SHOULD BE TAKEN INTO CONSIDERATION'
                ],
                'code'           => 'other_test',
                'color'          => '#FDD807',
                'min_percentage' => 35,
                'max_percentage' => 39,
                'type'           => 1,
            ],
            [
                'es' => [
                    'name' => 'LA PREDISPOSICIÓN DEL DEPORTISTA AL RETORNO NO ES ADECUADA'
                ],
                'en' => [
                    'name' => 'THE PREDISPOSITION OF THE ATHLETE TO RETURN IS NOT ADEQUATE'
                ],
                'code'           => 'cant_return',
                'color'          => '#FF0000',
                'min_percentage' => 0,
                'max_percentage' => 35,
                'type'           => 1,
            ],
            [
                'es' => [
                    'name' => 'EL JUGADOR ESTÁ LISTO PARA PASAR A LA SIGUIENTE FASE	'
                ],
                'en' => [
                    'name' => 'THE PLAYER IS READY TO GO TO THE NEXT PHASE'
                ],
                'code'           => 'next_phase',
                'color'          => '#82FD07',
                'min_percentage' => 85,
                'max_percentage' => 100,
                'type'           => 2,
            ],
            [
                'es' => [
                    'name' => 'EL JUGADOR PROGRESA ADECUADAMENTE PERO NO ES SUFICIENTE PARA PASAR A LA SIGUIENTE FASE	'
                ],
                'en' => [
                    'name' => 'THE PLAYER PROGRESSES PROPERLY BUT IS NOT ENOUGH TO GO TO THE NEXT PHASE'
                ],
                'code'           => 'progresses',
                'color'          => '#FDD807',
                'min_percentage' => 60,
                'max_percentage' => 84.9,
                'type'           => 2,
            ],
            [
                'es' => [
                    'name' => 'EL JUGADOR NO ESTÁ LISTO PARA PASAR A LA SIGUIENTE FASE'
                ],
                'en' => [
                    'name' => 'THE PLAYER IS NOT READY TO GO TO THE NEXT PHASE'
                ],
                'code'           => 'cant_passed',
                'color'          => '#FF0000',
                'min_percentage' => 0,
                'max_percentage' => 59.9,
                'type'           => 2,
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
        $this->createCurrentSituation($this->get()->current());
    }
}
