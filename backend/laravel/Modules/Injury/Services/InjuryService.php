<?php

namespace Modules\Injury\Services;

use App\Helpers\Helper;
use App\Traits\ResponseTrait;
use App\Traits\ResourceTrait;
use Modules\Alumn\Entities\Alumn;
use Modules\Player\Entities\Player;
use Modules\Injury\Cache\InjuryCache;
use Modules\Calculator\Services\CalculatorService;
use Modules\Calculator\Repositories\CalculatorItemTypeRepository;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjuryRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjuryClinicalTestTypeRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjurySeverityLocationRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjuriesExtrinsicFactorRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjuriesIntrinsicFactorRepositoryInterface;

class InjuryService
{
    use ResponseTrait, ResourceTrait;

    /**
     * @var $playerRepository
     */
    protected $playerRepository;

    /**
     * @var $injuryRepository
     */
    protected $injuryRepository;
    
    /**
     * @var $injurySeverityLocationRepository
     */
    protected $injurySeverityLocationRepository;

    /**
     * @var $injuryClinicalTestTypeRepository
     */
    protected $injuryClinicalTestTypeRepository;

    /**
     * @var $injuryIntrinsicRepository
     */
    protected $injuryIntrinsicRepository;

    /**
     * @var $injuryExtrinsicRepository
     */
    protected $injuryExtrinsicRepository;

    /**
     * @var object $calculatorItemTypeRepository
     */
    protected $calculatorItemTypeRepository;

    /**
     * @var $calculatorService
     */
    protected $calculatorService;

    /**
     * @var $injuryCache
     */
    protected $injuryCache;

    /**
     * @var $helper
     */
    protected $helper;

    /**
     * Create a new service instance
     */
    public function __construct(
        PlayerRepositoryInterface $playerRepository,
        InjuryRepositoryInterface $injuryRepository,
        InjurySeverityLocationRepositoryInterface $injurySeverityLocationRepository,
        InjuriesIntrinsicFactorRepositoryInterface $injuryIntrinsicRepository,
        InjuriesExtrinsicFactorRepositoryInterface $injuryExtrinsicRepository,
        InjuryClinicalTestTypeRepositoryInterface $injuryClinicalTestTypeRepository,
        CalculatorService $calculatorService,
        CalculatorItemTypeRepository $calculatorItemTypeRepository,
        InjuryCache $injuryCache,
        Helper $helper
    ) {
        $this->playerRepository = $playerRepository;
        $this->injuryRepository = $injuryRepository;
        $this->injurySeverityLocationRepository = $injurySeverityLocationRepository;
        $this->injuryIntrinsicRepository = $injuryIntrinsicRepository;
        $this->injuryExtrinsicRepository = $injuryExtrinsicRepository;
        $this->injuryClinicalTestTypeRepository = $injuryClinicalTestTypeRepository;
        $this->calculatorItemTypeRepository = $calculatorItemTypeRepository;
        $this->calculatorService = $calculatorService;
        $this->injuryCache = $injuryCache;
        $this->helper = $helper;
    }

    /**
     * Handles the player injury information
     *
     * @param Array $data
     * @return Object
     */
    public function store($data)
    {
        $injury = $this->injuryRepository->create($data);

        if (isset($data['clinical_test_types'])) {
            foreach ($data['clinical_test_types'] as $cttype) {
                $this->injuryClinicalTestTypeRepository->create([
                    'injury_id' => $injury->id,
                    'clinical_test_type_id' => $cttype
                ]);
            }
        }
        
        if ( isset($data['injury_extrinsic_factor']) && count($data['injury_extrinsic_factor']) > 0 ) {
            $injury->extrinsicFactor()->attach($data['injury_extrinsic_factor']);
        }
        
        if ( isset($data['injury_intrinsic_factor']) && count($data['injury_extrinsic_factor']) > 0 ) {
            $injury->intrinsicFactor()->attach($data['injury_intrinsic_factor']);
        }

        return $injury;
    }

    /**
     * Deletes an existent injury
     *
     * @param Object $injury
     * @return Boolean
     */
    public function destroy($injury)
    {
        return $this->injuryRepository->delete($injury->id);
    }

    /**
     * Retrieve locations of injuries
     *
     * @param $alumn_id
     */
    public function injuriesLocationsByAlumn($alumn_id)
    {
        $injuries = $this->injuryRepository->getInjuriesLocation('alumn', $alumn_id);

        foreach($injuries as $injury) {
            $injury->severity_location = $this->severityLocation($injury->injury_severity_id, $injury->injury_location_id);
            $injury->makeHidden(['affected_side', 'injury_severity_id', 'injury_location_id']);
        }

        return $injuries;
    }
    
