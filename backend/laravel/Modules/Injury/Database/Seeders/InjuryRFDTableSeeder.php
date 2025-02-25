<?php

namespace Modules\Injury\Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;

// Repositories
use Modules\Injury\Repositories\Interfaces\InjuryRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjuryRfdRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\CurrentSituationRepositoryInterface;

class InjuryRFDTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $injuryRepository;

    /**
     * @var object
     */
    protected $injuryRfdRepository;

    /**
     * @var object
     */
    protected $rfdSitutationRepository;

    /**
     * @var object
     */
    protected $faker;

    /**
     * Creates a new seeder instance
     *
     * @return void
     */
    public function __construct(
        InjuryRepositoryInterface $injuryRepository,
        InjuryRfdRepositoryInterface $injuryRfdRepository,
        CurrentSituationRepositoryInterface $rfdSitutationRepository
    ) {
        $this->injuryRepository = $injuryRepository;
        $this->injuryRfdRepository = $injuryRfdRepository;
        $this->rfdSitutationRepository = $rfdSitutationRepository;

        $this->faker = Factory::create();
    }

    /**
     * Store multiple RFD type rows into the database
     * 
     * @return void
     */
    private function createRfds()
    {
        $injuries = $this->injuryRepository->findAll();
        $situations = $this->rfdSitutationRepository->findAll();

        foreach ($injuries as $injury) {
            $payloadData = [
                'injury_id' => $injury->id,
                'percentage_complete' => $this->faker->randomFloat(),
                'current_situation_id' => $situations->random()->id,
                'annotations' => $this->faker->text(),
                'closed' => $this->faker->boolean(),
            ];

            $this->injuryRfdRepository->create($payloadData);
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRfds();
    }
}
