<?php

namespace Modules\Player\Services;

use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;
use Modules\Player\Repositories\Interfaces\LineupPlayerTypeRepositoryInterface;

class LineupPlayerTypeService 
{
    /**
     * @var $lineupPlayerTypeRepository
     */
    protected $lineupPlayerTypeRepository;
    
    /**
     * @var $sportRepository
     */
    protected $sportRepository;

    /**
     * Creates a new service instance
     */
    public function __construct(
        LineupPlayerTypeRepositoryInterface $lineupPlayerTypeRepository,
        SportRepositoryInterface $sportRepository
    )
    {
        $this->lineupPlayerTypeRepository = $lineupPlayerTypeRepository;
        $this->sportRepository = $sportRepository;
    }

    public function getLineupPlayerType($code)
    {
        $sport = $this->sportRepository->findOneBy(['code' => $code]);

        return $this->lineupPlayerTypeRepository->getTypesLineup($sport);
    }
}