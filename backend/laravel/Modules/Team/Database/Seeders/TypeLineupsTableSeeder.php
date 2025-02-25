<?php

namespace Modules\Team\Database\Seeders;

use App\Services\BaseSeeder;
use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;
use Modules\Team\Repositories\Interfaces\TeamModalityRepositoryInterface;
use Modules\Team\Repositories\Interfaces\TypeLineupRepositoryInterface;

class TypeLineupsTableSeeder extends BaseSeeder
{
    /**
     * @var object
     */
    protected $typeLineupRepository;

    /**
     * @var $sportRepository
     */
    protected $sportRepository;

    /**
     * @var $teamModalityRepository
     */
    protected $teamModalityRepository;

    /**
     * @var array
     */
    protected $type_lineups = [];

    /**
     * TypeLineupsTableSeeder constructor.
     * @param TypeLineupRepositoryInterface $typeLineupRepository
     */
    public function __construct(TypeLineupRepositoryInterface $typeLineupRepository,
                                SportRepositoryInterface $sportRepository,
                                TeamModalityRepositoryInterface $teamModalityRepository)
    {
        $this->typeLineupRepository = $typeLineupRepository;
        $this->sportRepository = $sportRepository;
        $this->teamModalityRepository = $teamModalityRepository;
    }

    /**
     * @return void
     */
    protected function mergeTypeLineups()
    {
        $filename = "type-lineups.json";

        $elements = $this->getDataJson($filename);

        foreach($elements as $elm) {
            $this->type_lineups[] = [
                "sport_id" => $this->sportRepository->findOneBy(["code" => $elm['sport']])->id,
                "modality_id" => $elm['modality'] && $elm['modality'] !== null
                    ? $this->teamModalityRepository->findOneBy(["code" => $elm['modality']])->id : null,
                "lineup" => $elm['lineup'],
                "total_players" => $elm['total_players']
            ];
        }
    }

    /**
     * @return void
     */
    protected function createTypeLineup()
    {
        foreach ($this->type_lineups as $elm)
        {
            $this->typeLineupRepository->create($elm);
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->mergeTypeLineups();
        $this->createTypeLineup();
    }
}
