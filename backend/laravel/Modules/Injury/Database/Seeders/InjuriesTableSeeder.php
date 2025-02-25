<?php

namespace Modules\Injury\Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;

// Services
use Modules\Injury\Services\InjuryService;

// Repositories
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\MechanismInjuryRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjurySituationRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjuryExtrinsicFactorRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjuryIntrinsicFactorRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjuryTypeRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjurySeverityRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjuryLocationRepositoryInterface;
use Modules\Health\Repositories\Interfaces\AreaBodyRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\ClinicalTestTypeRepositoryInterface;

class InjuriesTableSeeder extends Seeder
{
    const INJURY_LIMIT = 3;

    /**
     * @var object
     */
    protected $injuryService;

    /**
     * @var object
     */
    protected $playerRepository;

    /**
     * @var object
     */
    protected $mechanismInjuryRepository;

    /**
     * @var object
     */
    protected $injurySituationRepository;

    /**
     * @var object
     */
    protected $injuryExtrinsicFactorRepository;

    /**
     * @var object
     */
    protected $injuryIntrinsicFactorRepository;

    /**
     * @var object
     */
    protected $injuryTypeRepository;

    /**
     * @var object
     */
    protected $areaBodyRepository;

    /**
     * @var object
     */
    protected $injurySeverityRepository;

    /**
     * @var object
     */
    protected $injuryLocationRepository;

    /**
     * @var object
     */
    protected $clinicalTestTypeRepository;

    /**
     * @var object
     */
    protected $faker;

    /**
     * Creates a new seeder instance
     */
    public function __construct(
        InjuryService $injuryService,
        PlayerRepositoryInterface $playerRepository,
        MechanismInjuryRepositoryInterface $mechanismInjuryRepository,
        InjurySituationRepositoryInterface $injurySituationRepository,
        InjuryExtrinsicFactorRepositoryInterface $injuryExtrinsicFactorRepository,
        InjuryIntrinsicFactorRepositoryInterface $injuryIntrinsicFactorRepository,
        InjuryTypeRepositoryInterface $injuryTypeRepository,
        AreaBodyRepositoryInterface $areaBodyRepository,
        InjurySeverityRepositoryInterface $injurySeverityRepository,
        InjuryLocationRepositoryInterface $injuryLocationRepository,
        ClinicalTestTypeRepositoryInterface $clinicalTestTypeRepository
    ) {
        $this->injuryService = $injuryService;
        $this->playerRepository = $playerRepository;
        $this->mechanismInjuryRepository = $mechanismInjuryRepository;
        $this->injurySituationRepository = $injurySituationRepository;
        $this->injuryExtrinsicFactorRepository = $injuryExtrinsicFactorRepository;
        $this->injuryIntrinsicFactorRepository = $injuryIntrinsicFactorRepository;
        $this->injuryTypeRepository = $injuryTypeRepository;
        $this->areaBodyRepository = $areaBodyRepository;
        $this->injurySeverityRepository = $injurySeverityRepository;
        $this->injuryLocationRepository = $injuryLocationRepository;
        $this->clinicalTestTypeRepository = $clinicalTestTypeRepository;
        $this->faker = Factory::create();
    }

    /**
     * Loop through all player entities and insert an individual injury row
     * 
     * @return void
     */
    private function createInjuries()
    {
        $players = $this->playerRepository->findAll();
        // $clinicalTestTypeIds = $this->clinicalTestTypeRepository->getRegisteredIds();
      
        foreach ($players as $player) {
            for ($i = 0; $i < self::INJURY_LIMIT; $i ++) {
                $injuryType = $this->injuryTypeRepository->findAll()->random();

                $requestPayload = [
                    'is_active' => $this->faker->boolean(25),
                    'entity_id' => $player->id,
                    'entity_type' => get_class($player),
                	'injury_date' => $this->faker->dateTimeThisMonth(),
                    'mechanism_injury_id' => $this->mechanismInjuryRepository->findAll()->random()->id,
                    'injury_situation_id' => $this->injurySituationRepository->findAll()->random()->id,
                    'is_triggered_by_contact' => $this->faker->boolean(50),
                    'injury_type_id' => $injuryType->id,
                    'injury_type_spec_id' => $injuryType->specs->random()->id,
                    'detailed_diagnose' => $this->faker->text(20),
                    'area_body_id' => $this->areaBodyRepository->findAll()->random()->id,
                    'detailed_location' => $this->faker->text(20),
                    'affected_side_id' => $this->faker->numberBetween(0, 1),
                    'is_relapse' => $this->faker->boolean(50),
                    'injury_severity_id' => $this->injurySeverityRepository->findAll()->random()->id,
                    'injury_location_id' => $this->injuryLocationRepository->findAll()->random()->id,
                    'injury_forecast' => $this->faker->sentence(),
                    'days_off' => $this->faker->numberBetween(1, 20),
                    'matches_off' => $this->faker->numberBetween(2, 12),
                    'medically_discharged_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
                    'sportly_discharged_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
                    'competitively_discharged_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
                    'surgery_date' => $this->faker->dateTimeBetween('+5 days', '+1 year'),
                    'surgeon_name' => $this->faker->name(),
                    'medical_center_name' => $this->faker->name(),
                    'surgery_extra_info' => $this->faker->sentence(),
                    'extra_info' => $this->faker->sentence(),
                ];

                $this->injuryService->store($requestPayload);
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createInjuries();
    }
}
