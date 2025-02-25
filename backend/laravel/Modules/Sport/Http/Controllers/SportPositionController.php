<?php

namespace Modules\Sport\Http\Controllers;

use App\Http\Controllers\Rest\BaseController;

use Modules\Sport\Repositories\Interfaces\SportPositionRepositoryInterface;
use Modules\Sport\Repositories\Interfaces\SportPositionSpecRepositoryInterface;

class SportPositionController extends BaseController
{
    /**
     * @var object
     */
    protected $sportPositionRepository;
    
    /**
     * @var object
     */
    protected $sportPositionSpecRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(SportPositionRepositoryInterface $sportPositionRepository, SportPositionSpecRepositoryInterface $sportPositionSpecRepository)
    {
        $this->sportPositionRepository = $sportPositionRepository;
        $this->sportPositionSpecRepository = $sportPositionSpecRepository;
    } 

    /**
     * Display a listing of the sports positions depending on the
     * identificator sent.
     * 
     * @param Int $sportId
     * @return Response
     */
    public function index($sportId)
    {
        $positions = $this->sportPositionRepository->findAllTranslated($sportId);

        return $this->sendResponse($positions, 'List Sports Positions');
    }

    /**
     * Sends specific information about position sent
     * 
     * @param Int $positionId
     * @return Response
     */
    public function positionSpecs ($positionId)
    {
        $positionsSpecs = $this->sportPositionSpecRepository->findAllTranslated($positionId);

        return $this->sendResponse($positionsSpecs, 'List Sports Position Specifications');
    }
}