    /**
     * Retrieve last injury by alumn
     * @param $alumn_id
     */
    public function lastInjuryByAlumn($alumn_id)
    {
        $injury = $this->injuryRepository->findBy([
                'entity_id' => $alumn_id,
                'entity_type' => Alumn::class
            ])
            ->sortBy([
                ['created_at', 'desc'],
                ['injury_date', 'desc']
            ])->first();
            
        if($injury) {
            $injury->location;

            $injury->severity_location = $this->severityLocation($injury->injury_severity_id, $injury->injury_location_id);
        }

        return $injury;
    }

    /**
     * Retrieve last injury by player
     * @param $player_id
     */
    public function lastInjuryByPlayer($player_id)
    {
        $injury = $this->injuryRepository->findBy([
                'entity_id' => $player_id,
                'entity_type' => Player::class
            ])
            ->sortBy([
                ['created_at', 'desc'],
                ['injury_date', 'desc']
            ])->first();
            
        if($injury) {
            $injury->location;

            $injury->severity_location = $this->severityLocation($injury->injury_severity_id, $injury->injury_location_id);
        }

        return $injury;
    }

    /**
     * Retrieve locations of injuries of player
     *
     * @param $player_id
     */
    public function injuriesLocationsByPlayer($player_id)
    {
        $injuries = $this->injuryRepository->getInjuriesLocation('player', $player_id);

        $injuries->makeHidden(['affected_side', 'injury_severity_id', 'injury_location_id']);

        foreach($injuries as $injury) {
            $injury->severity_location = $this->severityLocation($injury->injury_severity_id, $injury->injury_location_id);
        }

        return $injuries;
    }

    /**
     * Retrieve resume totals injuries by player
     * @param $player_id
     */
    public function resumeInjuriesByPlayer($player_id)
    {
        $injuries = $this->injuryRepository->findBy([
            'entity_id' => $player_id,
            'entity_type' => Player::class
        ]);

        $total_injuries = $injuries->count();
            
        $injuries_player = $this->resumeInjuries($injuries);

        $injuries_risk = $this->calculatorService->getHistory('player', $player_id);
        
        $risk = count($injuries_risk) > 0 ? $injuries_risk[0] : null;

        if($risk) {
            $risk->rank = $this->calculatorItemTypeRepository->getItemType($risk->total_points);
        }

        return [
            'injuries' => $injuries_player,
            'injuries_by_severity' => $this->severitiesInjury($injuries->countBy('severity.code')),
            'injuries_by_type' => $injuries->countBy('type.code'),
            'total_injuries' => $total_injuries,
            'injury_risk' => $risk
        ];
    }
    /**
     * Retrieve resume totals injuries by alumn
     * @param $alumn_id
     */
    public function resumeInjuriesByAlumn($alumn_id)
    {
        $injuries = $this->injuryRepository->findBy([
            'entity_id' => $alumn_id,
            'entity_type' => Alumn::class
        ]);

        $total_injuries = $injuries->count();
            
        $injuries_alumn = $this->resumeInjuries($injuries);

        $injuries_risk = $this->calculatorService->getHistory('alumn', $alumn_id);
        
        $risk = count($injuries_risk) > 0 ? $injuries_risk[0] : null;

        if($risk) {
            $risk->rank = $this->calculatorItemTypeRepository->getItemType($risk->total_points);
        }

        return [
            'injuries' => $injuries_alumn,
            'injuries_by_severity' => $this->severitiesInjury($injuries->countBy('severity.code')),
            'injuries_by_type' => $injuries->countBy('type.code'),
            'total_injuries' => $total_injuries,
            'injury_risk' => $risk
        ];
    }

    /**
     * Retrieve data severity by location
     *
     * @param $severity
     * @param $location
     *
     */
    public function severityLocation($severity, $location)
    {
        $servity_location = $this->injurySeverityLocationRepository->findOneBy([
            'severity_id' => $severity,
            'location_id' => $location
        ]);

        return $servity_location;
    }

    /**
     * Retrieve merge severities alumn
     */
    private function severitiesInjury($severity_group)
    {
        $severities = $this->injuryCache->getAllSeveritiesInjuryCode();

        $result = [];

        foreach($severities as $severity) {
            $result[$severity] = $severity_group[$severity] ?? 0;
        }

        return $result;
    }

    /**
     * Retrieve resume injuries
     */
    private function resumeInjuries($injuries)
    {
        foreach($injuries as $injury) {
            $injury->severity;
            $injury->type;
            $injury->areaBody;
            $injury->location;
            $injury->typeSpec->image ?? null;
            $injury->severity_location = $this->severityLocation($injury->injury_severity_id, $injury->injury_location_id);
        }

        return $this->helper->sortArrayByKey($injuries->toArray(), 'injury_date', true);
    }

}
