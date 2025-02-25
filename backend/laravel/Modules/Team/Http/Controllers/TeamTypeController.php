<?php

namespace Modules\Team\Http\Controllers;

use App\Http\Controllers\Rest\BaseController;
use Modules\Team\Repositories\Interfaces\TeamTypeRepositoryInterface;

class TeamTypeController extends BaseController
{
    /**
     * @var $teamTypeRepository
     */
    protected $teamTypeRepository;


    public function __construct(TeamTypeRepositoryInterface $teamTypeRepository)
    {
        $this->teamTypeRepository = $teamTypeRepository;
    }

    /**
     * Display a listing of team type.
     * @return Response
     */
    public function index()
    {
        $teamsType = $this->teamTypeRepository->findAllTranslated();

        return $this->sendResponse($teamsType, 'List Teams Type');
    }
}
