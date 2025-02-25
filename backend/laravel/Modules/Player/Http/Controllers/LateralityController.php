<?php

namespace Modules\Player\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Rest\BaseController;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;

class LateralityController extends BaseController
{
    /**
     * @var $playerRepository
     */
    protected $playerRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * Display a listing of laterities.
     * @return Response
     */
    public function index()
    {
        return $this->sendResponse($this->playerRepository->getLateritiesTypes(), 'List Laterities');
    }
}
